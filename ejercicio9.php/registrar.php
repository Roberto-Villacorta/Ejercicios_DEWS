<?php
require_once __DIR__ . '/funciones.php';

$mensajeError = '';
$mensajeExito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($usuario === '' || $password === '') {
        $mensajeError = 'Por favor, completa todos los campos.';
    } elseif (strlen($usuario) < 3) {
        $mensajeError = 'El nombre de usuario debe tener al menos 3 caracteres.';
    } else {
        if (registrarUsuario($usuario, $password)) {
            $mensajeExito = "¡Usuario '$usuario' registrado con éxito! Ya puedes iniciar sesión.";
        } else {
            $mensajeError = "El usuario '$usuario' ya está registrado. Por favor, elige otro nombre.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Mensajería</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registro de Usuario</h1>
            <a href="login.php" class="btn btn-secondary btn-sm">Volver a Login</a>
        </div>

        <?php if ($mensajeError !== ''): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($mensajeError) ?>
            </div>
        <?php endif; ?>

        <?php if ($mensajeExito !== ''): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($mensajeExito) ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="login.php" class="btn btn-primary">Ir a Iniciar Sesión</a>
            </div>
        <?php else: ?>
            <form action="registrar.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input 
                        type="text" 
                        id="usuario" 
                        name="usuario" 
                        class="form-control" 
                        value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" 
                        required 
                        autocomplete="off"
                        placeholder="Elige tu nombre de usuario"
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        required 
                        autocomplete="new-password"
                        placeholder="Crea una contraseña"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block">Registrar Usuario</button>
            </form>

            <div class="links-footer">
                <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
