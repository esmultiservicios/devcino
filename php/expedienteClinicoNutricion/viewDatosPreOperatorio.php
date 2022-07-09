<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$usuario = $_SESSION['colaborador_id'];	

$consulta_expediente = "SELECT pre.*
	FROM preoperacion AS pre
	INNER JOIN pacientes AS p
	ON pre.pacientes_id = p.pacientes_id
	WHERE pre.pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consulta_expediente);   

$arreglo = array();

while( $row = $result->fetch_assoc()){
	$arreglo[] = $row;  
}	

echo json_encode($arreglo);
?>