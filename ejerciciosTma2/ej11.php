<?php
include_once "./utilHTML.php";

// Array de opciones (value => label)
$aficiones = [
    'D' => 'Deporte',
    'C' => 'Cine',
    'L' => 'Lectura',
    'V' => 'Viajar'
];

// Comprobamos si se ha enviado el formulario para mantener la selección
// o asignamos una por defecto (por ejemplo 'C' como en el enunciado)
$seleccionado = $_POST['aficion'] ?? 'C';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aficion']) && array_key_exists($_POST['aficion'], $aficiones)) {
        $mensaje = "Has seleccionado: <strong>" . $aficiones[$_POST['aficion']] . "</strong> (Valor: " . htmlspecialchars($_POST['aficion']) . ")";
    } else {
        $mensaje = "No has seleccionado ninguna opción válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 11 - Función pintarRadio()</title>
</head>
<body>      
        <form action="" method="post">
            <fieldset>
                <legend>Selecciona tu afición favorita</legend>
                <?php
                // Llamada a la función requerida
                echo pintarRadio('aficion', $aficiones, $seleccionado);
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
        
        <h3>Código HTML generado por pintarRadio():</h3>
        <pre><?= htmlspecialchars(pintarRadio('aficion', ['D' => 'Deporte', 'C' => 'Cine'], 'C')) ?></pre>
</body>
</html>
