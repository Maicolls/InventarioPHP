<?php
// Conectar a la base de datos
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

// Recibir los datos del formulario
$nombre = $_POST['nombre_solicitante'];
$documento_s = $_POST['docu'];
$fecha_solicitud = $_POST['f_solicitud'];
$cod_regional = $_POST['cod_regional'];
$cod_costos = $_POST['cod_costos'];
$nombre_coor = $_POST['nombre_coor'];
$cargo = $_POST['cargo'];
$id_coordinador = $_POST['id_coordinador']; // Asegúrate de recibir el id del coordinador
$area_solicitud = $_POST['area_solicitud'];
$id_area = $_POST['id_area']; // Asegúrate de recibir el id del área
$nom_regional = $_POST['nom_regional'];
$nom_centro_costos = $_POST['nom_centro_costos'];
$destino = $_POST['destino'];
$ficha = $_POST['ficha'];
$numero_ficha = $_POST['numero_ficha']; // Asegúrate de recibir el número de la ficha
$id_tipo_cuentadante = $_POST['id_tipo_cuentadante']; // Obtener el tipo de cuentadante

// Preparar la consulta SQL para insertar los datos de la solicitud
$stmt = $conexion->prepare("INSERT INTO solicitud_periodica (fecha_soli, cod_regi, cod_costo, nom_jefe, cargo, area, nom_regi, nom_costo, dest_bien, num_fich, tipo_cuentadante, nombre_solici, documento_s) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssisi", $fecha_solicitud, $cod_regional, $cod_costos, $nombre_coor, $cargo, $id_area, $nom_regional, $nom_centro_costos, $destino, $numero_ficha, $id_tipo_cuentadante, $nombre, $documento_s);

/*------------------Insertar cuentadante---------------------------------*/

// Ejecutar la consulta para la solicitud
if ($stmt->execute()) {
    $resultado = $conexion->query("SELECT LAST_INSERT_ID() as last_id");
    $id_solicitud = $resultado->fetch_assoc()['last_id'];

    // Obtener el correo del coordinador
    $stmt_correo = $conexion->prepare("SELECT correo FROM instructor WHERE id = ?");
    $stmt_correo->bind_param("i", $id_coordinador);
    $stmt_correo->execute();
    $stmt_correo->bind_result($correo_coordinador);
    $stmt_correo->fetch();
    $stmt_correo->close();

    // Si la inserción de la solicitud es exitosa, proceder a la inserción de los cuentadantes
    if ($id_tipo_cuentadante == 1) {
        // Si es unipersonal, guardar los datos de unipersonal
        $nombre_unipersonal = $_POST['nombre_unipersonal'];
        $cedula_unipersonal = $_POST['cedula_unipersonal'];

        // Verificar si el cuentadante ya existe en la base de datos
        $stmt_verificar = $conexion->prepare("SELECT id FROM cuentadante WHERE nombre = ? AND documento = ?");
        $stmt_verificar->bind_param("ss", $nombre, $documento);
        $nombre = $nombre_unipersonal;
        $documento = $cedula_unipersonal;
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows > 0) {
            // El cuentadante ya existe, obtener su ID
            $stmt_verificar->bind_result($cuentadante_id);
            $stmt_verificar->fetch();
            $stmt_verificar->close();
        } else {
            // El cuentadante no existe, insertar un nuevo registro
            $stmt_verificar->close();

            // Preparar la consulta SQL para insertar los datos de unipersonal
            $stmt_cuentadante = $conexion->prepare("INSERT INTO cuentadante (nombre, documento, tipo) VALUES (?, ?, ?)");
            $stmt_cuentadante->bind_param("ssi", $nombre, $documento, $id_tipo_cuentadante);

            // Ejecutar la inserción para el unipersonal
            if (!$stmt_cuentadante->execute()) {
                die("Error en la inserción de cuentadante unipersonal: " . $stmt_cuentadante->error);
            }

            // Obtener el ID del nuevo cuentadante insertado
            $cuentadante_id = $stmt_cuentadante->insert_id;

            // Cerrar la consulta para el unipersonal
            $stmt_cuentadante->close();
        }

        // Insertar la relación en la tabla `cuentadante_solicitud`
        $stmt_relacion_cuentadante = $conexion->prepare("INSERT INTO cuentadante_solicitud (id_cuentadante, id_solicitud) VALUES (?, ?)");
        $stmt_relacion_cuentadante->bind_param("ii", $cuentadante_id, $id_solicitud);

        if (!$stmt_relacion_cuentadante->execute()) {
            die("Error en la inserción de la relación cuentadante-solicitud: " . $stmt_relacion_cuentadante->error);
        }
        $stmt_relacion_cuentadante->close();
    } elseif ($id_tipo_cuentadante == 2) {
        // Si es múltiple, guardar los datos de múltiple
        $nombre_cuentadante = $_POST['nom_cuentadante1'];
        $documento_cuentadante = $_POST['doc_cuenta1'];

        // Verificar si $nombre_cuentadante es un array antes de usar count()
        if (is_array($nombre_cuentadante)) {
            // Preparar la consulta SQL para insertar los datos de múltiple
            $stmt_cuentadante = $conexion->prepare("INSERT INTO cuentadante (nombre, documento, tipo) VALUES (?, ?, ?)");
            $stmt_cuentadante->bind_param("ssi", $nombre, $documento, $id_tipo_cuentadante);

            // Iterar sobre los datos de los cuentadantes múltiples y ejecutar la inserción para cada uno
            for ($i = 0; $i < count($nombre_cuentadante); $i++) {
                $nombre = $nombre_cuentadante[$i];
                $documento = $documento_cuentadante[$i];

                // Verificar si el cuentadante ya existe en la base de datos
                $stmt_verificar = $conexion->prepare("SELECT id FROM cuentadante WHERE nombre = ? AND documento = ?");
                $stmt_verificar->bind_param("ss", $nombre, $documento);
                $stmt_verificar->execute();
                $stmt_verificar->store_result();

                if ($stmt_verificar->num_rows > 0) {
                    // El cuentadante ya existe, obtener su ID
                    $stmt_verificar->bind_result($cuentadante_id);
                    $stmt_verificar->fetch();
                    $stmt_verificar->close();
                } else {
                    // El cuentadante no existe, insertar un nuevo registro
                    $stmt_verificar->close();

                    // Ejecutar la inserción para el cuentadante múltiple
                    if (!$stmt_cuentadante->execute()) {
                        die("Error en la inserción de cuentadante múltiple: " . $stmt_cuentadante->error);
                    }

                    // Obtener el ID del nuevo cuentadante insertado
                    $cuentadante_id = $stmt_cuentadante->insert_id;
                }

                // Insertar la relación en la tabla `cuentadante_solicitud`
                $stmt_relacion_cuentadante = $conexion->prepare("INSERT INTO cuentadante_solicitud (id_cuentadante, id_solicitud) VALUES (?, ?)");
                $stmt_relacion_cuentadante->bind_param("ii", $cuentadante_id, $id_solicitud);

                if (!$stmt_relacion_cuentadante->execute()) {
                    die("Error en la inserción de la relación cuentadante-solicitud: " . $stmt_relacion_cuentadante->error);
                }
                $stmt_relacion_cuentadante->close();
            }
        } else {
            // Manejar el caso en el que $nombre_cuentadante no es un array
            die("Error: Los datos de cuentadante múltiple no están en el formato esperado.");
        }
    }

    /*------------------Insertar elementos---------------------------------*/

    // Insertar los elementos y sus relaciones con la solicitud
    foreach ($_POST['cod_elem'] as $i => $cod_elem) {
        // Verificar si el elemento ya existe en la base de datos
        $stmt_verificar_elemento = $conexion->prepare("SELECT id_elemento FROM elemento WHERE codigo = ?");
        $stmt_verificar_elemento->bind_param("s", $cod_elem);
        $stmt_verificar_elemento->execute();
        $stmt_verificar_elemento->store_result();

        if ($stmt_verificar_elemento->num_rows > 0) {
            // El elemento ya existe, obtener su ID
            $stmt_verificar_elemento->bind_result($id_elemento);
            $stmt_verificar_elemento->fetch();
            $stmt_verificar_elemento->close();
        } else {
            // El elemento no existe, insertar un nuevo registro
            $stmt_verificar_elemento->close();

            // Preparar la consulta SQL para insertar el nuevo elemento
            $stmt_insertar_elemento = $conexion->prepare("INSERT INTO elemento (codigo, ambiente, nombre, und_medida, cantidad_solicitada, observaciones) VALUES (?, ?,  ?, ?, ?, ?)");
            $stmt_insertar_elemento->bind_param("isssis", $cod_elem, $destino, $_POST['desc_elem'][$i], $_POST['und_elem'][$i], $_POST['canti_elem'][$i], $_POST['obser_elem'][$i]);

            // Ejecutar la inserción del nuevo elemento
            if ($stmt_insertar_elemento->execute()) {
                // Obtener el ID del nuevo elemento insertado
                $id_elemento = $stmt_insertar_elemento->insert_id;
            } else {
                die("Error en la inserción de un nuevo elemento: " . $stmt_insertar_elemento->error);
            }

            // Cerrar la consulta para la inserción del nuevo elemento
            $stmt_insertar_elemento->close();
        }

        // Insertar la relación en la tabla `elementos_solicitud_periodica`
        $stmt_relacion = $conexion->prepare("INSERT INTO elementos_solicitud_periodica (id_solicitud, id_elemento) VALUES (?, ?)");
        $stmt_relacion->bind_param("ii", $id_solicitud, $id_elemento);

        // Ejecutar la consulta
        if (!$stmt_relacion->execute()) {
            die("Error al guardar la relación: " . $stmt_relacion->error);
        }
    }


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
        $mail->addAddress('maickgutierrez13@gmail.com',$correo_coordinador, $nombre_coor);

         // Adjuntar una imagen
    $imagePath = 'C:\xampp\htdocs\InventarioPHP\src\main\resources\templates\images\cenigraf.png';
    if (file_exists($imagePath)) {
        $mail->addEmbeddedImage($imagePath, 'logo_cenigraf');
    } else {
        throw new Exception("No se pudo acceder al archivo: $imagePath");
    }
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nueva Solicitud Periodica Enviada';
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
                <h2>Solicitud Periodica Generada</h2>
            </div>
            <div class='content'>
            <p>Se ha enviado una nueva solicitud periodica con la siguiente informacion:<br> </p>
                      <p><b>Fecha de Solicitud:</b> $fecha_solicitud<br></p>
                      <p><b>Codigo Regional:</b> $cod_regional<br></p>
                      <p><b>Codigo de Costos:</b> $cod_costos<br></p>
                      <p><b>Nombre del Coordinador:</b> $nombre_coor<br></p>
                      <p><b>Area de Solicitud:</b> $area_solicitud<br></p>
                      <p><b>Nombre Regional:</b> $nom_regional<br></p>
                      <p><b>Nombre Centro de Costos:</b> $nom_centro_costos<br></p>
                      <p><b>Cargo:</b> $cargo<br></p>
                      <p><b>Tipo de Cuentadante:</b> $id_tipo_cuentadante<br></p>
                      <p><b>Destino de los Bienes:</b> $destino<br></p>
                      <p><b>Codigo de grupo o numero de ficha:</b> $numero_ficha<br></p>
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

        $mail->send();
        $_SESSION['correo_enviado'] = true;
    } catch (Exception $e) {
        echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }

    // Redireccionar o realizar otras acciones después de la inserción exitosa
    header('Location:../Solicitud_periodica.php');
    exit();
} else {
    // Manejar errores en la inserción de la solicitud
    echo "Error en la inserción de solicitud_periodica: " . $stmt->error;
}

// Cerrar la consulta para la solicitud y la conexión
$stmt->close();
$conexion->close();
?>
