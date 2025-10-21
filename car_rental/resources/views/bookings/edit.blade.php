@extends('layouts.app')

@section('title', 'Edit Booking - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Edit Booking</h1>
                    <p class="lead">Booking #{{ $booking->booking_number }}</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section class="no-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6><i class="fa fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fa fa-edit"></i> Edit Booking Details</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bookings.update', $booking) }}">
                            @csrf
                            @method('PATCH')

                            <!-- Car Information (Read-only) -->
                            <div class="mb-4">
                                <h5><i class="fa fa-car"></i> Vehicle</h5>
                                <div class="alert alert-info">
                                    <strong>{{ $booking->car->make }} {{ $booking->car->model }}</strong> ({{ $booking->car->year }})
                                    <br><small>Daily Rate: ৳{{ number_format($booking->car->daily_rate * 110, 0) }}</small>
                                </div>
                            </div>

                            <!-- Location Details -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pickup Location <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="pickup_location" 
                                           class="form-control @error('pickup_location') is-invalid @enderror" 
                                           value="{{ old('pickup_location', $booking->pickup_location) }}"
                                           required>
                                    @error('pickup_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Drop-off Location <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="dropoff_location" 
                                           class="form-control @error('dropoff_location') is-invalid @enderror" 
                                           value="{{ old('dropoff_location', $booking->dropoff_location) }}"
                                           required>
                                    @error('dropoff_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date & Time Details -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pickup Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           name="pickup_date" 
                                           class="form-control @error('pickup_date') is-invalid @enderror" 
                                           value="{{ old('pickup_date', $booking->pickup_date->format('Y-m-d\TH:i')) }}"
                                           min="{{ now()->format('Y-m-d\TH:i') }}"
                                           required>
                                    @error('pickup_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Return Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           name="return_date" 
                                           class="form-control @error('return_date') is-invalid @enderror" 
                                           value="{{ old('return_date', $booking->return_date->format('Y-m-d\TH:i')) }}"
                                           min="{{ now()->format('Y-m-d\TH:i') }}"
                                           required>
                                    @error('return_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Customer Details -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="customer_name" 
                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                           value="{{ old('customer_name', $booking->customer_name) }}"
                                           required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           name="customer_email" 
                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                           value="{{ old('customer_email', $booking->customer_email) }}"
                                           required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                           name="customer_phone" 
                                           class="form-control @error('customer_phone') is-invalid @enderror" 
                                           value="{{ old('customer_phone', $booking->customer_phone) }}"
                                           required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" 
                                           name="customer_address" 
                                           class="form-control @error('customer_address') is-invalid @enderror" 
                                           value="{{ old('customer_address', $booking->customer_address) }}">
                                    @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Special Requirements -->
                            <div class="mb-3">
                                <label class="form-label">Special Requirements</label>
                                <textarea name="special_requirements" 
                                          class="form-control @error('special_requirements') is-invalid @enderror" 
                                          rows="3">{{ old('special_requirements', $booking->special_requirements) }}</textarea>
                                @error('special_requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
