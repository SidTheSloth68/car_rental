# 📋 Car Rental Booking Information Requirements

## Overview
Complete guide to all information required to make a car rental booking on the Caravel Car Rental platform.

---

## 🔐 Prerequisites

### **1. User Account (Required)**
Before booking, you must:
- ✅ **Create an account** OR **Sign in** to existing account
- ✅ Provide valid email address
- ✅ Create secure password
- ✅ Verify email (if verification enabled)

**Why?** All bookings are linked to user accounts for security and booking management.

---

## 📝 Required Booking Information

### **SECTION 1: Vehicle Selection** ⭐ REQUIRED

#### **Option A: Specific Car (from car listing)**
- Automatically selected when clicking "Rent Now" on a specific car
- Car details pre-filled

#### **Option B: Vehicle Type**
Choose one of the following categories:
- 🚗 **Economy/Car** - Standard vehicles
- 🚐 **Van** - Larger cargo space
- 🚌 **Minivan/Minibus** - 7-9 passengers
- 🏎️ **Luxury/Prestige** - Premium vehicles

**Field:** `car_type`  
**Validation:** Required if no specific car selected  
**Format:** Radio button selection

---

### **SECTION 2: Rental Dates & Locations** ⭐ ALL REQUIRED

#### **1. Pick Up Location** ⭐ REQUIRED
- **Description:** Where you'll collect the vehicle
- **Field:** `pickup_location`
- **Format:** Text input
- **Example:** "New York JFK Airport" or "123 Main St, Boston"
- **Max Length:** 255 characters
- **Validation:** Required, must be a string

#### **2. Drop Off Location** ⭐ REQUIRED
- **Description:** Where you'll return the vehicle
- **Field:** `dropoff_location`
- **Format:** Text input
- **Example:** "Boston Logan Airport" or "456 Oak Ave, Miami"
- **Max Length:** 255 characters
- **Validation:** Required, must be a string
- **Note:** Can be same as pickup or different location

#### **3. Pick Up Date** ⭐ REQUIRED
- **Description:** Date you want to collect the car
- **Field:** `pickup_date`
- **Format:** Date picker (YYYY-MM-DD)
- **Example:** "2025-10-15"
- **Validation:** 
  - ✅ Required
  - ✅ Must be today or future date
  - ❌ Cannot be in the past

#### **4. Pick Up Time** ⭐ REQUIRED
- **Description:** Time you want to collect the car
- **Field:** `pickup_time`
- **Format:** Dropdown (30-minute intervals)
- **Options:** 00:00, 00:30, 01:00, 01:30... 23:30
- **Example:** "14:00" (2:00 PM)
- **Validation:** Required

#### **5. Return Date** ⭐ REQUIRED
- **Description:** Date you'll return the car
- **Field:** `return_date`
- **Format:** Date picker (YYYY-MM-DD)
- **Example:** "2025-10-20"
- **Validation:**
  - ✅ Required
  - ✅ Must be after pickup date
  - ❌ Cannot be same as or before pickup date

#### **6. Return Time** ⭐ REQUIRED
- **Description:** Time you'll return the car
- **Field:** `return_time`
- **Format:** Dropdown (30-minute intervals)
- **Options:** 00:00, 00:30, 01:00, 01:30... 23:30
- **Example:** "10:00" (10:00 AM)
- **Validation:** Required

---

### **SECTION 3: Additional Options** ⚪ OPTIONAL

These are **optional add-ons** you can choose:

#### **1. Additional Insurance**
- **Description:** Extra coverage for peace of mind
- **Field:** `insurance`
- **Cost:** +$15 per day
- **Format:** Checkbox
- **Default:** Unchecked

#### **2. GPS Navigation**
- **Description:** Built-in GPS navigation system
- **Field:** `gps`
- **Cost:** +$5 per day
- **Format:** Checkbox
- **Default:** Unchecked

#### **3. Child Seat**
- **Description:** Safety seat for children
- **Field:** `child_seat`
- **Cost:** +$8 per day
- **Format:** Checkbox
- **Default:** Unchecked

---

### **SECTION 4: Contact Information** ⭐ REQUIRED

#### **1. Full Name** ⭐ AUTO-FILLED
- **Description:** Your legal name
- **Field:** `customer_name`
- **Format:** Text (readonly)
- **Source:** Automatically filled from your account
- **Example:** "John Smith"
- **Max Length:** 255 characters
- **Validation:** Required
- **Note:** Cannot be edited (uses account name)

#### **2. Email Address** ⭐ AUTO-FILLED
- **Description:** Your contact email
- **Field:** `customer_email`
- **Format:** Email (readonly)
- **Source:** Automatically filled from your account
- **Example:** "john.smith@example.com"
- **Max Length:** 255 characters
- **Validation:** Required, must be valid email
- **Note:** Cannot be edited (uses account email)

#### **3. Phone Number** ⭐ REQUIRED (USER INPUT)
- **Description:** Your contact phone number
- **Field:** `customer_phone`
- **Format:** Text input
- **Example:** "+1-555-123-4567" or "555-123-4567"
- **Max Length:** 20 characters
- **Validation:** Required
- **Note:** You must enter this manually

#### **4. Driver's License Number** ⭐ REQUIRED (USER INPUT)
- **Description:** Your valid driver's license number
- **Field:** `license_number`
- **Format:** Text input
- **Example:** "D1234567890" or "ABC-123-456"
- **Max Length:** 50 characters
- **Validation:** Required
- **Important:** Must be valid at time of pickup
- **Note:** You must enter this manually

---

### **SECTION 5: Special Requests** ⚪ OPTIONAL

#### **Special Requests/Notes**
- **Description:** Any additional requirements or notes
- **Field:** `notes` or `special_requirements`
- **Format:** Textarea
- **Example:** "I'll arrive after 8 PM, please leave key at reception"
- **Max Length:** 1000 characters
- **Validation:** Optional
- **Use Cases:**
  - Late arrival instructions
  - Specific car color preferences
  - Accessibility requirements
  - Special delivery instructions

---

### **SECTION 6: Terms & Conditions** ⭐ REQUIRED

#### **Terms Acceptance**
- **Description:** Agreement to rental terms
- **Field:** `terms`
- **Format:** Checkbox
- **Validation:** Required (must be checked)
- **Links to:**
  - Terms and Conditions
  - Privacy Policy
  - Rental Agreement
- **Note:** Cannot submit without checking this box

---

## 📊 Complete Field Summary

### **Required Fields (Must Fill)**

| # | Field Name | Type | Description | Example |
|---|------------|------|-------------|---------|
| 1 | `car_type` OR `car_id` | Radio/Hidden | Vehicle selection | "economy" or "5" |
| 2 | `pickup_location` | Text | Pickup location | "New York Airport" |
| 3 | `dropoff_location` | Text | Return location | "Boston Downtown" |
| 4 | `pickup_date` | Date | Collection date | "2025-10-15" |
| 5 | `pickup_time` | Time | Collection time | "14:00" |
| 6 | `return_date` | Date | Return date | "2025-10-20" |
| 7 | `return_time` | Time | Return time | "10:00" |
| 8 | `customer_name` | Text | Your name | "John Smith" ✓ Auto |
| 9 | `customer_email` | Email | Your email | "john@example.com" ✓ Auto |
| 10 | `customer_phone` | Tel | Phone number | "+1-555-1234" |
| 11 | `license_number` | Text | License number | "D123456789" |
| 12 | `terms` | Checkbox | Accept terms | Checked ✓ |

**Total Required Fields:** 12

### **Optional Fields**

| # | Field Name | Type | Description | Cost |
|---|------------|------|-------------|------|
| 1 | `insurance` | Checkbox | Extra insurance | +$15/day |
| 2 | `gps` | Checkbox | GPS navigation | +$5/day |
| 3 | `child_seat` | Checkbox | Child safety seat | +$8/day |
| 4 | `notes` | Textarea | Special requests | Free |

**Total Optional Fields:** 4

---

## ✅ Validation Rules

### **Date Validations**
```
✅ Pickup date >= Today
✅ Return date > Pickup date
❌ Past dates not allowed
❌ Return same day as pickup not allowed
```

### **Text Validations**
```
✅ Pickup location: 1-255 characters
✅ Dropoff location: 1-255 characters
✅ Customer name: 1-255 characters
✅ Phone: 1-20 characters
✅ License: 1-50 characters
✅ Notes: 0-1000 characters (optional)
```

### **Format Validations**
```
✅ Email: Valid email format (user@domain.com)
✅ Date: YYYY-MM-DD format
✅ Time: HH:MM format (24-hour)
✅ Car type: Must be valid type from list
```

### **Business Rules**
```
✅ Car must be available for selected dates
✅ No overlapping bookings for same car
✅ User must be authenticated
✅ Terms must be accepted
✅ All required fields must be filled
```

---

## 🎯 Step-by-Step Booking Process

### **Step 1: Login**
```
→ If not logged in, you'll see "Sign In" prompt
→ Login with your credentials
→ Automatically returned to booking form
```

### **Step 2: Select Vehicle**
```
Option A: Choose from search results
→ Click "Rent Now" on specific car
→ Car automatically selected

Option B: Choose by category
→ Select: Car, Van, Minibus, or Prestige
```

### **Step 3: Enter Rental Details**
```
→ Pickup location: [Enter address/location]
→ Dropoff location: [Enter address/location]
→ Pickup date: [Select from calendar]
→ Pickup time: [Select from dropdown]
→ Return date: [Select from calendar]
→ Return time: [Select from dropdown]
```

### **Step 4: Add Optional Extras (Optional)**
```
☐ Additional Insurance (+$15/day)
☐ GPS Navigation (+$5/day)
☐ Child Seat (+$8/day)
```

### **Step 5: Contact Information**
```
✓ Name: [Auto-filled from account]
✓ Email: [Auto-filled from account]
→ Phone: [Enter your phone number]
→ License: [Enter license number]
```

### **Step 6: Special Requests (Optional)**
```
→ Add any special notes or requests
```

### **Step 7: Accept Terms**
```
☑ I agree to Terms and Conditions and Privacy Policy
```

### **Step 8: Submit**
```
→ Click "Book Now"
→ Booking created
→ Confirmation email sent
→ View in Dashboard
```

---

## 💳 Pricing Calculation

### **Base Cost**
```
Daily Rate × Number of Days
Example: $50/day × 5 days = $250
```

### **Additional Costs (if selected)**
```
+ Insurance: $15/day × 5 days = $75
+ GPS: $5/day × 5 days = $25
+ Child Seat: $8/day × 5 days = $40
```

### **Total Booking Cost**
```
Base Cost: $250
Add-ons: $140
─────────────
Total: $390
```

---

## 📧 What Happens After Booking

### **Immediate Actions**
1. ✅ **Booking confirmation page** displayed
2. ✅ **Confirmation email** sent to your email
3. ✅ **Booking reference number** generated
4. ✅ **Added to your dashboard** for tracking

### **Booking Status**
- Initial status: **Pending**
- After admin review: **Confirmed**
- At pickup time: **Active**
- After return: **Completed**

### **What You Receive**
1. 📧 **Email confirmation** with:
   - Booking reference number
   - Car details
   - Pickup/return information
   - Total cost
   - Terms and conditions

2. 📱 **Dashboard access** showing:
   - Current bookings
   - Past bookings
   - Booking status
   - Payment information
   - Cancel/modify options

---

## 🚫 Common Validation Errors

### **Error 1: Past Date Selected**
```
Error: "The pickup date must be today or a future date."
Solution: Select today or future date
```

### **Error 2: Return Date Before Pickup**
```
Error: "The return date must be after pickup date."
Solution: Select return date after pickup date
```

### **Error 3: Missing Phone Number**
```
Error: "The customer phone field is required."
Solution: Enter your contact phone number
```

### **Error 4: Missing License Number**
```
Error: "The license number field is required."
Solution: Enter your driver's license number
```

### **Error 5: Terms Not Accepted**
```
Error: "You must accept the terms and conditions."
Solution: Check the terms checkbox
```

### **Error 6: Car Not Available**
```
Error: "The selected car is not available for booking."
Solution: Choose different dates or different car
```

---

## 📱 Mobile vs Desktop

### **All Fields Same**
Both mobile and desktop require the same information.

### **UI Differences**
- **Desktop:** Multi-column layout
- **Mobile:** Single-column, scrollable layout
- **Date Pickers:** Native device date picker on mobile
- **Time Dropdowns:** Optimized for touch on mobile

---

## ❓ Frequently Asked Questions

### **Q: Do I need to create an account?**
A: Yes, you must be logged in to submit a booking. However, you can browse cars without an account.

### **Q: Can I book without a driver's license?**
A: No, a valid driver's license number is required for all bookings.

### **Q: Can I change the pickup/return location later?**
A: Contact support to modify booking details. Some changes may incur fees.

### **Q: Is my phone number required?**
A: Yes, we need a contact number in case of issues with your booking.

### **Q: What if I arrive late for pickup?**
A: Add a note in the "Special Requests" section, or contact us directly.

### **Q: Are the add-ons mandatory?**
A: No, insurance, GPS, and child seat are all optional extras.

### **Q: Can I book for someone else?**
A: The booking will be under your account, but you can add notes about alternative driver (subject to our policies).

---

## 🎯 Quick Reference

### **Minimum Information Needed:**
1. Vehicle type or specific car
2. Pickup location
3. Dropoff location
4. Pickup date and time
5. Return date and time
6. Phone number
7. Driver's license number
8. Accept terms

### **Auto-Filled (No Input Needed):**
1. Your name (from account)
2. Your email (from account)

### **Optional (Can Skip):**
1. Additional insurance
2. GPS navigation
3. Child seat
4. Special requests/notes

---

## ✅ Booking Checklist

Use this checklist before clicking "Book Now":

- [ ] Vehicle selected (type or specific car)
- [ ] Pickup location entered
- [ ] Dropoff location entered
- [ ] Pickup date selected (today or future)
- [ ] Pickup time selected
- [ ] Return date selected (after pickup)
- [ ] Return time selected
- [ ] Phone number entered
- [ ] Driver's license number entered
- [ ] Optional extras selected (if wanted)
- [ ] Special requests added (if needed)
- [ ] Terms and conditions checkbox checked
- [ ] All information reviewed and correct

---

## 📞 Need Help?

If you have questions about booking:
- 📧 Email: contact@caravel.com
- 📞 Phone: +208 333 9296
- ⏰ Hours: Mon-Fri 08:00-18:00
- 💬 Live chat available on website

---

## 📝 Summary

**Total Fields:** 16  
**Required:** 12  
**Auto-Filled:** 2 (name, email)  
**Manual Input:** 10  
**Optional:** 4

**Average Time to Complete:** 3-5 minutes

**Your booking is just a few clicks away!** 🚗✨
