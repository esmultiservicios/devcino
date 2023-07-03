<?php
if(!isset($_SESSION)){
	session_start();
}

include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

$fecha_registro = date("Y-m-d H:i:s");
$fecha = date("Y-m-d");
$secuencia_facturacion_id = $_POST['secuencia_facturacion_id'];

if(isset($_POST['secuencia_profesional'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['secuencia_profesional'] == ""){
		$colaborador_id = 0;
	}else{
		$colaborador_id = $_POST['secuencia_profesional'];
	}
}else{
	$colaborador_id = 0;
}

$cai = $_POST['cai'];
$prefijo = $_POST['prefijo'];
$relleno = $_POST['relleno'];
$incremento = $_POST['incremento'];
$siguiente = $_POST['siguiente'];
$rango_inicial = $_POST['rango_inicial'];
$rango_final = $_POST['rango_final'];
$fecha_activacion = $_POST['fecha_activacion'];
$fecha_limite = $_POST['fecha_limite'];
$usuario = $_SESSION['colaborador_id'];
$comentario = "";

if(isset($_POST['estado'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['estado'] == ""){
		$estado = 0;
	}else{
		$estado = $_POST['estado'];
	}
}else{
	$estado = 0;
}

//VERIFICAMOS QUE SOLO EXISTA UN REGISTRO DE ADMINISTRADOR DE SECUENCIAS PARA LA FACTURACION
$query = "SELECT secuencia_facturacion_id
    FROM secuencia_facturacion
	WHERE activo = 1 AND colaborador_id = '$colaborador_id'";
$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows==0){
	//ALMACENAMOS EL ADMINISTRADOR DE SECUENCIAS PARA LA FACTURACION
	$correlativo = correlativo('secuencia_facturacion_id ', 'secuencia_facturacion');
	if($rango_inicial != ""){
		$rango_inicial =  str_pad($rango_inicial, $relleno, "0", STR_PAD_LEFT);
	}

	if($rango_final != ""){
		$rango_final =  str_pad($rango_final, $relleno, "0", STR_PAD_LEFT);
	}

	$documento_id = "1";//FACTURA ELECTRONICA
	$insert = "INSERT INTO secuencia_facturacion
		VALUES('$correlativo','$colaborador_id','$cai','$prefijo','$relleno','$incremento','$siguiente','$rango_inicial','$rango_final','$fecha_activacion','$fecha_limite','$comentario','$estado','$usuario','$fecha_registro','$documento_id')";
	$query = $mysqli->query($insert) or die($mysqli->error);

    if($query){
		$datos = array(
			0 => "Almacenado",
			1 => "Registro Almacenado Correctamente",
			2 => "success",
			3 => "btn-primary",
			4 => "formularioSecuenciaFacturacion",
			5 => "Registro",
			6 => "SecuenciaFacturacion",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
		);

		/*********************************************************************************************************************************************************************/
		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado una nueva secuencia de facturación con el prefijo: $prefijo y rangos desde $rango_inicial a $rango_final";
		$modulo = "Secuencia Facturación";
		$insert = "INSERT INTO historial
		   VALUES('$historial_numero','0','0','$modulo','$correlativo','0','0','$fecha','$estado_historial','$observacion_historial','$usuario','$fecha_registro')";
		$mysqli->query($insert) or die($mysqli->error);
		/*******************************************************************************************************************************************************************/
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