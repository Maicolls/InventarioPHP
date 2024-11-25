<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_inventario = $_POST['edit_cod_inve'];
    $nombre_elemento = $_POST['edit_nomb_inve'];
    $descripcion_elemento = $_POST['edit_desc_inve'];
    $cantidad_almacen = $_POST['edit_canti_inve'];
    $und_medida = $_POST['edit_medi_inve'];
    $estado = $_POST['edit_esta_inve'];

    $updateQuery = "UPDATE elemento SET nombre='$nombre_elemento', descripcion='$descripcion_elemento', cantidad='$cantidad_almacen', und_medida='$und_medida', estado='$estado' WHERE codigo='$id_inventario'";

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