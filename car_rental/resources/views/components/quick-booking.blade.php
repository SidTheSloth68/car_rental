<!-- Quick Booking Component -->
<div id="booking_form_wrap" class="padding40 rounded-5 shadow-soft" data-bgcolor="#ffffff">
    <form name="quickBookingForm" id='quick_booking_form' class="form-s2 row g-4" method="post" action="{{ route('bookings.store') }}">
        @csrf
        
        <div class="col-lg-6 d-light">
            <h4>Quick Booking</h4>
            
            <!-- Vehicle Selection -->
            <div class="mb-4">
                <h5>Select Vehicle</h5>
                <select name='car_id' id="vehicle_type" class="form-control @error('car_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Choose a vehicle</option>
                    @foreach($cars ?? [] as $car)
                        <option value="{{ $car->id }}" 
                                data-src="{{ $car->image_url }}"
                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->full_name }} - ${{ $car->daily_rate }}/day
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-4">
                <!-- Pickup Location -->
                <div class="col-lg-6">
                    <h5>Pick Up Location</h5>
                    <select name='pickup_location' id="pickup_location" class="form-control @error('pickup_location') is-invalid @enderror" required>
                        <option value="" disabled selected>Select location</option>
                        <option value='New York' {{ old('pickup_location') == 'New York' ? 'selected' : '' }}>New York</option>
                        <option value='Pennsylvania' {{ old('pickup_location') == 'Pennsylvania' ? 'selected' : '' }}>Pennsylvania</option>
                        <option value='New Jersey' {{ old('pickup_location') == 'New Jersey' ? 'selected' : '' }}>New Jersey</option>
                        <option value='Connecticut' {{ old('pickup_location') == 'Connecticut' ? 'selected' : '' }}>Connecticut</option>
                        <option value='Massachusetts' {{ old('pickup_location') == 'Massachusetts' ? 'selected' : '' }}>Massachusetts</option>
                        <option value='Vermont' {{ old('pickup_location') == 'Vermont' ? 'selected' : '' }}>Vermont</option>
                        <option value='Rhode Island' {{ old('pickup_location') == 'Rhode Island' ? 'selected' : '' }}>Rhode Island</option>
                        <option value='New Hampshire' {{ old('pickup_location') == 'New Hampshire' ? 'selected' : '' }}>New Hampshire</option>
                    </select>
                    @error('pickup_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Drop-off Location -->
                <div class="col-lg-6">
                    <h5>Destination</h5>
                    <select name='dropoff_location' id="destination" class="form-control @error('dropoff_location') is-invalid @enderror" required>
                        <option value="" disabled selected>Select destination</option>
                        <option value='New York' {{ old('dropoff_location') == 'New York' ? 'selected' : '' }}>New York</option>
                        <option value='Pennsylvania' {{ old('dropoff_location') == 'Pennsylvania' ? 'selected' : '' }}>Pennsylvania</option>
                        <option value='New Jersey' {{ old('dropoff_location') == 'New Jersey' ? 'selected' : '' }}>New Jersey</option>
                        <option value='Connecticut' {{ old('dropoff_location') == 'Connecticut' ? 'selected' : '' }}>Connecticut</option>
                        <option value='Massachusetts' {{ old('dropoff_location') == 'Massachusetts' ? 'selected' : '' }}>Massachusetts</option>
                        <option value='Vermont' {{ old('dropoff_location') == 'Vermont' ? 'selected' : '' }}>Vermont</option>
                        <option value='Rhode Island' {{ old('dropoff_location') == 'Rhode Island' ? 'selected' : '' }}>Rhode Island</option>
                        <option value='New Hampshire' {{ old('dropoff_location') == 'New Hampshire' ? 'selected' : '' }}>New Hampshire</option>
                    </select>
                    @error('dropoff_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pick Up Date & Time -->
                <div class="col-lg-6">
                    <h5>Pick Up Date & Time</h5>
                    <div class="date-time-field">
                        <input type="date" 
                               id="pickup_date_quick" 
                               name="pickup_date" 
                               class="form-control @error('pickup_date') is-invalid @enderror"
                               value="{{ old('pickup_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        <select name="pickup_time" 
                                id="pickup_time_quick" 
                                class="form-control @error('pickup_time') is-invalid @enderror"
                                required>
                            <option value="" disabled selected>Select time</option>
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

                <!-- Return Date & Time -->
                <div class="col-lg-6">
                    <h5>Return Date & Time</h5>
                    <div class="date-time-field">
                        <input type="date" 
                               id="return_date_quick" 
                               name="return_date" 
                               class="form-control @error('return_date') is-invalid @enderror"
                               value="{{ old('return_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        <select name="return_time" 
                                id="return_time_quick" 
                                class="form-control @error('return_time') is-invalid @enderror"
                                required>
                            <option value="" disabled selected>Select time</option>
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

        <!-- Customer Details -->
        <div class="col-lg-6">
            <h4>Enter Your Details</h4>
            <div class="row g-4">
                @auth
                    <!-- Pre-filled for authenticated users -->
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="text" 
                                   name="customer_name" 
                                   id="name_quick" 
                                   class="form-control" 
                                   placeholder="Your Name" 
                                   value="{{ auth()->user()->name }}" 
                                   readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="email" 
                                   name="customer_email" 
                                   id="email_quick" 
                                   class="form-control" 
                                   placeholder="Your Email" 
                                   value="{{ auth()->user()->email }}" 
                                   readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="tel" 
                                   name="customer_phone" 
                                   id="phone_quick" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   placeholder="Your Phone" 
                                   value="{{ old('customer_phone') }}"
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="text" 
                                   name="license_number" 
                                   id="license_quick" 
                                   class="form-control @error('license_number') is-invalid @enderror" 
                                   placeholder="Driver's License Number" 
                                   value="{{ old('license_number') }}"
                                   required>
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @else
                    <!-- Guest users need to provide details -->
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="text" 
                                   name="customer_name" 
                                   id="name_quick" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   placeholder="Your Name" 
                                   value="{{ old('customer_name') }}"
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="email" 
                                   name="customer_email" 
                                   id="email_quick" 
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   placeholder="Your Email" 
                                   value="{{ old('customer_email') }}"
                                   required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="tel" 
                                   name="customer_phone" 
                                   id="phone_quick" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   placeholder="Your Phone" 
                                   value="{{ old('customer_phone') }}"
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="field-set">
                            <input type="text" 
                                   name="license_number" 
                                   id="license_quick" 
                                   class="form-control @error('license_number') is-invalid @enderror" 
                                   placeholder="Driver's License Number" 
                                   value="{{ old('license_number') }}"
                                   required>
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endauth

                <div class="col-lg-12">
                    <div class="field-set">
                        <textarea name="notes" 
                                  id="message_quick" 
                                  class="form-control" 
                                  placeholder="Do you have any special requests?">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-lg-12 text-center">
            <div class="mb-3">
                <div class="form-check d-inline-block">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms_quick" required>
                    <label class="form-check-label" for="terms_quick">
                        I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
                    </label>
                </div>
            </div>
            <button type="submit" id="submit_quick" class="btn-main btn-fullwidth">
                <i class="fa fa-calendar-check-o"></i> Book Now
            </button>
        </div>
    </form>

    <!-- Success/Error Messages -->
    <div id="success_message" class="success s2" style="display: none;">
        <h3>Booking request submitted successfully!</h3>
        <p>We will contact you shortly to confirm your reservation.</p>
    </div>
    
    <div id="error_message" class="error" style="display: none;">
        <p>Sorry, an error occurred while processing your booking. Please try again.</p>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    const pickupDateQuick = document.getElementById('pickup_date_quick');
    const returnDateQuick = document.getElementById('return_date_quick');
    
    if (pickupDateQuick) {
        pickupDateQuick.setAttribute('min', today);
    }
    if (returnDateQuick) {
        returnDateQuick.setAttribute('min', today);
    }
    
    // Update return date minimum when pickup date changes
    if (pickupDateQuick) {
        pickupDateQuick.addEventListener('change', function() {
            const pickupDate = this.value;
            if (returnDateQuick) {
                returnDateQuick.setAttribute('min', pickupDate);
                
                // Clear return date if it's before pickup date
                const returnDate = returnDateQuick.value;
                if (returnDate && returnDate < pickupDate) {
                    returnDateQuick.value = '';
                }
            }
        });
    }
    
    // Form validation
    const quickForm = document.getElementById('quick_booking_form');
    if (quickForm) {
        quickForm.addEventListener('submit', function(e) {
            const pickupDate = pickupDateQuick ? pickupDateQuick.value : '';
            const returnDate = returnDateQuick ? returnDateQuick.value : '';
            
            if (pickupDate && returnDate && returnDate <= pickupDate) {
                e.preventDefault();
                alert('Return date must be after pickup date.');
                return false;
            }
        });
    }
});
</script>
@endpush