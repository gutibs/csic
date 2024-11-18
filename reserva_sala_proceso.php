<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config/config.php';
include("clases/clase_csic.php");
$csic = new Csic();

header('Content-Type: application/json'); // Ensure JSON response


$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $response['message'] = 'CSRF token inválido.';
        echo json_encode($response);
        exit;
    }

    // Validate inputs
    $sala_id = isset($_POST['sala']) ? intval($_POST['sala']) : 0;
    $fecha_deseada = isset($_POST['nombre_sala']) ? trim($_POST['nombre_sala']) : '';
    $numero_participantes = isset($_POST['numero_participantes']) ? intval($_POST['numero_participantes']) : 0;
    $comentarios = isset($_POST['comentarios']) ? trim($_POST['comentarios']) : '';
    $reservante_id = isset($_SESSION['id']) ? trim($_SESSION['id']) : '';

    if ($sala_id <= 0) {
        $response['message'] = 'ID de sala inválido.';
        echo json_encode($response);
        exit;
    }

    if (empty($fecha_deseada) || !preg_match('/^\d{2}-\d{2}-\d{4} \- \d{2}-\d{2}-\d{4}$/', $fecha_deseada)) {
        $response['message'] = 'Fecha deseada no válida.';
        echo json_encode($response);
        exit;
    }

    // 18-11-2024 - 18-11-2024
    $f = explode(" - ", $fecha_deseada);
    $f1 = trim($f[0]);
    $f2 = trim($f[1]);
    $f1e = explode('-', $f1);
    $fecha_inicio = $f1e[2] . '-' . $f1e[1] . '-' . $f1e[0];
    $f2e = explode('-', $f2);
    $fecha_fin = $f2e[2] . '-' . $f2e[1] . '-' . $f2e[0];

    if ($numero_participantes <= 0) {
        $response['message'] = 'El número de participantes debe ser mayor que 0.';
        echo json_encode($response);
        exit;
    }

    if (strlen($comentarios) > 500) {
        $response['message'] = 'Comentarios demasiado largos.';
        echo json_encode($response);
        exit;
    }
    if ($reservante_id === '') {
        $response['message'] = 'Hubo un error, debe iniciar sesion nuevamente.';
        echo json_encode($response);
        exit;
    }


    // Insert into the database
    try {
        $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO solicitud_reservas (sala_id, 
                                                                     reservante_id, 
                                                                     fecha_inicio, 
                                                                     fecha_fin, 
                                                                     numero_participantes, 
                                                                     comentarios, 
                                                                     estado) 
                                            VALUES (:sala_id, 
                                                    :reservante_id, 
                                                    :fecha_inicio, 
                                                    :fecha_fin,
                                                    :numero_participantes, 
                                                    :comentarios,
                                                    1)");
        $stmt->execute([
            ':sala_id' => $sala_id,
            ':reservante_id' => $reservante_id,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin,
            ':numero_participantes' => $numero_participantes,
            ':comentarios' => $comentarios
        ]);

        $response['success'] = true;
        $response['message'] = 'Solicitud enviada exitosamente.';


        // mando mail al usuario de confirmacion de la solicitud de reserva
        $_SESSION['apellido'] = '';

        $email = $_SESSION['email'];
        $nombre = $_SESSION['nombre'];
        $apellidos = $_SESSION['apellido'];


        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;  // Specify SMTP server
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable encryption
            $mail->Port = 587;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            // Recipients
            $mail->setFrom(MAIL_SETFROM, MAIL_NOMBRE);
            $mail->addAddress($email, $nombre . ' ' . $apellidos);
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Solicitud de reserva recibida';
            $mail->Body = "
            <p>Hola $nombre,</p>
            <p>Hemos recibido su solicitud de reserva en la central de reserva de salas del CSIC</p>
            <p>Su pedido est&aacute; siendo revisado por el administrador, el cual se pondr&aacute; en contacto con usted a la brevedad.</p>
            <p>Muchas gracias.</p>";

            // Send email
            $mail->send();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
        }


    } catch (PDOException $e) {
        $response['message'] = 'Error al guardar la solicitud: ' . $e->getMessage();
    }
}

echo json_encode($response);


