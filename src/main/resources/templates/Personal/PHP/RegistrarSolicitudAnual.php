<?php
include ('../../PHP/Conexion.php');
include ('../../PHP/Funciones.php');

InicioSesion();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../../Composer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../Composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../Composer/vendor/phpmailer/phpmailer/src/SMTP.php';


// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Medir el tiempo de inicio
$start_time = microtime(true);

// Manejar la inserción de la solicitud
if (isset($_POST['f_solicitud'])) {
    // Recibir los datos del formulario
    $fecha_solicitud = $_POST['f_solicitud'];
    $nombre = $_POST['nombre_solicitante'];
    $documento = $_POST['docu'];
    $ficha = $_POST['fi_anu'];
    $programa = $_POST['pro_anu'];

    $elementos = $_POST['nom_elemento'];
    $unidades = $_POST['unidad'];
    $cantidades = $_POST['cantidad'];
    $solicitadas = $_POST['solicitada'];

    // Procesar cada elemento individualmente
    for ($i = 0; $i < count($elementos); $i++) {
        // Verificar que el elemento tenga el formato correcto
        if (strpos($elementos[$i], ',') !== false) {
            list($id_elemento, $nombre_elemento) = explode(',', $elementos[$i]);
        } else {
            $id_elemento = $elementos[$i];
            $nombre_elemento = '';
        }
        $und_medida = $unidades[$i];
        $cantidad = $cantidades[$i];
        $cantidad_solicitada = $solicitadas[$i];

        // Preparar la consulta SQL para insertar los datos de la solicitud
        $stmt = $conexion->prepare("INSERT INTO solicitud_anual (fecha_soli, nombre_solici, documento, ficha_soli, programa_soli, cantidad_soli) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisi", $fecha_solicitud, $nombre, $documento, $ficha, $programa, $cantidad_solicitada);

        // Ejecutar la consulta de inserción de solicitud
        if (!$stmt->execute()) {
            echo json_encode(["status" => "error", "message" => "Error al insertar la solicitud: " . $stmt->error]);
            exit();
        }
        // Cerrar la consulta para la solicitud
        $stmt->close();
    }

    // Medir el tiempo después de la inserción
    $insert_time = microtime(true);

// Obtener la hora actual
$hora_envio = date('H:i:s');

// Enviar el correo electrónico usando PHPMailer
$mail = new PHPMailer(true);
try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'almacencenigraf@gmail.com';
    $mail->Password = 'xyivyvgjkzqueaeg';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinatarios
    $mail->setFrom('almacencenigraf@gmail.com', 'Almacen CENIGRAF');
    $mail->addAddress('maickgutierrez13@gmail.com', 'Nombre del Destinatario');

   // Adjuntar una imagen
    $imagePath = 'C:\xampp\htdocs\InventarioPHP\src\main\resources\templates\images\cenigraf.png';
    if (file_exists($imagePath)) {
        $mail->addEmbeddedImage($imagePath, 'logo_cenigraf');
    } else {
        throw new Exception("No se pudo acceder al archivo: $imagePath");
    }


    // Contenido del correo
    $mail->isHTML(true); // Configurar el correo en formato HTML
    $mail->Subject = 'Se ha generado Nueva Solicitud Anual'; // Asunto del correo

    // Cuerpo del correo
    $mail->Body = "
    <html>
    <head>
        <style>
            .container {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
                background-color: #f9f9f9;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header img {
                max-width: 150px;
            }
            .content {
                margin-bottom: 20px;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <img src='cid:logo_cenigraf' alt='CENIGRAF'>
                <h2>Solicitud Anual Generada</h2>
            </div>
            <div class='content'>
                <p>Buen dia, Se ha recibido una nueva solicitud anual con los siguientes detalles:</p>
                <p><strong>Fecha de Solicitud:</strong> $fecha_solicitud</p>
                <p><strong>Hora de Envío:</strong> $hora_envio</p>
                <p><strong>Nombre del Solicitante:</strong> $nombre</p>
                <p><strong>Documento:</strong> $documento</p>
                <p><strong>Ficha:</strong> $ficha</p>
                <p><strong>Programa:</strong> $programa</p>
            </div>
            <div class='footer'>
                <p>Este es un mensaje automático, por favor no responda a este correo.</p>
                <p>&copy; 2024 CENIGRAF. Todos los derechos reservados.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    $mail->send(); // Envío del correo
    $response = 'Correo enviado correctamente'; // Mensaje de éxito
    $status = 'success'; // Estado de éxito
} catch (Exception $e) {  // Manejo de excepciones
    $response = "Error al enviar el correo: {$mail->ErrorInfo}"; // Mensaje de error
    $status = 'error';
}

// Medir el tiempo después del envío del correo
$end_time = microtime(true);

// Calcular y mostrar los tiempos
$insert_duration = $insert_time - $start_time;
$mail_duration = $end_time - $insert_time;
$total_duration = $end_time - $start_time;

$response .= "<br>Tiempo de inserción: " . $insert_duration . " segundos<br>";
$response .= "Tiempo de envío de correo: " . $mail_duration . " segundos<br>";
$response .= "Tiempo total: " . $total_duration . " segundos<br>";

// Cerrar la conexión
$conexion->close();

// Enviar la respuesta al cliente en formato JSON
header('Content-Type: application/json');
echo json_encode(["status" => $status, "message" => $response]);
exit();
}
?>
// Cerrar la consulta para la solicitud y la conexión
        $stmt->close();
        $conexion->close();