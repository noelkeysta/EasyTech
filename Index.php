<?php
session_start();

// CSRF Protection
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }
}
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Rate Limiting
$ipAddress = $_SERVER['REMOTE_ADDR'];
$limit = 100; // Max requests per hour
$timeFrame = 3600; // 1 hour
$requests = apcu_fetch($ipAddress);

if ($requests === false) {
    apcu_store($ipAddress, 1, $timeFrame);
} elseif ($requests < $limit) {
    apcu_inc($ipAddress);
} else {
    die('Rate limit exceeded. Please try again later.');
}

// Secure Email Handling
if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format');
    }

    $to = 'recipient@example.com'; // Change to your recipient
    $subject = 'Subject'; // Change as needed
    $message = 'Message'; // Your message

    // Prevent email header injection
    if (preg_match('/[\r\n]/', $email)) {
        die('Headers not allowed');
    }

    $headers = "From: sender@example.com\r\n";

    mail($to, $subject, $message, $headers);
}

// Improved Form Handling
if (isset($_POST['submit'])) {
    // Form processing logic here
}
?>