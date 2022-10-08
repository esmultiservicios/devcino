<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['paciente_alimentos_id'];
$colaborador_id = 3; //PENSAR EN ESTA LOGICA PARA QUE EL COLABORADOR ID SE LLENE AUTOMATICAMENTE
$servicio_id = 2;//PENSAR EN UNA LOGICA PARA QUE EL SERVICIO_ID SE LLENE AUTOMATICAMENTE
$fecha = date("Y-m-d");
$fecha_registro = date("Y-m-d H:i:s");

if(isset($_POST['cafe'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['cafe'] == ""){
		$cafe = 2;
	}else{
		$cafe = $_POST['cafe'];
	}
}else{
	$cafe = 2;
}


if(isset($_POST['tes'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tes'] == ""){
		$tes = 2;
	}else{
		$tes = $_POST['tes'];
	}
}else{
	$tes = 2;
}


if(isset($_POST['leche'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['leche'] == ""){
		$leche = 2;
	}else{
		$leche = $_POST['leche'];
	}
}else{
	$leche = 2;
}


if(isset($_POST['yogurt'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['yogurt'] == ""){
		$yogurt = 2;
	}else{
		$yogurt = $_POST['yogurt'];
	}
}else{
	$yogurt = 2;
}


if(isset($_POST['requeson'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['requeson'] == ""){
		$requeson = 2;
	}else{
		$requeson = $_POST['requeson'];
	}
}else{
	$requeson = 2;
}


if(isset($_POST['cuajada'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['cuajada'] == ""){
		$cuajada = 2;
	}else{
		$cuajada = $_POST['cuajada'];
	}
}else{
	$cuajada = 2;
}


if(isset($_POST['queso_fresco'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['queso_fresco'] == ""){
		$queso_fresco = 2;
	}else{
		$queso_fresco = $_POST['queso_fresco'];
	}
}else{
	$queso_fresco = 2;
}


if(isset($_POST['queso_crema'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['queso_crema'] == ""){
		$queso_crema = 2;
	}else{
		$queso_crema = $_POST['queso_crema'];
	}
}else{
	$queso_crema = 2;
}


if(isset($_POST['mermelada'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['mermelada'] == ""){
		$mermelada = 2;
	}else{
		$mermelada = $_POST['mermelada'];
	}
}else{
	$mermelada = 2;
}


if(isset($_POST['mantequilla'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['mantequilla'] == ""){
		$mantequilla = 2;
	}else{
		$mantequilla = $_POST['mantequilla'];
	}
}else{
	$mantequilla = 2;
}


if(isset($_POST['pan_molde'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pan_molde'] == ""){
		$pan_molde = 2;
	}else{
		$pan_molde = $_POST['pan_molde'];
	}
}else{
	$pan_molde = 2;
}


if(isset($_POST['pan_baguette'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pan_baguette'] == ""){
		$pan_baguette = 2;
	}else{
		$pan_baguette = $_POST['pan_baguette'];
	}
}else{
	$pan_baguette = 2;
}


if(isset($_POST['bagels'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['bagels'] == ""){
		$bagels = 2;
	}else{
		$bagels = $_POST['bagels'];
	}
}else{
	$bagels = 2;
}


if(isset($_POST['pancakes'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pancakes'] == ""){
		$pancakes = 2;
	}else{
		$pancakes = $_POST['pancakes'];
	}
}else{
	$pancakes = 2;
}


if(isset($_POST['avena'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['avena'] == ""){
		$avena = 2;
	}else{
		$avena = $_POST['avena'];
	}
}else{
	$avena = 2;
}


if(isset($_POST['cereal'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['cereal'] == ""){
		$cereal = 2;
	}else{
		$cereal = $_POST['cereal'];
	}
}else{
	$cereal = 2;
}


if(isset($_POST['tortilla_maiz'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tortilla_maiz'] == ""){
		$tortilla_maiz = 2;
	}else{
		$tortilla_maiz = $_POST['tortilla_maiz'];
	}
}else{
	$tortilla_maiz = 2;
}


if(isset($_POST['tortilla_harina'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['tortilla_harina'] == ""){
		$tortilla_harina = 2;
	}else{
		$tortilla_harina = $_POST['tortilla_harina'];
	}
}else{
	$tortilla_harina = 2;
}


if(isset($_POST['arroz'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['arroz'] == ""){
		$arroz = 2;
	}else{
		$arroz = $_POST['arroz'];
	}
}else{
	$arroz = 2;
}


if(isset($_POST['papa'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['papa'] == ""){
		$papa = 2;
	}else{
		$papa = $_POST['papa'];
	}
}else{
	$papa = 2;
}


if(isset($_POST['camote'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['camote'] == ""){
		$camote = 2;
	}else{
		$camote = $_POST['camote'];
	}
}else{
	$camote = 2;
}


if(isset($_POST['pastas'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pastas'] == ""){
		$pastas = 2;
	}else{
		$pastas = $_POST['pastas'];
	}
}else{
	$pastas = 2;
}


if(isset($_POST['quinoa'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['quinoa'] == ""){
		$quinoa = 2;
	}else{
		$quinoa = $_POST['quinoa'];
	}
}else{
	$quinoa = 2;
}


if(isset($_POST['garbanzos'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['garbanzos'] == ""){
		$garbanzos = 2;
	}else{
		$garbanzos = $_POST['garbanzos'];
	}
}else{
	$garbanzos = 2;
}


if(isset($_POST['lentejas'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['lentejas'] == ""){
		$lentejas = 2;
	}else{
		$lentejas = $_POST['lentejas'];
	}
}else{
	$lentejas = 2;
}


if(isset($_POST['frijoles'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['frijoles'] == ""){
		$frijoles = 2;
	}else{
		$frijoles = $_POST['frijoles'];
	}
}else{
	$frijoles = 2;
}


if(isset($_POST['aguacate'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['aguacate'] == ""){
		$aguacate = 2;
	}else{
		$aguacate = $_POST['aguacate'];
	}
}else{
	$aguacate = 2;
}


if(isset($_POST['platano_maduro'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['platano_maduro'] == ""){
		$platano_maduro = 2;
	}else{
		$platano_maduro = $_POST['platano_maduro'];
	}
}else{
	$platano_maduro = 2;
}


if(isset($_POST['banana_verde'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['banana_verde'] == ""){
		$banana_verde = 2;
	}else{
		$banana_verde = $_POST['banana_verde'];
	}
}else{
	$banana_verde = 2;
}


if(isset($_POST['huevos'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['huevos'] == ""){
		$huevos = 2;
	}else{
		$huevos = $_POST['huevos'];
	}
}else{
	$huevos = 2;
}


if(isset($_POST['jamon'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['jamon'] == ""){
		$jamon = 2;
	}else{
		$jamon = $_POST['jamon'];
	}
}else{
	$jamon = 2;
}


if(isset($_POST['pollo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pollo'] == ""){
		$pollo = 2;
	}else{
		$pollo = $_POST['pollo'];
	}
}else{
	$pollo = 2;
}


if(isset($_POST['res'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['res'] == ""){
		$res = 2;
	}else{
		$res = $_POST['res'];
	}
}else{
	$res = 2;
}


if(isset($_POST['lomo_cerdo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['lomo_cerdo'] == ""){
		$lomo_cerdo = 2;
	}else{
		$lomo_cerdo = $_POST['lomo_cerdo'];
	}
}else{
	$lomo_cerdo = 2;
}


if(isset($_POST['filete_pescado'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['filete_pescado'] == ""){
		$filete_pescado = 2;
	}else{
		$filete_pescado = $_POST['filete_pescado'];
	}
}else{
	$filete_pescado = 2;
}


if(isset($_POST['atun'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['atun'] == ""){
		$atun = 2;
	}else{
		$atun = $_POST['atun'];
	}
}else{
	$atun = 2;
}


if(isset($_POST['sardinas'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['sardinas'] == ""){
		$sardinas = 2;
	}else{
		$sardinas = $_POST['sardinas'];
	}
}else{
	$sardinas = 2;
}


if(isset($_POST['camarones'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['camarones'] == ""){
		$camarones = 2;
	}else{
		$camarones = $_POST['camarones'];
	}
}else{
	$camarones = 2;
}

$vegetales = cleanString($_POST['vegetales']);
$frutas = cleanString($_POST['frutas']);
$desayuno = cleanString($_POST['desayuno']);
$merienda1 = cleanString($_POST['merienda1']);
$almuerzo = cleanString($_POST['almuerzo']);
$merienda2 = cleanString($_POST['merienda2']);
$cena = cleanString($_POST['cena']);

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
$query = "SELECT alimentos_id
	FROM alimentos
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id' AND fecha = '$fecha'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	$alimentos_id  = correlativo('alimentos_id', 'alimentos');
	$insert = "INSERT INTO alimentos VALUES('$alimentos_id','$pacientes_id','$colaborador_id','$servicio_id','$fecha','$cafe','$tes','$leche','$yogurt','$requeson','$cuajada','$queso_fresco','$queso_crema','$mermelada','$mantequilla','$pan_molde','$pan_baguette','$bagels','$pancakes','$avena','$cereal','$tortilla_maiz','$tortilla_harina','$arroz','$papa','$camote','$pastas','$quinoa','$garbanzos','$lentejas','$frijoles','$aguacate','$platano_maduro','$banana_verde','$huevos','$jamon','$pollo','$res','$lomo_cerdo','$filete_pescado','$atun','$sardinas','$camarones','$vegetales','$frutas','$desayuno','$merienda1','$almuerzo','$merienda2','$cena','$fecha_registro')";	

	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){					
		$datos = array(
			0 => "Almacenado", 
			1 => "Registro Almacenado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "AgregarrAlimentos",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $alimentos_id,
			9 => "Guardar",			
		);
		
		/*********************************************************************************************************************************************************************/
		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado un nuevo registro de alimentos para el paciente: $paciente con el numero de control: $alimentos_id";
		$modulo = "Expediente Clinico";
		$insert = "INSERT INTO historial 
		   VALUES('$historial_numero','0','0','$modulo','$alimentos_id','$colaborador_id','0','$fecha','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
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