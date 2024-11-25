<?php
include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_maquina = $_POST['edit_seri_maqu'];
    $nombre_maquina = $_POST['edit_nomb_maqu'];
    $marca = $_POST['edit_marc_maqu'];
    $modelo = $_POST['edit_model_maqu'];
    $placa = $_POST['edit_plac_maqu'];
    $adquisicion = $_POST['edit_adqu_maqu'];
    $cantidad = $_POST['edit_cant_maqu'];
    $id_ambiente = $_POST['edit_id_maqu'];

    // Construir la consulta SQL
    $updateQuery = "UPDATE maquina SET nombre_maquina='$nombre_maquina', marca='$marca', modelo='$modelo', placa='$placa', adquisicion='$adquisicion', cantidad='$cantidad', id_ambiente='$id_ambiente' WHERE serial='$id_maquina'";

    // Ejecutar la consulta de actualización
    if (mysqli_query($conexion, $updateQuery)) {
        $response['status'] = 'success';
        $response['title'] = 'Éxito';
        $response['message'] = 'Actualización de datos exitosa';
    } else {
        $response['status'] = 'error';
        $response['title'] = 'Error';
        $response['message'] = 'Error al actualizar los datos: ' . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    $response['status'] = 'error';
    $response['title'] = 'Error';
    $response['message'] = 'Acceso no válido';
}

echo json_encode($response);
?>