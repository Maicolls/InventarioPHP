/* document.addEventListener("DOMContentLoaded", function() {

    // Manejar el envío del formulario de solicitud de mantenimiento
    document.getElementById("envioMante").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío por defecto

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Mostrar mensaje de carga
        document.getElementById("loadingMessage").style.display = "block";

        // Enviar los datos usando fetch
        fetch("../Personal/Solicitud_mantenimiento.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar mensaje de carga
            document.getElementById("loadingMessage").style.display = "none";

            if (data.status === "success") {
                // Mostrar mensaje de éxito
                toastr.success(data.message, 'Éxito'); // Mostrar mensaje de éxito
                $(".toast-success").css("background-color", "green"); // Cambiar color
            } else {
                // Mostrar mensaje de error
                toastr.error(data.message, 'Error'); // Mostrar mensaje de error
            }
        })
        .catch(error => {
            // Ocultar mensaje de carga
            document.getElementById("loadingMessage").style.display = "none";

            // Mostrar mensaje de error
            toastr.error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.', 'Error'); // Mensaje genérico

            console.error("Error: " + error); // Log en consola
        });
    });

    // Manejar el envío del formulario de descarga de Excel
    document.getElementById("excelForm").addEventListener("submit", function(event) {
        // No es necesario prevenir el envío por defecto aquí, ya que queremos que el formulario se envíe normalmente
    });
}); 
document.addEventListener("DOMContentLoaded", function() {
    // Manejar el envío del formulario de solicitud de mantenimiento
    document.getElementById("envioMante").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío por defecto

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Mostrar mensaje de carga
        document.getElementById("loadingMessage").style.display = "block";

        // Enviar los datos usando fetch
        fetch("../PHP/RegistrarSolicitudMantenimiento.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar mensaje de carga
            document.getElementById("loadingMessage").style.display = "none";

            if (data.status === "success") {
                // Mostrar mensaje de éxito
                toastr.success(data.message, 'Éxito'); // Mostrar mensaje de éxito
                $(".toast-success").css("background-color", "green"); // Cambiar color
            } else {
                // Mostrar mensaje de error
                toastr.error(data.message, 'Error'); // Mostrar mensaje de error
            }
        })
        .catch(error => {
            // Ocultar mensaje de carga
            document.getElementById("loadingMessage").style.display = "none";

            // Mostrar mensaje de error
            toastr.error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.', 'Error'); // Mensaje genérico

            console.error("Error: " + error); // Log en consola
        });
    });

    // Manejar el envío del formulario de descarga de Excel
    document.getElementById("excelForm").addEventListener("submit", function(event) {
        // No es necesario prevenir el envío por defecto aquí, ya que queremos que el formulario se envíe normalmente
    });
}); */
document.addEventListener("DOMContentLoaded", function() {
    // Manejar el envío del formulario de solicitud de mantenimiento
    document.getElementById("envioMante").addEventListener("click", function(event) {
        event.preventDefault(); // Prevenir el envío por defecto

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, enviar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtener los datos del formulario
                var formData = new FormData(document.getElementById("EnvioFormulario"));

                // Mostrar mensaje de carga
                document.getElementById("loadingMessage").style.display = "block";

                // Enviar los datos usando fetch
                fetch("http://localhost/InventarioPHP/PHP/ReporteMantenimiento.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Ocultar mensaje de carga
                    document.getElementById("loadingMessage").style.display = "none";

                    console.log(data); // Imprimir la respuesta del servidor en la consola

                    if (data.status === "success") {
                        // Mostrar mensaje de éxito
                        Swal.fire(
                            'Enviado!',
                            data.message,
                            'success'
                        );
                    } else {
                        // Mostrar mensaje de error
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    // Ocultar mensaje de carga
                    document.getElementById("loadingMessage").style.display = "none";

                    // Mostrar mensaje de error
                    Swal.fire(
                        'Error!',
                        'Ocurrió un problema al procesar la solicitud. Intenta nuevamente.',
                        'error'
                    );

                    console.error("Error: " + error); // Log en consola
                });
            }
        });
    });

    // Manejar el envío del formulario de descarga de Excel
    document.getElementById("excelForm").addEventListener("submit", function(event) {
        // No es necesario prevenir el envío por defecto aquí, ya que queremos que el formulario se envíe normalmente
    });
});