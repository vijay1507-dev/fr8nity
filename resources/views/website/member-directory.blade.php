@extends('layouts.website')
@section('title', 'Member Directory - Fr8nity')
@section('content')
  <section>
    <div class="container blackbg">
    <div class="row">
      <!-- Left Column -->
      <div class="col-md-10 mx-auto mb-4 d-flex justify-content-center flex-column text-center mt-5 pt-4">
      <div>
        <h1 class="fw-bold size text_image">
        Member Directory
        </h1>
        <div class="input-group-text w-100 member_filter mt-3">
        <div class="input-group-text p-0 w-100">

          <input type="text" class="form-control border-0" placeholder="Company name" aria-label="Company name" id="company_name" value="{{ request('company_name') }}">
        </div>
        <div class="input-group-text p-0 w-100">
          <span class="icons d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
          </svg></span>
          <input type="text" class="form-control border-0" placeholder="Country" aria-label="Country" id="country" value="{{ request('country') }}">
        </div>
        <div class="input-group-text p-0 w-100">
          <span class="icons d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
          </svg></span>
          <input type="text" class="form-control border-0" placeholder="City" aria-label="City" id="city" value="{{ request('city') }}">
        </div>
        <div class="input-group-text p-0 border-0 w-100">

          <input type="text" class="form-control border-0" placeholder="Specialization" aria-label="" id="specialization" value="{{ request('specialization') }}">
        </div>
        <button class="btn btn-outline-secondary search_btn" type="button" id="filterBtn">Filter</button>
        @if(request('company_name') || request('country') || request('city') || request('specialization'))
          <a href="{{ route('members.directory') }}" class="btn  ms-2">Clear Filters</a>
        @endif
        </div>
        <p class="text-white mt-3">Can't find right member? <a href="{{route('contact-us')}}"
          class="text-primary">Click here</a></p>
      </div>
      </div>

    </div>
    </div>
  </section>

  <div class="filter_list pb-5">
    <div class="container">
    
      <div id="memberCards">
        @include('website.sections.member-cards', ['members' => $members])
      </div>
      @if($members->isEmpty())
        <div class="text-center py-5">
          <h4 class="text-white">
            @if(request('company_name') || request('country') || request('city') || request('specialization'))
              No members found
            @else
              No members found
            @endif
          </h4>
          <p class="text-muted">
            @if(request('company_name') || request('country') || request('city') || request('specialization'))
              <a href="{{ route('members.directory') }}" class="text-primary">clear all filters</a>.
            @endif
          </p>
        </div>
      @endif
      @if($members instanceof \Illuminate\Contracts\Pagination\Paginator && $members->hasMorePages())
        <div class="text-center my-4">
          <button id="loadMoreBtn" class="btn btnbg fe-semibold">Load More</button>
        </div>
      @endif
      @if(method_exists($members, 'total') && $members->total() > 10)
        <button id="goTopBtn" 
                class="btn btn-primary position-fixed" 
                style="right: 20px; bottom: 20px; display: none; z-index: 1050; border-radius: 50%; width: 48px; height: 48px; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
          <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V4.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4-.007-.007a.498.498 0 0 0-.697.014l-4 4a.5.5 0 1 0 .708.708L7.5 4.707V11.5A.5.5 0 0 0 8 12"/>
          </svg>
        </button>
      @endif
    </div>
  </div>


@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtn = document.getElementById('filterBtn');
    const companyNameInput = document.getElementById('company_name');
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');
    const specializationInput = document.getElementById('specialization');
    const filterList = document.querySelector('.filter_list');
    const memberCards = document.getElementById('memberCards');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const goTopBtn = document.getElementById('goTopBtn');
    let nextPageUrl = @json($members->nextPageUrl());
    let isLoading = false;
    
    // Handle filter button click
    filterBtn.addEventListener('click', function() {
        const originalText = filterBtn.innerHTML;
        filterBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Filtering...';
        filterBtn.disabled = true;
        
        // Add loading overlay to results
        if (filterList) {
            filterList.style.opacity = '0.6';
            filterList.style.pointerEvents = 'none';
        }
        
        // Build query parameters
        const params = new URLSearchParams();
        if (companyNameInput.value.trim()) {
            params.append('company_name', companyNameInput.value.trim());
        }
        if (countryInput.value.trim()) {
            params.append('country', countryInput.value.trim());
        }
        if (cityInput.value.trim()) {
            params.append('city', cityInput.value.trim());
        }
        if (specializationInput.value.trim()) {
            params.append('specialization', specializationInput.value.trim());
        }
        
        // Navigate to filtered results
        const url = '{{ route("members.directory") }}' + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    });
    
    // Handle Enter key on any input to trigger filter
    const inputs = [companyNameInput, countryInput, cityInput, specializationInput];
    inputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterBtn.click();
            }
        });
    });
    
    // Focus on first input when page loads
    if (companyNameInput && !companyNameInput.value) {
        companyNameInput.focus();
    }

    // Load more handler (button click)
    const loadMore = async () => {
        if (!nextPageUrl || isLoading) return;
        isLoading = true;
        if (loadMoreBtn) {
            loadMoreBtn.disabled = true;
            const original = loadMoreBtn.innerHTML;
            loadMoreBtn.setAttribute('data-original', original);
            loadMoreBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        }
        try {
            const response = await fetch(nextPageUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (data && data.html) {
                const temp = document.createElement('div');
                temp.innerHTML = data.html;
                while (temp.firstChild) {
                    memberCards.appendChild(temp.firstChild);
                }
                nextPageUrl = data.next_page_url;
                if (!nextPageUrl && loadMoreBtn) {
                    loadMoreBtn.parentElement.removeChild(loadMoreBtn);
                }
            } else {
                nextPageUrl = null;
                if (loadMoreBtn) {
                    loadMoreBtn.parentElement.removeChild(loadMoreBtn);
                }
            }
        } catch (e) {
            nextPageUrl = null;
        } finally {
            isLoading = false;
            if (loadMoreBtn && nextPageUrl) {
                loadMoreBtn.innerHTML = loadMoreBtn.getAttribute('data-original') || 'Load More';
                loadMoreBtn.disabled = false;
            }
        }
    };

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMore);
    }

    if (goTopBtn) {
        goTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        const toggleGoTop = () => {
            const shouldShow = window.scrollY > 300;
            goTopBtn.style.display = shouldShow ? 'inline-flex' : 'none';
        };
        window.addEventListener('scroll', toggleGoTop);
        toggleGoTop();
    }
});
</script>
@endpush