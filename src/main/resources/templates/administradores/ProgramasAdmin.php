<?php
include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();
Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM programa";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <title>SENA-Gestor de Materiales</title>
</head>
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
                                        <a class="dropdown-item" href="PersonalCenigrafAdmin.php" id="btn-nav">Personal
                                            CENIGRAF</a>
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
                <h1>Lista de programas</h1>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoProg">Subir archivo
                    <i class="bi bi-bookmark-plus"></i></button>
                <div id="archivoProg" class="collapse">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="Subir/InsertarPrograma.php" method="post" enctype="multipart/form-data">
                                <label>Seleccionar archivo Excel:</label>
                                <input type="file" name="archivo" id="archivo" accept=".xlsx">
                                <br>
                                <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                            </form>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#programa">Agregar programa
                    <i class="bi bi-bookmark-plus"></i></button>
                <div id="programa" class="collapse">
                    <h4>Complete todos los campos</h4>
                    <form id="formRegistrarPrograma">

                        <label>Nombre del Programa:</label>
                        <input type="text" class="form-control" id="reg_prog_nomb" name="reg_prog_nomb" placeholder="Ingresar nombre" required>
                        <label>Nombre del instructor:</label>
                        <select class="form-control" id="reg_nom_inst" name="reg_nom_inst" required>
                            <option value="">Seleccionar Instructor</option>
                            <?php
                            // Consulta para obtener los instructores disponibles
                            $consulta_instructores = "SELECT id, nombre_instructor FROM instructor";
                            $resultado_instructores = mysqli_query($conexion, $consulta_instructores);

                            // Generar opciones para el menú desplegable
                            while ($fila_instructor = mysqli_fetch_assoc($resultado_instructores)) {
                                echo "<option value='{$fila_instructor['id']}'>{$fila_instructor['nombre_instructor']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Registrar" id="reg_programas">
                    </form>

                </div>
                <table class="table table-striped table-bordered" id="tabla_prog">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Instructor</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="body_prog">
                        <?php
                        while ($fila = mysqli_fetch_assoc($resultado_programa)) {
                            echo "<tr>";
                            echo "<td>{$fila['id_programa']}</td>";
                            echo "<td>{$fila['nombre_programa']}</td>";
                            $id = $fila['id_instructor'];
                            $consulta_instructor = "SELECT nombre_instructor FROM instructor WHERE id = '$id'";
                            $resultado_instructor = mysqli_query($conexion, $consulta_instructor);
                            $nombre_instructor = mysqli_fetch_assoc($resultado_instructor)['nombre_instructor'];
                            echo "<td>{$nombre_instructor}</td>";
                            echo "<td>";
                            echo "<button type='button' class='btn btn-primary mr-2 actualizar' data-toggle='modal' data-target='#editarp' 
                            data-id_programa='{$fila['id_programa']}' data-nombre_programa='{$fila['nombre_programa']}' data-id='{$fila['id_instructor']}'>
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

    <!-- Modales -->
    <div id="editarp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal Programas-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h3>Completar todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarPrograma">
                            <label>ID Programa</label>
                            <input type="number" id="edit_id_prog" name="edit_id_prog" class="form-control" readonly>
                            <label>Nombre Programa</label>
                            <input type="text" id="edit_nomb_prog" name="edit_nomb_prog" class="form-control" style="text-transform: uppercase;" required>
                            <label>Instructor</label>
                            <select id="edit_id_inst" name="edit_id_inst" class="form-control" style="text-transform: uppercase;" required>
                                <option value="">Seleccionar Instructor</option>
                                <?php
                                // Consulta para obtener los instructores disponibles
                                $consulta_instructores = "SELECT id, nombre_instructor FROM instructor";
                                $resultado_instructores = mysqli_query($conexion, $consulta_instructores);

                                // Generar opciones para el menú desplegable
                                while ($fila_instructor = mysqli_fetch_assoc($resultado_instructores)) {
                                    echo "<option value='{$fila_instructor['id']}'>{$fila_instructor['nombre_instructor']}</option>";
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


    <!--JQuery y js-->
    <script src="../js/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar DataTables
        $('#tabla_prog').DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });

        // Función al hacer clic en el botón "Actualizar"
        $(".actualizar").on("click", function() {
            var id_programa = $(this).data("id_programa");
            var nombre_programa = $(this).data("nombre_programa");
            var id_instructor = $(this).data("id_instructor");

            // Mostrar los datos en el modal
            $("#edit_id_prog").val(id_programa);
            $("#edit_nomb_prog").val(nombre_programa);
            $("#edit_id_inst").val(id_instructor);

            // Abrir el modal
            $("#editarp").modal("show");
        });

        // AJAX para actualizar programa
        $('#formActualizarPrograma').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/ActualizarPrograma.php', // Ruta al archivo PHP para actualizar programa
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
        $("#buscador_programa").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#body_prog tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // AJAX para registrar programa
        $('#formRegistrarPrograma').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/RegistrarPrograma.php', // Cambia esta ruta según corresponda
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
            var idPrograma = $(this).closest("tr").find("td:first").text(); // Obtener el ID del programa desde la primera celda de la misma fila

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
                    $.post("PHP/EliminarPrograma.php", {
                        id_programa: idPrograma
                    }, function(data) {
                        // Mostrar el mensaje de respuesta del servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Programa eliminado correctamente',
                            text: data,
                            showConfirmButton: true
                        }).then(function() {
                            // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                            $('#tabla_prog').DataTable().row($(this).closest('tr')).remove().draw();
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