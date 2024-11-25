// Función para obtener detalles de la solicitud
function obtenerDetallesSolicitud(id) {
    $.ajax({
        url: '../almacen/PHP/obtener_detalles_solicitud.php',
        method: 'GET',
        data: { solicitudId: id },
        success: function(response) {
            var datos = JSON.parse(response);
            if (datos.error) {
                alert(datos.error);
                return;
            }

            // Rellenar los campos del modal con los datos obtenidos
            $('#f_solicitud').val(datos.fecha_soli);
            $('#cod_regional').val(datos.cod_regi);
            $('#cod_costos').val(datos.cod_costo);
            $('#nombre_coor').val(datos.nom_jefe);
            $('#area_solicitud').val(datos.area);
            $('#cargo').val(datos.cargo);
            $('#nom_regional').val(datos.nom_regi);
            $('#nom_centro_costos').val(datos.nom_costo);
            $('#tipo_cuenta').val(datos.tipo_cuentadante);
            $('#destino').val(datos.dest_bien);
            $('#ficha').val(datos.num_fich);
            $('#codigo').val(datos.codigo);
            $('#descripcion').val(datos.descripcion);
            $('#unidad_medida').val(datos.unidad_medida);
            $('#cantidad').val(datos.cantidad);
            $('#cantidad_solicitada').val(datos.cantidad_solicitada);
            $('#observacion').val(datos.observacion);
            $('#nombre').val(datos.nom_jefe);

            if (datos.cuentadantes.length > 0) {
                $('#nom_cuenta_uno').val(datos.cuentadantes[0].nombre);
                $('#doc_cuenta_uno').val(datos.cuentadantes[0].documento);
            }
            if (datos.cuentadantes.length > 1) {
                $('#nom_cuenta_dos').val(datos.cuentadantes[1].nombre);
                $('#doc_cuenta_dos').val(datos.cuentadantes[1].documento);
            }
            if (datos.cuentadantes.length > 2) {
                $('#nom_cuenta_tres').val(datos.cuentadantes[2].nombre);
                $('#doc_cuenta_tres').val(datos.cuentadantes[2].documento);
            }

            // Mostrar la firma si existe
            if (datos.firma) {
                $("#imagen_firma").html(`<img class="thumb" style="width: 200px" src="data:image/png;base64,${datos.firma}" />`);
            } else {
                $("#imagen_firma").html("<img src='https://mdbootstrap.com/img/Photos/Others/placeholder.jpg' style='width: 200px'/>");
            }

            // Mostrar el modal después de llenar los campos
            $('#verdetalles').modal('show');

            // Guardar el ID de la solicitud en un campo oculto para usarlo al subir la firma
            $('#solicitudId').val(id);
            console.log("ID de solicitud asignado: " + id); 
        },
        error: function() {
            alert('Error al obtener detalles de la solicitud.');
        }
    });
}

// Evento de clic para mostrar detalles de la solicitud
$(document).ready(function() {
    $('.btn-ver-detalles').on('click', function() {
        const solicitudId = $(this).data('id');
        obtenerDetallesSolicitud(solicitudId);
    });
});

// Función para manejar la carga de la firma
$(function () {
    $("#imagen_firma").html("<img src='https://mdbootstrap.com/img/Photos/Others/placeholder.jpg' style='width: 200px'/>");

    $("#subir_firma").on("change", function (evt) {
        var files = evt.target.files;

        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            reader.onload = (function(theFile) {
                return function(e) {
                    $("#imagen_firma").html(['<img class="thumb" style="width: 200px" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join(''));

                    var formData = new FormData();
                    formData.append('firma', theFile);
                    var solicitudId = $('#solicitudId').val(); 
                    formData.append('solicitudId', solicitudId);

                    $.ajax({
                        url: '../almacen/PHP/guardarFirma.php',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                alert(result.success);
                            } else {
                                alert(result.error);
                            }
                        },
                        error: function() {
                            alert('Error al subir la firma.');
                        }
                    });
                };
            })(f);

            reader.readAsDataURL(f);
        }
    });
});