
$(document).ready(function() {
    // Función para inicializar valores y configuraciones al cargar la página
    function init() {
        hideDeleteButton();
        // Evento click para añadir un nuevo artículo
        $("#nuevo_articulo").click(addNewRow);
        // Evento click para eliminar un artículo
        $("#eliminar_fila").click(deleteRow);
        // Evento submit para enviar el formulario
        $("#informeForm").submit(submitForm);
    }


    

    // Función para ocultar el botón de eliminar fila
    function hideDeleteButton() {
        $("#eliminar_fila").hide();
    }
    function addNewRow() {
        var newRowHtml = '<tr>' +
            '<td><select class="form-control" type="text" name="nom_elemento[]" ></td>' +
            '<td><input class="form-control" type="text" name="unidad[]" ></td>' +
            '<td><input class="form-control" type="text" name="cantidad[]" ></td>' +
            '<td><input class="form-control" type="number" name="solicitada[]" ></td>' +
            '</tr>';
        $("#body_elemento").append(newRowHtml);
        $("#eliminar_fila").show();
    }

   // Función para manejar el envío del formulario
function submitForm(event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto del formulario
    var form = $(this);
    // Mostrar mensaje de carga
    $("#loadingMessage").show();
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            $("#loadingMessage").hide(); // Ocultar mensaje de carga
            if (response.status === "success") {
                toastr.success(response.message, 'Éxito'); // Mostrar mensaje de éxito
                $(".toast-success").css("background-color", "green"); // Cambiar color
            } else {
                toastr.error(response.message, 'Error'); // Mostrar mensaje de error
            }
        },
        error: function(xhr, status, error) {
            $("#loadingMessage").hide(); // Ocultar mensaje de carga
            console.error("Error: " + error); // Log en consola
            console.error("Status: " + status);
            console.error("Response: " + xhr.responseText);

            toastr.error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.', 'Error'); // Mensaje genérico
        }
    });


    }

    // Función para eliminar la fila seleccionada de la tabla de artículos
    function deleteRow() {
        // Obtener la fila seleccionada
        var selectedRow = $("#body_elemento tr:last-child");
        // Eliminar la fila seleccionada
        selectedRow.remove();
        // Si ya no hay filas, ocultar el botón de eliminar fila
        if ($("#body_elemento tr").length === 0) {
            $("#eliminar_fila").hide();
        }
    }

    // Llamar a la función de inicialización al cargar la página
    init();
});

    // Delegación de eventos para manejar select en elementos dinámicos
    $(document).on('change', '#body_elemento .elemento-select', function() {
        var id_elemento = $(this).val(); // Obtener el ID del elemento seleccionado
        var $fila = $(this).closest('tr'); // Obtener la fila correspondiente

        // Realizar una solicitud AJAX para obtener la unidad de medida y la disponibilidad
        $.ajax({
            url: 'PHP/RegistrarSolicitudAnual.php',
            type: 'POST',
            data: {id_elemento: id_elemento},
            success: function(response) {
                var valores = response.split('|');
                $fila.find('.udmedanu').val(valores[0]); // Mostrar la unidad de medida en el campo de texto
                $fila.find('.dispo').val(valores[1]); // Mostrar la disponibilidad en el campo de número
            },
            error: function(xhr, status, error) {
                console.error(error); // Manejar errores si la solicitud AJAX falla
            }
        });
    });
    $(document).on('change', '#body_elemento input[name="solicitada[]"]', function() {
    var $fila = $(this).closest('tr');
    var id_elemento = $fila.find('select[name="nom_elemento[]"]').val(); // Obtener el ID del elemento seleccionado
    var cantidad_solicitada = $(this).val(); // Obtener la cantidad solicitada

    // Realizar una solicitud AJAX para actualizar la cantidad solicitada en la base de datos
    $.ajax({
        url: 'ruta/a/tu/script/php/de/actualizacion.php',
        type: 'POST',
        data: {id_elemento: id_elemento, cantidad_solicitada: cantidad_solicitada},
        success: function(response) {
            // Manejar la respuesta del servidor si es necesario
        },
        error: function(xhr, status, error) {
            console.error(error); // Manejar errores si la solicitud AJAX falla
        }
    });
});
