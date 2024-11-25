<?php
include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_ficha = $_POST['reg_fic_num'];
    $id_programa = $_POST['reg_prog_id']; 

    // Validar que el id_programa sea único
    $numExistente = "SELECT * FROM ficha WHERE numero_ficha = '$numero_ficha'";
    $resultado = mysqli_query($conexion, $numExistente);
    if (mysqli_num_rows($resultado) > 0) {
            $response['message'] = 'El número de la ficha ya existe';
            echo json_encode($response);
            exit();
        }
    // Insertar la ficha en la base de datos
    $consulta = "INSERT INTO ficha (numero_ficha, id_programa) VALUES ('$numero_ficha', '$id_programa')";
    if (mysqli_query($conexion, $consulta)) {
            $response['status'] = 'success';
            $response['title'] = 'Éxito';
            $response['message'] = 'Ficha registrada exitosamente';
            echo json_encode($response);
            exit();
        } else {
            $response['message'] = 'Error al registrar la ficha: ' . mysqli_error($conexion);
            echo json_encode($response);
            exit();
        }

    mysqli_close($conexion);
}

