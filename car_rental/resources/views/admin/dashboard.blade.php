@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-none d-lg-block small text-muted">
            Last updated: {{ now()->format('M d, Y - g:i A') }}
        </div>
    </div>

    <!-- Content Row - Statistics Cards -->
    <div class="row">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <span class="text-success">{{ $stats['total_customers'] }}</span> customers, 
                        <span class="text-info">{{ $stats['total_admins'] }}</span> admins
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Cars</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_cars']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <span class="text-success">{{ $stats['available_cars'] }}</span> available
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_bookings']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <span class="text-warning">{{ $stats['pending_bookings'] }}</span> pending, 
                        <span class="text-success">{{ $stats['confirmed_bookings'] }}</span> confirmed
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">৳{{ number_format($revenue_stats['total_revenue'] * 110, 0) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bangladeshi-taka-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        This month: <span class="text-success">৳{{ number_format($revenue_stats['monthly_revenue'] * 110, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Recent Activities -->
    <div class="row">
        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse($recent_users as $user)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="mr-3">
                                <div class="icon-circle bg-{{ $user->role === 'admin' ? 'success' : 'primary' }}">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                                <div class="text-muted small">
                                    <span class="badge badge-{{ $user->role === 'admin' ? 'success' : 'primary' }}">{{ ucfirst($user->role) }}</span>
                                    - {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No users found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Cars -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">Recent Cars</h6>
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-success">View All</a>
                </div>
                <div class="card-body">
                    @forelse($recent_cars as $car)
                        @if($car)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-car text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $car->make ?? 'Unknown' }} {{ $car->model ?? '' }}</div>
                                <div class="text-muted small">{{ $car->year ?? 'N/A' }} - {{ $car->type ? ucfirst($car->type) : 'N/A' }}</div>
                                <div class="text-muted small">
                                    ৳{{ $car->daily_rate ? number_format($car->daily_rate * 110, 0) : '0' }}/day - 
                                    <span class="badge badge-{{ $car->is_available ? 'success' : 'danger' }}">
                                        {{ $car->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <p class="text-muted">No cars found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Recent Bookings & News -->
    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Recent Bookings</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->reference_number ?? '#' . $booking->id }}</td>
                                        <td>{{ $booking->user->name ?? $booking->customer_name }}</td>
                                        <td>{{ $booking->car->make ?? 'N/A' }} {{ $booking->car->model ?? '' }}</td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $booking->status === 'confirmed' ? 'success' : 
                                                ($booking->status === 'pending' ? 'warning' : 'secondary') 
                                            }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>৳{{ number_format($booking->final_amount ?? 0 * 110, 0) }}</td>
                                        <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No bookings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Summary -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Content Management</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total Articles</span>
                            <span class="font-weight-bold">{{ $stats['total_news'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Published</span>
                            <span class="font-weight-bold text-success">{{ $stats['published_news'] }}</span>
                        </div>
                    </div>
                    
                    <h6 class="font-weight-bold">Recent Articles:</h6>
                    @forelse($recent_news->take(3) as $article)
                        <div class="py-2 border-bottom">
                            <div class="font-weight-bold text-sm">{{ Str::limit($article->title, 40) }}</div>
                            <div class="text-muted small">
                                {{ $article->created_at->format('M d, Y') }} - 
                                <span class="badge badge-{{ $article->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">No articles found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endsection