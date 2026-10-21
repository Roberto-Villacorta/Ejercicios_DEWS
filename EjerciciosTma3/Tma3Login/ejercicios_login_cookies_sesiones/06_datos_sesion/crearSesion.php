<?php
/**
 * Funcionalidad: Creación y almacenamiento de diversos tipos de datos en la sesión.
 * 
 * Almacena seis tipos distintos de datos en $_SESSION, incluyendo una instancia
 * de la clase orientada a objetos Punto.
 */
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/Punto.php';

session_start();

// Reiniciar y poblar la sesión con diferentes tipos de datos
$_SESSION = [];
$_SESSION['entero'] = 42;
$_SESSION['real'] = 3.14159;
$_SESSION['texto'] = 'Hola sesión PHP';
$_SESSION['fecha'] = date_create('2025-05-20');
$_SESSION['semaforo'] = ['r' => 'rojo', 'a' => 'amarillo', 'v' => 'verde'];
$_SESSION['punto'] = new Punto(2.5, 7.8);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 06 · Sesión Creada</title>
</head>
<body>
    <?php renderizarNavegacion('06 · Crear Datos de Sesión', '../index.php', [
        'Gestor de Sesión' => 'gestor_datos_sesion.php',
        'Recuperar Datos' => 'recuperarSesion.php'
    ]); ?>

    <h1>Datos de Sesión Creados</h1>
    <p>Se han guardado correctamente seis tipos de datos en la sesión (entero, float, string, DateTime, array asociativo y objeto Punto).</p>

    <p>
        <a href="recuperarSesion.php">Ver datos recuperados &rarr;</a> &middot;
        <a href="gestor_datos_sesion.php">Panel general del ejercicio</a>
    </p>
</body>
</html>
