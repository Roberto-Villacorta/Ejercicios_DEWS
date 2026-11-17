<?php
function conectarMySql($schema = 'test', $usu = 'root', $pwd = '', $host = 'localhost') {
    try {
        $dsn = "mysql:host=$host;dbname=$schema;charset=utf8";
        $db  = new PDO($dsn, $usu, $pwd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "ERROR de CONEXION a la BD $schema: " . $e->getMessage();
        die();
    }
}
?>
