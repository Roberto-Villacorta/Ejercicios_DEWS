<?php
/**
 * Funcionalidad: Redacción y envío de un mensaje privado.
 */
require_once __DIR__ . '/common.php';

if (empty($_SESSION['activo'])) {
    header('Location: login.php');
    exit;
}

$usuarioActual = $_SESSION['activo'];
$destinatario = $_POST['para'] ?? $_GET['para'] ?? '';
$error = '';

if (!isset($_SESSION['usuarios'][$destinatario]) || $destinatario === $usuarioActual) {
    http_response_code(400);
    exit('Destinatario no válido.');
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $textoMensaje = trim($_POST['texto'] ?? '');
    if ($textoMensaje === '') {
        $error = 'El contenido del mensaje no puede estar vacío.';
    } else {
        $_SESSION['mensajes'][] = [
            'de' => $usuarioActual,
            'para' => $destinatario,
            'texto' => $textoMensaje,
            'fecha' => date('Y-m-d H:i:s')
        ];
        header('Location: listaUsuarios.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 09 · Escribir Mensaje</title>
</head>
<body>
    <?php renderizarNavegacion('09 · Escribir Mensaje Privado', '../index.php', [
        'Volver a la bandeja' => 'listaUsuarios.php'
    ]); ?>

    <h1>Escribir Mensaje</h1>
    <p>De: <strong><?= escaparHtml($usuarioActual) ?></strong> &bull; Para: <strong><?= escaparHtml($destinatario) ?></strong></p>

    <?php if ($error): ?>
        <p><strong><?= escaparHtml($error) ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="para" value="<?= escaparHtml($destinatario) ?>">

        <p>
            <label for="texto">Escribe tu mensaje:</label><br>
            <textarea id="texto" name="texto" rows="5" cols="50" placeholder="Escribe aquí tu mensaje privado..." required autofocus></textarea>
        </p>

        <p>
            <button type="submit">Enviar mensaje</button> &middot;
            <a href="listaUsuarios.php">Cancelar y volver</a>
        </p>
    </form>
</body>
</html>
