<?php
function conectarMySql(
    $schema = "cdcol",
    $usu = 'root',
    $pdw = '',
    $host = "localhost"
) {
    try {
        $dsn = "mysql:dbname=$schema;host=$host";
        $conexion = new PDO($dsn, $usu, $pdw);
        return $conexion;
    } catch (PDOException $e) {
        print('Error');
        die();
    }
}
