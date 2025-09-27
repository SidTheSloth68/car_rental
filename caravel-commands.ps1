# Quick Laravel Commands for Caravel
# Add this to your PowerShell profile for permanent access

function Start-Caravel {
    Set-Location "E:\car_rental\car_rental\car_rental"
    & "E:\car_rental\car_rental\start-caravel.ps1"
}

function Caravel-Migrate {
    Set-Location "E:\car_rental\car_rental\car_rental"
    php artisan migrate:status
}

function Caravel-Cache-Clear {
    Set-Location "E:\car_rental\car_rental\car_rental"
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    Write-Host "✅ All caches cleared!" -ForegroundColor Green
}

Write-Host "🚗 Caravel commands loaded:" -ForegroundColor Green
Write-Host "  Start-Caravel     - Start the Laravel server" -ForegroundColor Cyan
Write-Host "  Caravel-Migrate   - Check migration status" -ForegroundColor Cyan  
Write-Host "  Caravel-Cache-Clear - Clear all caches" -ForegroundColor Cyan