<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];

$consulta = "SELECT *
	FROM notaoperacion
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consulta);   

$peso_actual = "";
$peso_actual_kg = "";
$peso_perdido = "";
$imc_actual = "";
$tecnica = "";
$cirujano = "";
$asistente = "";
$camara = "";
$anestesia = "";
$anestesiologo = "";
$otros = "";
$otros = "";
$hallazgos_operativos = "";
$descripcion_operativos = "";
$indicaciones = "";
$recomendaciones = "";
$prueba = "";
$blake = "";
$extraccion = "";
$evacuo = "";
$cierro = "";
$comentarios = "";
$fecha = "";
$servicio_id = "";
	
if($result->num_rows>0){
	$consulta_expediente1 = $result->fetch_assoc();
	$peso_actual = $consulta_expediente1['peso_actual'];
	$peso_actual_kg = $consulta_expediente1['peso_actual_kg'];
	$peso_perdido = $consulta_expediente1['peso_perdido'];
	$imc_actual = $consulta_expediente1['imc_actual'];
	$tecnica = $consulta_expediente1['tecnica'];
	$cirujano = $consulta_expediente1['cirujano'];
	$asistente = $consulta_expediente1['asistente'];
	$camara = $consulta_expediente1['camara'];
	$anestesia = $consulta_expediente1['anestesia'];
	$anestesiologo = $consulta_expediente1['anestesiologo'];
	$otros = $consulta_expediente1['otros'];
	$hallazgos_operativos = $consulta_expediente1['hallazgos_operativos'];
	$descripcion_operativos = $consulta_expediente1['descripcion_operativos'];
	$indicaciones = $consulta_expediente1['indicaciones'];
	$recomendaciones = $consulta_expediente1['recomendaciones'];
	$prueba = $consulta_expediente1['prueba'];
	$blake = $consulta_expediente1['blake'];
	$extraccion = $consulta_expediente1['extraccion'];
	$evacuo = $consulta_expediente1['evacuo'];
	$cierro = $consulta_expediente1['cierro'];
	$comentarios = $consulta_expediente1['comentarios'];
	$fecha = $consulta_expediente1['fecha'];
	$servicio_id = $consulta_expediente1['servicio_id'];	
}


$datos = array(
	0 => $peso_actual, 
	1 => $peso_actual_kg,	
	2 => $peso_perdido,
	3 => $imc_actual,
	4 => $tecnica,
	5 => $cirujano,
	6 => $asistente,					
	7 => $camara,
	8 => $anestesia,
	9 => $anestesiologo,
	10 => $otros,		
	11 => $hallazgos_operativos,
	12 => $descripcion_operativos,
	13 => $indicaciones,
	14 => $recomendaciones,
	15 => $prueba,	
	16 => $blake,					
	17 => $extraccion,
	18 => $evacuo,
	19 => $cierro,	
	20 => $comentarios,	
	21 => $fecha,	
	22 => $servicio_id,		
);

echo json_encode($datos);
?>