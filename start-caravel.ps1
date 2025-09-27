# Caravel Laravel Application Starter
Write-Host "🚗 Starting Caravel Car Rental Application..." -ForegroundColor Green

# Set the correct working directory
$LaravelPath = "E:\car_rental\car_rental\car_rental"
Set-Location $LaravelPath

Write-Host "📂 Working Directory: $PWD" -ForegroundColor Cyan

# Check if artisan exists
if (!(Test-Path "artisan")) {
    Write-Host "❌ Error: artisan file not found in current directory!" -ForegroundColor Red
    Write-Host "Current directory: $PWD" -ForegroundColor Yellow
    exit 1
}

# Clear configuration cache
Write-Host "🔄 Clearing Laravel caches..." -ForegroundColor Yellow
php artisan config:clear

# Check database connection
Write-Host "🗄️  Testing database connection..." -ForegroundColor Yellow
php artisan migrate:status

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Database connection successful!" -ForegroundColor Green
    
    # Start the server
    Write-Host "🚀 Starting Laravel development server..." -ForegroundColor Green
    Write-Host "🌐 Application will be available at: http://127.0.0.1:8000" -ForegroundColor Cyan
    Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Yellow
    Write-Host "" 
    
    php artisan serve --host=127.0.0.1 --port=8000
} else {
    Write-Host "❌ Database connection failed! Please check your configuration." -ForegroundColor Red
    exit 1
}