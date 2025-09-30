<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can search for cars
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Location and Dates
            'pickup_location' => [
                'nullable',
                'string',
                'max:255',
                Rule::in([
                    'downtown',
                    'airport',
                    'city_center',
                    'suburban',
                    'north_branch',
                    'south_branch',
                    'all_locations'
                ])
            ],
            'pickup_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addYear()->format('Y-m-d')
            ],
            'return_date' => [
                'nullable',
                'date',
                'after:pickup_date',
                'before_or_equal:' . now()->addYear()->format('Y-m-d')
            ],

            // Car Specifications
            'car_type' => [
                'nullable',
                'string',
                Rule::in([
                    'all',
                    'sedan',
                    'suv',
                    'hatchback',
                    'coupe',
                    'convertible',
                    'wagon',
                    'pickup',
                    'minivan',
                    'luxury',
                    'economy',
                    'compact'
                ])
            ],
            'make' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\-\s]+$/'
            ],
            'model' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\-\s]+$/'
            ],
            'year_from' => [
                'nullable',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1)
            ],
            'year_to' => [
                'nullable',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
                'gte:year_from'
            ],

            // Engine and Transmission
            'fuel_type' => [
                'nullable',
                'string',
                Rule::in(['all', 'petrol', 'diesel', 'hybrid', 'electric', 'plug-in-hybrid'])
            ],
            'transmission' => [
                'nullable',
                'string',
                Rule::in(['all', 'automatic', 'manual', 'cvt', 'single-speed'])
            ],

            // Capacity
            'seats' => [
                'nullable',
                'integer',
                'min:2',
                'max:15'
            ],
            'doors' => [
                'nullable',
                'integer',
                'min:2',
                'max:5'
            ],

            // Price Range
            'price_min' => [
                'nullable',
                'numeric',
                'min:0',
                'max:10000'
            ],
            'price_max' => [
                'nullable',
                'numeric',
                'min:0',
                'max:10000',
                'gte:price_min'
            ],
            'price_type' => [
                'nullable',
                'string',
                Rule::in(['daily', 'weekly', 'monthly'])
            ],

            // Features and Options
            'features' => [
                'nullable',
                'array'
            ],
            'features.*' => [
                'string',
                Rule::in([
                    'air_conditioning',
                    'gps_navigation',
                    'bluetooth',
                    'usb_charging',
                    'heated_seats',
                    'leather_seats',
                    'sunroof',
                    'backup_camera',
                    'parking_sensors',
                    'cruise_control',
                    'lane_departure_warning',
                    'blind_spot_monitoring',
                    'automatic_emergency_braking',
                    'adaptive_cruise_control',
                    'apple_carplay',
                    'android_auto',
                    'wireless_charging',
                    'premium_sound',
                    'all_wheel_drive',
                    'keyless_entry',
                    'remote_start'
                ])
            ],

            // Availability
            'availability' => [
                'nullable',
                'string',
                Rule::in(['all', 'available', 'unavailable'])
            ],
            'featured_only' => [
                'nullable',
                'boolean'
            ],

            // Sorting and Display
            'sort_by' => [
                'nullable',
                'string',
                Rule::in([
                    'price_low_high',
                    'price_high_low',
                    'year_new_old',
                    'year_old_new',
                    'rating_high_low',
                    'rating_low_high',
                    'popularity',
                    'newest_first',
                    'make_az',
                    'make_za'
                ])
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:6',
                'max:60'
            ],
            'view_type' => [
                'nullable',
                'string',
                Rule::in(['grid', 'list', 'compact'])
            ],

            // Filters
            'color' => [
                'nullable',
                'string',
                Rule::in([
                    'all',
                    'black',
                    'white',
                    'silver',
                    'gray',
                    'red',
                    'blue',
                    'green',
                    'yellow',
                    'brown',
                    'orange'
                ])
            ],
            'mileage_max' => [
                'nullable',
                'integer',
                'min:0',
                'max:500000'
            ],

            // Advanced Filters
            'insurance_included' => [
                'nullable',
                'boolean'
            ],
            'unlimited_mileage' => [
                'nullable',
                'boolean'
            ],
            'instant_booking' => [
                'nullable',
                'boolean'
            ],
            'free_cancellation' => [
                'nullable',
                'boolean'
            ],

            // Rating Filter
            'min_rating' => [
                'nullable',
                'numeric',
                'min:1',
                'max:5'
            ],

            // Search Query
            'search' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9\s\-]+$/'
            ],

            // Location Filters
            'distance_radius' => [
                'nullable',
                'integer',
                'min:1',
                'max:100'
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'pickup_date.after_or_equal' => 'Pickup date must be today or later.',
            'pickup_date.before_or_equal' => 'Pickup date cannot be more than one year from now.',
            'return_date.after' => 'Return date must be after pickup date.',
            'return_date.before_or_equal' => 'Return date cannot be more than one year from now.',
            
            'make.regex' => 'Car make can only contain letters, spaces, and hyphens.',
            'model.regex' => 'Car model can only contain letters, numbers, spaces, and hyphens.',
            
            'year_from.min' => 'Year from must be 2000 or later.',
            'year_from.max' => 'Year from cannot be in the future.',
            'year_to.min' => 'Year to must be 2000 or later.',
            'year_to.max' => 'Year to cannot be in the future.',
            'year_to.gte' => 'Year to must be greater than or equal to year from.',
            
            'seats.min' => 'Minimum number of seats is 2.',
            'seats.max' => 'Maximum number of seats is 15.',
            'doors.min' => 'Minimum number of doors is 2.',
            'doors.max' => 'Maximum number of doors is 5.',
            
            'price_min.min' => 'Minimum price cannot be negative.',
            'price_min.max' => 'Minimum price cannot exceed $10,000.',
            'price_max.min' => 'Maximum price cannot be negative.',
            'price_max.max' => 'Maximum price cannot exceed $10,000.',
            'price_max.gte' => 'Maximum price must be greater than or equal to minimum price.',
            
            'per_page.min' => 'Minimum results per page is 6.',
            'per_page.max' => 'Maximum results per page is 60.',
            
            'mileage_max.min' => 'Maximum mileage cannot be negative.',
            'mileage_max.max' => 'Maximum mileage cannot exceed 500,000.',
            
            'min_rating.min' => 'Minimum rating must be at least 1 star.',
            'min_rating.max' => 'Minimum rating cannot exceed 5 stars.',
            
            'search.max' => 'Search query cannot exceed 100 characters.',
            'search.regex' => 'Search query contains invalid characters.',
            
            'distance_radius.min' => 'Distance radius must be at least 1 mile.',
            'distance_radius.max' => 'Distance radius cannot exceed 100 miles.',
            
            'latitude.between' => 'Latitude must be between -90 and 90.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'pickup_location' => 'pickup location',
            'pickup_date' => 'pickup date',
            'return_date' => 'return date',
            'car_type' => 'car type',
            'make' => 'car make',
            'model' => 'car model',
            'year_from' => 'year from',
            'year_to' => 'year to',
            'fuel_type' => 'fuel type',
            'transmission' => 'transmission',
            'seats' => 'number of seats',
            'doors' => 'number of doors',
            'price_min' => 'minimum price',
            'price_max' => 'maximum price',
            'price_type' => 'price type',
            'features' => 'features',
            'sort_by' => 'sort by',
            'per_page' => 'results per page',
            'view_type' => 'view type',
            'color' => 'color',
            'mileage_max' => 'maximum mileage',
            'min_rating' => 'minimum rating',
            'search' => 'search query',
            'distance_radius' => 'distance radius',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validate that pickup date is before return date with meaningful time gap
            if ($this->pickup_date && $this->return_date) {
                $pickup = \Carbon\Carbon::parse($this->pickup_date);
                $return = \Carbon\Carbon::parse($this->return_date);
                
                if ($return->diffInHours($pickup) < 1) {
                    $validator->errors()->add('return_date', 'Return date must be at least 1 hour after pickup date.');
                }
            }

            // Validate price range logic
            if ($this->price_min !== null && $this->price_max !== null) {
                if ($this->price_min > $this->price_max) {
                    $validator->errors()->add('price_max', 'Maximum price must be greater than minimum price.');
                }
            }

            // Validate year range logic
            if ($this->year_from !== null && $this->year_to !== null) {
                if ($this->year_from > $this->year_to) {
                    $validator->errors()->add('year_to', 'End year must be greater than or equal to start year.');
                }
            }

            // Validate feature combinations (if business logic requires it)
            if ($this->features && is_array($this->features)) {
                // Check for conflicting features
                $conflictingFeatures = [
                    ['manual_transmission', 'automatic_transmission'],
                    ['petrol_engine', 'electric_engine']
                ];

                foreach ($conflictingFeatures as $conflictSet) {
                    $foundConflicts = array_intersect($this->features, $conflictSet);
                    if (count($foundConflicts) > 1) {
                        $validator->errors()->add('features', 'Conflicting features selected: ' . implode(', ', $foundConflicts));
                    }
                }
            }

            // Validate location coordinates if provided
            if (($this->latitude !== null || $this->longitude !== null) && 
                ($this->latitude === null || $this->longitude === null)) {
                $validator->errors()->add('latitude', 'Both latitude and longitude must be provided together.');
                $validator->errors()->add('longitude', 'Both latitude and longitude must be provided together.');
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default values
        $defaults = [
            'car_type' => 'all',
            'fuel_type' => 'all',
            'transmission' => 'all',
            'availability' => 'available',
            'sort_by' => 'price_low_high',
            'per_page' => 12,
            'view_type' => 'grid',
            'color' => 'all',
            'price_type' => 'daily',
        ];

        foreach ($defaults as $key => $default) {
            if (empty($this->input($key))) {
                $this->merge([$key => $default]);
            }
        }

        // Convert boolean fields
        $booleanFields = [
            'featured_only',
            'insurance_included',
            'unlimited_mileage',
            'instant_booking',
            'free_cancellation'
        ];

        $booleanData = [];
        foreach ($booleanFields as $field) {
            $booleanData[$field] = filter_var($this->input($field), FILTER_VALIDATE_BOOLEAN);
        }
        $this->merge($booleanData);

        // Clean and format string inputs
        $stringFields = ['make', 'model', 'search'];
        $stringData = [];
        foreach ($stringFields as $field) {
            if ($this->input($field)) {
                $stringData[$field] = trim($this->input($field));
            }
        }
        $this->merge($stringData);

        // Convert numeric fields
        $numericFields = ['price_min', 'price_max', 'year_from', 'year_to', 'seats', 'doors', 'mileage_max', 'min_rating', 'distance_radius'];
        $numericData = [];
        foreach ($numericFields as $field) {
            if ($this->input($field) !== null && $this->input($field) !== '') {
                $numericData[$field] = is_numeric($this->input($field)) ? (float)$this->input($field) : null;
            }
        }
        $this->merge($numericData);

        // Ensure features is an array
        if ($this->features && !is_array($this->features)) {
            $this->merge(['features' => [$this->features]]);
        }
    }

    /**
     * Get the available car types for search.
     */
    public static function getCarTypes(): array
    {
        return [
            'all' => 'All Types',
            'sedan' => 'Sedan',
            'suv' => 'SUV',
            'hatchback' => 'Hatchback',
            'coupe' => 'Coupe',
            'convertible' => 'Convertible',
            'wagon' => 'Wagon',
            'pickup' => 'Pickup Truck',
            'minivan' => 'Minivan',
            'luxury' => 'Luxury',
            'economy' => 'Economy',
            'compact' => 'Compact'
        ];
    }

    /**
     * Get the available fuel types for search.
     */
    public static function getFuelTypes(): array
    {
        return [
            'all' => 'All Fuel Types',
            'petrol' => 'Petrol/Gas',
            'diesel' => 'Diesel',
            'hybrid' => 'Hybrid',
            'electric' => 'Electric',
            'plug-in-hybrid' => 'Plug-in Hybrid'
        ];
    }

    /**
     * Get the available transmission types for search.
     */
    public static function getTransmissionTypes(): array
    {
        return [
            'all' => 'All Transmissions',
            'automatic' => 'Automatic',
            'manual' => 'Manual',
            'cvt' => 'CVT',
            'single-speed' => 'Single-Speed (Electric)'
        ];
    }

    /**
     * Get the available sort options.
     */
    public static function getSortOptions(): array
    {
        return [
            'price_low_high' => 'Price: Low to High',
            'price_high_low' => 'Price: High to Low',
            'year_new_old' => 'Year: Newest First',
            'year_old_new' => 'Year: Oldest First',
            'rating_high_low' => 'Rating: High to Low',
            'rating_low_high' => 'Rating: Low to High',
            'popularity' => 'Most Popular',
            'newest_first' => 'Recently Added',
            'make_az' => 'Make: A to Z',
            'make_za' => 'Make: Z to A'
        ];
    }

    /**
     * Get the available features for search.
     */
    public static function getSearchableFeatures(): array
    {
        return [
            'air_conditioning' => 'Air Conditioning',
            'gps_navigation' => 'GPS Navigation',
            'bluetooth' => 'Bluetooth',
            'usb_charging' => 'USB Charging',
            'heated_seats' => 'Heated Seats',
            'leather_seats' => 'Leather Seats',
            'sunroof' => 'Sunroof',
            'backup_camera' => 'Backup Camera',
            'parking_sensors' => 'Parking Sensors',
            'cruise_control' => 'Cruise Control',
            'lane_departure_warning' => 'Lane Departure Warning',
            'blind_spot_monitoring' => 'Blind Spot Monitoring',
            'automatic_emergency_braking' => 'Automatic Emergency Braking',
            'adaptive_cruise_control' => 'Adaptive Cruise Control',
            'apple_carplay' => 'Apple CarPlay',
            'android_auto' => 'Android Auto',
            'wireless_charging' => 'Wireless Charging',
            'premium_sound' => 'Premium Sound System',
            'all_wheel_drive' => 'All-Wheel Drive',
            'keyless_entry' => 'Keyless Entry',
            'remote_start' => 'Remote Start'
        ];
    }
}