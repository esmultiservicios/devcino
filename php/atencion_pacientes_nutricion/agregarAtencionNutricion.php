<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['atenciones_servicio_id'];
$fecha = $_POST['fecha_consulta'];
$edad = $_POST['edad_consulta'];
$motivo_consulta = cleanString($_POST['motivo_consulta']);
$ante_perso = cleanString($_POST['ante_perso']);
$ante_fam = cleanString($_POST['ante_fam']);
$alergias = cleanString($_POST['alergias']);
$adicciones = cleanString($_POST['adicciones']);
$niveles_estres = cleanString($_POST['niveles_estres']);
$niveles_actividad_fisica = cleanString($_POST['niveles_actividad_fisica']);
$intento_perdida_peso = cleanString($_POST['intento_perdida_peso']);
$antecedentes_quirurgicos = cleanString($_POST['antecedentes_quirurgicos']);
$observaciones = cleanString($_POST['observaciones']);
$diagnostico = cleanString($_POST['diagnostico']);
$indicaciones = cleanString($_POST['indicaciones']);
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
$query = "SELECT atenciones_nutricion_id
	FROM atenciones_nutricion
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$atenciones_nutricion_id  = correlativo('atenciones_nutricion_id', 'atenciones_nutricion');
	$insert = "INSERT INTO atenciones_nutricion VALUES('$atenciones_nutricion_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$motivo_consulta','$ante_perso','$ante_fam','$alergias','$adicciones','$niveles_estres','$niveles_actividad_fisica','$intento_perdida_peso','$antecedentes_quirurgicos','$observaciones','$diagnostico','$indicaciones','$candidato_bariatrica','$colaborador_id','$estado','$fecha_registro')";

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
			6 => "AgregarAtencionMedica",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $atenciones_nutricion_id,
			9 => "Guardar",			
		);
		
		/*********************************************************************************************************************************************************************/
		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado un nuevo expediente clinico para el paciente: $paciente NHC: $atenciones_nutricion_id";
		$modulo = "Expediente Clinico";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$atenciones_nutricion_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
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