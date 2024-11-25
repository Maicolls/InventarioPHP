<?php

include ('../PHP/Funciones.php');
include ('../PHP/Conexion.php');

InicioSesion();
Inactividad(700);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta SQL para seleccionar todos los registros de la tabla solicitud_periodica
$consulta = "
   SELECT  sp.*, 
    a.nombre_ambiente AS nombre_ambiente,
    sp.nombre_solici AS nombre_solicitante,
    sp.documento_s AS cedula,
          CASE 
              WHEN sp.firma IS NOT NULL THEN 'Aprobado' 
              ELSE 'Sin aprobar' 
          END AS estado_aprobacion,
          (SELECT SUM(e.cantidad) 
           FROM elemento e 
           INNER JOIN elementos_solicitud_periodica esp ON e.id_elemento = esp.id_elemento 
           WHERE esp.id_solicitud = sp.id) AS cantidad_elementos
   FROM solicitud_periodica sp 
   INNER JOIN ambiente a ON sp.area = a.id_ambiente
";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_coordinador_principal.css">
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <title>SENA-Gestor de Materiales</title>
</head>
<!--Barra de navegación-->
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <img src="../images/logo_cenigraf.png" alt="cenigraf logo" width="300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <nav class="navigation navbar navbar-expand-md navbar-dark mr-auto">
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-expand">
                            <li class="nav-link">
                                <a href="SolicitudPerAlmacen.php" id="btn-nav" class="btn btn-lg">Solicitudes</a>
                            </li>
                            <li class="nav-link">
                                <a href="PrincipalAlmacen.php" id="btn-nav" class="btn btn-lg">Consumibles</a>
                            </li>
                            <li class="nav-link">
                                <a class="btn btn-lg" href="MaquinasAlmacen.php" id="btn-nav">Máquinas</a>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                        Perfil <i class="bi bi-person-circle"></i></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">Almacen</a>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-4" style="padding-bottom: 45px;">Solicitud de consumibles - Personal CENIGRAF
                </h1>
                <table class="table table-striped table-bordered" id="sol_consu">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre Solicitante</th>
                            <th>Cédula</th>
                            <th>Fecha de Solicitud</th>
                            <th>Estado de Aprobación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $fila['id'] . "</td>";
                            echo "<td>" . $fila['nombre_solicitante'] . "</td>";
                            echo "<td>" . $fila['cedula'] . "</td>";
                            echo "<td>" . $fila['fecha_soli'] . "</td>";
                            echo "<td class='estado-aprobacion'>" . $fila['estado_aprobacion'] . "</td>";
                            echo "<td>";
                            echo '<button type="button" class="btn btn-primary btn-sm me-1 btn-ver-detalles" data-id="' . $fila['id'] . '" data-estado="' . $fila['estado_aprobacion'] . '">Ver Detalles <i class="bi bi-file-earmark-ruled"></i></button>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="verdetalles">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title px-3 py-3">Detalles Solicitud del Personal</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="form-actualizar-cantidad" action="PHP/actualizarSolicitud.php" method="POST">
                            <div class="row p-4">
                                <div class="form-group col-6">
                                    <label>Fecha de Solicitud:</label>
                                    <input class="form-control" id="f_solicitud" readonly>
                                    <label class="mt-2">Código Regional:</label>
                                    <input type="text" class="form-control" id="cod_regional" value="9217"
                                        placeholder="9217" readonly>
                                    <label class="mt-2">Código de Costos:</label>
                                    <input type="text" class="form-control" id="cod_costos" value="921710"
                                        placeholder="921710" readonly>
                                    <label class="mt-2">Nombre del jefe de oficina o coordinador del área:</label>
                                    <input type="text" class="form-control" id="nombre_coor" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label>Área:</label>
                                    <input type="text" class="form-control" id="area_solicitud" readonly>
                                    <label class="mt-2">Nombre Regional:</label>
                                    <input type="text" class="form-control" id="nom_regional" value="Distrito Capital"
                                        placeholder="Distrito Capital" readonly>
                                    <label class="mt-2">Nombre Centro de Costos:</label>
                                    <input type="text" class="form-control" id="nom_centro_costos" value="CENIGRAF"
                                        placeholder="CENIGRAF" readonly>
                                </div>
                                <div class="form-group col-6 pt-0">
                                    <label>Tipo de cuentadante:</label>
                                    <input type="text" class="form-control" id="tipo_cuenta" readonly>
                                </div>
                                <div class="col-6 pt-0"></div>
                                <div class="col-6">
                                    <label>Nombre cuentadante 1:</label>
                                    <input type="text" class="form-control" id="nom_cuenta_uno" readonly>
                                    <label class="mt-2">Nombre cuentadante 2:</label>
                                    <input type="text" class="form-control" id="nom_cuenta_dos" readonly>
                                    <label class="mt-2">Nombre cuentadante 3:</label>
                                    <input type="text" class="form-control" id="nom_cuenta_tres" readonly>
                                </div>
                                <div class="col-6">
                                    <label>Documento cuentadante 1:</label>
                                    <input type="number" class="form-control" id="doc_cuenta_uno" readonly>
                                    <label class="mt-2">Documento cuentadante 2:</label>

                                    <input type="number" class="form-control" id="doc_cuenta_dos" readonly>
                                    <label class="mt-2">Documento cuentadante 3:</label>
                                    <input type="number" class="form-control" id="doc_cuenta_tres" readonly>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">Destino de los bienes:</label>
                                    <input type="text" class="form-control" id="destino" readonly>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">Código de grupo o número de ficha:</label>
                                    <input type="text" class="form-control" name="ficha" id="ficha" readonly>
                                </div>
                                <div class="col-12">
                                    <table class="table table-bordered mt-4" id="tabla_ele_per">
                                        <thead>
                                            <tr>
                                                <th class="col-2">Código</th>
                                                <th class="col-3">Descripción</th>
                                                <th class="col-1">Und/Medida</th>
                                                <th class="col-1">Cantidad actual</th>
                                                <th class="col-1">Cantidad solicitada</th>
                                                <th class="col-1">Cantidad entregada</th>
                                                <th class="col-3">Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_elemento">
                                            <tr id="elemento_prin_per" data-estado-aprobacion="Aprobado">
                                                <td><input class="form-control" type="text" id="codigo" readonly></td>
                                                <td><input class="form-control" type="text" id="descripcion" readonly>
                                                </td>
                                                <td><input class="form-control" type="text" id="unidad_medida" readonly>
                                                </td>
                                                <td><input class="form-control" type="number" name="cantidad"
                                                        id="cantidad" readonly></td>
                                                <td><input class="form-control" type="number" id="cantidad_solicitada" name="cantidad_solicitada"
                                                        readonly></td>
                                                <td><input class="form-control" type="number" name="cantidadE"
                                                        id="cantidadE" required></td>
                                                <td><textarea class="form-control" style="height: 40px;" readonly
                                                        name="observacion" id="observacion"></textarea></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Digite el nombre"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <label class="mt-2">Cargo:</label>
                                    <input type="text" class="form-control" id="cargo" required
                                        placeholder="Digite el cargo" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="mt-2">Firma:</label><br>
                                    <div id="imagen_firma"></div>

                                    <input type="hidden" id="solicitudId" name="solicitudId">
                                <button class="btn btn-success btn-lg mt-6 float-right" id="enviar">Enviar
                                        Informe <i class="bi bi-send"></i></button>
                                </div>
                                
                               
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/CRUD_almacen.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Añadir un event listener a todos los botones "Ver Detalles"
                const detalleButtons = document.querySelectorAll('.btn-ver-detalles');

                detalleButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        // Obtener el estado de aprobación desde el atributo data-estado del botón
                        const estadoAprobacion = button.getAttribute('data-estado');

                        // Actualizar el campo cantidadE basado en el estado de aprobación
                        const cantidadEField = document.querySelector('#cantidadE');
                        if (estadoAprobacion === 'Aprobado') {
                            cantidadEField.removeAttribute('readonly');
                        } else {
                            cantidadEField.setAttribute('readonly', 'readonly');
                        }

                    });
                });
            });


        </script>

</body>

</html>