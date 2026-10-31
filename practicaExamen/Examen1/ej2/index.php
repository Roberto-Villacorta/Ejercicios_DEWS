<?php
session_start();

require_once "utilidades.php";

if (!isset($_SESSION["vacaciones"])) {
    $_SESSION["vacaciones"] = [];
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if ($_POST["accion"] == "anyadir") {

            $mes = (int) $_POST["mes"];
            $anio = (int) $_POST["anio"];

            if ($mes >= 1 && $mes <= 12 && $anio >= 1) {

                $existe = false;

                foreach ($_SESSION["vacaciones"] as $vacacion) {
                    if (
                        $vacacion["mes"] == $mes &&
                        $vacacion["anio"] == $anio
                    ) {
                        $existe = true;
                    }
                }

                if (!$existe) {
                    $_SESSION["vacaciones"][] = [
                        "mes" => $mes,
                        "anio" => $anio
                    ];
                }
            }
        }

        if ($_POST["accion"] == "borrar") {
            $_SESSION["vacaciones"] = [];
        }
    }
?>
<form action="index.php"method="POST">
    <label>Mes</label>
    <?php 
    echo '<select name="mes">'. PHP_EOL;
    for ($i = 1; $i <= 12; $i++) {
        echo '<option value="'.$i.'">'.$i.'</option>'.PHP_EOL;
    }
    echo '</select>';
    ?>
    <label >Año</label>
    <input name="anyo" type="number">
    <button type="submit" name="action" value="anyadir">Añadir mes</button>
    <button type="submit" name="action" value="generar">Generar planificación</button>
    <button type="submit" name="accion" value="borrar">Borrar planificación</button>
</form>

<?php
echo "<h1>Días de vacaciones</h1>".PHP_EOL;

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["accion"]) &&
    $_POST["accion"] == "generar"
) {

    echo "<h2>Planificación de vacaciones</h2>";

    if (count($_SESSION["vacaciones"]) == 0) {

        echo "<p>No has añadido ningún mes.</p>";

    } else {

        echo "<table border='1'>";
        echo "<tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Número de días</th>
                <th>Día elegido</th>
              </tr>";

        foreach ($_SESSION["vacaciones"] as $vacacion) {

            $mes = $vacacion["mes"];
            $anio = $vacacion["anio"];

            $dias = cal_days_in_month(
                CAL_GREGORIAN,
                $mes,
                $anio
            );

            $nombreMes = [
                1 => "Enero",
                2 => "Febrero",
                3 => "Marzo",
                4 => "Abril",
                5 => "Mayo",
                6 => "Junio",
                7 => "Julio",
                8 => "Agosto",
                9 => "Septiembre",
                10 => "Octubre",
                11 => "Noviembre",
                12 => "Diciembre"
            ];

            echo "<tr>";

            echo "<td>" . $nombreMes[$mes] . "</td>";
            echo "<td>" . $anio . "</td>";
            echo "<td>" . $dias . "</td>";
            echo "<td>" . generarSelectDias($mes, $anio) . "</td>";

            echo "</tr>";
        }

        echo "</table>";
    }
}

?>