<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fr8nity</title>

    <!-- Manifest file for PWA support -->
    <link rel="manifest" href="manifest.json" />

    <!-- Preconnect to speed up Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts: Instrument Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
    @include('partials.topbar')
    @include('partials.header')
    <section>
        <div class="container blackbg">
            <div class="row">
                <!-- Left Column -->
                <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
                    <div>
                        <h1 class="fw-bold size text_image">
                            When One Thrives,<br /> We All Rise
                        </h1>
                        <p class="fs-2">Logistics Network Reimagined</p>
                        <button type="button" class="btn btnbg fe-semibold mt-3">
                            <span>Become a Member</span>
                        </button>
                    </div>
                </div>

                <!-- Right Column (Video) -->
                <div class="col-12 col-md-6 mb-md-3 r">
                    <video src="{{asset('images/bannervideo.mp4')}}" autoplay muted loop playsinline class="w-100"></video>
                </div>
            </div>
        </div>
    </section>

    <section class="about_sec">
        <div class="container  py-5">
            <div class="container gradient_rounded radies_20">
                <div class="blacklight radies_20">
                    <div class="row align-items-center justify-content-center p-3">
                        <div class="col-12 col-md-6 text-center mb-4 mb-md-0">
                            <img src="{{ asset('images/ourStory.png') }}" alt="Our Story"
                                class="img-fluid rounded-4 shadow object-fit-cover w-100"
                                style="height: 100%; max-height: 450px; object-position: center;" />

                        </div>


                        <div class="col-12 col-md-6 ">
                            <h2 class="mb-3 fw-bold ">Our Story</h2>
                            <div class="underline mb-4">
                                <span class="move delay-0"></span>
                                <span class="move delay-1"></span>
                            </div>

                            <p class="fs-6">
                                It was popularised in the 1960s with the release of Letraset
                                sheets containing Lorem Ipsum passages, and more recently
                                with desktop publishing software like Aldus PageMaker
                                including versions of Lorem Ipsum.
                            </p>
                            <p class="fs-6">
                                has survived not only five centuries, but also the leap into
                                electronic typesetting, remaining essentially unchanged. It
                                was popularised in the 1960s with the release of Letraset
                                sheets containing Lorem Ipsum passages, and more recently
                                with desktop publishing software like Aldus PageMaker
                                including versions of Lorem Ipsum.
                            </p>
                            <button type="button" class="btn btnbg fe-semibold">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits_sec">
        <div class="container py-5 pt-3 px-2">
            <div class="text-center">
                <h2 class="text-center fw-bold fs-2">Your Benefits</h2>
                <div class="underline mb-4 mx-auto">
                    <span class="move delay-0" />
                    <span class="move delay-1" />
                </div>
            </div>
            <div class="row mx-auto align-items-stretch">
                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                    <div class="gradient_rounded radies_20 m-2 h-100">
                        <div class="card blacklight radies_20 p-2 h-100">
                            <img src="{{ asset('images/Mask group (3).png') }}" alt="Benefit 1"
                                class="img-fluid mb-3" />
                            <div class="card-content">
                                <div class="card-title">Business Opportunity Matching</div>
                                <div class="card-desc"> Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mb-4">
                    <div class="gradient_rounded radies_20 m-2 h-100">
                        <div class="card blacklight radies_20 p-2 h-100">
                            <img src="{{ asset('images/Mask group (4).png') }}" alt="Benefit 1"
                                class="img-fluid mb-3" />
                            <div class="card-content">
                                <div class="card-title">Cooperation Risk Protection</div>
                                <div class="card-desc"> Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mb-4">
                    <div class="gradient_rounded radies_20 m-2 h-100">
                        <div class="card blacklight radies_20 p-2 h-100">
                            <img src="{{ asset('images/Mask group (5).png') }}" alt="Benefit 3"
                                class="img-fluid mb-3" />
                            <div class="card-content">
                                <div class="card-title">Marketing and Promotion Services</div>
                                <div class="card-desc"> Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mb-4">
                    <div class="gradient_rounded radies_20 m-2 h-100">
                        <div class="card blacklight radies_20 p-2 h-100">
                            <img src="{{ asset('images/Mask group (6).png') }}" alt="Benefit 1"
                                class="img-fluid mb-3" />
                            <div class="card-content">
                                <div class="card-title">Reduce Costs and Boost efficiency</div>
                                <div class="card-desc"> Lorem ipsum, dolor sit amet consectetur adipisicing.</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="blacklight events_sec">
        <div class="container py-5 px-2">
            <div class="text-center">
                <h2 class="text-center fw-bold fs-2">Upcoming Events</h2>
                <div class="underline mb-4 mx-auto">
                    <span class="move delay-0"></span>
                    <span class="move delay-1"></span>
                </div>
            </div>
            <div class="row mx-auto align-items-stretch  ">
                <div class="col-12 col-sm-6 col-lg-4 mb-3 ">
                    <div class="gradient_rounded radies_20 m-2">
                        <div class="p-2 h-100 blackdark radies_20">
                            <img src="{{ asset('images/image 8.png') }}" alt="Benefit 1" class="img-fluid mb-3" />
                            <div class="px-4 d-flex flex-column pb-4">
                                <h6 class="textcolor fw-semibold fs-5">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting...
                                </h6>
                                <div class="d-flex justify-content-between fs-6 mt-2">
                                    <span class="yellowcolor view-more-underline">
                                        View More <img src={arrow} alt="" srcset="" />
                                    </span>
                                    <span>July 22’ 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 mb-3 ">
                    <div class="gradient_rounded radies_20 m-2">
                        <div class="p-2 h-100 blackdark radies_20">
                            <img src="{{ asset('images/eventimg2.png') }}" alt="Benefit 2" class="img-fluid mb-3" />
                            <div class="px-4 pb-4">
                                <h6 class="textcolor fw-semibold fs-5">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting...
                                </h6>
                                <div class="d-flex justify-content-between fs-6 mt-2">
                                    <span class="yellowcolor  view-more-underline">
                                        View More <img src={arrow} alt="" srcset="" />
                                    </span>
                                    <span>July 22’ 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 mb-3 ">
                    <div class="gradient_rounded radies_20 m-2">
                        <div class="p-2 h-100 blackdark radies_20">
                            <img src="{{ asset('images/eventimg3.png') }}" alt="Benefit 3"
                                class="img-fluid mb-3 p-2" />
                            <div class="px-4 pb-4">
                                <h6 class="textcolor fw-semibold fs-5">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting...
                                </h6>
                                <div class="d-flex justify-content-between fs-6 mt-2">
                                    <span class="yellowcolor view-more-underline">
                                        View More <img src={arrow} alt="" srcset="" />
                                    </span>
                                    <span>July 22’ 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center align-items-center pt-2">
                <button type="button" class="btn btnbg fw-semibold">
                    View All Upcoming Events
                </button>
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
                <div class="col-12 col-lg-6 mb-3 ">
                    <div class="gradient_rounded radies_20 m-2">
                        <div class="p-3 h-100 radies_20 blacklight">
                            <img src="{{ asset('images/funder1.png') }}" alt="Benefit 1" class="img-fluid mb-3" />
                            <div class="px-4 d-flex flex-column">
                                <h3 class="h5 textcolor">
                                    Cheryl Tan
                                </h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen book.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 mb-3 ">
                    <div class="gradient_rounded radies_20 m-2">
                        <div class="p-3 h-100 radies_20 blacklight">
                            <img src="{{ asset('images/funder2.png') }}" alt="Benefit 2" class="img-fluid mb-3" />
                            <div class="px-4 d-flex flex-column">
                                <h3 class="h5 textcolor">
                                    Dawn Tan
                                </h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and scrambled it to make a type specimen book.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center align-items-center pt-3">
                <button type="button" class="btn btnbg fw-semibold">
                    View All Member
                </button>
            </div>
        </div>
    </section>

    <section>
        <div class="container blackdark py-5 px-2 pt-2">
            <div class="pb-1">
                <div class="text-center">
                    <h2 class="text-center fw-bold fs-2">Our Coverage</h2>
                    <div class="underline mb-4 mx-auto">
                        <span class="move delay-0"></span>
                        <span class="move delay-1"></span>
                    </div>
                </div>
            </div>

            <div class="logos">
                <div class="logo_items" id="logoContainer">

                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Flag_of_Europe 1.png') }}" alt="logo-0" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Oceania_cruises_logo 2.png') }}" alt="logo-1" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/united-states 2.png') }}" alt="logo-2" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Flag_of_Europe 1.png') }}" alt="logo-0" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Oceania_cruises_logo 2.png') }}" alt="logo-1" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/united-states 2.png') }}" alt="logo-2" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Flag_of_Europe 1.png') }}" alt="logo-0" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/Oceania_cruises_logo 2.png') }}" alt="logo-1" />
                        </div>
                    </div>
                    <div class="gradient_rounded">
                        <div class="logo_slide">
                            <img src="{{ asset('images/united-states 2.png') }}" alt="logo-2" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class='newsletter_sec'>
        <div class='container'>
            <div class='newsletter'>
                <form> <input class='form-control  no-focus-style' type='text' />
                    <button class='btn btnbg fw-semibold'>Apply</button>
                </form>
            </div>
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
