<?php
/**
 * Funcionalidad: Registro de nuevos usuarios en la plataforma de mensajería.
 */
require_once __DIR__ . '/common.php';

$mensajeEstado = '';
$esExito = false;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_.-]{3,30}$/', $usuario) || strlen($password) < 6) {
        $mensajeEstado = 'El nombre de usuario debe tener entre 3 y 30 caracteres alfanuméricos y la contraseña al menos 6 caracteres.';
    } elseif (isset($_SESSION['usuarios'][$usuario])) {
        $mensajeEstado = 'El nombre de usuario ya está registrado. Por favor, elige otro.';
    } else {
        $_SESSION['usuarios'][$usuario] = password_hash($password, PASSWORD_DEFAULT);
        $mensajeEstado = "El usuario '{$usuario}' ha sido registrado con éxito. Ya puedes iniciar sesión.";
        $esExito = true;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 09 · Registrar Usuario</title>
</head>
<body>
    <?php renderizarNavegacion('09 · Registro de Usuario', '../index.php', [
        'Ir al Login' => 'login.php'
    ]); ?>

    <h1>Registro de Nuevo Usuario</h1>

    <?php if ($mensajeEstado): ?>
        <p><strong><?= escaparHtml($mensajeEstado) ?></strong></p>
    <?php endif; ?>

    <?php if ($esExito): ?>
        <p>
            <a href="login.php">Ir a Iniciar Sesión con mi nueva cuenta</a>
        </p>
    <?php else: ?>
        <form method="post">
            <p>
                <label for="usuario">Nombre de usuario (3-30 caracteres):</label><br>
                <input id="usuario" name="usuario" placeholder="ej. usuario_demo" required autofocus>
            </p>

            <p>
                <label for="password">Contraseña (mínimo 6 caracteres):</label><br>
                <input type="password" id="password" name="password" placeholder="Tu contraseña segura" required>
            </p>

            <p>
                <button type="submit">Completar Registro</button> &middot;
                <a href="login.php">Ya tengo cuenta, iniciar sesión</a>
            </p>
        </form>
    <?php endif; ?>
</body>
</html>
