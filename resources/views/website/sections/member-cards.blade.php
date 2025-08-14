@foreach($members as $member)
  @php
    $membershipTierName = $member->membershipTier ? $member->membershipTier->name : 'Explorer';
    $membershipTierClass = strtolower($membershipTierName) . '_bg';
    $specializations = [];
    if (!empty($member->specializations)) {
      $specializations = is_array($member->specializations)
        ? $member->specializations
        : (json_decode((string) $member->specializations, true) ?: []);
    }
    $companyLogo = $member->company_logo 
      ? asset('storage/' . $member->company_logo) 
      : asset('images/default_company.png');
    $location = [];
    if ($member->city && $member->city->name) {
      $location[] = $member->city->name;
    }
    if ($member->country && $member->country->name) {
      $location[] = $member->country->name;
    }
    $locationString = implode(' - ', $location);
  @endphp

  <div class="gradient_rounded radies_20 mb-3 member-card">
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
@endforeach


