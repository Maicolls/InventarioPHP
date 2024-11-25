<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo"<script>alert('Error: No se ha seleccionado ningún archivo.');
                window.location.href = '../PrincipalAlmacen.php';</script>";
            exit();
        }

        // Procesar el archivo Excel
        $documento = IOFactory::load($archivoTemporal);
        $hojaActual = $documento->getActiveSheet();

        $filas = $hojaActual->getRowIterator();

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

            // Verificar la cantidad de columnas esperada
            if (count($datos) !== 7) {
                echo"<script>alert('Error: El archivo Excel debe contener exactamente 7 columnas.');
                window.location.href = '../PrincipalAlmacen.php';</script>";
                exit();
            }

            // Verificar si el elemento ya existe
            $sqlCheck = "SELECT COUNT(*) FROM elemento WHERE codigo = ?";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bind_param('i', $datos[0]);
            $stmtCheck->execute();
            $stmtCheck->bind_result($cantidadFilas);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($cantidadFilas > 0) {
                // Si el elemento ya existe, pasar a la siguiente fila
                continue;
            }

            // Buscar el ID del ambiente usando el nombre del ambiente
            $nombreAmbiente = $datos[3];
            $sqlAmbiente = "SELECT id_ambiente FROM ambiente WHERE nombre_ambiente = ?";
            $stmtAmbiente = $conexion->prepare($sqlAmbiente);
            $stmtAmbiente->bind_param('s', $nombreAmbiente);
            $stmtAmbiente->execute();
            $stmtAmbiente->bind_result($idAmbiente);
            $stmtAmbiente->fetch();
            $stmtAmbiente->close();

            if (!$idAmbiente) {
                echo "<script>alert('Error: El nombre del ambiente no es válido.');
                window.location.href = '../PrincipalAlmacen.php';</script>";
                exit();
            }

            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO elemento (codigo, descripcion, und_medida, ambiente, cantidad, estado, nombre) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('isssiss', $datos[0], $datos[1], $datos[2], $idAmbiente, $datos[4], $datos[5], $datos[6]);
            $stmt->execute();
        }

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();

        echo "<script>alert('Datos insertados correctamente');
        window.location.href = '../PrincipalAlmacen.php';</script>";
    } else {
        echo "Error: No se ha proporcionado ningún archivo.";
    }
}
?>
