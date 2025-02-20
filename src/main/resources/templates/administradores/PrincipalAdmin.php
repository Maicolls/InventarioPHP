<?php

include ('../PHP/Funciones.php');

InicioSesion();

// Verifica si hay una sesión y si el nombre de usuario está establecido
if (isset($_SESSION['nombre_usuario'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];
    echo "<script>document.addEventListener('DOMContentLoaded', function(event) { 
        Swal.fire({
            icon: 'success',
            title: '¡Bienvenido, " . $nombreUsuario . "!',
            text: 'Has iniciado sesión correctamente.'
        });
    });</script>";

    // Limpia la variable de sesión después de mostrarla
    unset($_SESSION['nombre_usuario']);
}

Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" &amp;gt;>
    <!--Sweetalert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../CSS/style_menu_admin.css">
    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../images/logo-de-Sena-sin-fondo-Blanco.png">
    <title>SENA-Gestor de Materiales</title>
</head>
<!--Barra de navegación-->
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <img src="../images/logo_cenigraf.png" alt="cenigraf logo" width="300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <nav class="navigation navbar navbar-expand-md navbar-dark mr-auto">
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-expand">
                            <li class="nav-link">
                                <a href="PrincipalAdmin.php" id="btn-nav" class="btn btn-lg">Informe</a>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle"
                                        data-toggle="dropdown">Formación y Ambientes </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="ProgramasAdmin.php" id="btn-nav">Programas</a>
                                        <a class="dropdown-item" href="FichasAdmin.php" id="btn-nav">Fichas</a>
                                        <a class="dropdown-item" href="AmbientesAdmin.php" id="btn-nav">Ambientes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle"
                                        data-toggle="dropdown">Personal </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="PersonalCenigrafAdmin.php" id="btn-nav">Personal
                                            CENIGRAF</a>
                                        <!--<a class="dropdown-item" href="UsuariossAdmin.php" id="btn-nav">Usuarios</a>-->
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                        Perfil <i class="bi bi-person-circle"></i></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">Administrador</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="?cerrar_sesion=1">Cerrar Sesion</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<body>
    <!--Info-->
    <div class="container pl-2" id="info" style="width: 130%;">
        <div class="row" style="width: 125%;">
            <div class="col-5 pt-4 pb-4 pl-4">
                <h2>Descarga de reportes anuales</h2>
                <p id="parrafo">Archivo en formato <b>.xlsx</b> o <b>.pdf</b> con las solicitudes de material para uso
                    anual por parte de los instructores </p>
                <div>
                    <button class="btn btn-success btn-lg" id="informe"
                        onclick="location.href='Subir/ReportesExcelAdmin.php?tipo=anual'">Generar Excel <i
                            class="bi bi-file-earmark-excel"></i></button>
                </div>
                <div>
                    <button class="btn btn-danger btn-lg" id="informe"
                        onclick="location.href='Subir/ReportesPdfAdmin.php?tipo=anual'">Generar Pdf <i
                            class="bi bi-file-earmark-pdf"></i></button>
                </div>
            </div>
            <div class="col-5 pt-4 pb-4 pl-4">
                <h2>Descarga de reporte mensual</h2>
                <p id="parrafo">Archivo en formato <b>.xlsx</b> o <b>.pdf</b> con las solicitudes de material para uso
                    anual por parte de los instructores </p>
                <div>
                    <button class="btn btn-success btn-lg" id="informe"
                        onclick="location.href='Subir/ReportesExcelAdmin.php?tipo=mensual'">Generar Excel <i
                            class="bi bi-file-earmark-excel"></i></button>
                </div>
                <div>
                    <button class="btn btn-danger btn-lg" id="informe"
                        onclick="location.href='Subir/ReportesPdfAdmin.php?tipo=mensual'">Generar Pdf <i
                            class="bi bi-file-earmark-pdf"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>