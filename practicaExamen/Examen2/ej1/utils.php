<?php
function generarTablas($num){
$html = "<table border='1'>";
$html .= "<tr><th>Operación</th>
<th>Resultado</th></tr>";
for($i= 1;$i<=10;$i++){
$html .= "<tr><td>".$num." x ".$i."</td><td>".($num*$i)."</td></tr>";
}
$html .= "</table>";
return $html;
}