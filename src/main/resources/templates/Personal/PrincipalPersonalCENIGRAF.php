<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"&amp;gt;>
    <!--Sweetalert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../CSS/style_menu_instructores.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--JQuery y js-->
    <script src="../js/jquery-3.6.1.min.js" type="text/javascript"></script>
    <title>SENA-Gestor de Materiales</title>
</head>
    <!--Barra de navegación-->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 logo_section">
                    <div class="full">
                        <div class="center-desk">
                        <div class="logo">
                                <img src="../images/logo_cenigraf.png" alt="cenigraf logo" width="300px" style="float: left;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <nav class="navigation navbar navbar-expand-md navbar-dark mr-auto">
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-expand">
                                <li class="nav-link">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                            Perfil <i class="bi bi-person-circle"></i></i>
                                        </button>
                                        <div class="dropdown-menu">
                                        <a class="dropdown-item">Personal</a>
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
        <div class="container p-5" id="info">
            <div class="row p-5">
                <div class="col-12">
                    <h1>Seleccionar el tipo de informe que solicita</h1>
                </div>
                <div class="col-6 mt-5">
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#infomate" id="infor"><i class="bi bi-box-seam-fill" id="icon-btn"></i><br>Solicitud de materiales</button>                
                </div>
                <div class="col-6 mt-5"> 
                    <a href="Solicitud_mantenimiento.php"><button type="button" class="btn btn-outline-dark" id="infor"><i class="bi bi-wrench-adjustable-circle-fill" id="icon-btn"></i><br>Solicitud de mantenimiento</button></a>                
                </div>
            </div>
        </div>
        <div id="infomate" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
          
              <!-- Modal Materiales-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container p-5">
                        <h3>Seleccionar solicitud</h3>
                        <div class="row justify-content-center ">
                            <div class="col-6 " id="btn_principales">
                                <a href="Solicitud_periodica.php"><button type="button" class="btn btn-light" id="solicitudmate"><i class="bi bi-calendar2-week-fill" id="icon-btn"></i><br>Solicitud Periodica</button></a>                
                            </div>
                            <div class="col-6 " id="btn_principales">
                                <a href="Solicitud_anual.php"><button type="button" class="btn btn-light" id="solicitudmate"><i class="bi bi-calendar3" id="icon-btn"></i><br>Solicitud Anual</button></a>                
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          
            </div>
        </div>
        <script src="../js/Solicitud_mantenimiento.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>          
            $('#elemento_anu').select2();
            $('#elemento_per').select2();
            $('#elemento_man').select2();
            $('#ins_anu').select2();
            $('#fic_anu').select2();
            $('#pro_anu').select2();
            $('#ins_per').select2();
            $('#fic_per').select2();
            $('#pro_per').select2();
            $('#amb_man').select2();
            $('#maq_man').select2();
            $('#tipo_mante').select2();

            $("#eliminar_fila_man").click(function () { 
                $("#tb_elementom tr:last").remove();
            });
        </script>       
    </body> 
</html>