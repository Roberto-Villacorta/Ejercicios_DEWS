<?php
echo "Introduce un texto:";
$texto = trim(fgets(STDIN));
do{
echo "Introduce n (entre 1-6): ";
$n = (int)trim(fgets(STDIN));
}while($n < 1 || $n > 6);
for($i=1; $i <= $n; $i++){
    echo "<h$i>".$texto."</h$i> \n";
};
for($i=$n-1; $i >= 1; $i--){
    echo "<h$i>".$texto."</h$i> \n";
};
?>