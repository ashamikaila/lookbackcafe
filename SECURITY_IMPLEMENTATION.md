# Security Implementation Guide
## Look Back Café Online System

This document outlines the security measures implemented in the Look Back Café system.

---

## 1. Password Protection

### Bcrypt Hashing
All user passwords are secured using **Bcrypt hashing** with a cost factor of 12, which provides strong protection against credential theft and brute-force attacks.

**Implementation:**
- Location: `website/config/security.php`
- Functions: `hash_password()`, `verify_password()`
- Algorithm: PASSWORD_BCRYPT with cost=12

**Usage Example:**
```php
// Hash password during registration
$hashed_password = hash_password($password);

// Verify password during login
if (verify_password($password, $stored_hash)) {
    // Login successful
}
```

### Password Requirements

All passwords must meet the following criteria:

1. **Minimum Length**: At least 12 characters (configurable via `MIN_PASSWORD_LENGTH`)
2. **Required Character Types**:
   - At least one lowercase letter (a-z)
   - At least one uppercase letter (A-Z)
   - At least one number (0-9)
   - At least one special character (!@#$%^&*()_+-=[]{}|;:,.<>?)

3. **Weak Password Protection**:
   - Passwords are checked against a blacklist of common weak passwords
   - Blacklist includes: "password", "123456", "qwerty", "admin", "password123", and more
   - Location: `website/config/security.php` - `$weak_passwords` array

**Implementation:**
- Function: `validate_password($password)`
- Returns: `['valid' => bool, 'errors' => array]`

---

## 2. Data Encryption

### AES-256 Encryption
Sensitive data (personal details, transaction records) is encrypted using **AES-256-CBC** encryption to ensure confidentiality and data integrity.

**Implementation:**
- Location: `website/config/security.php`
- Functions: `encrypt_data()`, `decrypt_data()`
- Algorithm: AES-256-CBC with OpenSSL
- Key Derivation: SHA-256 hash of encryption key

**Usage Example:**
```php
// Encrypt sensitive data
$encrypted = encrypt_data($sensitive_info);

// Decrypt when needed
$decrypted = decrypt_data($encrypted);
```

**Important Security Notes:**
- Encryption key is currently stored as a constant in `security.php`
- **For Production**: Store encryption key in environment variables
- Each encryption uses a unique random Initialization Vector (IV)
- Encrypted data is base64 encoded for safe storage

**Database Table:**
- Table: `encrypted_data`
- Stores encrypted sensitive information with user association

---

## 3. Data Transmission Security

### HTTPS/TLS Implementation

The system enforces HTTPS with TLS 1.2 or higher for all data transmission to protect against interception and man-in-the-middle attacks.

**Implementation:**
- Location: `website/config/security.php`
- Functions: `is_https()`, `enforce_https()`

**Features:**
- Automatic HTTPS redirection (when enabled)
- Secure session cookies (httponly, secure, samesite)
- Detection of HTTPS via multiple methods:
  - `$_SERVER['HTTPS']`
  - Server port 443
  - X-Forwarded-Proto header

**Session Security:**
```php
configure_secure_session();
```
This function sets:
- `session.cookie_httponly = 1` (prevent XSS access to cookies)
- `session.use_only_cookies = 1` (prevent session fixation)
- `session.cookie_secure = 1` (HTTPS only)
- `session.cookie_samesite = Strict` (CSRF protection)
- Automatic session regeneration every 5 minutes

**To Enable HTTPS Enforcement:**
Add this line at the top of sensitive pages:
```php
enforce_https();
```

---

## 4. Access Control

### Role-Based Access Control (RBAC)

The system implements role-based access control with three user types:

1. **Guest Users**
   - Can view public content only
   - No authentication required
   - Limited to public pages

2. **Registered Users**
   - Can manage their accounts
   - Access to user dashboard
   - Can update profile and change password
   - Role: `"user"`

3. **Administrators**
   - Full system access
   - Manage content, users, and system settings
   - Access to admin dashboard
   - Role: `"admin"`

**Implementation:**

**Function: `require_auth($required_role = null)`**
```php
// Require any authenticated user
require_auth();

// Require specific role
require_auth('admin');

// Require one of multiple roles
require_auth(['admin', 'moderator']);
```

**Function: `check_role($required_role)`**
```php
if (check_role('admin')) {
    // Admin-only code
}
```

**Session Variables:**
- `$_SESSION['is_logged_in']` - Boolean authentication status
- `$_SESSION['role']` - User role (guest/user/admin)
- `$_SESSION['user_id']` - User identifier
- `$_SESSION['user_email']` - User email
- `$_SESSION['user_name']` - User name

**Protected Pages:**
- Admin pages: Check for `role === 'admin'`
- User pages: Check for `is_logged_in === true`
- Public pages: No authentication required

---

## 5. Additional Security Features

### Rate Limiting
Prevents brute-force attacks by limiting login attempts.

**Configuration:**
- Maximum attempts: 5 per 15 minutes (900 seconds)
- Tracked by: Email address and IP
- Table: `login_attempts`

**Functions:**
```php
check_rate_limit($identifier, $max_attempts = 5, $time_window = 900);
record_login_attempt($identifier, $success = false);
```

### Security Event Logging
All security-related events are logged for audit purposes.

**Table:** `security_log`

**Logged Events:**
- User registration
- Login success/failure
- Password changes
- Rate limit violations
- Unauthorized access attempts

**Function:**
```php
log_security_event($event_type, $description, $user_id = null);
```

### Input Sanitization
All user inputs are sanitized to prevent XSS attacks.

**Function:**
```php
$clean_input = sanitize_input($user_input);
```

**Features:**
- Trims whitespace
- Removes slashes
- Converts special characters to HTML entities
- UTF-8 encoding

### Email Validation
Validates email addresses using PHP's filter functions.

**Function:**
```php
if (validate_email($email)) {
    // Valid email
}
```

---

## 6. Database Security

### SQL Injection Prevention
- All database queries use **prepared statements**
- Parameters are bound using `bind_param()`
- No direct string concatenation in queries

### Database Connection Security
- UTF-8 character set to prevent encoding-based attacks
- SSL/TLS support (configurable)
- Error messages sanitized (no sensitive info exposed)

**Location:** `website/config/db.php`

---

## 7. Setup Instructions

### 1. Database Migration
Run the security migration script to create necessary tables:

```sql
mysql -u root -p lookback_cafe < database_security_migration.sql
```

This creates:
- `security_log` table
- `login_attempts` table
- `encrypted_data` table
- Necessary indexes
- Cleanup events

### 2. Update Existing Code
All authentication and user management files have been updated:
- `auth/register.php` - Enhanced password validation
- `auth/login.php` - Rate limiting and security logging
- `editprofile.php` - Secure password changes
- All admin pages - Role-based access control

### 3. Configure HTTPS (Production)
1. Obtain SSL/TLS certificate
2. Configure web server (Apache/Nginx) for HTTPS
3. Enable HTTPS enforcement in code:
   ```php
   require_once 'config/security.php';
   enforce_https();
   ```

### 4. Environment Variables (Production)
Store sensitive configuration in environment variables:
```php
// In security.php, replace:
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY'));
```

Set in your server environment:
```bash
export ENCRYPTION_KEY="your-32-byte-secure-key-here"
```

---

## 8. Testing Checklist

- [ ] Password validation rejects weak passwords
- [ ] Password validation requires all character types
- [ ] Bcrypt hashing works for registration and login
- [ ] Rate limiting blocks after 5 failed attempts
- [ ] Security events are logged correctly
- [ ] Admin pages require admin role
- [ ] User pages require authentication
- [ ] Session cookies are secure (httponly, secure, samesite)
- [ ] HTTPS redirection works (if enabled)
- [ ] Data encryption/decryption functions work
- [ ] SQL injection attempts are blocked
- [ ] XSS attempts are sanitized

---

## 9. Maintenance

### Regular Tasks
1. **Review Security Logs**: Check `security_log` table weekly
2. **Monitor Login Attempts**: Review `login_attempts` for suspicious activity
3. **Update Dependencies**: Keep PHP and MySQL updated
4. **Rotate Encryption Keys**: Change encryption key periodically
5. **Review Access Controls**: Audit user roles and permissions

### Automated Cleanup
The system automatically cleans up:
- Login attempts older than 7 days
- Security logs older than 90 days

---

## 10. Security Best Practices

### For Developers
1. Always use `require_auth()` on protected pages
2. Sanitize all user inputs with `sanitize_input()`
3. Use prepared statements for all database queries
4. Never store passwords in plain text
5. Log security events for audit trails
6. Validate and sanitize file uploads
7. Use HTTPS in production
8. Keep encryption keys secure

### For Administrators
1. Use strong admin passwords (12+ characters)
2. Enable two-factor authentication (future enhancement)
3. Regularly review security logs
4. Monitor for suspicious login attempts
5. Keep system updated
6. Backup encrypted data securely
7. Use HTTPS for all admin access

---

## 11. Future Enhancements

Recommended security improvements:
- [ ] Two-factor authentication (2FA)
- [ ] CAPTCHA for login forms
- [ ] IP whitelisting for admin access
- [ ] Content Security Policy (CSP) headers
- [ ] Automated security scanning
- [ ] Password expiration policy
- [ ] Account lockout after multiple failures
- [ ] Security headers (X-Frame-Options, X-XSS-Protection, etc.)

---

## Contact

For security concerns or to report vulnerabilities, please contact the system administrator.

**Last Updated:** 2024
**Version:** 1.0