<?php

if (!isset($_COOKIE['visita'])) {
    $visitas = 0;
    echo "<h1>Bienvenido a la web</h1>";
} else {   
    $visitas = (int)$_COOKIE['visita'] + 1;
    echo "<h1>Has venido $visitas veces</h1>";
}
setcookie("visita", (string)$visitas, time() + (86400 * 30), "/");
?>