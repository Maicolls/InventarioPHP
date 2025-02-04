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

//Inactividad(700);

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
    <!-- Sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../CSS/style_solicitudes.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos personalizados */
        .hide {
            display: none;
        }

        .listaAutocompletado {
            position: absolute;
            border: 1px solid #ddd;
            border-top: none;
            z-index: 1000;
            list-style-type: none;
        }

        .listaAutocompletado li {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
        }

        .listaAutocompletado li:hover {
            background-color: #f0f0f0;
        }

        .nombre-cuentadante,
        .documento-cuentadante {
            width: 48%;
            display: inline-block;
            margin-right: 1%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
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
                                        Perfil <i class="bi bi-person-circle"></i></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">Personal CENIGRAF</a>
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

    <?php
    if (isset($_SESSION['correo_enviado']) && $_SESSION['correo_enviado']) {
        echo "<script>document.addEventListener('DOMContentLoaded', function(event) { 
            Swal.fire({
                icon: 'success',
                title: 'Solicitud enviada',
                text: 'La solicitud periódica ha sido enviada con éxito, se enviará un correo al coordinador.'
            });
        });</script>";
        unset($_SESSION['correo_enviado']);
    }
    ?>
    <div class="container my-5 py-4 px-5" id="formulario">
        <div class="row">
            <div class="col-12 my-5" id="Principal">
                <a href="PrincipalPersonalCENIGRAF.php">
                    <img src="../images/Logo-de-SENA-png-verde.png" style="float: right;" width="70px" title="Volver">
                </a>

                <h2 class="mt-2" id="titulo">Solicitud de bienes - Personal CENIGRAF </h2>
                <h5>(GIL-F014)</h5>
            </div>
        </div>
        <form action="PHP/RegistrarSolicitudPeriodica.php" method="post">
            <!-- id="solicitud_per" -->
            <div class="row">
                <div class="col-md-6">
                    <label>Fecha de Solicitud:</label>
                    <input class="form-control" id="f_solicitud" name="f_solicitud" value="<?php echo date('Y-m-d'); ?>"
                        readonly>
                    <label class="mt-2">Código Regional:</label>
                    <input type="text" class="form-control" id="cod_regional" name="cod_regional" value="11"
                        placeholder="9217" readonly>
                    <label class="mt-2">Código de Costos:</label>
                    <input type="text" class="form-control" id="cod_costos" name="cod_costos" value="9217"
                        placeholder="921710" readonly>
                    <label class="mt-2">Nombre del jefe de oficina o coordinador del area:</label>
                    <input type="text" class="form-control" id="nombre_coor" name="nombre_coor" required
                        placeholder="Digite el jefe o coordinador" style="text-transform: uppercase;">
                    <ul class="listaAutocompletado" id="listaAutocompletado1"></ul>
                    <input type="hidden" id="id_coordinador" name="id_coordinador">
                </div>
                <div class="col-md-6">
                    <label>Area:</label>
                    <input type="text" class="form-control" id="area_solicitud" name="area_solicitud" required
                        placeholder="Digite el área" style="text-transform: uppercase;">
                    <ul class="listaAutocompletado" id="listaAutocompletado2"></ul>
                    <input type="hidden" id="id_area" name="id_area">
                    <label class="mt-2">Nombre Regional:</label>
                    <input type="text" class="form-control" id="nom_regional" name="nom_regional"
                        value="DISTRITO CAPITAL" placeholder="Distrito Capital" readonly>
                    <label class="mt-2">Nombre Centro de Costos:</label>
                    <input type="text" class="form-control" id="nom_centro_costos" name="nom_centro_costos"
                        value="CENIGRAF" placeholder="CENIGRAF" readonly>
                    <label class="mt-2">Cargo:</label>
                    <input type="text" class="form-control" id="cargo" name="cargo" required
                        placeholder="Digite el cargo" style="text-transform: uppercase;">
                </div>
                <div class="col-md-6">
                    <label class="mt-2">Tipo de cuentadante:</label>
                    <select class="form-control" id="tip_cuentadante" name="tip_cuentadante" onchange="mostrarCampos()"
                        required>
                        <option value="">Seleccionar Tipo de cuentadante</option>
                        <option value="Unipersonal">Unipersonal</option>
                        <option value="Multiple">Multiple</option>
                    </select>
                </div>
                <br>
                <div class="col-md-12">
                    <input type="hidden" id="id_tipo_cuentadante" name="id_tipo_cuentadante">
                    <div id="camposUnipersonal" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="mt-2" for="nombre_unipersonal">Nombre del cuentadante:</label>
                                    <input type="text" class="form-control" id="nombre_unipersonal"
                                        name="nombre_unipersonal" placeholder="Digite el nombre del cuentadante"
                                        style="text-transform: uppercase;" require>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="mt-2" for="cedula_unipersonal">Cédula del cuentadante:</label>
                                    <input type="number" class="form-control" id="cedula_unipersonal"
                                        name="cedula_unipersonal" placeholder="Digite la cedula del cuentadante"
                                        style="text-transform: uppercase;" require>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="camposMultiple" style="display: none;">
                        <div class="row" id="contenedorCuentadantes">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="mt-2" for="nom_cuentadante1">Nombre cuentadante 1:</label>
                                    <input type="text" class="form-control" id="nom_cuentadante1"
                                        name="nom_cuentadante1[]" placeholder="Digite el nombre del cuentadante"
                                        style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="mt-2" for="doc_cuenta1">Documento cuentadante 1:</label>
                                    <input type="number" class="form-control" id="doc_cuenta1" name="doc_cuenta1[]"
                                        placeholder="Digite la cedula del cuentadante"
                                        style="text-transform: uppercase;">
                                </div>

                            </div>

                        </div>

                        <button type="button" class="btn btn-primary mt-1" id="agregarCuentadante"> Añadir Cuentadante
                            <i class="bi bi-plus-circle"></i></button>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="mt-2">Destino de los bienes:</label>
                            <select class="form-control" name="destino" id="destino" required>
                                <option value="" disabled selected hidden>Seleccionar destino de los bienes</option>
                                <?php
                                // Consulta para obtener las areas disponibles
                                $consulta_area = "SELECT id, nombre FROM area";
                                $resultado_area = mysqli_query($conexion, $consulta_area);

                                // Generar opciones para el menú desplegable
                                while ($fila_area = mysqli_fetch_assoc($resultado_area)) {
                                    echo "<option value='{$fila_area['id']}'>{$fila_area['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="mt-2">Código de grupo o número de ficha:</label>
                            <input type="number" class="form-control" id="ficha" name="ficha"
                                placeholder="Ingrese el numero de ficha" required>
                            <ul class="listaAutocompletado" id="listaAutocompletado3"></ul>
                            <input type="hidden" id="numero_ficha" name="numero_ficha">
                        </div>
                    </div>
                    
                    <table class="table table-bordered mt-4" id="tabla_ele_per">
                        <thead>
                            <tr>
                                <th class="col-2">Código</th>
                                <th class="col-3">Descripción</th>
                                <th class="col-1">Und/Medida</th>
                                <th class="col-1">Cantidad(N°)</th>
                                <th class="col-3">Observación</th>
                            </tr>
                        </thead>
                        <tbody id="body_elemento">
                            <tr id="elemento_prin_per">
                                <td><input class="form-control" type="text" name="cod_elem[]" readonly></td>
                                <td><input class="form-control" type="text" name="desc_elem[]" require></td>
                                <td><input class="form-control" type="text" name="und_elem[]"></td>
                                <td><input class="form-control" type="number" name="canti_elem[]" require></td>
                                <td><textarea class="form-control" name="obser_elem[]"></textarea></td>
                            </tr>
                        </tbody>
                    </table>

                        <input type="hidden" class="form-control mt-1 mb-1" id="nombre_solicitante"
                            name="nombre_solicitante" value="<?php echo $_SESSION['nombre_instructor']; ?>" required
                            style="text-transform: uppercase;" readonly> 
                
                    <input type="hidden" class="form-control mt-1 mb-1" id="docu" name="docu" value="<?php echo $documento_instructor; ?>" required style="text-transform: uppercase;" readonly>

                    <button type="button" class="btn btn-secondary mt-3" id="nuevo_articulo">Añadir Artículo <i
                            class="bi bi-journal-plus"></i></button>
                    <button type="button" class="btn btn-danger  mt-3" id="eliminar_fila">Eliminar Artículo <i
                            class="bi bi-trash"></i></button>

                    <button class="btn btn-success btn-lg mt-2 float-right" id="correo_enviado">Enviar Informe <i
                            class="bi bi-send"></i></button>

        </form>
<form action="Subir/ReportesExcel.php" method="post" id="excelForm">
    <div class="row">
        <div class="col-md-6 mb-3">
            <!-- Incluye los campos del formulario principal -->
            <input type="hidden" name="f_solicitud" value="<?php echo isset($_POST['f_solicitud']) ? $_POST['f_solicitud'] : ''; ?>">
            <input type="hidden" name="nombre_solicitante" value="<?php echo isset($_POST['nombre_solicitante']) ? $_POST['nombre_solicitante'] : ''; ?>">
            <input type="hidden" name="docu" value="<?php echo isset($_POST['docu']) ? $_POST['docu'] : ''; ?>">
            <input type="hidden" name="fi_anu" value="<?php echo isset($_POST['fi_anu']) ? $_POST['fi_anu'] : ''; ?>">
            <input type="hidden" name="pro_anu" value="<?php echo isset($_POST['pro_anu']) ? $_POST['pro_anu'] : ''; ?>">
            <!-- Añade otros campos necesarios -->
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg mt-2 float-right">Descargar Excel <i class="bi bi-file-earmark-spreadsheet"></i></button>
</form>
    </div>
    </div>
    
    <script src="../js/Solicitud_periodica1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>