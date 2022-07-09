<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_SESSION['colaborador_id'];
$servicio_id = $_POST['servicio_PostOperatorio_id'];
$fecha = $_POST['post_fecha'];
$edad = $_POST['post_edad_consulta'];
$talla = cleanStringStrtolower($_POST['post_talla']);
$peso_actual = cleanStringStrtolower($_POST['post_peso_actual']);
$peso_actual_kg = cleanStringStrtolower($_POST['post_peso_actual_kg']);
$imc_actual = cleanStringStrtolower($_POST['post_imc_actual']);
$peso_perdido = cleanStringStrtolower($_POST['post_peso_perdido']);
$ewl = cleanStringStrtolower($_POST['post_ewl']);
$otros = cleanString($_POST['post_otros']);
$mejoria = cleanString($_POST['post_mejoria']);
$estado_actual = $_POST['post_estado_actual'];
$medicamentos = cleanString($_POST['post_medicamentos']);
$hallazgos = cleanString($_POST['post_hallazgos']);
$comentarios = cleanString($_POST['post_comentarios']);
$plan = cleanString($_POST['post_plan']);
$fecha_registro = date("Y-m-d H:i:s");
$usuario = $_SESSION['colaborador_id'];
$estado = 1;//ACTIVO

//GUARDAMOS EL REGISTRO DEL PACIENTE EN LA AGENDA
//CONSULTAR PUESTO COLABORADOR
$consulta_puesto = "SELECT puesto_id 
	FROM colaboradores 
	WHERE colaborador_id = '$colaborador_id'";
$result = $mysqli->query($consulta_puesto);

$puesto_colaborador = "";

if($result->num_rows>=0){
	$consulta_puesto1 = $result->fetch_assoc(); 
	$puesto_colaborador = $consulta_puesto1['puesto_id'];	
}

//CONSULTAR TIPO DE PACIENTE EN AGENDA
$query_tipo_paciente = "SELECT a.agenda_id
	FROM agenda AS a
	INNER JOIN colaboradores AS c
	ON a.colaborador_id = c.colaborador_id
	WHERE a.pacientes_id = '$pacientes_id' AND c.puesto_id = '$puesto_colaborador' AND a.servicio_id = '$servicio_id' AND a.status = 1";
$result_tipo_paciente = $mysqli->query($query_tipo_paciente) or die($mysqli->error);
$consultar_tipo_paciente = $result_tipo_paciente->fetch_assoc(); 

if ($consultar_tipo_paciente['agenda_id']== ""){
	$paciente = 'N';
	$color = '#008000'; //VERDE;
}else{ 
	$paciente = 'S';
	$color = '#0071c5'; //AZUL;
}	

$consultar_expediente= "SELECT expediente, CONCAT(nombre,' ',apellido) AS nombre 
	FROM pacientes 
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consultar_expediente);

$expediente = "";
$nombre = "";

if($result->num_rows>=0){
	$consultar_expediente1 = $result->fetch_assoc();
	$expediente = $consultar_expediente1['expediente'];
	$nombre = $consultar_expediente1['nombre'];		
}

$hora = '00:00';
$fecha_cita = date("Y-m-d H:i:s", strtotime($fecha));
$observacion = "Paciente agregado sin cita";

//CONSULTAMOS SI LA AGENDA YA ESTA ALMACENADA
$query_agenda = "SELECT agenda_id
	FROM agenda
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND CAST(fecha_cita AS DATE) = '$fecha'";
$result_agenda = $mysqli->query($query_agenda);

$agenda_id = "";

if($result_agenda->num_rows==0){
	$agenda_id = correlativo('agenda_id', 'agenda');
	$insert = "INSERT INTO agenda 
	VALUES('$agenda_id', '$pacientes_id', '$expediente', '$colaborador_id', '$hora', '$fecha_cita', '$fecha_cita', '$fecha_registro', '0', '$color', '$observacion','$usuario','$servicio_id','','1','0','2','$paciente','0')";

	$mysqli->query($insert);
}else{
	$consultar_agenda = $result_agenda->fetch_assoc();
	$agenda_id = $consultar_agenda['agenda_id'];	
}

//CONSULTA DATOS DEL PACIENTE
$query = "SELECT CONCAT(nombre, ' ', apellido) AS 'paciente', identidad, expediente AS 'expediente'
	FROM pacientes
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($query) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$paciente = '';
$identidad = '';
$expediente = '';

if($result->num_rows>0){
	$paciente = $consulta_registro['paciente'];
	$identidad = $consulta_registro['identidad'];
	$expediente = $consulta_registro['expediente'];
}	

//VERIFICAMOS QUE NO EXISTA EL REGISTRO EN LA ENTIDAD POST OPERACION
$query = "SELECT postoperacion_id
	FROM postoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha'";
$result = $mysqli->query($query) or die($mysqli->error);

	$postoperacion_id  = correlativo('postoperacion_id', 'postoperacion');
	$insert = "INSERT INTO postoperacion 
		VALUES('$postoperacion_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$talla','$peso_actual','$peso_actual_kg','$imc_actual','$peso_perdido','$otros','$ewl','$mejoria','$estado_actual','$medicamentos','$hallazgos','$comentarios','$plan','$paciente','$estado','$fecha_registro')";

	$query = $mysqli->query($insert) or die($mysqli->error);

if($query){
			
	$datos = array(
		0 => "Almacenado", 
		1 => "Registro Almacenado Correctamente", 
		2 => "success",
		3 => "btn-primary",
		4 => "formularioAtencionesPostOperatoria",
		5 => "Registro",
		6 => "AtencionMedicaPostOperatorio",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
		7 => "modalRegistroPacientesPostPeratorio", //Modals Para Cierre Automatico
		8 => $postoperacion_id,
		9 => "Guardar",	
	);
	
	/*********************************************************************************************************************************************************************/
	/*********************************************************************************************************************************************************************/
	//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
	$historial_numero = historial();
	$estado_historial = "Agregar";
	$observacion_historial = "Se ha agregado un nuevo expediente clinico para el paciente: $paciente NHC: $postoperacion_id";
	$modulo = "Post Operacion";
	$insert = "INSERT INTO historial 
		VALUES('$historial_numero','0','0','$modulo','$postoperacion_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
	$mysqli->query($insert) or die($mysqli->error);
	/*********************************************************************************************************************************************************************/		
}else{
	$datos = array(
		0 => "Error", 
		1 => "No se puedo almacenar este registro, los datos son incorrectos por favor corregir", 
		2 => "error",
		3 => "btn-danger",
		4 => "",
		5 => "",			
	);
}

echo json_encode($datos);
?>