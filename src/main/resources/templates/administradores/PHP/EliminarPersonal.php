<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM instructor WHERE id='$id'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Usuario eliminado exitosamente";
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}