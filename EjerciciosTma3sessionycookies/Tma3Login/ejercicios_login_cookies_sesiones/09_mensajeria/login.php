<?php
/**
 * Funcionalidad: Autenticación de usuarios en la plataforma de mensajería.
 */
require_once __DIR__ . '/common.php';

$mensajeError = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($_SESSION['usuarios'][$usuario]) && password_verify($password, $_SESSION['usuarios'][$usuario])) {
        $_SESSION['activo'] = $usuario;

        if (isset($_POST['recordar'])) {
            setcookie('ultimo_usuario', $usuario, [
                'expires' => time() + 2592000,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }

        header('Location: listaUsuarios.php');
        exit;
    }

    $mensajeError = 'Usuario o contraseña incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 09 · Mensajería - Iniciar Sesión</title>
</head>
<body>
    <?php renderizarNavegacion('09 · Mensajería Privada (Login)', '../index.php', [
        'Registrar nuevo usuario' => 'registrar.php'
    ]); ?>

    <h1>Mensajería Privada · Acceso</h1>
    <p>Inicia sesión con tu cuenta para acceder a la bandeja de mensajes privados.</p>
    <p><small>Usuarios disponibles: <code>ana</code> / <code>clave123</code> &bull; <code>pepe</code> / <code>secreto</code></small></p>

    <?php if ($mensajeError): ?>
        <p><strong><?= escaparHtml($mensajeError) ?></strong></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="usuario">Nombre de usuario:</label><br>
            <input id="usuario" name="usuario" value="<?= isset($_COOKIE['ultimo_usuario']) ? escaparHtml($_COOKIE['ultimo_usuario']) : '' ?>" placeholder="ana o pepe" required autofocus>
        </p>

        <p>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
        </p>

        <p>
            <label>
                <input type="checkbox" name="recordar">
                Recordar usuario en una cookie
            </label>
        </p>

        <p>
            <button type="submit">Entrar a la mensajería</button> &middot;
            <a href="registrar.php">Crear una cuenta nueva</a>
        </p>
    </form>
</body>
</html>
