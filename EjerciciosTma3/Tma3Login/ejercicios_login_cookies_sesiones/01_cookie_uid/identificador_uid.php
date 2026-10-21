<?php
/**
 * Funcionalidad: Identificador único de visitante mediante Cookie UID.
 * 
 * Genera un UID alfanumérico seguro en la primera visita y lo recuerda durante 1 año.
 * Procesa la acción de borrado antes de emitir cualquier cabecera o salida HTML.
 */
require_once __DIR__ . '/../helpers.php';

// 1. Procesar acción de borrado ANTES de cualquier cabecera o salida HTML
if (isset($_GET['borrar'])) {
    setcookie('UID', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    header('Location: identificador_uid.php?borrado=1');
    exit;
}

// 2. Comprobar si existe la cookie de UID válida (5 caracteres alfanuméricos)
$identificador = $_COOKIE['UID'] ?? '';
$esNuevo = !preg_match('/^[A-Za-z0-9]{5}$/', (string)$identificador);

if ($esNuevo) {
    // Generar un UID aleatorio seguro de 5 caracteres
    $identificador = substr(bin2hex(random_bytes(5)), 0, 5);
    setcookie('UID', $identificador, [
        'expires' => time() + 31536000, // 1 año de persistencia
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 01 · Identificador UID</title>
</head>
<body>
    <?php renderizarNavegacion('01 · Identificador UID (Cookie)', '../index.php'); ?>

    <h1>Identificador Único de Visitante</h1>

    <?php if (isset($_GET['borrado'])): ?>
        <p><strong>La cookie UID ha sido eliminada correctamente. Al recargar serás un visitante nuevo.</strong></p>
    <?php endif; ?>

    <p>
        <?php if ($esNuevo): ?>
            ¡Hola desconocido! A partir de ahora te recordaré con este identificador:
            <strong>UID = <?= escaparHtml($identificador) ?></strong>
        <?php else: ?>
            ¡Hola de nuevo! Te conozco mediante tu cookie:
            <strong>UID = <?= escaparHtml($identificador) ?></strong>
        <?php endif; ?>
    </p>

    <p>
        La cookie <code>UID</code> tiene una caducidad de 1 año (<code>time() + 31536000</code>), directiva <code>HttpOnly</code> y directiva <code>SameSite=Lax</code>.
    </p>

    <p>
        <a href="identificador_uid.php">Recargar página</a> &middot;
        <a href="?borrar=1">Borrar Cookie UID</a>
    </p>
</body>
</html>
