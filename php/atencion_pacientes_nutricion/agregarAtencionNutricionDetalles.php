<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['atenciones_servicio_id'];
$atenciones_nutricion_id = $_POST['atenciones_nutricion_id'];
$fecha_otros = $_POST['fecha_otros'];
$peso_hab = cleanString($_POST['peso_hab']);
$peso_p25 = cleanString($_POST['peso_p25']);
$brazo = cleanString($_POST['brazo']);
$muneca = cleanString($_POST['muneca']);
$msj = cleanString($_POST['msj']);
$cintura = cleanString($_POST['cintura']);
$cadera = cleanString($_POST['cadera']);
$indice_cc = cleanString($_POST['indice_cc']);
$estatura = cleanString($_POST['estatura']);
$imc = cleanString($_POST['imc']);
$talla = cleanString($_POST['talla']);
$peso_activo = cleanString($_POST['peso_activo']);
$riesgo_vascular = cleanString($_POST['riesgo_vascular']);
$porcentaje_grasa = cleanString($_POST['porcentaje_grasa']);
$tipo_dieta = cleanString($_POST['tipo_dieta']);
$pa = cleanString($_POST['pa']);
$abdomen = cleanString($_POST['abdomen']);

$colaborador_id = $_SESSION['colaborador_id'];
$fecha_registro = date("Y-m-d H:i:s");
$estado = 1;//ACTIVO

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
	$insert = "INSERT INTO atenciones_nutricion_detalles VALUES('$atenciones_nutricion_detalles_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha_otros','$peso_hab','$peso_p25','$brazo','$muneca','$msj','$cintura','$cadera','$indice_cc','$estatura','$imc','$talla','$peso_activo','$riesgo_vascular','$porcentaje_grasa','$tipo_dieta','$pa','$abdomen', '$colaborador_id','$fecha_registro')";	

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