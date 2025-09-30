# Rentaly - Premium Car Rental Application

A comprehensive Laravel-based car rental platform with modern features, optimized performance, and responsive design.

## 🚀 Features

### Core Functionality
- **Advanced Car Search & Filtering** - Location, dates, car specifications, price ranges
- **Real-time Booking System** - Instant availability checking with conflict prevention
- **User Dashboard** - Profile management, booking history, favorites
- **Admin Panel** - Car management, booking oversight, analytics
- **Multi-theme Support** - Light/dark themes with seamless switching
- **RESTful API** - Complete API for mobile apps and integrations

### Performance Optimizations
- **Vite Asset Bundling** - Optimized CSS/JS compilation and minification
- **Progressive Web App (PWA)** - Offline capabilities and mobile app experience
- **Service Worker** - Caching strategies and background sync
- **Lazy Loading** - Images and components loaded on demand
- **Database Optimization** - Indexed queries and efficient relationships
- **CDN Ready** - Optimized asset delivery

### Technical Stack
- **Framework**: Laravel 12.x
- **Frontend**: Bootstrap 5, Alpine.js, Vite
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Authentication**: Laravel Sanctum
- **Image Processing**: Intervention Image
- **Permissions**: Spatie Laravel Permission
- **PDF Generation**: DomPDF

## 📋 Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18.x or higher
- NPM or Yarn
- SQLite (development) / MySQL 8.0+ or PostgreSQL 13+ (production)

## 🛠️ Installation

### Quick Start

```bash
# Clone the repository
git clone https://github.com/SidTheSloth68/car_rental.git
cd car_rental

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### Production Setup

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

## 🗃️ Database

### Seeded Data
- **Admin User**: admin@rentaly.com / password
- **Test User**: user@rentaly.com / password
- **Sample Cars**: 15+ vehicles with realistic data
- **Sample Bookings**: Various booking scenarios
- **News Articles**: 15 sample blog posts

### Key Models
- `User` - Authentication and user management
- `Car` - Vehicle information and availability
- `Booking` - Reservation system with validation
- `News` - Blog/news content management

## 🎯 API Documentation

### Authentication
```bash
# Use Laravel Sanctum tokens
Authorization: Bearer {token}
```

### Key Endpoints

#### Cars
- `GET /api/v1/cars` - List cars with filters
- `GET /api/v1/cars/{id}` - Car details
- `POST /api/v1/cars/{id}/availability` - Check availability

#### Bookings
- `GET /api/v1/bookings` - User bookings
- `POST /api/v1/bookings` - Create booking
- `PUT /api/v1/bookings/{id}` - Update booking
- `POST /api/v1/bookings/{id}/cancel` - Cancel booking

## 🚀 Performance

### Optimization Features
- **Database Indexing** - Optimized queries for car search and availability
- **Eager Loading** - Prevents N+1 query problems
- **Caching** - Statistics and frequently accessed data
- **Asset Optimization** - Minified CSS/JS with tree shaking
- **Image Optimization** - Lazy loading and responsive images
- **PWA Support** - Offline functionality and caching

## 🛠️ Development

```bash
# Run development server with hot reload
npm run dev
php artisan serve

# Run tests
php artisan test

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan optimize:clear
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Migration Plan

This project follows a detailed 14-day migration plan converting the original HTML template to a full Laravel application. See `LARAVEL_MIGRATION_PLAN.md` for complete details.

Progress: **53/55 commits completed** (96.4%)

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Credits

- Original Template: Rentaly by Designesia
- Framework: [Laravel](https://laravel.com)
- Icons: Font Awesome, Elegant Icons, ET Line Icons

---

**Built with ❤️ using Laravel**
