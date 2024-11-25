<?php
// Incluir el archivo de conexión
include ('../../PHP/Conexion.php');

// Verificar si se recibieron los datos necesarios
if (isset($_POST['id_elemento']) && isset($_POST['solicitada'])) {
    // Recibir los datos enviados desde la solicitud AJAX
    $id_elemento = $_POST['id_elemento'];
    $cantidad_solicitada = $_POST['solicitada'];

    // Preparar la consulta SQL para actualizar la cantidad solicitada
    $stmt = $conexion->prepare("UPDATE elemento SET cantidad_solicitada = ? WHERE id_elemento = ?");
    $stmt->bind_param("ii", $cantidad_solicitada, $id_elemento);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La actualización se realizó correctamente
        echo "La cantidad solicitada se actualizó correctamente.";
    } else {
        // Error al ejecutar la consulta
        echo "Error al actualizar la cantidad solicitada: " . $stmt->error;
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    // Datos insuficientes
    echo "Error: Datos insuficientes para actualizar la cantidad solicitada.";
}

// Cerrar la conexión
$conexion->close();
?>
