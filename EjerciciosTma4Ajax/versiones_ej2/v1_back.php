<?php
// Datos de comunidades y provincias en el servidor
$comunidades = [
    'Andalucía' => ['Almería', 'Cádiz', 'Córdoba', 'Granada', 'Huelva', 'Jaén', 'Málaga', 'Sevilla'],
    'Aragón' => ['Huesca', 'Teruel', 'Zaragoza'],
    'Asturias (Principado de)' => ['Asturias'],
    'Canarias' => ['Palmas (Las)', 'Santa Cruz de Tenerife'],
    'Cantabria' => ['Cantabria'],
    'Castilla y León' => ['Ávila', 'Burgos', 'León', 'Palencia', 'Salamanca', 'Segovia', 'Soria', 'Valladolid', 'Zamora'],
    'Castilla-La Mancha' => ['Albacete', 'Ciudad Real', 'Cuenca', 'Guadalajara', 'Toledo'],
    'Cataluña' => ['Barcelona', 'Gerona', 'Lérida', 'Tarragona'],
    'Ceuta (Ciudad de)' => ['Ceuta'],
    'Comunidad Valenciana' => ['Alicante', 'Castellón', 'Valencia'],
    'Extremadura' => ['Badajoz', 'Cáceres'],
    'Galicia' => ['Coruña (La)', 'Lugo', 'Orense', 'Pontevedra'],
    'Islas Baleares' => ['Islas Baleares'],
    'Madrid (Comunidad de)' => ['Madrid'],
    'Melilla (Ciudad de)' => ['Melilla'],
    'Murcia (Región de)' => ['Murcia'],
    'Navarra (Comunidad Foral de)' => ['Navarra'],
    'País Vasco' => ['Álava', 'Guipúzcoa', 'Vizcaya'],
    'Rioja (La)' => ['Rioja (La)']
];

// Recibimos la comunidad seleccionada por POST desde el formulario
$comunidadSeleccionada = isset($_POST['comunidad']) ? $_POST['comunidad'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Versión 1: Back (Página Redibujada por PHP)</title>
</head>
<body>
    <h1>Versión 1: Servidor PHP (Página Redibujada por Completo)</h1>
    <p>El servidor ha procesado la petición POST y ha <strong>generado todo el HTML de nuevo</strong> con las provincias correspondientes.</p>

    <!-- El formulario se reenvía a sí mismo para seguir cambiando de comunidad -->
    <form action="v1_back.php" method="POST">
        <label for="comunidad">Comunidad Autónoma:</label>
        <select name="comunidad" id="comunidad" onchange="this.form.submit()">
            <?php
            foreach ($comunidades as $comunidad => $provincias) {
                $selected = ($comunidad === $comunidadSeleccionada) ? "selected" : "";
                echo "<option value='$comunidad' $selected>$comunidad</option>";
            }
            ?>
        </select>

        <label for="provincia">Provincias:</label>
        <select name="provincia" id="provincia">
            <?php
            if (!empty($comunidadSeleccionada) && isset($comunidades[$comunidadSeleccionada])) {
                foreach ($comunidades[$comunidadSeleccionada] as $provincia) {
                    echo "<option value='$provincia'>$provincia</option>";
                }
            } else {
                echo "<option value=''>-- Sin provincias disponibles --</option>";
            }
            ?>
        </select>

        <noscript>
            <button type="submit">Actualizar</button>
        </noscript>
    </form>

    <br>
    <p><a href="v1_front.html">&larr; Volver al formulario inicial</a></p>
</body>
</html>
