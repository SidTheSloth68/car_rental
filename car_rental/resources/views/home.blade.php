@extends('layouts.app')

@section('title', $pageTitle ?? 'Home - Caravel Car Rental')
@section('description', 'Looking for a vehicle? You\'re at the right place. Premium car rental service with luxury and economy vehicles')

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="no-bottom no-top" id="content">
    <div id="top"></div>
    
    <!-- Hero Section Component -->
    <x-hero-section 
        title="Looking for a" 
        highlight="vehicle" 
        subtitle="? You're at the right place." 
    />

    <!-- Vehicle Types Marquee -->
    <section aria-label="section" class="pt40 pb40 text-light" data-bgcolor="#111111">
        <div class="wow fadeInRight d-flex">
            <div class="de-marquee-list">
                <div class="d-item">
                    <span class="d-item-txt">SUV</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Hatchback</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Crossover</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Convertible</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Sedan</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Sports Car</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Coupe</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Minivan</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Station Wagon</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Truck</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Minivans</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Exotic Cars</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                </div>
            </div>
            <div class="de-marquee-list">
                <div class="d-item">
                    <span class="d-item-txt">SUV</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Hatchback</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Crossover</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Convertible</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Sedan</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Sports Car</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Coupe</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Minivan</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Station Wagon</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Truck</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Minivans</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                    <span class="d-item-txt">Exotic Cars</span>
                    <span class="d-item-display"><i class="d-item-dot"></i></span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section aria-label="section" class="jarallax">
        <img src="{{ asset('images/background/3.jpg') }}" class="jarallax-img" alt="">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center mb-4">
                    <h2 class="text-light">How It Works</h2>
                    <p class="text-light">Rent a car in 4 simple steps</p>
                    <div class="spacer-20"></div>
                </div>
            </div>
            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0s">
                    <div class="de-step-box" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 15px; height: 100%;">
                        <div class="d-step-number" style="background: #8bc34a; color: white; width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 20px;">1</div>
                        <h4 class="text-light mb-3">Choose a vehicle</h4>
                        <p class="text-light" style="opacity: 0.9;">Unlock unparalleled adventures and memorable journeys with our vast fleet of vehicles tailored to suit every need, taste, and destination.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="de-step-box" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 15px; height: 100%;">
                        <div class="d-step-number" style="background: #8bc34a; color: white; width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 20px;">2</div>
                        <h4 class="text-light mb-3">Pick location & date</h4>
                        <p class="text-light" style="opacity: 0.9;">Pick your ideal location and date, and let us take you on a journey filled with convenience, flexibility, and unforgettable experiences.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.4s">
                    <div class="de-step-box" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 15px; height: 100%;">
                        <div class="d-step-number" style="background: #8bc34a; color: white; width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 20px;">3</div>
                        <h4 class="text-light mb-3">Make a booking</h4>
                        <p class="text-light" style="opacity: 0.9;">Secure your reservation with ease, unlocking a world of possibilities and embarking on your next adventure with confidence.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.6s">
                    <div class="de-step-box" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 15px; height: 100%;">
                        <div class="d-step-number" style="background: #8bc34a; color: white; width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; margin: 0 auto 20px;">4</div>
                        <h4 class="text-light mb-3">Sit back & relax</h4>
                        <p class="text-light" style="opacity: 0.9;">Hassle-free convenience as we take care of every detail, allowing you to unwind and embrace a journey filled with comfort.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Features Section -->
    <section aria-label="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2>Our Features</h2>
                    <p>Discover a world of convenience, safety, and customization, paving the way for unforgettable adventures and seamless mobility solutions.</p>
                    <div class="spacer-20"></div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-3">
                    <div class="box-icon s2 p-small mb20 wow fadeInRight" data-wow-delay=".5s">
                        <i class="fa bg-color fa-trophy"></i>
                        <div class="d-inner">
                            <h4>First class services</h4>
                            Where luxury meets exceptional care, creating unforgettable moments and exceeding your every expectation.
                        </div>
                    </div>
                    <div class="box-icon s2 p-small mb20 wow fadeInL fadeInRight" data-wow-delay=".75s">
                        <i class="fa bg-color fa-road"></i>
                        <div class="d-inner">
                            <h4>24/7 road assistance</h4>
                            Reliable support when you need it most, keeping you on the move with confidence and peace of mind.
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <img src="{{ asset('images/misc/car.png') }}" alt="" class="img-fluid wow fadeInUp">
                </div>

                <div class="col-lg-3">
                    <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1s">
                        <i class="fa bg-color fa-tag"></i>
                        <div class="d-inner">
                            <h4>Quality at Minimum Expense</h4>
                            Where affordability meets excellence, offering you the best value without compromising on quality or reliability.
                        </div>
                    </div>
                    <div class="box-icon s2 d-invert p-small mb20 wow fadeInL fadeInLeft" data-wow-delay="1.25s">
                        <i class="fa bg-color fa-map-pin"></i>
                        <div class="d-inner">
                            <h4>Free Pick-Up & Drop-Off</h4>
                            Enjoy free pickup and drop-off services, adding an extra layer of ease to your car rental experience.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="text-light jarallax">
        <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInRight">
                    <h2>We offer customers a wide range of <span class="id-color">commercial cars</span> and <span class="id-color">luxury cars</span> for any occasion.</h2>
                </div>
                <div class="col-lg-6 wow fadeInLeft">
                    At our car rental agency, we believe that everyone deserves to experience the pleasure of driving a reliable and comfortable vehicle, regardless of their budget. We have curated a diverse fleet of well-maintained cars, ranging from sleek sedans to spacious SUVs, all at competitive prices. With our streamlined rental process, you can quickly and conveniently reserve your desired vehicle. Whether you need transportation for a business trip, family vacation, or simply want to enjoy a weekend getaway, we have flexible rental options to accommodate your schedule.
                </div>
            </div>
            <div class="spacer-double"></div>
            <div class="row text-center">
                <div class="col-md-3 col-sm-6 mb-sm-30">
                    <div class="de_count transparent text-light wow fadeInUp">
                        <h3 class="timer" data-to="2500" data-speed="3000">0</h3>
                        Completed Orders
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-sm-30">
                    <div class="de_count transparent text-light wow fadeInUp">
                        <h3 class="timer" data-to="1850" data-speed="3000">0</h3>
                        Happy Customers
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-sm-30">
                    <div class="de_count transparent text-light wow fadeInUp">
                        <h3 class="timer" data-to="45" data-speed="3000">0</h3>
                        Vehicles Fleet
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-sm-30">
                    <div class="de_count transparent text-light wow fadeInUp">
                        <h3 class="timer" data-to="8" data-speed="3000">0</h3>
                        Years Experience
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicle Fleet Section -->
    <section id="section-cars">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2>Our Vehicle Fleet</h2>
                    <p>Driving your dreams to reality with an exquisite fleet of versatile vehicles for unforgettable journeys.</p>
                    <div class="spacer-20"></div>
                </div>

                <div id="items-carousel" class="owl-carousel wow fadeIn">
                    <!-- Car items will be dynamically populated -->
                    @if(isset($featuredCars) && count($featuredCars) > 0)
                        @foreach($featuredCars as $car)
                        <div class="col-lg-12">
                            <div class="de-item mb30">
                                <div class="d-img">
                                    <img src="{{ asset('images/cars/' . $car['image']) }}" class="img-fluid" alt="{{ $car['name'] }}">
                                </div>
                                <div class="d-info">
                                    <div class="d-text">
                                        <h4>{{ $car['name'] }}</h4>
                                        <div class="d-item_like">
                                            <i class="fa fa-heart"></i><span>{{ $car['likes'] }}</span>
                                        </div>
                                        <div class="d-atr-group">
                                            <ul class="d-atr">
                                                <li><span>Seats:</span>{{ $car['seats'] }}</li>
                                                <li><span>Luggage:</span>{{ $car['luggage'] }}</li>
                                                <li><span>Doors:</span>{{ $car['doors'] }}</li>
                                                <li><span>Fuel:</span>{{ $car['fuel'] }}</li>
                                            </ul>
                                        </div>
                                        <div class="d-price">
                                            Daily rate from <span>৳{{ number_format($car['price'] * 110, 0) }}</span>
                                            <a class="btn-main" href="{{ route('booking.create.car', $car['id']) }}">Rent Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Default car items for now -->
                        <div class="col-lg-12">
                            <div class="de-item mb30">
                                <div class="d-img">
                                    <img src="{{ asset('images/cars/jeep-renegade.jpg') }}" class="img-fluid" alt="Jeep Renegade">
                                </div>
                                <div class="d-info">
                                    <div class="d-text">
                                        <h4>Jeep Renegade</h4>
                                        <div class="d-item_like">
                                            <i class="fa fa-heart"></i><span>74</span>
                                        </div>
                                        <div class="d-atr-group">
                                            <ul class="d-atr">
                                                <li><span>Seats:</span>4</li>
                                                <li><span>Luggage:</span>2</li>
                                                <li><span>Doors:</span>4</li>
                                                <li><span>Fuel:</span>Petrol</li>
                                            </ul>
                                        </div>
                                        <div class="d-price">
                                            Daily rate from <span>৳29,150</span>
                                            <a class="btn-main" href="{{ route('cars.index') }}">Rent Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Adventure Section -->
    <section class="text-light jarallax" aria-label="section">
        <img src="{{ asset('images/background/3.jpg') }}" alt="" class="jarallax-img">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Let's Your Adventure Begin</h1>
                    <div class="spacer-20"></div>
                </div>
                <div class="col-md-3">
                    <i class="fa fa-trophy de-icon mb20"></i>
                    <h4>First Class Services</h4>
                    <p>Where luxury meets exceptional care, creating unforgettable moments and exceeding your every expectation.</p>
                </div>
                <div class="col-md-3">
                    <i class="fa fa-road de-icon mb20"></i>
                    <h4>24/7 road assistance</h4>
                    <p>Reliable support when you need it most, keeping you on the move with confidence and peace of mind.</p>
                </div>
                <div class="col-md-3">
                    <i class="fa fa-map-pin de-icon mb20"></i>
                    <h4>Free Pick-Up & Drop-Off</h4>
                    <p>Enjoy free pickup and drop-off services, adding an extra layer of ease to your car rental experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="section-news">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h2>Latest News</h2>
                    <p>Breaking news, fresh perspectives, and in-depth coverage - stay ahead with our latest news, insights, and analysis.</p>
                    <div class="spacer-20"></div>
                </div>
                
                @if(isset($latestNews) && count($latestNews) > 0)
                    @foreach($latestNews as $news)
                    <div class="col-lg-4 mb10">
                        <div class="bloglist s2 item">
                            <div class="post-content">
                                <div class="post-image">
                                    <img alt="{{ $news['title'] }}" src="{{ asset($news['image']) }}" class="lazy">
                                </div>
                                <div class="post-text">
                                    <span class="p-tagline">{{ $news['category'] }}</span>
                                    <span class="p-date">{{ $news['date'] }}</span>
                                    <h4><a href="{{ route('news.show', $news['slug']) }}">{{ $news['title'] }}</a></h4>
                                    <p>{{ $news['excerpt'] }}</p>
                                    <a class="btn-main" href="{{ route('news.show', $news['slug']) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Default news items -->
                    <div class="col-lg-4 mb10">
                        <div class="bloglist s2 item">
                            <div class="post-content">
                                <div class="post-image">
                                    <img alt="" src="{{ asset('images/news/pic-blog-1.jpg') }}" class="lazy">
                                </div>
                                <div class="post-text">
                                    <span class="p-tagline">Tips</span>
                                    <span class="p-date">25 Jan 2022</span>
                                    <h4><a href="#">5 Tips for Your First Car Rental</a></h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- View All News Button -->
            <div class="row mt-4">
                <div class="col-lg-12 text-center">
                    <a class="btn-main" href="{{ route('news.index') }}">View All News</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="section-testimonials" class="no-top no-bottom">
        <div class="container-fluid">
            <div class="row g-2 p-2 align-items-center">
                @if(isset($testimonials) && count($testimonials) > 0)
                    @foreach($testimonials as $testimonial)
                    <div class="col-md-4">
                        <div class="de-image-text">
                            <div class="d-text">
                                <div class="d-quote id-color"><i class="fa fa-quote-right"></i></div>
                                <h4>{{ $testimonial['title'] }}</h4>
                                <blockquote>{{ $testimonial['quote'] }}</blockquote>
                                <div class="d-name"><strong>{{ $testimonial['name'] }}</strong></div>
                            </div> 
                            <img src="{{ asset('images/testimonial/' . $testimonial['image']) }}" class="img-fluid" alt="{{ $testimonial['name'] }}">
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Default testimonials -->
                    <div class="col-md-4">
                        <div class="de-image-text">
                            <div class="d-text">
                                <div class="d-quote id-color"><i class="fa fa-quote-right"></i></div>
                                <h4>Excellent Service</h4>
                                <blockquote>I have been using Caravel for my car rental needs for over 5 years now. I have never had any problems and their customer service is excellent.</blockquote>
                                <div class="d-name"><strong>Jason Stattham</strong></div>
                            </div> 
                            <img src="{{ asset('images/testimonial/1.jpg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="section-faq">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Have Any Questions?</h2>
                    <div class="spacer-20"></div>
                </div>
            </div>
            <div class="row g-custom-x">
                <div class="col-md-6 wow fadeInUp">
                    <div class="accordion secondary">
                        @if(isset($faqs) && count($faqs) > 0)
                            @foreach($faqs->take(3) as $index => $faq)
                            <div class="accordion-section">
                                <div class="accordion-section-title" data-tab="#accordion-{{ $index + 1 }}">
                                    {{ $faq['question'] }}
                                </div>
                                <div class="accordion-section-content" id="accordion-{{ $index + 1 }}">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Default FAQ -->
                            <div class="accordion-section">
                                <div class="accordion-section-title" data-tab="#accordion-1">
                                    What is the minimum age requirement for renting a car?
                                </div>
                                <div class="accordion-section-content" id="accordion-1">
                                    <p>The minimum age for renting a car is typically 21 years old. However, additional fees may apply for drivers under 25.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6 wow fadeInUp">
                    <div class="accordion secondary">
                        @if(isset($faqs) && count($faqs) > 3)
                            @foreach($faqs->skip(3)->take(3) as $index => $faq)
                            <div class="accordion-section">
                                <div class="accordion-section-title" data-tab="#accordion-{{ $index + 4 }}">
                                    {{ $faq['question'] }}
                                </div>
                                <div class="accordion-section-content" id="accordion-{{ $index + 4 }}">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- Default FAQ -->
                            <div class="accordion-section">
                                <div class="accordion-section-title" data-tab="#accordion-4">
                                    Do I need a credit card to rent a car?
                                </div>
                                <div class="accordion-section-content" id="accordion-4">
                                    <p>Yes, a valid credit card in the main driver's name is required for all car rentals for security deposit purposes.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section id="section-call-to-action" class="bg-color-2 pt60 pb60 text-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-2">
                    <span class="subtitle text-white">Call us for further information</span>
                    <h2 class="s2">Caravel customer care is here to help you anytime.</h2>
                </div>
                <div class="col-lg-4 text-lg-center text-sm-center">
                    <div class="phone-num-big">
                        <i class="fa fa-phone"></i>
                        <span class="pnb-text">Call Now</span>
                        <span class="pnb-num">1 200 333 800</span>
                    </div>
                    <a href="#" class="btn-main">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Admin Quick Access (only visible to admins) -->
    @auth
        @if(auth()->user()->role === 'admin')
        <section aria-label="admin-access" class="pt20 pb20" data-bgcolor="#f8f9fa">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="alert alert-info d-inline-flex align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white;">
                                <i class="fa fa-user-shield fa-lg me-3"></i>
                                <div>
                                    <strong>Welcome Admin!</strong> 
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm ms-3">
                                        <i class="fa fa-cog"></i> Access Admin Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    @endauth
</div>

<!-- Back to top -->
<a href="#" id="back-to-top"></a>
@endsection

@push('scripts')
<script>
// Initialize Google Maps if needed
function initialize() {
    // Google Maps initialization will be added later
    console.log('Page initialized');
}
</script>
@endpush