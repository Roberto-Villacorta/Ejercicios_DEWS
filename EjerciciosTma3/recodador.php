<?php
function generarCadenaAleatoria($longitud = 5){
    $charset = "0123456789abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    $base = strlen($charset);
    $result = '';
    $now =explode(' ',microtime())[1];
    while($now > $longitud){
    $i = $now % $base;
    $result .= $charset[$i] . $result;
    $now/= $base;
    }
    return substr($result,-5);
}


$valor = isset($_COOKIE['UUID']) ? $_COOKIE['UUID'] :null;
if($valor == null){
    echo"<h1>Hola desconocido a partir de ahora te recordaré</h1>";
    setcookie('UUID',generarCadenaAleatoria());
}else{
    echo "<h1>Hola tú UUID es $valor</h1>";
}

?>
