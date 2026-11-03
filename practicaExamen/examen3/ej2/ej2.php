<?php
session_start();

require_once "util.php";

if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = [];
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if ($_POST["accion"] == "anadir") {

            $nombre = $_POST["nombre"];
            $precio = (float) $_POST["precio"];
            $ud = (int) $_POST["ud"];
                $existe = false;

                foreach ($_SESSION["productos"] as $pr) {
                    if (
                       $pr['nombre']==$nombre
                    ) {
                        $existe = true;
                        $_SESSION["productos"][$pr]["ud"] += $ud;
                    }
                }

                if (!$existe) {
                    $_SESSION["productos"][] = [
                        "nombre" => $nombre,
                        "precio" => $precio,
                        "ud" => $ud
                    ];
                }
        }

        if ($_POST["accion"] == "borrar") {
            $_SESSION["productos"] = [];
        }
    }
?>

<form method="post" action="index.php">
    <input type="text"  id="nombre" >
    <input type="number"  id="precio" >
    <input type="number"  id="ud" >
    <button type="submit" name="accion" value="anadir">
    Añadir producto
    </button>
    <button type="submit" name="accion" value="mostrar">
        Mostrar lista
    </button>
    <button type="submit" name="accion" value="vaciar">
        Vaciar lista
    </button>
</form>


<?php
echo "<h1>Lista de productos</h1>".PHP_EOL;

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["accion"]) &&
    $_POST["accion"] == "mostrar"
) {

    echo "<h2>Planificación de productos</h2>";

    if (count($_SESSION["productos"]) == 0) {

        echo "<p>No has añadido ningún prodcto</p>";

    } else {

        foreach ($_SESSION["productos"] as $pr) {

            echo "<div class='lista-horizontal'>";
            echo generarHTML($pr['nombre'],$pr['precio'],$pr['ud']);
            echo "</div>";
    }
}
}

?>