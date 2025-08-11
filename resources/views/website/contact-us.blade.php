@extends('layouts.website')

@section('title', 'Contact Us - Fr8nity')

@section('content')
<section>
        <div class="container blackbg">
            <div class="row">
                <!-- Left Column -->
                <div class="col-12 col-md-6 mb-4 d-flex justify-content-center flex-column text-center text-md-start">
                    <div>
                        <h1 class="fw-bold size text_image pt-5 pt-lg-0">
                            Contact Us
                        </h1>
                        <p class="bannerp">Lorem ipsum dolor sit amet consectetur.</p>
            
                    </div>
                </div>
                <!-- Right Column (Video) -->
                <div class="col-12 col-md-6 mb-md-3 r">
                    <video src="./images/bannervideo.mp4" autoplay muted loop playsinline class="w-100"></video>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row p-0 align-items-stretch">
                <!-- Left Panel -->

                <div class="col-12 col-lg-4 mb-4 mb-lg-0 d-flex">
                    <div class="w-100 radies_20 d-flex flex-column ">


                        <div class="gradient_rounded radies_20 ">
                            <div class=" col-12 blacklight radies_20 p-4 ">
                                <img src="./images/footerlocation.svg" alt="Location icon" class="mb-2" />
                                <h4>Visit Us</h4>
                                <p class="mb-0">401 Broadway, 24th floor <br> Orchard view, London</p>
                            </div>



                        </div>
                        <div class="gradient_rounded radies_20 mt-4">
                            <div class=" col-12 blacklight radies_20 p-4">
                                <img src="./images/footerphn.svg" alt="Phone icon" class="mb-2" />
                                <h4>Booking on call</h4>
                                <p class="mb-0">Phone : 0123456789</p>
                                <p class="mb-0">Fax : 0123456789</p>
                            </div>
                        </div>
                        <div class="gradient_rounded radies_20 mt-4">
                            <div class=" col-12 blacklight radies_20 p-4">
                                <img src="./images/footermessage.svg" alt="Message icon" class="mb-2" />
                                <h4>Send us message</h4>
                                <p class="mb-0">contact@example.com</p>
                                <p class="mb-0">contact@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Panel (Form) -->
                <div class="col-12 col-lg-8 d-flex">

                    <div class="radies_20">
                        <div class="w-100 blacklight p-4 radies_20 d-flex flex-column" style="border: 1px solid #b58320;">
                            <h2 class="mb-4">How we can help you?</h2>
                            <form class="flex-grow-1 d-flex flex-column justify-content-between">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="name">Name*</label>
                                        <input type="text" class="form-control mb-3 rounded-30" id="name" name="name"
                                            placeholder="Name*" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="email">Email*</label>
                                        <input type="email" class="form-control mb-3 rounded-30" id="email" name="email"
                                            placeholder="Email*" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="subject">Subject*</label>
                                        <input type="text" class="form-control mb-3 rounded-30" id="subject"
                                            name="subject" placeholder="Subject*" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="phone">Phone Number*</label>
                                        <input type="tel" class="form-control mb-3 rounded-30" id="phone" name="phone"
                                            placeholder="Phone Number*" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="message">Message*</label>
                                        <textarea class="form-control mb-3 rounded-30" id="message" name="message"
                                            rows="4" placeholder="Message*" required></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btnbg">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-100 blackdark pt-5">
        <div class="contactmap">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193571.43894430257!2d-74.11808677447197!3d40.705825440897226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c250b3f0874b3f%3A0x6d7926d86d730b45!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1721799999999!5m2!1sen!2sin"
                width="100%" height="100%"  class="border-0"allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>
@endsection 