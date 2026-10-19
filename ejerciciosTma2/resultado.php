<?php
include_once './utilHTML.php';

$colores = ['R' => 'Rojo', 'G' => 'Verde', 'B' => 'Azul'];

// Recogemos la selección mediante método GET
$seleccionados = $_GET['color'] ?? [];

$elementosSeleccionados = [];
if (!empty($seleccionados) && is_array($seleccionados)) {
    foreach ($seleccionados as $clave) {
        if (isset($colores[$clave])) {
            $elementosSeleccionados[] = $colores[$clave];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado - Bullet Points</title>
</head>
<body>

    <h2>Elementos seleccionados:</h2>

    <?php if (!empty($elementosSeleccionados)): ?>
        <?= pintarBulletPoints($elementosSeleccionados) ?>
    <?php else: ?>
        <p style="color: red;">No se ha seleccionado ningún elemento.</p>
    <?php endif; ?>

    <br>
    <a href="EJCLASE.PHP">Volver a la selección</a>

</body>
</html>
