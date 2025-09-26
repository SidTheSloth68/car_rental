# Caravel - Car Rental Management System

A modern car rental management system built with Laravel, converted from the Rentaly HTML template.

## About Caravel

Caravel is a comprehensive car rental management system that provides:

- **Modern Car Booking System** - Easy-to-use car reservation interface
- **User Dashboard** - Complete customer account management
- **Admin Panel** - Full administrative control over cars, bookings, and users
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile devices
- **Dark Theme Support** - Toggle between light and dark modes
- **Advanced Search** - Filter cars by make, model, price, and availability
- **Booking Management** - Track reservations, payments, and rental history

## Features

- 🚗 **Car Management** - Add, edit, and manage vehicle inventory
- 👥 **User Authentication** - Registration, login, and profile management
- 📅 **Booking System** - Real-time availability and reservation management
- 💳 **Payment Integration** - Secure payment processing (planned)
- 📊 **Dashboard Analytics** - Business insights and reporting
- 🌙 **Dark/Light Theme** - User preference themes
- 📱 **Mobile Responsive** - Optimized for all devices
- 🔍 **Advanced Search** - Filter and search functionality
- ⭐ **Reviews & Ratings** - Customer feedback system
- 📧 **Email Notifications** - Automated booking confirmations

## Technology Stack

- **Backend**: Laravel 12.x
- **Database**: SQLite (development) / MySQL (production)
- **Frontend**: Blade Templates with Bootstrap
- **Assets**: Vite for compilation
- **Authentication**: Laravel Breeze
- **Testing**: PHPUnit

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/SidTheSloth68/car_rental.git
   cd car_rental
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run dev
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Migration Plan

This project follows a detailed 14-day migration plan converting the original HTML template to a full Laravel application. See `LARAVEL_MIGRATION_PLAN.md` for complete details.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- Original HTML Template: Rentaly by Designesia
- Laravel Framework: [Laravel](https://laravel.com)
- Icons: Font Awesome, Elegant Icons, ET Line Icons
