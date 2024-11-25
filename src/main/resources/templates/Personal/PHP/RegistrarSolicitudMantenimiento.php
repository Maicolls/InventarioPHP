<?php
// Conectar a la base de datos
include ('../../PHP/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$tipo_solicitud = $_POST['solicitud'];
$fecha_solicitud = $_POST['fecha_solicitud'];
$necesidad = $_POST['necesidad'];
$nom_maquina = $_POST['nom_maquina'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$placa = $_POST['placa'];
$serial = $_POST['serial'];
$cantidad = $_POST['cantidad'];
$tipo_mantenimiento = $_POST['tipo'];
$suministro = $_POST['suministro'];
$ambiente = $_POST['ambiente'];
$solicitante = $_POST['id_instructor'];
$rol_solicitante = $_POST['id_rol_solicitante'];



// Verificar si la máquina ya existe en la base de datos
$stmt_verificar_maquina = $conexion->prepare("SELECT id FROM maquina WHERE serial = ?");
$stmt_verificar_maquina->bind_param("s", $serial);
$stmt_verificar_maquina->execute();
$stmt_verificar_maquina->store_result();

if ($stmt_verificar_maquina->num_rows > 0) {
    // La máquina ya existe, obtener su ID
    $stmt_verificar_maquina->bind_result($id_maquina);
    $stmt_verificar_maquina->fetch();
    $stmt_verificar_maquina->close();
} else {
    // La máquina no existe, insertar un nuevo registro
    $stmt_verificar_maquina->close();

    // Preparar la consulta SQL para insertar la nueva máquina
    $stmt_insertar_maquina = $conexion->prepare("INSERT INTO maquina (serial, adquisicion, nombre_maquina, marca, modelo, placa, cantidad, id_ambiente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_insertar_maquina->bind_param("issssiii", $serial, $fecha_solicitud, $nom_maquina, $marca, $modelo, $placa, $cantidad, $ambiente);

    if ($stmt_insertar_maquina->execute()) {
        // Capturar el ID de la máquina insertada
        $id_maquina = $stmt_insertar_maquina->insert_id;
    } else {
        die("Error al insertar la máquina: " . $stmt_insertar_maquina->error);
    }
    $stmt_insertar_maquina->close();
}

// Preparar la consulta SQL para insertar los datos de la solicitud
$stmt = $conexion->prepare("INSERT INTO solicitud_mantenimiento (solicitud, fecha_soli, necesidad, maquina, tipo, suministro, id_instructor, id_ambiente, id_rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiisiii", $tipo_solicitud, $fecha_solicitud, $necesidad, $id_maquina, $tipo_mantenimiento, $suministro, $solicitante, $ambiente, $rol_solicitante);
echo "<script>alert('Solicitud de mantenimiento registrada correctamente. ID del rol: " . $rol_solicitante . "');</script>";
// Ejecutar la consulta
if ($stmt->execute()) {
 
        // Redireccionar o realizar otras acciones después de la inserción exitosa
        header('Location:../Subir/ReporteMantenimiento.php');
        exit();
    } else {
        // Manejar errores en la inserción de la solicitud
        echo "Error en la inserción de solicitud de mantenimiento: " . $stmt->error;
    }

    // Cerrar la consulta para la solicitud y la conexión
    $stmt->close();
    $conexion->close();

?>