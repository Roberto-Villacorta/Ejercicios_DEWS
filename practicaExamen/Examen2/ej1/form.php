<form action="form.php" method="POST">
    <input type="number" name="num" placeholder="Introduce un número">
    <button type="submit" name="accion" value="anadir">
    Añadir número
    </button>
    <button type="submit" name="accion" value="generar">
        Generar tablas
    </button>
    <button type="submit" name="accion" value="borrar">
        Borrar lista
    </button>
</form>

<?php
require_once('utils.php');

session_start();

if (!isset($_SESSION['memoria'])) {
    $_SESSION['memoria'] = [];
}else{
    if (isset($_POST['accion'])&&isset($_POST['num'])) {
     
       $accion = $_POST['accion'];
       switch ($accion) {
           case 'anadir':
               if (isset($_POST['num'])) {
                   $num = $_POST['num'];
                   anyadirNumero($num);
               }
               break;
           case 'generar':
               if (!empty($_SESSION['memoria'])) {
                   foreach ($_SESSION['memoria'] as $numero) {
                       echo generarTablas($numero);
                   }
               } else {
                   echo "No hay números en la lista.";
               }
               break;
           case 'borrar':
               $_SESSION['memoria'] = [];
               echo "Lista borrada.";
               break;
           default:
               echo "Acción no válida.";
               break;
    }
    }
}

function anyadirNumero($num) {
    if (!isset($_SESSION['memoria'])) {
        $_SESSION['memoria'] = [];
    } if($_POST['num']>0&&$_POST['num']<101){
           echo "Número introducido debe estar entre 1 y 100: ".$_POST['num']."<br>";
       }elseif($_SESSION['memoria']!=null&&in_array($num, $_SESSION['memoria'])){
           echo "Número introducido ya existe en la lista: ".$_POST['num']."<br>";
       }else{
            $_SESSION['memoria'][] = $num;
       }
}