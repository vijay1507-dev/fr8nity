@extends('layouts.website')
@section('title', 'Member Directory - Fr8nity')
@section('content')
<section>
    <div class="container blackbg">
        <div class="row">
            <!-- Left Column -->
            <div
                class="col-md-10 mx-auto mb-4 d-flex justify-content-center flex-column text-center mt-5 pt-4">
                <div>
                    <h1 class="fw-bold size text_image">
                        Member Directory
                    </h1>
                     <div class="input-group-text w-100 member_filter mt-3">
                        <div class="input-group-text p-0 w-100">
                            
                            <input type="text" class="form-control border-0" placeholder="Company name"
                                aria-label="Company name">
                        </div>
                            <div class="input-group-text p-0 w-100">
                            <span class="icons d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-geo-alt-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                </svg></span>
                            <input type="text" class="form-control border-0" placeholder="Country"
                                aria-label="Country">
                        </div>
                            <div class="input-group-text p-0 w-100">
                            <span class="icons d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-geo-alt-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                </svg></span>
                            <input type="text" class="form-control border-0" placeholder="City"
                                aria-label="City">
                        </div>
                        <div class="input-group-text p-0 border-0 w-100">
                            
                            <input type="text" class="form-control border-0" placeholder="Specialization"
                                aria-label="">
                        </div>
                        <button class="btn btn-outline-secondary search_btn" type="button">Filter</button>
                    </div>
                    <p class="text-white mt-3">Can't find right member? <a href="https://fr8nity.sistagging.com/contact-us" class="text-primary">Click here</a></p>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="filter_list pb-5">
      <div class="container">
      <div class="gradient_rounded radies_20 mb-3">
        <div class="bg-dark p-3 px-4 radies_20">
              <div class="d-flex align-items-center mb-2">
          <img src="https://pub-e63b17b4d990438a83af58c15949f8a2.r2.dev/type/amara.png" alt="Vantage Logistics Corp Logo" class="me-2 company_logo">
         <div>
             <h4 class="mb-0 text-white">josh <span>(Vantage Logistics Corporation)</span></h4>
           <span class="text-white d-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg> Ho Chi Minh City - Vietnam</span>
         </div>
        </div>
        <div class="d-flex align-items-center mb-2">
          <span class="badge badge-custom explorer_bg me-2">Explorer</span>
           <a href="{{route('members.directory-view-profile')}}" class="btn ms-auto btn btnbg fe-semibold">Get Contacts</a>
        </div>
        <div class="d-flex align-items-center flex-wrap mb-2">
          <span class="btn service-btn">FCL</span>
          <span class="btn service-btn">Air Freight</span>
          <span class="btn service-btn">Customs Clearance</span>
          <span class="btn service-btn">Express</span>
          <span class="btn service-btn">Break Bulk</span>
          <span class="btn service-btn">+11</span>
        </div>
        </div>
      </div>
      <div class="gradient_rounded radies_20 mb-3">
        <div class="bg-dark p-3 px-4 radies_20">
              <div class="d-flex align-items-center mb-2">
          <img src="https://pub-e63b17b4d990438a83af58c15949f8a2.r2.dev/type/amara.png" alt="Vantage Logistics Corp Logo" class="me-2 company_logo">
         <div>
             <h4 class="mb-0 text-white">josh <span>(Vantage Logistics Corporation)</span></h4>
           <span class="text-white d-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg> Ho Chi Minh City - Vietnam</span>
         </div>
        </div>
        <div class="d-flex align-items-center mb-2">
                <span class="badge badge-custom elevate_bg me-2">Elevate</span>
        
           <a href="{{route('members.directory-view-profile')}}" class="btn ms-auto btn btnbg fe-semibold">Get Contacts</a>
        </div>
        <div class="d-flex align-items-center flex-wrap mb-2">
          <span class="btn service-btn">FCL</span>
          <span class="btn service-btn">Air Freight</span>
          <span class="btn service-btn">Customs Clearance</span>
          <span class="btn service-btn">Express</span>
          <span class="btn service-btn">Break Bulk</span>
          <span class="btn service-btn">+11</span>
        </div>
        </div>
      </div>
      <div class="gradient_rounded radies_20 mb-3">
        <div class="bg-dark p-3 px-4 radies_20">
              <div class="d-flex align-items-center mb-2">
          <img src="https://pub-e63b17b4d990438a83af58c15949f8a2.r2.dev/type/amara.png" alt="Vantage Logistics Corp Logo" class="me-2 company_logo">
         <div>
             <h4 class="mb-0 text-white">josh <span>(Vantage Logistics Corporation)</span></h4>
           <span class="text-white d-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg> Ho Chi Minh City - Vietnam</span>
         </div>
        </div>
        <div class="d-flex align-items-center mb-2">
        
          <span class="badge badge-custom founder_bg me-2">Founder</span>
           <a href="{{route('members.directory-view-profile')}}" class="btn ms-auto btn btnbg fe-semibold">Get Contacts</a>
        </div>
        <div class="d-flex align-items-center flex-wrap mb-2">
          <span class="btn service-btn">FCL</span>
          <span class="btn service-btn">Air Freight</span>
          <span class="btn service-btn">Customs Clearance</span>
          <span class="btn service-btn">Express</span>
          <span class="btn service-btn">Break Bulk</span>
          <span class="btn service-btn">+11</span>
        </div>
        </div>
      </div>
      <div class="gradient_rounded radies_20 mb-3">
        <div class="bg-dark p-3 px-4 radies_20">
              <div class="d-flex align-items-center mb-2">
          <img src="https://pub-e63b17b4d990438a83af58c15949f8a2.r2.dev/type/amara.png" alt="Vantage Logistics Corp Logo" class="me-2 company_logo">
         <div>
             <h4 class="mb-0 text-white">josh <span>(Vantage Logistics Corporation)</span></h4>
           <span class="text-white d-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg> Ho Chi Minh City - Vietnam</span>
         </div>
        </div>
        <div class="d-flex align-items-center mb-2">
               <span class="badge badge-custom summit_bg me-2">Summit</span>
          <a href="{{route('members.directory-view-profile')}}" class="btn ms-auto btn btnbg fe-semibold">Get Contacts</a>
        </div>
        <div class="d-flex align-items-center flex-wrap mb-2">
          <span class="btn service-btn">FCL</span>
          <span class="btn service-btn">Air Freight</span>
          <span class="btn service-btn">Customs Clearance</span>
          <span class="btn service-btn">Express</span>
          <span class="btn service-btn">Break Bulk</span>
          <span class="btn service-btn">+11</span>
        </div>
        </div>
      </div>
    </div>
</div>


@endsection