<?php
// Incluye el archivo de conexión a la base de datos
include (__DIR__ . '/../../PHP/Conexion.php');

// Verifica si la conexión tiene errores
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verifica si las variables POST necesarias están establecidas
if (isset($_POST['solicitudId']) && isset($_POST['cantidad']) && isset($_POST['cantidadE'])) {
    $solicitudId = $_POST['solicitudId'];
    $cantidadActual = $_POST['cantidad'];
    $cantidadEntregada = $_POST['cantidadE'];

    // Calcula la nueva cantidad restando la cantidad entregada de la cantidad actual
    $nuevaCantidad = $cantidadActual - $cantidadEntregada;

    // Mensajes de depuración
    error_log("Cantidad actual: $cantidadActual");
    error_log("Cantidad entregada: $cantidadEntregada");
    error_log("Nueva cantidad: $nuevaCantidad");

    // Prepara la consulta SQL para actualizar la base de datos
    $query = "UPDATE elemento e
              INNER JOIN elementos_solicitud_periodica esp ON e.id_elemento = esp.id_elemento
              SET e.cantidad = ?,
                  e.cantidad_entregada = COALESCE(e.cantidad_entregada, 0) + ?
              WHERE esp.id_solicitud = ? AND esp.id_elemento = e.id_elemento";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincula los parámetros a la consulta
        $stmt->bind_param("iii", $nuevaCantidad, $cantidadEntregada, $solicitudId);
        if (!$stmt->execute()) {
            // Maneja los errores de ejecución
            error_log("Error al actualizar la cantidad: " . $stmt->error);
            echo "Error al actualizar la cantidad: " . $stmt->error;
        } else {
            // Mensaje de éxito
            error_log("Cantidad actualizada correctamente para solicitud $solicitudId");
            header('Location:../Subir/ReportesExcel.php?solicitudId=' . $solicitudId);
        }
        // Cierra la declaración preparada
        $stmt->close();
    } else {
        // Maneja los errores de preparación de la consulta
        error_log("Error en la preparación de la consulta: " . $conexion->error);
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    // Maneja el caso de datos POST inválidos
    error_log("Datos inválidos.");
    echo "Datos inválidos.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
