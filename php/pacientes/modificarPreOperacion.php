<?php
session_start();
include '../funtions.php';

// CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = isset($_POST['agenda_id']) && !empty($_POST['agenda_id']) ? $_POST['agenda_id'] : 0;
$pacientes_id = isset($_POST['pacientes_id']) && !empty($_POST['pacientes_id']) ? $_POST['pacientes_id'] : 0;
$colaborador_id = isset($_POST['colaborador_id']) && !empty($_POST['colaborador_id']) ? $_POST['colaborador_id'] : 1;
$servicio_id = isset($_POST['servicio_id']) && !empty($_POST['servicio_id']) ? $_POST['servicio_id'] : 1;

$fecha = $_POST['pre_fecha'];
$edad = $_POST['pre_edad_consulta'];
$talla = cleanStringStrtolower($_POST['pre_talla']);
$peso_actual = cleanStringStrtolower($_POST['pre_peso_actual']);
$pre_peso_actual_kg = cleanString($_POST['pre_peso_actual_kg']);
$pre_peso_perdido = cleanString($_POST['pre_peso_perdido']);
$imc_actual = cleanStringStrtolower($_POST['pre_imc_actual']);
$resultados = cleanString($_POST['pre_resultados_examenes']);
$estado = 1;  // ACTIVO

if (isset($_POST['psiquiatra_activo'])) {  // COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if ($_POST['psiquiatra_activo'] == '') {
		$psquiatria = 2;
	} else {
		$psquiatria = $_POST['psiquiatra_activo'];
	}
} else {
	$psquiatria = 2;
}

if (isset($_POST['psicologo_activo'])) {  // COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if ($_POST['psicologo_activo'] == '') {
		$psicologia = 2;
	} else {
		$psicologia = $_POST['psicologo_activo'];
	}
} else {
	$psicologia = 2;
}

if (isset($_POST['nutricion_activo'])) {  // COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if ($_POST['nutricion_activo'] == '') {
		$nutricion = 2;
	} else {
		$nutricion = $_POST['nutricion_activo'];
	}
} else {
	$nutricion = 2;
}

if (isset($_POST['medicina_interna_activo'])) {  // COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if ($_POST['medicina_interna_activo'] == '') {
		$medicina_interna = 2;
	} else {
		$medicina_interna = $_POST['medicina_interna_activo'];
	}
} else {
	$medicina_interna = 2;
}

$recomendaciones = cleanString($_POST['pre_recomendaciones']);
$fecha_cirugia = $_POST['pre_fecha_cirugia'];
$tipo_cirugia = $_POST['pre_tipo_cirugia'];
$fecha_registro = date('Y-m-d H:i:s');

// CONSULTAR TIPO DE PACIENTE EN AGENDA
$query_tipo_paciente = "SELECT paciente
	FROM agenda
	WHERE agenda_id = '$agenda_id'";
$result_tipo_paciente = $mysqli->query($query_tipo_paciente) or die($mysqli->error);

$tipo_paciente = '';

if ($result_tipo_paciente->num_rows > 0) {
	$consultar_tipo_paciente = $result_tipo_paciente->fetch_assoc();
	$tipo_paciente = $consultar_tipo_paciente['paciente'];
}

// CONSULTA DATOS DEL PACIENTE
$query = "SELECT CONCAT(nombre, ' ', apellido) AS 'paciente', identidad, expediente AS 'expediente'
	FROM pacientes
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($query) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$paciente = '';
$identidad = '';
$expediente = '';

if ($result->num_rows > 0) {
	$paciente = $consulta_registro['paciente'];
	$identidad = $consulta_registro['identidad'];
	$expediente = $consulta_registro['expediente'];
}

// VERIFICAMOS QUE NO EXISTA EL REGISTRO EN LA ENTIDAD POST OPERACION
$query = "SELECT preoperacion_id
	FROM preoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";

$result = $mysqli->query($query) or die($mysqli->error);

if ($result->num_rows == 0) {
	// CONSULTAMOS EL EXPEDIENTE CLINICO
	$query_expediente_clinico = "SELECT preoperacion_id
	FROM preoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
	$result_expediente_clinico = $mysqli->query($query_expediente_clinico) or die($mysqli->error);

	$preoperacion_id = '';

	if ($result_expediente_clinico->num_rows > 0) {
		$consulta_registro_expediente = $result_expediente_clinico->fetch_assoc();
		$preoperacion_id = $consulta_registro_expediente['preoperacion_id'];
	}

	$update = "UPDATE preoperacion
		SET
			talla = '$talla',
			peso_actual = '$peso_actual',
			peso_actual_kg = '$pre_peso_actual_kg',
			peso_perdido = '$imc_actual',
			imc_actual = '$pre_peso_perdido',
			resultados = '$resultados',
			psquiatria = '$psquiatria',
			psicologia = '$psicologia',
			nutricion = '$nutricion',
			medicina_interna = '$medicina_interna',
			recomendaciones = '$recomendaciones',
			fecha_cirugia = '$fecha_cirugia',
			tipo_cirugia = '$tipo_cirugia'
		WHERE preoperacion_id = '$preoperacion_id'";
	$query = $mysqli->query($update) or die($mysqli->error);

	if ($query) {
		$datos = [
			'status' => 'success',
			'title' => 'Success',
			'message' => 'Registro AlModificado Correctamente',
			'type' => 'success',
			'buttonClass' => 'btn-primary',
			'preoperacion_id' => $preoperacion_id
		];

		/*********************************************************************************************************************************************************************/
		/*********************************************************************************************************************************************************************/
		// INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = 'Agregar';
		$observacion_historial = "Se ha modificado un nuevo expediente clinico para el paciente: $paciente NHC: $preoperacion_id";
		$modulo = 'Pre Operacion';
		$fecha_registro = date('Y-m-d H:i:s');
		
		$insert = "INSERT INTO historial (
			historial_id, 
			pacientes_id, 
			expediente, 
			modulo, 
			codigo, 
			colaborador_id, 
			servicio_id, 
			fecha, 
			status, 
			observacion, 
			usuario, 
			fecha_registro
		) VALUES (
			'$historial_numero', 
			'$pacientes_id', 
			'$expediente', 
			'$modulo', 
			'0', 
			'$colaborador_id', 
			'$servicio_id', 
			'$fecha', 
			'$estado_historial', 
			'$observacion_historial', 
			'$colaborador_id', 
			'$fecha_registro'
		)";		

		if (!$mysqli->query($insert)) {
			die("Error en la consulta: " . $mysqli->error);
		}
		/*********************************************************************************************************************************************************************/
	} else {
		$datos = [
			'status' => 'error',
			'title' => 'error',
			'message' => 'No se puedo almacenar este registro, los datos son incorrectos por favor corregir',
			'type' => 'error',
			'buttonClass' => 'btn-danger'
		];
	}
} else {
	$datos = [
		'status' => 'error',
		'title' => 'error',
		'message' => 'Lo sentimos este registro no existe no se puede modificar',
		'type' => 'error',
		'buttonClass' => 'btn-danger'
	];
}

echo json_encode($datos);
