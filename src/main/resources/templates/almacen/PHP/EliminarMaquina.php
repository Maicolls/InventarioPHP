<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_maquina = $_POST['id_maquina'];

    $deleteQuery = "DELETE FROM maquina WHERE serial='$id_maquina'";

    if (mysqli_query($conexion, $deleteQuery)) {
        echo "Máquina eliminada";
    } else {
        echo "Error al eliminar la máquina: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "Acceso no válido.";
}

