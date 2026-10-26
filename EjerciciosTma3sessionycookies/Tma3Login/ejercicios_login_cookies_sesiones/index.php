<?php
/**
 * Índice Centralizado - Ejercicios de Cookies, Sesiones y Login
 * Asignatura: Desarrollo Web en Entorno Servidor (DEWS)
 * 
 * Enlaza directamente a los ficheros nombrados según su funcionalidad específica.
 */
require_once __DIR__ . '/helpers.php';

// Limpieza para pruebas
$mensajeEstado = '';
if (isset($_GET['limpiar_todo'])) {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $partes = explode('=', $cookie);
            $nombre = trim($partes[0]);
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => '/']);
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => '']);
        }
    }
    session_start();
    $_SESSION = [];
    session_destroy();
    header('Location: index.php?limpiado=1');
    exit;
}

if (isset($_GET['limpiado'])) {
    $mensajeEstado = 'Se han restablecido todas las cookies y sesiones de prueba.';
}

$ejercicios = [
    [
        'numero' => '01',
        'fichero' => 'identificador_uid.php',
        'ruta' => '01_cookie_uid/identificador_uid.php',
        'titulo' => 'Identificador Único de Visitante (Cookie UID)',
        'descripcion' => 'Genera y persiste un identificador criptográfico único (UID) para reconocer al usuario entre distintas visitas.'
    ],
    [
        'numero' => '02',
        'fichero' => 'contador_visitas_cookie.php',
        'ruta' => '02_contador_cookie/contador_visitas_cookie.php',
        'titulo' => 'Contador de Visitas Persistente con Cookie',
        'descripcion' => 'Registra cuántas veces ha entrado el usuario utilizando una cookie con duración de un año.'
    ],
    [
        'numero' => '03',
        'fichero' => 'ambito_rutas_cookies.php',
        'ruta' => '03_ambito_cookies/ambito_rutas_cookies.php',
        'titulo' => 'Ámbito y Jerarquía de Rutas de Cookies',
        'descripcion' => 'Demostración práctica de cómo el parámetro path restringe la visibilidad de las cookies entre niveles (Nivel 0, Nivel 1 y Nivel 2).'
    ],
    [
        'numero' => '04',
        'fichero' => 'login_preferencias_cookie.php',
        'ruta' => '04_login_cookie/login_preferencias_cookie.php',
        'titulo' => 'Login y Preferencias Recordadas con Cookies',
        'descripcion' => 'Inicio de sesión con usuarios de prueba y persistencia opcional de banderas en una cookie JSON.'
    ],
    [
        'numero' => '05',
        'fichero' => 'contador_visitas_sesion.php',
        'ruta' => '05_contador_sesion/contador_visitas_sesion.php',
        'titulo' => 'Contador de Visitas por Sesión de Usuario',
        'descripcion' => 'Lleva el conteo de visitas durante la sesión activa de PHP.'
    ],
    [
        'numero' => '06',
        'fichero' => 'gestor_datos_sesion.php',
        'ruta' => '06_datos_sesion/gestor_datos_sesion.php',
        'titulo' => 'Serialización de Tipos y Objetos POO en Sesión',
        'descripcion' => 'Almacena y recupera datos en $_SESSION (enteros, decimales, textos, DateTime, arrays y la clase humana Punto).'
    ],
    [
        'numero' => '07',
        'fichero' => 'registro_multipaso.php',
        'ruta' => '07_registro_pasos/registro_multipaso.php',
        'titulo' => 'Formulario Asistente Multipaso (Wizard)',
        'descripcion' => 'Formulario en 4 fases que almacena temporalmente los datos en sesión.'
    ],
    [
        'numero' => '09',
        'fichero' => 'panel_mensajeria.php',
        'ruta' => '09_mensajeria/panel_mensajeria.php',
        'titulo' => 'Sistema de Mensajería Privada entre Usuarios',
        'descripcion' => 'Plataforma con registro de cuentas, login, listado de usuarios, lectura y envío de mensajes.'
    ]
];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Índice Central · Cookies, Sesiones y Login</title>
</head>
<body>
    <h1>Login, Cookies y Sesiones en PHP</h1>
    <p>Panel centralizado de prácticas de DEWS. Cada ejercicio está organizado por su funcionalidad específica y cuenta con enlace de regreso a este menú principal.</p>

    <p>
        <a href="?limpiar_todo=1" onclick="return confirm('¿Seguro que deseas reiniciar todas las cookies y datos de sesión?')">
            Restablecer todas las cookies y sesiones de prueba
        </a>
    </p>

    <?php if ($mensajeEstado): ?>
        <p><strong><?= escaparHtml($mensajeEstado) ?></strong></p>
    <?php endif; ?>

    <hr>

    <ol>
        <?php foreach ($ejercicios as $ej): ?>
            <li>
                <p>
                    <strong><a href="<?= escaparHtml($ej['ruta']) ?>"><?= escaparHtml($ej['titulo']) ?></a></strong>
                    (Fichero: <code><?= escaparHtml($ej['fichero']) ?></code>)
                </p>
                <p><?= escaparHtml($ej['descripcion']) ?></p>
            </li>
        <?php endforeach; ?>
    </ol>

    <hr>
    <footer>
        <p><small>Desarrollo Web en Entorno Servidor &bull; PHP 8.x</small></p>
    </footer>
</body>
</html>
