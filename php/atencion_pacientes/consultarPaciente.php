<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$estado = 1; //1. Activo 2. Inactivo
$fecha_registro = date("Y-m-d H:i:s");
$usuario = $_SESSION['colaborador_id'];	

$consulta_expediente = "SELECT p.pacientes_id,  p.nombre, p.apellido, p.identidad, p.telefono1, p.telefono2, p.fecha_nacimiento, p.fecha, p.email, p.genero, p.localidad,
(CASE WHEN p.estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado',
(CASE WHEN p.expediente = '0' THEN 'TEMP' ELSE p.expediente END) AS 'expediente', p.departamento_id, p.municipio_id, p.pais_id, p.responsable, p.responsable_id, p.profesion_id, p.referidopor AS 'referido', c.servicio_id AS 'servicio_id'
	FROM pacientes AS p
    LEFT JOIN clinico AS c
    ON p.pacientes_id = c.pacientes_id
	WHERE p.pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consulta_expediente);   

$expediente = "";
$nombre = "";
$apellido = "";
$sexo = "";
$telefono1 = "";
$telefono2 = "";
$fecha_nacimiento = "";
$correo = "";
$fecha = "";
$localidad = "";
$departamento_id = "";
$municipio_id = "";
$pais_id = "";
$responsable = "";
$responsable_id = "";
$profesion_id = "";
$identidad = "";
$nombre_completo = "";
$referido = "";
$servicio_id = "";
	
if($result->num_rows>0){
	$consulta_expediente1 = $result->fetch_assoc();
	$expediente = $consulta_expediente1['expediente'];
	$nombre = $consulta_expediente1['nombre'];
	$apellido = $consulta_expediente1['apellido'];
	$sexo = $consulta_expediente1['genero'];
	$telefono1 = $consulta_expediente1['telefono1'];
	$telefono2 = $consulta_expediente1['telefono2'];
	$fecha_nacimiento = $consulta_expediente1['fecha_nacimiento'];
	$correo = $consulta_expediente1['email'];
	$fecha = $consulta_expediente1['fecha'];
	$localidad = $consulta_expediente1['localidad'];
	$departamento_id = $consulta_expediente1['departamento_id'];
	$municipio_id = $consulta_expediente1['municipio_id'];
	$pais_id = $consulta_expediente1['pais_id'];	
	$responsable = $consulta_expediente1['responsable'];	
	$responsable_id = $consulta_expediente1['responsable_id'];
	$profesion_id = $consulta_expediente1['profesion_id'];	
	$identidad = $consulta_expediente1['identidad'];
	$nombre_completo = strtoupper($nombre.' '.$apellido);
	$referido = $consulta_expediente1['referido'];
	$servicio_id = $consulta_expediente1['servicio_id'];
}

//OBTENER LA EDAD DEL USUARIO 
/*********************************************************************************/
$valores_array = getEdad($fecha_nacimiento);
$anos = $valores_array['anos'];
$meses = $valores_array['meses'];	  
$dias = $valores_array['dias'];	
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
	0 => $nombre, 
	1 => $apellido,	
	2 => $telefono1,
	3 => $telefono2,
	4 => $sexo,
	5 => $correo,
	6 => $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia,					
	7 => $expediente,
	8 => $localidad,
	9 => $fecha_nacimiento,	
	10 => $departamento_id,	
	11 => $municipio_id,		
	12 => $pais_id,	
	13 => $responsable,	
	14 => $responsable_id,
	15 => $profesion_id,
	16 => $identidad,
	17 => $nombre_completo,
	18 => $referido,
	19 => $anos,
	19 => $servicio_id	
);
echo json_encode($datos);
?>