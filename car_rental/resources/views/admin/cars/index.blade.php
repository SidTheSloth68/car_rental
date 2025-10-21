@extends('layouts.admin')

@section('title', 'Cars Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cars Management</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCarModal">
            <i class="fas fa-plus fa-sm"></i> Add New Car
        </button>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Search & Filter</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cars.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search Cars</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Make, model, year...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="sedan" {{ request('type') === 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ request('type') === 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="hatchback" {{ request('type') === 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="coupe" {{ request('type') === 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="convertible" {{ request('type') === 'convertible' ? 'selected' : '' }}>Convertible</option>
                                <option value="truck" {{ request('type') === 'truck' ? 'selected' : '' }}>Truck</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="available">Availability</label>
                            <select class="form-control" id="available" name="available">
                                <option value="">All Cars</option>
                                <option value="1" {{ request('available') === '1' ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sort">Sort By</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Latest</option>
                                <option value="make" {{ request('sort') === 'make' ? 'selected' : '' }}>Make</option>
                                <option value="daily_rate" {{ request('sort') === 'daily_rate' ? 'selected' : '' }}>Price (Low to High)</option>
                                <option value="daily_rate_desc" {{ request('sort') === 'daily_rate_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                <option value="year" {{ request('sort') === 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Cars Grid -->
    <div class="row">
        @forelse($cars as $car)
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-img-container" style="height: 200px; overflow: hidden;">
                        @if($car->images && is_array($car->images) && count($car->images) > 0)
                            <img src="{{ asset('storage/' . $car->images[0]) }}" 
                                 class="card-img-top" 
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 alt="{{ $car->make }} {{ $car->model }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="fas fa-car fa-3x text-gray-300"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="position-absolute" style="top: 10px; right: 10px;">
                            <span class="badge badge-{{ $car->available ? 'success' : 'danger' }}">
                                {{ $car->available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <h5 class="card-title mb-1">{{ $car->make }} {{ $car->model }}</h5>
                            <small class="text-muted">{{ $car->year }} • {{ ucfirst($car->type) }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <div class="row text-sm">
                                <div class="col-6">
                                    <i class="fas fa-users text-gray-400"></i> {{ $car->seats }} seats
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-cog text-gray-400"></i> {{ ucfirst($car->transmission) }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-gas-pump text-gray-400"></i> {{ ucfirst($car->fuel_type) }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-tachometer-alt text-gray-400"></i> {{ number_format($car->mileage) }} mi
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h5 text-success font-weight-bold">৳{{ number_format($car->daily_rate * 110, 0) }}</span>
                                    <small class="text-muted">/day</small>
                                </div>
                                @if($car->license_plate)
                                    <small class="text-muted">{{ $car->license_plate }}</small>
                                @endif
                            </div>
                        </div>
                        
                        @if($car->description)
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($car->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="mt-auto">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-sm btn-info" 
                                        onclick="viewCar({{ $car->id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" 
                                        onclick="editCar({{ $car->id }})" title="Edit Car">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-{{ $car->available ? 'secondary' : 'success' }}" 
                                        onclick="toggleAvailability({{ $car->id }}, {{ $car->available ? 'false' : 'true' }})" 
                                        title="{{ $car->available ? 'Mark Unavailable' : 'Mark Available' }}">
                                    <i class="fas fa-{{ $car->available ? 'pause' : 'play' }}"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="deleteCar({{ $car->id }})" title="Delete Car">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-car fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">No cars found</h5>
                        <p class="text-muted">No cars match your current search criteria.</p>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-primary">Show All Cars</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($cars->hasPages())
        <div class="d-flex justify-content-center">
            {{ $cars->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Create Car Modal -->
<div class="modal fade" id="createCarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Car</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="make">Make *</label>
                                <input type="text" class="form-control" id="make" name="make" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="model">Model *</label>
                                <input type="text" class="form-control" id="model" name="model" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="year">Year *</label>
                                <input type="number" class="form-control" id="year" name="year" 
                                       min="1990" max="{{ date('Y') + 1 }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="type">Type *</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="suv">SUV</option>
                                    <option value="hatchback">Hatchback</option>
                                    <option value="coupe">Coupe</option>
                                    <option value="convertible">Convertible</option>
                                    <option value="truck">Truck</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="seats">Seats *</label>
                                <input type="number" class="form-control" id="seats" name="seats" 
                                       min="1" max="12" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="transmission">Transmission *</label>
                                <select class="form-control" id="transmission" name="transmission" required>
                                    <option value="">Select Transmission</option>
                                    <option value="manual">Manual</option>
                                    <option value="automatic">Automatic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="fuel_type">Fuel Type *</label>
                                <select class="form-control" id="fuel_type" name="fuel_type" required>
                                    <option value="">Select Fuel Type</option>
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="daily_rate">Daily Rate ($) *</label>
                                <input type="number" class="form-control" id="daily_rate" name="daily_rate" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="mileage">Mileage</label>
                                <input type="number" class="form-control" id="mileage" name="mileage" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="license_plate">License Plate</label>
                                <input type="text" class="form-control" id="license_plate" name="license_plate">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="images">Car Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" 
                               multiple accept="image/*">
                        <small class="text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF</small>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="available" name="available" value="1" checked>
                        <label class="form-check-label" for="available">
                            Available for rent
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Car</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewCar(carId) {
    alert('View car details for car ID: ' + carId + '\n\nThis feature will show detailed car information including all images, specifications, booking history, and maintenance records.');
}

function editCar(carId) {
    alert('Edit car for car ID: ' + carId + '\n\nThis feature will allow you to modify car information, pricing, availability, and images.');
}

function toggleAvailability(carId, newStatus) {
    const action = newStatus === 'true' ? 'mark as available' : 'mark as unavailable';
    if (confirm('Are you sure you want to ' + action + ' this car?')) {
        alert('Toggle availability for car ID: ' + carId + ' to: ' + newStatus + '\n\nThis feature will update the car availability status.');
    }
}

function deleteCar(carId) {
    if (confirm('Are you sure you want to delete this car?\n\nThis action cannot be undone and will also cancel all future bookings for this car.')) {
        alert('Delete car ID: ' + carId + '\n\nCar deletion functionality would be implemented here with proper confirmation and booking cleanup.');
    }
}

// Auto-submit form on filter changes
document.getElementById('type').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('available').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection