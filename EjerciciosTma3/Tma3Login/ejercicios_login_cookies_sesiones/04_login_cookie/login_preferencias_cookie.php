<?php
/**
 * Funcionalidad: Autenticación y preferencias recordadas con cookies.
 * 
 * Permite iniciar sesión a usuarios válidos y recordar sus preferencias (banderas, conexiones)
 * en una cookie serializada en formato JSON si marca la casilla "Recordar".
 */
require_once __DIR__ . '/../helpers.php';

session_start();

// Credenciales válidas de demostración
$usuariosValidos = [
    'ana' => 'clave123',
    'pepe' => 'secreto'
];

// Recuperar perfil guardado en cookie si existe
$datosPerfil = json_decode($_COOKIE['perfil'] ?? '{}', true) ?: [];
$mensajeError = '';
$mensajeExito = '';

// Procesar cierre de sesión (Logout)
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    setcookie('perfil', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    header('Location: login_preferencias_cookie.php?bye=1');
    exit;
}

if (isset($_GET['bye'])) {
    $mensajeExito = 'Has cerrado sesión correctamente y se han borrado las preferencias recordadas.';
}

// Procesar formulario de login
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $banderasSeleccionadas = $_POST['banderas'] ?? ($datosPerfil['banderas'] ?? []);
    
    // Filtrar banderas válidas
    $banderasDisponibles = ['ES', 'FR', 'IT', 'DE', 'UK', 'PT'];
    $banderasValidadas = array_values(array_intersect($banderasDisponibles, (array)$banderasSeleccionadas));

    if (isset($usuariosValidos[$usuario]) && hash_equals($usuariosValidos[$usuario], $password)) {
        // Usuario correcto
        $esMismoUsuario = ($datosPerfil['usuario'] ?? '') === $usuario;
        $numConexiones = $esMismoUsuario ? (($datosPerfil['conexiones'] ?? 0) + 1) : 1;

        $datosPerfil = [
            'usuario' => $usuario,
            'conexiones' => $numConexiones,
            'banderas' => $banderasValidadas
        ];

        // Si marcó recordar, guardar en cookie por 30 días
        if (isset($_POST['recordar'])) {
            setcookie('perfil', json_encode($datosPerfil), [
                'expires' => time() + 2592000,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }

        $_SESSION['usuario_autenticado'] = $usuario;
        $_SESSION['datos_perfil'] = $datosPerfil;
        header('Location: login_preferencias_cookie.php');
        exit;
    } else {
        $mensajeError = 'Usuario o contraseña incorrectos. Revisa las credenciales de prueba.';
    }
}

$estaAutenticado = isset($_SESSION['usuario_autenticado']);
$usuarioActivo = $_SESSION['usuario_autenticado'] ?? '';
$perfilActivo = $_SESSION['datos_perfil'] ?? $datosPerfil;
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 04 · Login y Cookie de Preferencias</title>
</head>
<body>
    <?php renderizarNavegacion('04 · Login y Cookies de Preferencias', '../index.php'); ?>

    <h1>Login y Preferencias en Cookie</h1>

    <?php if ($mensajeExito): ?>
        <p><strong><?= escaparHtml($mensajeExito) ?></strong></p>
    <?php endif; ?>

    <?php if ($mensajeError): ?>
        <p><strong><?= escaparHtml($mensajeError) ?></strong></p>
    <?php endif; ?>

    <?php if ($estaAutenticado): ?>
        <h2>Bienvenido/a de nuevo, <?= escaparHtml($usuarioActivo) ?></h2>
        
        <h3>Datos de tu perfil y preferencias:</h3>
        <ul>
            <li>Veces conectado: <strong><?= intval($perfilActivo['conexiones'] ?? 1) ?></strong></li>
            <li>
                Banderas favoritas:
                <?php if (!empty($perfilActivo['banderas'])): ?>
                    <?= escaparHtml(implode(', ', $perfilActivo['banderas'])) ?>
                <?php else: ?>
                    <em>Ninguna seleccionada</em>
                <?php endif; ?>
            </li>
        </ul>

        <p>
            <a href="?logout=1">Desconectar y borrar cookie</a>
        </p>

    <?php else: ?>
        <p>Inicia sesión para comprobar el almacenamiento de preferencias en cookies.</p>
        <p><small>Credenciales de prueba: <code>ana</code> / <code>clave123</code> o <code>pepe</code> / <code>secreto</code></small></p>

        <form method="post">
            <p>
                <label for="usuario">Nombre de usuario:</label><br>
                <input id="usuario" name="usuario" value="<?= escaparHtml($datosPerfil['usuario'] ?? '') ?>" placeholder="ana o pepe" required>
            </p>

            <p>
                <label for="password">Contraseña:</label><br>
                <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
            </p>

            <p>Banderas favoritas:</p>
            <p>
                <?php foreach (['ES', 'FR', 'IT', 'DE', 'UK', 'PT'] as $bandera): ?>
                    <label>
                        <input type="checkbox" name="banderas[]" value="<?= $bandera ?>"
                            <?= in_array($bandera, $datosPerfil['banderas'] ?? [], true) ? 'checked' : '' ?>>
                        <?= $bandera ?>
                    </label>
                <?php endforeach; ?>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="recordar" checked>
                    Recordar usuario y preferencias en una cookie persistente (30 días)
                </label>
            </p>

            <p>
                <button type="submit">Iniciar Sesión</button>
            </p>
        </form>
    <?php endif; ?>
</body>
</html>
