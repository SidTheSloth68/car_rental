@extends('layouts.app')

@section('title', 'Book a Vehicle - Rentaly')

@section('content')
<!-- subheader begin -->
<section id="subheader" class="jarallax text-light">
    <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
    <div class="center-y relative text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Booking</h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->

<section id="section-hero" aria-label="section" class="no-top mt-80 sm-mt-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="spacer-single sm-hide"></div>
                <div class="p-4 rounded-3 shadow-soft" data-bgcolor="#ffffff">

                    <form name="bookingForm" id='booking_form' method="post" action="{{ route('bookings.store') }}">
                        @csrf
                        <div id="step-1" class="row">
                            <div class="col-lg-6 mb30">
                                <h5>What is your vehicle type?</h5>

                                <div class="de_form de_radio row g-3">
                                    <div class="radio-img col-lg-3 col-sm-3 col-6">
                                        <input id="radio-1a" name="car_type" type="radio" value="economy" {{ old('car_type') == 'economy' ? 'checked' : 'checked' }}>
                                        <label for="radio-1a"><img src="{{ asset('images/select-form/car.png') }}" alt="">Car</label>
                                    </div>

                                    <div class="radio-img col-lg-3 col-sm-3 col-6">
                                        <input id="radio-1b" name="car_type" type="radio" value="van" {{ old('car_type') == 'van' ? 'checked' : '' }}>
                                        <label for="radio-1b"><img src="{{ asset('images/select-form/van.png') }}" alt="">Van</label>
                                    </div>

                                    <div class="radio-img col-lg-3 col-sm-3 col-6">
                                        <input id="radio-1c" name="car_type" type="radio" value="minivan" {{ old('car_type') == 'minivan' ? 'checked' : '' }}>
                                        <label for="radio-1c"><img src="{{ asset('images/select-form/minibus.png') }}" alt="">Minibus</label>
                                    </div>

                                    <div class="radio-img col-lg-3 col-sm-3 col-6">
                                        <input id="radio-1d" name="car_type" type="radio" value="luxury" {{ old('car_type') == 'luxury' ? 'checked' : '' }}>
                                        <label for="radio-1d"><img src="{{ asset('images/select-form/sportscar.png') }}" alt="">Prestige</label>
                                    </div>
                                </div>
                                @error('car_type')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 mb20">
                                        <h5>Pick Up Location</h5>
                                        <input type="text" 
                                               name="pickup_location" 
                                               placeholder="Enter your pickup location" 
                                               id="pickup_location" 
                                               autocomplete="off" 
                                               class="form-control @error('pickup_location') is-invalid @enderror"
                                               value="{{ old('pickup_location') }}"
                                               required>
                                        @error('pickup_location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb20">
                                        <h5>Drop Off Location</h5>
                                        <input type="text" 
                                               name="dropoff_location" 
                                               placeholder="Enter your dropoff location" 
                                               id="dropoff_location" 
                                               autocomplete="off" 
                                               class="form-control @error('dropoff_location') is-invalid @enderror"
                                               value="{{ old('dropoff_location') }}"
                                               required>
                                        @error('dropoff_location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb20">
                                        <h5>Pick Up Date & Time</h5>
                                        <div class="date-time-field">
                                            <input type="date" 
                                                   id="pickup_date" 
                                                   name="pickup_date" 
                                                   class="form-control @error('pickup_date') is-invalid @enderror"
                                                   value="{{ old('pickup_date') }}"
                                                   min="{{ date('Y-m-d') }}"
                                                   required>
                                            <select name="pickup_time" 
                                                    id="pickup_time" 
                                                    class="form-control @error('pickup_time') is-invalid @enderror"
                                                    required>
                                                <option disabled {{ old('pickup_time') ? '' : 'selected' }}>Select time</option>
                                                @for($hour = 0; $hour < 24; $hour++)
                                                    @for($minute = 0; $minute < 60; $minute += 30)
                                                        @php
                                                            $timeValue = sprintf('%02d:%02d', $hour, $minute);
                                                        @endphp
                                                        <option value="{{ $timeValue }}" {{ old('pickup_time') == $timeValue ? 'selected' : '' }}>
                                                            {{ $timeValue }}
                                                        </option>
                                                    @endfor
                                                @endfor
                                            </select>
                                        </div>
                                        @error('pickup_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('pickup_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb20">
                                        <h5>Return Date & Time</h5>
                                        <div class="date-time-field">
                                            <input type="date" 
                                                   id="return_date" 
                                                   name="return_date" 
                                                   class="form-control @error('return_date') is-invalid @enderror"
                                                   value="{{ old('return_date') }}"
                                                   min="{{ date('Y-m-d') }}"
                                                   required>
                                            <select name="return_time" 
                                                    id="return_time" 
                                                    class="form-control @error('return_time') is-invalid @enderror"
                                                    required>
                                                <option disabled {{ old('return_time') ? '' : 'selected' }}>Select time</option>
                                                @for($hour = 0; $hour < 24; $hour++)
                                                    @for($minute = 0; $minute < 60; $minute += 30)
                                                        @php
                                                            $timeValue = sprintf('%02d:%02d', $hour, $minute);
                                                        @endphp
                                                        <option value="{{ $timeValue }}" {{ old('return_time') == $timeValue ? 'selected' : '' }}>
                                                            {{ $timeValue }}
                                                        </option>
                                                    @endfor
                                                @endfor
                                            </select>
                                        </div>
                                        @error('return_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @error('return_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Car Selection (if specific car requested) -->
                            @if(request('car_id'))
                                <input type="hidden" name="car_id" value="{{ request('car_id') }}">
                            @endif

                            <!-- Additional Options -->
                            <div class="col-lg-12 mb30">
                                <h5>Additional Options</h5>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="insurance" id="insurance" value="1" {{ old('insurance') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insurance">
                                                Additional Insurance (+$15/day)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gps" id="gps" value="1" {{ old('gps') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gps">
                                                GPS Navigation (+$5/day)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="child_seat" id="child_seat" value="1" {{ old('child_seat') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="child_seat">
                                                Child Seat (+$8/day)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            @auth
                                <div class="col-lg-12 mb30">
                                    <h5>Contact Information</h5>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Full Name</label>
                                            <input type="text" name="customer_name" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Email</label>
                                            <input type="email" name="customer_email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label>Phone Number</label>
                                            <input type="tel" 
                                                   name="customer_phone" 
                                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                                   value="{{ old('customer_phone') }}"
                                                   placeholder="Enter your phone number"
                                                   required>
                                            @error('customer_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label>Driver's License Number</label>
                                            <input type="text" 
                                                   name="license_number" 
                                                   class="form-control @error('license_number') is-invalid @enderror" 
                                                   value="{{ old('license_number') }}"
                                                   placeholder="Enter your license number"
                                                   required>
                                            @error('license_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="col-lg-12 mb30">
                                    <h5>Special Requests</h5>
                                    <textarea name="notes" 
                                              class="form-control" 
                                              rows="4" 
                                              placeholder="Any special requests or notes...">{{ old('notes') }}</textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn-main pull-right">
                                        <i class="fa fa-calendar-check-o"></i> Book Now
                                    </button>
                                </div>
                            @else
                                <div class="col-lg-12 text-center">
                                    <div class="alert alert-info">
                                        <h5>Please sign in to complete your booking</h5>
                                        <p>You need to be logged in to make a reservation.</p>
                                        <a href="{{ route('login', ['redirect' => url()->full()]) }}" class="btn btn-primary me-2">Sign In</a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="spacer-single"></div>

        <!-- How it works section -->
        <div class="row">
            <div class="col-md-3 wow fadeInRight" data-wow-delay=".2s">
                <div class="feature-box style-4 text-center">
                    <a href="#"><i class="bg-color text-light i-boxed fa fa-car"></i></a>
                    <div class="text">
                        <a href="#"><h4>Choose a vehicle</h4></a>
                        Unlock unparalleled adventures and memorable journeys with our vast fleet of vehicles tailored to suit every need, taste, and destination.
                    </div>
                    <span class="wm">1</span>
                </div>
            </div>

            <div class="col-md-3 wow fadeInRight" data-wow-delay=".4s">
                <div class="feature-box style-4 text-center">
                    <a href="#"><i class="bg-color text-light i-boxed fa fa-calendar"></i></a>
                    <div class="text">
                        <a href="#"><h4>Pick location & date</h4></a>
                        Pick your ideal location and date, and let us take you on a journey filled with convenience, flexibility, and unforgettable experiences.
                    </div>
                    <span class="wm">2</span>
                </div>
            </div>

            <div class="col-md-3 wow fadeInRight" data-wow-delay=".6s">
                <div class="feature-box style-4 text-center">
                    <a href="#"><i class="bg-color text-light i-boxed fa fa-credit-card"></i></a>
                    <div class="text">
                        <a href="#"><h4>Make a booking</h4></a>
                        Secure your reservation with ease and confidence, knowing that your booking is confirmed and your adventure awaits.
                    </div>
                    <span class="wm">3</span>
                </div>
            </div>

            <div class="col-md-3 wow fadeInRight" data-wow-delay=".8s">
                <div class="feature-box style-4 text-center">
                    <a href="#"><i class="bg-color text-light i-boxed fa fa-road"></i></a>
                    <div class="text">
                        <a href="#"><h4>Enjoy the ride</h4></a>
                        Hit the road with confidence, knowing that every mile is backed by our commitment to quality, safety, and your ultimate satisfaction.
                    </div>
                    <span class="wm">4</span>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('pickup_date').setAttribute('min', today);
    document.getElementById('return_date').setAttribute('min', today);
    
    // Update return date minimum when pickup date changes
    document.getElementById('pickup_date').addEventListener('change', function() {
        const pickupDate = this.value;
        document.getElementById('return_date').setAttribute('min', pickupDate);
        
        // If return date is before pickup date, clear it
        const returnDate = document.getElementById('return_date').value;
        if (returnDate && returnDate < pickupDate) {
            document.getElementById('return_date').value = '';
        }
    });
    
    // Form validation
    document.getElementById('booking_form').addEventListener('submit', function(e) {
        const pickupDate = document.getElementById('pickup_date').value;
        const returnDate = document.getElementById('return_date').value;
        
        if (pickupDate && returnDate && returnDate <= pickupDate) {
            e.preventDefault();
            alert('Return date must be after pickup date.');
            return false;
        }
    });
});
</script>
@endpush
@endsection