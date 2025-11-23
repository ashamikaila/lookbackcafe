# Fix OpenSSL Extension Missing Error

## The Problem
You're getting this error: `Extension missing: openssl`

This means the OpenSSL extension is not enabled in your PHP installation. OpenSSL is required for secure SMTP connections (TLS/SSL).

---

## ✅ SOLUTION 1: Enable OpenSSL Extension (RECOMMENDED)

### For XAMPP on Windows:

1. **Locate your php.ini file**:
   - Open XAMPP Control Panel
   - Click "Config" next to Apache
   - Select "PHP (php.ini)"

2. **Find this line** (use Ctrl+F to search):
   ```
   ;extension=openssl
   ```

3. **Remove the semicolon** to enable it:
   ```
   extension=openssl
   ```

4. **Save the file**

5. **Restart Apache**:
   - In XAMPP Control Panel
   - Click "Stop" then "Start" for Apache

6. **Verify OpenSSL is enabled**:
   - Create a file: `test_openssl.php`
   - Add this code:
   ```php
   <?php
   if (extension_loaded('openssl')) {
       echo "✅ OpenSSL is enabled!";
   } else {
       echo "❌ OpenSSL is NOT enabled";
   }
   ?>
   ```
   - Open in browser and check

---

## ✅ SOLUTION 2: Use Non-Secure SMTP (TEMPORARY WORKAROUND)

If you can't enable OpenSSL right now, you can use a temporary workaround:

### Update email.php:

Open `lookbackcafe/website/config/email.php` and change:

```php
// Change port from 587 to 25 (non-secure)
define('SMTP_PORT', 25);
```

Then in the `get_mailer()` function, update the SMTP configuration:

```php
if (USE_SMTP) {
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    
    // Check if OpenSSL is available
    if (extension_loaded('openssl')) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    } else {
        // Fallback to non-secure connection
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        $mail->Port = 25;
    }
}
```

⚠️ **WARNING**: This is less secure. Enable OpenSSL as soon as possible!

---

## ✅ SOLUTION 3: Use PHP mail() Function (SIMPLEST)

If SMTP doesn't work, use PHP's built-in mail function:

Open `lookbackcafe/website/config/email.php` and change:

```php
define('USE_SMTP', false); // Disable SMTP, use PHP mail()
```

**Pros**: No OpenSSL needed, works immediately
**Cons**: Emails may go to spam, less reliable

---

## 🔍 Verify OpenSSL Status

Run this in your browser to check OpenSSL:

```php
<?php
phpinfo();
// Search for "openssl" on the page
?>
```

Or create a simple test file:

```php
<?php
echo "OpenSSL Status: ";
if (extension_loaded('openssl')) {
    echo "✅ ENABLED";
    echo "<br>OpenSSL Version: " . OPENSSL_VERSION_TEXT;
} else {
    echo "❌ DISABLED";
}
?>
```

---

## 📝 Step-by-Step for XAMPP Users

1. ✅ Open XAMPP Control Panel
2. ✅ Click "Config" button next to Apache
3. ✅ Select "PHP (php.ini)"
4. ✅ Press Ctrl+F and search for: `extension=openssl`
5. ✅ Remove the semicolon (;) at the beginning
6. ✅ Save the file
7. ✅ Stop Apache
8. ✅ Start Apache
9. ✅ Test again!

---

## 🎯 Which Solution Should You Use?

**Best**: Solution 1 - Enable OpenSSL (most secure, most reliable)
**Quick**: Solution 3 - Use PHP mail() (works immediately, may go to spam)
**Temporary**: Solution 2 - Non-secure SMTP (if you can't enable OpenSSL yet)

---

## ❓ Still Not Working?

1. Check if you're editing the correct php.ini file
   - XAMPP might have multiple php.ini files
   - Use `phpinfo()` to find the loaded configuration file

2. Make sure Apache restarted properly
   - Stop completely, wait 5 seconds, then start

3. Check Windows Firewall
   - May be blocking SMTP ports

4. Try Solution 3 (PHP mail) as a quick test

---

**Recommended**: Enable OpenSSL (Solution 1) for best results!