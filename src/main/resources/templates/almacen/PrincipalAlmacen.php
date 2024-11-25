<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();
Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM elemento";
$resultado_inventario = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" &amp;gt;>
    <!--Sweetalert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_programas_admin.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        .table-responsive {
            margin-top: 20px;
            width: 100%;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .table .btn-accion {
            display: flex;
            justify-content: center;
            gap: 7px;
            /* Ajusta el espacio entre botones */
        }


        .btn-group {
            display: flex;
            justify-content: center;
        }

        .btn-group .btn {
            margin: 0 2px;
        }
    </style>
     <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
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

    <div class="container" id="info">
        <h1>Elementos Consumibles</h1>
        <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoInventario">Subir archivo <i class="bi bi-bookmark-plus"></i></button>
        <div id="archivoInventario" class="collapse">
            <div class="row">
                <div class="col-md-6">
                    <form action="Subir/InsertarInventario.php" method="post" enctype="multipart/form-data">
                        <label>Seleccionar archivo Excel:</label>
                        <input type="file" name="archivo" id="archivo" accept=".xlsx">
                        <br>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                    </form>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#articulo">Agregar Articulo <i class="bi bi-bookmark-plus"></i></button>
        <div id="articulo" class="collapse">
            <div class="row">
                <div class="col-md-6">
                    <form id="formRegistrarinven">
                        <h4>REGISTRAR ELEMENTOS</h4>
                        <label>Código:</label>
                        <input type="text" id="reg_inve_cod" name="reg_inve_cod" class="form-control" placeholder="Ingresar código" required>
                        <label>Nombre:</label>
                        <input type="text" id="reg_inve_nomb" name="reg_inve_nomb" class="form-control" placeholder="Ingresar nombre" style="text-transform: uppercase;" required>
                        <label>Descripción:</label>
                        <textarea class="form-control" id="reg_inve_desc" name="reg_inve_desc" placeholder="Ingresar descripción" style="text-transform: uppercase;" required></textarea>
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" id="reg_inve_cant" name="reg_inve_cant" placeholder="Ingresar cantidad" required>
                        <label>Ambiente:</label>
                        <select class="form-control" id="reg_id_ambiente" name="reg_id_ambiente" required>
                            <option value="">Seleccionar ambiente</option>
                            <?php
                            // Consulta
                            $consulta_ambiente = "SELECT id_ambiente, nombre_ambiente FROM ambiente";
                            $resultado_ambiente = mysqli_query($conexion, $consulta_ambiente);
                            // Generar opciones para el menú desplegable
                            while ($fila_ambiente = mysqli_fetch_assoc($resultado_ambiente)) {
                                echo "<option value='{$fila_ambiente['id_ambiente']}'>{$fila_ambiente['nombre_ambiente']}</option>";
                            }
                            ?>
                        </select>
                        <label>Medida:</label>
                        <select class="form-control" id="reg_inve_medi" name="reg_inve_medi" required>
                            <option value="" disabled selected>Seleccionar Medida</option>
                            <option value="Unidad">UNIDAD</option>
                            <option value="Pliego">PLIEGO</option>
                            <option value="1/2 Pliego">1/2 PLIEGO</option>
                            <option value="Caja">CAJA</option>
                            <option value="Kilo">KILO</option>
                            <option value="Rollo">ROLLO</option>
                            <option value="Lamina">LAMINA</option>
                            <option value="Galón">GALÓN</option>
                            <option value="Paquete">PAQUETE</option>
                            <option value="Metros">METRO</option>
                        </select>
                        <label>Estado:</label>
                        <select class="form-control" id="reg_inve_esta" name="reg_inve_esta" required>
                            <option value="" disabled selected>Seleccionar Estado</option>
                            <option value="Activo">ACTIVO</option>
                            <option value="Inactivo">INACTIVO</option>
                        </select>

                        <button type="submit" class="btn btn-success mt-3 mb-3" id="reg_inventario">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <br>
        <table class="table table-striped table-bordered table-sm" id="tabla_ele">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Medida</th>
                    <th>Ambiente</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="body_inve">
                <?php
                while ($fila = mysqli_fetch_assoc($resultado_inventario)) {
                    echo "<tr>";
                    echo "<td>{$fila['codigo']}</td>";
                    echo "<td>{$fila['nombre']}</td>";
                    echo "<td>{$fila['descripcion']}</td>";
                    echo "<td>{$fila['cantidad']}</td>";
                    echo "<td>{$fila['und_medida']}</td>";
                    $id_ambiente = $fila['ambiente'];
                    $consulta_ambiente = "SELECT nombre_ambiente FROM ambiente WHERE id_ambiente = '$id_ambiente'";
                    $resultado_ambiente = mysqli_query($conexion, $consulta_ambiente);
                    $nombre_ambiente = mysqli_fetch_assoc($resultado_ambiente)['nombre_ambiente'];
                    echo "<td>{$nombre_ambiente}</td>";
                    echo "<td>{$fila['estado']}</td>";
                    echo "<td>";
                    echo "<div class='btn-group'>";
                    echo "<button type='button' class='btn btn-primary actualizar' data-toggle='modal' data-target='#editarinve' 
    data-codigo='{$fila['codigo']}' data-nombre='{$fila['nombre']}' data-descripcion='{$fila['descripcion']}' data-cantidad='{$fila['cantidad']}' data-und_medida='{$fila['und_medida']}' data-estado='{$fila['estado']}'>
    Editar
</button>";
                    echo "<button type='button' class='btn btn-danger eliminar'>
    Eliminar
</button>";
                    echo "</div>";
                    echo "</td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="editarinve" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal Programas-->
            <div class="modal-content">
                <div class="modal-header">
                <h3>EDITAR ELEMENTOS</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h3>Completar todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarinventario">
                            <label>Código:</label>
                            <input type="text" id="edit_cod_inve" name="edit_cod_inve" class="form-control" readonly>
                            <label>Nombre:</label>
                            <input type="text" id="edit_nomb_inve" name="edit_nomb_inve" class="form-control" style="text-transform: uppercase;" required>
                            <label>Descripción:</label>
                            <textarea class="form-control" id="edit_desc_inve" name="edit_desc_inve" style="text-transform: uppercase;" required></textarea>
                            <label>Cantidad:</label>
                            <input type="number" class="form-control" id="edit_canti_inve" name="edit_canti_inve" required>
                            <label>Medida:</label>
                            <select class="form-control" id="edit_medi_inve" name="edit_medi_inve" required>
                                <option value="" disabled>Seleccionar Medida</option>
                                <option value="Unidad">UNIDAD</option>
                                <option value="Pliego">PLIEGO</option>
                                <option value="1/2 Pliego">1/2 PLIEGO</option>
                                <option value="Caja">CAJA</option>
                                <option value="Kilo">KILO</option>
                                <option value="Rollo">ROLLO</option>
                                <option value="Lamina">LAMINA</option>
                                <option value="Galón">GALÓN</option>
                                <option value="Paquete">PAQUETE</option>
                                <option value="Metros">METRO</option>
                            </select>
                            <br>
                            <label>Estado:</label>
                            <select lass="form-control" id="edit_esta_inve" name="edit_esta_inve" required>
                                <option value="" disabled selected>Seleccionar Estado</option>
                                <option value="Activo">ACTIVO</option>
                                <option value="Inactivo">INACTIVO</option>
                            </select>
                            <br>
                            <input type="submit" id='cambios_inve' class="btn btn-success mt-3" value="Realizar cambios">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // DataTable initialization
            $('#tabla_ele').DataTable({
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Buscar:"
                }
            });

            // Función al hacer clic en el botón "Actualizar"
            $(".actualizar").on("click", function() {
                var codigo = $(this).data("codigo");
                var nombre_elemento = $(this).data("nombre");
                var descripcion_elemento = $(this).data("descripcion");
                var cantidad_almacen = $(this).data("cantidad");
                var und_medida = $(this).data("und_medida");
                var estado = $(this).data("estado");

                // Mostrar los datos en el modal de edición
                $("#edit_cod_inve").val(codigo);
                $("#edit_nomb_inve").val(nombre_elemento);
                $("#edit_desc_inve").val(descripcion_elemento);
                $("#edit_canti_inve").val(cantidad_almacen);
                $("#edit_medi_inve").val(und_medida);
                $("#edit_esta_inve").val(estado);

                // Abrir el modal
                $("#editarinve").modal("show");
            });

            // AJAX para actualizar inventario
            $('#formActualizarinventario').on('submit', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'PHP/ActualizarInventario.php', // Ruta al archivo PHP para actualizar inventario
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message,
                            showConfirmButton: true
                        }).then(function() {
                            if (response.status === 'success') {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            showConfirmButton: true
                        });
                    }
                });
            });

            // Función para filtrar la tabla al escribir en el campo de búsqueda
            $("#buscarel").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#body_inve tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // AJAX para registrar inventario
            $('#formRegistrarinven').on('submit', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'PHP/RegistrarInventario.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message,
                            showConfirmButton: true
                        }).then(function() {
                            if (response.status === 'success') {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud',
                            showConfirmButton: true
                        });
                    }
                });
            });

            // Función al hacer clic en el botón "Eliminar"
            $(document).on("click", ".eliminar", function() {
                var codigo = $(this).closest("tr").find("td:first").text(); // Obtener el ID de la ficha desde la primera celda de la misma fila

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
                        $.post("PHP/EliminarPrincipal.php", {
                            codigo: codigo
                        }, function(data) {
                            // Mostrar el mensaje de respuesta del servidor
                            Swal.fire({
                                icon: 'success',
                                title: 'Elemento eliminado correctamente',
                                text: data,
                                showConfirmButton: true
                            }).then(function() {
                                // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                                $('#tabla_ele').DataTable().row($(this).closest('tr')).remove().draw();
                                window.location.reload();
                            });
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>