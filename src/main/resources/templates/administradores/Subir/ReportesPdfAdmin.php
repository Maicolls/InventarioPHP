<?php
include('../../PHP/Conexion.php'); // Incluye el archivo de conexión a la base de datos

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

// Incluir TCPDF
require '../../Composer/vendor/phpoffice/TCPDF-main/tcpdf.php';


// Crear instancia de TCPDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false); // Cambiar orientación a 'L' para landscape

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Reporte PDF');
$pdf->SetSubject('Reporte en PDF');
$pdf->SetKeywords('TCPDF, PDF, reporte, PHP');

// Establecer márgenes
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Habilitar el salto automático de página
$pdf->SetAutoPageBreak(true, 10); // 10mm de margen inferior para empezar una nueva página

// Agregar una página
$pdf->AddPage();

// Títulos de las columnas
$pdf->SetFont('helvetica', 'B', 8); // Reducir el tamaño de la fuente
$pdf->SetFillColor(200, 220, 255);

$titulos = [
    'FECHA' => 20,
    'NOMBRE AMBIENTE' => 35,
    'NOMBRE SOLICITANTE' => 35,
    'CEDULA' => 25,
    'AUTORIZA' => 30,
    'CORREO' => 40,
    'FICHA' => 20,
    'CODIGO' => 20,
    'NOMBRE DEL ELEMENTO' => 35,
    'UNIDAD' => 20,
    'CANTIDAD SOLICITADA' => 25,
    'OBSERVACIONES' => 50
];

foreach ($titulos as $titulo => $ancho) {
    $pdf->Cell($ancho, 8, $titulo, 1, 0, 'C', 1); // Ajustar el tamaño de la celda y la altura
}
$pdf->Ln();

// Datos de la consulta
$pdf->SetFont('helvetica', '', 8); // Reducir el tamaño de la fuente
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(20, 8, $row['fecha_soli'], 1);
    $pdf->Cell(35, 8, $row['nombre_ambiente'], 1);
    $pdf->Cell(35, 8, $row['nombre_solici'], 1);
    $pdf->Cell(25, 8, $row['documento_s'], 1);
    $pdf->Cell(30, 8, $row['nom_jefe'], 1);
    $pdf->Cell(40, 8, $row['correo_jefe'], 1);
    $pdf->Cell(20, 8, $row['num_fich'], 1);
    $pdf->Cell(20, 8, $row['codigo'], 1);
    $pdf->Cell(35, 8, $row['nombre'], 1);
    $pdf->Cell(20, 8, $row['und_medida'], 1);
    $pdf->Cell(25, 8, $row['cantidad_solicitada'], 1);
    $pdf->MultiCell(50, 8, $row['observaciones'], 1); // MultiCell para observaciones para permitir saltos de línea
}

// Salida del documento
$pdf->Output('reporte.pdf', 'D');

// Cerrar la conexión a la base de datos
$conexion->close();
?>
