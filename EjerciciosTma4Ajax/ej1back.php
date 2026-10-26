<?php
$numRand = rand(1, 3);
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "Desconocido";
switch ($numRand) {
    case 1:
        echo "<h1 style='color:red'>Que tal estas $nombre</h1>";
        break;
    case 2:
        echo "<h2 style='color:green'>Que tal estas $nombre</h2>";
        break;
    case 3:
        echo "<h3 style='color:blue'>Que tal estas $nombre</h3>";
        break;
}
