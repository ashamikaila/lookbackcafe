# Security Fixes Migration Guide

## Quick Start - What You Need to Do

### ✅ Step 1: No Immediate Action Required
The security headers are automatically applied to all pages that include `config/security.php`. Your existing code will continue to work.

### ✅ Step 2: Gradually Add CSRF Protection (Recommended)

#### For Each Form in Your Application:

**Before:**
```php
<form method="POST" action="process.php">
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>
```

**After:**
```php
<form method="POST" action="process.php">
    <?php csrf_token_field(); ?>
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>
```

#### For Each Form Handler:

**Before:**
```php
<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    // Process form...
}
?>
```

**After:**
```php
<?php
session_start();
require_once 'config/db.php';
require_once 'config/headers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token(); // Add this line
    $username = $_POST['username'];
    // Process form...
}
?>
```

---

### ✅ Step 3: Update Output Escaping (Recommended)

Replace direct output of user data with escaped versions:

**Before:**
```php
<p>Welcome, <?php echo $userName; ?>!</p>
<input type="text" value="<?php echo $userEmail; ?>">
```

**After:**
```php
<p>Welcome, <?php echo escape_html($userName); ?>!</p>
<input type="text" value="<?php echo escape_attr($userEmail); ?>">
```

---

### ✅ Step 4: Fix Sensitive Data in URLs (Optional but Recommended)

**Before:**
```php
header("Location: profile.php?userName=" . $userName . "&status=updated");
```

**After - Option 1 (Flash Messages):**
```php
require_once 'config/url_helper.php';
redirect_with_message('profile.php', 'Profile updated successfully', 'success');
```

**After - Option 2 (Session Storage):**
```php
require_once 'config/url_helper.php';
store_in_session('user_name', $userName);
header("Location: profile.php");

// In profile.php
$userName = get_from_session('user_name');
```

---

## Files That Need Updates

### Priority 1: Forms (Add CSRF Protection)

Update these files to add CSRF tokens:

1. `auth/login.php` - Login form
2. `auth/register.php` - Registration form  
3. `editprofile.php` - Profile edit form
4. `contact.php` - Contact form
5. `newsletter.php` - Newsletter subscription
6. Any other forms in your application

### Priority 2: Form Handlers (Validate CSRF)

Add `require_csrf_token();` to:

1. `auth/login.php` - POST handler
2. `auth/register.php` - POST handler
3. `editprofile.php` - POST handler
4. `contact.php` - POST handler
5. Any other POST handlers

### Priority 3: Output Escaping

Update these files to use escape functions:

1. `includes/nav.php` - User name display (✅ Already using htmlspecialchars)
2. `editprofile.php` - Form values
3. `admindash.php` - Admin data display
4. `user-accounts.php` - User data display
5. Any page displaying user input

---

## Example: Complete Form Update

### Before (Vulnerable):
```php
<!-- profile_form.php -->
<form method="POST" action="update_profile.php">
    <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>">
    <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>">
    <button type="submit">Update</button>
</form>

<!-- update_profile.php -->
<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Update database...
    
    header("Location: profile.php?message=Profile updated&userName=" . $name);
}
?>
```

### After (Secure):
```php
<!-- profile_form.php -->
<?php require_once 'config/headers.php'; ?>
<form method="POST" action="update_profile.php">
    <?php csrf_token_field(); ?>
    <input type="text" name="name" value="<?php echo escape_attr($_SESSION['user_name']); ?>">
    <input type="email" name="email" value="<?php echo escape_attr($_SESSION['user_email']); ?>">
    <button type="submit">Update</button>
</form>

<!-- update_profile.php -->
<?php
session_start();
require_once 'config/db.php';
require_once 'config/headers.php';
require_once 'config/url_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token(); // Validate CSRF token
    
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    
    // Update database...
    
    redirect_with_message('profile.php', 'Profile updated successfully', 'success');
}
?>

<!-- profile.php -->
<?php
$flash = get_flash_message();
if ($flash): ?>
    <div class="alert alert-<?php echo escape_attr($flash['type']); ?>">
        <?php echo escape_html($flash['message']); ?>
    </div>
<?php endif; ?>
```

---

## Testing Checklist

After making changes, test:

- [ ] All forms still submit correctly
- [ ] CSRF protection blocks requests without tokens
- [ ] User data displays correctly (not double-escaped)
- [ ] Redirects work properly
- [ ] Flash messages appear
- [ ] No JavaScript errors in console
- [ ] No PHP errors in logs

---

## Rollback Plan

If something breaks:

1. The new files don't affect existing code automatically
2. Simply remove the `require_csrf_token();` calls if they cause issues
3. Remove `csrf_token_field();` from forms
4. Your code will work as before (but without CSRF protection)

---

## Timeline Recommendation

- **Week 1**: Add CSRF protection to critical forms (login, registration, password change)
- **Week 2**: Add CSRF protection to remaining forms
- **Week 3**: Update output escaping throughout the application
- **Week 4**: Migrate URL parameters to session/token-based approach

---

## Need Help?

Common issues and solutions:

### Issue: "CSRF token validation failed"
**Solution:** Make sure the form has `<?php csrf_token_field(); ?>` and session is started

### Issue: "Call to undefined function csrf_token_field()"
**Solution:** Add `require_once 'config/headers.php';` at the top of the file

### Issue: "Headers already sent"
**Solution:** Make sure there's no output before `header()` calls and session_start()

### Issue: Double-escaped HTML (showing &amp;lt; instead of <)
**Solution:** Don't escape data that's already escaped. Use escape functions only once on output.

---

**Remember:** These changes improve security without breaking existing functionality. Take your time to implement them gradually!