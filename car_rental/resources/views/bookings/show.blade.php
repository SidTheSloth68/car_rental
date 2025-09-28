@extends('layouts.app')

@section('title', 'Booking Details - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Booking Details</h1>
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
            <div class="col-lg-8">
                <!-- Booking Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Booking Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-calendar-check-o me-2"></i>Booking Confirmation
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary">Booking Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Booking Number:</td>
                                        <td>{{ $booking->booking_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Booking Date:</td>
                                        <td>{{ $booking->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Days:</td>
                                        <td>{{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary">Rental Period</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Pick-up:</td>
                                        <td>{{ $booking->pickup_date->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Return:</td>
                                        <td>{{ $booking->return_date->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Pick-up Location:</td>
                                        <td>{{ $booking->pickup_location }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Drop-off Location:</td>
                                        <td>{{ $booking->dropoff_location }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-user me-2"></i>Customer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ $booking->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td>{{ $booking->customer_email }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Phone:</td>
                                        <td>{{ $booking->customer_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">License Number:</td>
                                        <td>{{ $booking->license_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @if($booking->notes)
                            <div class="mt-3">
                                <h6 class="fw-bold">Special Requests:</h6>
                                <p class="text-muted">{{ $booking->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @auth
                    @if(auth()->id() === $booking->user_id)
                        <div class="mb-4">
                            @if($booking->status === 'pending')
                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary me-2">
                                    <i class="fa fa-edit"></i> Edit Booking
                                </a>
                                <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="fa fa-times"></i> Cancel Booking
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('dashboard.bookings') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-list"></i> View All Bookings
                            </a>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Vehicle Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-car me-2"></i>Vehicle Details
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($booking->car)
                            <div class="text-center mb-3">
                                <img src="{{ $booking->car->image_url }}" 
                                     alt="{{ $booking->car->full_name }}" 
                                     class="img-fluid rounded">
                            </div>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Vehicle:</td>
                                    <td>{{ $booking->car->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Type:</td>
                                    <td>{{ ucfirst($booking->car->type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transmission:</td>
                                    <td>{{ ucfirst($booking->car->transmission) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Fuel Type:</td>
                                    <td>{{ ucfirst($booking->car->fuel_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Seats:</td>
                                    <td>{{ $booking->car->seats }} passengers</td>
                                </tr>
                            </table>
                        @else
                            <p class="text-muted">Vehicle information not available</p>
                        @endif
                    </div>
                </div>

                <!-- Pricing Breakdown -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-calculator me-2"></i>Pricing Breakdown
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td>Daily Rate:</td>
                                <td class="text-end">${{ number_format($booking->daily_rate, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Duration:</td>
                                <td class="text-end">{{ $booking->days }} day{{ $booking->days > 1 ? 's' : '' }}</td>
                            </tr>
                            <tr>
                                <td>Subtotal:</td>
                                <td class="text-end">${{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                            @if($booking->discount_amount > 0)
                                <tr class="text-success">
                                    <td>Discount:</td>
                                    <td class="text-end">-${{ number_format($booking->discount_amount, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Tax (10%):</td>
                                <td class="text-end">${{ number_format($booking->tax_amount, 2) }}</td>
                            </tr>
                            <tr class="border-top fw-bold">
                                <td>Total Amount:</td>
                                <td class="text-end text-primary">${{ number_format($booking->final_amount, 2) }}</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Payment Status: 
                                <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection