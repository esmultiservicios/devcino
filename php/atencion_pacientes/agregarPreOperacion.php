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
$servicio_id = post_int('servicio_preoperatorio_id');

$fecha = post_text($mysqli, 'pre_fecha');
$edad = post_text($mysqli, 'pre_edad_consulta');

$talla = post_text($mysqli, 'pre_talla');
$peso_actual = post_text($mysqli, 'pre_peso_actual');
$pre_peso_actual_kg = post_text($mysqli, 'pre_peso_actual_kg');
$pre_peso_perdido = post_text($mysqli, 'pre_peso_perdido');
$imc_actual = post_text($mysqli, 'pre_imc_actual');
$resultados = post_text($mysqli, 'pre_resultados_examenes');
$usuario = session_int('colaborador_id');
$estado = 1;//ACTIVO

if(isset($_POST['psiquiatra_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['psiquiatra_activo'] == ""){
		$psquiatria = 2;
	}else{
		$psquiatria = post_text($mysqli, 'psiquiatra_activo');
	}
}else{
	$psquiatria = 2;
}

if(isset($_POST['psicologo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['psicologo_activo'] == ""){
		$psicologia = 2;
	}else{
		$psicologia = post_text($mysqli, 'psicologo_activo');
	}
}else{
	$psicologia = 2;
}

if(isset($_POST['nutricion_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nutricion_activo'] == ""){
		$nutricion = 2;
	}else{
		$nutricion = post_text($mysqli, 'nutricion_activo');
	}
}else{
	$nutricion = 2;
}

if(isset($_POST['medicina_interna_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['medicina_interna_activo'] == ""){
		$medicina_interna = 2;
	}else{
		$medicina_interna = post_text($mysqli, 'medicina_interna_activo');
	}
}else{
	$medicina_interna = 2;
}

$recomendaciones = post_text($mysqli, 'pre_recomendaciones');
$fecha_cirugia = post_text($mysqli, 'pre_fecha_cirugia');
$tipo_cirugia = post_text($mysqli, 'pre_tipo_cirugia');
$fecha_registro = date("Y-m-d H:i:s");

if ($pacientes_id <= 0 || $servicio_id <= 0 || $fecha === "" || $fecha_cirugia === "" || $tipo_cirugia === "") {
    echo json_encode([
        "status" => "error",
        "title" => "Error",
        "message" => "Debe completar paciente, servicio, fecha de atención, fecha de cirugía y tipo de cirugía",
        "type" => "error",
        "buttonClass" => "btn-danger"
    ], JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}

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

$paciente_tipo = 'N';
$color = '#008000'; //VERDE;

if($result_tipo_paciente->num_rows > 0){
	$paciente_tipo = 'S';
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
	VALUES('$agenda_id', '$pacientes_id', '$expediente', '$colaborador_id', '$hora', '$fecha_cita', '$fecha_cita', '$fecha_registro', '0', '$color', '$observacion','$usuario','$servicio_id','','1','0','2','$paciente_tipo','0')";

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
$query = "SELECT preoperacion_id
	FROM preoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$preoperacion_id  = correlativo('preoperacion_id', 'preoperacion');

	$insert = "INSERT INTO preoperacion 
		VALUES('$preoperacion_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$talla','$peso_actual','$pre_peso_actual_kg','$imc_actual','$pre_peso_perdido','$resultados','$psquiatria','$psicologia','$nutricion','$medicina_interna','$recomendaciones','$fecha_cirugia','$tipo_cirugia','$paciente_tipo','$estado','$fecha_registro')";
	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){
					
		$datos = [
			"status" => "success",
			"title" => "Success",
			"message" => "Registro Almacenado Correctamente",
			"type" => "success",
			"buttonClass" => "btn-primary",
			"preoperacion_id" => $preoperacion_id
		];
		
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
		$datos = [
			"status" => "error",
			"title" => "error",
			"message" => "No se pudo almacenar este registro, los datos son incorrectos",
			"type" => "error",
			"buttonClass" => "btn-danger"
		];
	}
}else{
	$datos = [
        "status" => "error",
		"title" => "error",
        "message" => "Lo sentimos este registro ya existe no se puede almacenar", 
        "type" => "error",
        "buttonClass" => "btn-danger"
    ];
}

echo json_encode($datos);