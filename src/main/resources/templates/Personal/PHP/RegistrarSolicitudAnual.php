<?php
include ('../../PHP/Conexion.php');

// Manejar la solicitud de autocompletado
if (isset($_POST['id_elemento']) && !isset($_POST['f_solicitud'])) {
    $id_elemento = $_POST['id_elemento'];

    // Consultar la unidad de medida y disponibilidad asociada al ID del inventario
    $consulta = "SELECT und_medida, cantidad FROM elemento WHERE id_elemento = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id_elemento);
    $stmt->execute();
    $stmt->bind_result($unidad_medida, $disponibilidad);

    if ($stmt->fetch()) {
        echo $unidad_medida . '|' . $disponibilidad; // Devolver la unidad de medida y la disponibilidad como respuesta
    } else {
        echo "Error: No se encontró la unidad de medida para el ID del inventario proporcionado.";
    }

    $stmt->close();
    exit();
}

// Manejar la inserción de la solicitud
if (isset($_POST['f_solicitud'])) {
    // Recibir los datos del formulario
    $fecha_solicitud = $_POST['f_solicitud'];
    $nombre = $_POST['nombre_solicitante'];
    $documento = $_POST['docu'];
    $ficha = $_POST['fi_anu'];
    $programa = $_POST['pro_anu'];

    $elementos = $_POST['nom_elemento'];
    $unidades = $_POST['unidad'];
    $cantidades = $_POST['cantidad'];
    $solicitadas = $_POST['solicitada'];

    //procesar cada elemento individualmente
    for ($i = 0; $i < count($elementos); $i++) {
        list($id_elemento, $nombre_elemento) = explode(',', $elementos[$i]);
        $und_medida = $unidades[$i];
        $cantidad = $cantidades[$i];
        $cantidad_solicitada = $solicitadas[$i];
    }


    // Preparar la consulta SQL para insertar los datos de la solicitud
    $stmt = $conexion->prepare("INSERT INTO solicitud_anual (fecha_soli, nombre_solici, documento, ficha_soli, programa_soli, cantidad_soli	
    ) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisi", $fecha_solicitud, $nombre,$documento, $ficha, $programa, $cantidad_solicitada);

    // Ejecutar la consulta de inserción de solicitud
    if ($stmt->execute()) {
        // Obtener el ID de la solicitud insertada
        $id_solicitud = $stmt->insert_id;

        // Insertar los elementos y sus relaciones con la solicitud
        foreach ($elementos as $elemento) {
            /*$id_elemento = $elemento['id_elemento'];
            $nombre_elemento = $elemento['nom_elemento'];
            $und_medida = $elemento['unidad'];
            $cantidad = $elemento['cantidad'];
            $cantidad_solicitada = $elemento['solicitada'];*/

            // Verificar si el elemento ya existe en la base de datos
            $stmt_verificar_elemento = $conexion->prepare("SELECT id_elemento, cantidad FROM elemento WHERE id_elemento = ?");
            $stmt_verificar_elemento->bind_param("i", $id_elemento);
            $stmt_verificar_elemento->execute();
            $stmt_verificar_elemento->bind_result($id_elemento, $cantidad);
            $stmt_verificar_elemento->store_result();

            if ($stmt_verificar_elemento->num_rows > 0) {
                // El elemento ya existe, obtener su ID y cantidad existente
                $stmt_verificar_elemento->fetch();

                /*// Calcular la nueva cantidad y la cantidad entregada
                $nueva_cantidad = $cantidad + $cantidad_solicitada;*/

                $nueva_cantidad = $cantidad;

                // Actualizar la cantidad del elemento existente
                $stmt_actualizar_elemento = $conexion->prepare("UPDATE elemento SET cantidad = ? WHERE id_elemento = ?");
                $stmt_actualizar_elemento->bind_param("ii", $nueva_cantidad, $id_elemento);
                $stmt_actualizar_elemento->execute();
                $stmt_actualizar_elemento->close();
            } else {
                // El elemento no existe, insertar un nuevo registro
                $stmt_verificar_elemento->close();

                /*// Calcular la cantidad entregada
                $nueva_cantidad = $cantidad + $cantidad_solicitada;*/

                //Agregar cantidad del nuevo elemento como 0
                $cantidad = 0;
                $nueva_cantidad = $cantidad;

                // Preparar la consulta SQL para insertar el nuevo elemento
                $stmt_insertar_elemento = $conexion->prepare("INSERT INTO elemento (nombre, und_medida, cantidad) VALUES (?, ?, ?)");
                $stmt_insertar_elemento->bind_param("sii", $nombre_elemento, $und_medida, $nueva_cantidad);

                // Ejecutar la inserción del nuevo elemento
                if ($stmt_insertar_elemento->execute()) {
                    // Obtener el ID del nuevo elemento insertado
                    $id_elemento = $stmt_insertar_elemento->insert_id;
                } else {
                    die("Error en la inserción de un nuevo elemento: " . $stmt_insertar_elemento->error);
                }

                // Cerrar la consulta para la inserción del nuevo elemento
                $stmt_insertar_elemento->close();
            }

            // Insertar la relación en la tabla `elemento_solicitud_anual`
            $stmt_relacion = $conexion->prepare("INSERT INTO elemento_solicitud_anual (id_solicitud, id_elemento) VALUES (?, ?)");
            $stmt_relacion->bind_param("ii", $id_solicitud, $id_elemento);

            // Ejecutar la consulta
            if (!$stmt_relacion->execute()) {
                die("Error al guardar la relación: " . $stmt_relacion->error);
            }

            // Cerrar la consulta de relación
            $stmt_relacion->close();
        }

        // Redireccionar o realizar otras acciones después de la inserción exitosa
        header('Location:../Subir/ReporteAnualE.php');
        exit();
    } else {
        // Manejar errores en la inserción de la solicitud
        echo "Error en la inserción de solicitud_anual: " . $stmt->error;
    }

    // Cerrar la consulta para la solicitud y la conexión
    $stmt->close();
    $conexion->close();
}
?>