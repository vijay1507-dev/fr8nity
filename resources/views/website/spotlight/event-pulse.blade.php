@extends('layouts.website')

@section('title', 'Event Pulse - Spotlight - Fr8nity')

@section('content')


    <!-- <div class="container blackbg">
            <div class="row">

                <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
                    <div>
                        <h1 class="fw-bold size text_image">
                            Event Pulse
                        </h1>
                        <p class="fs-4 fs-sm-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi, doloremque.</p>
                        <a href="{{ route('register') }}" class="btn btnbg fe-semibold mt-3">
                            <span>Become a Member</span>
                        </a>
                    </div>
                </div>


                <div class="col-12 col-md-6 mb-md-3 r">
                    <video src="{{asset('images/bannervideo.mp4')}}" autoplay muted loop playsinline class="w-100"></video>
                </div>
            </div>
        </div> -->



    <div class="container ">
        <div class=" mt-5" bis_skin_checked="1">
            <h2 class=" fw-bold fs-2 text-center">Event Pulse</h2>
            <div class="underline mb-4 mx-auto " bis_skin_checked="1">
                <span class="move delay-0"></span>
                <span class="move delay-1"></span>
            </div>
        </div>


        <div id="event-pulse-items">
            @include('website.spotlight.partials.event-pulse-items', ['eventPulseItems' => $eventPulseItems])
        </div>

        @if($eventPulseItems->hasMorePages())
        <div class="row justify-content-center align-items-center mx-0 py-5">
            <button type="button" class="btn btnbg fw-semibold" id="load-more-events-btn" onclick="loadMoreEvents()">
                <span class="btn-text">See More Events</span>
                <span class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </button>
        </div>
        @endif
        
        @if($eventPulseItems->count() == 0)
        <div class="row mx-auto mb-5">
            <div class="col-12 text-center">
                <div class="" role="alert">
                    <h5 class="mb-3">No Event Pulse Items Available</h5>
                    <p class="mb-0">There are currently no event pulse items to display. Please check back later.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

@push('scripts')
<script>
let currentEventPage = {{ $eventPulseItems->currentPage() }};
let hasMoreEventPages = {{ $eventPulseItems->hasMorePages() ? 'true' : 'false' }};
let isEventLoading = false;

function loadMoreEvents() {
    if (isEventLoading || !hasMoreEventPages) return;
    
    isEventLoading = true;
    const btn = document.getElementById('load-more-events-btn');
    const btnText = btn.querySelector('.btn-text');
    const spinner = btn.querySelector('.spinner-border');
    
    // Show loading state
    btnText.textContent = 'Loading...';
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    fetch(`{{ route('spotlight.event-pulse') }}?page=${currentEventPage + 1}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.html) {
            document.getElementById('event-pulse-items').insertAdjacentHTML('beforeend', data.html);
            currentEventPage = data.nextPage - 1;
            hasMoreEventPages = data.hasMore;
            
            if (!hasMoreEventPages) {
                btn.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error loading more events:', error);
        alert('Error loading more events. Please try again.');
    })
    .finally(() => {
        isEventLoading = false;
        btnText.textContent = 'See More Events';
        spinner.classList.add('d-none');
        btn.disabled = false;
    });
}
</script>
@endpush

@endsection