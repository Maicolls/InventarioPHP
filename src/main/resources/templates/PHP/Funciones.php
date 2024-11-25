<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



function InicioSesion(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['username'])) {
        echo "<script>
            localStorage.setItem('error_acceso', 'Debe iniciar sesión para ingresar a la página');
            window.location.href = '../index.php';
        </script>";
        exit();
    }
}

function Inactividad($TiempoInactivo = 900) {
    if (isset($_SESSION['username']) && isset($_SESSION['TiempoLimite'])) {
        $Tiempo = time() - $_SESSION['TiempoLimite'];
        if ($Tiempo > $TiempoInactivo) {
            session_unset();
            session_destroy();
            echo "<script>
                localStorage.setItem('error_inactividad', 'Tu sesión ha expirado por inactividad.');
                window.location.href = '../index.php';
            </script>";
            exit();
        }
    } elseif (isset($_SESSION['username'])) {
        $_SESSION['TiempoLimite'] = time();
    }
}



function cerrarSesion() {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}





