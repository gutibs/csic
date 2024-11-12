<?php
include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");

$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'nueva') {

    // Validate required fields
    $errors = [];
    if (empty($_POST['unidad_id'])) {
        $errors[] = "Unidad is required.";
    }
    if (empty($_POST['nombre_sala'])) {
        $errors[] = "Nombre de la Sala is required.";
    }
    if (empty($_POST['numero_sala'])) {
        $errors[] = "Número de Sala is required.";
    }
    if (empty($_POST['capacidad'])) {
        $errors[] = "Capacidad is required.";
    }
    if (empty($_POST['edificio_id'])) {
        $errors[] = "Edificio is required.";
    }

    // If there are errors, display them and exit
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        exit;
    }

    // Retrieve form data
    $unidad_id = $_POST['unidad_id'];
    $nombre_sala = $_POST['nombre_sala'];
    $numero_sala = $_POST['numero_sala'];
    $capacidad = $_POST['capacidad'];
    $edificio_id = $_POST['edificio_id'];
    $equipamiento = [
        'ordenador' => isset($_POST['ordenador']) ? 1 : 0,
        'videoconferencia' => isset($_POST['videoconferencia']) ? 1 : 0,
        'television' => isset($_POST['television']) ? 1 : 0,
        'proyector' => isset($_POST['proyector']) ? 1 : 0,
        'catering' => isset($_POST['catering']) ? 1 : 0,
    ];

    // Define the upload directory for images
    $uploadDir = '/../static/imagenes/salas/';



    // Handle file uploads
    $fileFields = ['imagen1', 'imagen2', 'imagen3', 'imagen4', 'imagen5', 'video', 'manual_uso', 'manual_encendido', 'manual_apagado'];
    $uploadedFiles = [];
    foreach ($fileFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($_FILES[$field]['name']);
            $fileTmpPath = $_FILES[$field]['tmp_name'];
            $uploadPath = $uploadDir . '/' . $fileName;
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $uploadedFiles[$field] = $fileName; // Store the file name in an array to save to the database
            } else {
                echo "no";
            }
        }
    }

    // Prepare and execute insert query
    $sql = "INSERT INTO salas (
                unidad_id, nombre_sala, numero_sala, capacidad, 
                ordenador, videoconferencia, television, proyector, catering, 
                imagen1, imagen2, imagen3, imagen4, imagen5, 
                video, manual_uso, manual_encendido, manual_apagado, 
                edificio_id
            ) VALUES (
                :unidad_id, :nombre_sala, :numero_sala, :capacidad, 
                :ordenador, :videoconferencia, :television, :proyector, :catering, 
                :imagen1, :imagen2, :imagen3, :imagen4, :imagen5, 
                :video, :manual_uso, :manual_encendido, :manual_apagado, 
                :edificio_id
            )";

    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':unidad_id', $unidad_id);
    $stmt->bindParam(':nombre_sala', $nombre_sala);
    $stmt->bindParam(':numero_sala', $numero_sala);
    $stmt->bindParam(':capacidad', $capacidad);
    $stmt->bindParam(':edificio_id', $edificio_id);
    foreach ($equipamiento as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    foreach ($fileFields as $field) {
        $stmt->bindValue(":$field", $uploadedFiles[$field] ?? null);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Sala created successfully!";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] === 'elimina') {
    $csic = new Csic();
    extract($_GET);

    $sql = "DELETE FROM salas WHERE id = $sala";
    $csic->do_this($sql);

    $sql = "DELETE FROM reservas WHERE sala = $sala";
    $csic->do_this($sql);

    header("location:../salas.php");

}
