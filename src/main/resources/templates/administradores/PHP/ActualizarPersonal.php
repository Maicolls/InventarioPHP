
<?php

include('../../PHP/Conexion.php');

// Inicializar la respuesta por defecto
$response = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Ocurrió un error desconocido'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $cedula = $_POST['edit_ced_inst'];
    $nombre_instructor = $_POST['edit_nom_inst'];
    $celular = $_POST['edit_tele_inst'];
    $correo = $_POST['edit_corr_inst'];
    $contrasena = mysqli_real_escape_string($conexion, $_POST['edit_contra_inst']);
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);    
    $rol = $_POST['edit_rol_inst'];
    $especialidad = $_POST['edit_instru_espe'];
    $id = $_POST['id'];

    // Actualizar la fila correspondiente en la base de datos
    $updateQuery = "UPDATE instructor SET cedula='$cedula', nombre_instructor='$nombre_instructor', celular='$celular', correo='$correo',  contrasena='$contrasena_hash',  rol='$rol', especialidad='$especialidad' WHERE id='$id'";

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