<?php
include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $solicitudId = $_POST['solicitudId'];

    // Validar que el ID no esté vacío
    if (!empty($solicitudId)) {
        $deleteQuery = "DELETE FROM solicitud_periodica WHERE id='$solicitudId'";

        if (mysqli_query($conexion, $deleteQuery)) {
            echo "Solicitud eliminada exitosamente";
        } else {
            echo "Error al eliminar la solicitud: " . mysqli_error($conexion);
        }
    } else {
        echo "ID de solicitud no válido.";
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}
?>
