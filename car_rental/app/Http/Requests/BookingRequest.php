<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can make bookings
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Car Selection
            'car_id' => [
                'required',
                'integer',
                'exists:cars,id',
                function ($attribute, $value, $fail) {
                    $car = \App\Models\Car::find($value);
                    if ($car && !$car->is_available) {
                        $fail('The selected car is not available for booking.');
                    }
                }
            ],

            // Booking Dates
            'pickup_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before:return_date'
            ],
            'return_date' => [
                'required',
                'date',
                'after:pickup_date',
                'before_or_equal:' . now()->addYear()->format('Y-m-d')
            ],

            // Pickup & Return Details
            'pickup_location' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'downtown',
                    'airport',
                    'city_center',
                    'suburban',
                    'north_branch',
                    'south_branch',
                    'custom'
                ])
            ],
            'return_location' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'downtown',
                    'airport',
                    'city_center',
                    'suburban',
                    'north_branch',
                    'south_branch',
                    'custom'
                ])
            ],
            'pickup_time' => [
                'required',
                'date_format:H:i'
            ],
            'return_time' => [
                'required',
                'date_format:H:i'
            ],

            // Custom Location Details (required when location is 'custom')
            'custom_pickup_address' => [
                'required_if:pickup_location,custom',
                'nullable',
                'string',
                'max:500'
            ],
            'custom_return_address' => [
                'required_if:return_location,custom',
                'nullable',
                'string',
                'max:500'
            ],

            // Customer Information
            'customer_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'customer_email' => [
                'required',
                'email',
                'max:255'
            ],
            'customer_phone' => [
                'required',
                'string',
                'regex:/^[\+]?[1-9][\d]{0,15}$/',
                'max:20'
            ],
            'customer_age' => [
                'required',
                'integer',
                'min:21',
                'max:80'
            ],

            // Driver's License Information
            'license_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9]+$/'
            ],
            'license_expiry' => [
                'required',
                'date',
                'after:today'
            ],
            'license_issuing_country' => [
                'required',
                'string',
                'max:100'
            ],

            // Emergency Contact
            'emergency_contact_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'emergency_contact_phone' => [
                'required',
                'string',
                'regex:/^[\+]?[1-9][\d]{0,15}$/',
                'max:20'
            ],

            // Additional Options
            'additional_drivers' => [
                'nullable',
                'integer',
                'min:0',
                'max:3'
            ],
            'child_seats' => [
                'nullable',
                'integer',
                'min:0',
                'max:4'
            ],
            'gps_navigation' => [
                'nullable',
                'boolean'
            ],
            'insurance_coverage' => [
                'required',
                'string',
                Rule::in(['basic', 'standard', 'premium', 'comprehensive'])
            ],

            // Special Requirements
            'special_requests' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'flight_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[A-Z0-9]+$/'
            ],

            // Payment Information
            'payment_method' => [
                'required',
                'string',
                Rule::in(['credit_card', 'debit_card', 'paypal', 'bank_transfer'])
            ],
            'billing_address' => [
                'required',
                'string',
                'max:500'
            ],
            'billing_city' => [
                'required',
                'string',
                'max:100'
            ],
            'billing_postal_code' => [
                'required',
                'string',
                'max:20'
            ],
            'billing_country' => [
                'required',
                'string',
                'max:100'
            ],

            // Terms and Conditions
            'terms_accepted' => [
                'required',
                'accepted'
            ],
            'marketing_consent' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'car_id.required' => 'Please select a car for your booking.',
            'car_id.exists' => 'The selected car is not available.',
            'pickup_date.required' => 'Please specify your pickup date.',
            'pickup_date.after_or_equal' => 'Pickup date must be today or later.',
            'pickup_date.before' => 'Pickup date must be before return date.',
            'return_date.required' => 'Please specify your return date.',
            'return_date.after' => 'Return date must be after pickup date.',
            'return_date.before_or_equal' => 'Return date cannot be more than one year from now.',
            'customer_name.required' => 'Your full name is required.',
            'customer_name.regex' => 'Name should only contain letters and spaces.',
            'customer_email.required' => 'Email address is required.',
            'customer_email.email' => 'Please provide a valid email address.',
            'customer_phone.required' => 'Phone number is required.',
            'customer_phone.regex' => 'Please provide a valid phone number.',
            'customer_age.required' => 'Age verification is required.',
            'customer_age.min' => 'You must be at least 21 years old to rent a car.',
            'customer_age.max' => 'Maximum age for car rental is 80 years.',
            'license_number.required' => 'Driver\'s license number is required.',
            'license_number.regex' => 'License number should only contain letters and numbers.',
            'license_expiry.required' => 'License expiry date is required.',
            'license_expiry.after' => 'Your driver\'s license must be valid (not expired).',
            'emergency_contact_name.required' => 'Emergency contact name is required.',
            'emergency_contact_phone.required' => 'Emergency contact phone is required.',
            'insurance_coverage.required' => 'Please select an insurance coverage option.',
            'payment_method.required' => 'Please select a payment method.',
            'terms_accepted.required' => 'You must accept the terms and conditions.',
            'terms_accepted.accepted' => 'Please accept the terms and conditions to proceed.',
            'custom_pickup_address.required_if' => 'Please provide pickup address for custom location.',
            'custom_return_address.required_if' => 'Please provide return address for custom location.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'car_id' => 'car selection',
            'pickup_date' => 'pickup date',
            'return_date' => 'return date',
            'pickup_location' => 'pickup location',
            'return_location' => 'return location',
            'pickup_time' => 'pickup time',
            'return_time' => 'return time',
            'customer_name' => 'full name',
            'customer_email' => 'email address',
            'customer_phone' => 'phone number',
            'customer_age' => 'age',
            'license_number' => 'license number',
            'license_expiry' => 'license expiry date',
            'license_issuing_country' => 'license issuing country',
            'emergency_contact_name' => 'emergency contact name',
            'emergency_contact_phone' => 'emergency contact phone',
            'additional_drivers' => 'additional drivers',
            'child_seats' => 'child seats',
            'gps_navigation' => 'GPS navigation',
            'insurance_coverage' => 'insurance coverage',
            'special_requests' => 'special requests',
            'flight_number' => 'flight number',
            'payment_method' => 'payment method',
            'billing_address' => 'billing address',
            'billing_city' => 'billing city',
            'billing_postal_code' => 'postal code',
            'billing_country' => 'billing country',
            'terms_accepted' => 'terms and conditions',
            'marketing_consent' => 'marketing consent',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check if pickup and return dates don't conflict with existing bookings
            if ($this->car_id && $this->pickup_date && $this->return_date) {
                $conflictingBooking = \App\Models\Booking::where('car_id', $this->car_id)
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($query) {
                        $query->whereBetween('pickup_date', [$this->pickup_date, $this->return_date])
                            ->orWhereBetween('return_date', [$this->pickup_date, $this->return_date])
                            ->orWhere(function ($subQuery) {
                                $subQuery->where('pickup_date', '<=', $this->pickup_date)
                                    ->where('return_date', '>=', $this->return_date);
                            });
                    })
                    ->exists();

                if ($conflictingBooking) {
                    $validator->errors()->add('pickup_date', 'This car is not available for the selected dates.');
                    $validator->errors()->add('return_date', 'This car is not available for the selected dates.');
                }
            }

            // Validate that pickup time is reasonable (not in the past for today's bookings)
            if ($this->pickup_date && $this->pickup_time) {
                $pickupDateTime = \Carbon\Carbon::parse($this->pickup_date . ' ' . $this->pickup_time);
                if ($pickupDateTime->isToday() && $pickupDateTime->isPast()) {
                    $validator->errors()->add('pickup_time', 'Pickup time cannot be in the past for today\'s bookings.');
                }
            }

            // Validate minimum rental duration (at least 1 hour)
            if ($this->pickup_date && $this->return_date && $this->pickup_time && $this->return_time) {
                $pickup = \Carbon\Carbon::parse($this->pickup_date . ' ' . $this->pickup_time);
                $return = \Carbon\Carbon::parse($this->return_date . ' ' . $this->return_time);
                
                if ($return->diffInHours($pickup) < 1) {
                    $validator->errors()->add('return_time', 'Minimum rental duration is 1 hour.');
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert boolean strings to actual booleans
        $this->merge([
            'gps_navigation' => filter_var($this->gps_navigation ?? false, FILTER_VALIDATE_BOOLEAN),
            'marketing_consent' => filter_var($this->marketing_consent ?? false, FILTER_VALIDATE_BOOLEAN),
            'terms_accepted' => filter_var($this->terms_accepted ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Clean and format phone numbers
        if ($this->customer_phone) {
            $this->merge([
                'customer_phone' => preg_replace('/[^\d\+]/', '', $this->customer_phone)
            ]);
        }

        if ($this->emergency_contact_phone) {
            $this->merge([
                'emergency_contact_phone' => preg_replace('/[^\d\+]/', '', $this->emergency_contact_phone)
            ]);
        }

        // Uppercase license number
        if ($this->license_number) {
            $this->merge([
                'license_number' => strtoupper($this->license_number)
            ]);
        }

        // Uppercase flight number
        if ($this->flight_number) {
            $this->merge([
                'flight_number' => strtoupper($this->flight_number)
            ]);
        }
    }
}