<?php
// Iniciar sesión
include ('../../PHP/Funciones.php');

InicioSesion();

// Verificar si la sesión contiene el identificador del usuario
if (!isset($_SESSION['id'])) {
    die("No se ha iniciado sesión.");
}

// Incluir el archivo de conexión a la base de datos
include ('../../PHP/Conexion.php');

$usuario_id = $_SESSION['id'];

// Incluir PhpSpreadsheet
require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Ruta de la plantilla
$plantilla = '../../Composer/vendor/Excel/plantilla_solicitud.xlsx';

// Crear un objeto PhpSpreadsheet a partir de la plantilla
$spreadsheet = IOFactory::load($plantilla);

// Obtener la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Consultar los datos de la base de datos
$sql = "SELECT sp.*, a.nombre_ambiente AS nombre_ambiente,
               tc.nombre_cuent AS nombre_cuent, ar.nombre AS nombre
        FROM solicitud_periodica sp 
        INNER JOIN ambiente a ON sp.area = a.id_ambiente
        INNER JOIN tipo_cuentadante tc ON sp.tipo_cuentadante = tc.id_cuentadante
        INNER JOIN area ar ON sp.dest_bien = ar.id
        ORDER BY sp.id DESC LIMIT 1";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Si hay datos, recorrer el resultado y asignarlos a las celdas
    $row = $result->fetch_assoc();
    $sheet->setCellValue('C5', $row['fecha_soli']); // Fecha de Solicitud
    $sheet->setCellValue('H5', strtoupper($row['nombre_ambiente'])); // Area
    $sheet->setCellValue('C6', $row['cod_regi']); //Codigo regional
    $sheet->setCellValue('C7', $row['cod_costo']); //Codigo de costos
    $sheet->setCellValue('H6', strtoupper($row['nom_regi'])); //Nombre regional
    $sheet->setCellValue('H7', strtoupper($row['nom_costo'])); //Nombre de costos
    $sheet->setCellValue('E8', strtoupper($row['nom_jefe'])); // Nombre del Coordinador
    $sheet->setCellValue('C9', strtoupper($row['nombre_cuent'])); // Tipo cuentadante
    $sheet->setCellValue('E17', strtoupper($row['nombre'])); // Destino de bienes
    $sheet->setCellValue('F18', strtoupper($row['num_fich'])); // Ficha de caracterizacion
    $sheet->setCellValue('C37', strtoupper($row['nom_jefe'])); // Nombre del coordinador
    $sheet->setCellValue('H37', strtoupper($row['cargo'])); // Cargo

}
$result->free();

// Obtener el último id_solicitud insertado
$sql_last_solicitud = "SELECT MAX(id) AS last_id_solicitud FROM solicitud_periodica";
$result_last_solicitud = $conexion->query($sql_last_solicitud);

if ($result_last_solicitud->num_rows > 0) {
    $row_last_solicitud = $result_last_solicitud->fetch_assoc();
    $id_solicitud = $row_last_solicitud['last_id_solicitud'];
} else {
    echo "No se encontraron solicitudes.";
    exit;
}

// Consulta para obtener los datos del cuentadante según el id de la solicitud

$sql_cuentadante = "
    SELECT c.nombre, c.documento 
    FROM cuentadante c
    INNER JOIN cuentadante_solicitud cs ON c.id = cs.id_cuentadante
    WHERE cs.id_solicitud = ?
";

$stmt = $conexion->prepare($sql_cuentadante);
$stmt->bind_param('i', $id_solicitud);
$stmt->execute();
$result_cuentadante = $stmt->get_result();

if ($result_cuentadante->num_rows > 0) {
    $row_count = 0; // Contador de filas
    $row_number = 13; // Comienza en la fila 13

    // Capturar el primer valor de la base de datos y establecerlo en G10 y J10
    $row_cuentadante = $result_cuentadante->fetch_assoc();
    $sheet->setCellValue('G10', strtoupper($row_cuentadante['nombre'])); // Cambia 'Nombre' según tu necesidad
    $sheet->setCellValue('J10', strtoupper($row_cuentadante['documento'])); // Cambia 'Documento' según tu necesidad

    // Ahora procesar el resto de los datos
    while ($row_cuentadante = $result_cuentadante->fetch_assoc()) {
        if ($row_count < 4) { // Asegurarse de no superar las 4 filas disponibles
            // Calcular la fila actual dinámicamente
            $current_row = $row_number + $row_count;
            // Establecer valores en las celdas correspondientes
            $sheet->setCellValue('C' . $current_row, strtoupper($row_cuentadante['nombre']));
            $sheet->setCellValue('H' . $current_row, strtoupper($row_cuentadante['documento']));
            $row_count++;
        } else {
            break;
        }
    }
} else {
    echo "No se encontraron registros para el cuentadante.";
}
$stmt->close();
$result_cuentadante->free();



// Consulta para obtener los datos del elemento según el id de la solicitud
$sql_elemento = "
    SELECT e.codigo, e.nombre, e.und_medida, e.cantidad_solicitada, 
           e.cantidad_entregada, e.observaciones 
    FROM elemento e
    INNER JOIN elementos_solicitud_periodica es ON e.id_elemento = es.id_elemento
    WHERE es.id_solicitud = ?
";

$stmt = $conexion->prepare($sql_elemento);
$stmt->bind_param('i', $id_solicitud);
$stmt->execute();
$result_elemento = $stmt->get_result();

if ($result_elemento->num_rows > 0) {
    $row_number = 21; // Comienza en la fila 21
    while ($row_elemento = $result_elemento->fetch_assoc()) {
        $sheet->setCellValue('B' . $row_number, strtoupper($row_elemento['codigo'])); // Codigo
        $sheet->setCellValue('C' . $row_number, strtoupper($row_elemento['nombre'])); // Descripción de bien
        $sheet->setCellValue('E' . $row_number, strtoupper($row_elemento['und_medida'])); // Unidad de medida
        $sheet->setCellValue('F' . $row_number, strtoupper($row_elemento['cantidad_solicitada'])); // Cantidad Solicitada
        $sheet->setCellValue('G' . $row_number, strtoupper($row_elemento['cantidad_entregada'])); // Cantidad Entregada
        $sheet->setCellValue('H' . $row_number, strtoupper($row_elemento['observaciones'])); // Observaciones
        $row_number++; // Avanza a la siguiente fila
    }
} else {
    echo "No se encontraron registros para el elemento.";
}

$stmt->close();
$result_elemento->free();

// Cerrar la conexión
$conexion->close();

// Configurar los encabezados HTTP para la descarga del archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Solicitud.xlsx"');
header('Cache-Control: max-age=0');


// Guardar el archivo Excel en el flujo de salida (output)
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit();
?>