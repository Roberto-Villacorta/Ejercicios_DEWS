<?php
header('Content-Type: application/json; charset=utf-8');

// Array de traducciones completo que se provee en la primera carga
$BDetiquetas = [
    "ES" => ["Palabra", "Traducción", "Enviar"],
    "EN" => ["Word", "Translation", "Send"],
    "FR" => ["Mot", "Traduction", "Envoyer"]
];

// Se devuelven todas las traducciones en una sola respuesta JSON
echo json_encode($BDetiquetas, JSON_UNESCAPED_UNICODE);
