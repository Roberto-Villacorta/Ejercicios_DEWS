<?php
$productos = [
    'P001' => [
        "memoria RAM",
        "memoria",
        35,
        12
    ],
    'P002'=>[
        "SSD 1TB",
        "Almacenamiento",
        75,
        8
    ],
    'P003'=>[
        "GPU",
        "Gráfica",
        299,
        0
    ],
    'P004'=>[
        "PSU",
        "Alimentación",
        65,
        5
    ]
];
echo "código;Producto;Categoría;Precio;Unidades";
echo PHP_EOL;
foreach ($productos as $key => $value) {
    echo $key.";";
    foreach($value as $v){
        echo $v.";";
    }
    echo PHP_EOL;
}

$valor = 0;
$numProductos = 0;
$unidades = 0;
$productosAgotados = 0;

foreach ($productos as $key => $value) {
    $valor += $value[3] * $value[2];
    $numProductos++;
    $unidades += $value[3];
    if ($value[3] == 0){
        $productosAgotados++ ;
    }   
}

echo $valor.PHP_EOL;
echo $numProductos.PHP_EOL;
echo $unidades.PHP_EOL;
echo $productosAgotados.PHP_EOL;
?>