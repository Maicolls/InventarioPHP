<?php
include ('../PHP/Funciones.php');
include ('../PHP/Conexion.php');

InicioSesion();
if (!isset($_SESSION['nombre_usuario'])) {
    if (isset($_SESSION['id'])) {
        $consulta_nombre_usuario = "SELECT nombre_instructor FROM instructor WHERE id = {$_SESSION['id']}";
        $resultado_nombre_usuario = mysqli_query($conexion, $consulta_nombre_usuario);

        if ($resultado_nombre_usuario && mysqli_num_rows($resultado_nombre_usuario) > 0) {
            $fila_nombre_usuario = mysqli_fetch_assoc($resultado_nombre_usuario);
            $_SESSION['nombre_instructor'] = $fila_nombre_usuario['nombre_instructor'];
        } else {
            die("El nombre de usuario no está disponible.");
        }
    } else {
        die("El nombre de usuario no está disponible.");
    }
}

$consulta_documento = "SELECT cedula FROM instructor WHERE nombre_instructor = '{$_SESSION['nombre_instructor']}'";
$resultado_documento = mysqli_query($conexion, $consulta_documento);

if ($resultado_documento && mysqli_num_rows($resultado_documento) > 0) {
    $fila_documento = mysqli_fetch_assoc($resultado_documento);
    $documento_instructor = $fila_documento['cedula']; // Cambié 'documento' a 'cedula' aquí
} else {
    $documento_instructor = ""; // Establecer el documento en blanco si no se encuentra en la base de datos
}

Inactividad(700);

if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_solicitudes.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.2.2/dist/select2-bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>SENA-Gestor de Materiales</title>
</head>

<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <img src="../images/logo_cenigraf.png" alt="cenigraf logo" width="30%">
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
                                        Perfil <i class="bi bi-person-circle"></i>
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
    <div class="container my-5 py-4 px-5" id="formulario">
        <div class="row">
            <div class="col-12 my-5" id="Principal">
                <a href="PrincipalPersonalCENIGRAF.php">
                    <img src="../images/Logo-de-SENA-png-verde.png" style="float: right;" width="70px" title="Volver">
                </a>
                <h2 class="mt-2" id="titulo">Formulario solicitud de elementos anual</h2>
            </div>
        </div>
            <form action="../Personal/PHP/RegistrarSolicitudAnual.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label>Fecha de Solicitud:</label>
                        <input type="text" class="form-control mt-1 mb-1" id="f_solicitud" name="f_solicitud"
                            value="<?php echo date('Y-m-d'); ?>" readonly>

                        <script>
                            // Deshabilitar la edición del campo de fecha
                            document.getElementById('f_solicitud').addEventListener('focus', function () {
                                this.blur();
                            });
                        </script>
                        <label>Nombre del solicitante:</label>
                        <input type="text" class="form-control mt-1 mb-1" id="nombre_solicitante"
                            name="nombre_solicitante" value="<?php echo $_SESSION['nombre_instructor']; ?>" required
                            style="text-transform: uppercase;" readonly>
                            
                        <label>Seleccionar la ficha:</label>
                        <select class="form-control mt-1 mb-1" id="fi_anu" name="fi_anu" required>
                            <option value="">Seleccionar Ficha</option>
                            <?php
                            $consulta_fichas = "SELECT numero_ficha FROM ficha";
                            $resultado_fichas = mysqli_query($conexion, $consulta_fichas);
                            while ($fila_fichas = mysqli_fetch_assoc($resultado_fichas)) {
                                echo "<option value='{$fila_fichas['numero_ficha']}'>{$fila_fichas['numero_ficha']}</option>";
                            }
                            ?>
                        </select>
                        </div>

                        <div class="col-md-6">
                    <label>Número de documento:</label>
                    <input type="number" class="form-control mt-1 mb-1" id="docu" name="docu" value="<?php echo $documento_instructor; ?>" required style="text-transform: uppercase;" readonly>

                    <label>Seleccionar programa:</label>
                        <select class="form-control mt-1 mb-1" id="pro_anu" name="pro_anu" required>
                            <option value="">Seleccionar Programa</option>
                            <?php
                            $consulta_programas = "SELECT * FROM programa";
                            $resultado_programas = mysqli_query($conexion, $consulta_programas);
                            while ($fila_programa = mysqli_fetch_assoc($resultado_programas)) {
                                echo "<option value='{$fila_programa['id_programa']}'>{$fila_programa['nombre_programa']}</option>";
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered mt-4" id="tabla_ele_anu">
                            <thead>
                                <tr>
                                    <th class="col-3">Nombre del elemento</th>
                                    <th class="col-1">U/Medida</th>
                                    <th class="col-1">Disponible</th>
                                    <th class="col-1">Cantidad a comprar</th>
                                </tr>
                            </thead>
                            <tbody id="body_elemento">
                                <tr id="elemento_prin_anu" name="elemento_prin_anu">
                                    <td>
                                        <select class="form-control elemento-select" name="nom_elemento[]">
                                            <option>Seleccionar</option>
                                            <?php
                                            $consulta_elemento = "SELECT * FROM elemento";
                                            $resultado_elemento = mysqli_query($conexion, $consulta_elemento);
                                            while ($fila_elemento = mysqli_fetch_assoc($resultado_elemento)) {
                                                echo "<option value='{$fila_elemento['id_elemento']},{$fila_elemento['nombre']}'>{$fila_elemento['nombre']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control udmedanu" name="unidad[]" id="unidad"
                                            readonly></td>
                                    <td><input type="number" class="form-control dispo" name="cantidad[]" id="cantidad"
                                            readonly></td>
                                    <td><input type="number" class="form-control cantidad" name="solicitada[]"
                                            id="solicitada" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-success btn-lg mt-4 float-right" id="enviar_informe">Enviar Informe <i
                                class="bi bi-send"></i></button>
                        <button class="btn btn-secondary mb-3" id="nuevo_articulo">Añadir Item <i
                                class="bi bi-journal-plus"></i></button><br>
                        <button type="button" class="btn btn-danger mb-3" id="eliminar_fila">Eliminar Artículo <i
                                class="bi bi-trash"></i></button><br>
                    </div>
                </div>
            </form>
        </div>
        <script src="../js/Solicitud_anual.js"></script>
</body>

</html>