<?php
/**
 * URL Helper Functions
 * Fixes OWASP ZAP Alert #3: Information Disclosure - Sensitive Information in URL
 * 
 * This file provides functions to handle sensitive data without exposing it in URLs
 */

/**
 * Store sensitive data in session instead of URL
 * 
 * @param string $key The key to store data under
 * @param mixed $value The value to store
 */
function store_in_session($key, $value) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['temp_data'][$key] = $value;
}

/**
 * Retrieve sensitive data from session
 * 
 * @param string $key The key to retrieve
 * @param bool $delete Whether to delete after retrieving
 * @return mixed The stored value or null
 */
function get_from_session($key, $delete = true) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $value = $_SESSION['temp_data'][$key] ?? null;
    
    if ($delete && $value !== null) {
        unset($_SESSION['temp_data'][$key]);
    }
    
    return $value;
}

/**
 * Generate a secure token for URL parameters instead of exposing sensitive data
 * 
 * @param mixed $sensitive_data The sensitive data to tokenize
 * @return string A secure token
 */
function tokenize_data($sensitive_data) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $token = bin2hex(random_bytes(16));
    $_SESSION['tokenized_data'][$token] = [
        'data' => $sensitive_data,
        'expires' => time() + 300 // 5 minutes
    ];
    
    // Clean up expired tokens
    cleanup_expired_tokens();
    
    return $token;
}

/**
 * Retrieve data from token
 * 
 * @param string $token The token to retrieve data for
 * @param bool $delete Whether to delete after retrieving
 * @return mixed The original data or null
 */
function detokenize_data($token, $delete = true) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['tokenized_data'][$token])) {
        return null;
    }
    
    $token_data = $_SESSION['tokenized_data'][$token];
    
    // Check if expired
    if ($token_data['expires'] < time()) {
        unset($_SESSION['tokenized_data'][$token]);
        return null;
    }
    
    $data = $token_data['data'];
    
    if ($delete) {
        unset($_SESSION['tokenized_data'][$token]);
    }
    
    return $data;
}

/**
 * Clean up expired tokens from session
 */
function cleanup_expired_tokens() {
    if (!isset($_SESSION['tokenized_data'])) {
        return;
    }
    
    $current_time = time();
    foreach ($_SESSION['tokenized_data'] as $token => $data) {
        if ($data['expires'] < $current_time) {
            unset($_SESSION['tokenized_data'][$token]);
        }
    }
}

/**
 * Build a safe redirect URL without exposing sensitive parameters
 * 
 * @param string $base_url The base URL
 * @param array $params Parameters to include (non-sensitive only)
 * @param array $sensitive_params Sensitive parameters to tokenize
 * @return string The safe URL
 */
function build_safe_url($base_url, $params = [], $sensitive_params = []) {
    $url = $base_url;
    
    // Add regular parameters
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    // Tokenize sensitive parameters
    if (!empty($sensitive_params)) {
        $token = tokenize_data($sensitive_params);
        $url .= (strpos($url, '?') === false ? '?' : '&') . 'token=' . urlencode($token);
    }
    
    return $url;
}

/**
 * Redirect with message stored in session instead of URL
 * 
 * @param string $url The URL to redirect to
 * @param string $message The message to display
 * @param string $type The message type (success, error, info, warning)
 */
function redirect_with_message($url, $message, $type = 'info') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
    
    header("Location: $url");
    exit();
}

/**
 * Get and clear flash message from session
 * 
 * @return array|null The flash message array or null
 */
function get_flash_message() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['flash_message'])) {
        return null;
    }
    
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
    
    return $message;
}

/**
 * Obfuscate sensitive data for logging/display
 * 
 * @param string $data The data to obfuscate
 * @param int $visible_chars Number of characters to keep visible
 * @return string The obfuscated data
 */
function obfuscate_sensitive($data, $visible_chars = 3) {
    if (strlen($data) <= $visible_chars) {
        return str_repeat('*', strlen($data));
    }
    
    return substr($data, 0, $visible_chars) . str_repeat('*', strlen($data) - $visible_chars);
}

/**
 * Check if a parameter name is considered sensitive
 * 
 * @param string $param_name The parameter name
 * @return bool True if sensitive
 */
function is_sensitive_param($param_name) {
    $sensitive_patterns = [
        'password',
        'passwd',
        'pwd',
        'secret',
        'token',
        'key',
        'api',
        'auth',
        'session',
        'cookie',
        'user',
        'username',
        'email',
        'ssn',
        'credit',
        'card',
        'cvv',
        'pin'
    ];
    
    $param_lower = strtolower($param_name);
    
    foreach ($sensitive_patterns as $pattern) {
        if (strpos($param_lower, $pattern) !== false) {
            return true;
        }
    }
    
    return false;
}

/**
 * Sanitize URL parameters and remove sensitive ones
 * Use this to clean URLs before logging or displaying
 * 
 * @param string $url The URL to sanitize
 * @return string The sanitized URL
 */
function sanitize_url_for_logging($url) {
    $parsed = parse_url($url);
    
    if (!isset($parsed['query'])) {
        return $url;
    }
    
    parse_str($parsed['query'], $params);
    $safe_params = [];
    
    foreach ($params as $key => $value) {
        if (!is_sensitive_param($key)) {
            $safe_params[$key] = $value;
        } else {
            $safe_params[$key] = '[REDACTED]';
        }
    }
    
    $safe_query = http_build_query($safe_params);
    $parsed['query'] = $safe_query;
    
    return build_url_from_parts($parsed);
}

/**
 * Build URL from parsed components
 * 
 * @param array $parts Parsed URL parts
 * @return string The reconstructed URL
 */
function build_url_from_parts($parts) {
    $url = '';
    
    if (isset($parts['scheme'])) {
        $url .= $parts['scheme'] . '://';
    }
    
    if (isset($parts['user'])) {
        $url .= $parts['user'];
        if (isset($parts['pass'])) {
            $url .= ':' . $parts['pass'];
        }
        $url .= '@';
    }
    
    if (isset($parts['host'])) {
        $url .= $parts['host'];
    }
    
    if (isset($parts['port'])) {
        $url .= ':' . $parts['port'];
    }
    
    if (isset($parts['path'])) {
        $url .= $parts['path'];
    }
    
    if (isset($parts['query'])) {
        $url .= '?' . $parts['query'];
    }
    
    if (isset($parts['fragment'])) {
        $url .= '#' . $parts['fragment'];
    }
    
    return $url;
}
?>