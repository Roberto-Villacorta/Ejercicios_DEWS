<?php
session_start();
session_destroy();
session_start();
?>

<form action="n2.php" method="post">
    Indica el número de sumandos (2..15)
    <input type="number" name="cantidad" min="2" max="15"><br>
    <input type="submit" value="Siguiente">
</form>
