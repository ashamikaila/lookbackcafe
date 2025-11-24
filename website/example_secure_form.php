<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
/**
 * Example Secure Form Implementation
 * This file demonstrates how to use all the new security features
 * 
 * OWASP ZAP Fixes Demonstrated:
 * - CSP headers (automatically applied)
 * - CSRF protection
 * - XSS prevention with output escaping
 * - Secure URL handling
 */

require_once 'config/db.php';
require_once 'config/security.php'; // Includes headers.php automatically
require_once 'config/url_helper.php';

// Configure secure session
configure_secure_session();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // STEP 1: Validate CSRF token (FIX for CSRF attacks)
    require_csrf_token();
    
    // STEP 2: Sanitize inputs (FIX for XSS - Alert #5)
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    // STEP 3: Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (!validate_email($email)) {
        $errors[] = 'Valid email is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // STEP 4: Process if no errors
    if (empty($errors)) {
        // Save to database (example)
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            // STEP 5: Redirect with flash message (FIX for Alert #3 - No sensitive data in URL)
            redirect_with_message(
                'example_secure_form.php',
                'Thank you! Your message has been sent successfully.',
                'success'
            );
        } else {
            redirect_with_message(
                'example_secure_form.php',
                'An error occurred. Please try again.',
                'error'
            );
        }
    } else {
        // Store errors in session
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: example_secure_form.php");
        exit();
    }
}

// Get flash message
$flash = get_flash_message();

// Get form errors and data
$errors = $_SESSION['form_errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_data']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Form Example - Look Back Café</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }
        
        .error-list {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .security-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .security-info h3 {
            margin-top: 0;
        }
        
        .security-info ul {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h1>Secure Form Example</h1>
    
    <div class="security-info">
        <h3>🔒 Security Features Demonstrated:</h3>
        <ul>
            <li>✅ Content Security Policy (CSP) headers with form-action and frame-ancestors</li>
            <li>✅ CSRF token protection</li>
            <li>✅ XSS prevention with output escaping</li>
            <li>✅ Secure URL handling (no sensitive data in URLs)</li>
            <li>✅ Input validation and sanitization</li>
            <li>✅ Flash messages for user feedback</li>
        </ul>
    </div>
    
    <?php if ($flash): ?>
        <!-- FIX for Alert #5: Properly escaped output -->
        <div class="alert alert-<?php echo escape_attr($flash['type']); ?>">
            <?php echo escape_html($flash['message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error-list">
            <strong>Please correct the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <!-- FIX for Alert #5: Escaped error messages -->
                    <li><?php echo escape_html($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- FIX for Alert #1: Form action uses 'self' (allowed by CSP form-action directive) -->
    <form method="POST" action="example_secure_form.php">
        <!-- FIX for CSRF: Token field added -->
        <?php csrf_token_field(); ?>
        
        <div class="form-group">
            <label for="name">Name:</label>
            <!-- FIX for Alert #5: Escaped attribute value -->
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="<?php echo escape_attr($formData['name'] ?? ''); ?>"
                required
            >
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <!-- FIX for Alert #5: Escaped attribute value -->
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="<?php echo escape_attr($formData['email'] ?? ''); ?>"
                required
            >
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <!-- FIX for Alert #5: Escaped textarea content -->
            <textarea 
                id="message" 
                name="message" 
                required
            ><?php echo escape_html($formData['message'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit">Send Message</button>
    </form>
    
    <hr style="margin: 30px 0;">
    
    <h2>How This Form is Secured:</h2>
    
    <h3>1. CSRF Protection</h3>
    <p>The form includes a CSRF token that is validated on submission. Try viewing the page source to see the hidden token field.</p>
    
    <h3>2. Input Sanitization</h3>
    <p>All user inputs are sanitized using <code>sanitize_input()</code> to prevent XSS attacks.</p>
    
    <h3>3. Output Escaping</h3>
    <p>All output uses context-aware escaping:</p>
    <ul>
        <li><code>escape_html()</code> for HTML content</li>
        <li><code>escape_attr()</code> for HTML attributes</li>
    </ul>
    
    <h3>4. Secure Redirects</h3>
    <p>Instead of passing sensitive data in URLs, we use flash messages stored in the session.</p>
    
    <h3>5. Security Headers</h3>
    <p>Open your browser's Developer Tools → Network tab → Select this page → Check Response Headers to see:</p>
    <ul>
        <li>Content-Security-Policy (with form-action and frame-ancestors)</li>
        <li>X-Frame-Options</li>
        <li>X-XSS-Protection</li>
        <li>X-Content-Type-Options</li>
        <li>Referrer-Policy</li>
    </ul>
    
    <p><a href="main.php">← Back to Main Page</a></p>
</body>
</html>