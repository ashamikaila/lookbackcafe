<?php
/**
 * Security Initialization
 * This file MUST be included at the very beginning of every PHP page
 * It sets all security headers to fix OWASP ZAP alerts
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include security configuration
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/headers.php';
require_once __DIR__ . '/../config/url_helper.php';

// Set all security headers immediately
set_security_headers();
?>