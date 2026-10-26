<?php
/**
 * Configuración común y arranque de sesión para la mensajería privada.
 */
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Mensaje.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['usuarios'] ??= [];
$_SESSION['mensajes'] ??= [];

// Usuarios predefinidos de prueba si la lista está vacía
if (empty($_SESSION['usuarios'])) {
    $_SESSION['usuarios']['ana'] = password_hash('clave123', PASSWORD_DEFAULT);
    $_SESSION['usuarios']['pepe'] = password_hash('secreto', PASSWORD_DEFAULT);

    $_SESSION['mensajes'][] = [
        'de' => 'ana',
        'para' => 'pepe',
        'texto' => 'Hola Pepe, bienvenido a la plataforma de mensajería interna.',
        'fecha' => date('Y-m-d H:i:s')
    ];
}
