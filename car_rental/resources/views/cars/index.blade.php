@extends('layouts.app')

@section('title', 'Cars')

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Cars</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<section id="section-cars">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Sort Options -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p>Showing {{ $cars->count() }} of {{ $cars->total() }} cars</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <form method="GET" action="{{ route('cars.index') }}" class="d-inline">
                            @foreach(request()->except(['sort_by', 'sort_order']) as $key => $value)
                                @if(is_array($value))
                                    @foreach($value as $v)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="sort_by" onchange="this.form.submit()" class="form-select d-inline-block w-auto">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_per_day" {{ request('sort_by') == 'price_per_day' ? 'selected' : '' }}>Price Low to High</option>
                                <option value="year" {{ request('sort_by') == 'year' ? 'selected' : '' }}>Year</option>
                                <option value="make" {{ request('sort_by') == 'make' ? 'selected' : '' }}>Make</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row">
                    @forelse($cars as $car)
                    <div class="col-xl-4 col-lg-6">
                        <div class="de-item mb30">
                            <div class="d-img">
                                @if($car->gallery && is_array($car->gallery) && count($car->gallery) > 0)
                                    <img src="{{ asset('images/cars/' . $car->gallery[0]) }}" class="img-fluid" alt="{{ $car->make }} {{ $car->model }}">
                                @elseif($car->image)
                                    <img src="{{ asset('images/cars/' . $car->image) }}" class="img-fluid" alt="{{ $car->make }} {{ $car->model }}">
                                @else
                                    <img src="{{ asset('images/cars/default-car.jpg') }}" class="img-fluid" alt="{{ $car->make }} {{ $car->model }}">
                                @endif
                            </div>
                            <div class="d-info">
                                <div class="d-text">
                                    <h4>{{ $car->make }} {{ $car->model }}</h4>
                                    <div class="d-item_like">
                                        @auth
                                            <button class="favorite-btn border-0 bg-transparent p-0" 
                                                    data-car-id="{{ $car->id }}"
                                                    data-favorited="{{ auth()->user()->hasFavorited($car->id) ? 'true' : 'false' }}"
                                                    style="cursor: pointer;">
                                                <i class="fa fa-heart {{ auth()->user()->hasFavorited($car->id) ? 'text-danger' : '' }}"></i>
                                            </button>
                                        @else
                                            <i class="fa fa-heart"></i>
                                        @endauth
                                        <span class="favorite-count">{{ $car->favorites_count ?: 0 }}</span>
                                    </div>
                                    <div class="d-atr-group">
                                        <span class="d-atr"><img src="{{ asset('images/icons/1-green.svg') }}" alt="">{{ $car->seats }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/2-green.svg') }}" alt="">{{ $car->doors }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/3-green.svg') }}" alt="">{{ $car->transmission == 'automatic' ? 'A' : 'M' }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/4-green.svg') }}" alt="">{{ ucfirst($car->car_type) }}</span>
                                    </div>
                                    <div class="d-price">
                                        Daily rate from <span>৳{{ number_format($car->price_per_day * 110, 0) }}</span>
                                        @if($car->is_available)
                                            @auth
                                                <a class="btn-main" href="{{ route('cars.show', $car) }}">Rent Now</a>
                                            @else
                                                <a class="btn-main" href="{{ route('login') }}?message=rent">Rent Now</a>
                                            @endauth
                                        @else
                                            <span class="badge badge-danger mt-2" style="display: block; padding: 10px; background: #dc3545; color: white; font-size: 14px;">Currently Booked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h4>No cars found</h4>
                            <p>Try adjusting your filters or <a href="{{ route('cars.index') }}">browse all cars</a>.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($cars->hasPages())
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $cars->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button clicks
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const carId = this.dataset.carId;
            const isFavorited = this.dataset.favorited === 'true';
            const icon = this.querySelector('i');
            const countSpan = this.nextElementSibling;
            
            // Toggle favorite
            const method = isFavorited ? 'DELETE' : 'POST';
            const url = `/favorites/${carId}`;
            
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle the favorited state
                    this.dataset.favorited = isFavorited ? 'false' : 'true';
                    
                    // Update icon style
                    if (isFavorited) {
                        icon.classList.remove('text-danger');
                    } else {
                        icon.classList.add('text-danger');
                    }
                    
                    // Update count
                    let currentCount = parseInt(countSpan.textContent) || 0;
                    countSpan.textContent = isFavorited ? Math.max(0, currentCount - 1) : currentCount + 1;
                    
                    // Show success message (optional)
                    console.log(data.message);
                } else {
                    alert(data.message || 'Failed to update favorites');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
});
</script>
@endauth

@endsection