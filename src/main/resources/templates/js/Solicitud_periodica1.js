$(document).ready(function() {
    // Función para inicializar valores y configuraciones al cargar la página
    function init() {
        hideDeleteButton();
        // Evento click para añadir un nuevo artículo
        $("#nuevo_articulo").click(addNewRow);
        // Evento click para eliminar un artículo
        $("#eliminar_fila").click(deleteRow);
    }

    // Función para ocultar el botón de eliminar fila
    function hideDeleteButton() {
        $("#eliminar_fila").hide();
    }

    // Función para añadir una nueva fila a la tabla de artículos
    function addNewRow() {
        var newRowHtml = '<tr>' +
            '<td><input class="form-control" type="text" name="cod_elem[]" readonly></td>' +
            '<td><input class="form-control" type="text" name="desc_elem[]" ></td>' +
            '<td><input class="form-control" type="text" name="und_elem[]" ></td>' +
            '<td><input class="form-control" type="number" name="canti_elem[]" ></td>' +
            '<td><textarea class="form-control" name="obser_elem[]"></textarea></td>' +
            '</tr>';
        $("#body_elemento").append(newRowHtml);
        // Mostrar el botón de eliminar fila después de añadir una nueva fila
        $("#eliminar_fila").show();
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


    /*------------------------ Autocompletar nombre area ---------------*/

    $(document).ready(function () {
        // Autocompletar para el área
        $('#area_solicitud').on('input', function () {
            var valorInput = $(this).val().toUpperCase();
            $('#listaAutocompletado2').empty();
            var idEncontrado = null; // Variable para almacenar el ID si hay coincidencia

            if (valorInput) {
                $.ajax({
                    url: 'PHP/buscar_area.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { texto: valorInput },
                    success: function (respuesta) {
                        var areas = respuesta.areas;
                        var coincidenciaExacta = false; // Bandera para verificar coincidencia exacta
                        if (areas) {
                            areas.forEach(function (area) {
                                $('#listaAutocompletado2').append('<li data-id="' + area.id + '">' + area.nombre + '</li>');
                            // Verificar si el valorInput coincide exactamente con algún nombre
                            if (valorInput === area.nombre.toUpperCase()) {
                                    coincidenciaExacta = true;
                                    idEncontrado = area.id; // Guardar el ID correspondiente
                                }
                            
                            });
                            $('#listaAutocompletado2').show();
                        } else {
                            $('#listaAutocompletado2').hide();
                        }
                        // Si hay coincidencia exacta y no se ha seleccionado una opción, actualiza el campo oculto
                        if (coincidenciaExacta && !$('#listaAutocompletado2 li.selected').length) {
                                $('#id_area').val(idEncontrado);
                                $('#listaAutocompletado2').hide();
                            }
                        }
                    });
                } else {
                    // Si no hay texto, se debe restablecer el campo oculto y mostrar la lista si hay elementos
            $('#id_area').val('');
            if ($('#listaAutocompletado2 li').length > 0) {
                $('#listaAutocompletado2').show();
            }
                }
            });

        // Autocompletar para el jefe o coordinador
        $('#nombre_coor').on('input', function () {
            var valorInput = $(this).val().toUpperCase();
            $('#listaAutocompletado1').empty();
            

            if (valorInput) {
                $.ajax({
                    url: 'PHP/buscar_area.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { texto: valorInput },
                    success: function (respuesta) {
                        var coordinadores = respuesta.coordinadores;
                        var coincidenciaExacta = false; // Bandera para verificar coincidencia exacta
                        if (coordinadores) {
                            coordinadores.forEach(function (coordinador) {
                                $('#listaAutocompletado1').append('<li data-id="' + coordinador.id + '">' + coordinador.nombre + '</li>');
                                 // Verificar si el valorInput coincide exactamente con algún nombre
                                if (valorInput === coordinador.nombre.toUpperCase()) {
                                    coincidenciaExacta = true;
                                    idEncontrado = coordinador.id; // Guardar el ID correspondiente
                                }
                        
                            });
                            $('#listaAutocompletado1').show();
                        } else {
                            $('#listaAutocompletado1').hide();
                        }
                     // Si hay coincidencia exacta y no se ha seleccionado una opción, actualiza el campo oculto
                     if (coincidenciaExacta && !$('#listaAutocompletado1 li.selected').length) {
                        $('#id_coordinador').val(idEncontrado);
                        $('#listaAutocompletado1').hide();
                    }
                }
            });
        } else {
            // Si no hay texto, se debe restablecer el campo oculto y mostrar la lista si hay elementos
    $('#id_coordinador').val('');
    if ($('#listaAutocompletado1 li').length > 0) {
        $('#listaAutocompletado1').show();
    }
        }
    });

        // Autocompletar para la ficha
        $('#ficha').on('input', function () {
            var valorInput = $(this).val().toUpperCase();
            $('#listaAutocompletado3').empty();

            if (valorInput) {
                $.ajax({
                    url: 'PHP/buscar_area.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { texto: valorInput },
                    success: function (respuesta) {
                        var fichas = respuesta.fichas;
                        var coincidenciaExacta = false; // Bandera para verificar coincidencia exacta
                        if (fichas) {
                            fichas.forEach(function (fichas) {
                                $('#listaAutocompletado3').append('<li data-id="' + fichas.numFicha + '">' + fichas.numFicha + '</li>');
                                // Verificar si el valorInput coincide exactamente con algún nombre
                                if (valorInput === fichas.numFicha.toUpperCase()) {
                                    coincidenciaExacta = true;
                                    idEncontrado = fichas.numFicha; // Guardar el ID correspondiente
                                }
                        
                            });
                            $('#listaAutocompletado3').show();
                        } else {
                            $('#listaAutocompletado3').hide();
                        }
                    // Si hay coincidencia exacta y no se ha seleccionado una opción, actualiza el campo oculto
                    if (coincidenciaExacta && !$('#listaAutocompletado3 li.selected').length) {
                        $('#numero_ficha').val(idEncontrado);
                        $('#listaAutocompletado3').hide();
                    }
                }
            });
        } else {
            // Si no hay texto, se debe restablecer el campo oculto y mostrar la lista si hay elementos
    $('#numero_ficha').val('');
    if ($('#listaAutocompletado3 li').length > 0) {
        $('#listaAutocompletado3').show();
    }
        }
    });

        // Evento de clic para seleccionar un elemento de la lista
        $(document).on('click', '.listaAutocompletado li', function () {
            var selectedText = $(this).text();
            var selectedId = $(this).data('id');
            var inputId = $(this).closest('ul').attr('id');

            if (inputId === 'listaAutocompletado1') {
                // Si el clic es en un elemento de la lista de coordinadores
                $('#nombre_coor').val(selectedText);
                $('#id_coordinador').val(selectedId);
            } else if (inputId === 'listaAutocompletado2') {
                // Si el clic es en un elemento de la lista de áreas
                $('#area_solicitud').val(selectedText);
                $('#id_area').val(selectedId);
            } else if (inputId === 'listaAutocompletado3') {
                // Si el clic es en un elemento de la lista de fichas
                $('#ficha').val(selectedText);
                $('#numero_ficha').val(selectedId);
            }

            $('.listaAutocompletado').hide();
        });

    });


    /*------------------------ FIN ---------------*/
     $(document).ready(function() {
            function mostrarCampos() {
                var tipoCuentadante = $("#tip_cuentadante").val();
                if (tipoCuentadante === "Unipersonal") {
                    $("#camposUnipersonal").show();
                    $("#camposMultiple").hide();
                    $("#id_tipo_cuentadante").val(1);
                } else if (tipoCuentadante === "Multiple") {
                    $("#camposUnipersonal").hide();
                    $("#camposMultiple").show();
                    $("#id_tipo_cuentadante").val(2);
                } else {
                    $("#camposUnipersonal").hide();
                    $("#camposMultiple").hide();
                }
            }

          // Inicializar los campos al cargar la página
    mostrarCampos();

    // Manejar el cambio en la selección del tipo de cuentadante
    $("#tip_cuentadante").on("change", mostrarCampos);

    // Contador para los IDs de los campos de cuentadante múltiple
    var contadorCuentadante = 1;
 
    // Función para agregar nuevos campos de cuentadante múltiple
    $('#agregarCuentadante').click(function() {
        contadorCuentadante++;
     
        // Crear un nuevo div 'form-group' para el nombre del cuentadante
        var campoNombre = $(
            '<div class="col-md-6 mb-3">' +
            '<div class="form-group">' +
            '<label class="mt-2">Nombre cuentadante ' + contadorCuentadante + ':</label>' +
            '<input type="text" class="form-control" name="nom_cuentadante1[]" placeholder="Digite el nombre del cuentadante" style="text-transform: uppercase;">' +
            '</div>' +
            '</div>'
        );

        // Crear un nuevo div 'form-group' para el documento del cuentadante
        var campoDocumento = $(
            '<div class="col-md-6 mb-3">' +
            '<div class="form-group">' +
            '<label class="mt-2">Documento cuentadante ' + contadorCuentadante + ':</label>' +
            '<input type="number" class="form-control" name="doc_cuenta1[]" placeholder="Digite la cedula del cuentadante" style="text-transform: uppercase;">' +
            '</div>' +
            '</div>'
        );

        // Insertar los nuevos campos en el contenedor de cuentadantes
        $('#contenedorCuentadantes').append(campoNombre).append(campoDocumento);
    });
});