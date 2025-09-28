@extends('layouts.app')

@section('title', 'Contact Us - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Contact Us</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-3">Get in Touch</h2>
                <p class="lead">Have questions, need help, or want to give feedback? Our team is here to assist you 24/7. Fill out the form or use the contact details below.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fa fa-phone text-primary me-2"></i> <strong>Phone:</strong> +208 333 9296</li>
                    <li class="mb-2"><i class="fa fa-envelope text-primary me-2"></i> <strong>Email:</strong> contact@caravel.com</li>
                    <li class="mb-2"><i class="fa fa-map-marker text-primary me-2"></i> <strong>Address:</strong> 123 Main Street, New York, NY</li>
                </ul>
                <div class="social-icons mt-3">
                    <a href="#" class="me-2"><i class="fa fa-facebook fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fa fa-youtube fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fa fa-pinterest fa-lg"></i></a>
                    <a href="#" class="me-2"><i class="fa fa-instagram fa-lg"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-3">Contact Form</h4>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection