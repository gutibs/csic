<?php
include("../../config/config.php");

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

    $capacidad = ($capacidad === "") ? 0 : $capacidad;


    $edificio_id = $_POST['edificio_id'];
    $anillo_magnetico = $_POST['anillo_magnetico'];
    $equipamiento = [
        'ordenador' => isset($_POST['ordenador']) ? 1 : 0,
        'videoconferencia' => isset($_POST['videoconferencia']) ? 1 : 0,
        'television' => isset($_POST['television']) ? 1 : 0,
        'proyector' => isset($_POST['proyector']) ? 1 : 0,
        'catering' => isset($_POST['catering']) ? 1 : 0,
    ];



    // Prepare and execute insert query
    $sql = "INSERT INTO salas (
                unidad_id, nombre_sala, numero_sala, capacidad, 
                ordenador, videoconferencia, television, proyector, catering, anillo_magnetico,
                edificio_id
            ) VALUES (
                :unidad_id, :nombre_sala, :numero_sala, :capacidad, 
                :ordenador, :videoconferencia, :television, :proyector, :catering, :anillo_magnetico, 
                :edificio_id
            )";

    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':unidad_id', $unidad_id);
    $stmt->bindParam(':nombre_sala', $nombre_sala);
    $stmt->bindParam(':numero_sala', $numero_sala);
    $stmt->bindParam(':capacidad', $capacidad);
    $stmt->bindParam(':edificio_id', $edificio_id);
    $stmt->bindParam(':anillo_magnetico', $anillo_magnetico  );

    foreach ($equipamiento as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    // Execute the statement
    if ($stmt->execute()) {
        $sala_id = $pdo->lastInsertId();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    $uploadDir = '../../static/imagenes/salas/';



    // Handle file uploads
    $fileFields = ['imagen1', 'imagen2', 'imagen3', 'imagen4', 'imagen5', 'video', 'manual_uso', 'manual_encendido', 'manual_apagado'];
    $uploadedFiles = [];
    foreach ($fileFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$field]['tmp_name'];
            $fileName = $_FILES[$field]['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid($field."_sala_" . $sala_id . "_") . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $sql = "UPDATE salas SET $field = '{$newFileName}' WHERE id = $sala_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

            }
        }
    }

    header("location:../salas.php");

}
