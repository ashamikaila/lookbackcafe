<?php
/**
 * Security Headers Configuration
 * Implements comprehensive security headers to protect against common web vulnerabilities
 * Fixes OWASP ZAP security warnings
 */

/**
 * Set all security headers
 * Call this function at the beginning of every page
 */
function set_security_headers() {
    // Prevent output if headers already sent
    if (headers_sent()) {
        return;
    }
    
    // 1. Content Security Policy (CSP) - FIX for ZAP Alert #1
    // Defines approved sources of content to prevent XSS attacks
    $csp_directives = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://www.google.com https://www.gstatic.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "img-src 'self' data: https: http:",
        "font-src 'self' https://fonts.gstatic.com data:",
        "connect-src 'self'",
        "media-src 'self'",
        "object-src 'none'",
        "frame-src 'self' https://www.google.com",
        "base-uri 'self'",
        "form-action 'self'",  // FIX: Prevents forms from submitting to external sites
        "frame-ancestors 'self'",  // FIX: Prevents clickjacking by controlling where page can be embedded
        "upgrade-insecure-requests"
    ];
    header("Content-Security-Policy: " . implode("; ", $csp_directives));
    
    // 2. X-Frame-Options - Prevents clickjacking
    header("X-Frame-Options: SAMEORIGIN");
    
    // 3. X-Content-Type-Options - Prevents MIME type sniffing
    header("X-Content-Type-Options: nosniff");
    
    // 4. X-XSS-Protection - Enables browser XSS filter (legacy but still useful)
    header("X-XSS-Protection: 1; mode=block");
    
    // 5. Referrer-Policy - Controls referrer information
    // FIX for ZAP Alert #3: Prevents sensitive info in URLs from leaking
    header("Referrer-Policy: strict-origin-when-cross-origin");
    
    // 6. Permissions-Policy - Controls browser features
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    
    // 7. Strict-Transport-Security (HSTS) - Forces HTTPS
    // Only set if using HTTPS
    if (is_https()) {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    }
    
    // 8. Cache-Control for sensitive pages
    // Prevents caching of sensitive data
    if (is_sensitive_page()) {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
    
    // 9. Set secure cookie attributes
    set_secure_cookie_params();
}

/**
 * Check if current page contains sensitive information
 * 
 * @return bool True if page is sensitive
 */
function is_sensitive_page() {
    $sensitive_pages = [
        'login.php',
        'register.php',
        'editprofile.php',
        'admindash.php',
        'user-accounts.php',
        'analytics.php',
        'menumanagement.php',
        'as_admin.php',
        'as_user.php',
        'login_as.php'
    ];
    
    $current_page = basename($_SERVER['PHP_SELF']);
    return in_array($current_page, $sensitive_pages);
}

/**
 * Set secure cookie parameters
 */
function set_secure_cookie_params() {
    if (session_status() === PHP_SESSION_NONE) {
        $params = [
            'lifetime' => 0,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'] ?? '',
            'secure' => is_https(),
            'httponly' => true,
            'samesite' => 'Strict'
        ];
        
        if (PHP_VERSION_ID >= 70300) {
            session_set_cookie_params($params);
        } else {
            session_set_cookie_params(
                $params['lifetime'],
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
    }
}

/**
 * Sanitize output for HTML context - FIX for ZAP Alert #5 (XSS)
 * Use this when outputting user data in HTML
 * 
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function escape_html($data) {
    if ($data === null) {
        return '';
    }
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sanitize output for HTML attribute context
 * 
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function escape_attr($data) {
    if ($data === null) {
        return '';
    }
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sanitize output for JavaScript context
 * 
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function escape_js($data) {
    if ($data === null) {
        return '';
    }
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

/**
 * Sanitize output for URL context
 * 
 * @param string $url The URL to sanitize
 * @return string The sanitized URL
 */
function escape_url($url) {
    if ($url === null) {
        return '';
    }
    return htmlspecialchars(filter_var($url, FILTER_SANITIZE_URL), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Validate and sanitize URL parameters - FIX for ZAP Alert #3
 * Prevents sensitive information disclosure in URLs
 * 
 * @param string $param_name The parameter name
 * @param mixed $default_value Default value if parameter is invalid
 * @param string $type Expected type (string, int, email, etc.)
 * @return mixed The sanitized parameter value
 */
function get_safe_param($param_name, $default_value = '', $type = 'string') {
    if (!isset($_GET[$param_name]) && !isset($_POST[$param_name])) {
        return $default_value;
    }
    
    $value = $_GET[$param_name] ?? $_POST[$param_name];
    
    switch ($type) {
        case 'int':
            return filter_var($value, FILTER_VALIDATE_INT) !== false ? (int)$value : $default_value;
            
        case 'email':
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false ? $value : $default_value;
            
        case 'url':
            return filter_var($value, FILTER_VALIDATE_URL) !== false ? $value : $default_value;
            
        case 'bool':
            return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default_value;
            
        case 'string':
        default:
            return is_string($value) ? sanitize_input($value) : $default_value;
    }
}

/**
 * Generate CSRF token
 * 
 * @return string The CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * 
 * @param string $token The token to validate
 * @return bool True if valid
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Output CSRF token as hidden input field
 */
function csrf_token_field() {
    $token = generate_csrf_token();
    echo '<input type="hidden" name="csrf_token" value="' . escape_attr($token) . '">';
}

/**
 * Require CSRF token validation for POST requests
 */
function require_csrf_token() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!validate_csrf_token($token)) {
            http_response_code(403);
            die('CSRF token validation failed');
        }
    }
}

/**
 * Sanitize filename to prevent directory traversal
 * 
 * @param string $filename The filename to sanitize
 * @return string The sanitized filename
 */
function sanitize_filename($filename) {
    // Remove any path components
    $filename = basename($filename);
    // Remove any non-alphanumeric characters except dots, dashes, and underscores
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    return $filename;
}

/**
 * Log security events with sanitized data
 * 
 * @param string $event_type The type of event
 * @param string $message The message to log
 * @param array $context Additional context
 */
function log_security_event_safe($event_type, $message, $context = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event_type' => $event_type,
        'message' => $message,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255),
        'context' => $context
    ];
    
    error_log(json_encode($log_entry));
}
?>