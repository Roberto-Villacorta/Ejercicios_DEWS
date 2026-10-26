<?php
/**
 * Funcionalidad: Lectura de mensajes privados recibidos de un remitente.
 */
require_once __DIR__ . '/common.php';

if (empty($_SESSION['activo'])) {
    header('Location: login.php');
    exit;
}

$usuarioActual = $_SESSION['activo'];
$remitente = $_GET['de'] ?? '';

if (!isset($_SESSION['usuarios'][$remitente]) || $remitente === $usuarioActual) {
    http_response_code(400);
    exit('Remitente no válido.');
}

$mensajesFiltrados = array_filter(
    $_SESSION['mensajes'],
    fn($m) => $m['de'] === $remitente && $m['para'] === $usuarioActual
);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 09 · Mensajes de <?= escaparHtml($remitente) ?></title>
</head>
<body>
    <?php renderizarNavegacion('09 · Lectura de Mensajes', '../index.php', [
        'Volver a la lista' => 'listaUsuarios.php',
        'Responder' => 'escribir.php?para=' . rawurlencode($remitente)
    ]); ?>

    <h1>Mensajes recibidos de <?= escaparHtml($remitente) ?></h1>
    <p>(<?= count($mensajesFiltrados) ?> recibidos)</p>

    <?php if (empty($mensajesFiltrados)): ?>
        <p>No hay mensajes de este remitente.</p>
    <?php else: ?>
        <?php foreach ($mensajesFiltrados as $mensaje): ?>
            <div>
                <p>
                    <small>Remitente: <strong><?= escaparHtml($mensaje['de']) ?></strong> &bull; <?= escaparHtml($mensaje['fecha']) ?></small>
                </p>
                <p><?= nl2br(escaparHtml($mensaje['texto'])) ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <p>
        <a href="escribir.php?para=<?= rawurlencode($remitente) ?>">Responder a <?= escaparHtml($remitente) ?></a> &middot;
        <a href="listaUsuarios.php">&larr; Volver a la lista de usuarios</a>
    </p>
</body>
</html>
