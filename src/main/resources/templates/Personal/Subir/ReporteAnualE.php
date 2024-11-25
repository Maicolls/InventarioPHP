<?php
// Iniciar sesión
session_start();

// Verificar si la sesión contiene el identificador del usuario
if (!isset($_SESSION['id'])) {
    die("No se ha iniciado sesión.");
}

// Incluir el archivo de conexión a la base de datos
include('../../PHP/Conexion.php');

$usuario_id = $_SESSION['id'];

// Incluir PhpSpreadsheet
require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Ruta de la plantilla
$plantilla = '../../Composer/vendor/Excel/solicitud_anual.xlsx';

// Crear un objeto PhpSpreadsheet a partir de la plantilla
$spreadsheet = IOFactory::load($plantilla);

// Obtener la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Consultar los datos de la base de datos
$sql = "SELECT * FROM solicitud_anual ORDER BY id_anual DESC LIMIT 1";
$result = $conexion->query($sql);

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
        
        // Consulta para obtener los datos del elemento según el id de la solicitud
        $sql_elemento = "
            SELECT e.nombre, e.und_medida, e.cantidad 
            FROM elemento e
            INNER JOIN elemento_solicitud_anual ea ON e.id_elemento = ea.id_elemento
            WHERE ea.id_solicitud = ?
        ";

        $stmt = $conexion->prepare($sql_elemento);
        $stmt->bind_param('i', $id_solicitud);
        $stmt->execute();
        $result_elemento = $stmt->get_result();

        if ($result_elemento->num_rows > 0) {
            $row_number = 12; // Comienza en la fila 16
            while ($row_elemento = $result_elemento->fetch_assoc()) {
                $sheet->setCellValue('B' . $row_number, strtoupper($row_elemento['nombre'])); // Nombre
                $sheet->setCellValue('C' . $row_number, strtoupper($row_elemento['und_medida'])); // Unidad de medida
                $sheet->setCellValue('E' . $row_number, strtoupper($row_elemento['cantidad'])); // Cantidad
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
