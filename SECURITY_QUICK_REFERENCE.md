# Security Quick Reference Guide
## Look Back Café - Developer Cheat Sheet

---

## Password Requirements Summary

✅ **Minimum 12 characters**  
✅ **At least 1 lowercase letter** (a-z)  
✅ **At least 1 uppercase letter** (A-Z)  
✅ **At least 1 number** (0-9)  
✅ **At least 1 special character** (!@#$%^&*()_+-=[]{}|;:,.<>?)  
✅ **Not in weak password blacklist**

**Blacklisted passwords:**
- password, 123456, qwerty, admin, password123, 12345678, 123456789, 1234567890, letmein, welcome, monkey, dragon, master, sunshine, princess, football, baseball, abc123, iloveyou, trustno1

---

## Common Code Patterns

### 1. Protect a Page (Require Login)
```php
<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

configure_secure_session();
require_auth(); // Any logged-in user
?>
```

### 2. Protect Admin-Only Page
```php
<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

configure_secure_session();
require_auth('admin'); // Admin only
?>
```

### 3. User Registration with Password Validation
```php
// Sanitize inputs
$name = sanitize_input($_POST["name"]);
$email = sanitize_input($_POST["email"]);
$password = $_POST["password"];

// Validate email
if (!validate_email($email)) {
    // Handle error
}

// Validate password
$validation = validate_password($password);
if (!$validation['valid']) {
    $errors = $validation['errors'];
    // Display errors to user
}

// Hash password
$hashed = hash_password($password);

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (user_name, user_email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed);
$stmt->execute();
```

### 4. User Login with Rate Limiting
```php
$email = sanitize_input($_POST["email"]);
$password = $_POST["password"];

// Check rate limit
if (check_rate_limit($email)) {
    // Too many attempts
    header("Location: login.php?error=rate_limit");
    exit();
}

// Verify credentials
$stmt = $conn->prepare("SELECT user_id, password FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (verify_password($password, $user['password'])) {
        // Success
        record_login_attempt($email, true);
        log_security_event('login_success', "User logged in: $email", $user['user_id']);
        
        // Create session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['role'] = 'user';
    } else {
        // Failed
        record_login_attempt($email, false);
        log_security_event('login_failed', "Failed login: $email", null);
    }
}
```

### 5. Change Password
```php
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];

// Validate new password
$validation = validate_password($new_password);
if (!$validation['valid']) {
    // Show errors
}

// Get current password hash
$stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verify old password
if (verify_password($old_password, $user['password'])) {
    // Update password
    $new_hash = hash_password($new_password);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_hash, $user_id);
    $stmt->execute();
    
    log_security_event('password_changed', "Password changed", $user_id);
}
```

### 6. Encrypt/Decrypt Sensitive Data
```php
// Encrypt
$sensitive_data = "Credit card: 1234-5678-9012-3456";
$encrypted = encrypt_data($sensitive_data);

// Store in database
$stmt = $conn->prepare("INSERT INTO encrypted_data (user_id, data_type, encrypted_value) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $data_type, $encrypted);
$stmt->execute();

// Decrypt
$decrypted = decrypt_data($encrypted);
```

### 7. Check User Role
```php
// Check if admin
if (check_role('admin')) {
    // Admin-only code
}

// Check multiple roles
if (check_role(['admin', 'moderator'])) {
    // Code for admins or moderators
}
```

### 8. Log Security Event
```php
// Log user action
log_security_event('profile_updated', "User updated profile", $user_id);

// Log admin action
log_security_event('user_deleted', "Admin deleted user ID: $deleted_user_id", $_SESSION['user_id']);

// Log suspicious activity
log_security_event('suspicious_activity', "Multiple failed login attempts", null);
```

---

## Available Security Functions

| Function | Purpose | Returns |
|----------|---------|---------|
| `validate_password($password)` | Validate password strength | `['valid' => bool, 'errors' => array]` |
| `hash_password($password)` | Hash password with bcrypt | `string` (hashed password) |
| `verify_password($password, $hash)` | Verify password against hash | `bool` |
| `encrypt_data($data)` | Encrypt sensitive data (AES-256) | `string` (base64 encoded) |
| `decrypt_data($encrypted)` | Decrypt data | `string` or `false` |
| `sanitize_input($data)` | Sanitize user input (XSS prevention) | `string` |
| `validate_email($email)` | Validate email format | `bool` |
| `generate_secure_token($length)` | Generate random token | `string` |
| `is_https()` | Check if using HTTPS | `bool` |
| `enforce_https()` | Redirect to HTTPS | `void` |
| `configure_secure_session()` | Set secure session params | `void` |
| `check_role($required_role)` | Check user role | `bool` |
| `require_auth($required_role)` | Require authentication | `void` (redirects if not auth) |
| `log_security_event($type, $desc, $user_id)` | Log security event | `void` |
| `check_rate_limit($identifier, $max, $window)` | Check login rate limit | `bool` |
| `record_login_attempt($identifier, $success)` | Record login attempt | `void` |

---

## Security Checklist for New Pages

- [ ] Include `require_once 'config/security.php'`
- [ ] Call `configure_secure_session()` after `session_start()`
- [ ] Use `require_auth()` or `require_auth('role')` for protected pages
- [ ] Sanitize all user inputs with `sanitize_input()`
- [ ] Validate emails with `validate_email()`
- [ ] Validate passwords with `validate_password()`
- [ ] Use prepared statements for all database queries
- [ ] Log important actions with `log_security_event()`
- [ ] Never store passwords in plain text
- [ ] Use `encrypt_data()` for sensitive information

---

## Database Tables

### security_log
Stores all security events
```sql
id, event_type, description, user_id, ip_address, user_agent, created_at
```

### login_attempts
Tracks login attempts for rate limiting
```sql
id, identifier, ip_address, success, attempt_time
```

### encrypted_data
Stores encrypted sensitive data
```sql
id, user_id, data_type, encrypted_value, created_at, updated_at
```

---

## Configuration Constants

Located in `website/config/security.php`:

```php
MIN_PASSWORD_LENGTH = 12
REQUIRE_UPPERCASE = true
REQUIRE_LOWERCASE = true
REQUIRE_NUMBER = true
REQUIRE_SPECIAL_CHAR = true
ENCRYPTION_KEY = 'LookBackCafe2024SecureKey!@#$%'
ENCRYPTION_METHOD = 'AES-256-CBC'
```

---

## Error Messages

### Password Validation Errors
- "Password must be at least 12 characters long"
- "Password must contain at least one lowercase letter"
- "Password must contain at least one uppercase letter"
- "Password must contain at least one number"
- "Password must contain at least one special character"
- "Password is too common. Please choose a stronger password"

### Login Errors
- `?error=rate_limit` - Too many login attempts
- `?error=1` - Invalid credentials
- `?error=unauthorized` - Insufficient permissions

---

## Production Deployment

Before deploying to production:

1. **Run database migration:**
   ```bash
   mysql -u root -p lookback_cafe < database_security_migration.sql
   ```

2. **Enable HTTPS enforcement:**
   - Uncomment HTTPS redirect in `.htaccess`
   - Add `enforce_https()` to critical pages

3. **Secure encryption key:**
   - Move `ENCRYPTION_KEY` to environment variable
   - Update code to use `getenv('ENCRYPTION_KEY')`

4. **Enable security headers:**
   - Uncomment HSTS in `.htaccess`
   - Configure CSP as needed

5. **Test all security features:**
   - Password validation
   - Rate limiting
   - Role-based access
   - Session security
   - HTTPS redirection

---

## Support

For security issues or questions, refer to:
- Full documentation: `SECURITY_IMPLEMENTATION.md`
- Security configuration: `website/config/security.php`
- Database schema: `database_security_migration.sql`