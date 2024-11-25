<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_ambiente = $_POST['edit_id_amb'];
    $nombre_ambiente = $_POST['edit_nomb_amb'];
    $descripcion = $_POST['edit_desc_amb'];
    $id_area = $_POST['edit_area_id'];


// Validar si el id_instructor existe
$areaExistente = "SELECT * FROM area WHERE id = '$id_area'";
$resultado = mysqli_query($conexion, $areaExistente);

if (mysqli_num_rows($resultado) > 0) {

    $updateQuery = "UPDATE ambiente SET nombre_ambiente='$nombre_ambiente', descripcion='$descripcion',  id_area='$id_area' WHERE id_ambiente='$id_ambiente'";

    if (mysqli_query($conexion, $updateQuery)) {
        $response['status'] = 'success';
        $response['title'] = 'Éxito';
        $response['message'] = 'Actualización de datos exitosa';
    } else {
        // Preparar la respuesta en caso de error de actualización
        $response['status'] = 'error';
        $response['title'] = 'Error';
        $response['message'] = 'Error al actualizar los datos: ' . mysqli_error($conexion);
    }
 } else {
        // Preparar la respuesta en caso de que el id_programa no exista
        $response['status'] = 'error';
        $response['title'] = 'Error';
        $response['message'] = 'No existen coincidencias en el area ';
        }
        
        // Enviar la respuesta como JSON al cliente
        echo json_encode($response);
        
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
        } else {
        // Preparar la respuesta en caso de que la solicitud no sea POST
        $response['status'] = 'error';
        $response['title'] = 'Error';
        $response['message'] = 'Acceso no válido';
        
        // Enviar la respuesta como JSON al cliente
        echo json_encode($response);
        }
