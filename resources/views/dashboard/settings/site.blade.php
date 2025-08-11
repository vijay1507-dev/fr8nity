@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.site.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Site Settings</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="site_phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control @error('site_phone') is-invalid @enderror" id="site_phone" name="site_phone" value="{{ old('site_phone', $site['site_phone']) }}">
                                <div id="site_phone_error" class="text-danger mt-1" style="display:none"></div>
                                @error('site_phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="site_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('site_email') is-invalid @enderror" id="site_email" name="site_email" value="{{ old('site_email', $site['site_email']) }}">
                                @error('site_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="social_facebook" class="form-label">Facebook URL</label>
                                <input type="url" class="form-control @error('social_facebook') is-invalid @enderror" id="social_facebook" name="social_facebook" value="{{ old('social_facebook', $site['social_facebook']) }}">
                                @error('social_facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="social_instagram" class="form-label">Instagram URL</label>
                                <input type="url" class="form-control @error('social_instagram') is-invalid @enderror" id="social_instagram" name="social_instagram" value="{{ old('social_instagram', $site['social_instagram']) }}">
                                @error('social_instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="social_linkedin" class="form-label">LinkedIn URL</label>
                                <input type="url" class="form-control @error('social_linkedin') is-invalid @enderror" id="social_linkedin" name="social_linkedin" value="{{ old('social_linkedin', $site['social_linkedin'] ?? '') }}">
                                @error('social_linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="social_twitter" class="form-label">Twitter/X URL</label>
                                <input type="url" class="form-control @error('social_twitter') is-invalid @enderror" id="social_twitter" name="social_twitter" value="{{ old('social_twitter', $site['social_twitter']) }}">
                                @error('social_twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="social_youtube" class="form-label">YouTube URL</label>
                                <input type="url" class="form-control @error('social_youtube') is-invalid @enderror" id="social_youtube" name="social_youtube" value="{{ old('social_youtube', $site['social_youtube']) }}">
                                @error('social_youtube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.querySelector('#site_phone');
    if (!input || !window.intlTelInput) return;

    var iti = window.intlTelInput(input, {
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js',
        separateDialCode: true,
        nationalMode: false,
        initialCountry: '{{ empty($site['site_phone']) ? 'sg' : '' }}'
    });

    @if(!empty($site['site_phone']))
        iti.setNumber(@json($site['site_phone']));
    @endif

    var form = input.closest('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            var fullNumber = iti.getNumber();
            // Basic client-side validation: ensure valid number if provided
            if (input.value.trim() !== '' && !iti.isValidNumber()) {
                e.preventDefault();
                $('#site_phone_error').text('Please enter a valid phone number.').show();
                return false;
            }
            $('#site_phone_error').hide();
            input.value = fullNumber;
            return true;
        });
    }
});
</script>
@endsection


