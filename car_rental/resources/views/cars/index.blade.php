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
            <div class="col-lg-3">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('cars.index') }}" id="filter-form">
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
                        <a href="{{ route('cars.index') }}" class="btn-main btn-fullwidth mt-2">Clear Filters</a>
                    </div>
                </form>
            </div>

            <div class="col-lg-9">
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
                                @if($car->images && count(json_decode($car->images, true)) > 0)
                                    @php $images = json_decode($car->images, true); @endphp
                                    <img src="{{ asset('images/cars/' . $images[0]) }}" class="img-fluid" alt="{{ $car->make }} {{ $car->model }}">
                                @else
                                    <img src="{{ asset('images/cars/default-car.jpg') }}" class="img-fluid" alt="{{ $car->make }} {{ $car->model }}">
                                @endif
                            </div>
                            <div class="d-info">
                                <div class="d-text">
                                    <h4>{{ $car->make }} {{ $car->model }}</h4>
                                    <div class="d-item_like">
                                        <i class="fa fa-heart"></i><span>{{ $car->favorites_count ?: 0 }}</span>
                                    </div>
                                    <div class="d-atr-group">
                                        <span class="d-atr"><img src="{{ asset('images/icons/1-green.svg') }}" alt="">{{ $car->seats }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/2-green.svg') }}" alt="">{{ $car->doors }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/3-green.svg') }}" alt="">{{ $car->transmission == 'automatic' ? 'A' : 'M' }}</span>
                                        <span class="d-atr"><img src="{{ asset('images/icons/4-green.svg') }}" alt="">{{ ucfirst($car->car_type) }}</span>
                                    </div>
                                    <div class="d-price">
                                        Daily rate from <span>${{ number_format($car->price_per_day, 0) }}</span>
                                        <a class="btn-main" href="{{ route('cars.show', $car) }}">Rent Now</a>
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