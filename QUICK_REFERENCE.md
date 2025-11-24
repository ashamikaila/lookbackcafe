# Security Features - Quick Reference Card

## 🚀 Quick Start

All security headers are **automatically applied** when you include `config/security.php`. No immediate changes needed!

---

## 📋 Common Tasks

### Add CSRF Protection to a Form

```php
<!-- In your form HTML -->
<form method="POST">
    <?php csrf_token_field(); ?>
    <!-- rest of form -->
</form>

<!-- In form handler PHP -->
<?php
require_once 'config/headers.php';
require_csrf_token(); // Add at start of POST handler
?>
```

### Escape User Output

```php
<?php require_once 'config/headers.php'; ?>

<!-- HTML Content -->
<p><?php echo escape_html($userInput); ?></p>

<!-- HTML Attributes -->
<input value="<?php echo escape_attr($userInput); ?>">

<!-- JavaScript -->
<script>var data = <?php echo escape_js($userInput); ?>;</script>

<!-- URLs -->
<a href="<?php echo escape_url($link); ?>">Link</a>
```

### Redirect with Message (No URL Parameters)

```php
<?php
require_once 'config/url_helper.php';

// Instead of: header("Location: page.php?message=Success");
redirect_with_message('page.php', 'Success!', 'success');

// In page.php, display the message:
$flash = get_flash_message();
if ($flash) {
    echo '<div class="alert-' . $flash['type'] . '">' . 
         escape_html($flash['message']) . '</div>';
}
?>
```

### Pass Sensitive Data Securely

```php
<?php
require_once 'config/url_helper.php';

// Store in session instead of URL
store_in_session('user_data', $sensitiveData);
header("Location: page.php");

// Retrieve in page.php
$data = get_from_session('user_data');
?>
```

---

## 🔧 Function Reference

### From `config/headers.php`

| Function | Purpose | Example |
|----------|---------|---------|
| `escape_html($data)` | Escape for HTML content | `<?php echo escape_html($text); ?>` |
| `escape_attr($data)` | Escape for HTML attributes | `<div id="<?php echo escape_attr($id); ?>">` |
| `escape_js($data)` | Escape for JavaScript | `<script>var x = <?php echo escape_js($val); ?>;</script>` |
| `escape_url($url)` | Escape for URLs | `<a href="<?php echo escape_url($link); ?>">` |
| `csrf_token_field()` | Output CSRF token input | `<?php csrf_token_field(); ?>` |
| `require_csrf_token()` | Validate CSRF token | `require_csrf_token();` (in POST handler) |
| `generate_csrf_token()` | Get CSRF token value | `$token = generate_csrf_token();` |

### From `config/url_helper.php`

| Function | Purpose | Example |
|----------|---------|---------|
| `redirect_with_message($url, $msg, $type)` | Redirect with flash message | `redirect_with_message('page.php', 'Done!', 'success');` |
| `get_flash_message()` | Get flash message | `$flash = get_flash_message();` |
| `store_in_session($key, $value)` | Store data in session | `store_in_session('user_id', $id);` |
| `get_from_session($key)` | Get data from session | `$id = get_from_session('user_id');` |
| `tokenize_data($data)` | Create token for data | `$token = tokenize_data(['id' => $id]);` |
| `detokenize_data($token)` | Get data from token | `$data = detokenize_data($_GET['token']);` |

### From `config/security.php`

| Function | Purpose | Example |
|----------|---------|---------|
| `sanitize_input($data)` | Sanitize user input | `$clean = sanitize_input($_POST['name']);` |
| `sanitize_array($array)` | Sanitize array of inputs | `$clean = sanitize_array($_POST);` |
| `validate_email($email)` | Validate email format | `if (validate_email($email)) { }` |
| `hash_password($password)` | Hash password (bcrypt) | `$hash = hash_password($password);` |
| `verify_password($pwd, $hash)` | Verify password | `if (verify_password($pwd, $hash)) { }` |

---

## ✅ Security Checklist

### For Every Form:
- [ ] Add `<?php csrf_token_field(); ?>` inside `<form>` tag
- [ ] Add `require_csrf_token();` at start of POST handler
- [ ] Sanitize all inputs with `sanitize_input()`
- [ ] Escape all outputs with `escape_*()` functions

### For Every Page with User Data:
- [ ] Use `escape_html()` for text content
- [ ] Use `escape_attr()` for HTML attributes
- [ ] Use `escape_js()` for JavaScript variables
- [ ] Use `escape_url()` for URLs

### For Every Redirect:
- [ ] Use `redirect_with_message()` for user feedback
- [ ] Use `store_in_session()` for sensitive data
- [ ] Avoid putting sensitive data in URL parameters

---

## 🎯 Message Types

For `redirect_with_message()`:

- `'success'` - Green success message
- `'error'` - Red error message
- `'warning'` - Yellow warning message
- `'info'` - Blue info message

---

## 📝 Template: Secure Form

```php
<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';
require_once 'config/url_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    
    // Validate
    if (empty($name) || !validate_email($email)) {
        redirect_with_message('form.php', 'Invalid input', 'error');
    }
    
    // Process...
    
    redirect_with_message('success.php', 'Saved!', 'success');
}

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html>
<head><title>Form</title></head>
<body>
    <?php if ($flash): ?>
        <div class="alert-<?php echo escape_attr($flash['type']); ?>">
            <?php echo escape_html($flash['message']); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <?php csrf_token_field(); ?>
        <input type="text" name="name" value="<?php echo escape_attr($name ?? ''); ?>">
        <input type="email" name="email" value="<?php echo escape_attr($email ?? ''); ?>">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
```

---

## 🔍 Testing

### Check Security Headers
1. Open DevTools (F12)
2. Go to Network tab
3. Reload page
4. Click on the page request
5. Check Response Headers for:
   - `Content-Security-Policy`
   - `X-Frame-Options`
   - `X-XSS-Protection`

### Test CSRF Protection
1. Remove `<?php csrf_token_field(); ?>` from form
2. Try to submit
3. Should get "CSRF token validation failed" error

### Test XSS Protection
1. Try entering `<script>alert('XSS')</script>` in a form
2. Should be displayed as text, not executed

---

## 💡 Tips

- **Always escape output**, even if you think it's safe
- **Never trust user input**, always sanitize
- **Use flash messages** instead of URL parameters for feedback
- **Test thoroughly** after adding CSRF protection
- **Check error logs** if something doesn't work

---

## 🆘 Troubleshooting

| Problem | Solution |
|---------|----------|
| "CSRF token validation failed" | Make sure form has `csrf_token_field()` and session is started |
| "Call to undefined function" | Add `require_once 'config/headers.php';` |
| "Headers already sent" | No output before `header()` calls |
| Double-escaped HTML | Only escape once, on output |
| Flash message not showing | Check `get_flash_message()` is called |

---

**For full documentation, see:** `SECURITY_FIXES.md` and `MIGRATION_GUIDE.md`