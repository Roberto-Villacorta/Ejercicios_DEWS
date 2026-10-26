<?php
/**
 * Funcionalidad: Formulario asistente de registro por pasos (Wizard).
 * 
 * Conserva el estado parcial de cada paso en $_SESSION['form'], permitiendo
 * avanzar, retroceder y editar campos específicos antes de la confirmación final.
 */
require_once __DIR__ . '/../helpers.php';

session_start();

// Inicializar datos del formulario en sesión si no existen
$_SESSION['form'] ??= [
    'paso' => 1,
    'nombre' => '',
    'email' => '',
    'ciudad' => ''
];
$datosFormulario = &$_SESSION['form'];

// Procesar reinicio del proceso
if (isset($_GET['reset'])) {
    unset($_SESSION['form']);
    header('Location: registro_multipaso.php');
    exit;
}

// Procesar envío de cada paso
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $pasoActual = (int)($datosFormulario['paso'] ?? 1);

    if ($pasoActual === 1) {
        $datosFormulario['nombre'] = trim($_POST['nombre'] ?? '');
    } elseif ($pasoActual === 2) {
        $datosFormulario['email'] = trim($_POST['email'] ?? '');
    } elseif ($pasoActual === 3) {
        $datosFormulario['ciudad'] = trim($_POST['ciudad'] ?? '');
    }

    $accion = $_POST['a'] ?? 'next';

    if ($accion === 'back') {
        $datosFormulario['paso'] = max(1, $pasoActual - 1);
    } elseif ($accion === 'edit1') {
        $datosFormulario['paso'] = 1;
    } elseif ($accion === 'edit2') {
        $datosFormulario['paso'] = 2;
    } elseif ($accion === 'edit3') {
        $datosFormulario['paso'] = 3;
    } elseif ($accion === 'finalizar') {
        $datosFormulario['completado'] = true;
        $datosFormulario['paso'] = 4;
    } else {
        $datosFormulario['paso'] = min(4, $pasoActual + 1);
    }

    header('Location: registro_multipaso.php');
    exit;
}

$pasoActual = (int)($datosFormulario['paso'] ?? 1);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 07 · Registro Multipaso</title>
</head>
<body>
    <?php renderizarNavegacion('07 · Asistente de Registro Multipaso', '../index.php'); ?>

    <h1>Registro Multipaso en Sesión</h1>
    <p>Paso <?= $pasoActual ?> de 4</p>

    <?php if ($pasoActual === 1): ?>
        <!-- PASO 1: Nombre -->
        <form method="post">
            <p>
                <label for="nombre">Nombre completo:</label><br>
                <input id="nombre" name="nombre" value="<?= escaparHtml($datosFormulario['nombre']) ?>" placeholder="Escribe tu nombre" required autofocus>
            </p>
            <p>
                <button type="submit" name="a" value="next">Siguiente paso &rarr;</button>
            </p>
        </form>

    <?php elseif ($pasoActual === 2): ?>
        <!-- PASO 2: Email -->
        <form method="post">
            <p>
                <label for="email">Dirección de correo electrónico:</label><br>
                <input type="email" id="email" name="email" value="<?= escaparHtml($datosFormulario['email']) ?>" placeholder="ejemplo@correo.com" required autofocus>
            </p>
            <p>
                <button type="submit" name="a" value="back" formnovalidate>&larr; Paso anterior</button>
                <button type="submit" name="a" value="next">Siguiente paso &rarr;</button>
            </p>
        </form>

    <?php elseif ($pasoActual === 3): ?>
        <!-- PASO 3: Ciudad -->
        <form method="post">
            <p>
                <label for="ciudad">Ciudad de residencia:</label><br>
                <input id="ciudad" name="ciudad" value="<?= escaparHtml($datosFormulario['ciudad']) ?>" placeholder="ej. Madrid, Barcelona..." required autofocus>
            </p>
            <p>
                <button type="submit" name="a" value="back" formnovalidate>&larr; Paso anterior</button>
                <button type="submit" name="a" value="next">Ver resumen &rarr;</button>
            </p>
        </form>

    <?php else: ?>
        <!-- PASO 4: Resumen y confirmación -->
        <h2>Resumen de datos recopilados</h2>
        <ul>
            <li>Nombre: <strong><?= escaparHtml($datosFormulario['nombre']) ?></strong></li>
            <li>Email: <strong><?= escaparHtml($datosFormulario['email']) ?></strong></li>
            <li>Ciudad: <strong><?= escaparHtml($datosFormulario['ciudad']) ?></strong></li>
        </ul>

        <form method="post">
            <p>
                <button type="submit" name="a" value="edit1">Editar nombre</button>
                <button type="submit" name="a" value="edit2">Editar email</button>
                <button type="submit" name="a" value="edit3">Editar ciudad</button>
                <a href="?reset=1">Reiniciar formulario</a>
            </p>
        </form>
    <?php endif; ?>
</body>
</html>
