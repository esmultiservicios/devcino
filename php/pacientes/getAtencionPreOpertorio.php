<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

$preoperacion_id = $_POST['preoperacion_id'];

//CONSULTAR NOMBRE PROFESIONAL
$query = "SELECT pacientes_id
FROM preoperacion
WHERE preoperacion_id = '$preoperacion_id'"; 
$result = $mysqli->query($query) or die($mysqli->error);

$pacientes_id = 0;

if($result->num_rows>0){
	$consulta2 = $result->fetch_assoc();
	$pacientes_id = $consulta2['pacientes_id'];
}	
	
echo $pacientes_id;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>