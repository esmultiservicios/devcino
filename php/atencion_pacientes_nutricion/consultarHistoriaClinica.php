<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$fecha_registro = date("Y-m-d H:i:s");
$usuario = $_SESSION['colaborador_id'];	

$consulta_expediente = "SELECT a.*, p.fecha_nacimiento AS 'fecha_nacimiento'
	FROM atenciones_nutricion AS a
	INNER JOIN pacientes AS p
	ON a.pacientes_id = p.pacientes_id
	WHERE a.pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consulta_expediente);   

$motivo_consulta = "";
$fecha = "";	
$ante_perso = "";
$ante_fam = "";
$alergias = "";
$adicciones = "";
$niveles_estres = "";
$niveles_actividad_fisica = "";
$intento_perdida_peso = "";
$antecedentes_quirurgicos = "";
$observaciones = "";
$diagnostico = "";
$indicaciones = "";
$candidato_bariatrica = "";	
$user = "";	
$estado = "";	
$atenciones_nutricion_id = "";	
$servicio_id = "";
$fecha_nacimiento = "";
	
if($result->num_rows>0){
	$consulta_expediente1 = $result->fetch_assoc();
	$motivo_consulta = $consulta_expediente1['motivo_consulta'];
	$fecha = $consulta_expediente1['fecha'];
	$ante_perso = $consulta_expediente1['ante_perso'];
	$ante_fam = $consulta_expediente1['ante_fam'];
	$alergias = $consulta_expediente1['alergias'];
	$adicciones = $consulta_expediente1['adicciones'];
	$niveles_estres = $consulta_expediente1['niveles_estres'];
	$niveles_actividad_fisica = $consulta_expediente1['niveles_actividad_fisica'];
	$intento_perdida_peso = $consulta_expediente1['intento_perdida_peso'];
	$antecedentes_quirurgicos = $consulta_expediente1['antecedentes_quirurgicos'];
	$observaciones = $consulta_expediente1['observaciones'];
	$diagnostico = $consulta_expediente1['diagnostico'];
	$indicaciones = $consulta_expediente1['indicaciones'];
	$candidato_bariatrica = $consulta_expediente1['candidato_bariatrica'];	
	$user = $consulta_expediente1['user'];	
	$estado = $consulta_expediente1['estado'];	
	$atenciones_nutricion_id = $consulta_expediente1['atenciones_nutricion_id'];
	$servicio_id = $consulta_expediente1['servicio_id'];
	$fecha_nacimiento = $consulta_expediente1['fecha_nacimiento'];		
}

//OBTENER LA EDAD DEL USUARIO 
/*********************************************************************************/
if($fecha_nacimiento != "" || $fecha_nacimiento != null){
	$valores_array = getEdad($fecha_nacimiento);
	$anos = $valores_array['anos'];
	$meses = $valores_array['meses'];	  
	$dias = $valores_array['dias'];	
}else{
	$anos = 0;
	$meses = 0;	  
	$dias = 0;		
}
/*********************************************************************************/
if ($anos>1 ){
   $palabra_anos = "Años";
}else{
  $palabra_anos = "Año";
}

if ($meses>1 ){
   $palabra_mes = "Meses";
}else{
  $palabra_mes = "Mes";
}

if($dias>1){
	$palabra_dia = "Días";
}else{
	$palabra_dia = "Día";
}

$datos = array(
	0 => $motivo_consulta, 
	1 => $fecha, 	
	2 => $ante_perso,	
	3 => $ante_fam,
	4 => $alergias,
	5 => $adicciones,
	6 => $niveles_estres,
	7 => $niveles_actividad_fisica,
	8 => $intento_perdida_peso,					
	9 => $antecedentes_quirurgicos,
	10 => $observaciones,
	11 => $diagnostico,	
	12 => $indicaciones,	
	13 => $candidato_bariatrica,		
	14 => $user,	
	15 => $estado,
	16 => $atenciones_nutricion_id,
	17 => $servicio_id,
	18 => $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia	
);
echo json_encode($datos);
?>