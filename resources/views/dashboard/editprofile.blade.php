@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
  <div class="container py-4">
      <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        <!-- Personal Information -->
        <div class="p-4 rounded card">
          <h3 class="mb-4">Edit Profile</h3>
          <div class="row">
            <!-- Profile Photo -->
            <div class="col-12 mb-4">
              <div class="d-flex align-items-center">
                <div class="me-4">
                  @if($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                  @else
                    <img src="{{ asset('images/men-avtar.png') }}" alt="Default Profile" class="rounded-circle" width="100" height="100" id="profilePhotoPreview">
                  @endif
                </div>
                <div>
                  <label class="form-label" for="profile_photo">Profile Photo</label>
                  <input type="file" id="profile_photo" name="profile_photo" class="form-control" accept="image/*">
                  <div class="form-text">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</div>
                  @error('profile_photo')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label" for="name">Name*</label>
              <input type="text" id="name" name="name" class="form-control mb-3 rounded-30" value="{{ $user->name }}" required>
              @error('name')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label" for="email">Email*</label>
              <input type="email" id="email" name="email" class="form-control mb-3 rounded-30" value="{{ $user->email }}" required>
              @error('email')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12">
              <hr class="my-4">
              <h4 class="mb-3">Change Password</h4>
              <p class="text-muted small mb-4">Leave password fields empty if you don't want to change your password.</p>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label" for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password" class="form-control mb-3 rounded-30">
              <div class="form-text">Required to change password</div>
              @error('current_password')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label" for="new_password">New Password</label>
              <input type="password" id="new_password" name="new_password" class="form-control mb-3 rounded-30" minlength="8">
              <div class="form-text">Minimum 8 characters</div>
              @error('new_password')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
              <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control mb-3 rounded-30">
              @error('new_password_confirmation')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-center align-items-center mt-4">
              <button type="submit" class="btn btnbg">Update Profile <i class="fas fa-check ms-2"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editProfileForm');
    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('new_password');
    const newPasswordConfirmation = document.getElementById('new_password_confirmation');
    const profilePhotoInput = document.getElementById('profile_photo');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');

    // Preview profile photo before upload
    profilePhotoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePhotoPreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Add validation for password confirmation match
    form.addEventListener('submit', function(e) {
        // Check if trying to change password
        if (newPassword.value || newPasswordConfirmation.value) {
            if (!currentPassword.value) {
                e.preventDefault();
                alert('Current password is required to change password');
                currentPassword.focus();
                return;
            }
            if (newPassword.value !== newPasswordConfirmation.value) {
                e.preventDefault();
                alert('New passwords do not match');
                newPassword.focus();
                return;
            }
        }
    });

    // Add validation for password confirmation match
    newPasswordConfirmation.addEventListener('input', function() {
        if (newPassword.value !== this.value) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });

    newPassword.addEventListener('input', function() {
        if (newPasswordConfirmation.value && newPasswordConfirmation.value !== this.value) {
            newPasswordConfirmation.setCustomValidity('Passwords do not match');
        } else {
            newPasswordConfirmation.setCustomValidity('');
        }
    });
});
</script>
@endpush 
