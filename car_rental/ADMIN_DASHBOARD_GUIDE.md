# Admin Dashboard Access Guide

## Overview
The Rentaly Car Rental system now has a comprehensive admin dashboard for managing all database elements through a user-friendly web interface.

## Admin Credentials
- **Email:** admin@rentaly.com
- **Password:** password123

## Accessing the Admin Dashboard

### Step 1: Login
1. Visit: http://127.0.0.1:8000/login
2. Enter the admin credentials above
3. Click "Login"

### Step 2: Access Dashboard
After login, navigate to: http://127.0.0.1:8000/admin/dashboard

## Dashboard Features

### 📊 Main Dashboard
- **Statistics Overview:** Total users, cars, bookings, and news articles
- **Charts:** Monthly booking trends and revenue analytics
- **Recent Activities:** Latest users, bookings, and system activities
- **System Information:** Laravel version, PHP version, environment details

### 👥 User Management (`/admin/users`)
- **View All Users:** Complete list with pagination
- **Search & Filter:** By name, email, role, or status
- **User Details:** View complete user profiles
- **User Actions:** Create, edit, delete users
- **Role Management:** Admin vs Customer roles
- **Statistics:** Total bookings, loyalty points per user

### 🚗 Car Management (`/admin/cars`)
- **Vehicle Inventory:** All cars with availability status
- **Search & Filter:** By brand, model, type, availability
- **Car Details:** Complete specifications and pricing
- **Availability Toggle:** Enable/disable car bookings
- **Booking History:** View bookings per vehicle

### 📅 Booking Management (`/admin/bookings`)
- **All Bookings:** Complete booking history
- **Status Management:** Pending, confirmed, completed, cancelled
- **Search & Filter:** By customer, car, date range, status
- **Booking Details:** Customer info, car details, dates, pricing
- **Status Updates:** Change booking status in real-time

### 📰 News Management (`/admin/news`)
- **Article Management:** All news articles and blog posts
- **Content Status:** Draft, published, archived
- **Category Filtering:** Organize by news categories
- **Publishing Control:** Manage what content is visible
- **Content Analytics:** View article performance

### ⚙️ System Settings (`/admin/settings`)
- **Environment Info:** PHP version, Laravel version
- **System Configuration:** Database, cache, session drivers
- **Debug Information:** Environment and debug mode status
- **Application Details:** URL, timezone, and other settings

## Database Elements You Can View and Manage

### Users Table
- **Total Records:** 36 users (5 admins, 31 customers)
- **Fields Viewable:** name, email, phone, address, role, total_bookings, loyalty_points, preferred_payment_method
- **Actions:** Create, read, update, delete users

### Cars Table
- **Total Records:** 12 vehicles
- **Fields Viewable:** brand, model, type, price_per_day, available, specifications
- **Actions:** Manage inventory, toggle availability, view booking history

### Bookings Table
- **Total Records:** All customer bookings
- **Fields Viewable:** customer details, car info, dates, status, pricing
- **Actions:** Update status, view details, search/filter

### News Table
- **Total Records:** 15 published articles
- **Fields Viewable:** title, content, category, status, comments_count, images
- **Actions:** Manage content, change status, organize by category

## Quick Navigation
The dashboard includes a sidebar navigation with:
- 🏠 Dashboard - Main overview and statistics
- 👥 Users - Customer and admin management
- 🚗 Cars - Vehicle inventory management
- 📅 Bookings - Reservation management
- 📰 News - Content management
- ⚙️ Settings - System configuration
- 🔗 View Website - Link to public site
- 🚪 Logout - Secure session termination

## Security Features
- **Role-Based Access:** Only admin users can access the dashboard
- **Authentication Required:** Must be logged in with admin privileges
- **CSRF Protection:** All forms include security tokens
- **Session Management:** Secure login/logout functionality

## Technical Implementation
- **Framework:** Laravel 12.31.1
- **Database:** SQLite with complete schema
- **Frontend:** Bootstrap 5.3 with responsive design
- **Charts:** Chart.js for analytics visualization
- **Icons:** Font Awesome 6.4.0
- **Security:** Laravel Sanctum and middleware protection

## Alternative Database Access Methods
If you prefer command-line access:

1. **Laravel Tinker:**
   ```bash
   php artisan tinker
   User::count()
   Car::all()
   ```

2. **SQLite Browser:**
   - Download DB Browser for SQLite
   - Open: `database/database.sqlite`

3. **VS Code Extensions:**
   - Install "SQLite Viewer" extension
   - Right-click on `database.sqlite` → "Open with SQLite Viewer"

## Support
The admin dashboard provides a comprehensive interface for managing all aspects of the car rental system. You can view, create, edit, and delete records across all database tables through an intuitive web interface.

For any technical issues, check the Laravel logs in `storage/logs/laravel.log`.