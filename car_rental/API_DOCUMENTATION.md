# Rentaly API Documentation

This document provides comprehensive information about the Rentaly Car Rental API endpoints, authentication, and usage examples.

## Table of Contents

1. [Overview](#overview)
2. [Authentication](#authentication)
3. [Rate Limiting](#rate-limiting)
4. [Response Format](#response-format)
5. [Error Handling](#error-handling)
6. [Endpoints](#endpoints)
   - [Cars](#cars-api)
   - [Bookings](#bookings-api)
   - [Users](#users-api)
7. [Examples](#examples)
8. [SDKs](#sdks)

## Overview

The Rentaly API is a RESTful API that allows you to interact with the car rental system programmatically. It supports JSON requests and responses, and uses Laravel Sanctum for authentication.

**Base URL**: `https://your-domain.com/api/v1`

**Content-Type**: `application/json`

**API Version**: v1.0.0

## Authentication

The API uses Laravel Sanctum token-based authentication. You need to obtain an access token to make authenticated requests.

### Obtaining an Access Token

Currently, tokens are issued through the web interface. In a future version, we'll add API authentication endpoints.

### Using the Token

Include the token in the Authorization header:

```http
Authorization: Bearer {your-access-token}
```

### Example

```bash
curl -H "Authorization: Bearer 1|abc123def456ghi789" \
     -H "Content-Type: application/json" \
     https://your-domain.com/api/v1/cars
```

## Rate Limiting

The API implements rate limiting to ensure fair usage:

- **General endpoints**: 60 requests per minute
- **Sensitive endpoints**: 10 requests per minute (e.g., booking creation)

Rate limit headers are included in all responses:

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1640995200
```

## Response Format

All API responses follow a consistent JSON structure:

### Success Response

```json
{
    "success": true,
    "message": "Request completed successfully",
    "data": {
        // Response data
    }
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error description",
    "error": "Detailed error (only in debug mode)"
}
```

### Paginated Response

```json
{
    "success": true,
    "message": "Cars retrieved successfully",
    "data": {
        "cars": [...],
        "pagination": {
            "current_page": 1,
            "per_page": 15,
            "total": 150,
            "last_page": 10,
            "from": 1,
            "to": 15
        }
    }
}
```

## Error Handling

The API uses standard HTTP status codes:

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `429` - Too Many Requests
- `500` - Internal Server Error

### Validation Errors

```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "pickup_date": ["The pickup date is required."],
        "return_date": ["The return date must be after pickup date."]
    }
}
```

## Endpoints

## Cars API

### List Cars

Retrieve a paginated list of available cars with filtering options.

**Endpoint**: `GET /cars`

**Authentication**: Not required

**Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `page` | integer | No | Page number (default: 1) |
| `per_page` | integer | No | Items per page (max: 50, default: 15) |
| `location` | string | No | Filter by location |
| `pickup_date` | date | No | Pickup date (Y-m-d format) |
| `return_date` | date | No | Return date (Y-m-d format) |
| `make` | string | No | Filter by car make |
| `type` | string | No | Filter by car type |
| `min_price` | decimal | No | Minimum daily rate |
| `max_price` | decimal | No | Maximum daily rate |
| `seats` | integer | No | Minimum number of seats |
| `transmission` | string | No | `automatic` or `manual` |
| `fuel_type` | string | No | `gasoline`, `diesel`, `hybrid`, `electric` |
| `features` | array | No | Array of required features |
| `sort_by` | string | No | Sort field (default: `created_at`) |
| `sort_order` | string | No | `asc` or `desc` (default: `desc`) |
| `available_only` | boolean | No | Show only available cars |

**Example Request**:

```bash
curl "https://your-domain.com/api/v1/cars?location=New%20York&pickup_date=2024-01-15&return_date=2024-01-20&type=sedan&min_price=50&max_price=150&sort_by=daily_rate&sort_order=asc"
```

**Example Response**:

```json
{
    "success": true,
    "message": "Cars retrieved successfully",
    "data": {
        "cars": [
            {
                "id": 1,
                "make": "Toyota",
                "model": "Camry",
                "year": 2023,
                "type": "sedan",
                "daily_rate": 75.00,
                "weekly_rate": 450.00,
                "monthly_rate": 1800.00,
                "transmission": "automatic",
                "fuel_type": "gasoline",
                "seats": 5,
                "doors": 4,
                "air_conditioning": true,
                "gps_navigation": true,
                "bluetooth": true,
                "backup_camera": true,
                "image": "/images/cars/toyota-camry-2023.jpg",
                "location": "New York",
                "available": true,
                "rating": 4.5,
                "total_ratings": 128,
                "features": ["air_conditioning", "gps_navigation", "bluetooth"]
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 15,
            "total": 25,
            "last_page": 2,
            "from": 1,
            "to": 15
        },
        "filters": {
            "makes": ["Toyota", "Honda", "Ford"],
            "types": ["sedan", "suv", "compact"],
            "locations": ["New York", "Los Angeles", "Chicago"],
            "price_range": {
                "min": 25.00,
                "max": 300.00
            }
        }
    }
}
```

### Get Car Details

Retrieve detailed information about a specific car.

**Endpoint**: `GET /cars/{id}`

**Authentication**: Not required

**Example Request**:

```bash
curl "https://your-domain.com/api/v1/cars/1"
```

**Example Response**:

```json
{
    "success": true,
    "message": "Car details retrieved successfully",
    "data": {
        "car": {
            "id": 1,
            "make": "Toyota",
            "model": "Camry",
            "year": 2023,
            "type": "sedan",
            "description": "Comfortable and reliable sedan perfect for business trips and family travel.",
            "daily_rate": 75.00,
            "weekly_rate": 450.00,
            "monthly_rate": 1800.00,
            "transmission": "automatic",
            "fuel_type": "gasoline",
            "engine_size": "2.5L",
            "seats": 5,
            "doors": 4,
            "luggage_capacity": 15.1,
            "fuel_economy": "28 city / 39 highway",
            "air_conditioning": true,
            "gps_navigation": true,
            "bluetooth": true,
            "backup_camera": true,
            "cruise_control": true,
            "heated_seats": false,
            "sunroof": false,
            "images": [
                "/images/cars/toyota-camry-2023-1.jpg",
                "/images/cars/toyota-camry-2023-2.jpg",
                "/images/cars/toyota-camry-2023-3.jpg"
            ],
            "location": "New York",
            "available": true,
            "rating": 4.5,
            "total_ratings": 128,
            "total_bookings": 45,
            "created_at": "2024-01-01T12:00:00Z",
            "updated_at": "2024-01-10T10:30:00Z"
        },
        "related_cars": [
            {
                "id": 2,
                "make": "Honda",
                "model": "Accord",
                "daily_rate": 80.00,
                "image": "/images/cars/honda-accord-2023.jpg"
            }
        ],
        "availability_calendar": {
            "2024-01-15": true,
            "2024-01-16": true,
            "2024-01-17": false,
            "2024-01-18": true
        }
    }
}
```

### Check Car Availability

Check if a car is available for specific dates.

**Endpoint**: `POST /cars/{id}/availability`

**Authentication**: Not required

**Request Body**:

```json
{
    "pickup_date": "2024-01-15",
    "return_date": "2024-01-20",
    "pickup_time": "10:00",
    "return_time": "10:00"
}
```

**Example Response**:

```json
{
    "success": true,
    "message": "Availability checked successfully",
    "data": {
        "available": true,
        "pricing": {
            "daily_rate": 75.00,
            "rental_days": 5,
            "base_amount": 375.00,
            "tax_amount": 37.50,
            "insurance_amount": 50.00,
            "total_amount": 462.50
        },
        "restrictions": [],
        "alternative_dates": []
    }
}
```

### Get Featured Cars

Retrieve a list of featured cars.

**Endpoint**: `GET /cars/featured`

**Authentication**: Not required

**Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | integer | No | Number of cars to return (max: 20, default: 8) |

**Example Response**:

```json
{
    "success": true,
    "message": "Featured cars retrieved successfully",
    "data": {
        "featured_cars": [...],
        "count": 8
    }
}
```

### Get Car Makes and Models

Retrieve available car makes and models for filters.

**Endpoint**: `GET /cars/makes`

**Authentication**: Not required

**Example Response**:

```json
{
    "success": true,
    "message": "Car makes retrieved successfully",
    "data": {
        "makes": [
            {
                "make": "Toyota",
                "models": ["Camry", "Corolla", "RAV4", "Highlander"],
                "count": 15
            },
            {
                "make": "Honda",
                "models": ["Accord", "Civic", "CR-V", "Pilot"],
                "count": 12
            }
        ]
    }
}
```

### Get Car Statistics

Retrieve statistical information about cars.

**Endpoint**: `GET /cars/statistics`

**Authentication**: Not required

**Example Response**:

```json
{
    "success": true,
    "message": "Car statistics retrieved successfully",
    "data": {
        "total_cars": 150,
        "available_cars": 123,
        "car_types": {
            "sedan": 45,
            "suv": 35,
            "compact": 30,
            "luxury": 25,
            "convertible": 15
        },
        "locations": {
            "New York": 45,
            "Los Angeles": 38,
            "Chicago": 32,
            "Miami": 25,
            "San Francisco": 10
        },
        "average_rating": 4.3,
        "price_range": {
            "min": 25.00,
            "max": 300.00,
            "average": 85.50
        }
    }
}
```

## Bookings API

All booking endpoints require authentication.

### List User Bookings

Retrieve a paginated list of user's bookings.

**Endpoint**: `GET /bookings`

**Authentication**: Required

**Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `page` | integer | No | Page number (default: 1) |
| `per_page` | integer | No | Items per page (max: 50, default: 15) |
| `status` | string | No | Filter by status |
| `date_from` | date | No | Filter bookings from date |
| `date_to` | date | No | Filter bookings to date |
| `car_id` | integer | No | Filter by car ID |
| `sort_by` | string | No | Sort field (default: `created_at`) |
| `sort_order` | string | No | `asc` or `desc` (default: `desc`) |

**Example Response**:

```json
{
    "success": true,
    "message": "Bookings retrieved successfully",
    "data": {
        "bookings": [
            {
                "id": 1,
                "reference_number": "BK20240115ABC123",
                "status": "confirmed",
                "pickup_date": "2024-01-15",
                "return_date": "2024-01-20",
                "pickup_location": "New York Airport",
                "return_location": "New York Airport",
                "total_amount": 375.00,
                "final_amount": 462.50,
                "rental_days": 5,
                "created_at": "2024-01-10T14:30:00Z",
                "car": {
                    "id": 1,
                    "make": "Toyota",
                    "model": "Camry",
                    "year": 2023,
                    "image": "/images/cars/toyota-camry-2023.jpg",
                    "type": "sedan"
                }
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 15,
            "total": 8,
            "last_page": 1,
            "from": 1,
            "to": 8
        },
        "statistics": {
            "total": 8,
            "pending": 1,
            "confirmed": 5,
            "completed": 1,
            "cancelled": 1
        }
    }
}
```

### Create Booking

Create a new car reservation.

**Endpoint**: `POST /bookings`

**Authentication**: Required

**Request Body**:

```json
{
    "car_id": 1,
    "pickup_date": "2024-01-15",
    "return_date": "2024-01-20",
    "pickup_time": "10:00",
    "return_time": "10:00",
    "pickup_location": "New York Airport",
    "return_location": "New York Airport",
    "customer_name": "John Doe",
    "customer_email": "john@example.com",
    "customer_phone": "+1234567890",
    "insurance_coverage": "standard",
    "additional_drivers": 1,
    "child_seats": 0,
    "gps_navigation": true,
    "special_requests": "Non-smoking vehicle preferred"
}
```

**Validation Rules**:

- `car_id`: Required, must exist in cars table
- `pickup_date`: Required, must be today or future date
- `return_date`: Required, must be after pickup_date
- `pickup_time`: Required, valid time format (HH:MM)
- `return_time`: Required, valid time format (HH:MM)
- `customer_name`: Required, minimum 2 characters
- `customer_email`: Required, valid email format
- `customer_phone`: Required, valid phone format
- `insurance_coverage`: Required, one of: basic, standard, premium, comprehensive

**Example Response**:

```json
{
    "success": true,
    "message": "Booking created successfully",
    "data": {
        "booking": {
            "id": 15,
            "reference_number": "BK20240115XYZ789",
            "status": "pending",
            "car_id": 1,
            "pickup_date": "2024-01-15",
            "return_date": "2024-01-20",
            "pickup_time": "10:00",
            "return_time": "10:00",
            "pickup_location": "New York Airport",
            "return_location": "New York Airport",
            "customer_name": "John Doe",
            "customer_email": "john@example.com",
            "customer_phone": "+1234567890",
            "total_amount": 375.00,
            "tax_amount": 37.50,
            "insurance_amount": 50.00,
            "additional_fees": 10.00,
            "final_amount": 472.50,
            "rental_days": 5,
            "insurance_coverage": "standard",
            "additional_drivers": 1,
            "child_seats": 0,
            "created_at": "2024-01-10T15:45:00Z",
            "car": {
                "id": 1,
                "make": "Toyota",
                "model": "Camry",
                "year": 2023,
                "image": "/images/cars/toyota-camry-2023.jpg"
            }
        },
        "payment_instructions": {
            "reference_number": "BK20240115XYZ789",
            "amount": 472.50,
            "currency": "USD",
            "payment_methods": ["credit_card", "debit_card", "paypal"],
            "payment_deadline": "2024-01-11T15:45:00Z"
        }
    }
}
```

### Get Booking Details

Retrieve detailed information about a specific booking.

**Endpoint**: `GET /bookings/{id}`

**Authentication**: Required (user can only access their own bookings)

**Example Response**:

```json
{
    "success": true,
    "message": "Booking details retrieved successfully",
    "data": {
        "booking": {
            // Full booking details with all fields
        },
        "timeline": [
            {
                "date": "2024-01-10T15:45:00Z",
                "event": "Booking Created",
                "description": "Booking was created and is pending confirmation"
            }
        ],
        "payment_history": []
    }
}
```

### Update Booking

Update an existing booking (limited fields based on status).

**Endpoint**: `PUT /bookings/{id}`

**Authentication**: Required

**Request Body** (example for pending booking):

```json
{
    "pickup_date": "2024-01-16",
    "return_date": "2024-01-21",
    "pickup_time": "09:00",
    "special_requests": "Updated special requests"
}
```

### Cancel Booking

Cancel an existing booking.

**Endpoint**: `POST /bookings/{id}/cancel`

**Authentication**: Required

**Request Body**:

```json
{
    "reason": "Change of plans"
}
```

**Example Response**:

```json
{
    "success": true,
    "message": "Booking cancelled successfully",
    "data": {
        "booking": {
            // Updated booking with cancelled status
        },
        "refund_details": {
            "refund_amount": 400.00,
            "cancellation_fee": 72.50,
            "refund_timeline": "3-5 business days"
        }
    }
}
```

### Get Booking Statistics

Retrieve user's booking statistics.

**Endpoint**: `GET /bookings/statistics`

**Authentication**: Required

**Example Response**:

```json
{
    "success": true,
    "message": "Booking statistics retrieved successfully",
    "data": {
        "total_bookings": 15,
        "active_bookings": 2,
        "completed_bookings": 10,
        "cancelled_bookings": 2,
        "pending_bookings": 1,
        "total_amount_spent": 3450.00,
        "average_booking_value": 230.00,
        "bookings_by_month": [...],
        "popular_cars": [...],
        "booking_status_distribution": {
            "pending": 1,
            "confirmed": 2,
            "completed": 10,
            "cancelled": 2
        }
    }
}
```

### Get Upcoming Bookings

Retrieve user's upcoming bookings.

**Endpoint**: `GET /bookings/upcoming`

**Authentication**: Required

**Example Response**:

```json
{
    "success": true,
    "message": "Upcoming bookings retrieved successfully",
    "data": {
        "upcoming_bookings": [...],
        "count": 3
    }
}
```

## Users API

### Get Current User

Retrieve information about the authenticated user.

**Endpoint**: `GET /user`

**Authentication**: Required

**Example Response**:

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": "2024-01-01T12:00:00Z",
        "created_at": "2024-01-01T12:00:00Z",
        "updated_at": "2024-01-10T10:30:00Z"
    }
}
```

## Examples

### Complete Booking Flow

Here's an example of a complete booking flow using the API:

#### 1. Search for Cars

```bash
curl "https://your-domain.com/api/v1/cars?location=New%20York&pickup_date=2024-01-15&return_date=2024-01-20&type=sedan"
```

#### 2. Check Car Availability

```bash
curl -X POST "https://your-domain.com/api/v1/cars/1/availability" \
     -H "Content-Type: application/json" \
     -d '{
       "pickup_date": "2024-01-15",
       "return_date": "2024-01-20",
       "pickup_time": "10:00",
       "return_time": "10:00"
     }'
```

#### 3. Create Booking

```bash
curl -X POST "https://your-domain.com/api/v1/bookings" \
     -H "Authorization: Bearer your-token" \
     -H "Content-Type: application/json" \
     -d '{
       "car_id": 1,
       "pickup_date": "2024-01-15",
       "return_date": "2024-01-20",
       "pickup_time": "10:00",
       "return_time": "10:00",
       "pickup_location": "New York Airport",
       "return_location": "New York Airport",
       "customer_name": "John Doe",
       "customer_email": "john@example.com",
       "customer_phone": "+1234567890",
       "insurance_coverage": "standard"
     }'
```

#### 4. Check Booking Status

```bash
curl "https://your-domain.com/api/v1/bookings/15" \
     -H "Authorization: Bearer your-token"
```

### Error Handling Example

```javascript
async function searchCars(params) {
    try {
        const response = await fetch(`/api/v1/cars?${new URLSearchParams(params)}`);
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Request failed');
        }
        
        if (data.success) {
            return data.data;
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('API Error:', error.message);
        throw error;
    }
}
```

## SDKs

### JavaScript/Node.js SDK Example

```javascript
class RentalyAPI {
    constructor(baseURL, token = null) {
        this.baseURL = baseURL;
        this.token = token;
    }
    
    setToken(token) {
        this.token = token;
    }
    
    async request(endpoint, options = {}) {
        const url = `${this.baseURL}${endpoint}`;
        const headers = {
            'Content-Type': 'application/json',
            ...options.headers
        };
        
        if (this.token) {
            headers.Authorization = `Bearer ${this.token}`;
        }
        
        const response = await fetch(url, {
            ...options,
            headers
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Request failed');
        }
        
        return data;
    }
    
    // Cars
    async getCars(params = {}) {
        return this.request(`/cars?${new URLSearchParams(params)}`);
    }
    
    async getCar(id) {
        return this.request(`/cars/${id}`);
    }
    
    async checkAvailability(carId, dates) {
        return this.request(`/cars/${carId}/availability`, {
            method: 'POST',
            body: JSON.stringify(dates)
        });
    }
    
    // Bookings
    async getBookings(params = {}) {
        return this.request(`/bookings?${new URLSearchParams(params)}`);
    }
    
    async createBooking(bookingData) {
        return this.request('/bookings', {
            method: 'POST',
            body: JSON.stringify(bookingData)
        });
    }
    
    async getBooking(id) {
        return this.request(`/bookings/${id}`);
    }
    
    async cancelBooking(id, reason) {
        return this.request(`/bookings/${id}/cancel`, {
            method: 'POST',
            body: JSON.stringify({ reason })
        });
    }
}

// Usage
const api = new RentalyAPI('https://your-domain.com/api/v1');
api.setToken('your-access-token');

// Search cars
const cars = await api.getCars({ location: 'New York', type: 'sedan' });

// Create booking
const booking = await api.createBooking({
    car_id: 1,
    pickup_date: '2024-01-15',
    return_date: '2024-01-20',
    // ... other fields
});
```

## Changelog

### v1.0.0 (2024-01-15)
- Initial API release
- Cars endpoints (list, details, availability, featured, makes, statistics)
- Bookings endpoints (CRUD operations, statistics)
- Authentication with Laravel Sanctum
- Rate limiting implementation
- Comprehensive error handling

---

For more information or support, please contact: api-support@rentaly.com