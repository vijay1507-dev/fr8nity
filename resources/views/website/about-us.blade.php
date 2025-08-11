@extends('layouts.website')

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
                    <p class="fs-6">Fr8nity is more than a network — it’s an alliance where trust is currency, collaboration is culture, and growth is the shared destination.</p>
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
           Fr8nity is more than a network — it’s an alliance where trust is currency, collaboration is culture, and growth is the shared destination.

                </p>
                <p class="fs-6">
            We connect vetted freight forwarders from every corner of the globe, uniting those who believe in doing business with integrity and intention. In our circle, opportunities are not kept — they are exchanged. Partnerships are not transactional — they are cultivated. Every introduction, every connection, is a step toward collective success.

                </p>
                    <p class="fs-6">
                  Here, experience meets fresh perspective. Tradition fuels innovation. Borders dissolve into bridges. And within this trusted space, every member finds not just opportunity, but the assurance that when one thrives, we all rise.
                </p>
                  
                <a href="#" type="button" class="btn btnbg fe-semibold mt-4">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>


<section class="founders_sec">
    <div class="container py-5 px-2">
        <div class="text-center">
            <h2 class="text-center fw-bold fs-2">Meet Our Founders</h2>
            <div class="underline mb-4 mx-auto">
                <span class="move delay-0"></span>
                <span class="move delay-1"></span>
            </div>
        </div>

        <div class="row mx-auto align-items-stretch">
              <div class="col-12 col-md-6 mb-3">
                <div class="gradient_rounded radies_20 m-2 h-100">
                    <div class="p-3 h-100 radies_20 blacklight">
                        <img src="{{ asset('images/dawn.webp') }}" alt="Dawn Tan" class="img-fluid mb-3" />
                        <div class="px-4 d-flex flex-column">
                            <h3 class="h4 textcolor">
                                Dawn – The Trailblazer
                            </h3>
                            <p class="mb-0">With 30+ years of industry expertise, Dawn is a seasoned freight forwarder whose career was built container by container. Her depth of experience, operational precision, and unwavering grit ensure Fr8nity remains grounded in what works.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 mb-3">
                <div class="gradient_rounded radies_20 m-2 h-100">
                    <div class="p-3 h-100 radies_20 blacklight">
                        <img src="{{ asset('images/creryl.webp') }}" alt="Cheryl Tan" class="img-fluid mb-3" />
                        <div class="px-4 d-flex flex-column">
                            <h3 class="h4 textcolor">
                                 Cheryl – The Firestarter 
                            </h3>
                            <p class="mb-0">Cheryl brings a vibrant edge with more than a decade in customer service, sales, and leadership. She’s a digital-native leader — people-first, future-focused — with a sharp instinct for building meaningful relationships and driving growth.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

          
        </div>
        
    </div>
</section> 


<section class="about_sec">
    <div class="container py-5">
         <div class="row align-items-center justify-content-center p-3">
             <div class="col-12 col-md-6">
                <h2 class="mb-3 fw-bold">A New Kind of Network</h2>
                <div class="underline mb-4">
                    <span class="move delay-0"></span>
                    <span class="move delay-1"></span>
                </div>
                <p class="fs-6">
                    Freight forwarding is rooted in tradition — but Fr8nity believes tradition shouldn’t limit innovation.
                </p>
               
                <p class="fs-6">
                    We blend experience and energy to create something stronger:
                </p>
                <ul class="p-0">
                    <li>🤝 We build trust with every layer we lay</li>
                    <li>🌱 We nurture partnerships that evolve with us</li>
                    <li>📈 We commit to elevation at every step</li>
                </ul>
                <p class="fs-6">
                    More than business, freight is connection — across borders, industries, and lives. Dawn and Cheryl, united by a love for travel and discovery, see freight forwarding as a chance to connect people, move ideas, and build bridges.
                </p>
                <p class="fs-6">
                   Fr8nity is that bridge. A place where all forwarders — seasoned or new — thrive together.
                </p>
            </div>
            <div class="col-12 col-md-6 text-center mb-4 mb-md-0 px-md-4">
                <div class="gradient_rounded radies_20">
                    <div class="blacklight radies_20 p-3">
                            <img src="{{asset('images/ourStory.png')}}" alt="Our Story"
                    class="img-fluid rounded-4 shadow object-fit-cover w-100 radies_20"
                    style="height: 100%; max-height: 450px; object-position: center;" />
                    </div>    
                </div>    
            </div>
           
        </div>
    </div>
</section>


<!-- <section class="ourteam_sec">
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
</section>  -->


@endsection
