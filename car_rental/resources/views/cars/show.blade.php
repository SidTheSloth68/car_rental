@extends('layouts.app')

@section('title', $car->make . ' ' . $car->model)

@section('content')
<!-- section begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/2.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>{{ $car->make }} {{ $car->model }}</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- section close -->

<section id="section-car-details">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div id="slider-carousel" class="owl-carousel">
                    @if($car->gallery && is_array($car->gallery) && count($car->gallery) > 0)
                        @foreach($car->gallery as $image)
                        <div class="item">
                            <img src="{{ asset('images/cars/' . $image) }}" alt="{{ $car->make }} {{ $car->model }}">
                        </div>
                        @endforeach
                    @elseif($car->image)
                        <div class="item">
                            <img src="{{ asset('images/cars/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}">
                        </div>
                    @else
                        <div class="item">
                            <img src="{{ asset('images/cars/default-car.jpg') }}" alt="{{ $car->make }} {{ $car->model }}">
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-3">
                <h3>{{ $car->make }} {{ $car->model }} {{ $car->year }}</h3>
                <p>{{ $car->description ?: 'Premium vehicle available for rent. Experience luxury and comfort on your next journey.' }}</p>

                <div class="spacer-10"></div>

                <h4>Specifications</h4>
                <div class="de-spec">
                    <div class="d-row">
                        <span class="d-title">Body</span>
                        <span class="d-value">{{ ucfirst($car->car_type) }}</span>
                    </div>
                    <div class="d-row">
                        <span class="d-title">Seats</span>
                        <span class="d-value">{{ $car->seats }} seats</span>
                    </div>
                    <div class="d-row">
                        <span class="d-title">Doors</span>
                        <span class="d-value">{{ $car->doors }} doors</span>
                    </div>
                    @if($car->luggage_capacity)
                    <div class="d-row">
                        <span class="d-title">Luggage</span>
                        <span class="d-value">{{ $car->luggage_capacity }} L</span>
                    </div>
                    @endif
                    <div class="d-row">
                        <span class="d-title">Fuel Type</span>
                        <span class="d-value">{{ ucfirst($car->fuel_type) }}</span>
                    </div>
                    @if($car->engine_size)
                    <div class="d-row">
                        <span class="d-title">Engine</span>
                        <span class="d-value">{{ $car->engine_size }}L</span>
                    </div>
                    @endif
                    <div class="d-row">
                        <span class="d-title">Year</span>
                        <span class="d-value">{{ $car->year }}</span>
                    </div>
                    @if($car->mileage)
                    <div class="d-row">
                        <span class="d-title">Mileage</span>
                        <span class="d-value">{{ number_format($car->mileage) }} km</span>
                    </div>
                    @endif
                    <div class="d-row">
                        <span class="d-title">Transmission</span>
                        <span class="d-value">{{ ucfirst($car->transmission) }}</span>
                    </div>
                    @if($car->drivetrain)
                    <div class="d-row">
                        <span class="d-title">Drive</span>
                        <span class="d-value">{{ $car->drivetrain }}</span>
                    </div>
                    @endif
                    @if($car->fuel_consumption)
                    <div class="d-row">
                        <span class="d-title">Fuel Economy</span>
                        <span class="d-value">{{ $car->fuel_consumption }}L/100km</span>
                    </div>
                    @endif
                    @if($car->color)
                    <div class="d-row">
                        <span class="d-title">Exterior Color</span>
                        <span class="d-value">{{ ucfirst($car->color) }}</span>
                    </div>
                    @endif
                    @if($car->interior_color)
                    <div class="d-row">
                        <span class="d-title">Interior Color</span>
                        <span class="d-value">{{ ucfirst($car->interior_color) }}</span>
                    </div>
                    @endif
                </div>

                <div class="spacer-single"></div>

                <h4>Features</h4>
                <ul class="ul-style-2">
                    @if($car->features && is_array($car->features) && count($car->features) > 0)
                        @foreach($car->features as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    @elseif($car->features && is_string($car->features))
                        @php $features = json_decode($car->features, true); @endphp
                        @if($features && count($features) > 0)
                            @foreach($features as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        @else
                            <li>Air Conditioning</li>
                            <li>Bluetooth</li>
                            <li>GPS Navigation</li>
                            <li>Power Steering</li>
                        @endif
                    @else
                        <li>Air Conditioning</li>
                        <li>Bluetooth</li>
                        <li>GPS Navigation</li>
                        <li>Power Steering</li>
                    @endif
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="de-price text-center">
                    Daily rate
                    <h3>${{ number_format($car->price_per_day, 0) }}</h3>
                </div>
                <div class="spacer-30"></div>
                
                @if($car->is_available)
                <div class="de-box mb25">
                    <form name="bookingForm" id='booking_form' method="post" action="{{ route('bookings.store') }}">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        
                        <h4>Book this car</h4>

                        <div class="spacer-20"></div>

                        <div class="row">
                            <div class="col-lg-12 mb20">
                                <h5>Pick Up Location</h5>
                                <input type="text" name="pickup_location" placeholder="Enter your pickup location" 
                                       class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Drop Off Location</h5>
                                <input type="text" name="dropoff_location" placeholder="Enter your drop-off location" 
                                       class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Pick Up Date & Time</h5>
                                <input type="datetime-local" name="pickup_date" class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Drop Off Date & Time</h5>
                                <input type="datetime-local" name="dropoff_date" class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Full Name</h5>
                                <input type="text" name="customer_name" placeholder="Enter your full name" 
                                       class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Email</h5>
                                <input type="email" name="email" placeholder="Enter your email" 
                                       class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb20">
                                <h5>Phone</h5>
                                <input type="tel" name="phone" placeholder="Enter your phone number" 
                                       class="form-control" required>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn-main btn-fullwidth">Book Now</button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="de-box mb25 text-center">
                    <h4 class="text-danger">Currently Unavailable</h4>
                    <p>This vehicle is not available for booking at the moment.</p>
                    <a href="{{ route('cars.index') }}" class="btn-main">Browse Other Cars</a>
                </div>
                @endif

                <div class="de-box">
                    <h4>Share</h4>
                    <div class="de-color-icons">
                        <span><i class="fa fa-twitter fa-lg"></i></span>
                        <span><i class="fa fa-facebook fa-lg"></i></span>
                        <span><i class="fa fa-reddit fa-lg"></i></span>
                        <span><i class="fa fa-linkedin fa-lg"></i></span>
                        <span><i class="fa fa-pinterest fa-lg"></i></span>
                        <span><i class="fa fa-stumbleupon fa-lg"></i></span>
                        <span><i class="fa fa-delicious fa-lg"></i></span>
                        <span><i class="fa fa-envelope fa-lg"></i></span>
                    </div>
                </div>
            </div>                
        </div>
        
        @if($relatedCars->count() > 0)
        <div class="spacer-double"></div>
        <div class="row">
            <div class="col-md-12">
                <h3>Related Cars</h3>
                <div class="spacer-20"></div>
            </div>
        </div>
        <div class="row">
            @foreach($relatedCars as $relatedCar)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="de-item mb30">
                    <div class="d-img">
                        @if($relatedCar->gallery && is_array($relatedCar->gallery) && count($relatedCar->gallery) > 0)
                            <img src="{{ asset('images/cars/' . $relatedCar->gallery[0]) }}" class="img-fluid" alt="{{ $relatedCar->make }} {{ $relatedCar->model }}">
                        @elseif($relatedCar->image)
                            <img src="{{ asset('images/cars/' . $relatedCar->image) }}" class="img-fluid" alt="{{ $relatedCar->make }} {{ $relatedCar->model }}">
                        @else
                            <img src="{{ asset('images/cars/default-car.jpg') }}" class="img-fluid" alt="{{ $relatedCar->make }} {{ $relatedCar->model }}">
                        @endif
                    </div>
                    <div class="d-info">
                        <div class="d-text">
                            <h4>{{ $relatedCar->make }} {{ $relatedCar->model }}</h4>
                            <div class="d-atr-group">
                                <span class="d-atr"><img src="{{ asset('images/icons/1-green.svg') }}" alt="">{{ $relatedCar->seats }}</span>
                                <span class="d-atr"><img src="{{ asset('images/icons/2-green.svg') }}" alt="">{{ $relatedCar->doors }}</span>
                                <span class="d-atr"><img src="{{ asset('images/icons/3-green.svg') }}" alt="">{{ $relatedCar->transmission == 'automatic' ? 'A' : 'M' }}</span>
                                <span class="d-atr"><img src="{{ asset('images/icons/4-green.svg') }}" alt="">{{ ucfirst($relatedCar->car_type) }}</span>
                            </div>
                            <div class="d-price">
                                Daily rate from <span>${{ number_format($relatedCar->price_per_day, 0) }}</span>
                                <a class="btn-main" href="{{ route('cars.show', $relatedCar) }}">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize owl carousel for car images
    if (typeof $.fn.owlCarousel !== 'undefined') {
        $('#slider-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }
    
    // Calculate total price based on dates
    const pickupDateInput = document.querySelector('input[name="pickup_date"]');
    const dropoffDateInput = document.querySelector('input[name="dropoff_date"]');
    const dailyRate = {{ $car->price_per_day }};
    
    function calculatePrice() {
        if (pickupDateInput.value && dropoffDateInput.value) {
            const pickupDate = new Date(pickupDateInput.value);
            const dropoffDate = new Date(dropoffDateInput.value);
            const timeDiff = dropoffDate.getTime() - pickupDate.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            if (daysDiff > 0) {
                const totalPrice = dailyRate * daysDiff;
                // You can display the total price somewhere in the form
                console.log('Total price for ' + daysDiff + ' days: $' + totalPrice);
            }
        }
    }
    
    if (pickupDateInput && dropoffDateInput) {
        pickupDateInput.addEventListener('change', calculatePrice);
        dropoffDateInput.addEventListener('change', calculatePrice);
    }
});
</script>
@endpush
@endsection