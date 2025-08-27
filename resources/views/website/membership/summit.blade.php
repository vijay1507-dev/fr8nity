@extends('layouts.website')
@section('title', 'Summit Membership - Fr8nity')
@section('content')

  <section>
    <div class="container blackbg banner_innerpage">
    <div class="row">

      <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
      <div>
        <h1 class="fw-bold size text_image pt-5 pb-1 pt-lg-0">
        Summit Membership
        </h1>
        <p class="bannerp fs-6">The Pinnacle of Freight Partnership</p>
        <p class="bannerp fs-6">The Summit Membership is reserved for forwarders who lead with excellence and trade with
        vision. </p>
        <p class="bannerp fs-6">
        Positioned just below the exclusive Founder tier, Summit members enjoy maximum protection, elite visibility,
        and priority access across FR8NITY’s trusted global network.</p>
      </div>
      </div>

      <div class="col-12 col-md-6 mb-md-3 right_image text-end">
      <img src="https://fr8nity.sistagging.com/images/summitimg.png" alt=""
        class="img-fluid rounded-4  object-fit-cover"
        style="height: 100%; max-height: 450px; object-position: center;" />
      </div>
    </div>
    </div>
  </section>
  <section class=" blackdark">
    <div class="container py-5 px-2">
    <div class="text-center">
      <h2 class="text-center fw-bold fs-2">Your Membership at a Glance</h2>
      <div class="underline mb-4 mx-auto">
      <span class="move delay-0"></span>
      <span class="move delay-1"></span>
      </div>
    </div>
    <div class="row mx-auto justify-content-center align-items-stretch">
      <div class="col-12 col-sm-6 col-lg-5 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-2 h-100 blacklight radies_20 d-flex flex-column">
        <div class="px-5 d-flex flex-column justify-content-center align-items-center flex-grow-1">
          <svg viewBox="0 0 1024 1024" width="70px" height="70px" class="icon mb-4" version="1.1"
          xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="gradientFill" x1="100%" y1="0%" x2="0%" y2="0%">
            <stop offset="0%" style="stop-color:#b58320" />
            <stop offset="54.81%" style="stop-color:#ffff78" />
            <stop offset="100%" style="stop-color:#f3ab0b" />
            </linearGradient>
          </defs>
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <path d="M194.4 368h698.4v60H194.4z" fill="url(#gradientFill)"></path>
            <path
            d="M928 751.2V275.2c0-24-18.4-48-48-48H138.4c-24 0-48 18.4-48 48v476c0 24 18.4 48 48 48h740.8c30.4-5.6 48.8-24 48.8-48z m60 0c0 60-48 108.8-108.8 108.8H138.4c-60 0-108.8-48-108.8-108.8V275.2c0-60 48-108.8 108.8-108.8h740.8c60 0 108.8 48 108.8 108.8v476z"
            fill="url(#gradientFill)"></path>
            <path d="M633.6 573.6h106.4V680H633.6zM792 573.6h106.4V680H792z" fill="url(#gradientFill)"></path>
          </g>
          </svg>
          <h6 class="textcolor fw-semibold fs-3">Annual Fee:</h6>
          <p class="mb-0">{{ $membershipTier->annual_fee ?? 'N/A' }}</p>
        </div>
        </div>
      </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-5 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-2 h-100 blacklight radies_20 d-flex flex-column">

        <div class="px-5 d-flex flex-column justify-content-center align-items-center flex-grow-1 p-3">
          <svg fill="#a8a9ad" width="70px" height="70px" class="mb-4" viewBox="0 0 256 256" id="Layer_1"
          version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink">
          <defs>
            <linearGradient id="gradientFill" x1="100%" y1="0%" x2="0%" y2="0%">
            <stop offset="0%" style="stop-color:#b58320" />
            <stop offset="54.81%" style="stop-color:#ffff78" />
            <stop offset="100%" style="stop-color:#f3ab0b" />
            </linearGradient>
          </defs>
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <g>
            <path fill="url(#gradientFill)"
              d="M100.4,113.6l2,1.3l2.3-0.8c11-4.1,24-5.2,30.8-5.4l0.9,0V144c0,2.7,2.2,4.8,4.8,4.8s4.8-2.2,4.8-4.8v-35.5l0.9,0 c8.3,0.4,20.4,1.6,30.8,5.4l2.3,0.8l2-1.3c15.2-9.7,36.3-14.6,57.9-13.6l6.1,0.3l-1.1-6c-7.3-40-50.9-67.3-88.2-72.7 c-2.9-0.4-6-0.7-9.2-0.8c-0.5,0-1,0-1.4,0v-8.5c0-2.7-2.2-4.8-4.8-4.8s-4.8,2.2-4.8,4.8v8.5c-0.4,0-0.8,0-1.3,0 c-3.4,0.1-6.5,0.4-9.4,0.8C88.4,27,44.8,54.3,37.5,94.2l-1.1,6l6.1-0.3C64.1,98.9,85.2,103.9,100.4,113.6z M127.1,31.2 c2.6-0.4,5.3-0.6,8.5-0.7c3.7-0.2,7.5-0.2,11.4,0c3,0.1,5.7,0.3,8.3,0.7h0c32.1,4.6,69.2,26.6,78.7,59c-20.6,0-39.9,4.9-55.2,14 c-11-3.7-23.1-4.9-31.4-5.2l-3.1-0.1c-1.1,0-2.1,0-2.8,0H141c-0.8,0-1.7,0-2.7,0l-3.2,0.1c-8.4,0.4-20.5,1.6-31.5,5.2 c-15.3-9.1-34.6-14-55.2-14C57.9,57.8,95,35.8,127.1,31.2z">
            </path>
            <path fill="url(#gradientFill)"
              d="M224,162.3l-59.8,25.1c-2.5,1-3.6,3.9-2.6,6.3c1,2.5,3.9,3.6,6.3,2.6l59.8-25.1c2.6-1.1,5.5-0.3,7.2,1.8 c1.1,1.4,1.6,3.1,1.3,4.8c-0.3,1.8-1.3,3.3-2.8,4.2c-26.1,17-85.4,50.6-88.2,52.2c-0.1,0.1-0.2,0.1-0.3,0.2v0 c-7.2,4.3-15.3,5.4-25.5,3.6c-0.6-0.1-14.4-1.8-47.1-5.8l-16.8-2.1v-65.3c2.7-0.2,5.1-0.3,6.1-0.3l0.6,0 c22.5-1.4,44.1,2.9,66.9,7.5c2.9,0.6,5.8,1.2,8.8,1.8c3.1,0.6,5.4,3.3,5.4,6.5c0,0.2,0,0.4-0.1,0.8c-0.2,1.8-1.2,3.1-1.9,3.9 c-1.2,1.2-2.9,1.9-4.7,1.9H91.1c-2.7,0-4.8,2.2-4.8,4.8s2.2,4.8,4.8,4.8h45.7c4.3,0,8.5-1.7,11.6-4.8c2.6-2.7,4.2-6,4.6-9.4 c0.1-0.7,0.2-1.4,0.2-2.2c0-7.8-5.5-14.5-13.2-16c-2.9-0.6-5.8-1.2-8.7-1.8c-22.4-4.5-45.6-9.2-69.4-7.7l-0.5,0 c-1.1,0-3.3,0.2-5.9,0.3c-0.6-2.1-2.4-3.6-4.6-3.6h-36c-2.7,0-4.8,2.2-4.8,4.8v81.4c0,2.7,2.2,4.8,4.8,4.8h36 c1.9,0,3.6-1.2,4.4-2.8l16.1,2c19.2,2.4,45.5,5.6,46.6,5.7c3.6,0.6,7,1,10.3,1c8,0,15.1-1.9,21.6-5.7c0.1,0,0.1-0.1,0.2-0.1 c0.6-0.3,62-35,88.8-52.5c3.8-2.5,6.3-6.4,7-10.8c0.7-4.4-0.5-8.9-3.3-12.4C238,161.4,230.6,159.5,224,162.3z M46,233.1H19.6v-71.7 H46V233.1z">
            </path>
            </g>
          </g>
          </svg>

          <h6 class="textcolor fw-semibold fs-3 text-center">Credit Protection:</h6>
          <p class="mb-0 text-center">{{ $membershipTier->credit_protection ?? 'N/A' }} (with self-participation on
          claims)</p>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </section>
  <section class="freightmember_sec blacklight">
    <div class="container py-5 px-2">
    <div class="text-center">
      <h2 class="text-center fw-bold fs-2">Summit Benefits</h2>
      <div class="underline mb-4 mx-auto">
      <span class="move delay-0"></span>
      <span class="move delay-1"></span>
      </div>
    </div>
    <div class="row mx-auto justify-content-center align-items-stretch">
      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">

        <div class="px-4 d-flex flex-column align-items-center flex-grow-1 text-center">
          <svg height="70px" width="70px" class="mb-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 290 290" xml:space="preserve">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#b58320;" />
              <stop offset="54.81%" style="stop-color:#ffff78;" />
              <stop offset="100%" style="stop-color:#f3ab0b;" />
            </linearGradient>
            </defs>
            <g>
            <path id="circle8927" fill="url(#gradient)"
              d="M234.998,32.726c-2.761-0.034-5.028,2.177-5.062,4.938c-0.019,1.524,0.658,2.973,1.839,3.937 C262.347,67.254,280,105.109,280,145.017c0,39.908-17.653,77.764-48.225,103.416c-2.121,1.768-2.407,4.922-0.639,7.043 c1.768,2.121,4.922,2.407,7.043,0.639c0.009-0.007,0.017-0.014,0.026-0.022C271.036,228.545,290,187.875,290,145.017 c0-42.858-18.964-83.528-51.795-111.076C237.313,33.171,236.177,32.74,234.998,32.726z M54.852,32.73 c-1.126,0.048-2.203,0.474-3.057,1.211C18.964,61.489,0,102.159,0,145.017c0,42.858,18.964,83.528,51.795,111.076 c2.109,1.783,5.264,1.518,7.047-0.592c1.783-2.109,1.518-5.264-0.591-7.047c-0.009-0.007-0.017-0.014-0.026-0.022 C27.653,222.781,10,184.925,10,145.017c0-39.908,17.653-77.764,48.225-103.416c2.14-1.745,2.46-4.895,0.715-7.036 C57.942,33.343,56.427,32.663,54.852,32.73z M188.928,71.027c-2.761-0.034-5.028,2.176-5.062,4.938 c-0.019,1.525,0.659,2.976,1.842,3.939c19.25,16.152,30.363,39.985,30.363,65.113s-11.114,48.961-30.363,65.113 c-2.144,1.741-2.471,4.89-0.73,7.034c1.741,2.144,4.89,2.471,7.034,0.73c0.042-0.034,0.083-0.069,0.124-0.104 c21.509-18.048,33.936-44.695,33.936-72.773s-12.426-54.725-33.936-72.773C191.243,71.473,190.107,71.042,188.928,71.027z M100.922,71.031c-1.126,0.048-2.204,0.476-3.057,1.213C76.356,90.292,63.93,116.939,63.93,145.017 c0,28.078,12.426,54.725,33.936,72.773c2.087,1.809,5.245,1.584,7.054-0.502c1.809-2.087,1.584-5.245-0.502-7.054 c-0.041-0.035-0.082-0.07-0.124-0.104c-19.25-16.152-30.363-39.985-30.363-65.113c0-25.129,11.114-48.961,30.363-65.113 c2.141-1.744,2.463-4.894,0.719-7.035C104.015,71.645,102.499,70.963,100.922,71.031z M145,110.017c-19.271,0-35,15.729-35,35 s15.729,35,35,35s35-15.729,35-35S164.271,110.017,145,110.017z M145,120.017c13.866,0,25,11.134,25,25s-11.134,25-25,25 s-25-11.134-25-25S131.134,120.017,145,120.017z M145,127.517c-1.381-0.02-2.516,1.084-2.535,2.465 c-0.02,1.381,1.084,2.516,2.465,2.535c0.024,0,0.047,0,0.071,0c6.933,0,12.5,5.567,12.5,12.5c-0.02,1.381,1.084,2.516,2.465,2.535 c1.381,0.02,2.516-1.084,2.535-2.465c0-0.024,0-0.047,0-0.071C162.5,135.382,154.635,127.517,145,127.517z">
            </path>
            </g>
          </g>
          </svg>
          <h6 class="textcolor fw-semibold fs-4">Top-Tier Network Positioning </h6>
          <p class="text-center mb-1">Appear at the top of search results and receive the highest visibility across
          partner and trade requests.</p>
        </div>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">
        <div class="px-4 d-flex flex-column  align-items-center flex-grow-1 text-center">
          <svg width="70px" height="70px" class="mb-4" viewBox="0 0 256 256" id="Layer_1" version="1.1"
          xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#b58320;" />
              <stop offset="54.81%" style="stop-color:#ffff78;" />
              <stop offset="100%" style="stop-color:#f3ab0b;" />
            </linearGradient>
            </defs>
            <g>
            <path fill="url(#gradient)"
              d="M100.4,113.6l2,1.3l2.3-0.8c11-4.1,24-5.2,30.8-5.4l0.9,0V144c0,2.7,2.2,4.8,4.8,4.8s4.8-2.2,4.8-4.8v-35.5l0.9,0 c8.3,0.4,20.4,1.6,30.8,5.4l2.3,0.8l2-1.3c15.2-9.7,36.3-14.6,57.9-13.6l6.1,0.3l-1.1-6c-7.3-40-50.9-67.3-88.2-72.7 c-2.9-0.4-6-0.7-9.2-0.8c-0.5,0-1,0-1.4,0v-8.5c0-2.7-2.2-4.8-4.8-4.8s-4.8,2.2-4.8,4.8v8.5c-0.4,0-0.8,0-1.3,0 c-3.4,0.1-6.5,0.4-9.4,0.8C88.4,27,44.8,54.3,37.5,94.2l-1.1,6l6.1-0.3C64.1,98.9,85.2,103.9,100.4,113.6z M127.1,31.2 c2.6-0.4,5.3-0.6,8.5-0.7c3.7-0.2,7.5-0.2,11.4,0c3,0.1,5.7,0.3,8.3,0.7h0c32.1,4.6,69.2,26.6,78.7,59c-20.6,0-39.9,4.9-55.2,14 c-11-3.7-23.1-4.9-31.4-5.2l-3.1-0.1c-1.1,0-2.1,0-2.8,0H141c-0.8,0-1.7,0-2.7,0l-3.2,0.1c-8.4,0.4-20.5,1.6-31.5,5.2 c-15.3-9.1-34.6-14-55.2-14C57.9,57.8,95,35.8,127.1,31.2z">
            </path>
            <path fill="url(#gradient)"
              d="M224,162.3l-59.8,25.1c-2.5,1-3.6,3.9-2.6,6.3c1,2.5,3.9,3.6,6.3,2.6l59.8-25.1c2.6-1.1,5.5-0.3,7.2,1.8 c1.1,1.4,1.6,3.1,1.3,4.8c-0.3,1.8-1.3,3.3-2.8,4.2c-26.1,17-85.4,50.6-88.2,52.2c-0.1,0.1-0.2,0.1-0.3,0.2v0 c-7.2,4.3-15.3,5.4-25.5,3.6c-0.6-0.1-14.4-1.8-47.1-5.8l-16.8-2.1v-65.3c2.7-0.2,5.1-0.3,6.1-0.3l0.6,0 c22.5-1.4,44.1,2.9,66.9,7.5c2.9,0.6,5.8,1.2,8.8,1.8c3.1,0.6,5.4,3.3,5.4,6.5c0,0.2,0,0.4-0.1,0.8c-0.2,1.8-1.2,3.1-1.9,3.9 c-1.2,1.2-2.9,1.9-4.7,1.9H91.1c-2.7,0-4.8,2.2-4.8,4.8s2.2,4.8,4.8,4.8h45.7c4.3,0,8.5-1.7,11.6-4.8c2.6-2.7,4.2-6,4.6-9.4 c0.1-0.7,0.2-1.4,0.2-2.2c0-7.8-5.5-14.5-13.2-16c-2.9-0.6-5.8-1.2-8.7-1.8c-22.4-4.5-45.6-9.2-69.4-7.7l-0.5,0 c-1.1,0-3.3,0.2-5.9,0.3c-0.6-2.1-2.4-3.6-4.6-3.6h-36c-2.7,0-4.8,2.2-4.8,4.8v81.4c0,2.7,2.2,4.8,4.8,4.8h36 c1.9,0,3.6-1.2,4.4-2.8l16.1,2c19.2,2.4,45.5,5.6,46.6,5.7c3.6,0.6,7,1,10.3,1c8,0,15.1-1.9,21.6-5.7c0.1,0,0.1-0.1,0.2-0.1 c0.6-0.3,62-35,88.8-52.5c3.8-2.5,6.3-6.4,7-10.8c0.7-4.4-0.5-8.9-3.3-12.4C238,161.4,230.6,159.5,224,162.3z M46,233.1H19.6v-71.7 H46V233.1z">
            </path>
            </g>
          </g>
          </svg>
          <h6 class="textcolor fw-semibold fs-4">Credit Protection (USD 12,000/year)</h6>
          <p class="text-center mb-0">Operate with unmatched confidence. Summit members receive our most
          comprehensive protection plan, designed for high-value transactions (claimable with self-participation).
          </p>
        </div>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">
        <div class="px-4 d-flex flex-column  align-items-center flex-grow-1 text-center">
          <svg version="1.1" width="70px" height="70px" class="mb-4" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 88.965 88.966" xml:space="preserve">
          <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#b58320" />
            <stop offset="54.81%" style="stop-color:#ffff78" />
            <stop offset="100%" style="stop-color:#f3ab0b" />
            </linearGradient>
          </defs>
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <g>
            <g>
              <polygon fill="url(#gradient)"
              points="66.436,56.656 61.639,56.656 61.639,72.438 75.096,72.438 75.096,67.641 66.436,67.641" />
              <path fill="url(#gradient)"
              d="M65.049,46.49v-3.342V23.541c0,0,0.008-6.385,0-6.465l-3.746-7.59l3.324-6.32c0.354-0.67,0.33-1.475-0.062-2.121 C64.174,0.397,63.471,0,62.715,0H5.301C4.11,0,3.143,0.967,3.143,2.16l0.052,80.307h10.369V16.841H7.461V4.32h51.68l-2.186,4.15 c-0.328,0.625-0.332,1.369-0.007,1.998l3.295,6.373h-42.43v65.625h7.915h6.818h14.526h2.236c3.865,4,9.273,6.5,15.264,6.5 c11.719,0,21.25-9.532,21.25-21.25C85.825,56.158,76.547,46.746,65.049,46.49z M64.575,81.966c-7.857,0-14.25-6.394-14.25-14.25 s6.393-14.25,14.25-14.25s14.25,6.394,14.25,14.25S72.432,81.966,64.575,81.966z" />
            </g>
            </g>
          </g>
          </svg>

          <h6 class="textcolor fw-semibold fs-4 text-center">RisePoints Multiplier</h6>
          <p class="text-center mb-0"> Earn more, faster. Summit members accumulate RisePoints at a higher rate —
          perfect for unlocking premium perks and recognitions.</p>
        </div>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">
        <div class="px-4 d-flex flex-column  align-items-center flex-grow-1 text-center">
          <svg viewBox="0 0 24 24" width="70px" height="70px" class="mb-4" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#b58320" />
            <stop offset="54.81%" style="stop-color:#ffff78" />
            <stop offset="100%" style="stop-color:#f3ab0b" />
            </linearGradient>
          </defs>
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <path fill="url(#gradient)"
            d="M19.902 13.161a7.876 7.876 0 0 0-3.956-8.1c0-.021.006-.04.006-.061a3.952 3.952 0 0 0-7.904 0c0 .02.006.04.006.06a7.876 7.876 0 0 0-3.956 8.101 3.946 3.946 0 1 0 4.242 5.93 7.855 7.855 0 0 0 7.32 0 3.945 3.945 0 1 0 4.242-5.93zM12 2.051A2.948 2.948 0 1 1 9.052 5 2.951 2.951 0 0 1 12 2.052zM5 19.949A2.948 2.948 0 1 1 7.948 17 2.951 2.951 0 0 1 5 19.948zm3.75-1.76A3.896 3.896 0 0 0 8.952 17a3.952 3.952 0 0 0-3.868-3.944A7.1 7.1 0 0 1 4.996 12a6.977 6.977 0 0 1 3.232-5.885 3.926 3.926 0 0 0 7.544 0A6.977 6.977 0 0 1 19.004 12a7.1 7.1 0 0 1-.088 1.056A3.952 3.952 0 0 0 15.048 17a3.896 3.896 0 0 0 .202 1.188 7.13 7.13 0 0 1-6.5 0zM19 19.948A2.948 2.948 0 1 1 21.948 17 2.951 2.951 0 0 1 19 19.948z" />
            <path fill="none" d="M0 0h24v24H0z" />
          </g>
          </svg>

          <h6 class="textcolor fw-semibold fs-4 text-center">First Access to Premium Collaborations</h6>
          <p class="text-center mb-0"> Be the first considered for joint projects, cross-border campaigns, and
          spotlight opportunities.</p>
        </div>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">
        <div class="px-4 d-flex flex-column  align-items-center flex-grow-1 text-center">
          <svg height="70px" width="70px" class="mb-4" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" style="stop-color:#b58320;" />
              <stop offset="54.81%" style="stop-color:#ffff78;" />
              <stop offset="100%" style="stop-color:#f3ab0b;" />
            </linearGradient>
            </defs>
            <path fill="url(#gradient)"
            d="M338.79-.011v527.66L-.034 821.298V1919.99h1920V821.297l-338.71-293.647V-.011H338.79Zm112.94 1203.953V112.93h1016.471v1091.012l-189.289 151.34H641.02l-189.29-151.34Zm1129.526-526.87 225.882 195.726v60.085l-225.882 180.706V677.07ZM112.907 932.881v-60.084L338.79 677.071v436.518L112.907 932.883Zm1694.23 144.678v623.323l-238.08-301.553-88.658 70.023 266.654 337.695H172.88l266.767-337.695-88.659-70.023-238.08 301.553V1077.56l488.47 390.777h717.29l488.47-390.777Zm-790.666-795.207v282.353h282.353v112.941H1016.47V960H903.529V677.647H621.176V564.706H903.53V282.353h112.942Z"
            fill-rule="evenodd"></path>
          </g>
          </svg>

          <h6 class="textcolor fw-semibold fs-4 text-center">Invitation to Founders’ Roundtables</h6>
          <p class="text-center mb-0"> While not a Founder, you’ll receive special invites to selected leadership
          sessions with the FR8NITY core and global thought leaders.</p>
        </div>
        </div>
      </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mb-3 d-flex">
      <div class="gradient_rounded radies_20 m-2 flex-fill">
        <div class="p-1 py-5 h-100 blackdark radies_20 d-flex flex-column">
        <div class="px-4 d-flex flex-column  align-items-center flex-grow-1 text-center">
          <svg viewBox="0 0 24 24" height="70px" width="70px" class="mb-4" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#b58320" />
            <stop offset="54.81%" style="stop-color:#ffff78" />
            <stop offset="100%" style="stop-color:#f3ab0b" />
            </linearGradient>
          </defs>
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <circle opacity="0.5" cx="12" cy="9" r="3" stroke="url(#gradient)" stroke-width="1.5" />
            <circle cx="12" cy="12" r="10" stroke="url(#gradient)" stroke-width="1.5" />
            <path opacity="0.5"
            d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
            stroke="url(#gradient)" stroke-width="1.5" stroke-linecap="round" />
          </g>
          </svg>

          <h6 class="textcolor fw-semibold fs-4 text-center">Possibility of converting into Founders' Circle</h6>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </section>

  <section class="  blackdark pb-5">
    <div class="container pt-5 px-4 px-lg-2">
          <h3 class="fw-bold fs-2 fs-md-4 text-center pb-5">How to Earn RisePoints</h3>
    <div class="row d-flex">
      <div class="col-12 col-lg-6 d-flex flex-column h-100">
      <div class="flex-grow-1">
         <h3 class="fw-bold fs-3 mt-4 mt-lg-0 text-center">Membership Renewal</h3>
        <p class="text-center">Your actions within the FR8NITY network don’t just build relationships — they also earn you points.</p>
        <div class="row mx-auto">
        <div class="p-0 radies_20 tableborder">
          <div class="table-responsive blacklight radius_20">
          <table class="table mb-0 bg-transparent">
            <tbody>
            <tr class="bg-transparent">
              <td class="bg-transparent text-white p-2">Annual Membership Renewal</td>
              <td class="bg-transparent text-white p-2">8000 points</td>
            </tr>
            <tr class="bg-transparent">
              <td class="bg-transparent text-white p-2">Annual Membership Renewal (30 days before expiry)</td>
              <td class="bg-transparent text-white p-2">8000 x2.5 points</td>
            </tr>
            </tbody>
          </table>
          </div>
        </div>
        </div>
      </div>
      </div>

      <div class="col-12 col-lg-6 d-flex flex-column h-100">
      <div class="flex-grow-1">
        <div class="text-center">
        <h3 class="fw-bold fs-3 mt-4 mt-lg-0">Referral of Members</h3>
        </div>
        <div class="row mx-auto">
        <div class="p-0 radies_20 tableborder mt-2">
          <div class="table-responsive p-0 m-0 blacklight radius_20">
          <table class="table table-borderless mb-0 bg-transparent w-100">
            <thead class="blackdark">
            <th class="bg-transparent text-white">Referral of Members</th>
            <th class="bg-transparent text-white">Pts</th>
            </thead>
            <tbody>
            <tr class="bg-transparent px-2">
              <td class="bg-transparent text-white">Referred members join as member</td>
              <td class="bg-transparent text-white">3000</td>
            </tr>
            <tr class="bg-transparent px-2">
              <td class="bg-transparent text-white p-2">Referred members Conference</td>
              <td class="bg-transparent text-white">1000</td>
            </tr>
            </tbody>
          </table>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
    <div class="container pt-5 px-4 px-lg-2">
    <div class="text-center">
      <h3 class="text-center fw-bold fs-3 mb-4">Business Collaboration (As a Giver)</h3>
    </div>
    <div class="row mx-auto">
      <div class="p-0 radies_20 tableborder">
      <div class="table-responsive p-0 m-0 blacklight  ">
        <table class="table table-borderless mb-0 bg-transparent w-100">
        <thead class="blackdark">
          <th class="bg-transparent text-white"></th>
          <th class="bg-transparent text-white">Pts</th>
          <th class="bg-transparent text-white">Summit</th>
        </thead>
        <tbody>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white">Monthly Transaction Value >USD50 & <=USD1000 </td>
          <td class="bg-transparent text-white">500</td>
          <td class="bg-transparent text-white">x2</td>

          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Monthly Transaction Value >USD1000 & <=USD5000 </td>
          <td class="bg-transparent text-white">700</td>
          <td class="bg-transparent text-white">x2</td>

          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Monthly Transaction Value >USD5000 & <=USD25000 </td>
          <td class="bg-transparent text-white">1000</td>
          <td class="bg-transparent text-white">x2</td>

          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Monthly Transaction Value >USD25000 & <=USD100K </td>
          <td class="bg-transparent text-white">1500</td>
          <td class="bg-transparent text-white">x2.5</td>

          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Monthly Transaction Value Above USD100K</td>
          <td class="bg-transparent text-white">2000</td>
          <td class="bg-transparent text-white">x3</td>
          </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
    </div>
    <div class="container pt-5 px-4 px-lg-2">
    <div class="text-center">
      <h3 class="text-center fw-bold fs-3 mb-4">Engagement & Participation Online/Conference attendance</h3>
    </div>
    <div class="row mx-auto">
      <div class="p-0 radies_20 tableborder">
      <div class="table-responsive p-0 m-0 blacklight  ">
        <table class="table table-borderless mb-0 bg-transparent w-100">
        <thead class="blackdark">
          <th class="bg-transparent text-white"></th>
          <th class="bg-transparent text-white">Pts</th>
        </thead>
        <tbody>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white">Annual conference attendance</td>
          <td class="bg-transparent text-white">5000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Early Signed up for Annual Event</td>
          <td class="bg-transparent text-white">2000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Online event participation</td>
          <td class="bg-transparent text-white">250 per event</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Host Online event </td>
          <td class="bg-transparent text-white">500 per event</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Contribute article, case study, or insight via email
          </td>
          <td class="bg-transparent text-white">200</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Welcome a new member (host/intro post)</td>
          <td class="bg-transparent text-white">200</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Like and share Fr8nity post on social media</td>
          <td class="bg-transparent text-white">200</td>
          </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
    </div>

    <div class="container pt-5 px-4 px-lg-2">
    <div class="text-center">
      <h3 class="text-center fw-bold fs-3 mb-4">Can you exchange your points with?</h3>
    </div>
    <div class="row mx-auto">
      <div class="p-0 radies_20 tableborder">
      <div class="table-responsive p-0 m-0 blacklight ">
        <table class="table table-borderless mb-0 bg-transparent w-100">
        <thead class="blackdark">
          <th class="bg-transparent text-white">Items</th>
          <th class="bg-transparent text-white">Points Required</th>
        </thead>
        <tbody>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white"> 5% off membership renewal</td>
          <td class="bg-transparent text-white">135000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">10% off membership renewal</td>
          <td class="bg-transparent text-white">175000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">15% off membership renewal</td>
          <td class="bg-transparent text-white">220000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">8% off annual conference fee</td>
          <td class="bg-transparent text-white">170000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">Free online course webinar</td>
          <td class="bg-transparent text-white">100000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">1 free conference meeting pass</td>
          <td class="bg-transparent text-white">375000</td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">FR8NITY merchandise</td>
          <td class="bg-transparent text-white"></td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">- Logo collar pin</td>
          <td class="bg-transparent text-white"></td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">- Fr8nity formal Polo -T</td>
          <td class="bg-transparent text-white"></td>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">- Fr8nity Namecard Holder</td>
          <td class="bg-transparent text-white"></td>
          </tr>
          </tr>
          <tr class="bg-transparent px-2">
          <td class="bg-transparent text-white p-2">- Fr8nity Flag + Tier Flag</td>
          <td class="bg-transparent text-white"></td>
          </tr>
        </tbody>
        </table>
      </div>
      </div>
    </div>
    </div>
    </div>
    </div>
  </section>



@endsection