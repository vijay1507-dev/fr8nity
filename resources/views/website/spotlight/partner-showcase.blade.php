@extends('layouts.website')

@section('title', 'Partner Showcase - Spotlight - Fr8nity')

@section('content')
<section class="benefits_sec">
    <div class="container py-5 pt-5 px-2">
        <div class="text-center">
            <h2 class="text-center fw-bold fs-2">Partner Showcase </h2>
            <div class="underline mb-4 mx-auto">
                <span class="move delay-0" ></span>
                <span class="move delay-1" ></span>
            </div>
        </div>
        <div id="partner-showcase-items">
            @include('website.spotlight.partials.partner-showcase-items', ['partnerShowcaseItems' => $partnerShowcaseItems])
        </div>
        @if($partnerShowcaseItems->hasMorePages())
        <div class="row justify-content-center align-items-center mx-0 py-5">
            <button type="button" class="btn btnbg fw-semibold" id="load-more-btn" onclick="loadMoreItems()">
                <span class="btn-text">Load More Partner Showcases</span>
                <span class="spinner-border spinner-border-sm d-none" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
            </button>
        </div>
        @endif
        
        @if($partnerShowcaseItems->count() == 0)
        <div class="row mx-auto align-items-stretch pt-3">
            <div class="col-12 text-center">
                <div class="" role="alert">
                    <h5 class="mb-3">No Partner Showcase Items Available</h5>
                    <p class="mb-0">There are currently no partner showcase items to display. Please check back later.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
let currentPage = {{ $partnerShowcaseItems->currentPage() }};
let hasMorePages = {{ $partnerShowcaseItems->hasMorePages() ? 'true' : 'false' }};
let isLoading = false;

function loadMoreItems() {
    if (isLoading || !hasMorePages) return;
    
    isLoading = true;
    const btn = document.getElementById('load-more-btn');
    const btnText = btn.querySelector('.btn-text');
    const spinner = btn.querySelector('.spinner-border');
    
    // Show loading state
    btnText.textContent = 'Loading...';
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    fetch(`{{ route('spotlight.partner-showcase') }}?page=${currentPage + 1}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.html) {
            document.getElementById('partner-showcase-items').insertAdjacentHTML('beforeend', data.html);
            currentPage = data.nextPage - 1;
            hasMorePages = data.hasMore;
            
            if (!hasMorePages) {
                btn.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error loading more items:', error);
        alert('Error loading more items. Please try again.');
    })
    .finally(() => {
        isLoading = false;
        btnText.textContent = 'Load More Partner Showcases';
        spinner.classList.add('d-none');
        btn.disabled = false;
    });
}
</script>
@endpush

@endsection
