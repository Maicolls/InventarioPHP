<?php

include('../../PHP/Conexion.php');

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $numero_ficha = $_POST['edit_num_fich'];
    $id_programa = $_POST['edit_id_prog'];

    // Validar si el id_programa existe en la tabla programa
    $idExistente = "SELECT * FROM programa WHERE id_programa = '$id_programa'";
    $resultado = mysqli_query($conexion, $idExistente);

    if (mysqli_num_rows($resultado) > 0) {

        // Actualizar la tabla ficha con el nuevo id_programa
        $updateQuery = "UPDATE ficha SET id_programa='$id_programa' WHERE numero_ficha='$numero_ficha'";
        if (mysqli_query($conexion, $updateQuery)) {
            // Preparar la respuesta en caso de éxito
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
        $response['message'] = 'No existen coincidencias en el id del programa';
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
?>
