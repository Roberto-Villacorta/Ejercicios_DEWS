<?php
/**
 * logout.php
 * Cierra la sesión activa del usuario eliminando la cookie de sesión.
 */
require_once __DIR__ . '/funciones.php';

cerrarSesion();
header('Location: login.php');
exit;
