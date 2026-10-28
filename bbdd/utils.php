<?php
function conectarMySql(
    $schema = "test",
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
