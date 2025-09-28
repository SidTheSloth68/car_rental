@extends('layouts.app')

@section('title', 'My Bookings - Rentaly')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>My Bookings</h1>
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
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>My Bookings</h2>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Booking
                    </a>
                </div>

                @if($bookings->count() > 0)
                    <div class="row">
                        @foreach($bookings as $booking)
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2">
                                                @if($booking->car)
                                                    <img src="{{ $booking->car->image_url }}" 
                                                         alt="{{ $booking->car->full_name }}" 
                                                         class="img-fluid rounded">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                                        <i class="fa fa-car fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="card-title">
                                                    {{ $booking->car ? $booking->car->full_name : 'Vehicle Not Available' }}
                                                </h5>
                                                <p class="card-text">
                                                    <strong>Booking #:</strong> {{ $booking->booking_number }}<br>
                                                    <strong>Pick-up:</strong> {{ $booking->pickup_date->format('M d, Y h:i A') }}<br>
                                                    <strong>Return:</strong> {{ $booking->return_date->format('M d, Y h:i A') }}<br>
                                                    <strong>Location:</strong> {{ $booking->pickup_location }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 text-center">
                                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                                <div class="mt-2">
                                                    <strong>${{ number_format($booking->final_amount, 2) }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 text-end">
                                                <div class="btn-group-vertical" role="group">
                                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary mb-1">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    @if($booking->status === 'pending')
                                                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-secondary mb-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-calendar-times-o fa-5x text-muted mb-3"></i>
                        <h3>No Bookings Found</h3>
                        <p class="text-muted">You haven't made any bookings yet. Start by browsing our available vehicles.</p>
                        <a href="{{ route('booking.create') }}" class="btn btn-primary me-2">
                            <i class="fa fa-plus"></i> Make a Booking
                        </a>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-car"></i> Browse Cars
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection