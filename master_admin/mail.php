<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../config/config.php';
require '../vendor/autoload.php'; // Include PHPMailer via Composer

$mail = new PHPMailer(true);

try {
    // SMTP server configuration
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USERNAME; // Your Gmail address
    $mail->Password   = MAIL_PASSWORD;        // Your Gmail password or App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email sender and recipient
    $mail->setFrom(MAIL_SETFROM, 'Gustavo'); // From address and name
    $mail->addAddress('gutibs@icloud.com', 'Gustavo Benito Silva'); // To address and name

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email using PHPMailer and Gmail SMTP';
    $mail->Body    = '<h1>Hello!</h1><p>This is a test email sent using PHPMailer with Gmail SMTP.</p>';
    $mail->AltBody = 'This is a test email sent using PHPMailer with Gmail SMTP.';

    // Send email
    $mail->send();
    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo "Email could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
}
?>
