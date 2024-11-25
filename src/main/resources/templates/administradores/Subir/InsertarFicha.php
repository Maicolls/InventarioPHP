<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo "<script>alert('No se ha proporcionado ningún archivo');
            window.location.href = '../FichasAdmin.php';</script>";
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
   // Depuración: Mostrar los datos leídos de cada fila
   var_dump($datos);
            // Verificar la cantidad de columnas esperada
            if (count($datos) !== 2) {
                echo "<script>alert('Error: El archivo Excel debe contener exactamente 2 columnas.');
                window.location.href = '../FichasAdmin.php';</script>";
                exit();
            }

            // $datos[0] es el número de la ficha, $datos[1] es el nombre del programa
            $numeroFicha = $datos[0];
            $nombrePrograma = $datos[1];

            // Verificar si el número de ficha ya existe en la base de datos
            $sqlCheckFicha = "SELECT COUNT(*) FROM ficha WHERE numero_ficha = ?";
            $stmtCheckFicha = $conexion->prepare($sqlCheckFicha);
            if ($stmtCheckFicha === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }
            $stmtCheckFicha->bind_param('i', $numeroFicha);
            $stmtCheckFicha->execute();
            $stmtCheckFicha->bind_result($count);
            $stmtCheckFicha->fetch();
            $stmtCheckFicha->close();

            if ($count > 0) {
                // Si el número de ficha ya existe, pasa a la siguiente fila
                continue;
            }

            // Verificar si la llave foránea (nombre del programa) existe y obtener su ID
            $sqlCheckPrograma = "SELECT id_programa FROM programa WHERE nombre_programa = ?";
            $stmtCheckPrograma = $conexion->prepare($sqlCheckPrograma);
            if ($stmtCheckPrograma === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }
            $stmtCheckPrograma->bind_param('s', $nombrePrograma);
            $stmtCheckPrograma->execute();
            $stmtCheckPrograma->bind_result($idPrograma);
            $stmtCheckPrograma->fetch();
            $stmtCheckPrograma->close();

            if (empty($idPrograma)) {
                echo "<script>alert('El nombre del programa \"{$nombrePrograma}\" no existe. Por favor, verifica que el nombre esté correcto.');
                window.location.href = '../FichasAdmin.php';</script>";
                exit();
            }

            // Preparar la consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO ficha (numero_ficha, id_programa) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($conexion->error));
            }

            // Vincular los parámetros y ejecutar la consulta
            $stmt->bind_param('ii', $numeroFicha, $idPrograma);
            $stmt->execute();
            $stmt->close();
        }

        // Cerrar la conexión
        $conexion->close();

        echo "<script>alert('Datos insertados correctamente');
        window.location.href = '../FichasAdmin.php';</script>";
    }
}
?>
