<?php
do{
echo "introduce un número entre 1-10: ";
fscanf(STDIN,"%d\n",$n);
}while($n < 1 && $n > 10);

$numeros = [
    "romano" => ["I","II","III","IV","V","VI","VII","VIII","IX","X"],
    "texto" => ["uno","dos","tres","cuatro","cinco","seis","siete","ocho","nueve","diez"]
];

do{
 echo "que tipo de numero quieres saber, romano o en texto? ";
 $tipo = trim(fgets(STDIN));
}while(!isset($numeros[$tipo]));


 for($i = 0;$i<$n;$i++){
    echo $numeros[$tipo][$i].", ";
 }
?>