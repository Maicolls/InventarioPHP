<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_programa = $_POST['id_programa'];

    $deleteQuery = "DELETE FROM programa WHERE id_programa='$id_programa'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Programa eliminado";
    } else {
        echo "Error al eliminar el programa: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}
