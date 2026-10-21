<?php
    $sumandos = isset($_COOKIE["sumandos"]) ? unserialize($_COOKIE["sumandos"]) : [];

    echo "<h2>Numeros introducidos</h2>";
    if (!empty($sumandos)) {
        echo "<br>" . implode(" + ", $sumandos) . " = " . array_sum($sumandos);
    } else {
        echo "No hay números introducidos.";
    }
?>

<br><br>
<a href="num1.php"><button type="button">Volver</button></a>