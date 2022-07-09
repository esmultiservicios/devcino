<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['servicio_id'];
$agenda_id = $_POST['agenda_id'];

//CONSULTAMOS LA FECHA DE LA CITA
$query_fecha = "SELECT CAST(fecha_cita AS DATE) AS 'fecha_cita'
	FROM agenda
	WHERE agenda_id = '$agenda_id'";
$result_fecha = $mysqli->query($query_fecha);

$fecha_cita = "";

if($result_fecha->num_rows>0){
	$consulta_fecha = $result_fecha->fetch_assoc();
	$fecha_cita = $consulta_fecha['fecha_cita'];
}

$consulta = "SELECT *
	FROM preoperacion
	WHERE pacientes_id = '$pacientes_id' AND servicio_id = '$servicio_id' AND colaborador_id = '$colaborador_id'";
$result = $mysqli->query($consulta);   

$peso_actual = "";
$peso_actual_kg = "";
$peso_perdido = "";
$imc_actual = "";
$resultados = "";
$psquiatria = "";
$psicologia = "";
$nutricion = "";
$medicina_interna = "";
$recomendaciones = "";
$fecha_cirugia = "";
$tipo_cirugia = "";
$fecha = "";
	
if($result->num_rows>0){
	$consulta_expediente1 = $result->fetch_assoc();
	$peso_actual = $consulta_expediente1['peso_actual'];
	$peso_actual_kg = $consulta_expediente1['peso_actual_kg'];
	$peso_perdido = $consulta_expediente1['peso_perdido'];
	$imc_actual = $consulta_expediente1['imc_actual'];
	$resultados = $consulta_expediente1['resultados'];
	$psquiatria = $consulta_expediente1['psquiatria'];
	$psicologia = $consulta_expediente1['psicologia'];
	$nutricion = $consulta_expediente1['nutricion'];
	$medicina_interna = $consulta_expediente1['medicina_interna'];
	$recomendaciones = $consulta_expediente1['recomendaciones'];
	$fecha_cirugia = $consulta_expediente1['fecha_cirugia'];
	$tipo_cirugia = $consulta_expediente1['tipo_cirugia'];
	$fecha = $consulta_expediente1['fecha'];
}

$datos = array(
	0 => $peso_actual, 
	1 => $peso_actual_kg,	
	2 => $peso_perdido,
	3 => $imc_actual,
	4 => $resultados,
	5 => $psquiatria,
	6 => $psicologia,					
	7 => $nutricion,
	8 => $medicina_interna,
	9 => $recomendaciones,	
	10 => $fecha_cirugia,	
	11 => $tipo_cirugia,
	12 => $fecha,	
);
echo json_encode($datos);
?>