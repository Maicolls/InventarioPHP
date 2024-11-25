<?php
include('Conexion.php');

session_start();

if(isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    // Expresión regular para validar contraseña: mínimo 8 caracteres, al menos una mayúscula y una minúscula
    $regex_password = '/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/';

    $consulta = "SELECT id, nombre_instructor, contrasena, correo, rol FROM instructor WHERE correo = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);
    
    if($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Validación de la contraseña
        if (!preg_match($regex_password, $contrasena)) {
            $_SESSION['error_login'] = 'La contraseña debe tener mínimo 8 caracteres, al menos una mayúscula y una minúscula.';
            header('Location: ../index.php');
            exit();
        } else if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['username'] = $usuario['correo'];
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_instructor'];
        
            switch($usuario['rol']) {
                case "1":
                    header("Location: ../administradores/PrincipalAdmin.php");
                    break;
                case "4":
                    header("Location: ../Personal/PrincipalPersonalCENIGRAF.php");
                    break;
                case "3":
                    header("Location: ../almacen/MaquinasAlmacen.php");
                    break;
                case "2":
                    header("Location: ../coordinador/SolicitudPerCoordi.php");
                    break;
                default:
                    header("Location: ../index.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['error_login'] = 'Contraseña incorrecta';
        }
    } else {
        $_SESSION['error_login'] = 'Usuario no encontrado';
    }

    // Redirige al index.php si hay algún error
    if(isset($_SESSION['error_login'])) {
        header('Location: ../index.php');
        exit();
    }
} else {
    $_SESSION['error_login'] = 'Datos de inicio de sesión no recibidos';
    header('Location: ../index.php');
    exit();
}
?>