@extends('layouts.app')

@section('title', 'My Bookings - Caravel')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>My Bookings</h1>
                    <p>Welcome back, {{ auth()->user()->name }}!</p>
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
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking #</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Days</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td><strong>{{ $booking->booking_number }}</strong></td>
                                        <td>
                                            {{ $booking->car->make ?? 'N/A' }} {{ $booking->car->model ?? '' }}<br>
                                            <small class="text-muted">{{ $booking->car->year ?? '' }}</small>
                                        </td>
                                        <td>{{ $booking->pickup_date->format('M d, Y') }}</td>
                                        <td>{{ $booking->return_date->format('M d, Y') }}</td>
                                        <td>{{ $booking->days }}</td>
                                        <td>৳{{ number_format($booking->final_amount * 110, 0) }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($booking->status) {
                                                    'active' => 'success',
                                                    'done' => 'info',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ $booking->status === 'active' ? 'Active' : 'Done' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $paymentClass = match($booking->payment_status) {
                                                    'pending' => 'warning',
                                                    'paid' => 'success',
                                                    'refunded' => 'info',
                                                    'failed' => 'danger',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $paymentClass }}">
                                                @if($booking->payment_status === 'pending' && $booking->payment_method === 'cash' && $booking->status === 'active')
                                                    Pay on Return
                                                @else
                                                    {{ ucfirst($booking->payment_status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-primary" title="View Details">
                                                    <i class="fa fa-eye"></i> View Details
                                                </a>
                                                @if($booking->status === 'active')
                                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to mark this booking as complete? This will finalize the service and process any pending payments.');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" title="Complete Service">
                                                            <i class="fa fa-check"></i> Complete Service
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-3x mb-3"></i>
                        <h4>No bookings yet</h4>
                        <p>You haven't made any bookings. Browse our available cars and make your first booking!</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary mt-3">
                            <i class="fa fa-car"></i> Browse Cars
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
