<?php
include('../../PHP/Conexion.php');
// Inicializar la respuesta por defecto
$response = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Ocurrió un error desconocido'
);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_ambiente = $_POST['reg_ambi_nomb'];
    $descripcion = $_POST['reg_ambi_desc'];
    $id_area = $_POST['reg_nom_area'];

    // Validar que el id_ambiente sea unico
    $idExistente = "SELECT id_ambiente FROM ambiente WHERE nombre_ambiente = '$nombre_ambiente'";
    $resultado = mysqli_query($conexion, $idExistente);
    if (mysqli_num_rows($resultado) > 0) {
        $response['message'] = 'El ambiente ya existe';
        echo json_encode($response);
        exit();
    }

    // Validar que el id_area exista
    $areaExistente = "SELECT * FROM area WHERE id = '$id_area'";
    $resultado = mysqli_query($conexion, $areaExistente);
    if (mysqli_num_rows($resultado) == 0) {
        $response['message'] = 'El IDdel area no coincide';
        echo json_encode($response);
        exit();
}
    $consulta = "INSERT INTO ambiente (nombre_ambiente, descripcion,  id_area) VALUES ('$nombre_ambiente',  '$descripcion', '$id_area')";

    if (mysqli_query($conexion, $consulta)) {
            $response['status'] = 'success';
            $response['title'] = 'Éxito';
            $response['message'] = 'Ambiente registrado exitosamente';
            echo json_encode($response);
            exit();
        } else {
            $response['message'] = 'Error al registrar el ambiente: ' . mysqli_error($conexion);
            echo json_encode($response);
            exit();
        }
    
        mysqli_close($conexion);
    }
?>