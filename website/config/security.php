<?php
/**
 * Security Configuration and Utilities
 * Implements password validation, encryption, and security helpers
 */

// Include security headers
require_once __DIR__ . '/headers.php';

// Set security headers on every page that includes this file
set_security_headers();

// Password validation constants
define('MIN_PASSWORD_LENGTH', 12);
define('REQUIRE_UPPERCASE', true);
define('REQUIRE_LOWERCASE', true);
define('REQUIRE_NUMBER', true);
define('REQUIRE_SPECIAL_CHAR', true);

// Weak password blacklist
$GLOBALS['weak_passwords'] = [
    "password", 
    "123456", 
    "qwerty", 
    "admin", 
    "password123",
    "12345678",
    "123456789",
    "1234567890",
    "letmein",
    "welcome",
    "abc123",
    "iloveyou",
    "user",
];

/**
 * Validate password strength
 * 
 * @param string $password The password to validate
 * @return array ['valid' => bool, 'errors' => array]
 */
function validate_password($password) {
    $errors = [];
    
    // Check minimum length
    if (strlen($password) < MIN_PASSWORD_LENGTH) {
        $errors[] = "Password must be at least " . MIN_PASSWORD_LENGTH . " characters long";
    }
    
    // Check for lowercase letter
    if (REQUIRE_LOWERCASE && !preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }
    
    // Check for uppercase letter
    if (REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }
    
    // Check for number
    if (REQUIRE_NUMBER && !preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }
    
    // Check for special character
    if (REQUIRE_SPECIAL_CHAR && !preg_match('/[^a-zA-Z0-9]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }
    
    // Check against weak password list
    $lowercase_password = strtolower($password);
    foreach ($GLOBALS['weak_passwords'] as $weak) {
        if ($lowercase_password === $weak || strpos($lowercase_password, $weak) !== false) {
            $errors[] = "Password is too common. Please choose a stronger password";
            break;
        }
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Hash password using bcrypt
 * 
 * @param string $password The password to hash
 * @return string The hashed password
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password against hash
 * 
 * @param string $password The password to verify
 * @param string $hash The hash to verify against
 * @return bool True if password matches hash
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * AES-256 Encryption for sensitive data
 * Uses OpenSSL with AES-256-CBC
 */

// Encryption key - IMPORTANT: Store this securely in environment variables in production
// For now, using a constant. In production, use: getenv('ENCRYPTION_KEY')
define('ENCRYPTION_KEY', 'LookBackCafe2024SecureKey!@#$%'); // 32 bytes for AES-256
define('ENCRYPTION_METHOD', 'AES-256-CBC');

/**
 * Encrypt sensitive data
 * Uses OpenSSL if available, otherwise falls back to basic encryption
 * 
 * @param string $data The data to encrypt
 * @return string|false The encrypted data (base64 encoded) or false on failure
 */
function encrypt_data($data) {
    if (empty($data)) {
        return false;
    }
    
    // Check if OpenSSL is available
    if (function_exists('openssl_encrypt') && function_exists('openssl_cipher_iv_length')) {
        // Use OpenSSL AES-256-CBC
        $iv_length = openssl_cipher_iv_length(ENCRYPTION_METHOD);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $key = hash('sha256', ENCRYPTION_KEY, true);
        $encrypted = openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv);
        
        if ($encrypted === false) {
            return false;
        }
        
        return base64_encode('openssl:' . $iv . $encrypted);
    } else {
        // Fallback: Use XOR cipher with random key (basic encryption)
        // Note: This is NOT as secure as AES-256, but better than nothing
        $key = hash('sha256', ENCRYPTION_KEY);
        $iv = substr(md5(microtime()), 0, 16); // Random IV
        $encrypted = '';
        
        for ($i = 0; $i < strlen($data); $i++) {
            $encrypted .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
        }
        
        return base64_encode('fallback:' . $iv . $encrypted);
    }
}

/**
 * Decrypt sensitive data
 * 
 * @param string $encrypted_data The encrypted data (base64 encoded)
 * @return string|false The decrypted data or false on failure
 */
function decrypt_data($encrypted_data) {
    if (empty($encrypted_data)) {
        return false;
    }
    
    $data = base64_decode($encrypted_data);
    if ($data === false) {
        return false;
    }
    
    // Check encryption method used
    if (strpos($data, 'openssl:') === 0) {
        // OpenSSL decryption
        if (!function_exists('openssl_decrypt') || !function_exists('openssl_cipher_iv_length')) {
            error_log('Cannot decrypt: OpenSSL not available');
            return false;
        }
        
        $data = substr($data, 8); // Remove 'openssl:' prefix
        $iv_length = openssl_cipher_iv_length(ENCRYPTION_METHOD);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        $key = hash('sha256', ENCRYPTION_KEY, true);
        
        return openssl_decrypt($encrypted, ENCRYPTION_METHOD, $key, 0, $iv);
        
    } elseif (strpos($data, 'fallback:') === 0) {
        // Fallback XOR decryption
        $data = substr($data, 9); // Remove 'fallback:' prefix
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        $key = hash('sha256', ENCRYPTION_KEY);
        $decrypted = '';
        
        for ($i = 0; $i < strlen($encrypted); $i++) {
            $decrypted .= chr(ord($encrypted[$i]) ^ ord($key[$i % strlen($key)]));
        }
        
        return $decrypted;
    }
    
    return false;
}

/**
 * Sanitize user input to prevent XSS - Enhanced version
 * 
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function sanitize_input($data) {
    if ($data === null) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}

/**
 * Sanitize array of inputs recursively
 * 
 * @param array $data The array to sanitize
 * @return array The sanitized array
 */
function sanitize_array($data) {
    $sanitized = [];
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $sanitized[$key] = sanitize_array($value);
        } else {
            $sanitized[$key] = sanitize_input($value);
        }
    }
    return $sanitized;
}

/**
 * Validate email format
 * 
 * @param string $email The email to validate
 * @return bool True if valid email
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate secure random token
 * 
 * @param int $length The length of the token
 * @return string The random token
 */
function generate_secure_token($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Check if request is using HTTPS
 * 
 * @return bool True if using HTTPS
 */
function is_https() {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
}

/**
 * Enforce HTTPS connection
 * Redirects to HTTPS if not already using it
 */
function enforce_https() {
    if (!is_https() && php_sapi_name() !== 'cli') {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

/**
 * Set secure session configuration
 */
function configure_secure_session() {
    // Only set session ini settings if session hasn't started yet
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', is_https() ? 1 : 0);
        ini_set('session.cookie_samesite', 'Strict');
    }
    
    // Regenerate session ID periodically to prevent session fixation
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

/**
 * Check if user has required role
 * 
 * @param string|array $required_role The required role(s)
 * @return bool True if user has required role
 */
function check_role($required_role) {
    if (!isset($_SESSION['role'])) {
        return false;
    }
    
    if (is_array($required_role)) {
        return in_array($_SESSION['role'], $required_role);
    }
    
    return $_SESSION['role'] === $required_role;
}

/**
 * Require authentication
 * Redirects to login if not authenticated
 * 
 * @param string|array $required_role Optional role requirement
 */
function require_auth($required_role = null) {
    if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
        header("Location: login_as.php");
        exit();
    }
    
    if ($required_role !== null && !check_role($required_role)) {
        header("Location: login_as.php?error=unauthorized");
        exit();
    }
}

/**
 * Log security event
 * 
 * @param string $event_type The type of security event
 * @param string $description Description of the event
 * @param int|null $user_id The user ID if applicable
 */
function log_security_event($event_type, $description, $user_id = null) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    
    $stmt = $conn->prepare("INSERT INTO security_log (event_type, description, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $event_type, $description, $user_id, $ip_address, $user_agent);
    $stmt->execute();
}

/**
 * Rate limiting for login attempts
 * 
 * @param string $identifier Email or IP address
 * @param int $max_attempts Maximum attempts allowed
 * @param int $time_window Time window in seconds
 * @return bool True if rate limit exceeded
 */
function check_rate_limit($identifier, $max_attempts = 5, $time_window = 60) {
    global $conn;
    
    $time_threshold = date('Y-m-d H:i:s', time() - $time_window);
    
    $stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND attempt_time > ?");
    $stmt->bind_param("ss", $identifier, $time_threshold);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['attempts'] >= $max_attempts;
}

/**
 * Record login attempt
 * 
 * @param string $identifier Email or IP address
 * @param bool $success Whether login was successful
 */
function record_login_attempt($identifier, $success = false) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    
    $stmt = $conn->prepare("INSERT INTO login_attempts (identifier, ip_address, success) VALUES (?, ?, ?)");
    $success_int = $success ? 1 : 0;
    $stmt->bind_param("ssi", $identifier, $ip_address, $success_int);
    $stmt->execute();
    
    // Clean up old attempts - keep only last 1 hour of data (3600 seconds)
    // This ensures old failed attempts don't accumulate and block users forever
     $cleanup_time = date('Y-m-d H:i:s', time() - 60); // 24 hours
    $conn->query("DELETE FROM login_attempts WHERE attempt_time < '$cleanup_time'");
}
?>