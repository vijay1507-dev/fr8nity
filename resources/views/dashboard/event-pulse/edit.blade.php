@extends('layouts.dashboard')

@section('title', 'Edit Event Pulse Item')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Event Pulse Item</h4>
            <a href="{{ route('admin.event-pulse.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.event-pulse.update', $eventPulse->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $eventPulse->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $eventPulse->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="feature_image" class="form-label">Feature Image</label>
                            @if($eventPulse->feature_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $eventPulse->feature_image) }}" 
                                         alt="Current Feature Image" class="img-thumbnail" style="max-height: 100px;">
                                    <small class="d-block text-muted">Current feature image</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('feature_image') is-invalid @enderror" 
                                   id="feature_image" name="feature_image" accept="image/*">
                            <div class="form-text">Leave empty to keep current image. Maximum file size: 10MB</div>
                            @error('feature_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Gallery Images</label>
                            @if($eventPulse->gallery && count($eventPulse->gallery) > 0)
                                <div class="mb-2">
                                    <small class="d-block text-muted mb-2">Current gallery images:</small>
                                    <div class="row">
                                        @foreach($eventPulse->gallery as $galleryImage)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset('storage/' . $galleryImage) }}" 
                                                     alt="Gallery Image" class="img-thumbnail" style="height: 80px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple>
                            <div class="form-text">Leave empty to keep current gallery. Selecting new images will replace all current gallery images</div>
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $eventPulse->order) }}" min="0">
                            <div class="form-text">Items with lower order numbers appear first</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                       {{ old('status', $eventPulse->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Created By</label>
                            <p class="form-control-plaintext">{{ $eventPulse->creator ? $eventPulse->creator->name : 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <p class="form-control-plaintext">{{ $eventPulse->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Event Pulse Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview feature image
    document.getElementById('feature_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // You can add image preview functionality here if needed
        }
    });

    // Preview gallery images
    document.getElementById('gallery').addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            // You can add gallery preview functionality here if needed
        }
    });
</script>
@endsection