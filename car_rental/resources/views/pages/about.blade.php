@extends('layouts.app')

@section('title', 'About Us - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>About Us</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('images/about/about-main.jpg') }}" class="img-fluid rounded shadow" alt="About Caravel">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-3">Welcome to Caravel</h2>
                <p class="lead">Caravel is your trusted partner for car rentals, offering a wide range of vehicles to suit every journey, taste, and budget. Whether you're planning a weekend getaway, a business trip, or a family vacation, we have the perfect car for you.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Wide selection of cars, SUVs, vans, and luxury vehicles</li>
                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Competitive pricing and transparent rates</li>
                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i>24/7 customer support and roadside assistance</li>
                    <li class="mb-2"><i class="fa fa-check text-success me-2"></i>Easy online booking and flexible rental terms</li>
                </ul>
                <p>Our mission is to make your rental experience smooth, enjoyable, and hassle-free. We pride ourselves on our commitment to customer satisfaction and our passion for helping you explore new destinations with confidence.</p>
                <a href="{{ route('contact.show') }}" class="btn btn-primary mt-3"><i class="fa fa-envelope"></i> Contact Us</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-light pt-5 pb-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <i class="fa fa-car fa-3x text-primary mb-2"></i>
                <h4>1000+ Vehicles</h4>
                <p>Choose from a huge fleet of well-maintained vehicles for every need.</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fa fa-users fa-3x text-success mb-2"></i>
                <h4>10,000+ Happy Customers</h4>
                <p>We are proud to serve thousands of satisfied customers every year.</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fa fa-globe fa-3x text-info mb-2"></i>
                <h4>Multiple Locations</h4>
                <p>Convenient pick-up and drop-off points in major cities and airports.</p>
            </div>
            <div class="col-md-3 mb-4">
                <i class="fa fa-star fa-3x text-warning mb-2"></i>
                <h4>Top Rated Service</h4>
                <p>Our commitment to quality and service excellence sets us apart.</p>
            </div>
        </div>
    </div>
</section>
@endsection