<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_SESSION['colaborador_id'];
$servicio_id = $_POST['atenciones_servicio_id'];
$atenciones_nutricion_id = $_POST['atenciones_nutricion_id'];
$fecha_otros = $_POST['fecha_otros'];

$peso_hab = cleanString($_POST['peso_hab']);
$peso = cleanString($_POST['peso']);
$estatura = cleanString($_POST['estatura']);
$cintura = cleanString($_POST['cintura']);
$cadera = cleanString($_POST['cadera']);
$indice_cc = cleanString($_POST['indice_cc']);
$brazo = cleanString($_POST['brazo']);
$imc = cleanString($_POST['imc']);
$msj = cleanString($_POST['msj']);
$pa = cleanString($_POST['pa']);
$sedentario = cleanString($_POST['sedentario']);
$act_moderada = cleanString($_POST['act_moderada']);
$act_vigorosa = cleanString($_POST['act_vigorosa']);
$impedancia_g = cleanString($_POST['impedancia_g']);
$impedancia_m = cleanString($_POST['impedancia_m']);
$impedancia_gv = cleanString($_POST['impedancia_gv']);
$alimentos = cleanString($_POST['alimentos']);

$colaborador_id = $_SESSION['colaborador_id'];
$fecha_registro = date("Y-m-d H:i:s");
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
	$tipo_paciente = 'N';
	$color = '#008000'; //VERDE;
}else{ 
	$tipo_paciente = 'S';
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
	VALUES('$agenda_id', '$pacientes_id', '$expediente', '$colaborador_id', '$hora', '$fecha_cita', '$fecha_cita', '$fecha_registro', '0', '$color', '$observacion','$usuario','$servicio_id','','1','0','2','$tipo_paciente','0')";

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

//VERIFICAMOS QUE NO EXISTA EL REGISTRO
$query = "SELECT atenciones_nutricion_detalles_id
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha_otros'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$atenciones_nutricion_detalles_id  = correlativo('atenciones_nutricion_detalles_id', 'atenciones_nutricion_detalles');
	$insert = "INSERT INTO atenciones_nutricion_detalles VALUES('$atenciones_nutricion_detalles_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha_otros','$peso_hab','$peso','$estatura','$cintura','$cadera','$indice_cc','$brazo','$imc','$msj','$pa','$impedancia_g','$impedancia_m','$impedancia_gv','$sedentario','$act_moderada','$act_vigorosa','$alimentos', '$colaborador_id','$fecha_registro')";	

	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){
		//ACTUALIZAMOS EL ESTADO DE LA AGENDA
		$status = 1;
		$update = "UPDATE agenda SET status = '$status'
		   WHERE agenda_id = '$agenda_id'";	
		$mysqli->query($update) or die($mysqli->error);
					
		$datos = array(
			0 => "Almacenado", 
			1 => "Registro Almacenado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "AgregarrAtencionMedicaDetalles",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $atenciones_nutricion_detalles_id,
			9 => "Guardar",			
		);
		
		/*********************************************************************************************************************************************************************/
		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado un nuevo expediente clinico para el paciente: $paciente NHC: $atenciones_nutricion_detalles_id";
		$modulo = "Expediente Clinico";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$atenciones_nutricion_detalles_id','$colaborador_id','0','$fecha_otros','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
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