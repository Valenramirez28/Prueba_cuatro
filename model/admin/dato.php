<?php
$conexion=mysqli_connect('localhost', 'root','','impuestos');

$id_tipo_veh = $_POST ['id_tipo_veh'];

$sql="SELECT cilindraje.id_cc, cilindraje.cilindraje FROM tipo_veh INNER JOIN cilindraje ON tipo_veh.id_tip_veh = cilindraje.id_tip_veh
AND tipo_veh.id_tip_veh = '$id_tipo_veh'";

$result=mysqli_query($conexion,$sql);
$cadena="<label>Cilindrajes</label><br>
<select  cilindraje='cilindraje'>";

while($ver=mysqli_fetch_row($result)) {

$cadena=$cadena.'<option value='.$ver[0].'>'.utf8_decode($ver[1]).' </option>';
}
echo $cadena."</select>";

?>