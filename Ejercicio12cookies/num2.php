<?php
// 1. Obtener la cantidad de sumandos:
// En la primera llamada (desde num1.php) viene por POST. En las siguientes, se lee de la cookie.
if (isset($_POST["cantidad"])) {
    $cantidad = (int)$_POST["cantidad"];
    setcookie("cantidad", $cantidad);
} elseif (isset($_COOKIE["cantidad"])) {
    $cantidad = (int)$_COOKIE["cantidad"];
} else {
    // Si no existe la cantidad, volvemos al inicio
    header("Location: num1.php");
    exit;
}

// 2. Recuperar el array de sumandos acumulados de la cookie (o inicializarlo vacío)
$sumandos = array();
if (isset($_COOKIE["sumandos"])) {
    $datos = @unserialize($_COOKIE["sumandos"]);
    if (is_array($datos)) {
        $sumandos = $datos;
    }
}

// 3. Procesar el nuevo sumando SOLO si ha sido enviado (evita el Warning en la primera visita)
if (isset($_POST["sumando"]) && $_POST["sumando"] !== "") {
    $sumandos[] = (int)$_POST["sumando"];
    setcookie("sumandos", serialize($sumandos));
    $_COOKIE["sumandos"] = serialize($sumandos);
}

// 4. El contador es la cantidad de números que ya hemos guardado
$contador = count($sumandos);

// 5. Si ya se han introducido todos los sumandos solicitados, ir a num3.php
if ($contador >= $cantidad) {
    header("Location: num3.php");
    exit;
}
?>
<form action="num2.php" method="post">
    Introduce el sumando numero <?php echo $contador + 1; ?> (1..10)
    <input type="number" name="sumando" min="1" max="10" required autofocus><br>
    <input type="submit" value="Siguiente">
</form>
