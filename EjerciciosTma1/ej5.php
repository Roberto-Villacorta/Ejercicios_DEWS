<?php
$a = ["As","Dos","Tres","Cuatro","Cinco","Seis","Siete","Sota","Caballo","Rey"];
echo "Dime n: ";
$n = fgets(STDIN);



for ($i = 0; $i <= $n; $i++){
     echo $a[$i%10] . "";
}
?>