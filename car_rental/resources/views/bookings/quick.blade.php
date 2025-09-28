@extends('layouts.app')

@section('title', 'Quick Booking - Rentaly')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Quick Booking</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section id="section-hero" aria-label="section" class="no-top" data-bgcolor="#121212">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 mt-80 sm-mt-0">
                <div class="spacer-single sm-hide"></div>
                
                <!-- Quick Booking Component -->
                <x-quick-booking :cars="$cars" />
                
                <div class="spacer-double"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="section-features" class="pt-4 pb-4" data-bgcolor="#f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-4">
                <h3>Why Choose Quick Booking?</h3>
                <p class="lead">Fast, simple, and secure car rental reservations</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-box text-center">
                    <i class="fa fa-bolt fa-3x text-primary mb-3"></i>
                    <h4>Lightning Fast</h4>
                    <p>Book your car in less than 2 minutes with our streamlined process.</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-box text-center">
                    <i class="fa fa-shield fa-3x text-success mb-3"></i>
                    <h4>Secure & Safe</h4>
                    <p>Your personal information is protected with bank-level security.</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-box text-center">
                    <i class="fa fa-phone fa-3x text-info mb-3"></i>
                    <h4>24/7 Support</h4>
                    <p>Our customer service team is available around the clock to help you.</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="feature-box text-center">
                    <i class="fa fa-check-circle fa-3x text-warning mb-3"></i>
                    <h4>Instant Confirmation</h4>
                    <p>Get immediate booking confirmation and rental details via email.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection