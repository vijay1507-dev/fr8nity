@extends('layouts.main')

@section('title', 'About-us')

@section('content')

<section>
    <div class="container blackbg">
        <div class="row">
            <!-- Left Column -->
            <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
                <div>
                    <h1 class="fw-bold size text_image">
                       About Us
                    </h1>
                    <p class="fs-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <a href="{{ route('membership') }}" class="btn btnbg fe-semibold mt-3">
                        <span>Become a Member</span>
                    </a>
                </div>
            </div>

            <!-- Right Column (Video) -->
            <div class="col-12 col-md-6 mb-md-3 r">
                <video src="{{asset('images/bannervideo.mp4')}}" autoplay muted loop playsinline class="w-100"></video>
            </div>
        </div>
    </div>
</section> 

<!-- About Section -->
<section class="about_sec">
    <div class="container py-5">
        <div class="container">
            <div class="">
                <div class="row align-items-center justify-content-center p-3">
                    <div class="col-12 col-md-6 text-center mb-4 mb-md-0 px-md-4">
                        <div class="gradient_rounded radies_20">
                            <div class="blacklight radies_20 p-3">
                                 <img src="{{asset('images/ourStory.png')}}" alt="Our Story"
                            class="img-fluid rounded-4 shadow object-fit-cover w-100 radies_20"
                            style="height: 100%; max-height: 450px; object-position: center;" />
                            </div>    
                        </div>    
                    </div>
                    <div class="col-12 col-md-6">
                        <h2 class="mb-3 fw-bold">About The FR8NITY </h2>
                        <div class="underline mb-4">
                            <span class="move delay-0"></span>
                            <span class="move delay-1"></span>
                        </div>
                        <p class="fs-6">
                            FR8NITY is more than a freight forwarding network. It's a movement - where credibility moves faster than cargo.
                        </p>
                        <p class="fs-6">
                            Born from years in the trenches of logistics, FR8NITY was built to connect forwarders globally, offering not just access - but advantage.
                        </p>
                         <p class="fs-6">
                            It's a space where professionalism meets partnership. Where independent players rise together through shared trust, verified referrals, and meaningful growth.
                        </p>
                         <p class="fs-6">
                           Because in this fast-paced, high-pressure industry, no one should have to move alone.
                        </p>
                        <a href="#" type="button" class="btn btnbg fe-semibold mt-4">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="container py-5 px-2">
        <div class="text-center">
            <h2 class="text-center fw-bold fs-2">Founders</h2>
            <div class="underline mb-4 mx-auto">
                <span class="move delay-0"></span>
                <span class="move delay-1"></span>
            </div>
        </div>

        <div class="row mx-auto align-items-stretch">
            <div class="col-12 col-lg-6 mb-3">
                <div class="gradient_rounded radies_20 m-2">
                    <div class="p-3 h-100 radies_20 blacklight">
                        <img src="{{ asset('images/funder1.png') }}" alt="Cheryl Tan" class="img-fluid mb-3" />
                        <div class="px-4 d-flex flex-column">
                            <h3 class="h5 textcolor">
                                Cheryl Tan
                            </h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                unknown printer took a galley of type and scrambled it to make a type specimen book.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-3">
                <div class="gradient_rounded radies_20 m-2">
                    <div class="p-3 h-100 radies_20 blacklight">
                        <img src="{{ asset('images/funder2.png') }}" alt="Dawn Tan" class="img-fluid mb-3" />
                        <div class="px-4 d-flex flex-column">
                            <h3 class="h5 textcolor">
                                Dawn Tan
                            </h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                unknown printer took a galley of type and scrambled it to make a type specimen book.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section> 


<section class="ourteam_sec">
    <div class="container py-5 pt-3 px-2">
        <div class="text-center">
            <h2 class="text-center fw-bold fs-2">Our Team</h2>
            <div class="underline mb-4 mx-auto">
                <span class="move delay-0" />
                <span class="move delay-1" />
            </div>
        </div>
        <div class="row mx-auto align-items-stretch mt-5">
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Charlotte Chan</div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team02.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Ethan Tan</div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team03.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Aileen Tan</div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team04.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Aaron Aziz</div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team05.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Jessica Tan </div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="gradient_rounded radies_20 m-0 h-100">
                    <div class="card blacklight radies_20 p-2 h-100">
                        <img src="{{ asset('images/team06.jpg') }}" alt="Benefit 1"
                            class="img-fluid mb-0" />
                        <div class="card-content p-md-3 p-2">
                            <div class="card-title">Hariss Harun</div>
                            <div class="card-desc"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</section> 


@endsection
