<?php
session_start();
if(!isset($_SESSION['sumandos'])){
    $_SESSION['sumandos'] = $_POST['cantidad'];
    $_SESSION['sumando'] = 1;
    $_SESSION['numeros'] = [];
}else{
    $_SESSION['sumando']++;
    if(isset($_POST['numero'])){
        $_SESSION['numeros'][] = $_POST['numero'];
    }
    if($_SESSION['sumando'] == $_SESSION['sumandos']){
    header("Location: n3.php");
}
}
?>
<form action="n2.php" method="post">
    Introduce el numero <?php echo $_SESSION['sumando']; ?> 
    <input type="number" name="numero" min="1" max="10" required autofocus>
    <input type="submit" value="Siguiente">
</form>
