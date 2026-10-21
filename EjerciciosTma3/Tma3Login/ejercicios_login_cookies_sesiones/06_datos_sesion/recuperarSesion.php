<?php
/**
 * Funcionalidad: Recuperación e inspección de datos serializados en sesión.
 * 
 * Recupera y muestra los datos almacenados previamente en la sesión,
 * deserializando correctamente el objeto Punto.
 */
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/Punto.php';

session_start();
$sesionInicializada = isset($_SESSION['entero']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 06 · Recuperar Datos de Sesión</title>
</head>
<body>
    <?php renderizarNavegacion('06 · Recuperar Datos de Sesión', '../index.php', [
        'Gestor de Sesión' => 'gestor_datos_sesion.php',
        'Crear Sesión' => 'crearSesion.php'
    ]); ?>

    <h1>Recuperación de Datos de Sesión</h1>

    <?php if (!$sesionInicializada): ?>
        <p>No hay datos registrados en la sesión actual. Por favor, crea primero la sesión.</p>
        <p>
            <a href="crearSesion.php">Crear datos de sesión ahora</a>
        </p>
    <?php else: ?>
        <p>A continuación se muestran los seis tipos de datos recuperados de <code>$_SESSION</code>:</p>

        <ul>
            <li>Entero: <strong><?= escaparHtml($_SESSION['entero']) ?></strong></li>
            <li>Real: <strong><?= escaparHtml($_SESSION['real']) ?></strong></li>
            <li>Texto: <strong><?= escaparHtml($_SESSION['texto']) ?></strong></li>
            <li>Fecha: <strong><?= escaparHtml($_SESSION['fecha'] instanceof DateTimeInterface ? $_SESSION['fecha']->format('Y-m-d') : 'No válido') ?></strong></li>
            <li>Semáforo: <code><?= escaparHtml(json_encode($_SESSION['semaforo'], JSON_UNESCAPED_UNICODE)) ?></code></li>
            <li>Punto: <strong><?= escaparHtml($_SESSION['punto'] instanceof Punto ? $_SESSION['punto']->describir() : (string)$_SESSION['punto']) ?></strong></li>
        </ul>

        <p>
            <a href="crearSesion.php">Regenerar datos</a> &middot;
            <a href="gestor_datos_sesion.php">Ir al panel del ejercicio</a>
        </p>
    <?php endif; ?>
</body>
</html>
