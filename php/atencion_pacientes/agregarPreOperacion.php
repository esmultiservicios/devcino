<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['servicio_id'];
$fecha = $_POST['pre_fecha'];
$edad = $_POST['pre_edad_consulta'];
$talla = cleanStringStrtolower($_POST['pre_talla']);
$peso_actual = cleanStringStrtolower($_POST['pre_peso_actual']);
$pre_peso_actual_kg = cleanString($_POST['pre_peso_actual_kg']);
$pre_peso_perdido = cleanString($_POST['pre_peso_perdido']);
$imc_actual = cleanStringStrtolower($_POST['pre_imc_actual']);
$resultados = cleanString($_POST['pre_resultados_examenes']);
$estado = 1;//ACTIVO

if(isset($_POST['psiquiatra_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['psiquiatra_activo'] == ""){
		$psquiatria = 2;
	}else{
		$psquiatria = $_POST['psiquiatra_activo'];
	}
}else{
	$psquiatria = 2;
}

if(isset($_POST['psicologo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['psicologo_activo'] == ""){
		$psicologia = 2;
	}else{
		$psicologia = $_POST['psicologo_activo'];
	}
}else{
	$psicologia = 2;
}

if(isset($_POST['nutricion_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nutricion_activo'] == ""){
		$nutricion = 2;
	}else{
		$nutricion = $_POST['nutricion_activo'];
	}
}else{
	$nutricion = 2;
}

if(isset($_POST['medicina_interna_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['medicina_interna_activo'] == ""){
		$medicina_interna = 2;
	}else{
		$medicina_interna = $_POST['medicina_interna_activo'];
	}
}else{
	$medicina_interna = 2;
}

$recomendaciones = cleanString($_POST['pre_recomendaciones']);
$fecha_cirugia = $_POST['pre_fecha_cirugia'];
$tipo_cirugia = $_POST['pre_tipo_cirugia'];
$fecha_registro = date("Y-m-d H:i:s");

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
$query = "SELECT preoperacion_id
	FROM preoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$preoperacion_id  = correlativo('preoperacion_id', 'preoperacion');
	$insert = "INSERT INTO preoperacion 
		VALUES('$preoperacion_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$talla','$peso_actual','$pre_peso_actual_kg','$imc_actual','$pre_peso_perdido','$resultados','$psquiatria','$psicologia','$nutricion','$medicina_interna','$recomendaciones','$fecha_cirugia','$tipo_cirugia','$tipo_paciente','$estado','$fecha_registro')";
	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){
					
		$datos = array(
			0 => "Almacenado", 
			1 => "Registro Almacenado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "AtencionMedicaPreOperatorio",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "modalRegistroPacientesPreoPeratorio", //Modals Para Cierre Automatico
			8 => $preoperacion_id,
			9 => "Guardar",			
		);
		
		/*********************************************************************************************************************************************************************/
		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado un nuevo expediente clinico para el paciente: $paciente NHC: $preoperacion_id";
		$modulo = "Pre Operacion";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$preoperacion_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
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
}else{
	$datos = array(
		0 => "Error", 
		1 => "Lo sentimos este registro ya existe no se puede almacenar", 
		2 => "error",
		3 => "btn-danger",
		4 => "",
		5 => "",		
	);
}

echo json_encode($datos);
?>