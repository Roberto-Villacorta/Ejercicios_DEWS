<?php
include_once './utilHTML.php';

$colores = ['R' => 'Rojo', 'G' => 'Verde', 'B' => 'Azul'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio de Clase - Checkboxes</title>
</head>
<body>

    <form action="resultado.php" method="get">
        <fieldset>
            <legend>Selecciona uno o varios colores:</legend>
            <?= pintarCheckboxes('color', $colores) ?>
        </fieldset>
        <br>
        <input type="submit" value="Enviar">
    </form>

</body>
</html> 
