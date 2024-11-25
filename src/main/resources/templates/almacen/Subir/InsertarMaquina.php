<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo "<script>alert('No se ha proporcionado ningún archivo');
            window.location.href = '../MaquinasAlmacen.php';</script>";
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
            if (count($datos) !== 8) {
                echo "<script>alert('Error: El archivo Excel debe contener exactamente 8 columnas.');
                window.location.href = '../MaquinasAlmacen.php';</script>";
                exit();
            }

            // Verificar si la llave primaria ya existe
            $sqlCheck = "SELECT COUNT(*) FROM maquina WHERE serial = ?";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bind_param('i', $datos[0]);
            $stmtCheck->execute();
            $stmtCheck->bind_result($cantidadFilas);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($cantidadFilas > 0) {
                echo "<script>alert('El id de la máquina ya existe');
                window.location.href = '../MaquinasAlmacen.php';</script>";
                exit();
            }

            // Obtener el id_ambiente basado en el nombre_ambiente
            $nombreAmbiente = $datos[7];
            $sqlCheck = "SELECT id_ambiente FROM ambiente WHERE nombre_ambiente = ?";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bind_param('s', $nombreAmbiente);
            $stmtCheck->execute();
            $stmtCheck->bind_result($idAmbiente);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if (!$idAmbiente) {
                echo "<script>alert('El nombre del ambiente debe existir');
                window.location.href = '../MaquinasAlmacen.php';</script>";
                exit();
            }

            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO maquina (serial, adquisicion, nombre_maquina, modelo, marca, placa, cantidad, id_ambiente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('issssiii', $datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $idAmbiente);
            $stmt->execute();
        }
    
        // Cerrar la conexión
        $stmt->close();
        $conexion->close();

        echo "<script>alert('Datos insertados correctamente');
        window.location.href = '../MaquinasAlmacen.php';</script>";
    } 
}

?>
