# Fresh Start - Email System Setup

## What Was Removed

✅ **Deleted Files:**
- `vendor/phpmailer/` - Entire PHPMailer library
- `website/config/email.php` - Old email configuration
- `website/config/email_gmail.php` - Gmail SMTP config
- `website/config/email_alternative.php` - Alternative config
- `website/test_email.php` - Email test script
- `website/test_newsletter.php` - Newsletter test script
- `website/check_openssl.php` - OpenSSL diagnostic
- `website/openssl_test.php` - OpenSSL test
- `website/debug_openssl.php` - Debug script
- `website/check_errors.php` - Error checker
- `router.php` - Router script
- `start_server.ps1` - PowerShell server script
- `start_server.bat` - Batch server script
- `start_server_fixed.bat` - Fixed batch script
- `setup_xampp.bat` - XAMPP setup script
- `USE_XAMPP_INSTEAD.md` - XAMPP guide

## Files That Still Reference Email Functions

⚠️ **These files need to be updated after you install a new email solution:**

1. **`website/forgot_password.php`** (line 5, 44)
   - Requires: `config/email.php`
   - Uses: `send_otp_email()`

2. **`website/newsletter.php`** (line 12, 21)
   - Requires: `config/email.php`
   - Uses: `send_bulk_newsletter()`

3. **`website/send_newsletter.php`** (line 5, 22)
   - Requires: `config/email.php`
   - Uses: `send_bulk_newsletter()`

4. **`website/check_php_config.php`** (lines 92-110)
   - Checks if PHPMailer is installed

## Next Steps

Choose one of these approaches:

### Option 1: Use XAMPP with PHPMailer (Recommended)

1. **Move project to XAMPP:**
   ```
   Copy: C:\Users\jaynzle\Documents\lookbackcafeonline\lookbackcafe
   To: C:\xampp\htdocs\lookbackcafe
   ```

2. **Install Composer** (if not installed):
   - Download from: https://getcomposer.org/download/

3. **Install PHPMailer via Composer:**
   ```bash
   cd C:\xampp\htdocs\lookbackcafe
   composer require phpmailer/phpmailer
   ```

4. **Create new `config/email.php`** with proper SMTP settings

5. **Start XAMPP Apache** and test

### Option 2: Use a Different Email Service

Instead of PHPMailer, you could use:
- **SendGrid PHP Library**
- **Mailgun PHP SDK**
- **Amazon SES SDK**
- **Postmark PHP**

### Option 3: Use PHP's Built-in mail()

Simple but requires mail server configuration on Windows.

## Database Tables Still Intact

The following email-related database tables are still there:
- `password_reset_otps` - For OTP functionality
- `newsletter_subscribers` - For newsletter subscriptions
- `newsletters_sent` - For newsletter history

## Current Status

🔴 **Email functionality is BROKEN** until you:
1. Install a new email library
2. Create new `config/email.php` with required functions:
   - `send_otp_email($email, $otp, $name)`
   - `send_bulk_newsletter($subject, $content)`
   - `send_newsletter_email($email, $subject, $content)`

---

**Ready for a fresh, clean setup!** 🎉