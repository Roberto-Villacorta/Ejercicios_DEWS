<?php
session_start();
require_once "funciones.php";

// Si la sesión no existe, inicializamos como array vacío
if (!isset($_SESSION['palabras'])) {
    $_SESSION['palabras'] = [];
}

echo "<h2>Lista de Verbos y Conjugaciones</h2>";

if (empty($_SESSION['palabras'])) {
    echo "<p>No hay verbos guardados todavía.</p>";
} else {
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>Verbo</th><th>Conjugacion</th><th>Presente de Indicativo</th></tr>";
    foreach ($_SESSION['palabras'] as $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($value) . "</td>";
        echo "<td>" . conjugacion($value) . "</td>";
        echo "<td>" . conjugar($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<br>
<a href="p1.php?reset=1"><button type="button">Volver a introducir verbos</button></a>

