<?php
/**
 * Funcionalidad: Listado de usuarios y bandeja de mensajes recibidos.
 */
require_once __DIR__ . '/common.php';

if (empty($_SESSION['activo'])) {
    header('Location: login.php');
    exit;
}

$usuarioActual = $_SESSION['activo'];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 09 · Lista de Usuarios</title>
</head>
<body>
    <?php renderizarNavegacion('09 · Bandeja de Mensajería', '../index.php', [
        'Cerrar Sesión' => 'logout.php'
    ]); ?>

    <h1>Bandeja de Mensajería</h1>
    <p>Conectado como: <strong><?= escaparHtml($usuarioActual) ?></strong></p>

    <p>Selecciona un usuario para redactarle un mensaje privado o revisar los mensajes recibidos:</p>

    <ul>
        <?php
        $usuariosEncontrados = 0;
        foreach ($_SESSION['usuarios'] as $usuarioRemoto => $hash):
            if ($usuarioRemoto === $usuarioActual) continue;
            $usuariosEncontrados++;

            $totalMensajesRecibidos = count(array_filter(
                $_SESSION['mensajes'],
                fn($m) => $m['de'] === $usuarioRemoto && $m['para'] === $usuarioActual
            ));
        ?>
            <li>
                <strong><?= escaparHtml($usuarioRemoto) ?></strong>
                (<?= $totalMensajesRecibidos ?> <?= $totalMensajesRecibidos === 1 ? 'mensaje' : 'mensajes' ?>)
                &mdash;
                <?php if ($totalMensajesRecibidos > 0): ?>
                    <a href="leer.php?de=<?= rawurlencode($usuarioRemoto) ?>">Leer mensajes</a> &middot;
                <?php endif; ?>
                <a href="escribir.php?para=<?= rawurlencode($usuarioRemoto) ?>">Escribir mensaje</a>
            </li>
        <?php endforeach; ?>

        <?php if ($usuariosEncontrados === 0): ?>
            <li>No hay otros usuarios registrados en el sistema.</li>
        <?php endif; ?>
    </ul>

    <p>
        <a href="registrar.php">Registrar otro usuario</a> &middot;
        <a href="logout.php">Cerrar sesión</a>
    </p>
</body>
</html>
