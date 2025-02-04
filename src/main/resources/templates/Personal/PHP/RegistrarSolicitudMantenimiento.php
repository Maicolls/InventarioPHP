<?php
session_start();
require '../../Composer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../Composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../Composer/vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../Composer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si la sesión contiene el identificador del usuario
if (!isset($_SESSION['id'])) {
    echo json_encode(["status" => "error", "message" => "No se ha iniciado sesión."]);
    exit();
}

// Incluir el archivo de conexión a la base de datos
include ('../../PHP/Conexion.php');

// Obtener los datos del formulario
$tipo_solicitud = $_POST['solicitud'];
$fecha_solicitud = $_POST['fecha_solicitud'];
$necesidad = $_POST['necesidad'];
$nom_maquina = $_POST['nom_maquina'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$placa = $_POST['placa'];
$serial = $_POST['serial'];
$cantidad = $_POST['cantidad'];
$tipo_mantenimiento = $_POST['tipo'];
$suministro = $_POST['suministro'];
$id_ambiente = $_POST['id_ambiente'];
$id_instructor = $_POST['id_instructor'];
$id_rol_solicitante = $_POST['id_rol_solicitante'];

// Verificar si la máquina ya existe en la base de datos
$stmt_verificar_maquina = $conexion->prepare("SELECT id FROM maquina WHERE serial = ?");
$stmt_verificar_maquina->bind_param("s", $serial);
$stmt_verificar_maquina->execute();
$stmt_verificar_maquina->store_result();

if ($stmt_verificar_maquina->num_rows > 0) {
    // La máquina ya existe, obtener su ID
    $stmt_verificar_maquina->bind_result($id_maquina);
    $stmt_verificar_maquina->fetch();
    $stmt_verificar_maquina->close();
} else {
    $stmt_verificar_maquina->close();

    // Insertar los datos de la máquina en la base de datos
    $stmt_insertar_maquina = $conexion->prepare("INSERT INTO maquina (nombre_maquina, marca, modelo, placa, serial, cantidad, id_ambiente) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_insertar_maquina->bind_param("ssssssi", $nom_maquina, $marca, $modelo, $placa, $serial, $cantidad, $id_ambiente);
    
    if ($stmt_insertar_maquina->execute()) {
        $id_maquina = $stmt_insertar_maquina->insert_id;
    } else {
        echo json_encode(["status" => "error", "message" => "Error al insertar la máquina: " . $stmt_insertar_maquina->error]);
        exit();
    }
    $stmt_insertar_maquina->close();
}

// Preparar la consulta SQL para insertar los datos de la solicitud
$stmt = $conexion->prepare("INSERT INTO solicitud_mantenimiento (solicitud, fecha_soli, necesidad, maquina, id_instructor, id_ambiente, id_rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiii", $tipo_solicitud, $fecha_solicitud, $necesidad, $id_maquina, $id_instructor, $id_ambiente, $id_rol_solicitante);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Obtener información adicional para el correo electrónico
    $correo_coordinador = "coordinador@example.com"; // Reemplaza con el correo real del coordinador
    $nombre_coor = "Nombre del Coordinador"; // Reemplaza con el nombre real del coordinador

    // Obtener el nombre del ambiente desde la base de datos
    $stmt_ambiente = $conexion->prepare("SELECT nombre_ambiente FROM ambiente WHERE id_ambiente = ?");
    $stmt_ambiente->bind_param("i", $id_ambiente);
    $stmt_ambiente->execute();
    $stmt_ambiente->bind_result($nombre_ambiente);
    $stmt_ambiente->fetch();
    $stmt_ambiente->close();

    // Obtener la cédula y el correo del solicitante desde la base de datos
    $stmt_solicitante = $conexion->prepare("SELECT cedula, correo FROM instructor WHERE id = ?");
    $stmt_solicitante->bind_param("i", $id_instructor);
    $stmt_solicitante->execute();
    $stmt_solicitante->bind_result($cedula, $correo);
    $stmt_solicitante->fetch();
    $stmt_solicitante->close();

    $nombre_maquina = $nom_maquina; // Usar el nombre de la máquina del formulario
    $tipo = $tipo_mantenimiento; // Usar el tipo de mantenimiento del formulario

    // Enviar correo electrónico usando PHPMailer
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
        $mail->addAddress('maickgutierrez13@gmail.com', $correo_coordinador, $nombre_coor);

        // Adjuntar una imagen
        $imagePath = 'C:/xampp/htdocs/InventarioPHP/src/main/resources/templates/images/cenigraf.png';
        if (file_exists($imagePath)) {
            $mail->addEmbeddedImage($imagePath, 'logo_cenigraf');
        } else {
            throw new Exception("No se pudo acceder al archivo: $imagePath");
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Se ha generado una Nueva Solicitud de Mantenimiento';
        $mail->Body = "
        <html>
        <head>
            <style>
                .container{
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
                <h2>Solicitud de Mantenimiento Generada</h2>
            </div>
            <div class='content'>
            <p>Se ha enviado una nueva solicitud de mantenimiento con la siguiente información:<br> </p>
                      <p><b>Fecha de Solicitud:</b> $fecha_solicitud<br></p>
                      <p><b>Nombre del Ambiente:</b> $nombre_ambiente<br></p>
                      <p><b>Tipo de Mantenimiento:</b> $tipo_mantenimiento<br></p>
                      <p><b>Solicitante:</b> $id_instructor<br></p>
                      <p><b>Cédula:</b> $cedula<br></p>
                      <p><b>Correo:</b> $correo<br></p>
                      <p><b>Nombre de la Máquina:</b> $nombre_maquina<br></p>
                      <p><b>Marca:</b> $marca<br></p>
                      <p><b>Modelo:</b> $modelo<br></p>
                      <p><b>Placa:</b> $placa<br></p>
                      <p><b>Serial:</b> $serial<br></p>
                      <p><b>Cantidad:</b> $cantidad<br></p>
                      <p><b>Tipo:</b> $tipo<br></p>
                      <p><b>Suministro:</b> $suministro<br></p>
                      <p><b>Ingrese desde el siguiente link:<br></p>
                      <p><b>http://localhost/InventarioPHP/src/main/resources/templates<br>
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
        echo json_encode(["status" => "success", "message" => "Solicitud enviada y correo enviado correctamente."]);
    } catch (Exception $e) {  // Manejo de excepciones
        echo json_encode(["status" => "error", "message" => "Error al enviar el correo: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al insertar la solicitud: " . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
