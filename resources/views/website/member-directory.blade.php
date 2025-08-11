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
      @forelse($members as $member)
        @php
          $membershipTierName = $member->membershipTier ? $member->membershipTier->name : 'Explorer';
          $membershipTierClass = strtolower($membershipTierName) . '_bg';
          
          // Parse specializations from JSON
          $specializations = [];
          if ($member->specializations) {
            $specializations = json_decode($member->specializations, true) ?? [];
          }
          
          // Fallback for company logo
          $companyLogo = $member->company_logo 
            ? asset('storage/' . $member->company_logo) 
            : asset('images/default_company.png');
            
          // Location string
          $location = [];
          if ($member->city && $member->city->name) {
            $location[] = $member->city->name;
          }
          if ($member->country && $member->country->name) {
            $location[] = $member->country->name;
          }
          $locationString = implode(' - ', $location);
        @endphp
        
        <div class="gradient_rounded radies_20 mb-3">
          <div class="bg-dark p-3 px-4 radies_20">
            <div class="d-flex align-items-center mb-2">
              <img src="{{ $companyLogo }}" 
                   alt="{{ $member->company_name ?? $member->name }} Logo" 
                   class="me-2 company_logo">
              <div>
                <h5 class="mb-0 text-white">{{ $member->company_name ?? $member->name }}</h5>
                <span class="text-white d-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                  </svg> 
                  {{ $locationString ?: 'Location not specified' }}
                </span>
              </div>
            </div>
            <div class="d-flex align-items-center mb-2">
              <span class="badge badge-custom {{ $membershipTierClass }} me-2">{{ $membershipTierName }}</span>
                             <a href="{{ route('members.directory-view-profile', ['company_name' => Str::slug($member->company_name ?? $member->name), 'encrypted_id' => encrypt($member->id)]) }}" 
                  class="btn ms-auto btn btnbg fe-semibold">Get Contacts</a>
            </div>
            <div class="d-flex align-items-center flex-wrap mb-2">
              @if(count($specializations) > 0)
                @foreach(array_slice($specializations, 0, 5) as $specialization)
                  <span class="btn service-btn">{{ $specialization }}</span>
                @endforeach
                @if(count($specializations) > 5)
                  <span class="btn service-btn">+{{ count($specializations) - 5 }}</span>
                @endif
              @else
                <span class="btn service-btn text-muted">No specializations listed</span>
              @endif
            </div>
          </div>
        </div>
      @empty
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
      @endforelse
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
});
</script>
@endpush