<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];

    $deleteQuery = "DELETE FROM usuario WHERE id_usuario='$id_usuario'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Eliminación de usuario exitosa";
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}
