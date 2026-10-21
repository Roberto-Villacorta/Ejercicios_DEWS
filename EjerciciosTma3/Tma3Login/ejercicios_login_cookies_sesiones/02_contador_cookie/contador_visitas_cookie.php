<?php
/**
 * Funcionalidad: Contador de visitas persistente mediante Cookie.
 * 
 * Gestiona el conteo de accesos persistido en el navegador del cliente.
 * Procesa el reinicio antes de emitir cabeceras o salidas HTML.
 */
require_once __DIR__ . '/../helpers.php';

// 1. Procesar acción de reinicio ANTES de leer o modificar el contador
if (isset($_GET['reset'])) {
    setcookie('visitas', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    header('Location: contador_visitas_cookie.php?reiniciado=1');
    exit;
}

// 2. Leer cookie actual y validar que sea un entero no negativo
$visitasCookie = filter_var($_COOKIE['visitas'] ?? 0, FILTER_VALIDATE_INT);
$visitasValidadas = ($visitasCookie === false || $visitasCookie < 0) ? 0 : $visitasCookie;

$esPrimeraVisita = ($visitasValidadas === 0);
$totalVisitas = $visitasValidadas + 1;

// 3. Guardar el nuevo valor en la cookie
setcookie('visitas', (string)$totalVisitas, [
    'expires' => time() + 31536000, // Duración: 1 año
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 02 · Contador de Visitas con Cookie</title>
</head>
<body>
    <?php renderizarNavegacion('02 · Contador de Visitas con Cookie', '../index.php'); ?>

    <h1>Contador de Visitas Persistente</h1>

    <?php if (isset($_GET['reiniciado'])): ?>
        <p><strong>El contador de visitas ha sido reiniciado a cero con éxito.</strong></p>
    <?php endif; ?>

    <p>
        <?php if ($esPrimeraVisita): ?>
            <strong>BIENVENIDO</strong>. Esta es tu primera visita a esta página.
        <?php else: ?>
            <strong>Hola de nuevo</strong>. Es la vez número <strong><?= $totalVisitas ?></strong> que visitas esta página.
        <?php endif; ?>
    </p>

    <p>
        Esta cookie reside en el navegador del cliente y persiste durante un año aunque se cierre el navegador.
    </p>

    <p>
        <a href="contador_visitas_cookie.php">Contar otra visita (Recargar)</a> &middot;
        <a href="?reset=1">Reiniciar Contador</a>
    </p>
</body>
</html>
