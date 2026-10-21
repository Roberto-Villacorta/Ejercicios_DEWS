<?php
/**
 * Funcionalidad: Visibilidad de cookies en Nivel 1.
 */
require_once __DIR__ . '/../../helpers.php';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 03 · Ámbito de Cookies (Nivel 1)</title>
</head>
<body>
    <?php renderizarNavegacion('03 · Ámbito de Cookies (Nivel 1)', '../../index.php', [
        'Volver a Nivel 0' => '../ambito_rutas_cookies.php',
        'Ir a Nivel 2' => 'nivel2/visibilidad_nivel2.php'
    ]); ?>

    <h1>Ámbito de Cookies · Nivel 1</h1>
    <p>
        <strong>Comportamiento de herencia:</strong>
        Aquí son visibles tanto las cookies globales (Nivel 0) como las asignadas específicamente a <code>nivel1/</code>.
        Las cookies asignadas a <code>nivel2/</code> todavía no son visibles aquí.
    </p>

    <h2>Cookies visibles actualmente en Nivel 1</h2>
    <pre><?php
        $visibles = 0;
        foreach ($_COOKIE as $claveCookie => $valor) {
            echo escaparHtml("$claveCookie = $valor") . "\n";
            $visibles++;
        }
        if ($visibles === 0) {
            echo "// No hay cookies visibles en este nivel.\n";
        }
    ?></pre>

    <p>
        <a href="../ambito_rutas_cookies.php">&larr; Volver a Nivel 0</a> &middot;
        <a href="nivel2/visibilidad_nivel2.php">Avanzar a Nivel 2 &rarr;</a>
    </p>
</body>
</html>
