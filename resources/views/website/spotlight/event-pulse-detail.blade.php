@extends('layouts.website')

@section('title', 'Event Pulse - Spotlight - Fr8nity')

@section('content')


<div class="container gradient_rounded radies_20 my-5">
<div class="blacklight radies_20">


<div class="event-detail-container  ">
     <div class="row  p-4">
    <div class="left-section col-6">
       
        <div class="image-container">
            @if($eventPulse->feature_image)
                <img src="{{ asset('storage/' . $eventPulse->feature_image) }}" alt="{{ $eventPulse->title }}" class="main-image" id="mainImage">
            @else
                <img src="{{ asset('images/our_story.jpg') }}" alt="{{ $eventPulse->title }}" class="main-image" id="mainImage">
            @endif
            
            @if($eventPulse->gallery_images && count($eventPulse->gallery_images) > 0)
                <button class="navigation-arrows nav-left" onclick="previousImage()">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
                </button>
                <button class="navigation-arrows nav-right" onclick="nextImage()">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
        
        @if($eventPulse->gallery_images && count($eventPulse->gallery_images) > 0)
            <div class="gallery-thumbnails">
                @if($eventPulse->feature_image)
                    <img src="{{ asset('storage/' . $eventPulse->feature_image) }}" 
                         alt="{{ $eventPulse->title }}" 
                         class="gallery-thumb active" 
                         onclick="changeImage(this, '{{ asset('storage/' . $eventPulse->feature_image) }}')">
                @endif
                @foreach($eventPulse->gallery_images as $index => $image)
                    <img src="{{ asset('storage/' . $image) }}" 
                         alt="Gallery {{ $index + 1 }}" 
                         class="gallery-thumb" 
                         onclick="changeImage(this, '{{ asset('storage/' . $image) }}')">
                @endforeach
            </div>
        @endif
    </div>

    <div class="right-section col-6">
        <h1 class="event-title">{{ $eventPulse->title }}</h1>
        <p class="event-description">
            {{ $eventPulse->description }}
        </p>
    </div>
    </div>
</div>
</div></div>

<script>
let currentImageIndex = 0;
const images = [
    @if($eventPulse->feature_image)
        '{{ asset('storage/' . $eventPulse->feature_image) }}',
    @endif
    @if($eventPulse->gallery_images)
        @foreach($eventPulse->gallery_images as $image)
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
