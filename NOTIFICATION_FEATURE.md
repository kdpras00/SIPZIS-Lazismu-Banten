# Notification Feature for Muzakki Users

## Overview

This feature adds a notification system for logged-in muzakki users to display all their payments. A notification icon with a badge showing the count of all payments is displayed next to the profile icon in the navbar. When clicked, it shows a popup with the latest payments instead of redirecting to a separate page.

## Implementation Details

### 1. Database Model Updates

- Added `scopePending()` method to the `ZakatPayment` model to filter pending payments
- Added `getPendingPaymentsCountAttribute()` method to the `Muzakki` model to get the count of pending payments
- Added `getTotalPaymentsCountAttribute()` method to the `Muzakki` model to get the count of all payments

### 2. Navbar Updates

- Added notification icon next to the profile icon for authenticated muzakki users
- The notification icon is always visible for authenticated muzakki users
- The icon includes a badge showing the count of all payments
- Clicking the notification icon shows a popup with the latest 5 payments
- The popup can be closed by clicking the X button or clicking outside the popup

### 3. Routes

- Added `/muzakki/notifications` route for the full notifications page (kept for direct access)
- Added `/muzakki/notifications/ajax` route for AJAX requests to load popup content
- The routes are protected and only accessible to muzakki users

### 4. Controller Methods

- Updated `notifications()` method in `ZakatPaymentController` to fetch all payments (kept for full page)
- Added `ajaxNotifications()` method in `ZakatPaymentController` to handle AJAX requests for popup content
- Both methods ensure only authenticated muzakki users can access the notifications

### 5. Views

- Updated `resources/views/muzakki/notifications.blade.php` to display all payments (kept for full page)
- Created `resources/views/muzakki/partials/notifications-popup.blade.php` for popup content
- The popup view shows a list of the latest 5 payments with details, status indicators, and a link to view all
- Includes a friendly empty state with a call-to-action button to make a donation

## How It Works

1. When a muzakki logs in, the system checks for all payments associated with their account
2. The notification icon with a badge appears next to the profile icon for all authenticated muzakki users
3. The badge shows the count of all payments
4. Clicking the notification icon shows a popup with the latest 5 payments
5. The popup can be closed by clicking the X button or clicking outside the popup
6. Users can click "Lihat semua pembayaran" to go to the full notifications page

## Benefits

- Provides muzakki users with a visual indicator of their payment history without leaving the current page
- Makes it easy for users to quickly check their recent payments
- Improves user experience with a non-disruptive popup interface
- Shows payment status with visual indicators (pending, completed, cancelled)
- Provides appropriate actions for each payment status
- Maintains the full notifications page for users who want to see all payments
