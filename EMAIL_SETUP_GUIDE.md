# Email Setup Guide

## Features Implemented

### 1. Forgot Password with OTP ✅
- User enters email → receives 6-digit OTP
- OTP expires in 10 minutes
- One-time use only
- Secure password reset

### 2. Newsletter System ✅
- Admin can send newsletters to all subscribers
- Automatic email when promotions updated
- Unsubscribe link included

---

## Setup Instructions

### Step 1: Run Database Migration
In phpMyAdmin:
1. Select `lookback_cafe` database
2. Go to SQL tab
3. Copy/paste contents of `email_migration.sql`
4. Click Go

### Step 2: Configure Email Settings
Edit `website/config/email.php`:

**Option 1: Brevo (Sendinblue) - RECOMMENDED for Real Emails**
```php
define('USE_SMTP', true);
define('SMTP_HOST', 'smtp-relay.brevo.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-brevo-email@example.com');
define('SMTP_PASSWORD', 'your-brevo-smtp-key');
define('SMTP_FROM_EMAIL', 'noreply@lookbackcafe.com');
```

**Setup Brevo (Free - 300 emails/day):**
1. Sign up at https://www.brevo.com/
2. Go to Settings > SMTP & API > SMTP
3. Generate SMTP key
4. Add sender email in Settings > Senders & IP
5. Verify your sender email
6. Copy credentials to `email.php`

**Option 2: PHP mail() (Simple but less reliable)**
```php
define('USE_SMTP', false); // Use PHP mail()
define('SMTP_FROM_EMAIL', 'noreply@lookbackcafe.com');
```
- Works immediately on most servers
- May go to spam folder
- Good for local testing only

**Option 3: Other SMTP Services**
- **SendGrid** (100 emails/day free): https://sendgrid.com/
- **Mailgun** (100 emails/day for 3 months): https://www.mailgun.com/
- **Amazon SES** (62,000 emails/month on AWS): https://aws.amazon.com/ses/

**Note:** PHPMailer is installed in `vendor/phpmailer/`

---

## How It Works

### Forgot Password Flow:
1. User clicks "Forgot Password" on login page
2. Enters email → `forgot_password.php`
3. Receives OTP email
4. Enters OTP → `verify_otp.php`
5. Sets new password → `reset_password.php`
6. Redirects to login

### Newsletter Flow:
1. Admin goes to Newsletter page
2. Clicks "Send Newsletter"
3. Writes subject + content
4. Clicks "Send to All Subscribers"
5. All active subscribers receive email

---

## Usage

### For Users:
- **Forgot Password**: `http://localhost:8080/website/forgot_password.php`

### For Admins:
- **Send Newsletter**: `http://localhost:8080/website/send_newsletter.php`
- Link added to Newsletter page

---

## Auto-Notify Subscribers

To auto-send when special offers updated, add this to `special.php`:

```php
// After updating special offer
require_once 'config/email.php';

$subject = "New Special Offer at Look Back Café!";
$content = "
    <h2>Check Out Our Latest Offer!</h2>
    <p><strong>$offer_title</strong></p>
    <p>$offer_description</p>
    <p>Valid until: $valid_until</p>
";

send_bulk_newsletter($subject, $content);
```

---

## Testing

1. **Test OTP**: Go to `forgot_password.php`
2. **Test Newsletter**: Go to `send_newsletter.php` (admin only)
3. Check spam folder if emails not received

---

## Production Notes

- **Use Brevo or other SMTP service** (not PHP mail())
- **Verify sender email** in your SMTP provider
- Add rate limiting for OTP requests
- Store SMTP credentials in environment variables
- Monitor daily email limits (Brevo: 300/day)
- Check spam folder during testing
- Enable SMTP debugging if emails not sending:
  ```php
  // In email.php, uncomment:
  $mail->SMTPDebug = 2;
  ```

---

## Troubleshooting

### Emails Not Sending?
1. Check SMTP credentials are correct
2. Verify sender email in Brevo dashboard
3. Check spam/junk folder
4. Enable SMTP debug mode
5. Check Brevo sending logs

### "SMTP Error: Could not authenticate"
- Use SMTP key, not account password
- Verify username is your Brevo email

### Emails Going to Spam?
- Verify sender email address
- Use professional sender name
- Avoid spam trigger words
- Add SPF/DKIM records (advanced)