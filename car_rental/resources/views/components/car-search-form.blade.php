<!-- Car Search Form Component -->
<form name="contactForm" id='contact_form' method="post" action="{{ $action ?? route('cars.search', [], false) }}">
    @csrf
    <div id="step-1" class="row">
        <div class="col-md-12 mb-3">
            <h4>{{ $formTitle ?? 'Find Your Perfect Car' }}</h4>
            @if($showPlaceholder ?? false)
                <p class="text-muted mb-4">Search for available cars by entering your rental details below</p>
            @endif
            
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Pick Up Location</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="pickup_location"
                        id="pickup_location"
                        placeholder="Enter location" 
                        value="{{ old('pickup_location', $pickupLocation ?? '') }}"
                        {{ ($disabled ?? false) ? 'disabled' : '' }}
                    >
                    @error('pickup_location')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Drop Off Location</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="dropoff_location"
                        id="dropoff_location"
                        placeholder="Enter location" 
                        value="{{ old('dropoff_location', $dropoffLocation ?? '') }}"
                        {{ ($disabled ?? false) ? 'disabled' : '' }}
                    >
                    @error('dropoff_location')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Pick Up Date</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        name="pickup_date"
                        id="pickup_date"
                        value="{{ old('pickup_date', $pickupDate ?? '') }}"
                        min="{{ date('Y-m-d') }}"
                        {{ ($disabled ?? false) ? 'disabled' : '' }}
                    >
                    @error('pickup_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Return Date</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        name="return_date"
                        id="return_date"
                        value="{{ old('return_date', $returnDate ?? '') }}"
                        min="{{ date('Y-m-d') }}"
                        {{ ($disabled ?? false) ? 'disabled' : '' }}
                    >
                    @error('return_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button 
                        type="submit" 
                        class="btn btn-main w-100"
                        {{ ($disabled ?? false) ? 'disabled' : '' }}
                    >
                        {{ $buttonText ?? 'Search Cars' }}
                    </button>
                </div>
            </div>
            
            @if($showAdvancedOptions ?? false)
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Car Type</label>
                        <select 
                            class="form-control" 
                            name="car_type"
                            id="car_type"
                            {{ ($disabled ?? false) ? 'disabled' : '' }}
                        >
                            <option value="">Any Type</option>
                            <option value="economy" {{ old('car_type') == 'economy' ? 'selected' : '' }}>Economy</option>
                            <option value="compact" {{ old('car_type') == 'compact' ? 'selected' : '' }}>Compact</option>
                            <option value="standard" {{ old('car_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="suv" {{ old('car_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="luxury" {{ old('car_type') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                            <option value="convertible" {{ old('car_type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Price Range</label>
                        <select 
                            class="form-control" 
                            name="price_range"
                            id="price_range"
                            {{ ($disabled ?? false) ? 'disabled' : '' }}
                        >
                            <option value="">Any Price</option>
                            <option value="0-50" {{ old('price_range') == '0-50' ? 'selected' : '' }}>৳0 - ৳5,500</option>
                            <option value="50-100" {{ old('price_range') == '50-100' ? 'selected' : '' }}>৳5,500 - ৳11,000</option>
                            <option value="100-200" {{ old('price_range') == '100-200' ? 'selected' : '' }}>৳11,000 - ৳22,000</option>
                            <option value="200+" {{ old('price_range') == '200+' ? 'selected' : '' }}>৳22,000+</option>
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure return date is after pickup date
    const pickupDate = document.getElementById('pickup_date');
    const returnDate = document.getElementById('return_date');
    
    if (pickupDate && returnDate) {
        pickupDate.addEventListener('change', function() {
            returnDate.min = this.value;
            if (returnDate.value && returnDate.value < this.value) {
                returnDate.value = this.value;
            }
        });
    }
});
</script>
@endpush