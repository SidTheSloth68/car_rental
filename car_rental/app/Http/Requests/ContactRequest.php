<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can submit a contact form
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
            // Basic Contact Information
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^[\+]?[1-9][\d]{0,15}$/',
                'max:20'
            ],

            // Subject and Message
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9\s\-\?\!\.\,\'\"]+$/'
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000'
            ],

            // Contact Type/Category
            'contact_type' => [
                'required',
                'string',
                Rule::in([
                    'general_inquiry',
                    'booking_support',
                    'technical_issue',
                    'billing_question',
                    'feedback',
                    'complaint',
                    'partnership',
                    'media_inquiry',
                    'other'
                ])
            ],

            // Additional Information
            'company' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-\&\.\,\'\"]+$/'
            ],
            'preferred_contact_method' => [
                'nullable',
                'string',
                Rule::in(['email', 'phone', 'either'])
            ],
            'best_time_to_contact' => [
                'nullable',
                'string',
                Rule::in(['morning', 'afternoon', 'evening', 'anytime'])
            ],

            // Location Information
            'country' => [
                'nullable',
                'string',
                'max:100'
            ],
            'city' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],

            // Booking Related (if applicable)
            'booking_reference' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\-]+$/'
            ],
            'car_of_interest' => [
                'nullable',
                'string',
                'max:100'
            ],

            // Priority Level
            'priority' => [
                'nullable',
                'string',
                Rule::in(['low', 'normal', 'high', 'urgent'])
            ],

            // Privacy and Terms
            'privacy_accepted' => [
                'required',
                'accepted'
            ],
            'newsletter_signup' => [
                'nullable',
                'boolean'
            ],

            // Anti-spam Protection
            'website' => [
                'nullable',
                'max:0' // Honeypot field - should be empty
            ],

            // CAPTCHA (if implementing)
            'captcha' => [
                'nullable',
                'string'
            ],

            // File Attachments
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif',
                'max:10240' // 10MB max
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Your name is required.',
            'name.min' => 'Name must be at least 2 characters long.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'name.regex' => 'Name can only contain letters, spaces, hyphens, apostrophes, and periods.',
            
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            
            'subject.required' => 'Subject is required.',
            'subject.min' => 'Subject must be at least 5 characters long.',
            'subject.max' => 'Subject cannot exceed 200 characters.',
            'subject.regex' => 'Subject contains invalid characters.',
            
            'message.required' => 'Message is required.',
            'message.min' => 'Message must be at least 10 characters long.',
            'message.max' => 'Message cannot exceed 2000 characters.',
            
            'contact_type.required' => 'Please select a contact type.',
            'contact_type.in' => 'Invalid contact type selected.',
            
            'company.max' => 'Company name cannot exceed 255 characters.',
            'company.regex' => 'Company name contains invalid characters.',
            
            'preferred_contact_method.in' => 'Invalid contact method selected.',
            'best_time_to_contact.in' => 'Invalid contact time selected.',
            
            'country.max' => 'Country name cannot exceed 100 characters.',
            'city.max' => 'City name cannot exceed 100 characters.',
            'city.regex' => 'City name can only contain letters, spaces, hyphens, apostrophes, and periods.',
            
            'booking_reference.max' => 'Booking reference cannot exceed 50 characters.',
            'booking_reference.regex' => 'Booking reference format is invalid.',
            
            'car_of_interest.max' => 'Car of interest cannot exceed 100 characters.',
            
            'priority.in' => 'Invalid priority level selected.',
            
            'privacy_accepted.required' => 'You must accept the privacy policy.',
            'privacy_accepted.accepted' => 'Please accept the privacy policy to continue.',
            
            'website.max' => 'Please leave the website field empty.',
            
            'attachment.file' => 'Uploaded file is invalid.',
            'attachment.mimes' => 'File must be a PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, or GIF.',
            'attachment.max' => 'File size cannot exceed 10MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'phone' => 'phone number',
            'subject' => 'subject',
            'message' => 'message',
            'contact_type' => 'contact type',
            'company' => 'company name',
            'preferred_contact_method' => 'preferred contact method',
            'best_time_to_contact' => 'best time to contact',
            'country' => 'country',
            'city' => 'city',
            'booking_reference' => 'booking reference',
            'car_of_interest' => 'car of interest',
            'priority' => 'priority level',
            'privacy_accepted' => 'privacy policy acceptance',
            'newsletter_signup' => 'newsletter signup',
            'attachment' => 'file attachment',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check for spam patterns in message
            $spamPatterns = [
                '/\b(viagra|cialis|casino|poker|lottery|winner)\b/i',
                '/\b(click here|free money|make money fast)\b/i',
                '/\b(guarantee|act now|limited time)\b/i',
                '/(http:\/\/|https:\/\/|www\.)[^\s]+/i' // URLs in message
            ];

            foreach ($spamPatterns as $pattern) {
                if (preg_match($pattern, $this->message)) {
                    $validator->errors()->add('message', 'Your message appears to contain spam content.');
                    break;
                }
            }

            // Check for excessive capitalization
            if (strlen($this->message) > 0) {
                $upperCount = preg_match_all('/[A-Z]/', $this->message);
                $totalCount = strlen(preg_replace('/[^a-zA-Z]/', '', $this->message));
                
                if ($totalCount > 0 && ($upperCount / $totalCount) > 0.8) {
                    $validator->errors()->add('message', 'Please avoid excessive use of capital letters.');
                }
            }

            // Validate booking reference if provided
            if ($this->booking_reference) {
                $bookingExists = \App\Models\Booking::where('reference_number', $this->booking_reference)->exists();
                if (!$bookingExists) {
                    $validator->errors()->add('booking_reference', 'The provided booking reference was not found.');
                }
            }

            // Check if email is from a disposable email service
            $disposableDomains = [
                '10minutemail.com', 'tempmail.org', 'guerrillamail.com',
                'mailinator.com', 'trash-mail.com', 'temp-mail.org'
            ];
            
            $emailDomain = substr(strrchr($this->email, "@"), 1);
            if (in_array(strtolower($emailDomain), $disposableDomains)) {
                $validator->errors()->add('email', 'Please use a permanent email address.');
            }

            // Honeypot validation
            if (!empty($this->website)) {
                $validator->errors()->add('website', 'Spam detected.');
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and format data
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => strtolower(trim($this->email ?? '')),
            'subject' => trim($this->subject ?? ''),
            'message' => trim($this->message ?? ''),
            'company' => trim($this->company ?? ''),
            'city' => trim($this->city ?? ''),
            'country' => trim($this->country ?? ''),
        ]);

        // Clean phone number
        if ($this->phone) {
            $this->merge([
                'phone' => preg_replace('/[^\d\+]/', '', $this->phone)
            ]);
        }

        // Uppercase booking reference
        if ($this->booking_reference) {
            $this->merge([
                'booking_reference' => strtoupper(trim($this->booking_reference))
            ]);
        }

        // Convert boolean fields
        $this->merge([
            'newsletter_signup' => filter_var($this->newsletter_signup ?? false, FILTER_VALIDATE_BOOLEAN),
            'privacy_accepted' => filter_var($this->privacy_accepted ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Set default priority if not provided
        if (empty($this->priority)) {
            $this->merge(['priority' => 'normal']);
        }

        // Set default preferred contact method
        if (empty($this->preferred_contact_method)) {
            $this->merge(['preferred_contact_method' => 'email']);
        }
    }

    /**
     * Get the contact type options for forms.
     */
    public static function getContactTypes(): array
    {
        return [
            'general_inquiry' => 'General Inquiry',
            'booking_support' => 'Booking Support',
            'technical_issue' => 'Technical Issue',
            'billing_question' => 'Billing Question',
            'feedback' => 'Feedback',
            'complaint' => 'Complaint',
            'partnership' => 'Partnership Opportunity',
            'media_inquiry' => 'Media Inquiry',
            'other' => 'Other'
        ];
    }

    /**
     * Get the priority levels for forms.
     */
    public static function getPriorityLevels(): array
    {
        return [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];
    }

    /**
     * Get the contact method options for forms.
     */
    public static function getContactMethods(): array
    {
        return [
            'email' => 'Email',
            'phone' => 'Phone',
            'either' => 'Either Email or Phone'
        ];
    }

    /**
     * Get the best time to contact options for forms.
     */
    public static function getBestTimeOptions(): array
    {
        return [
            'morning' => 'Morning (9 AM - 12 PM)',
            'afternoon' => 'Afternoon (12 PM - 5 PM)',
            'evening' => 'Evening (5 PM - 8 PM)',
            'anytime' => 'Anytime'
        ];
    }
}