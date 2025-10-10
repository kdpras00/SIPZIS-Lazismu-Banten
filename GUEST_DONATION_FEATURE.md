# Guest Donation Feature with Conditional Fields

## Overview

This feature modifies the guest donation form to provide a streamlined experience for users who are already logged in with a muzakki account. When a logged-in user makes a donation, only the essential fields (donation amount and message/doa) are displayed, as their personal information is already available in their profile.

## How It Works

### For Non-Logged In Users (Guests)

1. Users see the full donation form with all fields:

   - Donation amount (with quick selection buttons)
   - Full name
   - Phone number
   - Email address
   - Message/doa

2. All information is collected through the form and stored in the system.

### For Logged In Users (With Muzakki Account)

1. Users see a simplified donation form with only:

   - Donation amount (with quick selection buttons)
   - Message/doa

2. The personal information (name, phone, email) is automatically taken from their muzakki profile and included as hidden fields in the form submission.

## Implementation Details

### Controller Changes

- Modified `ZakatPaymentController@guestCreate` to check if the user is logged in
- Passes the logged-in muzakki information to the view
- Modified `ZakatPaymentController@guestStore` to use profile information when available

### View Changes

- Added conditional logic in `guest-create.blade.php` to show/hide fields based on login status
- For logged-in users, personal information fields are hidden but their values are included as hidden inputs

### Data Flow

1. When a user accesses the donation page:

   - If logged in, their muzakki profile data is used
   - If not logged in, they fill in all fields manually

2. When submitting the donation:
   - For logged-in users, data is taken from their profile
   - For guests, data is taken from the form
   - All donations are processed through the same workflow

## Benefits

- Reduces friction for existing users by pre-filling their information
- Maintains the full functionality for guest users
- Improves user experience by showing only relevant fields
- Ensures data consistency by using profile information for logged-in users
