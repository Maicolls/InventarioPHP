<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_ficha = $_POST['numero_ficha'];

    $deleteQuery = "DELETE FROM ficha WHERE numero_ficha='$numero_ficha'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Ficha eliminada exitosamente";
    } else {
        echo "Error al eliminar la ficha: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}
