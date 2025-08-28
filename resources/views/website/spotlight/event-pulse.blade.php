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


        <div class="row mx-auto">
            <div class="gradient_rounded radies_20 mb-3">
                <div class="col-12 radies_20 blacklight">
                    <div class="row align-items-center  px-1 px-lg-3  py-2 py-lg-0 ">

                        <div class="col-4 col-lg-2 mx-0 mb-3 mb-lg-0 py-3">
                            <div class="event_img">
                                <img src="{{ asset('images/our_story.jpg') }}" alt="Event Image" class="img-fluid rounded">
                            </div>
                        </div>


                        <div class="col-8 ">
                            <p class="fs-6 mb-0">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit...
                            </p>
                        </div>


                        <div class="col-12 col-md-2 text-md-end text-center mt-3 mt-md-0">
                            <a href="{{ route('spotlight.event-pulse.detail') }}" class="btn btnbg fe-semibold">Read More</a>
                        </div>

                    </div>
                </div>
            </div>



        </div>

<div class="row justify-content-center align-items-center mx-0 py-5" bis_skin_checked="1">
            <button type="button" class="btn btnbg fw-semibold">
              See More Events
            </button>
        </div>




    </div>

@endsection