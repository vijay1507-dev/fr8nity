@extends('layouts.website')

@section('title', 'Event Pulse Detail - Spotlight - Fr8nity')

@section('content')

<div class="event-detail-container">
     
    <div class="left-section">
       
        <div class="image-container">
            <img src="{{ asset('images/our_story.jpg') }}" alt="Museum Tour" class="main-image" id="mainImage">
            
            <button class="navigation-arrows nav-left" onclick="previousImage()">
                &lt;
            </button>
            <button class="navigation-arrows nav-right" onclick="nextImage()">
                &gt;
            </button>
        </div>
        
        <div class="gallery-thumbnails">
            <img src="{{ asset('images/our_story.jpg') }}" alt="Gallery 1" class="gallery-thumb active" onclick="changeImage(this, '{{ asset('images/our_story.jpg') }}')">
            <img src="{{ asset('images/Mask group (3).png') }}" alt="Gallery 2" class="gallery-thumb" onclick="changeImage(this, '{{ asset('images/Mask group (3).png') }}')">
            <img src="{{ asset('images/Mask group (4).png') }}" alt="Gallery 3" class="gallery-thumb" onclick="changeImage(this, '{{ asset('images/Mask group (4).png') }}')">
            <img src="{{ asset('images/Mask group (5).png') }}" alt="Gallery 4" class="gallery-thumb" onclick="changeImage(this, '{{ asset('images/Mask group (5).png') }}')">
            <img src="{{ asset('images/Mask group (6).png') }}" alt="Gallery 5" class="gallery-thumb" onclick="changeImage(this, '{{ asset('images/Mask group (6).png') }}')">
        </div>
    </div>

    <div class="right-section">
        <h1 class="event-title">Global Trade Summit Adventure</h1>
        <p class="event-description">
            Experience the thrill of international trade with breathtaking networking opportunities and challenging 
            business scenarios. Perfect for entrepreneurs and business leaders seeking growth and expansion.
        </p>
    </div>
</div>

<script>
let currentImageIndex = 0;
const images = [
    '{{ asset('images/our_story.jpg') }}',
    '{{ asset('images/Mask group (3).png') }}',
    '{{ asset('images/Mask group (4).png') }}',
    '{{ asset('images/Mask group (5).png') }}',
    '{{ asset('images/Mask group (6).png') }}'
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
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateMainImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateMainImage();
}

function updateMainImage() {
    document.getElementById('mainImage').src = images[currentImageIndex];
    
    // Update thumbnail active state
    document.querySelectorAll('.gallery-thumb').forEach((thumb, index) => {
        thumb.classList.toggle('active', index === currentImageIndex);
    });
}

// Date picker functionality
document.getElementById('eventDate').addEventListener('click', function() {
    // You can integrate a date picker library here
    this.type = 'date';
    this.min = '2025-01-01';
    this.max = '2025-12-31';
});
</script>

@endsection
