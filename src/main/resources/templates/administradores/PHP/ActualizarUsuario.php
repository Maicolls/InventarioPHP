<?php

include('../../PHP/Conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST['edit_id_usua'];
    $nombre = $_POST['edit_nomb_usua'];
    $contrasena = $_POST['edit_contra_usua'];
    $rol = $_POST['edit_rol_usua'];

    //Tomar en cuenta si esta consulta sirve ya que no se encuentra almacenada en la base de datos
    $updateQuery = "UPDATE usuario SET nombre='$nombre', contrasena='$contrasena', rol='$rol' WHERE id_usuario='$id_usuario'";
    /////////////////////////////////////////////////////////

    if (mysqli_query($conexion, $updateQuery)) {
        echo "<script>alert('Actualizacion de datos exitosa');
    window.location.href = '../UsuariossAdmin.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos');
        window.location.href = '../UsuariossAdmin.php';</script>" . mysqli_error($conexion);
    }


mysqli_close($conexion);
} else {
echo "Acceso no válido.";
}
?>