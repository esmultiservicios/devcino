<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_SESSION['colaborador_id'];
$servicio_id = $_POST['servicio_notaOperatoria_id'];
$fecha = $_POST['nota_fecha'];
$edad = $_POST['nota_edad_consulta'];
$talla = cleanStringStrtolower($_POST['nota_talla']);
$peso_actual = cleanStringStrtolower($_POST['nota_peso_actual']);
$peso_actual_kg = cleanStringStrtolower($_POST['nota_peso_actual_kg']);
$nota_peso_perdido = cleanStringStrtolower($_POST['nota_peso_perdido']);
$imc_actual = cleanStringStrtolower($_POST['nota_imc_actual']);
$nota_tecnica = cleanString($_POST['nota_tecnica']);
$cirujano = cleanStringStrtolower($_POST['nota_cirujano']);
$asistente = cleanStringStrtolower($_POST['nota_asistente']);
$camara = cleanString($_POST['nota_camara']);
$anestesia = $_POST['nota_anestesia'];
$anestesiologo = cleanString($_POST['nota_anestesiologo']);
$nota_otros = cleanString($_POST['nota_otros']);
$nota_hallazgos_operativos = cleanString($_POST['nota_hallazgos_operativos']);
$nota_descripcion_operatoria = cleanString($_POST['nota_descripcion_operatoria']);
$indicaciones = cleanString($_POST['nota_indicaciones']);
$nota_recomendaciones = cleanString($_POST['nota_recomendaciones']);
$nota_comentarios = cleanString($_POST['nota_comentarios']);
$estado = 1;//ACTIVO

if(isset($_POST['nota_prueba_metileno_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nota_prueba_metileno_activo'] == ""){
		$prueba = 2;
	}else{
		$prueba = $_POST['nota_prueba_metileno_activo'];
	}
}else{
	$prueba = 2;
}

if(isset($_POST['nota_dreno_blake_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nota_dreno_blake_activo'] == ""){
		$blake = 2;
	}else{
		$blake = $_POST['nota_dreno_blake_activo'];
	}
}else{
	$blake = 2;
}

if(isset($_POST['nota_extraccion_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nota_extraccion_activo'] == ""){
		$extraccion = 2;
	}else{
		$extraccion = $_POST['nota_extraccion_activo'];
	}
}else{
	$extraccion = 2;
}

if(isset($_POST['nota_evacuo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nota_evacuo_activo'] == ""){
		$evacuo = 2;
	}else{
		$evacuo = $_POST['nota_evacuo_activo'];
	}
}else{
	$evacuo = 2;
}

if(isset($_POST['nota_cierro_piel_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['nota_cierro_piel_activo'] == ""){
		$cierro = 2;
	}else{
		$cierro = $_POST['nota_cierro_piel_activo'];
	}
}else{
	$cierro = 2;
}

$comentarios = cleanString($_POST['nota_comentarios']);
$fecha_registro = date("Y-m-d H:i:s");

//CONSULTAR TIPO DE PACIENTE EN AGENDA
$query_tipo_paciente = "SELECT paciente
	FROM agenda
	WHERE agenda_id = '$agenda_id'";
$result_tipo_paciente = $mysqli->query($query_tipo_paciente) or die($mysqli->error);

$tipo_paciente = ""; // Valor predeterminado

if ($result_tipo_paciente->num_rows > 0) {
    $consultar_tipo_paciente = $result_tipo_paciente->fetch_assoc();
    $tipo_paciente = $consultar_tipo_paciente['paciente'];
} else {
    // Si no se encuentra el registro, puedes asignar un valor por defecto o manejar el error aquí
    $tipo_paciente = ""; 
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
$query = "SELECT notaoperacion_id
	FROM notaoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";

$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==1){
	//CONSULTAMOS EL EXPEDIENTE CLINICO
	$query_expediente_clinico = "SELECT notaoperacion_id
	FROM notaoperacion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
	$result_expediente_clinico = $mysqli->query($query_expediente_clinico) or die($mysqli->error);

	$notaoperacion_id = '';

	if($result_expediente_clinico->num_rows>0){
		$consulta_registro_expediente = $result_expediente_clinico->fetch_assoc();
		$notaoperacion_id = $consulta_registro_expediente['notaoperacion_id'];
	}	
		
	$udpate = "UPDATE notaoperacion
		SET
			talla = '$talla',
			peso_actual = '$peso_actual',
			peso_actual_kg = '$peso_actual_kg',
			peso_perdido = '$nota_peso_perdido',
			imc_actual = '$imc_actual',
			tecnica = '$nota_tecnica',
			cirujano = '$cirujano',
			asistente = '$asistente',
			camara = '$camara',
			anestesia = '$anestesia',
			anestesiologo = '$anestesiologo',
			otros = '$nota_otros',
			hallazgos_operativos = '$nota_hallazgos_operativos',
			descripcion_operativos = '$nota_descripcion_operatoria',
			indicaciones = '$indicaciones',
			recomendaciones = '$nota_recomendaciones',
			prueba = '$prueba',
			blake = '$blake',
			extraccion = '$extraccion',
			evacuo = '$evacuo',
			cierro = '$cierro',
			comentarios = '$comentarios'
		WHERE notaoperacion_id = '$notaoperacion_id'";
	$query = $mysqli->query($udpate) or die($mysqli->error);

    if($query){				
		$datos = [
			"status" => "success",
			"title" => "Success",
			"message" => "Registro Modificado Correctamente", 
			"type" => "success",
			"buttonClass" => "btn-primary",
			"preoperacion_id" => $notaoperacion_id
		];
		
		/*********************************************************************************************************************************************************************/
		//AGREGAMOS LOS ARCHIVOS CARGADOS EN LA ENTIDAD CLINICO_DETALLES	
		// Count total uploaded files
		$totalfiles = count($_FILES['files']['name']);

		//RECORREMOS EL FILE INPUT
		for($i=0;$i<$totalfiles;$i++){
			$notaoperacion_detalles_id = correlativo('notaoperacion_detalles_id', 'notaoperacion_detalles');	
			$filename = 'no_'.$paciente.'_'.$_FILES['files']['name'][$i];
				
			//ESTABLECEMOS EL PATH DONDE SE GUARDARA EL DOCUMENTO
			$path = $_SERVER["DOCUMENT_ROOT"].PRODUCT_PATH.$filename;
			if (file_exists($path)){
				$file_exist = 1;
			}else{
				move_uploaded_file($_FILES["files"]["tmp_name"][$i],$path);		 			
				$insert = "INSERT INTO notaoperacion_detalles VALUES('$notaoperacion_detalles_id','$notaoperacion_id','$filename', '$fecha_registro')";
				$query = $mysqli->query($insert);
			}
		}		
		/*********************************************************************************************************************************************************************/

		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha modifcado un nuevo expediente clinico para el paciente: $paciente NHC: $notaoperacion_id";
		$modulo = "Nota Operatoria";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$notaoperacion_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
		$mysqli->query($insert) or die($mysqli->error);
		/*********************************************************************************************************************************************************************/		
	}else{
		$datos = [
			"status" => "error",
			"title" => "error",
			"message" => "No se puedo modificar este registro, los datos son incorrectos por favor corregir", 
			"type" => "error",
			"buttonClass" => "btn-danger"
		];
	}
}else{
	$datos = [
		"status" => "error",
		"title" => "error",
		"message" => "Lo sentimos este registro no existe no se puede modificar", 
		"type" => "error",
		"buttonClass" => "btn-danger"
	];
}

echo json_encode($datos);