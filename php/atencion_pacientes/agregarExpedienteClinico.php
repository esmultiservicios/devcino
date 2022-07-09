<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$servicio_id = $_POST['servicio_id'];
$fecha = $_POST['fecha'];
$edad = $_POST['edad_consulta'];
$inicio_obesidad = cleanStringStrtolower($_POST['inicio_obesidad']);
$habito_alimenticio = cleanStringStrtolower($_POST['habito_alimenticio']);
$tipo_obesidad = cleanStringStrtolower($_POST['tipo_obesidad']);
$intentos_perdida_peso = cleanStringStrtolower($_POST['intentos_perdida_peso']);
$peso_maximo_alcanzado = cleanStringStrtolower($_POST['peso_maximo_alcanzado']);
$peso_maximo_alcanzado_kg = cleanStringStrtolower($_POST['peso_maximo_alcanzado_kg']);
$sedentarismo = cleanStringStrtolower($_POST['sedentarismo']);

if(isset($_POST['ejercicio_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ejercicio_activo'] == ""){
		$ejercicio = 2;
	}else{
		$ejercicio = $_POST['ejercicio_activo'];
	}
}else{
	$ejercicio = 2;
}

if(isset($_POST['ejercicio_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ejercicio_respuesta'] == ""){
		$ejercicio_respuesta = "";
	}else{
		$ejercicio_respuesta = $_POST['ejercicio_respuesta'];
	}
}else{
	$ejercicio_respuesta = "";
}

//INICIO PRIMERA FILA
if(isset($_POST['erge_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['erge_activo'] == ""){
		$erge = 2;
	}else{
		$erge = $_POST['erge_activo'];
	}
}else{
	$erge = 2;
}

if(isset($_POST['erge_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['erge_respuesta'] == ""){
		$respuesta_erge = "";
	}else{
		$respuesta_erge = $_POST['erge_respuesta'];
	}
}else{
	$respuesta_erge = "";
}

if(isset($_POST['hta_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hta_activo'] == ""){
		$hta = 2;
	}else{
		$hta = $_POST['hta_activo'];
	}
}else{
	$hta = 2;
}

if(isset($_POST['hta_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hta_respuesta'] == ""){
		$respuesta_hta = "";
	}else{
		$respuesta_hta = $_POST['hta_respuesta'];
	}
}else{
	$respuesta_hta = "";
}

if(isset($_POST['higado_graso_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['higado_graso_activo'] == ""){
		$higado_graso = 2;
	}else{
		$higado_graso = $_POST['higado_graso_activo'];
	}
}else{
	$higado_graso = 2;
}

if(isset($_POST['higado_graso_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['higado_graso_respuesta'] == ""){
		$respuesta_higado_graso = "";
	}else{
		$respuesta_higado_graso = $_POST['higado_graso_respuesta'];
	}
}else{
	$respuesta_higado_graso = "";
}

if(isset($_POST['saos_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['saos_activo'] == ""){
		$saos = 2;
	}else{
		$saos = $_POST['saos_activo'];
	}
}else{
	$saos = 2;
}

if(isset($_POST['saos_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['saos_respuesta'] == ""){
		$respuesta_saos = "";
	}else{
		$respuesta_saos = $_POST['saos_respuesta'];
	}
}else{
	$respuesta_saos = "";
}

if(isset($_POST['hipotiroidismo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hipotiroidismo_activo'] == ""){
		$hipotiroidismo = 2;
	}else{
		$hipotiroidismo = $_POST['hipotiroidismo_activo'];
	}
}else{
	$hipotiroidismo = 2;
}

if(isset($_POST['hipotiroidismo_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hipotiroidismo_respuesta'] == ""){
		$respuesta_hipotiroidismo = "";
	}else{
		$respuesta_hipotiroidismo = $_POST['hipotiroidismo_respuesta'];
	}
}else{
	$respuesta_hipotiroidismo = "";
}

if(isset($_POST['articulares_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['articulares_activo'] == ""){
		$articulares = 2;
	}else{
		$articulares = $_POST['articulares_activo'];
	}
}else{
	$articulares = 2;
}

if(isset($_POST['articulares_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['articulares_respuesta'] == ""){
		$respuesta_articulares = "";
	}else{
		$respuesta_articulares = $_POST['articulares_respuesta'];
	}
}else{
	$respuesta_articulares = "";
}
//FIN PRIMERA FILA


//INICIO SEGUNDA FILA
if(isset($_POST['ovarios_poliquisticos_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ovarios_poliquisticos_activo'] == ""){
		$ovarios_poliquisticos = 2;
	}else{
		$ovarios_poliquisticos = $_POST['ovarios_poliquisticos_activo'];
	}
}else{
	$ovarios_poliquisticos = 2;
}

if(isset($_POST['ovarios_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ovarios_respuesta'] == ""){
		$respuesta_ovarios_poliquisticos = "";
	}else{
		$respuesta_ovarios_poliquisticos = $_POST['ovarios_respuesta'];
	}
}else{
	$respuesta_ovarios_poliquisticos = "";
}

if(isset($_POST['varices_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['varices_activo'] == ""){
		$varices = 2;
	}else{
		$varices = $_POST['varices_activo'];
	}
}else{
	$varices = 2;
}

if(isset($_POST['varices_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['varices_respuesta'] == ""){
		$respuesta_varices = "";
	}else{
		$respuesta_varices = $_POST['varices_respuesta'];
	}
}else{
	$respuesta_varices = "";
}


if(isset($_POST['drogas_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['drogas_activo'] == ""){
		$drogas = 2;
	}else{
		$drogas = $_POST['drogas_activo'];
	}
}else{
	$drogas = 2;
}

if(isset($_POST['drogas_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['drogas_respuesta'] == ""){
		$respuesta_drogas = "";
	}else{
		$respuesta_drogas = $_POST['drogas_respuesta'];
	}
}else{
	$respuesta_drogas = "";
}

if(isset($_POST['antecedentes_fami_diabetes_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_diabetes_activo'] == ""){
		$ant_fami_diabetes = 2;
	}else{
		$ant_fami_diabetes = $_POST['antecedentes_fami_diabetes_activo'];
	}
}else{
	$ant_fami_diabetes = 2;
}

if(isset($_POST['ant_fam_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_respuesta'] == ""){
		$respuesta_ant_fami_diabetes = "";
	}else{
		$respuesta_ant_fami_diabetes = $_POST['ant_fam_respuesta'];
	}
}else{
	$respuesta_ant_fami_diabetes = "";
}

if(isset($_POST['antecedentes_fami_Obesidad_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_Obesidad_activo'] == ""){
		$ant_fami_obesidad = 2;
	}else{
		$ant_fami_obesidad = $_POST['antecedentes_fami_Obesidad_activo'];
	}
}else{
	$ant_fami_obesidad = 2;
}

if(isset($_POST['ant_fam_obecidad_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_obecidad_respuesta'] == ""){
		$respuesta_ant_fami_obesidad = "";
	}else{
		$respuesta_ant_fami_obesidad = $_POST['ant_fam_obecidad_respuesta'];
	}
}else{
	$respuesta_ant_fami_obesidad = "";
}

if(isset($_POST['antecedentes_fami_cancer_gastrico_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_cancer_gastrico_activo'] == ""){
		$ant_fami_cancer_gastrico = 2;
	}else{
		$ant_fami_cancer_gastrico = $_POST['antecedentes_fami_cancer_gastrico_activo'];
	}
}else{
	$ant_fami_cancer_gastrico = 2;
}

if(isset($_POST['ant_fam_gastrico_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_gastrico_respuesta'] == ""){
		$respuesta_ant_fami_cancer_gastrico = "";
	}else{
		$respuesta_ant_fami_cancer_gastrico = $_POST['ant_fam_gastrico_respuesta'];
	}
}else{
	$respuesta_ant_fami_cancer_gastrico = "";
}
//FIN SEGUNDA FILA

//INICIO TERCERA FILA
if(isset($_POST['antecedentes_fami_psiquiatricas_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_psiquiatricas_activo'] == ""){
		$ant_fami_psiquiatricas = 2;
	}else{
		$ant_fami_psiquiatricas = $_POST['antecedentes_fami_psiquiatricas_activo'];
	}
}else{
	$ant_fami_psiquiatricas = 2;
}

if(isset($_POST['enf_psiquiatricas_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['enf_psiquiatricas_respuesta'] == ""){
		$respuesta_respuesta_ant_fami_psiquiatricas = "";
	}else{
		$respuesta_respuesta_ant_fami_psiquiatricas = $_POST['enf_psiquiatricas_respuesta'];
	}
}else{
	$respuesta_respuesta_ant_fami_psiquiatricas = "";
}

if(isset($_POST['antecedentes_dm_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_dm_activo'] == ""){
		$ant_dm = 2;
	}else{
		$ant_dm = $_POST['antecedentes_dm_activo'];
	}
}else{
	$ant_dm = 2;
}

if(isset($_POST['dm_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dm_respuesta'] == ""){
		$respuesta_ant_dm = "";
	}else{
		$respuesta_ant_dm = $_POST['dm_respuesta'];
	}
}else{
	$respuesta_ant_dm = "";
}

if(isset($_POST['alergias_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alergias_activo'] == ""){
		$alergias = 2;
	}else{
		$alergias = $_POST['alergias_activo'];
	}
}else{
	$alergias = 2;
}

if(isset($_POST['alergias_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alergias_respuesta'] == ""){
		$respuesta_alergias = "";
	}else{
		$respuesta_alergias = $_POST['alergias_respuesta'];
	}
}else{
	$respuesta_alergias = "";
}

if(isset($_POST['alcohol_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alcohol_activo'] == ""){
		$alcohol = 2;
	}else{
		$alcohol = $_POST['alcohol_activo'];
	}
}else{
	$alcohol = 2;
}

if(isset($_POST['alcohol_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alcohol_respuesta'] == ""){
		$respuesta_alcohol = "";
	}else{
		$respuesta_alcohol = $_POST['alcohol_respuesta'];
	}
}else{
	$respuesta_alcohol = "";
}

if(isset($_POST['tabaquismo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tabaquismo_activo'] == ""){
		$tabaquismo = 2;
	}else{
		$tabaquismo = $_POST['tabaquismo_activo'];
	}
}else{
	$tabaquismo = 2;
}

if(isset($_POST['tabaquismo_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tabaquismo_respuesta'] == ""){
		$respuesta_tabaquismo = "";
	}else{
		$respuesta_tabaquismo = $_POST['tabaquismo_respuesta'];
	}
}else{
	$respuesta_tabaquismo = "";
}

if(isset($_POST['dislipidemia_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dislipidemia_activo'] == ""){
		$dislipidemia = 2;
	}else{
		$dislipidemia = $_POST['dislipidemia_activo'];
	}
}else{
	$dislipidemia = 2;
}

if(isset($_POST['dislipidemia_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dislipidemia_respuesta'] == ""){
		$respuesta_dislipidemia = "";
	}else{
		$respuesta_dislipidemia = $_POST['dislipidemia_respuesta'];
	}
}else{
	$respuesta_dislipidemia = "";
}
//FIN TERCERA FILA

$otros = cleanStringStrtolower($_POST['otros']);
$cirugia_abdominal_expediente = cleanStringStrtolower($_POST['cirugia_abdominal_expediente']);
$talla = cleanStringStrtolower($_POST['talla']);
$peso_ideal = cleanStringStrtolower($_POST['peso_ideal']);
$peso_ideal_kg = cleanStringStrtolower($_POST['peso_ideal_kg']);
$peso = cleanStringStrtolower($_POST['peso']);
$peso_kg = cleanStringStrtolower($_POST['peso_kg']);
$exceso_peso = cleanStringStrtolower($_POST['exceso_peso']);
$exceso_peso_kg = cleanStringStrtolower($_POST['exceso_peso_kg']);
$imc = cleanStringStrtolower($_POST['imc']);
$diagnostico = cleanStringStrtolower($_POST['diagnostico']);
$estudios_imagenes = cleanStringStrtolower($_POST['estudios_imagenes']);
$referencia_a = cleanStringStrtolower($_POST['referencia_a']);
$recomendaciones = cleanStringStrtolower($_POST['recomendaciones_quirurgicas']);
$presupuesto = cleanStringStrtolower($_POST['presupuesto']);
$expe_observaciones = cleanStringStrtolower($_POST['expe_observaciones']);
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

//VERIFICAMOS QUE NO EXISTA EL REGISTRO
$query = "SELECT clinico_id
	FROM clinico
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$clinico_id  = correlativo('clinico_id', 'clinico');
	$insert = "INSERT INTO clinico 
		VALUES('$clinico_id','$agenda_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$edad','$inicio_obesidad','$habito_alimenticio','$tipo_obesidad','$intentos_perdida_peso','$peso_maximo_alcanzado','$peso_maximo_alcanzado_kg','$sedentarismo','$ejercicio','$ejercicio_respuesta','$alergias','$respuesta_alergias','$erge','$respuesta_erge','$hta','$respuesta_hta','$dislipidemia','$respuesta_dislipidemia','$higado_graso','$respuesta_higado_graso','$saos','$respuesta_saos','$hipotiroidismo','$respuesta_hipotiroidismo','$articulares','$respuesta_articulares','$ovarios_poliquisticos','$respuesta_ovarios_poliquisticos','$varices','$respuesta_varices','$tabaquismo','$respuesta_tabaquismo','$alcohol','$respuesta_alcohol','$drogas','$respuesta_drogas','$ant_fami_diabetes','$respuesta_ant_fami_diabetes','$ant_fami_obesidad','$respuesta_ant_fami_obesidad','$ant_fami_cancer_gastrico','$respuesta_ant_fami_cancer_gastrico','$ant_fami_psiquiatricas','$respuesta_respuesta_ant_fami_psiquiatricas','$ant_dm','$respuesta_ant_dm','$otros', '$cirugia_abdominal_expediente', '$talla','$peso_ideal','$peso_ideal_kg','$peso','$peso_kg','$exceso_peso','$exceso_peso_kg','$imc','$diagnostico','$estudios_imagenes','$referencia_a','$recomendaciones','$presupuesto','$expe_observaciones','$tipo_paciente','$estado','$fecha_registro')";
	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){					
		$datos = array(
			0 => "Almacenado", 
			1 => "Registro Almacenado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "AtencionMedica",
			7 => "modal_registro_atenciones", //Modals Para Cierre Automatico
			8 => $clinico_id,
			9 => "Guardar",			
		);
		
		/*********************************************************************************************************************************************************************/
		//AGREGAMOS LOS ARCHIVOS CARGADOS EN LA ENTIDAD CLINICO_DETALLES	
		// Count total uploaded files
		$totalfiles = count($_FILES['files']['name']);

		//RECORREMOS EL FILE INPUT
		for($i=0;$i<$totalfiles;$i++){
			$clinico_detalles_id = correlativo('clinico_detalles_id', 'clinico_detalles');	
			$filename = 'ec_'.$paciente.'_'.$_FILES['files']['name'][$i];
				
			//ESTABLECEMOS EL PATH DONDE SE GUARDARA EL DOCUMENTO
			$path = $_SERVER["DOCUMENT_ROOT"].PRODUCT_PATH.$filename;
			if (file_exists($path)){
				$file_exist = 1;
			}else{
				move_uploaded_file($_FILES["files"]["tmp_name"][$i],$path);		 			
				$insert = "INSERT INTO clinico_detalles VALUES('$clinico_detalles_id','$clinico_id','$filename', '$fecha_registro')";
				$query = $mysqli->query($insert);
			}
		}		
		/*********************************************************************************************************************************************************************/

		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado un nuevo expediente clinico para el paciente: $paciente NHC: $clinico_id";
		$modulo = "Expediente Clinico";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$clinico_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
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