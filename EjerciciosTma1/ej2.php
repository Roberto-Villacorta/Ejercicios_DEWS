<?php
$a = ["+","-","."];
echo "Dime un número: ";
$num = fgets(STDIN);

while ($num>0){
    if ($num === false) {
        break;
    }

    for ($i = 0; $i < $num; $i++){
        echo $a[$i%3];
    }
    echo "\n";
    $num--;
}

/*
Solución del profesor sin arrays

<?php
function sigCaracter($c) {
	switch ($c) {
		case "+" :
			$sol = "-";
			break;
		case "-" :
			$sol = ".";
			break;
		case "." :
			$sol = "+";
			break;
	}
	return $sol;
}

echo "Introduce n: \n";
fscanf ( STDIN, "%d\n", $n );

$c = "+";

for($i = $n; $i >= 1; $i --) {
	for($j = 1; $j <= $i; $j ++) {
		echo $c;
		$c = sigCaracter ( $c );
	}
	echo "\n";
}
?>
*/ 
?>