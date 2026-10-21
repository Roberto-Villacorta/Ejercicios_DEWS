<?php
session_start();
echo "<h2>". implode(" + ", $_SESSION['numeros']) . " = " . array_sum($_SESSION['numeros']) . "</h2>";

echo "<a href='n1.php'><button>Volver a empezar</button></a>";