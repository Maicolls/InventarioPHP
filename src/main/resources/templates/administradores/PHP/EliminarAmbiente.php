<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_ambiente = $_POST['id_ambiente'];

    $deleteQuery = "DELETE FROM ambiente WHERE id_ambiente='$id_ambiente'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Ambiente eliminado exitosamente";
    } else {
        echo "Error al eliminar el ambiente: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}