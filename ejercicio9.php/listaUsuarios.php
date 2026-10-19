<?php
require_once __DIR__ . '/funciones.php';

$loginFallido = false;
$usuarioActivo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Intento de login procedente de login.php
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $recordar = isset($_POST['recordar']);

    if (validarCredenciales($usuario, $password)) {
        iniciarSesion($usuario, $recordar);
        $usuarioActivo = $usuario;
    } else {
        $loginFallido = true;
    }
} else {
    // Acceso por GET: verificar si hay sesión activa en cookie
    $usuarioActivo = obtenerUsuarioActivo();
    if ($usuarioActivo === null) {
        $loginFallido = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $loginFallido ? 'Error de Autenticación' : 'Lista de Usuarios - Mensajería' ?></title>
    <?php if ($loginFallido): ?>
        <!-- Redirección automática tras 3 segundos si el login no tiene éxito -->
        <meta http-equiv="refresh" content="3;url=login.php">
    <?php endif; ?>
</head>
<body>
    <div class="container">
        <?php if ($loginFallido): ?>
            <!-- Pantalla informativa de login no exitoso -->
            <div class="redirect-box">
                <div class="spinner"></div>
                <div class="alert alert-error" style="justify-content: center;">
                    <strong>Error de autenticación:</strong> Usuario o contraseña incorrectos.
                </div>
                <p>Será redirigido automáticamente a la pantalla de login en <strong id="segundos">3</strong> segundos...</p>
                <div style="margin-top: 20px;">
                    <a href="login.php" class="btn btn-primary">Volver al login de inmediato</a>
                </div>
            </div>

            <script>
                var segundos = 3;
                var intervalo = setInterval(function() {
                    segundos--;
                    var elem = document.getElementById('segundos');
                    if (elem && segundos >= 0) {
                        elem.textContent = segundos;
                    }
                    if (segundos <= 0) {
                        clearInterval(intervalo);
                        window.location.href = 'login.php';
                    }
                }, 1000);
            </script>
        <?php else: ?>
            <!-- Pantalla principal: Lista de usuarios -->
            <div class="header">
                <div>
                    <h1>Mensajería</h1>
                    <p style="margin-top: 4px;">
                        Usuario activo: <span class="user-badge"><?= htmlspecialchars($usuarioActivo) ?></span>
                    </p>
                </div>
                <div>
                    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                </div>
            </div>

            <?php if (isset($_GET['enviado']) && $_GET['enviado'] === '1'): ?>
                <div class="alert alert-success">
                    ✓ Mensaje enviado correctamente.
                </div>
            <?php endif; ?>

            <h2>Usuarios disponibles</h2>
            <p style="margin-bottom: 16px;">
                A continuación se muestran los usuarios y el número de mensajes que te ha enviado cada uno:
            </p>

            <?php
            $todosUsuarios = obtenerUsuarios();
            $otrosUsuarios = [];
            foreach (array_keys($todosUsuarios) as $nombreUsuario) {
                if ($nombreUsuario !== $usuarioActivo) {
                    $otrosUsuarios[] = $nombreUsuario;
                }
            }
            ?>

            <?php if (empty($otrosUsuarios)): ?>
                <div class="alert alert-info">
                    No hay otros usuarios registrados en el sistema. Puedes registrar uno nuevo desde la pantalla de registro.
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario (Mensajes recibidos)</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($otrosUsuarios as $otro): ?>
                                <?php 
                                    $numMensajes = contarMensajes($otro, $usuarioActivo);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($otro) ?></strong>
                                        <span class="badge <?= $numMensajes > 0 ? 'badge-blue' : 'badge-gray' ?>">
                                            (<?= $numMensajes ?>)
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions" style="justify-content: flex-end;">
                                            <?php if ($numMensajes > 0): ?>
                                                <a href="leer.php?de=<?= urlencode($otro) ?>" class="btn btn-primary btn-sm">Leer</a>
                                            <?php endif; ?>
                                            <a href="escribir.php?para=<?= urlencode($otro) ?>" class="btn btn-outline-primary btn-sm">Escribir</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="links-footer">
                <p>¿Quieres registrar otro usuario? <a href="registrar.php">Registrar nuevo usuario</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
