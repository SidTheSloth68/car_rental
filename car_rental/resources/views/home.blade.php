@extends('layouts.app')

@section('title', 'Home - Caravel Car Rental')
@section('description', 'Welcome to Caravel - Premium car rental service with luxury and economy vehicles')

@section('content')
<div class="container-fluid">
    <!-- Hero Section Placeholder -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 text-white mb-4">Welcome to Caravel</h1>
                    <p class="lead text-white mb-5">Premium Car Rental Service - Your Journey Starts Here</p>
                    
                    <!-- Temporary car search form placeholder -->
                    <div class="card p-4">
                        <h4>Find Your Perfect Car</h4>
                        <p class="text-muted">Car search functionality will be implemented in upcoming commits</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section Placeholder -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Why Choose Caravel?</h2>
                    <p class="lead">More features and content will be added in subsequent commits</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/background/1.jpg') }}') center/cover;
        min-height: 100vh;
    }
</style>
@endpush