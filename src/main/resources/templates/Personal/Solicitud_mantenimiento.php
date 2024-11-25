<?php

include ('../PHP/Funciones.php');
include ('../PHP/Conexion.php');

InicioSesion();

if (!isset($_SESSION['nombre_usuario'])) {
    if (isset($_SESSION['id'])) {
        $consulta_nombre_usuario = "SELECT * FROM instructor WHERE id = {$_SESSION['id']}";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" &amp;gt;>
    <link rel="stylesheet" href="../CSS/style_solicitudes.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--JQuery y js-->
    <script src="../js/jquery-3.6.1.min.js" type="text/javascript"></script>
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
    <div class="container my-5 py-4 px-5" id="formulario">
        <div class="row">
            <div class="col-12 my-5" id="Principal">

                <a href="PrincipalPersonalCENIGRAF.php">
                    <img src="../images/Logo-de-SENA-png-verde.png" style="float: right;" width="70px" title="Volver">
                </a>



                <h2 class="mt-2" id="titulo">Solicitud de mantenimiento - Personal CENIGRAF </h2>
            </div>
        </div>
        <form action="PHP/RegistrarSolicitudMantenimiento.php" method="post">
            <div class="row">
                <div class="form-group col-12">
                    <h3>Seleccione el tipo de mantenimiento</h3>

                    <?php
                    // Consulta para obtener los tipos de mantenimiento disponibles
                    $consulta_mantenimiento = "SELECT id, nombre FROM tipo_mantenimiento";
                    $resultado_mantenimiento = mysqli_query($conexion, $consulta_mantenimiento);

                    // Generar opciones para los radio botones
                    while ($fila_mantenimiento = mysqli_fetch_assoc($resultado_mantenimiento)) {
                        echo "<div class='form-check px-5'>";
                        echo "<label class='form-check-label' for='radio{$fila_mantenimiento['id']}'>";
                        echo "<input type='radio' name='solicitud' class='form-check-input'  id='radio{$fila_mantenimiento['id']}' value='{$fila_mantenimiento['id']}' required>{$fila_mantenimiento['nombre']}";
                        echo "</label>";
                        echo "</div>";
                    }
                    ?>

                </div>

                <div class="col-6">
                    <label for="fecha_solicitud">Fecha de solicitud:</label>
                    <input type="text" class="form-control" id="fecha_solicitud" name="fecha_solicitud" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="col-6">
                    <label for="necesidad">Nombre de la necesidad:</label>
                    <input type="text" class="form-control" id="necesidad" name="necesidad"
                        style="text-transform: uppercase;" required>
                </div>
                <div class="form-group col-12">
                    <table class="table table-bordered mt-4">
                        <thead style="text-align: center;">
                            <th>JUSTIFICACIÓN</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="px-3">
                                        El Centro para la Industria de la Comunicación Gráfica-SENA, Regional Distrito
                                        Capital, debe garantizar la adecuada formación profesional de sus aprendices.
                                        Dentro de esta obligación, es importante propender porque
                                        ellos cuenten con infraestructura tecnológica de artes gráficas, que esté en
                                        óptimas condiciones de funcionamiento, para que pueden contar con un proceso de
                                        formación de calidad acorde con las exigencias del mundo
                                        laboral.
                                    </p>
                                    <p class="px-3">
                                        Por otra parte, se deben garantizar que los procesos formativos den respuesta a
                                        condiciones de calidad para la ejecución de las competencias de corte, plegado,
                                        costuras con hilo, traquelado, plasificado, corte laser,
                                        encuademación rústica, anilados, encuademaciones en tapa dura, repujados y
                                        estampados.
                                    </p>
                                    <p class="px-3">
                                        El amblente de formación debo contar con los equipos en óptimas condiciones de
                                        acuerdo con el manual del fabricante, para que de esa manera se pueda garantizar
                                        el buen desarrollo de las competencias asociadas
                                        al programa de formación. El mantenimiento de la maquinaria, debe hacerse
                                        anualmente debido al desgaste ocasionado por la operación de los aprendices, se
                                        debe garantizar que estén en completa funcionalidad, lo
                                        que se logra con un mantenimiento preventivo y correctivo periódico de las
                                        máquinas con la Inclusión de los repuestos nuevos y originales que se requieran.
                                        Adicionalmente, el apoyo a la producción de impresos
                                        solicitados por la comunidad educativa en generel de este Centro de Formación,
                                        la Dirección General y otras Dependencias de la Entidad. demandan que los
                                        equipos utlizados en los procesos funcionen
                                        adecuadamente.
                                    </p>
                                    <p class="px-3">
                                        Dentro de ls objetivos de mantenimiento se encuentran:
                                    </p>
                                    <p class="pl-5">
                                        1) Evitar, reduclr, y en su caso reparar las allas sobre los bienes e
                                        infraestructura tecnológica del Centro para la Industra de la Comunicación
                                        Gráfica-SENA, Regional Distrito Capital
                                    </p>
                                    <p class="pl-5">
                                        2) Disminuir la gravedad de las fallas que no se logren eviar en la maquinaria
                                    </p>
                                    <p class="pl-5">
                                        3) Evitar que las máquinas paren su producción
                                    </p>
                                    <p class="pl-5">
                                        4) Evitar accidentes de los aprendices, instructores u oro personal de planta o
                                        contratista que opere las máquinas
                                    </p>
                                    <p class="pl-5">
                                        5) Conservar los bienes productivos en condiciones óplimas y seguras de
                                        operación
                                    </p>
                                    <p class="pl-5">
                                        6) Balancear el costo del mantenimiento con el lucro cesante que implicaría la
                                        inoperatividad de la maquinaria y:
                                    </p>
                                    <p class="pl-5">
                                        7) Prolongar su vida útil
                                    </p>
                                    <p class="px-3">
                                        Esta necesidad se determinó de acuerdo a la experticia técnica de los
                                        Instructores de la especialidad de Impresión Digital, liderados por el
                                        instructor Nelson Prieto Díez, Instructor de los
                                        programas de formación Técnicos en impresión digital, técnicos en preprensa
                                        digital y tecnólogos en Supervisión de Procesos Gráficos desde hace 16 años,
                                        Diseñador gráfico con especialización
                                        en Gerencia de Diseño, con experiencia laboral en el sector gráfico de más de 25
                                        años.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center align-items-center minh-100">
                <div class="col-12">
                    <table class="table table-bordered table-responsive mt-2 text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" class="col-1 pb-4">Item</th>
                                <th colspan="6" class="col-5">Máquina</th>
                                <th colspan="1" class="col-2 ">Mantenimiento</th>
                                <th rowspan="4" class="col-1  pb-4">Suministros de repuesto</th>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Placa</th>
                                <th>Serial</th>
                                <th>Cantidad</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_ele_man">
                            <tr>
                                <td id="contador">
                                    1
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" name="nom_maquina"
                                            id="nom_maquina" placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" name="marca" id="marca"
                                            placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="texto" class="form-control form-control-sm" name="modelo"
                                            id="modelo" placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-sm" name="placa"
                                            id="placa" placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-sm" name="serial"
                                            id="serial" placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-sm" name="cantidad"
                                            id="cantidad" placeholder="">
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    // Consulta para obtener los tipos de mantenimiento disponibles
                                    $consulta_tipo = "SELECT id, nombre FROM mantenimiento";
                                    $resultado_tipo = mysqli_query($conexion, $consulta_tipo);

                                    // Generar opciones para los radio botones
                                    while ($fila_tipo = mysqli_fetch_assoc($resultado_tipo)) {
                                        echo "<div class='form-check'>";
                                        echo "<label class='form-check-label' for='radio_mantenimiento_{$fila_tipo['id']}'>";
                                        echo "<input type='radio' class='form-check-input' name='tipo' id='radio_mantenimiento_{$fila_tipo['id']}' value='{$fila_tipo['id']}' required> {$fila_tipo['nombre']}";
                                        echo "</label>";
                                        echo "</div>";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <div class="form-group">
                                        <textarea class="form-control form-control-sm" name="suministro"
                                            id="suministro" style="resize: none;"></textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 mt-1">
                    <table class="table table-bordered mt-4">
                        <thead style="text-align: center;">
                            <th class="col-4">Datos Solicitante</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label>¿Quién solicita?</label>
                                        <input type="hidden" name="id_instructor"
                                            value="<?php echo $_SESSION['id']; ?>">
                                        <input type="text" class="form-control" id="solicitante" name="solicitante"
                                            value="<?php echo $_SESSION['nombre_instructor']; ?>" required
                                            style="text-transform: uppercase;" readonly>

                                        <label>Ambiente:</label>
                                        <select class="form-control" id="ambiente" name="ambiente" required>
                                            <option value="">Seleccionar Ambiente</option>
                                            <?php
                                            $consulta_ambientes = "SELECT id_ambiente, nombre_ambiente FROM ambiente";
                                            $resultado_ambientes = mysqli_query($conexion, $consulta_ambientes);
                                            while ($fila_ambiente = mysqli_fetch_assoc($resultado_ambientes)) {
                                                echo "<option value='{$fila_ambiente['id_ambiente']}'>{$fila_ambiente['nombre_ambiente']}</option>";
                                            }
                                            ?>
                                        </select>

                                        <?php
                                        // Consulta para obtener el nombre del rol
                                        $consulta_nombre_rol = "SELECT nombre FROM rol WHERE id_rol = {$_SESSION['rol']}";
                                        $resultado_nombre_rol = mysqli_query($conexion, $consulta_nombre_rol);

                                        // Verifica si se obtuvieron resultados
                                        if ($resultado_nombre_rol && mysqli_num_rows($resultado_nombre_rol) > 0) {
                                            $fila_nombre_rol = mysqli_fetch_assoc($resultado_nombre_rol);
                                            $nombre_rol = $fila_nombre_rol['nombre'];
                                        } else {
                                            $nombre_rol = "Rol no encontrado";
                                        }
                                        ?>

                                        <label class="mt-2">Cargo del solicitante</label>
                                        <!-- Campo oculto para enviar el ID del rol -->
                                        <input type="hidden" name="id_rol_solicitante"
                                            value="<?php echo $_SESSION['rol']; ?>">
                                        <!-- Campo visible que muestra el nombre del rol -->
                                        <input type="text" class="form-control" id="nombre_rol_solicitante"
                                            name="nombre_rol_solicitante" value="<?php echo $nombre_rol; ?>" required
                                            style="text-transform: uppercase;" readonly>



                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <button class="btn btn-success btn-lg mt-4 float-right" id="enviar">Enviar Informe <i
                            class="bi bi-send"></i></button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>