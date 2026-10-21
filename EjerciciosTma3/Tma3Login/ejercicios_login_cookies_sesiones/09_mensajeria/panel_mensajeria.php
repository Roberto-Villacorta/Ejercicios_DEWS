<?php
/**
 * Funcionalidad: Panel central y enrutador de la aplicación de mensajería privada.
 */
require_once __DIR__ . '/common.php';

if (!empty($_SESSION['activo'])) {
    header('Location: listaUsuarios.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
