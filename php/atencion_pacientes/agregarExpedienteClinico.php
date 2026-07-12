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
$servicio_id = post_int('atenciones_servicio_id');
$fecha = post_text($mysqli, 'fecha');
$edad = post_text($mysqli, 'edad_consulta');
$inicio_obesidad = post_text($mysqli, 'inicio_obesidad');
$habito_alimenticio = post_text($mysqli, 'habito_alimenticio');
$tipo_obesidad = post_text($mysqli, 'tipo_obesidad');
$intentos_perdida_peso = post_text($mysqli, 'intentos_perdida_peso');
$peso_maximo_alcanzado = post_text($mysqli, 'peso_maximo_alcanzado');
$peso_maximo_alcanzado_kg = post_text($mysqli, 'peso_maximo_alcanzado_kg');
$sedentarismo = post_text($mysqli, 'sedentarismo');
$usuario = session_int('colaborador_id');

$ejercicio = checkbox_value('ejercicio_activo', 2);


if(isset($_POST['ejercicio_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ejercicio_respuesta'] == ""){
		$ejercicio_respuesta = "";
	}else{
		$ejercicio_respuesta = post_text($mysqli, 'ejercicio_respuesta');
	}
}else{
	$ejercicio_respuesta = "";
}

//INICIO PRIMERA FILA
$erge = checkbox_value('erge_activo', 2);

if(isset($_POST['erge_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['erge_respuesta'] == ""){
		$respuesta_erge = "";
	}else{
		$respuesta_erge = post_text($mysqli, 'erge_respuesta');
	}
}else{
	$respuesta_erge = "";
}

$hta = checkbox_value('hta_activo', 2);


if(isset($_POST['hta_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hta_respuesta'] == ""){
		$respuesta_hta = "";
	}else{
		$respuesta_hta = post_text($mysqli, 'hta_respuesta');
	}
}else{
	$respuesta_hta = "";
}

$higado_graso = checkbox_value('higado_graso_activo', 2);

if(isset($_POST['higado_graso_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['higado_graso_respuesta'] == ""){
		$respuesta_higado_graso = "";
	}else{
		$respuesta_higado_graso = post_text($mysqli, 'higado_graso_respuesta');
	}
}else{
	$respuesta_higado_graso = "";
}

if(isset($_POST['saos_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['saos_activo'] == ""){
		$saos = 2;
	}else{
		$saos = post_text($mysqli, 'saos_activo');
	}
}else{
	$saos = 2;
}

if(isset($_POST['saos_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['saos_respuesta'] == ""){
		$respuesta_saos = "";
	}else{
		$respuesta_saos = post_text($mysqli, 'saos_respuesta');
	}
}else{
	$respuesta_saos = "";
}

if(isset($_POST['hipotiroidismo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hipotiroidismo_activo'] == ""){
		$hipotiroidismo = 2;
	}else{
		$hipotiroidismo = post_text($mysqli, 'hipotiroidismo_activo');
	}
}else{
	$hipotiroidismo = 2;
}

if(isset($_POST['hipotiroidismo_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['hipotiroidismo_respuesta'] == ""){
		$respuesta_hipotiroidismo = "";
	}else{
		$respuesta_hipotiroidismo = post_text($mysqli, 'hipotiroidismo_respuesta');
	}
}else{
	$respuesta_hipotiroidismo = "";
}

if(isset($_POST['articulares_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['articulares_activo'] == ""){
		$articulares = 2;
	}else{
		$articulares = post_text($mysqli, 'articulares_activo');
	}
}else{
	$articulares = 2;
}

if(isset($_POST['articulares_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['articulares_respuesta'] == ""){
		$respuesta_articulares = "";
	}else{
		$respuesta_articulares = post_text($mysqli, 'articulares_respuesta');
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
		$ovarios_poliquisticos = post_text($mysqli, 'ovarios_poliquisticos_activo');
	}
}else{
	$ovarios_poliquisticos = 2;
}

if(isset($_POST['ovarios_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ovarios_respuesta'] == ""){
		$respuesta_ovarios_poliquisticos = "";
	}else{
		$respuesta_ovarios_poliquisticos = post_text($mysqli, 'ovarios_respuesta');
	}
}else{
	$respuesta_ovarios_poliquisticos = "";
}

if(isset($_POST['varices_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['varices_activo'] == ""){
		$varices = 2;
	}else{
		$varices = post_text($mysqli, 'varices_activo');
	}
}else{
	$varices = 2;
}

if(isset($_POST['varices_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['varices_respuesta'] == ""){
		$respuesta_varices = "";
	}else{
		$respuesta_varices = post_text($mysqli, 'varices_respuesta');
	}
}else{
	$respuesta_varices = "";
}


if(isset($_POST['drogas_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['drogas_activo'] == ""){
		$drogas = 2;
	}else{
		$drogas = post_text($mysqli, 'drogas_activo');
	}
}else{
	$drogas = 2;
}

if(isset($_POST['drogas_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['drogas_respuesta'] == ""){
		$respuesta_drogas = "";
	}else{
		$respuesta_drogas = post_text($mysqli, 'drogas_respuesta');
	}
}else{
	$respuesta_drogas = "";
}

if(isset($_POST['antecedentes_fami_diabetes_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_diabetes_activo'] == ""){
		$ant_fami_diabetes = 2;
	}else{
		$ant_fami_diabetes = post_text($mysqli, 'antecedentes_fami_diabetes_activo');
	}
}else{
	$ant_fami_diabetes = 2;
}

if(isset($_POST['ant_fam_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_respuesta'] == ""){
		$respuesta_ant_fami_diabetes = "";
	}else{
		$respuesta_ant_fami_diabetes = post_text($mysqli, 'ant_fam_respuesta');
	}
}else{
	$respuesta_ant_fami_diabetes = "";
}

if(isset($_POST['antecedentes_fami_Obesidad_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_Obesidad_activo'] == ""){
		$ant_fami_obesidad = 2;
	}else{
		$ant_fami_obesidad = post_text($mysqli, 'antecedentes_fami_Obesidad_activo');
	}
}else{
	$ant_fami_obesidad = 2;
}

if(isset($_POST['ant_fam_obecidad_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_obecidad_respuesta'] == ""){
		$respuesta_ant_fami_obesidad = "";
	}else{
		$respuesta_ant_fami_obesidad = post_text($mysqli, 'ant_fam_obecidad_respuesta');
	}
}else{
	$respuesta_ant_fami_obesidad = "";
}

if(isset($_POST['antecedentes_fami_cancer_gastrico_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_fami_cancer_gastrico_activo'] == ""){
		$ant_fami_cancer_gastrico = 2;
	}else{
		$ant_fami_cancer_gastrico = post_text($mysqli, 'antecedentes_fami_cancer_gastrico_activo');
	}
}else{
	$ant_fami_cancer_gastrico = 2;
}

if(isset($_POST['ant_fam_gastrico_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['ant_fam_gastrico_respuesta'] == ""){
		$respuesta_ant_fami_cancer_gastrico = "";
	}else{
		$respuesta_ant_fami_cancer_gastrico = post_text($mysqli, 'ant_fam_gastrico_respuesta');
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
		$ant_fami_psiquiatricas = post_text($mysqli, 'antecedentes_fami_psiquiatricas_activo');
	}
}else{
	$ant_fami_psiquiatricas = 2;
}

if(isset($_POST['enf_psiquiatricas_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['enf_psiquiatricas_respuesta'] == ""){
		$respuesta_respuesta_ant_fami_psiquiatricas = "";
	}else{
		$respuesta_respuesta_ant_fami_psiquiatricas = post_text($mysqli, 'enf_psiquiatricas_respuesta');
	}
}else{
	$respuesta_respuesta_ant_fami_psiquiatricas = "";
}

if(isset($_POST['antecedentes_dm_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['antecedentes_dm_activo'] == ""){
		$ant_dm = 2;
	}else{
		$ant_dm = post_text($mysqli, 'antecedentes_dm_activo');
	}
}else{
	$ant_dm = 2;
}

if(isset($_POST['dm_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dm_respuesta'] == ""){
		$respuesta_ant_dm = "";
	}else{
		$respuesta_ant_dm = post_text($mysqli, 'dm_respuesta');
	}
}else{
	$respuesta_ant_dm = "";
}

if(isset($_POST['alergias_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alergias_activo'] == ""){
		$alergias = 2;
	}else{
		$alergias = post_text($mysqli, 'alergias_activo');
	}
}else{
	$alergias = 2;
}

if(isset($_POST['alergias_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alergias_respuesta'] == ""){
		$respuesta_alergias = "";
	}else{
		$respuesta_alergias = post_text($mysqli, 'alergias_respuesta');
	}
}else{
	$respuesta_alergias = "";
}

if(isset($_POST['alcohol_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alcohol_activo'] == ""){
		$alcohol = 2;
	}else{
		$alcohol = post_text($mysqli, 'alcohol_activo');
	}
}else{
	$alcohol = 2;
}

if(isset($_POST['alcohol_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['alcohol_respuesta'] == ""){
		$respuesta_alcohol = "";
	}else{
		$respuesta_alcohol = post_text($mysqli, 'alcohol_respuesta');
	}
}else{
	$respuesta_alcohol = "";
}

if(isset($_POST['tabaquismo_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tabaquismo_activo'] == ""){
		$tabaquismo = 2;
	}else{
		$tabaquismo = post_text($mysqli, 'tabaquismo_activo');
	}
}else{
	$tabaquismo = 2;
}

if(isset($_POST['tabaquismo_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tabaquismo_respuesta'] == ""){
		$respuesta_tabaquismo = "";
	}else{
		$respuesta_tabaquismo = post_text($mysqli, 'tabaquismo_respuesta');
	}
}else{
	$respuesta_tabaquismo = "";
}

if(isset($_POST['dislipidemia_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dislipidemia_activo'] == ""){
		$dislipidemia = 2;
	}else{
		$dislipidemia = post_text($mysqli, 'dislipidemia_activo');
	}
}else{
	$dislipidemia = 2;
}

if(isset($_POST['dislipidemia_respuesta'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['dislipidemia_respuesta'] == ""){
		$respuesta_dislipidemia = "";
	}else{
		$respuesta_dislipidemia = post_text($mysqli, 'dislipidemia_respuesta');
	}
}else{
	$respuesta_dislipidemia = "";
}
//FIN TERCERA FILA

$otros = post_text($mysqli, 'otros');
$cirugia_abdominal_expediente = post_text($mysqli, 'cirugia_abdominal_expediente');
$talla = post_text($mysqli, 'talla');
$peso_ideal = post_text($mysqli, 'peso_ideal');
$peso_ideal_kg = post_text($mysqli, 'peso_ideal_kg');
$peso = post_text($mysqli, 'peso');
$peso_kg = post_text($mysqli, 'peso_kg');
$exceso_peso = post_text($mysqli, 'exceso_peso');
$exceso_peso_kg = post_text($mysqli, 'exceso_peso_kg');
$imc = post_text($mysqli, 'imc');
$diagnostico = post_text($mysqli, 'diagnostico');
$estudios_imagenes = post_text($mysqli, 'estudios_imagenes');
$referencia_a = post_text($mysqli, 'referencia_a');
$recomendaciones = post_text($mysqli, 'recomendaciones_quirurgicas');
$presupuesto = post_text($mysqli, 'presupuesto');
$expe_observaciones = post_text($mysqli, 'expe_observaciones');
$fecha_registro = date("Y-m-d H:i:s");
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
		$datos = [
			"status" => "success",
			"title" => "Success",
			"message" => "Registro Almacenado Correctamente",
			"type" => "success",
			"buttonClass" => "btn-primary",
			"preoperacion_id" => $clinico_id
		];		
		
		/*********************************************************************************************************************************************************************/
		//AGREGAMOS LOS ARCHIVOS CARGADOS EN LA ENTIDAD CLINICO_DETALLES	
		// Count total uploaded files
		$totalfiles = isset($_FILES['files']['name']) && is_array($_FILES['files']['name']) ? count($_FILES['files']['name']) : 0;

		//RECORREMOS EL FILE INPUT
		for($i=0;$i<$totalfiles;$i++){
			if (empty($_FILES['files']['name'][$i]) || empty($_FILES['files']['tmp_name'][$i])) { continue; }
			if (empty($_FILES['files']['name'][$i]) || empty($_FILES['files']['tmp_name'][$i])) { continue; }
			$clinico_detalles_id = correlativo('clinico_detalles_id', 'clinico_detalles');	
			$nombre_archivo = basename($_FILES['files']['name'][$i]);
			$nombre_archivo = preg_replace('/[^A-Za-z0-9._-]/', '_', $nombre_archivo);
			$filename = 'ec_'.$paciente.'_'.$nombre_archivo;
				
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
		$datos = [
			"status" => "error",
			"title" => "error",
			"message" => "No se puedo almacenar este registro, los datos son incorrectos por favor corregir", 
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
