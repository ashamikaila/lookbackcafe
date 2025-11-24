<?php
/**
 * Mailtrap SMTP Configuration
 * 
 * Instructions:
 * 1. Go to https://mailtrap.io/
 * 2. Login to your account
 * 3. Go to Email Testing > Inboxes
 * 4. Select your inbox
 * 5. Go to SMTP Settings
 * 6. Copy the credentials and paste them below
 */

// Mailtrap SMTP Credentials
// Replace these with your actual Mailtrap credentials
return [
    'host' => 'sandbox.smtp.mailtrap.io',
    'port' => 2525,
    'username' => '641b2167abba6b', // YOUR MAILTRAP USERNAME HERE
    'password' => '326fbd908b2c37', // YOUR MAILTRAP PASSWORD HERE
    'from_email' => 'noreply@lookbackcafe.com',
    'from_name' => 'Look Back Café'
];