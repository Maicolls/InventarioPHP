<?php
// obtenerSolicitud.php

// Conectar a la base de datos
include (__DIR__ . '/../../PHP/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si se proporcionó el ID de la solicitud
if (isset($_GET['solicitudId'])) {
    $solicitudId = $_GET['solicitudId'];

   // Consulta SQL para obtener los detalles de la solicitud, sus elementos y cuentadantes asociados
   $query = "SELECT sp.fecha_soli, sp.cod_regi, sp.cod_costo, sp.nom_jefe, sp.area, sp.cargo, sp.nom_regi, sp.nom_costo, sp.tipo_cuentadante, sp.dest_bien, sp.num_fich, e.codigo, e.descripcion, e.und_medida, e.cantidad, e.cantidad_solicitada, e.observaciones, c.nombre AS nom_cuenta, c.documento AS doc_cuenta, sp.firma
   FROM solicitud_periodica sp
   LEFT JOIN elementos_solicitud_periodica esp ON sp.id = esp.id_solicitud
   LEFT JOIN elemento e ON esp.id_elemento = e.id_elemento
   LEFT JOIN cuentadante_solicitud cs ON sp.id = cs.id_solicitud
   LEFT JOIN cuentadante c ON cs.id_cuentadante = c.id
   WHERE sp.id = ?";
    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Asociar parámetros
        $stmt->bind_param("i", $solicitudId);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener resultados
        $result = $stmt->get_result();

        // Verificar si se encontró la solicitud
        if ($result->num_rows > 0) {
            // Inicializar un array para almacenar los detalles de la solicitud
            $detalles = [];
            $cuentadantes = [];

            // Recorrer todas las filas encontradas (debería ser única por ID)
            while ($row = $result->fetch_assoc()) {
                // Crear un arreglo con los detalles de la solicitud
                $detalleSolicitud = [
                    'fecha_soli' => $row['fecha_soli'],
                    'cod_regi' => $row['cod_regi'],
                    'cod_costo' => $row['cod_costo'],
                    'nom_jefe' => $row['nom_jefe'],
                    'area' => $row['area'],
                    'cargo' => $row['cargo'],
                    'nom_regi' => $row['nom_regi'],
                    'nom_costo' => $row['nom_costo'],
                    'tipo_cuentadante' => $row['tipo_cuentadante'],
                    'dest_bien' => $row['dest_bien'],
                    'num_fich' => $row['num_fich'],
                    // Campos de la tabla de elementos
                    'codigo' => $row['codigo'] ?? '',
                    'descripcion' => $row['descripcion'] ?? '',
                    'unidad_medida' => $row['und_medida'] ?? '',
                    'cantidad' => $row['cantidad_solicitada'] ?? '',
                    'observacion' => $row['observaciones'] ?? '',
                    'firma' => base64_encode($row['firma']) // Codificar en base64 la firma para enviarla
                ];

                // Agregar cuentadantes a la solicitud
                if (!empty($row['nom_cuenta'])) {
                    $cuentadante = [
                        'nombre' => $row['nom_cuenta'],
                        'documento' => $row['doc_cuenta']
                    ];
                    $cuentadantes[] = $cuentadante;
                }

                // Añadir detalle de solicitud a los detalles
                $detalles = $detalleSolicitud;
            }

            // Añadir cuentadantes a los detalles
            $detalles['cuentadantes'] = $cuentadantes;

            // Devolver los datos como JSON
            echo json_encode($detalles);
        } else {
            // No se encontró la solicitud con el ID proporcionado
            echo json_encode(['error' => 'No se encontró la solicitud con el ID proporcionado.']);
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        echo json_encode(['error' => 'Error en la preparación de la consulta.']);
    }
} else {
    // No se proporcionó el ID de la solicitud
    echo json_encode(['error' => 'No se proporcionó el ID de la solicitud.']);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
