<?php
// Incluye el archivo de conexión a la base de datos
include('../../PHP/Conexion.php');

// Verificar el tipo de reporte (mensual o anual)
$tipoReporte = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Consulta SQL base para obtener los detalles de la solicitud, sus elementos y cuentadantes asociados
$query = "SELECT sp.fecha_soli,  
       sp.nom_jefe,  
       i.correo AS correo_jefe,
       sp.nombre_solici, 
       sp.documento_s, 
       a.nombre_ambiente AS nombre_ambiente,  
       sp.nom_costo, 
       sp.tipo_cuentadante, 
       sp.dest_bien, 
       sp.num_fich, 
       e.codigo, 
       e.nombre, 
       e.und_medida, 
       e.cantidad_solicitada, 
       e.cantidad_entregada, 
       e.observaciones
FROM solicitud_periodica sp
LEFT JOIN elementos_solicitud_periodica esp ON sp.id = esp.id_solicitud
LEFT JOIN ambiente a ON sp.area = a.id_ambiente
LEFT JOIN elemento e ON esp.id_elemento = e.id_elemento
LEFT JOIN instructor i ON sp.nom_jefe = i.nombre_instructor";

// Si es un reporte mensual, agregar condición para obtener datos de un mes específico
if ($tipoReporte === 'mensual') {
    $mes = date('m'); // Obtener el mes actual
    $query .= " WHERE MONTH(sp.fecha_soli) = $mes";
} elseif ($tipoReporte === 'anual') {
    $anio = date('Y'); // Obtener el año actual
    $query .= " WHERE YEAR(sp.fecha_soli) = $anio";
}

$resultado = $conexion->query($query);

// Crear un objeto PhpSpreadsheet
require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Escribir los encabezados de columna en negrilla
$sheet->setCellValue('A1', 'FECHA');
$sheet->setCellValue('B1', 'AREA');
$sheet->setCellValue('C1', 'NOMBRE SOLICITANTE');
$sheet->setCellValue('D1', 'CEDULA');
$sheet->setCellValue('E1', 'AUTORIZA');
$sheet->setCellValue('F1', 'CORREO');
$sheet->setCellValue('G1', 'FICHA');
$sheet->setCellValue('H1', 'CODIGO');
$sheet->setCellValue('I1', 'NOMBRE DEL ELEMENTO');
$sheet->setCellValue('J1', 'UNIDAD DE MEDIDA');
$sheet->setCellValue('K1', 'CANTIDAD SOLICITADA');
$sheet->setCellValue('L1', 'CANTIDAD ENTREGADA');
$sheet->setCellValue('M1', 'OBSERVACIONES');

// Establecer estilo de fuente en negrilla para los encabezados
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
];
$sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

// Escribir los datos en el archivo Excel
$row_number = 2;

while ($row = $resultado->fetch_assoc()) {
    $sheet->setCellValue('A' . $row_number, $row['fecha_soli']);
    $sheet->setCellValue('B' . $row_number, strtoupper($row['nombre_ambiente']));
    $sheet->setCellValue('C' . $row_number, strtoupper($row['nombre_solici'])); // nombre del solicitante
    $sheet->setCellValue('D' . $row_number, strtoupper($row['documento_s'])); // documento solicitante
    $sheet->setCellValue('E' . $row_number, strtoupper($row['nom_jefe']));
    $sheet->setCellValue('F' . $row_number, $row['correo_jefe']); // correo del coordinador
    $sheet->setCellValue('G' . $row_number, $row['num_fich']);
    $sheet->setCellValue('H' . $row_number, strtoupper($row['codigo'])); // Codigo
    $sheet->setCellValue('I' . $row_number, strtoupper($row['nombre']));
    $sheet->setCellValue('J' . $row_number, strtoupper($row['und_medida']));
    $sheet->setCellValue('K' . $row_number, strtoupper($row['cantidad_solicitada']));
    $sheet->setCellValue('L' . $row_number, strtoupper($row['cantidad_entregada'])); // Supuse que "cantidad entregada" es igual a "cantidad solicitada"
    $sheet->setCellValue('M' . $row_number, strtoupper($row['observaciones'])); // Observaciones

    $row_number++;
}

// Ajustar automáticamente el ancho de las columnas para que se ajusten al contenido
foreach (range('A', 'M') as $columna) {
    $sheet->getColumnDimension($columna)->setAutoSize(true);
}

// Configurar los encabezados HTTP para la descarga del archivo Excel
$filename = ($tipoReporte === 'mensual') ? 'reporte_mensual.xlsx' : 'reporte_anual.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Guardar el archivo Excel en el flujo de salida (output)
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Cerrar la conexión a la base de datos
$conexion->close();
?>
