<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include('../../PHP/Conexion.php');

    $codigo = $_POST['reg_inve_cod'];
    $nombre_elemento = $_POST['reg_inve_nomb'];
    $descripcion_elemento = $_POST['reg_inve_desc'];
    $cantidad_almacen = $_POST['reg_inve_cant'];
    $und_medida = $_POST['reg_inve_medi'];
    $estado = $_POST['reg_inve_esta'];
    $id_ambiente = $_POST['reg_id_ambiente']; // Suponiendo que obtienes el valor de id_ambiente del formulario

    // Validar que el id_elemento sea único
    $idExistente = "SELECT * FROM elemento WHERE codigo = '$codigo'";
    $resultado = mysqli_query($conexion, $idExistente);
    if (mysqli_num_rows($resultado) > 0) {
            $response['message'] = 'El código del elemento ya existe';
            echo json_encode($response);
            exit();
        }
    // Verificar si el id_ambiente existe en la tabla ambiente
    $consulta_ambiente = "SELECT id_ambiente FROM ambiente WHERE id_ambiente = '$id_ambiente'";
    $resultado_ambiente = mysqli_query($conexion, $consulta_ambiente);
    if (mysqli_num_rows($resultado_ambiente) == 0) {
            $response['message'] = 'El ID de ambiente no es válido';
            echo json_encode($response);
            exit();
        }
    // Insertar datos en la tabla elemento
    $consulta = "INSERT INTO elemento (codigo, nombre, descripcion, cantidad, und_medida, estado, ambiente) 
    VALUES ('$codigo', '$nombre_elemento', '$descripcion_elemento', '$cantidad_almacen', '$und_medida', '$estado', '$id_ambiente')";
 
if (mysqli_query($conexion, $consulta)) {
    $response['status'] = 'success';
    $response['title'] = 'Éxito';
    $response['message'] = 'Elemento registrado exitosamente';
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