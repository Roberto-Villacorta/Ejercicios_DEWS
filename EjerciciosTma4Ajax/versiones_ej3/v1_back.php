<?php
$BDetiquetas = [
    "ES" => ["Palabra", "Traducción", "Enviar"],
    "EN" => ["Word", "Translation", "Send"],
    "FR" => ["Mot", "Traduction", "Envoyer"]
];

// Idioma seleccionado enviado por POST (por defecto 'ES')
$idioma = isset($_POST['idioma']) && isset($BDetiquetas[$_POST['idioma']]) ? $_POST['idioma'] : "ES";

// Etiquetas correspondientes al idioma seleccionado
$etiquetas = $BDetiquetas[$idioma];

// Mantenemos los textos introducidos en los inputs si existían
$palabra = isset($_POST['palabra']) ? htmlspecialchars($_POST['palabra']) : '';
$traduccion = isset($_POST['traduccion']) ? htmlspecialchars($_POST['traduccion']) : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 - Versión 1 (Back: Página Redibujada)</title>
</head>

<body>
    <h2>Ejercicio 3 - Versión 1: Redibujado Completo (PHP)</h2>
    <p>El servidor ha recibido el idioma <strong><?php echo $idioma; ?></strong> y ha <strong>vuelto a generar todo el HTML</strong> con las nuevas etiquetas.</p>

    <div class="formulario">
        <!-- El formulario vuelve a apuntar a sí mismo para seguir cambiando de idioma -->
        <form action="v1_back.php" method="POST">
            <div class="banderas">
                <label>
                    <input type="radio" name="idioma" value="ES" <?php echo ($idioma === 'ES') ? 'checked' : ''; ?> onchange="this.form.submit()">
                    🇪🇸 Español
                </label>
                <label>
                    <input type="radio" name="idioma" value="EN" <?php echo ($idioma === 'EN') ? 'checked' : ''; ?> onchange="this.form.submit()">
                    🇬🇧 English
                </label>
                <label>
                    <input type="radio" name="idioma" value="FR" <?php echo ($idioma === 'FR') ? 'checked' : ''; ?> onchange="this.form.submit()">
                    🇫🇷 Français
                </label>
            </div>

            <div class="campo">
                <label id="lblPalabra" for="palabra"><?php echo $etiquetas[0]; ?>:</label>
                <input type="text" id="palabra" name="palabra" value="<?php echo $palabra; ?>">
            </div>

            <div class="campo">
                <label id="lblTraduccion" for="traduccion"><?php echo $etiquetas[1]; ?>:</label>
                <input type="text" id="traduccion" name="traduccion" value="<?php echo $traduccion; ?>">
            </div>

            <input type="submit" id="btnEnviar" value="<?php echo $etiquetas[2]; ?>" onclick="alert('Formulario enviado (simulación)'); return false;">
        </form>
    </div>
    <br>
    <a href="v1_front.html">&larr; Volver al formulario inicial</a>
</body>

</html>