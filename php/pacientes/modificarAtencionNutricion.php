<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$atenciones_nutricion_id = $_POST['atenciones_nutricion_id'];
$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$servicio_id = $_POST['atenciones_servicio_id'];
$fecha = $_POST['fecha_consulta'];
$edad = $_POST['edad_consulta'];
$motivo_consulta = cleanStringStrtolower($_POST['motivo_consulta']);
$ante_perso = cleanStringStrtolower($_POST['ante_perso']);
$ante_fam = cleanStringStrtolower($_POST['ante_fam']);
$alergias = cleanStringStrtolower($_POST['alergias']);
$adicciones = cleanStringStrtolower($_POST['adicciones']);
$niveles_estres = cleanStringStrtolower($_POST['niveles_estres']);
$niveles_actividad_fisica = cleanStringStrtolower($_POST['niveles_actividad_fisica']);
$intento_perdida_peso = cleanStringStrtolower($_POST['intento_perdida_peso']);
$antecedentes_quirurgicos = cleanStringStrtolower($_POST['antecedentes_quirurgicos']);
$observaciones = cleanStringStrtolower($_POST['observaciones']);
$diagnostico = cleanStringStrtolower($_POST['diagnostico']);
$indicaciones = cleanStringStrtolower($_POST['indicaciones']);
$colaborador_id = $_SESSION['colaborador_id'];
$fecha_registro = date("Y-m-d H:i:s");
$estado = 1;//ACTIVO

if(isset($_POST['candidato_bariatrica'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['candidato_bariatrica'] == ""){
		$candidato_bariatrica = 2;
	}else{
		$candidato_bariatrica = $_POST['candidato_bariatrica'];
	}
}else{
	$candidato_bariatrica = 2;
}


//CONSULTAR DATOS DEL PACIENTE
$query_paciente = "SELECT expediente, CONCAT(nombre, ' ', apellido) AS 'paciente', identidad
    FROM pacientes
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($query_paciente) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$expediente = '';
$paciente = '';
$identidad = '';

if($result->num_rows>0){
	$expediente = $consulta_registro['expediente'];
	$paciente = $consulta_registro['paciente'];
	$identidad = $consulta_registro['identidad'];	
}	 

//CONSULTAMOS SI EXISTE LA ATENCION DEL PACIENTE
$consultar_atencion = "SELECT atenciones_nutricion_id 
	FROM atenciones_nutricion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
$result_atencion = $mysqli->query($consultar_atencion) or die($mysqli->error);

if($result_atencion->num_rows>0){//NO EXISTE LA ATENCION PROCEDEMOS A GUARDARLA
	//MODIFICAMOS LOS DATOS EN LA ENTIDAD historia_clinica
	$update = "UPDATE atenciones_nutricion 
		SET 
			motivo_consulta = '$motivo_consulta',
			ante_perso = '$ante_perso',
			ante_fam = '$ante_fam',
			alergias = '$alergias',
			adicciones = '$adicciones',
			niveles_estres = '$niveles_estres',
			niveles_actividad_fisica = '$niveles_actividad_fisica',
			intento_perdida_peso = '$intento_perdida_peso',
			antecedentes_quirurgicos = '$antecedentes_quirurgicos',
			observaciones = '$observaciones',
			diagnostico = '$diagnostico',
			indicaciones = '$indicaciones',
			candidato_bariatrica = '$candidato_bariatrica'
		WHERE atenciones_nutricion_id = '$atenciones_nutricion_id'";

	$query = $mysqli->query($update);

	if($query){
		$datos = array(
			0 => "Modificado", 
			1 => "Registro Modificado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "ModificarAtencionMedica",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $atenciones_nutricion_id,
			9 => "",
		);

		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado una nueva atención para este paciente: $paciente con identidad n° $identidad";
		$modulo = "Historia Clinica";
		$insert = "INSERT INTO historial 
			VALUES('$historial_numero','$pacientes_id','$expediente','$modulo','$atenciones_nutricion_id','$colaborador_id','$servicio_id','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
		$mysqli->query($insert) or die($mysqli->error);
		/********************************************/			
	}else{
		$datos = array(
			0 => "Error", 
			1 => "No se puedo modificar este registro, los datos son incorrectos por favor corregir", 
			2 => "error",
			3 => "btn-danger",
			4 => "",
			5 => "",			
		);
	}
}else{//YA EXISTE UNA ATENCION NO SE PUEDE GUARDAR
	$datos = array(
		0 => "Error", 
		1 => "Lo sentimos este registro no existe no se puede almacenar", 
		2 => "error",
		3 => "btn-danger",
		4 => "",
		5 => "",		
	);
}

echo json_encode($datos);

$mysqli->close();//CERRAR CONEXIÓN
?>