  # LOGIN PAGES DISCUSSION GUIDE
  ## For Professor Review & Debugging

  ---

  ## FILE: as_user.php (User Login Page)

  ### PURPOSE
  This page displays the login form for regular users (customers).

  ### CRITICAL DEPENDENCIES

  #### 1. **LINE 2: `require_once 'includes/security_init.php';`**
  - **FUNCTION**: Initializes security headers and session
  - **CONTAINS**: Security headers (CSP, X-Frame-Options, etc.) and `session_start()`
  - **IF REMOVED**: 
    - Session won't start → `$_SESSION` variables won't work
    - Error messages won't display (lines 76-79)
    - Security headers missing → vulnerable to XSS, clickjacking
  - **DEBUG**: Check if `session_start()` is called elsewhere, add security headers manually

  #### 2. **LINE 32: `<form action="auth/login.php" method="POST">`**
  - **FUNCTION**: Submits login credentials to authentication handler
  - **PROCESSES**: Calls `check_rate_limit()`, `record_login_attempt()`, `verify_password()`
  - **IF REMOVED/CHANGED**: 
    - Login won't work at all
    - Form submits to wrong page
  - **DEBUG**: Verify `auth/login.php` exists and is accessible

  #### 3. **LINE 33: `<input type="hidden" name="role" value="user">`**
  - **FUNCTION**: Tells login.php this is a USER login (not admin)
  - **USED BY**: `auth/login.php` to determine which table to check (users vs admin)
  - **IF REMOVED**:
    - Login will default to user role but may cause confusion
    - May check wrong database table
  - **DEBUG**: Check if `$role` variable in `auth/login.php` has proper default

  #### 4. **LINE 36: `<input type="email" name="email" ... required>`**
  - **FUNCTION**: Email input field for user identification
  - **USED BY**: `auth/login.php` as `$email = $_POST["email"]`
  - **IF REMOVED**:
    - Login will fail - no email submitted
    - Rate limiting won't work (needs identifier)
  - **DEBUG**: Check if `$_POST["email"]` is set in `auth/login.php`

  #### 5. **LINE 40: `<input type="password" name="password" ... required>`**
  - **FUNCTION**: Password input field for authentication
  - **USED BY**: `auth/login.php` as `$password = $_POST["password"]`
  - **IF REMOVED**:
    - Login will fail - no password to verify
    - `verify_password()` will fail
  - **DEBUG**: Check if `$_POST["password"]` is set in `auth/login.php`

  #### 6. **LINES 76-79: Error message display**
  ```php
  <?php if (isset($_SESSION['error_message'])): ?>
      alert('<?php echo addslashes($_SESSION['error_message']); ?>');
      <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
  ```
  - **FUNCTION**: Shows rate limit errors and login failures
  - **DEPENDS ON**: `$_SESSION['error_message']` set by `auth/login.php`
  - **IF REMOVED**:
    - Users won't see error messages
    - Won't know why login failed or if rate limited
  - **DEBUG**: Check browser console, verify session is working

  ### JAVASCRIPT FUNCTIONS

  #### 7. **LINES 62-74: `togglePassword()` function**
  - **FUNCTION**: Shows/hides password text
  - **DEPENDS ON**: password input `id="password"`, `.toggle-password` button
  - **IF REMOVED**:
    - Password toggle button won't work
    - Password stays hidden
  - **DEBUG**: Check if password input has `id="password"`

  ### FORM FLOW
  ```
  User Input → as_user.php (this page) 
            → auth/login.php 
            → check_rate_limit() 
            → verify credentials 
            → record_login_attempt() 
            → redirect to main.php or back here
  ```

  ### RATE LIMITING INTEGRATION
  - When form submits, `auth/login.php` calls `check_rate_limit($email, 5, 60)`
  - If 5 failed attempts in 60 seconds: Sets `$_SESSION['error_message']` and redirects back
  - Error displays via JavaScript alert (lines 76-79)
  - After 60 seconds, rate limit automatically resets

  ---

  ## FILE: as_admin.php (Admin Login Page)

  ### PURPOSE
  This page displays the login form for administrators.

  ### CRITICAL DEPENDENCIES

  #### 1. **LINE 2: `require_once 'includes/security_init.php';`**
  - **FUNCTION**: Initializes security headers and session
  - **CONTAINS**: Security headers (CSP, X-Frame-Options, etc.) and `session_start()`
  - **IF REMOVED**: 
    - Session won't start → `$_SESSION` variables won't work
    - Error messages won't display (lines 68-71)
    - Security headers missing → vulnerable to XSS, clickjacking
  - **DEBUG**: Check if `session_start()` is called elsewhere, add security headers manually

  #### 2. **LINE 32: `<form action="auth/login.php" method="POST">`**
  - **FUNCTION**: Submits login credentials to authentication handler
  - **PROCESSES**: Calls `check_rate_limit()`, `record_login_attempt()`, `verify_password()`
  - **IF REMOVED/CHANGED**: 
    - Login won't work at all
    - Form submits to wrong page
  - **DEBUG**: Verify `auth/login.php` exists and is accessible

  #### 3. **LINE 33: `<input type="hidden" name="role" value="admin">`**
  - **FUNCTION**: Tells login.php this is an ADMIN login (not user)
  - **USED BY**: `auth/login.php` to determine which table to check (admin vs users)
  - **IF REMOVED**:
    - Login will default to user role
    - Will check wrong database table (users instead of admin)
    - Admin won't be able to login
  - **DEBUG**: Check if `$role` variable in `auth/login.php` has proper default

  #### 4. **LINE 36: `<input type="text" name="username" ... required>`**
  - **FUNCTION**: Username/email input field for admin identification
  - **USED BY**: `auth/login.php` as `$email = $_POST["username"]` (note: variable name is email but input is username)
  - **IF REMOVED**:
    - Login will fail - no username/email submitted
    - Rate limiting won't work (needs identifier)
  - **DEBUG**: Check if `$_POST["username"]` OR `$_POST["email"]` is set in `auth/login.php`

  #### 5. **LINE 40: `<input type="password" name="password" ... required>`**
  - **FUNCTION**: Password input field for authentication
  - **USED BY**: `auth/login.php` as `$password = $_POST["password"]`
  - **IF REMOVED**:
    - Login will fail - no password to verify
    - `verify_password()` will fail
  - **DEBUG**: Check if `$_POST["password"]` is set in `auth/login.php`

  #### 6. **LINES 68-71: Error message display**
  ```php
  <?php if (isset($_SESSION['error_message'])): ?>
      alert('<?php echo addslashes($_SESSION['error_message']); ?>');
      <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
  ```
  - **FUNCTION**: Shows rate limit errors and login failures
  - **DEPENDS ON**: `$_SESSION['error_message']` set by `auth/login.php`
  - **IF REMOVED**:
    - Admins won't see error messages
    - Won't know why login failed or if rate limited
  - **DEBUG**: Check browser console, verify session is working

  ### JAVASCRIPT FUNCTIONS

  #### 7. **LINES 54-66: `togglePassword()` function**
  - **FUNCTION**: Shows/hides password text
  - **DEPENDS ON**: password input `id="password"`, `.toggle-password` button
  - **IF REMOVED**:
    - Password toggle button won't work
    - Password stays hidden
  - **DEBUG**: Check if password input has `id="password"`

  ### FORM FLOW
  ```
  Admin Input → as_admin.php (this page) 
              → auth/login.php 
              → check_rate_limit() 
              → verify admin credentials 
              → record_login_attempt() 
              → redirect to admindash.php or back here
  ```

  ### RATE LIMITING INTEGRATION
  - When form submits, `auth/login.php` calls `check_rate_limit($email, 5, 60)`
  - If 5 failed attempts in 60 seconds: Sets `$_SESSION['error_message']` and redirects back
  - Error displays via JavaScript alert (lines 68-71)
  - After 60 seconds, rate limit automatically resets

  ---

  ## FILE: auth/login.php (Authentication Handler)

  ### PURPOSE
  Processes login requests from both user and admin login pages.

  ### CRITICAL FUNCTIONS

  #### 1. **`check_rate_limit($identifier, $max_attempts = 5, $time_window = 60)`**
  - **LOCATION**: `config/security.php` line 368
  - **FUNCTION**: Checks if user/admin has exceeded login attempts
  - **PARAMETERS**:
    - `$identifier`: Email/username of person trying to login
    - `$max_attempts`: Maximum failed attempts allowed (default: 5)
    - `$time_window`: Time window in seconds (default: 60)
  - **RETURNS**: `true` if rate limited (blocked), `false` if allowed
  - **SQL QUERY**: 
    ```sql
    SELECT COUNT(*) FROM login_attempts 
    WHERE identifier = ? 
    AND UNIX_TIMESTAMP(attempt_time) >= ? 
    AND success = 0
    ```
  - **IF REMOVED**:
    - No rate limiting protection
    - Brute force attacks possible
    - Unlimited login attempts allowed
  - **DEBUG**: Check if function exists in `config/security.php`

  #### 2. **`record_login_attempt($identifier, $success = false)`**
  - **LOCATION**: `config/security.php` line 390
  - **FUNCTION**: Records each login attempt in database
  - **PARAMETERS**:
    - `$identifier`: Email/username of person trying to login
    - `$success`: `true` if login succeeded, `false` if failed
  - **SQL OPERATIONS**:
    - INSERT: Adds new login attempt record
    - DELETE: Cleans up attempts older than 1 hour
  - **IF REMOVED**:
    - Login attempts not tracked
    - Rate limiting won't work (no data to check)
    - No audit trail of login attempts
  - **DEBUG**: Check if function exists in `config/security.php`

  #### 3. **`verify_password($password, $hash)`**
  - **LOCATION**: `config/security.php`
  - **FUNCTION**: Verifies password against bcrypt hash
  - **USES**: `password_verify()` PHP function
  - **IF REMOVED**:
    - Password verification fails
    - Can't login even with correct password
  - **DEBUG**: Check if function exists in `config/security.php`

  #### 4. **`sanitize_input($data)`**
  - **LOCATION**: `config/security.php`
  - **FUNCTION**: Cleans user input to prevent XSS
  - **OPERATIONS**: `trim()`, `stripslashes()`, `htmlspecialchars()`
  - **IF REMOVED**:
    - XSS vulnerabilities
    - Malicious input not filtered
  - **DEBUG**: Check if function exists in `config/security.php`

  #### 5. **`log_security_event($event_type, $description, $user_id)`**
  - **LOCATION**: `config/security.php` line 349
  - **FUNCTION**: Logs security events to database
  - **EVENTS LOGGED**:
    - `rate_limit_exceeded`: Too many login attempts
    - `admin_login_success`: Admin logged in
    - `admin_login_failed`: Admin login failed
    - `user_login_success`: User logged in
    - `user_login_failed`: User login failed
  - **IF REMOVED**:
    - No security audit trail
    - Can't track suspicious activity
  - **DEBUG**: Check if function exists in `config/security.php`

  ### LOGIN FLOW LOGIC

  ```php
  // LINE 11: Get form inputs
  $email = sanitize_input($_POST["email"] ?? $_POST["username"] ?? "");
  $password = $_POST["password"] ?? "";
  $role = $_POST["role"] ?? "user";

  // LINE 16: Check rate limiting BEFORE attempting login
  if (check_rate_limit($email)) {
      log_security_event('rate_limit_exceeded', "Too many login attempts for: $email", null);
      $_SESSION['error_message'] = "Too many login attempts. Please try again later.";
      header("Location: ../" . ($role === "admin" ? "as_admin.php" : "as_user.php"));
      exit();
  }

  // LINE 23-58: If role is admin
  if ($role === "admin") {
      // Query admin table
      // Verify password
      // If success: record_login_attempt($email, true) and redirect to admindash.php
      // If fail: record_login_attempt($email, false) and redirect back to as_admin.php
  }

  // LINE 60-96: If role is user
  else {
      // Query users table
      // Verify password
      // If success: record_login_attempt($email, true) and redirect to main.php
      // If fail: record_login_attempt($email, false) and redirect back to as_user.php
  }
  ```

  ---

  ## COMMON DEBUGGING SCENARIOS

  ### 1. "Login button does nothing"
  - **CHECK**: Form action path (line 32 in as_user.php / as_admin.php)
  - **FIX**: Ensure `action="auth/login.php"` is correct
  - **TEST**: Check browser network tab for form submission

  ### 2. "No error messages show"
  - **CHECK**: `security_init.php` session start (line 2)
  - **CHECK**: Error display code (lines 76-79 in as_user.php, 68-71 in as_admin.php)
  - **FIX**: Verify `session_start()` is called
  - **TEST**: Add `var_dump($_SESSION)` to see session contents

  ### 3. "Password toggle broken"
  - **CHECK**: `togglePassword()` function exists
  - **CHECK**: Password input has `id="password"`
  - **FIX**: Ensure JavaScript is not blocked
  - **TEST**: Check browser console for errors

  ### 4. "Rate limit not working"
  - **CHECK**: `check_rate_limit()` is called in `auth/login.php` (line 16)
  - **CHECK**: `record_login_attempt()` is called after login attempt
  - **FIX**: Verify both functions exist in `config/security.php`
  - **TEST**: Run `php lookbackcafe/test_rate_limit.php`

  ### 5. "Can't login after waiting 60 seconds"
  - **CHECK**: `UNIX_TIMESTAMP()` fix is applied in `check_rate_limit()` (line 375)
  - **CHECK**: Cleanup query uses `UNIX_TIMESTAMP()` (line 402)
  - **FIX**: Update both queries to use `UNIX_TIMESTAMP(attempt_time) >= ?`
  - **TEST**: Run `php lookbackcafe/test_full_scenario.php`

  ### 6. "Admin login goes to user page"
  - **CHECK**: Hidden input `name="role" value="admin"` exists (line 33 in as_admin.php)
  - **FIX**: Ensure role input is present and value is "admin"
  - **TEST**: Check `$_POST['role']` value in `auth/login.php`

  ### 7. "Database connection error"
  - **CHECK**: `require_once '../config/db.php'` in `auth/login.php`
  - **CHECK**: Database credentials in `config/db.php`
  - **FIX**: Verify MySQL is running, credentials are correct
  - **TEST**: Run `php -r "require 'website/config/db.php'; echo 'Connected';"` 

  ### 8. "Session not persisting"
  - **CHECK**: `session_start()` is called (in `security_init.php`)
  - **CHECK**: Cookies are enabled in browser
  - **FIX**: Clear browser cookies and try again
  - **TEST**: Check if `PHPSESSID` cookie is set

  ---

  ## RATE LIMITING TECHNICAL DETAILS

  ### How It Works
  1. **On Login Attempt**: `auth/login.php` calls `check_rate_limit($email, 5, 60)`
  2. **Query Executes**: Counts failed attempts in last 60 seconds using `UNIX_TIMESTAMP()`
  3. **If Count >= 5**: User is blocked, error message set
  4. **If Count < 5**: Login proceeds normally
  5. **After Login**: `record_login_attempt()` logs the attempt (success or failure)
  6. **Cleanup**: Old attempts (>1 hour) are automatically deleted

  ### Why UNIX_TIMESTAMP() is Critical
  - **Problem**: PHP and MySQL may use different timezones
  - **Solution**: `UNIX_TIMESTAMP()` converts to UTC seconds since epoch
  - **Result**: Timezone-independent comparison that always works correctly

  ### Database Table: login_attempts
  ```sql
  CREATE TABLE `login_attempts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `identifier` varchar(255) NOT NULL,  -- Email or username
    `role` varchar(20) DEFAULT 'user',   -- 'user' or 'admin'
    `ip_address` varchar(45) DEFAULT NULL,
    `success` tinyint(1) DEFAULT 0,      -- 0 = failed, 1 = success
    `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
  );
  ```

  ---

  ## QUICK REFERENCE: File Dependencies

  ```
  as_user.php
  ├── includes/security_init.php (session, headers)
  ├── auth/login.php (form action)
  │   ├── config/db.php (database connection)
  │   └── config/security.php
  │       ├── check_rate_limit()
  │       ├── record_login_attempt()
  │       ├── verify_password()
  │       ├── sanitize_input()
  │       └── log_security_event()
  └── resources/css/as_user.css (styling)

  as_admin.php
  ├── includes/security_init.php (session, headers)
  ├── auth/login.php (form action)
  │   ├── config/db.php (database connection)
  │   └── config/security.php
  │       ├── check_rate_limit()
  │       ├── record_login_attempt()
  │       ├── verify_password()
  │       ├── sanitize_input()
  │       └── log_security_event()
  └── resources/css/as_admin.css (styling)
  ```

  ---

  ## END OF DISCUSSION GUIDE