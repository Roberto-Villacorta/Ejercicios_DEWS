<?php
require_once __DIR__ . '/funciones.php';

// Verificar que el usuario tenga sesión activa mediante cookie
$usuarioActivo = obtenerUsuarioActivo();
if ($usuarioActivo === null) {
    header('Location: login.php');
    exit;
}

// Obtener el remitente desde el parámetro GET
$remitente = trim($_GET['de'] ?? '');

// Comprobar que el remitente no esté vacío
if ($remitente === '') {
    header('Location: listaUsuarios.php');
    exit;
}

/**
 * CONTROL DE SEGURIDAD CRÍTICO:
 * Solo se obtienen y muestran los mensajes donde:
 * - 'de' es el remitente recibido por GET ($remitente)
 * - 'para' es OBLIGATORIAMENTE el usuario activo ($usuarioActivo) de la cookie.
 * 
 * Si un usuario intenta añadir parámetros como ?para=otroUsuario en la URL,
 * dichos parámetros son ignorados por completo en el servidor.
 */
$mensajes = obtenerMensajesRecibidos($remitente, $usuarioActivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de <?= htmlspecialchars($remitente) ?> - Mensajería</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Mensajes Recibidos</h1>
                <p style="margin-top: 4px;">
                    De: <strong><?= htmlspecialchars($remitente) ?></strong> | 
                    Para: <span class="user-badge"><?= htmlspecialchars($usuarioActivo) ?></span>
                </p>
            </div>
            <div class="actions">
                <a href="listaUsuarios.php" class="btn btn-secondary btn-sm">Volver a la Lista</a>
                <a href="escribir.php?para=<?= urlencode($remitente) ?>" class="btn btn-primary btn-sm">Responder</a>
            </div>
        </div>

        <?php if (empty($mensajes)): ?>
            <div class="alert alert-info">
                No tienes mensajes recibidos de <strong><?= htmlspecialchars($remitente) ?></strong>.
            </div>
        <?php else: ?>
            <h2>Historial de mensajes (<?= count($mensajes) ?>)</h2>
            <div class="mensajes-lista">
                <?php foreach ($mensajes as $msg): ?>
                    <div class="mensaje-item">
                        <div class="mensaje-header">
                            <span><strong>De:</strong> <?= htmlspecialchars($msg['de']) ?></span>
                            <span>📅 <?= htmlspecialchars($msg['fecha']) ?></span>
                        </div>
                        <div class="mensaje-texto"><?= nl2br(htmlspecialchars($msg['texto'])) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
            <a href="listaUsuarios.php" class="btn btn-secondary">← Volver a Lista de Usuarios</a>
            <a href="escribir.php?para=<?= urlencode($remitente) ?>" class="btn btn-primary">Escribir a <?= htmlspecialchars($remitente) ?></a>
        </div>
    </div>
</body>
</html>
