<?php

require '../../Composer/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
include('../../PHP/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo'])) {
        $archivoTemporal = $_FILES['archivo']['tmp_name'];

        if (empty($archivoTemporal)) {
            echo"<script>alert('No se ha proporcionado ningún archivo');
            window.location.href = '../UsuariossAdmin.php';</script>";
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
            if (count($datos) !== 4) {
                echo"<script>alert('Error: El archivo Excel debe contener exactamente 4 columnas.');
                window.location.href = '../UsuariossAdmin.php';</script>";
                exit();
            }

            // Verificar si la llave primaria ya existe
            $sqlCheck = "SELECT COUNT(*) FROM usuario WHERE id_usuario = ?";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bind_param('i', $datos[0]);
            $stmtCheck->execute();
            $stmtCheck->bind_result($cantidadFilas);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($cantidadFilas > 0) {
                echo "<script>alert('El id del usuario ya existe');
                window.location.href = '../UsuariossAdmin.php';</script>";
                exit();
            }

// Preparar la consulta SQL para insertar los datos en la tabla
$sql = "INSERT INTO usuario (id_usuario, nombre, contrasena, rol) VALUES (?, ?, ?, ? )";
$stmt = $conexion->prepare($sql);

// Vincular los parámetros y ejecutar la consulta
$stmt->bind_param('isss', $datos[0], $datos[1], $datos[2], $datos[3]);
$stmt->execute();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

echo "<script>alert('Datos insertados correctamente');
window.location.href = '../UsuariossAdmin.php';</script>";
} else {
    echo "<script>alert('No se ha proporcionado ningún archivo');
    window.location.href = '../UsuariossAdmin.php';</script>";
}
}
?>