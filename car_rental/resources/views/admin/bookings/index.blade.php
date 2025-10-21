@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manage Bookings</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_number }}</td>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->car->make }} {{ $booking->car->model }}</td>
                                    <td>{{ $booking->pickup_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->return_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>৳{{ number_format($booking->final_amount * 110, 0) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">View</a>
                                            @if($booking->status === 'pending')
                                                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No bookings found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $bookings->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection