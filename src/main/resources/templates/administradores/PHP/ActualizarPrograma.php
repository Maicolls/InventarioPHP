<?php
include('../../PHP/Conexion.php');

// Inicializar la respuesta por defecto
$response = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Ocurrió un error desconocido'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_programa = $_POST['edit_id_prog'];
    $nombre_programa = $_POST['edit_nomb_prog'];
    $id_instructor = $_POST['edit_id_inst'];

    // Validar si el id_instructor existe
    $instructorExistente = "SELECT * FROM instructor WHERE id = '$id_instructor'";
    $resultado = mysqli_query($conexion, $instructorExistente);

    if (mysqli_num_rows($resultado) > 0) {
        $updateQuery = "UPDATE programa SET nombre_programa='$nombre_programa', id_instructor='$id_instructor' WHERE id_programa='$id_programa'";

        if (mysqli_query($conexion, $updateQuery)) {
            $response['status'] = 'success';
            $response['title'] = 'Éxito';
            $response['message'] = 'Actualización de datos exitosa';
        } else {
            $response['message'] = 'Error al actualizar los datos: ' . mysqli_error($conexion);
        }
    } else {
        $response['message'] = 'No existen coincidencias en el ID del instructor';
    }

    mysqli_close($conexion);
} else {
    $response['message'] = 'Acceso no válido';
}

echo json_encode($response);
?>
