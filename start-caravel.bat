@echo off
cd /d "E:\car_rental\car_rental\car_rental"
echo Starting Caravel Laravel Application...
echo Current directory: %CD%
php artisan serve --host=127.0.0.1 --port=8000
pause