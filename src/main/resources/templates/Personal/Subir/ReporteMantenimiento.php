<?php
// Iniciar sesión
session_start();

// Verificar si la sesión contiene el identificador del usuario
if (!isset($_SESSION['id'])) {
    die("No se ha iniciado sesión.");
}

// Verificar el parámetro 'vista'
if (!isset($_POST['vista']) || $_POST['vista'] !== 'solicitud_mantenimiento') {
    die("Acceso no autorizado.");
}

// Incluir el archivo de conexión a la base de datos
include('../../PHP/Conexion.php');

// Incluir PhpSpreadsheet
require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Ruta de la plantilla
$plantilla = '../../Composer/vendor/Excel/solicitud_mantenimiento.xlsx';

// Verificar si la plantilla existe
if (!file_exists($plantilla)) {
    die("La plantilla no se encuentra en la ruta especificada.");
}

// Crear un objeto PhpSpreadsheet a partir de la plantilla
$spreadsheet = IOFactory::load($plantilla);

// Obtener la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Consultar los datos de la base de datos
$sql = "SELECT sm.*, a.nombre_ambiente AS nombre_ambiente, tm.nombre AS tipo_mantenimiento, 
                i.nombre_instructor AS solicitante, i.cedula AS cedula, r.nombre AS cargo, m.*
        FROM solicitud_mantenimiento sm
        INNER JOIN tipo_mantenimiento tm ON sm.solicitud = tm.id
        INNER JOIN instructor i ON sm.id_instructor = i.id
        INNER JOIN ambiente a ON sm.id_ambiente = a.id_ambiente
        INNER JOIN rol r ON sm.id_rol = r.id_rol
        INNER JOIN maquina m ON sm.maquina = m.id
        ORDER BY sm.id DESC LIMIT 1";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Si hay datos, recorrer el resultado y asignarlos a las celdas
    $row = $result->fetch_assoc();
    $sheet->setCellValue('C5', $row['fecha_soli']); // Fecha de Solicitud
    $sheet->setCellValue('C6', strtoupper($row['necesidad'])); // Necesidad
    $sheet->setCellValue('H6', strtoupper($row['nombre_ambiente'])); // Nombre ambiente
    $sheet->setCellValue('C7', strtoupper($row['tipo_mantenimiento'])); // Tipo de mantenimiento
    $sheet->setCellValue('C8', strtoupper($row['solicitante'])); // Solicitante
    $sheet->setCellValue('I8', strtoupper($row['cedula'])); // documento
    $sheet->setCellValue('H16', strtoupper($row['cargo'])); // Cargo
    $sheet->setCellValue('C16', strtoupper($row['solicitante'])); // Solicitante
    // Ahora, asigna los valores de la máquina
    $sheet->setCellValue('B14', strtoupper($row['nombre_maquina'])); // Nombre de la máquina
    $sheet->setCellValue('C14', strtoupper($row['marca'])); // Marca de la máquina
    $sheet->setCellValue('D14', strtoupper($row['modelo'])); // Modelo de la máquina
    $sheet->setCellValue('E14', strtoupper($row['placa'])); // Placa de la máquina
    $sheet->setCellValue('F14', strtoupper($row['serial'])); // Serial de la máquina
    $sheet->setCellValue('G14', strtoupper($row['cantidad'])); // Cantidad de la máquina
    $sheet->setCellValue('H14', strtoupper($row['tipo'])); // Tipo de máquina
    $sheet->setCellValue('I13', strtoupper($row['suministro'])); // Suministro de la máquina
} else {
    echo "No se encontraron solicitudes de mantenimiento.";
    exit;
}

// Cerrar la conexión
$conexion->close();

// Configurar los encabezados HTTP para la descarga del archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="solicitud_de_mantenimiento.xlsx"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en el flujo de salida (output)
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit();
?>