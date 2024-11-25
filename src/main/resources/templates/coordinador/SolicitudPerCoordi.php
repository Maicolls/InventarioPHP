<?php
include ('../PHP/Funciones.php');
include ('../PHP/Conexion.php');
InicioSesion();

if (isset($_SESSION['nombre_usuario'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];
    if (!isset($_SESSION['alerta_mostrada'])) {
        echo "<script>document.addEventListener('DOMContentLoaded', function(event) { Swal.fire({ icon: 'success', title: '¡Bienvenido, " . $nombreUsuario . "!', text: 'Has iniciado sesión correctamente.' }); });</script>";
        $_SESSION['alerta_mostrada'] = true;
    }
}

Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

// Consulta SQL para seleccionar todos los registros de la tabla solicitud_periodica
$consulta = "
  SELECT 
    sp.*, 
    a.nombre_ambiente AS nombre_ambiente,
    sp.nombre_solici AS nombre_solicitante,
    sp.documento_s AS cedula,
    CASE 
        WHEN sp.firma IS NOT NULL THEN 'Firmado' 
        ELSE 'Sin firmar' 
    END AS estado_aprobacion
FROM 
    solicitud_periodica sp 
INNER JOIN 
    ambiente a ON sp.area = a.id_ambiente;

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

<body>
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
                                    <a href="SolicitudPerCoordi.php" id="btn-nav" class="btn btn-lg">Solicitudes</a>
                                </li>
                                <li class="nav-link">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                            Perfil <i class="bi bi-person-circle"></i></i> </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Coordinador - Jefe</a>
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
                            <th>Firmado</th>
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
                            echo "<td>" . $fila['estado_aprobacion'] . "</td>";
                            echo "<td>";
                            echo '<button type="button" class="btn btn-success btn-sm me-1 btn-ver-detalles" data-id="' . $fila['id'] . '">Ver Detalles <i class="bi bi-file-earmark-ruled"></i></button>';
                            echo "<button type='button' class='btn btn-danger btn-sm ml-1 eliminar'>Eliminar<i class='bi bi-trash3'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
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
                            <form id="solicitud_per">
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
                                        <input type="text" class="form-control" id="nom_regional"
                                            value="Distrito Capital" placeholder="Distrito Capital" readonly>
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
                                                <th class="col-2">Código</th>
                                                <th class="col-3">Descripción</th>
                                                <th class="col-1">Und/Medida</th>
                                                <th class="col-1">Cantidad solicitada</th>
                                                <th class="col-3">Observación</th>
                                            </thead>
                                            <tbody id="body_elemento">
                                                <tr id="elemento_prin_per">
                                                    <td><input class="form-control" type="text" id="codigo" readonly>
                                                    </td>
                                                    <td><input class="form-control" type="text" id="descripcion"
                                                            readonly></td>
                                                    <td><input class="form-control" type="text" id="unidad_medida"
                                                            readonly></td>
                                                    <td><input class="form-control" type="number" id="cantidad"
                                                            readonly></td>
                                                    <td><textarea class="form-control" style="height: 40px;" readonly
                                                            name="observacion" id="observacion"></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-2">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre"
                                            placeholder="Digite el nombre" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="mt-2">Cargo:</label>
                                        <input type="text" class="form-control" id="cargo" required
                                            placeholder="Digite el cargo" readonly>
                                    </div>

                                    <div class="col-6">
                                        <input type="hidden" id="solicitudId" name="solicitudId">
                                        <label class="mt-2">Firma:</label><br>
                                        <div id="imagen_firma"><br></div>
                                        <label>Suba la firma como imagen <font color="red">*</font></label>
                                        <div class="btn btn-secondary">
                                            <label class="form-label text-white m-1" for="subir_firma">Subir firma <i
                                                    class="bi bi-pen"></i></label>
                                            <input type="file" class="form-control d-none" accept="image/*"
                                                id="subir_firma"/>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success btn-lg mt-4 float-right" id="enviar">Informe Aprobado <i
                                    class="bi bi-send"></i></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    <script>
    // Función al hacer clic en el botón "Eliminar"
    $(document).on("click", ".eliminar", function() {
        var solicitudId = $(this).closest("tr").find("td:first").text(); // Obtener el ID de la ficha desde la primera celda de la misma fila

        // Mostrar un mensaje de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la solicitud para eliminar los datos del usuario
                $.post("PHP/EliminarSolicitud.php", {
                    solicitudId: solicitudId // Corrección en la clave del objeto
                }, function(data) {
                    // Mostrar el mensaje de respuesta del servidor
                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitud eliminada correctamente',
                        text: data,
                        showConfirmButton: true
                    }).then(function() {
                        // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                        $('#sol_consu').DataTable().row($(this).closest('tr')).remove().draw();
                        window.location.reload();
                    });
                });
            }
        });
    });
</script>
<script src="../js/CRUD_coordinador.js"></script>
</body>

</html>