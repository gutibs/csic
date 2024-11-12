<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");
require '../../vendor/autoload.php';

$csic = new Csic();
$csic->storeFormValues($_POST);
$nuevo =$csic->nuevo_usuario();

extract($_POST);
$url = CARPETA_VALIDACION."validacion.php?token=".$nuevo;
$texto = "Bienvenido al sistema de reservas del CSIC, por favor, confirme su direccion de correo haciendo click <a href='$url'>aqui</a>";

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
    $mail->setFrom(MAIL_SETFROM, 'Sistema de Gestión de reservas del CSIC'); // From address and name
    $mail->addAddress($email, $nombre." ".$apellido); // To address and name

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Confirme su correo en el sistema de reservas del CSIC';
    $mail->Body    = $texto;
    $mail->AltBody = $texto;

    // Send email
    $mail->send();
    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo "Email could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
}



header("location:../usuarios.php");