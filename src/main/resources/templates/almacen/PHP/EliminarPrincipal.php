<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];

    $deleteQuery = "DELETE FROM elemento WHERE codigo='$codigo'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "elemento eliminado correctamente";
    } else {
        echo "Error al eliminar el elemento: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}
