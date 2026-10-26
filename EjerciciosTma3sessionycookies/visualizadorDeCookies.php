<?php
// Obtener el nivel de visualización actual mediante GET (por defecto muestra el formulario)
$modoVer = isset($_GET['ver_nivel']) ? (int)$_GET['ver_nivel'] : null;

// Rutas/directorios asociados a cada nivel para el path de la cookie
$baseDir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$rutas = [
    0 => $baseDir . '/',
    1 => $baseDir . '/nivel1/',
    2 => $baseDir . '/nivel1/nivel2/'
];

// Procesamiento de creación de cookies
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $nivel = (int)($_POST['nivel'] ?? 0);

    if ($nombre !== '') {
        $ruta = $rutas[$nivel] ?? '/';
        // Crear cookie con el path correspondiente al nivel
        setcookie($nombre, $contenido, time() + 3600, $ruta);
        // Guardamos también en sesión o mostramos aviso de confirmación
        $mensaje = "Cookie <strong>" . htmlspecialchars($nombre) . "</strong> creada correctamente en el nivel $nivel (Ruta: <code>$ruta</code>).";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado y creación de cookies</title>
</head>
<body>

    <!-- 1. Listado de enlaces por nivel -->
    <h2>Listado de cookies por nivel</h2>
    <div class="enlaces">
        <div>Nivel0 --&gt; <a href="?ver_nivel=0">Listado de cookies</a></div>
        <div>Nivel0 --&gt; Nivel1 --&gt; <a href="?ver_nivel=1">Listado de cookies</a></div>
        <div>Nivel0 --&gt; Nivel1 --&gt; Nivel2 --&gt; <a href="?ver_nivel=2">Listado de cookies</a></div>
    </div>

    <!-- Si se ha pulsado en ver cookies de algún nivel -->
    <?php if ($modoVer !== null): ?>
        <div class="seccion-listado">
            <h3>Cookies visibles en: Nivel <?= $modoVer ?></h3>
            <p><small>Ruta simulada: <code><?= htmlspecialchars($rutas[$modoVer] ?? '/') ?></code></small></p>

            <?php if (empty($_COOKIE)): ?>
                <p><em>No hay cookies disponibles en esta sesión.</em></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Contenido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_COOKIE as $clave => $valor): ?>
                            <tr>
                                <td><?= htmlspecialchars($clave) ?></td>
                                <td><?= htmlspecialchars($valor) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <p><a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>">Ocultar listado</a></p>
        </div>
    <?php endif; ?>

    <!-- 2. Formulario de creación -->
    <h3>Creación de cookies en diferentes niveles (directorios) por un script ubicado en /</h3>
    <p class="subtitulo">Se permite fijar nombre y contenido de la cookie, así como el nivel</p>

    <?php if ($mensaje): ?>
        <p style="color: #006600;"><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <fieldset>
            <legend>Creación de cookie</legend>
            <div class="fila">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="contenido">Contenido</label>
                <input type="text" id="contenido" name="contenido">
            </div>

            <div class="fila">
                <label for="nivel">Nivel</label>
                <select id="nivel" name="nivel">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>

                <input type="submit" name="crear" value="Crea cookie">
            </div>
        </fieldset>
    </form>

</body>
</html>