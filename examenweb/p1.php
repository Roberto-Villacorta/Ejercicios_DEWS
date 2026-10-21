<?php
session_start();

// Si venimos de pulsar "Volver a introducir verbos", borramos los anteriores
if (isset($_GET['reset'])) {
    $_SESSION['palabras'] = [];
    session_destroy();
    session_start();
}

if (!isset($_SESSION['palabras'])) {
    $_SESSION['palabras'] = [];
}

// Procesar el envío evitando duplicados (y normalizando a minúsculas)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verbo = strtolower(trim($_POST['verbo'] ?? ''));
    if ($verbo !== '' && !in_array($verbo, $_SESSION['palabras'])) {
        $_SESSION['palabras'][] = $verbo;
    }

    // Si se pulsó el botón "Ver Conjugación", redirigimos a p2.php habiendo guardado el verbo
    if (isset($_POST['ver_conjugacion'])) {
        header("Location: p2.php");
        exit;
    }
}
?>

<form action="p1.php" method="post">
    <label for="verbo">Introduce un verbo en infinitivo</label>
    <input type="text" name="verbo" id="verbo" autofocus>
    <input type="submit" name="enviar" value="Enviar">
    <button type="submit" name="ver_conjugacion" value="1">Ver Conjugación</button>
</form>