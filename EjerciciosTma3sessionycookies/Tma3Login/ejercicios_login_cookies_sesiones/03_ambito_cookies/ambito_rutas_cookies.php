<?php
/**
 * Funcionalidad: Ámbito y rutas de cookies (Nivel 0).
 * 
 * Demuestra la visibilidad jerárquica de cookies según el path.
 * Las rutas se determinan dinámicamente para funcionar en cualquier entorno local.
 */
require_once __DIR__ . '/../helpers.php';

// Calcular rutas dinámicas según la ubicación actual del script
$directorioActual = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$rutasValidas = [
    '0' => $directorioActual . '/',
    '1' => $directorioActual . '/nivel1/',
    '2' => $directorioActual . '/nivel1/nivel2/'
];

// Procesar borrado de cookies creadas
if (isset($_GET['borrar_todas'])) {
    foreach ($_COOKIE as $nombre => $valor) {
        if ($nombre !== 'UID' && $nombre !== 'visitas' && $nombre !== 'PHPSESSID') {
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => $rutasValidas['0']]);
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => $rutasValidas['1']]);
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => $rutasValidas['2']]);
            setcookie($nombre, '', ['expires' => time() - 3600, 'path' => '/']);
        }
    }
    header('Location: ambito_rutas_cookies.php?borradas=1');
    exit;
}

// Crear nueva cookie con el ámbito seleccionado
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $nombreCookie = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['nombre'] ?? '');
    $valorCookie = substr(trim($_POST['valor'] ?? ''), 0, 150);
    $nivelSeleccionado = $_POST['nivel'] ?? '0';
    $rutaDestino = $rutasValidas[$nivelSeleccionado] ?? $rutasValidas['0'];

    if ($nombreCookie !== '') {
        setcookie($nombreCookie, $valorCookie, [
            'expires' => time() + 3600,
            'path' => $rutaDestino,
            'samesite' => 'Lax'
        ]);
    }
    header('Location: ambito_rutas_cookies.php?creada=1');
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ejercicio 03 · Ámbito de Cookies (Nivel 0)</title>
</head>
<body>
    <?php renderizarNavegacion('03 · Ámbito y Rutas de Cookies (Nivel 0)', '../index.php', [
        'Ir a Nivel 1' => 'nivel1/visibilidad_nivel1.php',
        'Ir a Nivel 2' => 'nivel1/nivel2/visibilidad_nivel2.php'
    ]); ?>

    <h1>Ámbito y Rutas de Cookies · Nivel 0</h1>
    <p>
        El parámetro <code>path</code> determina qué directorios del servidor pueden leer una cookie.
        Una cookie asignada a una ruta solo es visible en esa ruta y en todos sus subdirectorios hijos.
    </p>

    <?php if (isset($_GET['creada'])): ?>
        <p><strong>Cookie creada exitosamente con el ámbito seleccionado.</strong></p>
    <?php endif; ?>

    <?php if (isset($_GET['borradas'])): ?>
        <p><strong>Se ha solicitado el borrado de las cookies creadas.</strong></p>
    <?php endif; ?>

    <h2>Crear nueva cookie de prueba</h2>
    <form method="post">
        <p>
            <label for="nombre">Nombre de la Cookie:</label><br>
            <input id="nombre" name="nombre" placeholder="ej. mi_cookie" required>
        </p>

        <p>
            <label for="valor">Valor:</label><br>
            <input id="valor" name="valor" placeholder="ej. prueba123" required>
        </p>

        <p>
            <label for="nivel">Ámbito (Ruta / Path):</label><br>
            <select id="nivel" name="nivel">
                <option value="0">Nivel 0 (<?= htmlspecialchars($rutasValidas['0']) ?>)</option>
                <option value="1">Nivel 1 (<?= htmlspecialchars($rutasValidas['1']) ?>)</option>
                <option value="2">Nivel 2 (<?= htmlspecialchars($rutasValidas['2']) ?>)</option>
            </select>
        </p>

        <p>
            <button type="submit">Crear Cookie</button>
        </p>
    </form>

    <h2>Cookies visibles actualmente en Nivel 0</h2>
    <p>
        En Nivel 0 únicamente se ven las cookies cuyo path sea la raíz o Nivel 0 (las asignadas a Nivel 1 o 2 no son visibles aquí):
    </p>
    <pre><?php
        $visibles = 0;
        foreach ($_COOKIE as $claveCookie => $valor) {
            echo escaparHtml("$claveCookie = $valor") . "\n";
            $visibles++;
        }
        if ($visibles === 0) {
            echo "// No hay cookies visibles en este nivel.\n";
        }
    ?></pre>

    <p>
        <a href="nivel1/visibilidad_nivel1.php">Navegar a Nivel 1 &rarr;</a> &middot;
        <a href="nivel1/nivel2/visibilidad_nivel2.php">Navegar a Nivel 2 &rarr;</a> &middot;
        <a href="?borrar_todas=1">Borrar cookies creadas</a>
    </p>
</body>
</html>
