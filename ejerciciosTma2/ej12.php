<?php
include_once "./utilHTML.php";

// Array asociativo de opciones (clave => etiqueta)
$aficiones = [
    'D' => 'Deporte',
    'C' => 'Cine',
    'L' => 'Lectura',
    'M' => 'Música',
    'V' => 'Viajar'
];

// Comprobamos si se ha enviado el formulario para recuperar las casillas marcadas
$seleccionados = $_POST['aficion'] ?? ['D'];
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['aficion']) && is_array($_POST['aficion'])) {
        $nombresSeleccionados = [];
        foreach ($_POST['aficion'] as $clave) {
            if (isset($aficiones[$clave])) {
                $nombresSeleccionados[] = $aficiones[$clave];
            }
        }
        $mensaje = "Aficiones seleccionadas: <strong>" . implode(", ", $nombresSeleccionados) . "</strong>";
    } else {
        $seleccionados = [];
        $mensaje = "No has seleccionado ninguna afición.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 12 - Función pintarCheckboxes()</title>
</head>
<body>    
        <form action="" method="post">
            <fieldset>
                <legend>Selecciona tus aficiones</legend>
                <?php
                // Llamada a la función requerida
                echo pintarCheckboxes('aficion', $aficiones, $seleccionados);
                ?>
            </fieldset>
            <input type="submit" value="Enviar">
        </form>

        <?php if ($mensaje !== ""): ?>
            <div class="resultado">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
        
        <h3>Código HTML generado por pintarCheckboxes() (ejemplo base):</h3>
        <pre><?= htmlspecialchars(pintarCheckboxes('aficion', ['D' => 'Deporte', 'C' => 'Cine'])) ?></pre>
</body>
</html>
