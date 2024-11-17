<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'config/config.php';
require 'vendor/autoload.php';


// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Enable verbose debug output
    $mail->SMTPDebug = 2; // Debug level: 0 = off, 1 = client messages, 2 = client and server messages
    $mail->isSMTP();      // Set mailer to use SMTP
    $mail->Host = MAIL_HOST;  // Specify SMTP server
    $mail->SMTPAuth = true;           // Enable SMTP authentication
    $mail->Username = MAIL_USERNAME;
    $mail->Password = MAIL_PASSWORD;
    $mail->SMTPSecure = 'tls';        // Enable TLS encryption ('ssl' also available)
    $mail->Port = 587;                // TCP port to connect to

    // Recipients
    $mail->setFrom(MAIL_SETFROM, MAIL_NOMBRE);
    $mail->addAddress('gutibs@gmail.com', 'Gustavo Benito Silva'); // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = '<p>This is the <b>HTML</b> message body</p>';
    $mail->AltBody = 'This is the plain text body for non-HTML mail clients';

    // Send email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
