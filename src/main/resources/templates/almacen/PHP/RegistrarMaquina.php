<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include('../../PHP/Conexion.php');

    $id_maquina = $_POST['reg_seri_maqu'];
    $nombre_maquina = $_POST['reg_nomb_maqu'];
    $marca = $_POST['reg_marc_maqu'];
    $modelo = $_POST['reg_model_maqu'];
    $placa = $_POST['reg_plac_maqu'];
    $adquisicion = $_POST['reg_fech_maqu'];
    $cantidad = $_POST['reg_cant_maqu'];
    $id_ambiente = $_POST['reg_nom_ambi']; // Cambiar a 'reg_nom_ambi' si el campo 'reg_id_ambi' es el id del ambiente

    // Validar que el id_maquina sea único
    $idExistente = "SELECT * FROM maquina WHERE serial = '$id_maquina'";
    $resultado = mysqli_query($conexion, $idExistente);
    if (mysqli_num_rows($resultado) > 0) {
        $response['message'] = 'El serial ya existe';
        echo json_encode($response);
        exit();
    }
    // Validar que el id_ambiente exista
    $ambienteExistente = "SELECT * FROM ambiente WHERE id_ambiente = '$id_ambiente'";
    $resultado = mysqli_query($conexion, $ambienteExistente);
    if (mysqli_num_rows($resultado) == 0) {
        $response['message'] = 'El id del ambiente no coincide';
        echo json_encode($response);
        exit();
    }

    $consulta = "INSERT INTO maquina (serial, nombre_maquina, marca, modelo, placa, adquisicion, cantidad, id_ambiente) VALUES ('$id_maquina', '$nombre_maquina','$marca', '$modelo', '$placa', '$adquisicion', '$cantidad', '$id_ambiente')";

    
    if (mysqli_query($conexion, $consulta)) {
        $response['status'] = 'success';
        $response['title'] = 'Éxito';
        $response['message'] = 'Maquina registrada exitosamente';
        echo json_encode($response);
        exit();
    } else {
        $response['message'] = 'Error al registrar la maquina: ' . mysqli_error($conexion);
        echo json_encode($response);
        exit();
    }

    mysqli_close($conexion);
}
?>
