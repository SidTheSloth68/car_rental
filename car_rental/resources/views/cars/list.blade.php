@extends('layouts.app')

@section('title', 'Cars - List View')

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
            <div class="col-lg-3">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('cars.list') }}" id="filter-form">
                    <div class="item_filter_group">
                        <h4>Vehicle Type</h4>
                        <div class="de_form">
                            @php
                                $vehicleTypes = ['sedan' => 'Sedan', 'suv' => 'SUV', 'hatchback' => 'Hatchback', 'convertible' => 'Convertible'];
                            @endphp
                            @foreach($vehicleTypes as $value => $label)
                            <div class="de_checkbox">
                                <input id="vehicle_type_{{ $value }}" name="car_type[]" type="checkbox" value="{{ $value }}" 
                                       {{ in_array($value, request('car_type', [])) ? 'checked' : '' }}>
                                <label for="vehicle_type_{{ $value }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="item_filter_group">
                        <h4>Car Body Type</h4>
                        <div class="de_form">
                            @php
                                $bodyTypes = ['convertible' => 'Convertible', 'coupe' => 'Coupe', 'luxury' => 'Luxury Cars', 'hatchback' => 'Hatchback', 'minivan' => 'Minivan', 'pickup' => 'Pickup', 'sedan' => 'Sedan', 'sports' => 'Sports Car', 'wagon' => 'Station Wagon', 'suv' => 'SUV'];
                            @endphp
                            @foreach($bodyTypes as $value => $label)
                            <div class="de_checkbox">
                                <input id="car_body_type_{{ $value }}" name="car_type[]" type="checkbox" value="{{ $value }}"
                                       {{ in_array($value, request('car_type', [])) ? 'checked' : '' }}>
                                <label for="car_body_type_{{ $value }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="item_filter_group">
                        <h4>Car Seats</h4>
                        <div class="de_form">
                            @foreach([2, 4, 5, 7, 8] as $seatCount)
                            <div class="de_checkbox">
                                <input id="car_seat_{{ $seatCount }}" name="seats[]" type="checkbox" value="{{ $seatCount }}"
                                       {{ in_array($seatCount, request('seats', [])) ? 'checked' : '' }}>
                                <label for="car_seat_{{ $seatCount }}">{{ $seatCount }} seats</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="item_filter_group">
                        <h4>Fuel Type</h4>
                        <div class="de_form">
                            @php
                                $fuelTypes = ['gasoline' => 'Gasoline', 'diesel' => 'Diesel', 'electric' => 'Electric', 'hybrid' => 'Hybrid'];
                            @endphp
                            @foreach($fuelTypes as $value => $label)
                            <div class="de_checkbox">
                                <input id="fuel_type_{{ $value }}" name="fuel_type[]" type="checkbox" value="{{ $value }}"
                                       {{ in_array($value, request('fuel_type', [])) ? 'checked' : '' }}>
                                <label for="fuel_type_{{ $value }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="item_filter_group">
                        <h4>Price ($)</h4>
                        <div class="price-input">
                            <div class="field">
                                <span>Min</span>
                                <input type="number" class="input-min" name="min_price" value="{{ request('min_price') }}" placeholder="0">
                            </div>
                            <div class="separator">-</div>
                            <div class="field">
                                <span>Max</span>
                                <input type="number" class="input-max" name="max_price" value="{{ request('max_price') }}" placeholder="1000">
                            </div>
                        </div>
                    </div>

                    <div class="item_filter_group">
                        <button type="submit" class="btn-main btn-fullwidth">Apply Filters</button>
                        <a href="{{ route('cars.list') }}" class="btn-main btn-fullwidth mt-2">Clear Filters</a>
                    </div>
                </form>
            </div>

            <div class="col-lg-9">
                <!-- View Toggle & Sort Options -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p>Showing {{ $cars->count() }} of {{ $cars->total() }} cars</p>
                        <div class="view-toggle">
                            <a href="{{ route('cars.index', request()->query()) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-th"></i> Grid View
                            </a>
                            <span class="btn btn-sm btn-primary">
                                <i class="fa fa-list"></i> List View
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <form method="GET" action="{{ route('cars.list') }}" class="d-inline">
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
                    <div class="col-lg-12">
                        <div class="de-item-list mb30">
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
                                    <div class="d-atr-group">
                                        <ul class="d-atr">
                                            <li><span>Seats:</span> {{ $car->seats }}</li>
                                            @if($car->luggage_capacity)
                                            <li><span>Luggage:</span> {{ $car->luggage_capacity }}L</li>
                                            @endif
                                            <li><span>Doors:</span> {{ $car->doors }}</li>
                                            <li><span>Fuel:</span> {{ ucfirst($car->fuel_type) }}</li>
                                            @if($car->horsepower)
                                            <li><span>Horsepower:</span> {{ $car->horsepower }}</li>
                                            @endif
                                            @if($car->engine_size)
                                            <li><span>Engine:</span> {{ $car->engine_size }}L</li>
                                            @endif
                                            @if($car->drivetrain)
                                            <li><span>Drive:</span> {{ $car->drivetrain }}</li>
                                            @endif
                                            <li><span>Type:</span> {{ ucfirst($car->car_type) }}</li>
                                        </ul>
                                    </div>
                                    
                                    @if($car->description)
                                    <div class="car-description mt-3">
                                        <p>{{ Str::limit($car->description, 150) }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($car->features && is_array($car->features) && count($car->features) > 0)
                                    <div class="car-features mt-2">
                                        <strong>Features:</strong>
                                        @foreach(array_slice($car->features, 0, 5) as $feature)
                                            <span class="badge bg-light text-dark me-1">{{ $feature }}</span>
                                        @endforeach
                                        @if(count($car->features) > 5)
                                            <span class="text-muted">+{{ count($car->features) - 5 }} more</span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="d-price">
                                <div class="price-info">
                                    <div class="rating mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i <= ($car->rating ?: 4) ? '' : '-o' }}"></i>
                                        @endfor
                                        <span class="ms-2 text-muted">({{ $car->reviews_count ?: rand(5, 50) }} reviews)</span>
                                    </div>
                                    @if($car->insurance_included)
                                    <div class="text-success small mb-1">
                                        <i class="fa fa-check"></i> Insurance Included
                                    </div>
                                    @endif
                                    @if($car->deposit_required)
                                    <div class="text-info small mb-1">
                                        Deposit: ${{ number_format($car->deposit_required, 0) }}
                                    </div>
                                    @endif
                                </div>
                                Daily rate from <span>${{ number_format($car->price_per_day, 0) }}</span>
                                @if($car->is_available)
                                    <a class="btn-main" href="{{ route('cars.show', $car) }}">Rent Now</a>
                                @else
                                    <span class="btn btn-secondary disabled">Unavailable</span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h4>No cars found</h4>
                            <p>Try adjusting your filters or <a href="{{ route('cars.list') }}">browse all cars</a>.</p>
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

@push('styles')
<style>
.de-item-list {
    display: flex;
    align-items: stretch;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.de-item-list .d-img {
    flex: 0 0 300px;
    height: 200px;
    overflow: hidden;
}

.de-item-list .d-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.de-item-list .d-info {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.de-item-list .d-price {
    flex: 0 0 200px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.d-atr {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 15px;
}

.d-atr li {
    font-size: 13px;
    color: #666;
}

.d-atr li span {
    font-weight: bold;
    color: #333;
}

.view-toggle {
    margin-top: 10px;
}

.view-toggle .btn {
    margin-right: 5px;
}

.car-features .badge {
    font-size: 11px;
    margin-bottom: 2px;
}

.rating .fa-star {
    color: #ffc107;
}

.rating .fa-star-o {
    color: #ddd;
}

@media (max-width: 768px) {
    .de-item-list {
        flex-direction: column;
    }
    
    .de-item-list .d-img {
        flex: none;
        height: 200px;
    }
    
    .de-item-list .d-price {
        flex: none;
    }
    
    .d-atr {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterForm = document.getElementById('filter-form');
    const checkboxes = filterForm.querySelectorAll('input[type="checkbox"]');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Price range inputs
    const minPriceInput = document.querySelector('.input-min');
    const maxPriceInput = document.querySelector('.input-max');
    
    if (minPriceInput && maxPriceInput) {
        [minPriceInput, maxPriceInput].forEach(input => {
            input.addEventListener('change', function() {
                setTimeout(() => filterForm.submit(), 500);
            });
        });
    }
});
</script>
@endpush
@endsection