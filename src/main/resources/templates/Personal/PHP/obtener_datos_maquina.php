<?php
// Incluir el archivo de conexión a la base de datos
include('../../PHP/Conexion.php');

// Verificar si se recibió el nombre de la máquina
if(isset($_POST['nombre_maquina'])) {
    // Sanitizar y obtener el nombre de la máquina desde la solicitud POST
    $nombreMaquina = mysqli_real_escape_string($conexion, $_POST['nombre_maquina']);

    // Consulta SQL para obtener los datos de la máquina
    $consulta = "SELECT * FROM maquina WHERE nombre_maquina = '$nombreMaquina'";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta fue exitosa
    if($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos de la máquina
        $fila = mysqli_fetch_assoc($resultado);

        // Crear un array asociativo con los datos de la máquina
        $datosMaquina = array(
            'modelo' => $fila['placa'],
            'serial' => $fila['id_maquina'],
            'cantidad' => $fila['cantidad']
            // Agrega más campos si es necesario
        );

        // Devolver los datos de la máquina en formato JSON
        echo json_encode($datosMaquina);
    } else {
        // Si no se encontraron datos, devolver un mensaje de error
        echo json_encode(array('error' => 'No se encontraron datos para la máquina.'));
    }
} else {
    // Si no se recibió el nombre de la máquina, devolver un mensaje de error
    echo json_encode(array('error' => 'No se recibió el nombre de la máquina.'));
}
?>
