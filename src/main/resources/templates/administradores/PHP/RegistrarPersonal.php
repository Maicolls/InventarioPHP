<?php
include('../../PHP/Conexion.php');
$cedula = mysqli_real_escape_string($conexion, $_POST['reg_instru_ced']);
$nombre_instructor = mysqli_real_escape_string($conexion, $_POST['reg_instru_nomb']);
$celular = mysqli_real_escape_string($conexion, $_POST['reg_instru_celu']);
$correo = mysqli_real_escape_string($conexion, $_POST['reg_instru_corr']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['reg_instru_contra']);
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
$rol = mysqli_real_escape_string($conexion, $_POST['reg_instru_rol']);
$especialidad_id = mysqli_real_escape_string($conexion, $_POST['reg_instru_espe']);

$consulta_verificar = "SELECT * FROM instructor WHERE cedula = '$cedula'";
$resultado_verificar = mysqli_query($conexion, $consulta_verificar);
if (mysqli_num_rows($resultado_verificar) > 0) {
    $response['message'] = 'La cédula ya está registrada.';
    echo json_encode($response);
    exit();
}

$consulta = "INSERT INTO instructor (cedula, nombre_instructor, celular, correo, contrasena, rol, especialidad) 
             VALUES ('$cedula', '$nombre_instructor', '$celular', '$correo', '$contrasena_hash', '$rol', '$especialidad_id')";

if (mysqli_query($conexion, $consulta)) {
    $response['status'] = 'success';
    $response['title'] = 'Éxito';
    $response['message'] = 'Usuario registrado exitosamente';
    echo json_encode($response);
    exit();
} else {
    $response['message'] = 'Error al registrar el usuario: ' . mysqli_error($conexion);
    echo json_encode($response);
    exit();
}

mysqli_close($conexion);
?>
