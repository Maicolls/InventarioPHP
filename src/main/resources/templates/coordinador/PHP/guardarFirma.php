<?php
// guardarFirma.php

// Conectar a la base de datos
include (__DIR__ . '/../../PHP/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si se proporcionó el ID de la solicitud
if (isset($_POST['solicitudId'])) {
    $solicitudId = $_POST['solicitudId'];

    // Verificar si se subió un archivo de firma
    if (isset($_FILES['firma']) && $_FILES['firma']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['firma']['tmp_name'];
        $fileType = $_FILES['firma']['type'];

        // Leer el contenido del archivo y codificarlo en base64
        $imageData = file_get_contents($fileTmpPath);
        $imageBase64 = base64_encode($imageData);

        $query = "UPDATE solicitud_periodica SET firma = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param("si", $imageData, $solicitudId);
            $stmt->execute();
            echo json_encode(['success' => 'Firma subida y guardada correctamente.']);
        } else {
            echo json_encode(['error' => 'Error en la preparación de la consulta.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'No se subió ningún archivo o hubo un error al subirlo.']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó el ID de la solicitud.']);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
