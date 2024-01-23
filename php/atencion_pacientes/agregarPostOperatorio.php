<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['servicio_id'];
$fecha = $_POST['post_fecha'];
$edad = $_POST['post_edad_consulta'];
$talla = $_POST['post_talla'];
$peso_actual = $_POST['post_peso_actual'];
$peso_actual_kg = $_POST['post_peso_actual_kg'];
$imc_actual = $_POST['post_imc_actual'];
$peso_perdido = $_POST['post_peso_perdido'];
$ewl = $_POST['post_ewl'];
$otros = cleanString($_POST['post_otros']);
$mejoria = cleanString($_POST['post_mejoria']);
$estado_actual = $_POST['post_estado_actual'];
$medicamentos = cleanString($_POST['post_medicamentos']);
$hallazgos = cleanString($_POST['post_hallazgos']);
$comentarios = cleanString($_POST['post_comentarios']);
$plan = cleanString($_POST['post_plan']);
$fecha_registro = date("Y-m-d H:i:s");
$estado = 1;//ACTIVO

//CONSULTAR TIPO DE PACIENTE EN AGENDA
$query_tipo_paciente = "SELECT paciente
	FROM agenda
	WHERE agenda_id = '$agenda_id'";
$result_tipo_paciente = $mysqli->query($query_tipo_paciente) or die($mysqli->error);
$consultar_tipo_paciente = $result_tipo_paciente->fetch_assoc(); 

$tipo_paciente = "";

if($result_tipo_paciente->num_rows>=0){
	$tipo_paciente = $consultar_tipo_paciente['paciente'];
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
		VALUES('$postoperacion_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$talla','$peso_actual','$peso_actual_kg','$imc_actual','$peso_perdido','$otros','$ewl','$mejoria','$estado_actual','$medicamentos','$hallazgos','$comentarios','$plan','$tipo_paciente','$estado','$fecha_registro')";

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