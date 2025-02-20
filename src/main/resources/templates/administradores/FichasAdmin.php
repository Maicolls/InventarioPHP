<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();
Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM ficha";
$resultado_programa = mysqli_query($conexion, $consulta);

?>

<!DOCTYPE html>
<html lang="en">

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
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">Formación y Ambientes</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="ProgramasAdmin.php" id="btn-nav">Programas</a>
                                        <a class="dropdown-item" href="FichasAdmin.php" id="btn-nav">Fichas</a>
                                        <a class="dropdown-item" href="AmbientesAdmin.php" id="btn-nav">Ambientes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">Personal</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="PersonalCenigrafAdmin.php" id="btn-nav">Personal CENIGRAF</a>
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
                <h1>Lista de fichas</h1>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoFich">Subir archivo <i class="bi bi-bookmark-plus"></i></button>
                <div id="archivoFich" class="collapse">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="Subir/InsertarFicha.php" method="post" enctype="multipart/form-data">
                                <label>Seleccionar archivo Excel:</label>
                                <input type="file" name="archivo" id="archivo" accept=".xlsx">
                                <br>
                                <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                            </form>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#ficha">Agregar ficha <i class="bi bi-bookmark-plus"></i></button>
                <div id="ficha" class="collapse">
                    <h4>Registrar ficha</h4>
                    <form id="formRegistrarFicha">
                        <label>Número de Ficha:</label>
                        <input type="text" class="form-control" id="reg_fic_num" name="reg_fic_num" placeholder="Ingresar Número" required>
                        <label>Programa:</label>
                        <select class="form-control" id="reg_prog_id" name="reg_prog_id" required>
                            <option value="">Seleccionar Programa</option>
                            <?php
                            $consulta_programas = "SELECT * FROM programa";
                            $resultado_programas = mysqli_query($conexion, $consulta_programas);
                            while ($fila_programa = mysqli_fetch_assoc($resultado_programas)) {
                                echo "<option value='{$fila_programa['id_programa']}'>{$fila_programa['nombre_programa']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Registrar" id="reg_ficha">
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tabla_fichas">
                        <thead class="text-center">
                            <tr>
                                <th>Número de Ficha</th>
                                <th>Programa</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="body_fich">
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado_programa)) {
                                echo "<tr>";
                                echo "<td>{$fila['numero_ficha']}</td>";
                                $id_programa = $fila['id_programa'];
                                $consulta_programa = "SELECT nombre_programa FROM programa WHERE id_programa = '$id_programa'";
                                $resultado_programa_nombre = mysqli_query($conexion, $consulta_programa);
                                $nombre_programa = mysqli_fetch_assoc($resultado_programa_nombre)['nombre_programa'];
                                echo "<td>{$nombre_programa}</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary mr-2 actualizar' data-toggle='modal' data-target='#editarf' 
                                          data-numero_ficha='{$fila['numero_ficha']}'  data-id_programa='{$fila['id_programa']}'>
                                          Editar
                                          </button>";
                                echo "<button type='button' class='btn btn-danger eliminar'>
                                          Eliminar
                                          </button>";
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

    <div id="editarf" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Ficha</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h3>Complete todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarFicha">
                            <label>Número de Ficha</label>
                            <input type="number" id="edit_num_fich" name="edit_num_fich" class="form-control" readonly>
                            <label>Programa</label>
                            <select class="form-control" id="edit_id_prog" name="edit_id_prog" required>
                                <option value="">Seleccionar Programa</option>
                                <?php
                                $consulta_programas = "SELECT * FROM programa";
                                $resultado_programas = mysqli_query($conexion, $consulta_programas);

                                while ($fila_programa = mysqli_fetch_assoc($resultado_programas)) {
                                    echo "<option value='{$fila_programa['id_programa']}'>{$fila_programa['nombre_programa']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" id='cambios_fich' class="btn btn-success mt-3" value="Realizar cambios">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
            // Inicializar DataTables
            $('#tabla_fichas').DataTable({
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                }
            });
// Función al hacer clic en el botón "Actualizar"
$(".actualizar").on("click", function() {
                var numero_ficha = $(this).data("numero_ficha");
                var id_programa = $(this).data("id_programa");

                // Mostrar los datos en el modal
                $("#edit_num_fich").val(numero_ficha);
                $("#edit_id_prog").val(id_programa);

                // Abrir el modal
            $("#editarf").modal("show");
        });

        // AJAX para actualizar programa
        $('#formActualizarFicha').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/ActualizarFicha.php', // Ruta al archivo PHP para actualizar programa
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
        $("#buscador_ficha").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#body_fich tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // AJAX para registrar ficha
        $('#formRegistrarFicha').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/RegistrarFicha.php',
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
            var numero_ficha = $(this).closest("tr").find("td:first").text(); // Obtener el ID del programa desde la primera celda de la misma fila

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
                    $.post("PHP/EliminarFicha.php", {
                        numero_ficha: numero_ficha
                    }, function(data) {
                        // Mostrar el mensaje de respuesta del servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Ficha eliminada correctamente',
                            text: data,
                            showConfirmButton: true
                        }).then(function() {
                            // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                            $('#tabla_fichas').DataTable().row($(this).closest('tr')).remove().draw();
                            window.location.reload();
                        });
                    });
                }
            });
        });
    });
</script>
   

    <script src="../js/CRUD_ficha.js"></script>
    <script src="../js/CRUD_programa.js"></script>
</body>

</html>