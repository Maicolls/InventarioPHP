<?php
// Iniciar sesión
session_start();

// Verificar si la sesión contiene el identificador del usuario
if (!isset($_SESSION['id'])) {
    die("No se ha iniciado sesión.");
}

// Verificar el parámetro 'vista'
if (!isset($_POST['vista']) || $_POST['vista'] !== 'solicitud_anual') {
    die("Acceso no autorizado.");
}

$vista = $_POST['vista'];

// Incluir el archivo de conexión a la base de datos
include('../../PHP/Conexion.php');

$usuario_id = $_SESSION['id'];

// Incluir PhpSpreadsheet
require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Ruta de la plantilla
$plantilla = '../../Composer/vendor/Excel/solicitud_anual.xlsx';

// Verificar si la plantilla existe
if (!file_exists($plantilla)) {
    die("La plantilla no se encuentra en la ruta especificada.");
}

// Crear un objeto PhpSpreadsheet a partir de la plantilla
$spreadsheet = IOFactory::load($plantilla);

// Obtener la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Obtener los datos del formulario
$fecha_solicitud = $_POST['f_solicitud'];
$nombre_solicitante = $_POST['nombre_solicitante'];
$documento = $_POST['docu'];
$ficha = $_POST['fi_anu'];
$programa = $_POST['pro_anu'];

// Depuración: Imprimir los valores de los campos ocultos
echo "Fecha de Solicitud: $fecha_solicitud<br>";
echo "Nombre del Solicitante: $nombre_solicitante<br>";
echo "Documento: $documento<br>";
echo "Ficha: $ficha<br>";
echo "Programa: $programa<br>";

// Rellenar la hoja con los datos del formulario
$sheet->setCellValue('A1', 'Fecha de Solicitud');
$sheet->setCellValue('B1', $fecha_solicitud);
$sheet->setCellValue('A2', 'Nombre del Solicitante');
$sheet->setCellValue('B2', $nombre_solicitante);
$sheet->setCellValue('A3', 'Documento');
$sheet->setCellValue('B3', $documento);
$sheet->setCellValue('A4', 'Ficha');
$sheet->setCellValue('B4', $ficha);
$sheet->setCellValue('A5', 'Programa');
$sheet->setCellValue('B5', $programa);

// Consultar los datos de la base de datos
$sql = "SELECT * FROM solicitud_anual WHERE fecha_soli = ? AND nombre_solici = ? AND documento = ? AND ficha_soli = ? AND programa_soli = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssisi", $fecha_solicitud, $nombre_solicitante, $documento, $ficha, $programa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si hay datos, recorrer el resultado y asignarlos a las celdas
    $row = $result->fetch_assoc();
    $sheet->setCellValue('C5', $row['fecha_soli']); // Fecha de Solicitud
    $sheet->setCellValue('C6', strtoupper($row['nombre_solici'])); // Solicitante
    $sheet->setCellValue('B28', strtoupper($row['nombre_solici'])); // Solicitante
    $sheet->setCellValue('H6', strtoupper($row['documento'])); // Documento del solicitante
    $sheet->setCellValue('E9', strtoupper($row['ficha_soli'])); // Ficha del solicitante
    $sheet->setCellValue('G12', strtoupper($row['cantidad_soli'])); // Cantidad solicitada

    $programa_id = $row['programa_soli'];
    $sql_programa = "SELECT nombre_programa FROM programa WHERE id_programa = $programa_id";
    $result_programa = $conexion->query($sql_programa);

    if ($result_programa->num_rows > 0) {
        $row_programa = $result_programa->fetch_assoc();
        $sheet->setCellValue('C8', strtoupper($row_programa['nombre_programa']));
        $result_programa->free();
    } else {
        $sheet->setCellValue('C8', "Programa no encontrado");
    }

    // Obtener el último id_solicitud insertado
    $sql_last_solicitud = "SELECT MAX(id_anual) AS last_id_solicitud FROM solicitud_anual";
    $result_last_solicitud = $conexion->query($sql_last_solicitud);

    if ($result_last_solicitud->num_rows > 0) {
        $row_last_solicitud = $result_last_solicitud->fetch_assoc();
        $id_solicitud = $row_last_solicitud['last_id_solicitud'];
        $result_last_solicitud->free();
        
        // Depuración: Imprimir el último id_solicitud
        echo "Último id_solicitud: $id_solicitud<br>";

        // Consulta para obtener los datos del elemento según el id de la solicitud
        $sql_elemento = "
            SELECT e.nombre, e.und_medida
            FROM elemento e
            INNER JOIN elemento_solicitud_anual ea ON e.id_elemento = ea.id_elemento
            WHERE ea.id_solicitud = ?
        ";

        $stmt = $conexion->prepare($sql_elemento);
        $stmt->bind_param('i', $id_solicitud);
        $stmt->execute();
        $result_elemento = $stmt->get_result();

        // Depuración: Imprimir el número de filas obtenidas
        echo "Número de filas obtenidas: " . $result_elemento->num_rows . "<br>";

        if ($result_elemento->num_rows > 0) {
            $row_number = 12; // Comienza en la fila 12
            while ($row_elemento = $result_elemento->fetch_assoc()) {
                $sheet->setCellValue('B' . $row_number, strtoupper($row_elemento['nombre'])); // Nombre
                $sheet->setCellValue('C' . $row_number, strtoupper($row_elemento['und_medida'])); // Unidad de medida
                // Aquí puedes agregar más columnas si es necesario
                $row_number++; // Avanza a la siguiente fila
            }
        } else {
            echo "No se encontraron registros para el elemento.";
            exit;
        }
        $stmt->close();
        $result_elemento->free();
    } else {
        echo "No se encontraron solicitudes.";
        exit;
    }
} else {
    echo "No se encontraron solicitudes.";
    exit;
}

$result->free();
$conexion->close();

// Configurar los encabezados HTTP para la descarga del archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="solicitud_anual.xlsx"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en el flujo de salida (output)
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit();
?>