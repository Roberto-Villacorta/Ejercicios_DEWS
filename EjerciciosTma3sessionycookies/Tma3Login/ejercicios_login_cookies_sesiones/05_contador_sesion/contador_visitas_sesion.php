<?php
/**
 * Funcionalidad: Contador de visitas por sesión de usuario.
 * 
 * Gestiona el conteo de accesos utilizando la sesión nativa de PHP.
 * Los datos se destruyen al reiniciar la sesión o cerrar el navegador.
 */
require_once __DIR__ . '/../helpers.php';

session_start();

// Procesar acción de reinicio de sesión
if (isset($_GET['reset'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }
    session_destroy();
    header('Location: contador_visitas_sesion.php?reiniciado=1');
    exit;
}

// Incrementar contador de la sesión
$_SESSION['visitas'] = (int)($_SESSION['visitas'] ?? 0) + 1;
$contadorSesion = $_SESSION['visitas'];
$esPrimeraVisita = ($contadorSesion === 1);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 05 · Contador de Sesión</title>
</head>
<body>
    <?php renderizarNavegacion('05 · Contador con Sesión PHP', '../index.php'); ?>

    <h1>Contador de Visitas por Sesión</h1>

    <?php if (isset($_GET['reiniciado'])): ?>
        <p><strong>La sesión PHP ha sido destruida y el contador se ha restablecido.</strong></p>
    <?php endif; ?>

    <p>
        <?php if ($esPrimeraVisita): ?>
            Primera visita en esta sesión: <strong><?= $contadorSesion ?></strong>
        <?php else: ?>
            Visitas registradas en esta sesión: <strong><?= $contadorSesion ?></strong>
        <?php endif; ?>
    </p>

    <ul>
        <li>Identificador de Sesión (Session ID): <code><?= escaparHtml(session_id()) ?></code></li>
        <li>Persistencia: En memoria del servidor (se pierde al cerrar la sesión o el navegador).</li>
    </ul>

    <p>
        <a href="contador_visitas_sesion.php">Contar otra visita (Recargar)</a> &middot;
        <a href="?reset=1">Reiniciar Sesión</a>
    </p>
</body>
</html>
