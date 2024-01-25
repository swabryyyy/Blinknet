<?php

// Retrieve form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

// Validate input
if (empty($name) || empty($email) || empty($message)) {
    header('Location: contact.php?error=emptyfields');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.php?error=invalidemail');
    exit;
}

// Sanitize input to prevent XSS attacks
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$message = htmlspecialchars($message);

// Set email headers
$to = 'swabri1190@icloud.com';
$subject = 'New message from website contact form';
$headers = 'From: ' . $email . "\r\n" .
           'Reply-To: ' . $email . "\r\n" .
           'Content-Type: text/plain; charset=UTF-8';

// Compose email body
$body = "You have received a new message from your website contact form:\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Message:\n$message";

// Send email
if (mail($to, $subject, $body, $headers)) {
    header('Location: contact.php?success=messagesent');
    exit;
} else {
    // Logging or further error handling here
    error_log("Failed to send email: " . $mail->ErrorInfo);
    header('Location: contact.php?error=emailfailed');
    exit;
}

?>
