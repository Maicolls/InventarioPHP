<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();
Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM ambiente";
$resultado_ambientes = mysqli_query($conexion, $consulta);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Sweetalert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_programas_admin.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Extenciones Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
       <!-- Favicon -->
       <link rel="icon" type="image/x-icon" href="../images/logo-de-Sena-sin-fondo-Blanco.png">
    <title>SENA-Gestor de Materiales</title>

</head>
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <a href="PrincipalAdmin.php"><img src="../images/logo_cenigraf.png" alt="cenigraf logo" width="300px"></a>
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
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">Formación y Ambientes </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="ProgramasAdmin.php" id="btn-nav">Programas</a>
                                        <a class="dropdown-item" href="FichasAdmin.php" id="btn-nav">Fichas</a>
                                        <a class="dropdown-item" href="AmbientesAdmin.php" id="btn-nav">Ambientes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">Personal </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="PersonalCenigrafAdmin.php" id="btn-nav">Personal CENIGRAF</a>
                                        <!--  <a class="dropdown-item" href="UsuariossAdmin.php" id="btn-nav">Usuarios</a>-->
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                        Perfil <i class="bi bi-person-circle"></i>
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
    <div class="container" id="info">
        <div class="row">
            <div class="col-md-12">
                <h1>Lista de ambientes</h1>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoAmbi">Subir archivo <i class="bi bi-bookmark-plus"></i></button>
                <div id="archivoAmbi" class="collapse">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="Subir/InsertarAmbiente.php" method="post" enctype="multipart/form-data">
                                <label>Seleccionar archivo Excel:</label>
                                <input type="file" name="archivo" id="archivo" accept=".xlsx">
                                <br>
                                <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                            </form>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#ficha">Agregar ambiente <i class="bi bi-bookmark-plus"></i></button>
                <div id="ficha" class="collapse">
                    <h4>Registrar ambiente</h4>
                    <form id="formRegistrarAmbientes">
                        <label>Nombre del ambiente:</label>
                        <input type="text" class="form-control" id="reg_ambi_nomb" name="reg_ambi_nomb" placeholder="Ingresar nombre" required style="text-transform: uppercase;">
                        <label>Descripción del ambiente:</label>
                        <input type="text" class="form-control" id="reg_ambi_desc" name="reg_ambi_desc" placeholder="Ingresar descripción" required style="text-transform: uppercase;">
                        <label for="reg_nom_inst">Area al que pertenece:</label>
                        <select class="form-control" id="reg_nom_area" name="reg_nom_area" required>
                            <option value="">Seleccionar Area</option>
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
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Registrar" id="reg_ambientes">
                    </form>
                </div>

                <div class="table-responsive">
    <table class="table table-striped table-bordered" id="tabla_ambi">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Área</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($fila = mysqli_fetch_assoc($resultado_ambientes)) {
                echo "<tr>";
                echo "<td>{$fila['id_ambiente']}</td>";
                echo "<td>{$fila['nombre_ambiente']}</td>";
                echo "<td>{$fila['descripcion']}</td>";
                $id_area = $fila['id_area'];
                $consulta_area = "SELECT nombre FROM area WHERE id = '$id_area'";
                $resultado_area = mysqli_query($conexion, $consulta_area);
                $nombre_area = mysqli_fetch_assoc($resultado_area)['nombre'];
                echo "<td>{$nombre_area}</td>";
                echo "<td>";
                echo "<div class='d-flex justify-content-center align-items-center'>";
                echo "<button type='button' class='btn btn-primary mr-2 actualizar' data-toggle='modal' data-target='#editara' 
                        data-id_ambiente='{$fila['id_ambiente']}' data-nombre_ambiente='{$fila['nombre_ambiente']}' data-descripcion='{$fila['descripcion']}' data-id_area='{$fila['id_area']}'>
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

            </div>
        </div>
    </div>

    <!-- Modal for editing ambientes -->
    <div id="editara" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR AMBIENTE</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h3>Complete todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarAmbiente">
                            <label>ID Ambiente</label>
                            <input type="number" id="edit_id_amb" name="edit_id_amb" class="form-control" readonly>
                            <label>Nombre del Ambiente</label>
                            <input type="text" id="edit_nomb_amb" name="edit_nomb_amb" class="form-control" required style="text-transform: uppercase;">
                            <label>Descripción del Ambiente</label>
                            <input type="text" id="edit_desc_amb" name="edit_desc_amb" class="form-control" required style="text-transform: uppercase;">
                            <label>Area</label>
                            <select id="edit_area_id" name="edit_area_id" class="form-control" required>
                                <option value="">Seleccionar Area</option>
                                <?php
                                $consulta_area = "SELECT id, nombre FROM area";
                                $resultado_area = mysqli_query($conexion, $consulta_area);
                                while ($fila_area = mysqli_fetch_assoc($resultado_area)) {
                                    echo "<option value='{$fila_area['id']}'>{$fila_area['nombre']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" id='cambios_amb' class="btn btn-success mt-3" value="Realizar cambios">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
            // DataTable initialization
            $('#tabla_ambi').DataTable({
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Buscar:"
                }
            });
            // Función al hacer clic en el botón "Actualizar"
             $(".actualizar").on("click", function() {
                var id_ambiente = $(this).data("id_ambiente");
                var nombre_ambiente = $(this).data("nombre_ambiente");
                var descripcion = $(this).data("descripcion");
                var id_area = $(this).data("id_area");

                // Set data to modal inputs
                $("#edit_id_amb").val(id_ambiente);
                $("#edit_nomb_amb").val(nombre_ambiente);
                $("#edit_desc_amb").val(descripcion);
                $("#edit_area_id").val(id_area);

                // Abrir el modal
            $("#editara").modal("show");
        });

        // AJAX para actualizar programa
        $('#formActualizarAmbiente').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/ActualizarAmbiente.php', // Ruta al archivo PHP para actualizar programa
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
        $("#buscador_ambiente").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#body_ambi tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // AJAX para registrar ambiente
        $('#formRegistrarAmbientes').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/RegistrarAmbiente.php',
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
            var id_ambiente = $(this).closest("tr").find("td:first").text(); // Obtener el ID de la ficha desde la primera celda de la misma fila

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
                    $.post("PHP/EliminarAmbiente.php", {
                        id_ambiente: id_ambiente
                    }, function(data) {
                        // Mostrar el mensaje de respuesta del servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Ambiente eliminado correctamente',
                            text: data,
                            showConfirmButton: true
                        }).then(function() {
                            // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                            $('#tabla_ambi').DataTable().row($(this).closest('tr')).remove().draw();
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