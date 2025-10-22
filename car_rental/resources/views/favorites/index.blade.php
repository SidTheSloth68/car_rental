@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 fw-bold mb-2">My Favorite Cars</h1>
            <p class="text-muted">Cars you've marked as favorites</p>
        </div>
    </div>

    @if($favorites->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-heart fa-3x mb-3 text-muted"></i>
                    <h4>No Favorites Yet</h4>
                    <p>Start adding cars to your favorites to see them here!</p>
                    <a href="{{ route('cars.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-car me-2"></i>Browse Cars
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($favorites as $car)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        @if($car->image)
                            <img src="{{ asset('images/cars/' . $car->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $car->make }} {{ $car->model }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-car fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $car->make }} {{ $car->model }}</h5>
                                <button class="btn btn-sm btn-danger remove-favorite" 
                                        data-car-id="{{ $car->id }}"
                                        title="Remove from favorites">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            
                            <p class="text-muted mb-2">{{ $car->year }}</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ ucfirst($car->type) }}</span>
                                <span class="badge bg-info">{{ ucfirst($car->transmission) }}</span>
                                @if($car->is_available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-secondary">Not Available</span>
                                @endif
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-users text-muted me-2"></i>
                                <small>{{ $car->seats }} Seats</small>
                                <i class="fas fa-suitcase text-muted ms-3 me-2"></i>
                                <small>{{ $car->doors }} Doors</small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-primary mb-0">৳{{ number_format($car->daily_rate, 2) }}</h4>
                                    <small class="text-muted">per day</small>
                                </div>
                                @if($car->is_available)
                                    <a href="{{ route('booking.create.car', $car) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-calendar-check me-1"></i>Book Now
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Not Available
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $favorites->links() }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from favorites
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function() {
            const carId = this.dataset.carId;
            const card = this.closest('.col-md-6');
            
            if (!confirm('Remove this car from your favorites?')) {
                return;
            }
            
            fetch(`/favorites/${carId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove card with animation
                    card.style.transition = 'opacity 0.3s';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if no more favorites
                        if (document.querySelectorAll('.col-md-6').length === 0) {
                            location.reload();
                        }
                    }, 300);
                    
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    alert.style.zIndex = '9999';
                    alert.innerHTML = `
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(alert);
                    setTimeout(() => alert.remove(), 3000);
                } else {
                    alert('Failed to remove from favorites: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing from favorites.');
            });
        });
    });
});
</script>
@endpush

<style>
.hover-shadow {
    transition: box-shadow 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection
