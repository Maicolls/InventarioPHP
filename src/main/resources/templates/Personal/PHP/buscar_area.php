<?php

include ('../../PHP/Conexion.php');

$texto = $conexion->real_escape_string($_POST['texto']);

// Consulta para buscar ambientes
$resultadoAmbiente = $conexion->query("SELECT id_ambiente, nombre_ambiente FROM ambiente WHERE nombre_ambiente LIKE '%$texto%'");

$areas = [];
while ($fila = $resultadoAmbiente->fetch_assoc()) {
    $areas[] = [
        'id' => $fila['id_ambiente'],
        'nombre' => $fila['nombre_ambiente']
    ];
}

// Consulta para buscar coordinadores
$resultadoCoordinador = $conexion->query("SELECT id, nombre_instructor FROM instructor WHERE rol = 2 AND nombre_instructor LIKE '%$texto%'");

$coordinadores = [];
while ($fila = $resultadoCoordinador->fetch_assoc()) {
    $coordinadores[] = [
        'id' => $fila['id'],
        'nombre' => $fila['nombre_instructor']
    ];
}

// Consulta para buscar fichas
$resultadoFichas = $conexion->query("SELECT numero_ficha, id_programa FROM ficha WHERE numero_ficha LIKE '%$texto%'");

$fichas = [];
while ($fila = $resultadoFichas->fetch_assoc()) {
    $fichas[] = [
        'numFicha' => $fila['numero_ficha'],
        'idPrograma' => $fila['id_programa']
    ];
}


// Combinar los resultados
$resultados = [
    'areas' => $areas,
    'coordinadores' => $coordinadores,
    'fichas' => $fichas
];

echo json_encode($resultados);

?>
