# Rentaly Installation Guide

This guide provides detailed instructions for setting up the Rentaly car rental application in different environments.

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Local Development Setup](#local-development-setup)
3. [Production Deployment](#production-deployment)
4. [Docker Installation](#docker-installation)
5. [Configuration](#configuration)
6. [Troubleshooting](#troubleshooting)

## System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher
- **Composer**: 2.x
- **Node.js**: 18.x or higher
- **NPM**: 9.x or higher (or Yarn 1.22+)
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: SQLite 3.35+ (development) or MySQL 8.0+ / PostgreSQL 13+ (production)

### Recommended Requirements
- **PHP**: 8.3
- **Memory**: 512MB minimum, 1GB recommended
- **Storage**: 2GB free space
- **Extensions**: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, ZIP, GD, Imagick

### PHP Extensions
Ensure the following PHP extensions are installed:
```bash
# On Ubuntu/Debian
sudo apt install php8.3-bcmath php8.3-ctype php8.3-fileinfo php8.3-json php8.3-mbstring php8.3-openssl php8.3-pdo php8.3-tokenizer php8.3-xml php8.3-zip php8.3-gd php8.3-imagick php8.3-curl php8.3-mysql php8.3-sqlite3

# On CentOS/RHEL
sudo yum install php-bcmath php-ctype php-fileinfo php-json php-mbstring php-openssl php-pdo php-tokenizer php-xml php-zip php-gd php-imagick php-curl php-mysql php-sqlite
```

## Local Development Setup

### Step 1: Clone Repository

```bash
# Using HTTPS
git clone https://github.com/SidTheSloth68/car_rental.git

# Using SSH
git clone git@github.com:SidTheSloth68/car_rental.git

# Navigate to project directory
cd car_rental
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Alternative: Using Yarn
yarn install
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Generate JWT secret (if using JWT authentication)
php artisan jwt:secret
```

### Step 4: Database Setup

#### Using SQLite (Default for Development)
```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

#### Using MySQL
```bash
# Create database
mysql -u root -p
CREATE DATABASE car_rental;
exit

# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### Step 5: Storage and Permissions

```bash
# Create storage symlink
php artisan storage:link

# Set proper permissions (Linux/macOS)
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# For production environments
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/
```

### Step 6: Asset Compilation

```bash
# Development build
npm run dev

# Production build
npm run build

# Watch for changes (development)
npm run dev -- --watch
```

### Step 7: Start Development Server

```bash
# Start Laravel development server
php artisan serve

# Alternative: Specify host and port
php artisan serve --host=0.0.0.0 --port=8080
```

## Production Deployment

### Step 1: Server Preparation

#### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/car_rental/public
    
    <Directory /var/www/car_rental/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/car_rental_error.log
    CustomLog ${APACHE_LOG_DIR}/car_rental_access.log combined
</VirtualHost>
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/car_rental/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Step 2: Production Installation

```bash
# Clone repository
git clone https://github.com/SidTheSloth68/car_rental.git
cd car_rental

# Install dependencies (production)
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
npm ci

# Environment setup
cp .env.example .env
# Edit .env file with production settings
nano .env

# Generate keys
php artisan key:generate

# Database setup
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Build production assets
npm run build

# Set permissions
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Create storage symlink
php artisan storage:link
```

### Step 3: SSL Configuration

```bash
# Using Certbot (Let's Encrypt)
sudo certbot --apache -d your-domain.com

# Or for Nginx
sudo certbot --nginx -d your-domain.com
```

### Step 4: Queue and Scheduler Setup

```bash
# Add to crontab
crontab -e

# Add this line:
* * * * * cd /var/www/car_rental && php artisan schedule:run >> /dev/null 2>&1
```

#### Supervisor Configuration for Queues
```ini
# /etc/supervisor/conf.d/car_rental.conf
[program:car_rental_worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/car_rental/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/car_rental/storage/logs/worker.log
```

## Docker Installation

### Step 1: Docker Compose Setup

Create `docker-compose.yml`:
```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8000:80"
    volumes:
      - .:/var/www/html
    environment:
      - APP_ENV=local
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_DATABASE=car_rental
      - DB_USERNAME=root
      - DB_PASSWORD=secret
    depends_on:
      - db
      - redis

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: car_rental
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"

  node:
    image: node:18-alpine
    working_dir: /app
    volumes:
      - .:/app
    command: npm run dev

volumes:
  mysql_data:
```

### Step 2: Dockerfile

Create `Dockerfile`:
```dockerfile
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy application files
COPY . .

# Copy package.json and install Node.js dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Build assets
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data storage/ bootstrap/cache/
RUN chmod -R 775 storage/ bootstrap/cache/

# Configure Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
```

### Step 3: Run Docker Containers

```bash
# Build and start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed
```

## Configuration

### Environment Variables

#### Required Variables
```env
APP_NAME="Rentaly"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Optional Variables
```env
# Cache Configuration
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# File Storage
FILESYSTEM_DISK=local

# API Rate Limiting
API_RATE_LIMIT=60

# Image Processing
IMAGE_QUALITY=85
IMAGE_MAX_WIDTH=1920
IMAGE_MAX_HEIGHT=1080
```

### Performance Optimization

```bash
# Production optimization commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear all caches
php artisan optimize:clear

# Optimize Composer autoloader
composer dump-autoload --optimize

# Enable OPcache (in php.ini)
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
opcache.validate_timestamps=0
```

## Troubleshooting

### Common Issues

#### 1. Permission Errors
```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/

# Fix bootstrap/cache permissions
sudo chown -R www-data:www-data bootstrap/cache/
sudo chmod -R 775 bootstrap/cache/
```

#### 2. 500 Internal Server Error
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server logs
# Apache
tail -f /var/log/apache2/error.log

# Nginx
tail -f /var/log/nginx/error.log
```

#### 3. Database Connection Issues
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Clear config cache
php artisan config:clear

# Verify database credentials in .env
```

#### 4. Asset Compilation Issues
```bash
# Clear node modules and reinstall
rm -rf node_modules/
rm package-lock.json
npm install

# Clear Vite cache
rm -rf node_modules/.vite/

# Rebuild assets
npm run build
```

#### 5. Queue Jobs Not Processing
```bash
# Restart queue workers
php artisan queue:restart

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

### Debug Mode

For troubleshooting, temporarily enable debug mode:

```bash
# In .env file
APP_DEBUG=true

# Remember to disable in production
APP_DEBUG=false
```

### Performance Monitoring

```bash
# Monitor query performance
php artisan telescope:install

# Check application performance
php artisan route:list
php artisan config:show database

# Monitor logs
tail -f storage/logs/laravel.log
```

## Support

If you encounter issues not covered in this guide:

1. Check the [GitHub Issues](https://github.com/SidTheSloth68/car_rental/issues)
2. Review Laravel documentation at [laravel.com](https://laravel.com/docs)
3. Contact support at support@rentaly.com

---

**Installation complete! 🚀**

Visit your application URL to start using Rentaly.