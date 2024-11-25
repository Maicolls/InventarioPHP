<?php
include('../../PHP/Conexion.php');

// Inicializar la respuesta por defecto
$response = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Ocurrió un error desconocido'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_programa = $_POST['reg_prog_nomb'];
    $id = $_POST['reg_nom_inst'];

    // Validar que el nombre del programa sea único
    $nombreProgramaExistente = "SELECT * FROM programa WHERE nombre_programa = '$nombre_programa'";
    $resultado = mysqli_query($conexion, $nombreProgramaExistente);
    if (mysqli_num_rows($resultado) > 0) {
        $response['message'] = 'El nombre del programa ya existe';
        echo json_encode($response);
        exit();
    }

    // Validar que el id_instructor exista
    $instructorExistente = "SELECT * FROM instructor WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $instructorExistente);
    if (mysqli_num_rows($resultado) == 0) {
        $response['message'] = 'El ID del instructor no existe';
        echo json_encode($response);
        exit();
    }

    $consulta = "INSERT INTO programa (nombre_programa, id_INSTRUCTOR) VALUES ('$nombre_programa', '$id')";

    if (mysqli_query($conexion, $consulta)) {
        $response['status'] = 'success';
        $response['title'] = 'Éxito';
        $response['message'] = 'Programa registrado exitosamente';
        echo json_encode($response);
        exit();
    } else {
        $response['message'] = 'Error al registrar el programa: ' . mysqli_error($conexion);
        echo json_encode($response);
        exit();
    }

    mysqli_close($conexion);
}
?>
