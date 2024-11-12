<?php
// Assuming a database connection is already established
require '../../config/config.php';
require '../../clases/clase_csic.php';
$csic = new Csic();


try {
    $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sala_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $unidad_id = filter_input(INPUT_POST, 'unidad_id', FILTER_VALIDATE_INT);
    $nombre_sala = filter_input(INPUT_POST, 'nombre_sala', FILTER_SANITIZE_STRING);
    $numero_sala = filter_input(INPUT_POST, 'numero_sala', FILTER_VALIDATE_INT);
    $capacidad = filter_input(INPUT_POST, 'capacidad', FILTER_VALIDATE_INT);
    $ordenador = filter_input(INPUT_POST, 'ordenador', FILTER_VALIDATE_INT);
    $videoconferencia = filter_input(INPUT_POST, 'videoconferencia', FILTER_VALIDATE_INT);
    $television = filter_input(INPUT_POST, 'television', FILTER_VALIDATE_INT);
    $proyector = filter_input(INPUT_POST, 'proyector', FILTER_VALIDATE_INT);
    $catering = filter_input(INPUT_POST, 'catering', FILTER_VALIDATE_INT);
    $incidencia = filter_input(INPUT_POST, 'incidencia', FILTER_SANITIZE_STRING);
    $tipo_incidencia = filter_input(INPUT_POST, 'tipo_incidencia', FILTER_SANITIZE_STRING);
    $edificio_id = filter_input(INPUT_POST, 'edificio_id', FILTER_VALIDATE_INT);

    $stmt = $db->prepare("
        UPDATE salas SET
            unidad_id = :unidad_id,
            nombre_sala = :nombre_sala,
            numero_sala = :numero_sala,
            capacidad = :capacidad,
            ordenador = :ordenador,
            videoconferencia = :videoconferencia,
            television = :television,
            proyector = :proyector,
            catering = :catering,
            incidencia = :incidencia,
            tipo_incidencia = :tipo_incidencia,
            edificio_id = :edificio_id
        WHERE id = :id
    ");

    // Bind parameters to statement
    $stmt->bindParam(':unidad_id', $unidad_id, PDO::PARAM_INT);
    $stmt->bindParam(':nombre_sala', $nombre_sala, PDO::PARAM_STR);
    $stmt->bindParam(':numero_sala', $numero_sala, PDO::PARAM_INT);
    $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
    $stmt->bindParam(':ordenador', $ordenador, PDO::PARAM_INT);
    $stmt->bindParam(':videoconferencia', $videoconferencia, PDO::PARAM_INT);
    $stmt->bindParam(':television', $television, PDO::PARAM_INT);
    $stmt->bindParam(':proyector', $proyector, PDO::PARAM_INT);
    $stmt->bindParam(':catering', $catering, PDO::PARAM_INT);
    $stmt->bindParam(':incidencia', $incidencia, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_incidencia', $tipo_incidencia, PDO::PARAM_STR);
    $stmt->bindParam(':edificio_id', $edificio_id, PDO::PARAM_INT);
    $stmt->bindParam(':id', $sala_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update record.";
    }

    $uploadDir = '../../static/imagenes/salas/';

    foreach($_FILES as $cual => $FILE){

        if ($FILE['size'] !== 0) {
            // existe el archivo, tengo que borrar el anterior primero y luego reemplazo
            $sql = "SELECT {$cual} from salas WHERE id = $sala_id";
            $av = $csic->get_this_1($sql);
            if(!is_null($av->{$cual})) {
                $filePath = $uploadDir.$av->{$cual};
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $fileTmpPath = $_FILES[$cual]['tmp_name'];
            $fileName = $_FILES[$cual]['name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid($cual."_sala_" . $sala_id . "_") . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $sql = "UPDATE salas SET $cual = '{$newFileName}' WHERE id = $sala_id";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
        }
    }
}

header("location:../salas.php");
