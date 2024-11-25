<?php

include('../PHP/Funciones.php');
include('../PHP/Conexion.php');

InicioSesion();

// Verifica si hay una sesión y si el nombre de usuario está establecido
if (isset($_SESSION['nombre_usuario'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];
    echo "<script>document.addEventListener('DOMContentLoaded', function(event) { 
        Swal.fire({
            icon: 'success',
            title: '¡Bienvenido, " . $nombreUsuario . "!',
            text: 'Has iniciado sesión correctamente.'
        });
    });</script>";
    // Limpia la variable de sesión después de mostrarla
    unset($_SESSION['nombre_usuario']);
}

Inactividad(600);
if (isset($_GET['cerrar_sesion'])) {
    cerrarSesion();
}

$consulta = "SELECT * FROM maquina";
$resultado_maquina = mysqli_query($conexion, $consulta);
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

        header .logo_section img {
            max-width: 100%;
        }

        @media (min-width: 992px) {
            .nav-link .btn {
                font-size: 1.2em;
            }
        }

        #info {
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>SENA-Gestor de Materiales</title>
</head>
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
        <div class="row">
            <div class="col-12">
                <h1>Lista de máquinas</h1>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#archivoMaqu">Subir archivo <i class="bi bi-bookmark-plus"></i></button>
                <div id="archivoMaqu" class="collapse">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="Subir/InsertarMaquina.php" method="post" enctype="multipart/form-data">
                                <label>Seleccionar archivo Excel:</label>
                                <input type="file" name="archivo" id="archivo" accept=".xlsx">
                                <br>
                                <input type="submit" class="btn btn-success mt-3 mb-3" value="Subir" id="agrArchivo">
                            </form>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#maquina">Agregar máquina <i class="bi bi-bookmark-plus"></i></button>
                <div id="maquina" class="collapse">
                    <form id="formRegistrarMaquina">
                        <h4>Registrar máquina</h4>
                        <label>Serial:</label>
                        <input type="text" class="form-control mb-2" id="reg_seri_maqu" name="reg_seri_maqu" placeholder="Ingresar serial" required>
                        <label>Nombre Maquina:</label>
                        <input type="text" class="form-control mb-2" id="reg_nomb_maqu" name="reg_nomb_maqu" placeholder="Ingresar nombre" style="text-transform: uppercase;" required>
                        <label>Modelo Maquina:</label>
                        <input type="text" class="form-control mb-2" id="reg_model_maqu" name="reg_model_maqu" placeholder="Ingresar modelo"  style="text-transform: uppercase;" requiredrequired>
                        <label>Marca Maquina:</label>
                        <input type="text" class="form-control mb-2" id="reg_marc_maqu" name="reg_marc_maqu" placeholder="Ingresar marca"  style="text-transform: uppercase;" requiredrequired>
                        <label>Placa Maquina:</label>
                        <input type="text" class="form-control mb-2" id="reg_plac_maqu" name="reg_plac_maqu" placeholder="Ingresar placa"  style="text-transform: uppercase;" requiredrequired>
                        <label>Adquisición de la máquina:</label>
                        <input type="date" class="form-control mb-2" id="reg_fech_maqu" name="reg_fech_maqu" required>
                        <label>Cantidad</label>
                        <input type="number" class="form-control" id="reg_cant_maqu" name="reg_cant_maqu" required>
                        <label>Ambiente:</label>
                        <select class="form-control" id="reg_nom_ambi" name="reg_nom_ambi" required>
                            <option value="">Seleccionar Ambiente</option>
                            <?php
                            $consulta_ambientes = "SELECT id_ambiente, nombre_ambiente FROM ambiente";
                            $resultado_ambientes = mysqli_query($conexion, $consulta_ambientes);
                            while ($fila_ambiente = mysqli_fetch_assoc($resultado_ambientes)) {
                                echo "<option value='{$fila_ambiente['id_ambiente']}'>{$fila_ambiente['nombre_ambiente']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" class="btn btn-success mt-3 mb-3" value="Registrar" id="reg_maquina">
                    </form>
                </div>

                <table class="table table-striped table-bordered table-sm" id="tabla_maqu">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Nombre</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Fecha adquisición</th>
                            <th>Cantidad</th>
                            <th>Ambiente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="body_maqu">
                        <?php
                        while ($fila = mysqli_fetch_assoc($resultado_maquina)) {
                            echo "<tr>";
                            echo "<td>{$fila['serial']}</td>";
                            echo "<td>{$fila['nombre_maquina']}</td>";
                            echo "<td>{$fila['marca']}</td>";
                            echo "<td>{$fila['modelo']}</td>";
                            echo "<td>{$fila['placa']}</td>";
                            echo "<td>{$fila['adquisicion']}</td>";
                            echo "<td>{$fila['cantidad']}</td>";
                            $id_ambiente = $fila['id_ambiente'];
                            $consulta_ambiente = "SELECT nombre_ambiente FROM ambiente WHERE id_ambiente = '$id_ambiente'";
                            $resultado_ambiente_nombre = mysqli_query($conexion, $consulta_ambiente);
                            $nombre_ambiente = mysqli_fetch_assoc($resultado_ambiente_nombre)['nombre_ambiente'];
                            echo "<td>{$nombre_ambiente}</td>";
                            echo "<td class='btn-accion'>";
                            echo "<button type='button' class='btn btn-primary  mr-2 actualizar' data-toggle='modal' data-target='#editarm' 
                            data-serial='{$fila['serial']}' data-nombre_maquina='{$fila['nombre_maquina']}' data-marca='{$fila['marca']}'  data-modelo='{$fila['modelo']}' data-placa='{$fila['placa']}' data-adquisicion='{$fila['adquisicion']}' data-cantidad='{$fila['cantidad']}' data-id_ambiente='{$fila['id_ambiente']}'>
                            Editar
                          </button>";

                            echo "<button type='button' class='btn btn-danger  eliminar'>
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


    <div id="editarm" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal Programas-->
            <div class="modal-content">
                <div class="modal-header">
                <h3>EDITAR MÁQUINA</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h3>Completar todos los campos</h3>
                    <div class="container">
                        <form id="formActualizarMaquinas">
                            <label>Serial</label>
                            <input type="text" id="edit_seri_maqu" name="edit_seri_maqu" class="form-control" required>
                            <label>Nombre</label>
                            <input type="text" id="edit_nomb_maqu" name="edit_nomb_maqu" class="form-control" style="text-transform: uppercase;" required>
                            <label>Modelo Maquina:</label>
                        <input type="text" class="form-control mb-2" id="edit_model_maqu" name="edit_model_maqu" placeholder="Ingresar modelo"  style="text-transform: uppercase;" requiredrequired>
                        <label>Marca Maquina:</label>
                        <input type="text" class="form-control mb-2" id="edit_marc_maqu" name="edit_marc_maqu" placeholder="Ingresar marca"  style="text-transform: uppercase;" requiredrequired>
                            <label>Placa</label>
                            <input type="text" id="edit_plac_maqu" name="edit_plac_maqu" class="form-control"  style="text-transform: uppercase;" required required>
                            <label>Adquisición</label>
                            <input type="date" id="edit_adqu_maqu" name="edit_adqu_maqu" class="form-control" required>
                            <label>Cantidad</label>
                            <input type="number" id="edit_cant_maqu" name="edit_cant_maqu" class="form-control" required>
                            <label>Ambiente</label>
                            <select id="edit_id_maqu" name="edit_id_maqu" class="form-control" required>
                                <option value="">Seleccionar Ambiente</option>
                                <?php
                                $consulta_ambientes = "SELECT id_ambiente, nombre_ambiente FROM ambiente";
                                $resultado_ambientes = mysqli_query($conexion, $consulta_ambientes);
                                while ($fila_ambiente = mysqli_fetch_assoc($resultado_ambientes)) {
                                    echo "<option value='{$fila_ambiente['id_ambiente']}'>{$fila_ambiente['nombre_ambiente']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" id='cambios_maqu' class="btn btn-success mt-3" value="Realizar cambios">
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
            $('#tabla_maqu').DataTable({
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Buscar:"
                }
            });
        
   // Función al hacer clic en el botón "Actualizar"
   $(".actualizar").on("click", function() {
                var id_maquina = $(this).data("serial");
                var nombre_maquina = $(this).data("nombre_maquina");
                var marca = $(this).data("marca");
                var modelo = $(this).data("modelo");
                var placa = $(this).data("placa");
                var adquisicion = $(this).data("adquisicion");
                var cantidad = $(this).data("cantidad");
                var id_ambiente = $(this).data("id_ambiente");

                // Mostrar los datos en el modal
                $("#edit_seri_maqu").val(id_maquina);
                $("#edit_nomb_maqu").val(nombre_maquina);
                $("#edit_marc_maqu").val(marca);
                $("#edit_model_maqu").val(modelo);
                $("#edit_plac_maqu").val(placa);
                $("#edit_adqu_maqu").val(adquisicion);
                $("#edit_cant_maqu").val(cantidad);
                $("#edit_id_maqu").val(id_ambiente);
            });
                    // Abrir el modal
                    $("#editarm").modal("show");
        });

        // AJAX para actualizar programa
        $('#formActualizarMaquinas').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/ActualizarMaquina.php', // Ruta al archivo PHP para actualizar programa
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
         $("#buscador_maqu").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#body_maqu tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        // AJAX para registrar ambiente
        $('#formRegistrarMaquina').on('submit', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'PHP/RegistrarMaquina.php',
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
            var id_maquina = $(this).closest("tr").find("td:first").text(); // Obtener el ID de la ficha desde la primera celda de la misma fila

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
                    $.post("PHP/EliminarMaquina.php", {
                        id_maquina: id_maquina
                    }, function(data) {
                        // Mostrar el mensaje de respuesta del servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Maquina eliminada correctamente',
                            text: data,
                            showConfirmButton: true
                        }).then(function() {
                            // Eliminar la fila de la tabla y recargar la tabla después de eliminar
                            $('#tabla_maqu').DataTable().row($(this).closest('tr')).remove().draw();
                            window.location.reload();
                        });
                    });
                }
            });
        });
</script>
</body>
< </html>