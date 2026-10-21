<?php
/**
 * Funcionalidad: Visibilidad de cookies en Nivel 2.
 */
require_once __DIR__ . '/../../../helpers.php';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 03 · Ámbito de Cookies (Nivel 2)</title>
</head>
<body>
    <?php renderizarNavegacion('03 · Ámbito de Cookies (Nivel 2)', '../../../index.php', [
        'Volver a Nivel 1' => '../visibilidad_nivel1.php',
        'Volver a Nivel 0' => '../../ambito_rutas_cookies.php'
    ]); ?>

    <h1>Ámbito de Cookies · Nivel 2</h1>
    <p>
        <strong>Comportamiento de herencia completa:</strong>
        En Nivel 2 convergen todas las cookies: las heredadas de Nivel 0, las de Nivel 1 y las creadas específicamente para este <code>nivel2/</code>.
    </p>

    <h2>Cookies visibles actualmente en Nivel 2</h2>
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
        <a href="../visibilidad_nivel1.php">&larr; Volver a Nivel 1</a> &middot;
        <a href="../../ambito_rutas_cookies.php">Volver a Nivel 0 (Crear más cookies)</a>
    </p>
</body>
</html>
