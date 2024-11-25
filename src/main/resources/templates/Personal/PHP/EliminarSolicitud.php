<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM solicitud_periodica WHERE id='$id'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Solicitud eliminada exitosamente";
    } else {
        echo "Error al eliminar el solicitud: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}