<h1>Membership Expiry Reminder</h1>

<p>Dear {{ $user->name }},</p>

<p>Your {{ $user->membershipTier ? $user->membershipTier->name : '' }} membership with Fr8nity will expire on {{ $user->membership_expires_at->format('d M Y') }}.</p>

@if($daysUntilExpiry > 0)
<p>This is a reminder that your membership will expire in {{ $daysUntilExpiry }} day(s). To continue enjoying your membership benefits, please renew your membership before the expiry date.</p>
@else
<p>Your membership has expired. To regain access to your membership benefits, please renew your membership as soon as possible.</p>
@endif

<p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

<p>
    Thanks,<br>
    {{ config('app.name') }}
</p>