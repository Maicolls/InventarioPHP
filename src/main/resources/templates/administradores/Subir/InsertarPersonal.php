<?php

require '../../Composer/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo "<script>alert('Error: No se ha seleccionado ningún archivo.');
                window.location.href = '../PersonalCenigrafAdmin.php';</script>";
            exit();
        }

        // Procesar el archivo Excel
        $documento = IOFactory::load($archivoTemporal);
        $hojaActual = $documento->getActiveSheet();

        $filas = $hojaActual->getRowIterator();
        $numFilas = 0;
        $filaInicial = true; // Flag para omitir la primera fila
        foreach ($filas as $fila) {
            if ($filaInicial) {
                $filaInicial = false;
                continue;
            }

            $celdas = $fila->getCellIterator();
            $celdas->setIterateOnlyExistingCells(false); // This ensures empty cells are iterated too
            $datos = [];

            foreach ($celdas as $celda) {
                $valor = trim($celda->getValue());
                $datos[] = $valor; // Include all cells, even if empty
            }

            // Verificar la cantidad de columnas esperada
            if (count($datos) !== 7) {
                echo "<script>alert('Error: El archivo Excel debe contener exactamente 7 columnas.');
                    window.location.href = '../PersonalCenigrafAdmin.php';</script>";
                exit();
            }

            // Check if row is empty or has missing essential data
            if (empty($datos[0]) || empty($datos[1]) || empty($datos[2]) || empty($datos[3]) || empty($datos[4]) || empty($datos[5]) || empty($datos[6])) {
                continue;
            }

            // Verificar si la llave primaria ya existe
            $sqlCheck = "SELECT COUNT(*) FROM instructor WHERE cedula = ?";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bind_param('i', $datos[0]);
            $stmtCheck->execute();
            $stmtCheck->bind_result($cantidadFilas);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($cantidadFilas > 0) {
                // Si ya existe, continuar con la siguiente fila
                continue;
            }

            // Obtener el ID del rol basado en el nombre del rol
            $sqlRol = "SELECT id_rol FROM rol WHERE nombre = ?";
            $stmtRol = $conexion->prepare($sqlRol);
            $stmtRol->bind_param('s', $datos[5]);
            $stmtRol->execute();
            $stmtRol->bind_result($rolId);
            $stmtRol->fetch();
            $stmtRol->close();

            if (empty($rolId)) {
                echo "<script>alert('Error: No se encontró el rol especificado.');
                    window.location.href = '../PersonalCenigrafAdmin.php';</script>";
                exit();
            }

            // Obtener el ID de la especialidad basado en el nombre de la especialidad
            $sqlEspecialidad = "SELECT id FROM especialidad WHERE nombre_especialidad = ?";
            $stmtEspecialidad = $conexion->prepare($sqlEspecialidad);
            $stmtEspecialidad->bind_param('s', $datos[6]);
            $stmtEspecialidad->execute();
            $stmtEspecialidad->bind_result($especialidadId);
            $stmtEspecialidad->fetch();
            $stmtEspecialidad->close();

            if (empty($especialidadId)) {
                echo "<script>alert('Error: No se encontró la especialidad especificada.');
                    window.location.href = '../PersonalCenigrafAdmin.php';</script>";
                exit();
            }

            // Encriptar la contraseña tomando en cuenta el hash realizado
            $contrasena_hash = password_hash($datos[4], PASSWORD_DEFAULT);

            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO instructor (cedula, nombre_instructor, celular, correo, contrasena, rol, especialidad) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('issssii', $datos[0], $datos[1], $datos[2], $datos[3], $contrasena_hash, $rolId, $especialidadId);
            $stmt->execute();
            $numFilas++;
        }

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();

        echo "<script>alert('Datos insertados correctamente');
            window.location.href = '../PersonalCenigrafAdmin.php';</script>";
    } else {
        echo "Error: No se ha proporcionado ningún archivo.";
    }
}
?>