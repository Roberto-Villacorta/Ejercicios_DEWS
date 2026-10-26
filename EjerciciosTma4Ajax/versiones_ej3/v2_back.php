<?php
$BDetiquetas = [
    "ES" => ["Palabra", "Traducción", "Enviar"],
    "EN" => ["Word", "Translation", "Send"],
    "FR" => ["Mot", "Traduction", "Envoyer"]
];

$idioma = isset($_POST['idioma']) && isset($BDetiquetas[$_POST['idioma']]) ? $_POST['idioma'] : "ES";

// PISTA 2: Empaquetar los datos con implode('separador', array) para evitar XML
echo implode(';', $BDetiquetas[$idioma]);
