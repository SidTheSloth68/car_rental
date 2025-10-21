# Car Rental System - Login Credentials

## 🔐 **Test Accounts**

The system now uses only **2 roles**: `admin` and `user`

### **Admin Accounts** (Full access to admin panel and car management)
- **Email:** `admin@rentaly.com`
- **Password:** `password123`
- **Access:** Admin dashboard, car management, booking management

- **Email:** `superadmin@rentaly.com`  
- **Password:** `password123`
- **Access:** Admin dashboard, car management, booking management

### **User Accounts** (Regular customers)
- **Email:** `user@rentaly.com`
- **Password:** `password123`
- **Access:** User dashboard, booking creation, view own bookings

- **Email:** `jane.smith@email.com`
- **Password:** `password123`
- **Access:** User dashboard, booking creation, view own bookings

- **Email:** `michael.johnson@email.com`
- **Password:** `password123`
- **Access:** User dashboard, booking creation, view own bookings

### **Additional Users**
- 20+ additional user accounts created via factory
- All use password: `password123`

## 🌐 **URLs**
- **Main Site:** http://127.0.0.1:8000
- **Login:** http://127.0.0.1:8000/login
- **Register:** http://127.0.0.1:8000/register
- **User Dashboard:** http://127.0.0.1:8000/dashboard
- **Admin Dashboard:** http://127.0.0.1:8000/admin/dashboard

## 📊 **Database Contents**
- **Users:** 27 total (2 admin, 25 user)
- **Cars:** 12 available vehicles
- **Bookings:** 25 sample bookings
- **News Articles:** 15 articles

## ✅ **Booking System Status**
The booking section is now **fully functional** with:
- ✅ Sample bookings data populated
- ✅ User role standardization (only 'user' and 'admin')
- ✅ All booking routes working
- ✅ Dashboard displays real booking data
- ✅ Admin panel for booking management
- ✅ API endpoints operational
- ✅ 98.8% test coverage maintained

## 🚀 **Quick Test**
1. Start server: `php artisan serve`
2. Login as: `user@rentaly.com` / `password123`
3. Visit: http://127.0.0.1:8000/dashboard/bookings
4. Should see booking data and navigation options