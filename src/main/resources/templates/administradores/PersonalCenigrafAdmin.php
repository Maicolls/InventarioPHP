<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();
Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM instructor";
$resultado_personal = mysqli_query($conexion, $consulta);
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../images/logo-de-Sena-sin-fondo-Blanco.png">
    <title>SENA-Gestor de Materiales</title>
    <style>
        /* Aplicar la propiedad white-space: nowrap; a las celdas de la tabla */
        #tabla_inst td {
            white-space: nowrap;
        }
    </style>
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
                                        <!--   <a class="dropdown-item" href="UsuariossAdmin.php" id="btn-nav">Usuarios</a>-->
                                    </div>
                                </div>
                            </li>
                            <li class="nav-link">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-lg dropdown-toggle" data-toggle="dropdown">
                                        Perfil <i class="bi bi-person-circle"></i></i>
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
        <h1>Lista de personal CENIGRAF</h1>
        <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoInst">Subir archivo <i class="bi bi-bookmark-plus"></i></button>
        <div id="archivoInst" class="collapse">
            <div class="row">
                <div class="col-md-6">
                    <form action="Subir/InsertarPersonal.php" method="post" enctype="multipart/form-data">
                        <label>Seleccionar archivo Excel:</label>
                        <input type="file" name="archivo" id="archivo" accept=".xlsx">
                        <br>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                    </form>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#instructor">Agregar Persona <i class="bi bi-bookmark-plus"></i></button>
        <div id="instructor" class="collapse">
            <div class="row">
                <div class="col-md-6">
                    <h4>Registrar personal</h4>
                    <form id="formRegistrarPersonal">
                        <label>Cedula:</label>
                        <input type="number" class="form-control" id="reg_instru_ced" name="reg_instru_ced" placeholder="Ingresar cedula" required>
                        <label>Nombre:</label>
                        <input type="text" class="form-control" id="reg_instru_nomb" name="reg_instru_nomb" placeholder="Ingresar nombre" oninput="this.value = this.value.toUpperCase()" required>
                        <label>Teléfono:</label>
                        <input type="number" class="form-control" id="reg_instru_celu" name="reg_instru_celu" placeholder="Ingresar número telefónico" required>
                        <label>Correo:</label>
                        <input type="email" class="form-control" id="reg_instru_corr" name="reg_instru_corr" placeholder="Ingresar correo " required>
                        <label>Contraseña</label>
                        <input type="password" id="reg_instru_contra" name="reg_instru_contra" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número" required>
                        <label>Rol:</label>
                        <select class="form-control" id="reg_instru_rol" name="reg_instru_rol" required>
                            <option value="">Seleccionar rol</option>
                            <?php
                            // Consulta
                            $consulta_rol = "SELECT id_rol, nombre FROM rol";
                            $resultado_rol = mysqli_query($conexion, $consulta_rol);
                            // Generar opciones para el menú desplegable
                            while ($fila_rol = mysqli_fetch_assoc($resultado_rol)) {
                                echo "<option value='{$fila_rol['id_rol']}'>{$fila_rol['nombre']}</option>";
                            }
                            ?>
                        </select>
                        <label>Cargo:</label>
                        <select class="form-control" id="reg_instru_espe" name="reg_instru_espe" required>
                            <OPtion>Seleccionar</OPtion>
                            <?php
                            $consulta_especialidades = "SELECT * FROM especialidad";
                            $resultado_especialidades = mysqli_query($conexion, $consulta_especialidades);
                            while ($fila_especialidad = mysqli_fetch_assoc($resultado_especialidades)) {
                                echo "<option value='{$fila_especialidad['id']}'>{$fila_especialidad['nombre_especialidad']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Registrar" id="reg_personal">
                    </form>

                </div>
            </div>
        </div>
        <br>
        <table class="table table-striped table-bordered" id="tabla_inst">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Especialidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="body_inst">
                <?php
                while ($fila = mysqli_fetch_assoc($resultado_personal)) {
                    echo "<td>{$fila['id']}</td>";
                    echo "<td>{$fila['cedula']}</td>";
                    echo "<td>{$fila['nombre_instructor']}</td>";
                    echo "<td>{$fila['celular']}</td>";
                    echo "<td>{$fila['correo']}</td>";
                    echo "<td>********</td>"; // Aquí reemplaza la contraseña por asteriscos u otro texto
                    $id_rol = $fila['rol'];
                    $consulta_rol = "SELECT nombre FROM rol WHERE id_rol = '$id_rol'";
                    $resultado_rol = mysqli_query($conexion, $consulta_rol);
                    $nombre_rol = mysqli_fetch_assoc($resultado_rol)['nombre'];
                    echo "<td>{$nombre_rol}</td>";
                    // Consultar el nombre de la especialidad
                    $id_especialidad = $fila['especialidad'];
                    $consulta_especialidad = "SELECT nombre_especialidad FROM especialidad WHERE id = '$id_especialidad'";
                    $resultado_especialidad = mysqli_query($conexion, $consulta_especialidad);
                    if ($resultado_especialidad && mysqli_num_rows($resultado_especialidad) > 0) {
                        $nombre_especialidad = mysqli_fetch_assoc($resultado_especialidad)['nombre_especialidad'];
                        echo "<td>{$nombre_especialidad}</td>";
                    } else {
                        echo "<td>No se encontró la especialidad</td>";
                    }
                    echo "<td>";
                    echo "<button type='button' class='btn btn-primary mr-2 actualizar' data-toggle='modal' data-target='#editari' 
                    data-id='{$fila['id']}' data-cedula='{$fila['cedula']}' data-nombre_instructor='{$fila['nombre_instructor']}' data-celular='{$fila['celular']}' data-correo='{$fila['correo']}'  data-contrasena='{$fila['contrasena']}' data-rol='{$fila['rol']} data-especialidad='{$fila['especialidad']}'>
                    Editar
                </button>
                ";
                    echo "<button type='button' class='btn btn-danger eliminar'>Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="editari" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal Programas-->
            <div class="modal-content">
                <div class="modal-header">
                <h3>EDITAR USUARIO</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   
                </div>
                <div class="modal-body">
                    <h3>Completar todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarPersonal" >
                            <input type="hiden" id="id" name="id" class="form-control" readonly>
                            <label>Cedula</label>
                            <input type="text" id="edit_ced_inst" name="edit_ced_inst" class="form-control" required>
                            <label>Nombre</label>
                            <input type="text" id="edit_nom_inst" name="edit_nom_inst" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                            <label>Teléfono</label>
                            <input type="number" id="edit_tele_inst" name="edit_tele_inst" class="form-control" required>
                            <label>Correo</label>
                            <input type="text" id="edit_corr_inst" name="edit_corr_inst" class="form-control" required>
                            <label>Contraseña</label>
                            <input type="password" id="edit_contra_inst" name="edit_contra_inst" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número" required>
                            <label>Rol</label>
                            <select class="form-control" id="edit_rol_inst" name="edit_rol_inst" required>
                                <option value="">Seleccionar rol</option>
                                <?php
                                // Consulta
                                $consulta_rol = "SELECT id_rol, nombre FROM rol";
                                $resultado_rol = mysqli_query($conexion, $consulta_rol);

                                // Generar opciones para el menú desplegable
                                while ($fila_rol = mysqli_fetch_assoc($resultado_rol)) {
                                    echo "<option value='{$fila_rol['id_rol']}'>{$fila_rol['nombre']}</option>";
                                }
                                ?>
                            </select>
                            <label>Especialidad:</label>
                            <select class="form-control" id="edit_instru_espe" name="edit_instru_espe" required>
                                <?php
                                $consulta_especialidades = "SELECT * FROM especialidad";
                                $resultado_especialidades = mysqli_query($conexion, $consulta_especialidades);
                                while ($fila_especialidad = mysqli_fetch_assoc($resultado_especialidades)) {
                                    echo "<option value='{$fila_especialidad['id']}'>{$fila_especialidad['nombre_especialidad']}</option>";
                                }
                                ?>
                            </select>

                            <input type="submit" id="cambios_pers" class="btn btn-success mt-3" value="Realizar cambios">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/CRUD_personal.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // DataTable initialization
            $('#tabla_inst').DataTable({
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Buscar"
                }
            });
 // Función al hacer clic en el botón "Actualizar"
 $(".actualizar").on("click", function() {
                var id = $(this).data("id");
                var cedula = $(this).data("cedula");
                var nombre_instructor = $(this).data("nombre_instructor");
                var celular = $(this).data("celular");
                var correo = $(this).data("correo");
                var contrasena = $(this).data("contrasena");
                var rol = $(this).data("rol");
                var especialidad = $(this).data("especialidad");

                // Mostrar los datos en el modal de edición
                $("#id").val(id);
                $("#edit_ced_inst").val(cedula);
                $("#edit_nom_inst").val(nombre_instructor);
                $("#edit_tele_inst").val(celular);
                $("#edit_corr_inst").val(correo);
                $("#edit_contra_inst").val(contrasena);
                $("#edit_rol_inst").val(rol);
                $("#edit_espe_inst").val(especialidad);
            });

            // Abrir el modal
            $("#editari").modal("show");
        });

// AJAX para actualizar personal
$('#formActualizarPersonal').on('submit', function(e) {
    e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: 'PHP/ActualizarPersonal.php', // Ruta al archivo PHP para actualizar programa
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
          $("#buscador_inst").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tabla_inst tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

        // AJAX para registrar programa
        $('#formRegistrarPersonal').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/RegistrarPersonal.php', // Cambia esta ruta según corresponda
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
            var id = $(this).closest("tr").find("td:first").text(); // Obtener el ID del personal desde la primera celda de la misma fila

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
                    $.post("PHP/EliminarPersonal.php", {
                        id: id
                    }, function(data) {
                        // Mostrar el mensaje de respuesta del servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario eliminado correctamente',
                            text: data,
                            showConfirmButton: true
                        }).then(function() {
                            // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                            $('#tabla_inst').DataTable().row($(this).closest('tr')).remove().draw();
                            window.location.reload();
                        });
                    });
                }
            });
        });
</script>
        
</body>

</html>