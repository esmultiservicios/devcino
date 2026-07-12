<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

/*
|--------------------------------------------------------------------------
| FUNCIONES LOCALES DE ENTRADA
|--------------------------------------------------------------------------
| Conservan mayúsculas/minúsculas y protegen valores usados en SQL.
*/
function post_text($mysqli, $campo, $predeterminado = "") {
    $valor = isset($_POST[$campo]) ? trim((string)$_POST[$campo]) : $predeterminado;
    return $mysqli->real_escape_string($valor);
}

function post_int($campo, $predeterminado = 0) {
    return isset($_POST[$campo]) && $_POST[$campo] !== ""
        ? (int)$_POST[$campo]
        : (int)$predeterminado;
}

function session_int($campo, $predeterminado = 0) {
    return isset($_SESSION[$campo]) && $_SESSION[$campo] !== ""
        ? (int)$_SESSION[$campo]
        : (int)$predeterminado;
}

function checkbox_value($campo, $predeterminado = 2) {
    return isset($_POST[$campo]) && $_POST[$campo] !== ""
        ? (int)$_POST[$campo]
        : (int)$predeterminado;
}

if (session_int('colaborador_id') <= 0) {
    echo json_encode([
        "status" => "error",
        "title" => "Error",
        "message" => "Sesión expirada o usuario no válido",
        "type" => "error",
        "buttonClass" => "btn-danger"
    ], JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}


$pacientes_id = post_int('pacientes_id');
$colaborador_id = session_int('colaborador_id');
$servicio_id = post_int('servicio_PostOperatorio_id');
$fecha = post_text($mysqli, 'post_fecha');
$edad = post_text($mysqli, 'post_edad_consulta');
$talla = post_text($mysqli, 'post_talla');
$peso_actual = post_text($mysqli, 'post_peso_actual');
$peso_actual_kg = post_text($mysqli, 'post_peso_actual_kg');
$imc_actual = post_text($mysqli, 'post_imc_actual');
$peso_perdido = post_text($mysqli, 'post_peso_perdido');
$ewl = post_text($mysqli, 'post_ewl');
$otros = post_text($mysqli, 'post_otros');
$mejoria = post_text($mysqli, 'post_mejoria');
$estado_actual = post_text($mysqli, 'post_estado_actual');
$medicamentos = post_text($mysqli, 'post_medicamentos');
$hallazgos = post_text($mysqli, 'post_hallazgos');
$comentarios = post_text($mysqli, 'post_comentarios');
$plan = post_text($mysqli, 'post_plan');
$fecha_registro = date("Y-m-d H:i:s");
$usuario = session_int('colaborador_id');
$estado = 1;//ACTIVO

//GUARDAMOS EL REGISTRO DEL PACIENTE EN LA AGENDA
//CONSULTAR PUESTO COLABORADOR
$consulta_puesto = "SELECT puesto_id 
	FROM colaboradores 
	WHERE colaborador_id = '$colaborador_id'";
$result = $mysqli->query($consulta_puesto);

$puesto_colaborador = "";

if($result->num_rows>0){
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

$tipo_paciente = 'N';
$color = '#008000'; //VERDE;

if($result_tipo_paciente->num_rows > 0){
	$tipo_paciente = 'S';
	$color = '#0071c5'; //AZUL;	
}

$consultar_expediente= "SELECT expediente, CONCAT(nombre,' ',apellido) AS nombre 
	FROM pacientes 
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consultar_expediente);

$expediente = "";
$nombre = "";

if($result->num_rows>0){
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
	$datos = [
		"status" => "success",
		"title" => "Success",
		"message" => "Registro Almacenado Correctamente",
		"type" => "success",
		"buttonClass" => "btn-primary",
		"postoperacion_id" => $postoperacion_id
	];		
	
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
	$datos = [
		"status" => "error",
		"title" => "error",
		"message" => "No se puedo almacenar este registro, los datos son incorrectos por favor corregir",  
		"type" => "error",
		"buttonClass" => "btn-danger"
	];
}

echo json_encode($datos);
?>