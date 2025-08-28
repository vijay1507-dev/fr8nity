@extends('layouts.website')

@section('title', 'Partner Showcase - Spotlight - Fr8nity')

@section('content')

<div class="event-detail-container">
    <div class="left-section">
        <div class="image-container">
            @if($partnerShowcase->feature_image)
                <img src="{{ asset('storage/' . $partnerShowcase->feature_image) }}" alt="{{ $partnerShowcase->title }}" class="main-image" id="mainImage">
            @else
                <img src="{{ asset('images/our_story.jpg') }}" alt="{{ $partnerShowcase->title }}" class="main-image" id="mainImage">
            @endif
            
            @if($partnerShowcase->gallery_images && count($partnerShowcase->gallery_images) > 0)
                <button class="navigation-arrows nav-left" onclick="previousImage()">
                    &lt;
                </button>
                <button class="navigation-arrows nav-right" onclick="nextImage()">
                    &gt;
                </button>
            @endif
        </div>
        
        @if($partnerShowcase->gallery_images && count($partnerShowcase->gallery_images) > 0)
            <div class="gallery-thumbnails">
                @if($partnerShowcase->feature_image)
                    <img src="{{ asset('storage/' . $partnerShowcase->feature_image) }}" 
                         alt="{{ $partnerShowcase->title }}" 
                         class="gallery-thumb active" 
                         onclick="changeImage(this, '{{ asset('storage/' . $partnerShowcase->feature_image) }}')">
                @endif
                @foreach($partnerShowcase->gallery_images as $index => $image)
                    <img src="{{ asset('storage/' . $image) }}" 
                         alt="Gallery {{ $index + 1 }}" 
                         class="gallery-thumb" 
                         onclick="changeImage(this, '{{ asset('storage/' . $image) }}')">
                @endforeach
            </div>
        @endif
    </div>

    <div class="right-section">
        <h1 class="event-title">{{ $partnerShowcase->title }}</h1>
        <p class="event-description">
            {{ $partnerShowcase->description }}
        </p>
    </div>
</div>

<script>
let currentImageIndex = 0;
const images = [
    @if($partnerShowcase->feature_image)
        '{{ asset('storage/' . $partnerShowcase->feature_image) }}',
    @endif
    @if($partnerShowcase->gallery_images)
        @foreach($partnerShowcase->gallery_images as $image)
            '{{ asset('storage/' . $image) }}',
        @endforeach
    @endif
];

function changeImage(thumbnail, imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
    
    // Remove active class from all thumbnails
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.classList.remove('active');
    });
    
    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
    
    // Update current index
    currentImageIndex = images.indexOf(imageSrc);
}

function previousImage() {
    if (images.length > 1) {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updateMainImage();
    }
}

function nextImage() {
    if (images.length > 1) {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updateMainImage();
    }
}

function updateMainImage() {
    if (images.length > 0) {
        document.getElementById('mainImage').src = images[currentImageIndex];
        
        // Update thumbnail active state
        document.querySelectorAll('.gallery-thumb').forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentImageIndex);
        });
    }
}
</script>
@endsection
