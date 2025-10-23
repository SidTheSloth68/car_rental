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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search">Search Cars</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Make, model, year...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="available">Availability</label>
                            <select class="form-control" id="available" name="available">
                                <option value="">All Cars</option>
                                <option value="1" {{ request('available') === '1' ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>Unavailable</option>
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
                            <img src="{{ asset('images/cars/' . $car->images[0]) }}" 
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
                            <span class="badge badge-{{ $car->is_available ? 'success' : 'danger' }}" id="status-badge-{{ $car->id }}">
                                {{ $car->is_available ? 'Available' : 'Unavailable' }}
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
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h5 text-success font-weight-bold">৳{{ number_format($car->daily_rate * 110, 0) }}</span>
                                    <small class="text-muted">/day</small>
                                </div>
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
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-warning" title="Edit Car">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-{{ $car->is_available ? 'secondary' : 'success' }}" 
                                        onclick="toggleAvailability({{ $car->id }})" 
                                        id="toggle-btn-{{ $car->id }}"
                                        title="{{ $car->is_available ? 'Mark Unavailable' : 'Mark Available' }}">
                                    <i class="fas fa-{{ $car->is_available ? 'pause' : 'play' }}" id="toggle-icon-{{ $car->id }}"></i>
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
                                    <option value="economy">Economy</option>
                                    <option value="compact">Compact</option>
                                    <option value="standard">Standard</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="full_size">Full Size</option>
                                    <option value="premium">Premium</option>
                                    <option value="luxury">Luxury</option>
                                    <option value="suv">SUV</option>
                                    <option value="minivan">Minivan</option>
                                    <option value="convertible">Convertible</option>
                                    <option value="sports_car">Sports Car</option>
                                    <option value="truck">Truck</option>
                                    <option value="van">Van</option>
                                    <option value="exotic">Exotic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="seats">Seats *</label>
                                <input type="number" class="form-control" id="seats" name="seats" 
                                       min="1" max="50" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="doors">Doors *</label>
                                <input type="number" class="form-control" id="doors" name="doors" 
                                       min="2" max="6" value="4" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="transmission">Transmission *</label>
                                <select class="form-control" id="transmission" name="transmission" required>
                                    <option value="">Select</option>
                                    <option value="manual">Manual</option>
                                    <option value="automatic">Automatic</option>
                                    <option value="cvt">CVT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="fuel_type">Fuel Type *</label>
                                <select class="form-control" id="fuel_type" name="fuel_type" required>
                                    <option value="">Select</option>
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="lpg">LPG</option>
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
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="image">Car Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Supported formats: JPG, PNG, GIF (Max: 2MB)</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="features">Features (comma-separated)</label>
                        <textarea class="form-control" id="features" name="features" rows="2" 
                                  placeholder="GPS, Bluetooth, Air Conditioning, USB Charging"></textarea>
                        <small class="text-muted">Separate each feature with a comma</small>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" checked>
                        <label class="form-check-label" for="is_available">
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
// Ensure Bootstrap is available
if (typeof bootstrap === 'undefined') {
    console.error('Bootstrap is not loaded!');
}

function viewCar(carId) {
    // Fetch car details via AJAX
    fetch(`/admin/cars/${carId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(car => {
            let featuresHtml = '';
            if (car.features && Array.isArray(car.features)) {
                featuresHtml = car.features.map(f => `<span class="badge bg-secondary me-1">${f}</span>`).join('');
            }
            
            let imageHtml = car.image 
                ? `<img src="/images/cars/${car.image}" class="img-fluid mb-3" style="max-height: 300px; object-fit: cover;">`
                : '<div class="text-muted">No image available</div>';

            const modalContent = `
                <div class="modal fade" id="viewCarModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${car.year} ${car.make} ${car.model}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${imageHtml}
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Basic Information</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Make:</strong></td><td>${car.make}</td></tr>
                                            <tr><td><strong>Model:</strong></td><td>${car.model}</td></tr>
                                            <tr><td><strong>Year:</strong></td><td>${car.year}</td></tr>
                                            <tr><td><strong>Type:</strong></td><td>${car.type}</td></tr>
                                            <tr><td><strong>Seats:</strong></td><td>${car.seats}</td></tr>
                                            <tr><td><strong>Doors:</strong></td><td>${car.doors}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Technical Details</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Transmission:</strong></td><td>${car.transmission}</td></tr>
                                            <tr><td><strong>Fuel Type:</strong></td><td>${car.fuel_type}</td></tr>
                                            <tr><td><strong>Daily Rate:</strong></td><td>$${car.daily_rate}</td></tr>
                                            <tr><td><strong>Status:</strong></td><td><span class="badge bg-${car.is_available ? 'success' : 'danger'}">${car.is_available ? 'Available' : 'Unavailable'}</span></td></tr>
                                        </table>
                                    </div>
                                </div>
                                ${car.description ? `<div class="mt-3"><h6>Description</h6><p>${car.description}</p></div>` : ''}
                                ${featuresHtml ? `<div class="mt-3"><h6>Features</h6><div>${featuresHtml}</div></div>` : ''}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="/admin/cars/${car.id}/edit" class="btn btn-primary">Edit Car</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('viewCarModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Append and show modal
            document.body.insertAdjacentHTML('beforeend', modalContent);
            const modalElement = document.getElementById('viewCarModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            // Clean up on close
            modalElement.addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load car details. Please try again.');
        });
}

function toggleAvailability(carId) {
    if (confirm('Are you sure you want to change the availability status of this car?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }

        fetch(`/admin/cars/${carId}/toggle-availability`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update badge
                const badge = document.getElementById(`status-badge-${carId}`);
                const toggleBtn = document.getElementById(`toggle-btn-${carId}`);
                const toggleIcon = document.getElementById(`toggle-icon-${carId}`);
                
                if (data.is_available) {
                    badge.className = 'badge badge-success';
                    badge.textContent = 'Available';
                    toggleBtn.className = 'btn btn-sm btn-secondary';
                    toggleBtn.title = 'Mark Unavailable';
                    toggleIcon.className = 'fas fa-pause';
                } else {
                    badge.className = 'badge badge-danger';
                    badge.textContent = 'Unavailable';
                    toggleBtn.className = 'btn btn-sm btn-success';
                    toggleBtn.title = 'Mark Available';
                    toggleIcon.className = 'fas fa-play';
                }
                
                // Show success message
                showAlert('success', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Failed to update availability. Please try again.');
        });
    }
}

function deleteCar(carId) {
    if (confirm('Are you sure you want to delete this car?\n\nThis action cannot be undone and will affect all related bookings.')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }

        fetch(`/admin/cars/${carId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Failed to delete car. Please try again.');
        });
    }
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.textContent.includes(message.substring(0, 20))) {
                alert.remove();
            }
        });
    }, 3000);
}

// Auto-submit form on filter changes
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const availableSelect = document.getElementById('available');
    const sortSelect = document.getElementById('sort');
    
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (availableSelect) {
        availableSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endsection