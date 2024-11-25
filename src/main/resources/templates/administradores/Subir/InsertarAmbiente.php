<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo"<script>alert('No se ha proporcionado ningún archivo');
            window.location.href = '../AmbientesAdmin.php';</script>";
            exit();
        }

        // Procesar el archivo Excel
        $documento = IOFactory::load($archivoTemporal);
        $hojaActual = $documento->getActiveSheet();

        $filas = $hojaActual->getRowIterator();

        $datos_a_insertar = array();

        $filaInicial = true; // Flag para omitir la primera fila
        foreach ($filas as $fila) {
            if ($filaInicial) {
                $filaInicial = false;
                continue;
            }
        
            $celdas = $fila->getCellIterator();
            $datos = [];
        
            foreach ($celdas as $celda) {
                $valor = trim($celda->getValue());
            
                // Contar solo celdas con datos
                if ($valor !== "") {
                    $datos[] = $valor;
                }
            }
        
            if (count($datos) !== 3) {
                echo"<script>alert('Error: El archivo Excel debe contener exactamente 3 columnas (sin contar la primera columna).');
                window.location.href = '../AmbientesAdmin.php';</script>";
                exit();
            }
            
            $datos_a_insertar[] = $datos;
        }

        // Iterar sobre los datos recopilados y realizar las inserciones en la base de datos
        foreach ($datos_a_insertar as $datos) {
            // Verificar si el ambiente ya existe
            $sqlCheckAmbiente = "SELECT COUNT(*) FROM ambiente WHERE nombre_ambiente = ?";
            $stmtCheckAmbiente = $conexion->prepare($sqlCheckAmbiente);
            $stmtCheckAmbiente->bind_param('s', $datos[0]);
            $stmtCheckAmbiente->execute();
            $stmtCheckAmbiente->bind_result($cantidadAmbientes);
            $stmtCheckAmbiente->fetch();
            $stmtCheckAmbiente->close();
            
            if ($cantidadAmbientes > 0) {
                // Si el ambiente ya existe, pasar a la siguiente casilla
                continue;
            }
            
            // Obtener el ID del área utilizando el nombre del área
            $sqlGetAreaId = "SELECT id FROM area WHERE nombre = ?";
            $stmtGetAreaId = $conexion->prepare($sqlGetAreaId);
            $stmtGetAreaId->bind_param('s', $datos[2]); // Aquí se está utilizando $datos[2] como el nombre del área
            $stmtGetAreaId->execute();
            $stmtGetAreaId->bind_result($idArea);
            $stmtGetAreaId->fetch();
            $stmtGetAreaId->close();
            
            if (!$idArea) {
                echo "<script>alert('El nombre del área no existe');
                window.location.href = '../AmbientesAdmin.php';</script>";
                exit();
            }
            
            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO ambiente (nombre_ambiente, descripcion, id_area) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('ssi', $datos[0], $datos[1], $idArea);
            $stmt->execute();

            // Cerrar el statement
            $stmt->close();
        }

        // Cerrar la conexión
        $conexion->close();
        
        echo "<script>alert('Datos insertados correctamente');
        window.location.href = '../AmbientesAdmin.php';</script>";
    } 
}
?>
