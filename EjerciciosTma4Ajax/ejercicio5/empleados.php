<?php
$empleadosBD = [
    ["nombre" => "Pepe", "apellido" => "García", "telefono" => "637 654 654"],
    ["nombre" => "Ana", "apellido" => "García", "telefono" => "637 111 654"],
    ["nombre" => "Manolo", "apellido" => "González", "telefono" => "637 654 654"],
    ["nombre" => "Beatriz", "apellido" => "Ruiz", "telefono" => "612 999 888"],
    ["nombre" => "Carlos", "apellido" => "Pérez", "telefono" => "644 222 333"],
    ["nombre" => "Elena", "apellido" => "Gómez", "telefono" => "677 333 444"],
    ["nombre" => "David", "apellido" => "Romero", "telefono" => "688 555 111"]
];

$campo = isset($_REQUEST['campo']) ? strtolower(trim($_REQUEST['campo'])) : 'nombre';
$texto = isset($_REQUEST['texto']) ? trim($_REQUEST['texto']) : '';

$camposPermitidos = [
    'nombre'   => 'nombre',
    'apellido' => 'apellido',
    'telefono' => 'telefono'
];

$campoFiltrar = $camposPermitidos[$campo] ?? 'nombre';

$resultados = [];
if ($texto === '') {
    $resultados = $empleadosBD;
} else {
    foreach ($empleadosBD as $empleado) {
        if (stripos($empleado[$campoFiltrar], $texto) !== false) {
            $resultados[] = $empleado;
        }
    }
}

if (isset($_REQUEST['format']) && $_REQUEST['format'] === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($resultados)) {
    echo "<tr><td colspan='3' style='text-align: center; color: #888; font-style: italic; padding: 12px;'>No se encontraron empleados que cumplan el filtro.</td></tr>";
} else {
    foreach ($resultados as $emp) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($emp['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($emp['apellido']) . "</td>";
        echo "<td>" . htmlspecialchars($emp['telefono']) . "</td>";
        echo "</tr>";
    }
}
