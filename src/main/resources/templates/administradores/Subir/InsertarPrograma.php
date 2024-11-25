<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo "<script>alert('No se ha proporcionado ningún archivo');
            window.location.href = '../ProgramasAdmin.php';</script>";
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
            if (count($datos) !== 2) {
                echo "<script>alert('Error: El archivo Excel debe contener exactamente 2 columnas.');
                window.location.href = '../ProgramasAdmin.php';</script>";
                exit();
            }

            // $datos[0] es el nombre del programa, $datos[1] es el nombre del instructor
            $nombrePrograma = $datos[0];
            $nombreInstructor = $datos[1];

            // Verificar si el programa ya existe en la base de datos
            $sqlCheckProgram = "SELECT id_programa FROM programa WHERE nombre_programa = ?";
            $stmtCheckProgram = $conexion->prepare($sqlCheckProgram);
            if ($stmtCheckProgram === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }
            $stmtCheckProgram->bind_param('s', $nombrePrograma);
            $stmtCheckProgram->execute();
            $stmtCheckProgram->store_result();
            $programExists = $stmtCheckProgram->num_rows > 0;
            $stmtCheckProgram->close();

            // Si el programa ya existe, pasa al siguiente programa en el archivo Excel
            if ($programExists) {
                continue;
            }

            // Verificar si la llave foránea (nombre del instructor) existe y obtener su ID
            $sqlCheckInstructor = "SELECT id FROM instructor WHERE nombre_instructor = ?";
            $stmtCheckInstructor = $conexion->prepare($sqlCheckInstructor);
            if ($stmtCheckInstructor === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }
            $stmtCheckInstructor->bind_param('s', $nombreInstructor);
            $stmtCheckInstructor->execute();
            $stmtCheckInstructor->bind_result($idInstructor);
            $stmtCheckInstructor->fetch();
            $stmtCheckInstructor->close();

            if (empty($idInstructor)) {
                echo "<script>alert('El nombre del instructor \"{$nombreInstructor}\" no existe. Por favor, verifica que el nombre esté correcto.');
                window.location.href = '../ProgramasAdmin.php';</script>";
                exit();
            }

            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO programa (nombre_programa, id_instructor) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('si', $nombrePrograma, $idInstructor);
            $stmt->execute();
            $stmt->close();
        }

        // Cerrar la conexión
        $conexion->close();

        echo "<script>alert('Datos insertados correctamente');
        window.location.href = '../ProgramasAdmin.php';</script>";
    }
}
?>
