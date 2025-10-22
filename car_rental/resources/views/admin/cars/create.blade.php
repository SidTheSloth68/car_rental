@extends('layouts.admin')

@section('title', 'Add New Car')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-car"></i> Add New Car</h1>
    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Cars
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Car Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle"></i> Basic Information</h6>
                    
                    <div class="mb-3">
                        <label for="make" class="form-label">Make <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('make') is-invalid @enderror" 
                               id="make" name="make" value="{{ old('make') }}" required>
                        @error('make')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" 
                               id="model" name="model" value="{{ old('model') }}" required>
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('year') is-invalid @enderror" 
                               id="year" name="year" value="{{ old('year', date('Y')) }}" 
                               min="1900" max="{{ date('Y') + 1 }}" required>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="economy" {{ old('type') == 'economy' ? 'selected' : '' }}>Economy</option>
                            <option value="compact" {{ old('type') == 'compact' ? 'selected' : '' }}>Compact</option>
                            <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="intermediate" {{ old('type') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="full_size" {{ old('type') == 'full_size' ? 'selected' : '' }}>Full Size</option>
                            <option value="premium" {{ old('type') == 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="luxury" {{ old('type') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                            <option value="suv" {{ old('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="minivan" {{ old('type') == 'minivan' ? 'selected' : '' }}>Minivan</option>
                            <option value="convertible" {{ old('type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                            <option value="sports_car" {{ old('type') == 'sports_car' ? 'selected' : '' }}>Sports Car</option>
                            <option value="truck" {{ old('type') == 'truck' ? 'selected' : '' }}>Truck</option>
                            <option value="van" {{ old('type') == 'van' ? 'selected' : '' }}>Van</option>
                            <option value="exotic" {{ old('type') == 'exotic' ? 'selected' : '' }}>Exotic</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-cog"></i> Technical Specifications</h6>
                    
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                            <option value="">Select Fuel Type</option>
                            <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                            <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="lpg" {{ old('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                        </select>
                        @error('fuel_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission <span class="text-danger">*</span></label>
                        <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                            <option value="">Select Transmission</option>
                            <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="cvt" {{ old('transmission') == 'cvt' ? 'selected' : '' }}>CVT</option>
                        </select>
                        @error('transmission')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="seats" class="form-label">Seats <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('seats') is-invalid @enderror" 
                                   id="seats" name="seats" value="{{ old('seats') }}" min="1" max="50" required>
                            @error('seats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="doors" class="form-label">Doors <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('doors') is-invalid @enderror" 
                                   id="doors" name="doors" value="{{ old('doors') }}" min="1" max="10" required>
                            @error('doors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="luggage_capacity" class="form-label">Luggage Capacity</label>
                        <input type="text" class="form-control @error('luggage_capacity') is-invalid @enderror" 
                               id="luggage_capacity" name="luggage_capacity" value="{{ old('luggage_capacity') }}" 
                               placeholder="e.g., 3 bags">
                        @error('luggage_capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <!-- Pricing -->
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-dollar-sign"></i> Pricing (in USD)</h6>
                    
                    <div class="mb-3">
                        <label for="daily_rate" class="form-label">Daily Rate <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('daily_rate') is-invalid @enderror" 
                               id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" required>
                        @error('daily_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <!-- Image and Features -->
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-image"></i> Media</h6>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Car Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-list"></i> Features</h6>
                    
                    <div class="mb-3">
                        <label for="features" class="form-label">Features (comma-separated)</label>
                        <textarea class="form-control @error('features') is-invalid @enderror" 
                                  id="features" name="features" rows="4" 
                                  placeholder="GPS Navigation, Bluetooth, Air Conditioning, USB Charging">{{ old('features') }}</textarea>
                        <small class="text-muted">Separate each feature with a comma</small>
                        @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_available" name="is_available" 
                               {{ old('is_available', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">
                            Available for Rent
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Car
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Car
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
