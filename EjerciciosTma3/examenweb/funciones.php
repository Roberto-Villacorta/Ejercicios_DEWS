<?php

function conjugar($verbo){
$terminaciones = ["ar"=>[
    "o",
    "as",
    "a",
    "amos",
    "ais",
    "an"
]
,"er"=>[
    "o",
    "es",
    "e",
    "emos",
    "eis",
    "en"
]
,"ir" => [
"o", 
"es", 
"e", 
"imos", 
"ís",
"en"]
];
$verbo = strtolower(trim($verbo));
$devolver = "<select name='verbo'>";
$terminacion = substr($verbo, -2);
$raiz = substr($verbo, 0, -2);

if (isset($terminaciones[$terminacion])) {
    foreach ($terminaciones[$terminacion] as $value) {
        $devolver .= "<option value='" . $value . "'>" . $raiz . $value . "</option>";
    }
} else {
    $devolver .= "<option value=''>Palabra no conjugable</option>";
}

return $devolver . "</select>";
}

function conjugacion($verbo){
    $terminacion = ["ar", "er", "ir"];
    $fin = substr($verbo, -2);

    if(in_array($fin, $terminacion)){
        switch ($fin) {
            case 'ar':
                return 1;
                break;
            case 'er':
                return 2;
                break;
            case 'ir':
                return 3;
                break;
        }
    }   
}
?>
