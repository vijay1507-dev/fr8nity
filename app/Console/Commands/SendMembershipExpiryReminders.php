<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Mail\MembershipExpiryReminder;
use Carbon\Carbon;

class SendMembershipExpiryReminders extends Command
{
    protected $signature = 'membership:send-expiry-reminders {--force : Force re-send even if previously sent}';
    protected $description = 'Send reminder emails to members whose membership is about to expire';

    public function handle()
    {
        $today = Carbon::today();
        $now = utcNow();
        $reminderDays = Setting::get('membership_reminder_days', 15);
        $notificationsEnabled = Schema::hasTable('notifications');

        // Get users whose memberships are expiring soon
        $usersExpiring = User::whereBetween('membership_expires_at', [$today, $today->copy()->addDays($reminderDays)])
            ->where('is_active', true)
            ->when($notificationsEnabled, function ($query) use ($now) {
                $query->whereDoesntHave('notifications', function ($q) use ($now) {
                    $q->where('type', 'membership_expiry_reminder')
                        ->where('created_at', '>=', $now->subDay());
                });
            })
            ->with('membershipTier')
            ->get();

        $sentReminders = $this->processUsers($usersExpiring, $today, $notificationsEnabled, false);

        // Get users whose memberships have expired
        $expiredUsers = User::where('membership_expires_at', '<', $today)
            ->where('is_active', true)
            ->when($notificationsEnabled, function ($query) use ($now) {
                $query->whereDoesntHave('notifications', function ($q) use ($now) {
                    $q->where('type', 'membership_expiry_reminder')
                        ->where('created_at', '>=', $now->subDay());
                });
            })
            ->with('membershipTier')
            ->get();

        $expiredCount = $this->processUsers($expiredUsers, $today, $notificationsEnabled, true);

        // Final logging
        $this->info("Membership expiry reminders sent: {$sentReminders}, deactivated expired accounts: {$expiredCount}");
        Log::info("Membership expiry job completed. Reminders: {$sentReminders}, Deactivated: {$expiredCount}");
    }

    protected function processUsers($users, $today, $notificationsEnabled, $isExpired = false): int
    {
        $count = 0;

        if ($users->isEmpty()) return $count;

        foreach ($users as $user) {
            $daysUntilExpiry = $isExpired ? 0 : $today->diffInDays($user->membership_expires_at);

            try {
                Mail::to($user->email)->send(new MembershipExpiryReminder($user, $daysUntilExpiry));

                if ($notificationsEnabled) {
                    $this->createReminderNotification($user, $daysUntilExpiry, $isExpired);
                }

                if ($isExpired) {
                    $user->update(['is_active' => false]);
                    Log::info("Deactivated expired user: {$user->email}");
                } else {
                    Log::info("Sent expiry reminder to: {$user->email}, expires in {$daysUntilExpiry} days");
                }

                $count++;
            } catch (\Exception $e) {
                Log::error("Failed to send to {$user->email}: " . $e->getMessage());
            }
        }

        return $count;
    }

    protected function createReminderNotification(User $user, int $daysUntilExpiry, bool $isExpired = false): void
    {
        $user->notifications()->create([
            'id' => Str::uuid(),
            'type' => 'membership_expiry_reminder',
            'data' => json_encode([
                'days_until_expiry' => $daysUntilExpiry,
                'membership_expires_at' => $user->membership_expires_at,
                'sent_at' => utcNow()->toISOString(),
                'status' => $isExpired ? 'expired' : 'active',
            ]),
            'created_at' => utcNow(),
            'updated_at' => utcNow(),
        ]);
    }
}
