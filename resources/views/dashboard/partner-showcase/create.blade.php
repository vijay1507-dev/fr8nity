@extends('layouts.dashboard')

@section('title', 'Add Partner Showcase Item')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Add Partner Showcase Item</h4>
            <a href="{{ route('admin.partner-showcase.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.partner-showcase.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="feature_image" class="form-label">Feature Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('feature_image') is-invalid @enderror" 
                                   id="feature_image" name="feature_image" accept="image/*" required>
                            <div class="form-text">Maximum file size: 10MB. Accepted formats: JPEG, PNG, JPG, GIF</div>
                            @error('feature_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Gallery Images (Optional)</label>
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple>
                            <div class="form-text">You can select multiple images. Maximum file size per image: 10MB</div>
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', 0) }}" min="0">
                            <div class="form-text">Items with lower order numbers appear first</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                                       {{ old('status') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Partner Showcase Item
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