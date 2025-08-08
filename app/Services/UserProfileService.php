<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileService
{
    public function updateSuperAdminProfile(User $user, array $attributes, ?UploadedFile $profilePhoto, ?string $newPassword): void
    {
        $updateData = [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
        ];

        if ($profilePhoto) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $profilePhoto->store('profile-photos', 'public');
            $updateData['profile_photo'] = $path;
        }

        if ($newPassword) {
            $updateData['password'] = Hash::make($newPassword);
        }

        $user->update($updateData);
    }
}


