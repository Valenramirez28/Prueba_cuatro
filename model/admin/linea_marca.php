<?php
$conexion=mysqli_connect('localhost', 'root','','impuestos');

$id_marca = $_POST ['id_marca'];

$sql="SELECT linea.id_linea, linea.linea_nom FROM marca INNER JOIN linea ON marca.id_marca = linea.id_marca
AND marca.id_marca = '$id_marca'";

$result=mysqli_query($conexion,$sql);
$cadena="<label>Lineas</label><br>
<select  linea_nom='linea_nom'>";

while($ver=mysqli_fetch_row($result)) {

$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_decode($ver[1]).' </option>';
}
echo $cadena."</select>";

?>