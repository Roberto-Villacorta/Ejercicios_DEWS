<?php
include_once "./utilHTML.php";

$texto = "<h1>";
for ($i=0; $i <=50 ; $i++) {
    if($i%2!=0){
     $texto .= resaltar($i) . "<br>";        
    }else{
        $texto .= $i . "<br>";
    }
}
echo $texto . "</h1>";

?>