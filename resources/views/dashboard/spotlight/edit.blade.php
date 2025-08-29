@extends('layouts.dashboard')

@section('title', 'Edit Spotlight Item')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Spotlight Item</h4>
            <a href="{{ route('spotlight.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('spotlight.update', $spotlight->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $spotlight->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $spotlight->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="feature_image" class="form-label">Feature Image</label>
                            @if($spotlight->feature_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $spotlight->feature_image) }}" 
                                         alt="Current Feature Image" class="img-thumbnail" style="max-height: 100px;">
                                    <small class="d-block text-muted">Current feature image</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('feature_image') is-invalid @enderror" 
                                   id="feature_image" name="feature_image" accept="image/*">
                            <div class="form-text">Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                            @error('feature_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Gallery Images</label>
                            @if($spotlight->gallery && count($spotlight->gallery) > 0)
                                <div class="mb-2">
                                    <div class="row">
                                        @foreach($spotlight->gallery as $image)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="Gallery Image" class="img-thumbnail" style="max-height: 80px;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="d-block text-muted">Current gallery images</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple>
                            <div class="form-text">Leave empty to keep current gallery. Selecting new images will replace all current gallery images. Supported formats: JPEG, PNG, JPG, GIF. Max size per file: 2MB</div>
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $spotlight->type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $spotlight->order) }}" min="0">
                            <div class="form-text">Items with lower order numbers appear first</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                       {{ old('status', $spotlight->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Created By</label>
                            <p class="form-control-plaintext">{{ $spotlight->creator ? $spotlight->creator->name : 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <p class="form-control-plaintext">{{ $spotlight->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Spotlight Item
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
