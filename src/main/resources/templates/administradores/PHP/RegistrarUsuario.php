<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include('../../PHP/Conexion.php');

    $id_usuario = $_POST['reg_usua_id'];
    $nombre = $_POST['reg_usua_nomb'];
    $contrasena = $_POST['reg_usua_contra'];
    $rol = $_POST['reg_usua_rol'];

    // Validar que el id_usuario sea unico

    $idExistente = "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conexion, $idExistente);
    if (mysqli_num_rows($resultado) > 0) {
        echo "<script>alert('El id del usuario ya existe');
        window.location.href = '../UsuariossAdmin.php';</script>";
        exit();
    }

    $consulta = "INSERT INTO usuario (id_usuario, nombre, contrasena, rol) VALUES ('$id_usuario', '$nombre', '$contrasena', '$rol')";

    if (mysqli_query($conexion, $consulta)) {
        echo "<script>alert('Usuario registrado exitosamente');
        window.location.href = '../UsuariossAdmin.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error al registrar el usuario: " . mysqli_error($conexion) . "');
        window.location.href = '../UsuariossAdmin.php';</script>";
        exit();
    }

    mysqli_close($conexion);
}
?>