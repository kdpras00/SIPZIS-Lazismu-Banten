# SIPZIS Email Configuration Fix

## Issue

Emails were not being delivered due to SMTP authentication failures with Brevo (Sendinblue).

## Error Details

```
Failed to authenticate on SMTP server with username "991296001@smtp-brevo.com" using the following authenticators: "CRAM-MD5", "LOGIN", "PLAIN".
Authenticator "CRAM-MD5" returned "Expected response code "235" but got code "535", with message "535 5.7.8 Authentication failed".".
Authenticator "LOGIN" returned "Expected response code "235" but got code "535", with message "535 5.7.8 Authentication failed".".
Authenticator "PLAIN" returned "Expected response code "235" but got code "535", with message "535 5.7.8 Authentication failed".".
```

## Root Cause

The issue was with the SMTP password configuration. Initially, the API key was being used as the password, but Brevo requires the Master Password for SMTP authentication.

## Solution

Updated the [.env](file:///C:/xampp/htdocs/SistemZakat2/.env) file with the correct SMTP credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=991296001@smtp-brevo.com
MAIL_PASSWORD=A9rDgCtmNy4vnk8x
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=prasaku68@10031766.brevosend.com
MAIL_FROM_NAME="SIPZIS"
```

## Additional Fix

Added the missing `encryption` parameter to the [config/mail.php](file:///C:/xampp/htdocs/SistemZakat2/config/mail.php) file:

```php
'smtp' => [
    'transport' => 'smtp',
    'scheme' => env('MAIL_SCHEME'),
    'url' => env('MAIL_URL'),
    'host' => env('MAIL_HOST', '127.0.0.1'),
    'port' => env('MAIL_PORT', 2525),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'timeout' => null,
    'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'), // Added this line
],
```

## Verification

Created and ran test scripts to verify the configuration:

- `test-email.php` - Basic email test
- `test-email-comprehensive.php` - Comprehensive connectivity and authentication test
- `test-email-final.php` - Final verification test

All tests now pass successfully.

## Troubleshooting Checklist

If emails stop working in the future, check:

1. **SMTP Credentials**: Ensure username and password are correct
2. **IP Whitelisting**: Check if Brevo requires IP address whitelisting
3. **Sender Verification**: Verify the sender email address in Brevo
4. **Account Status**: Ensure the Brevo account is active and not suspended
5. **Firewall Settings**: Confirm your server isn't blocking SMTP connections

## Alternative Solutions

If SMTP continues to have issues:

1. Use Brevo's HTTP API for sending emails
2. Switch to a different email service provider
3. Contact Brevo support for specific SMTP authentication assistance
