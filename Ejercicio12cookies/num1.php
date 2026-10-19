<?php
// Limpiamos las cookies anteriores para iniciar un nuevo cálculo
setcookie("cantidad", "", time() - 3600);
setcookie("sumandos", "", time() - 3600);
?>  
<form action="num2.php" method="post">
    Indica el número de sumandos (2..15)
    <input type="number" name="cantidad" min="2" max="15"><br>
    <input type="submit" value="Siguiente">
</form>
