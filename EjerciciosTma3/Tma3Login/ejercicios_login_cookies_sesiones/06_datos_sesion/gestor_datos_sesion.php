<?php
/**
 * Funcionalidad: Gestor de almacenamiento de tipos y objetos en sesión.
 * 
 * Panel unificado para crear, inspeccionar e interactuar con objetos serializados en sesión.
 */
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/Punto.php';

session_start();

$mensajeAccion = '';

// Procesar limpieza de la sesión del ejercicio
if (isset($_GET['limpiar'])) {
    unset($_SESSION['entero'], $_SESSION['real'], $_SESSION['texto'], $_SESSION['fecha'], $_SESSION['semaforo'], $_SESSION['punto']);
    header('Location: gestor_datos_sesion.php?limpiado=1');
    exit;
}

if (isset($_GET['limpiado'])) {
    $mensajeAccion = 'Los datos del ejercicio han sido eliminados de la sesión.';
}

// Acción interactiva: Desplazar el punto en la sesión
if ((($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') && isset($_POST['mover_punto'])) {
    if (isset($_SESSION['punto']) && $_SESSION['punto'] instanceof Punto) {
        $dx = floatval($_POST['dx'] ?? 0);
        $dy = floatval($_POST['dy'] ?? 0);
        $_SESSION['punto']->desplazar($dx, $dy);
        $mensajeAccion = "Se ha desplazado el Punto sumando DX: {$dx} y DY: {$dy}.";
    }
}

$tieneDatos = isset($_SESSION['entero']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 06 · Gestor de Datos de Sesión</title>
</head>
<body>
    <?php renderizarNavegacion('06 · Gestor de Tipos de Datos y Objetos en Sesión', '../index.php'); ?>

    <h1>Gestor de Datos y Objetos POO en Sesión</h1>
    <p>
        Demostración de la capacidad de PHP para guardar en <code>$_SESSION</code> tipos escalares (enteros, decimales, textos), fechas, arrays y objetos con métodos propios de la clase <code>Punto</code>.
    </p>

    <?php if ($mensajeAccion): ?>
        <p><strong><?= escaparHtml($mensajeAccion) ?></strong></p>
    <?php endif; ?>

    <p>
        <a href="crearSesion.php">Crear / Reinicializar datos en sesión</a> &middot;
        <a href="recuperarSesion.php">Ver vista clásica de recuperación</a>
        <?php if ($tieneDatos): ?>
            &middot; <a href="?limpiar=1">Limpiar datos de sesión</a>
        <?php endif; ?>
    </p>

    <?php if ($tieneDatos): ?>
        <h2>Estado actual de los datos en $_SESSION</h2>
        <ul>
            <li>Entero: <strong><?= escaparHtml($_SESSION['entero']) ?></strong></li>
            <li>Decimal / Real: <strong><?= escaparHtml($_SESSION['real']) ?></strong></li>
            <li>Texto: <strong><?= escaparHtml($_SESSION['texto']) ?></strong></li>
            <li>Fecha (DateTime): <strong><?= escaparHtml($_SESSION['fecha'] instanceof DateTimeInterface ? $_SESSION['fecha']->format('Y-m-d') : 'No válido') ?></strong></li>
            <li>Array Semáforo: <code><?= escaparHtml(json_encode($_SESSION['semaforo'], JSON_UNESCAPED_UNICODE)) ?></code></li>
            <li>Instancia de Clase Punto: <strong><?= escaparHtml($_SESSION['punto'] instanceof Punto ? $_SESSION['punto']->describir() : (string)$_SESSION['punto']) ?></strong></li>
        </ul>

        <?php if (isset($_SESSION['punto']) && $_SESSION['punto'] instanceof Punto): ?>
            <h3>Interactuar con el objeto Punto persistido</h3>
            <p>
                Al enviar el formulario, el objeto recuperado de la sesión ejecuta su método <code>desplazar()</code> y vuelve a guardarse en sesión.
            </p>

            <form method="post">
                <input type="hidden" name="mover_punto" value="1">
                <p>
                    <label for="dx">Desplazamiento X (&Delta;X):</label><br>
                    <input type="number" step="0.5" id="dx" name="dx" value="1.0" required>
                </p>
                <p>
                    <label for="dy">Desplazamiento Y (&Delta;Y):</label><br>
                    <input type="number" step="0.5" id="dy" name="dy" value="-0.5" required>
                </p>
                <p>
                    <button type="submit">Desplazar Punto</button>
                </p>
            </form>
        <?php endif; ?>

    <?php else: ?>
        <p>No hay datos creados todavía. Pulsa el enlace anterior para crear la sesión.</p>
    <?php endif; ?>
</body>
</html>
