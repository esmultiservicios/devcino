<?php
session_start();   
include "../funtions.php";

header("Content-Type: text/html;charset=utf-8");

require_once '../../dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
		
//CONEXION A DB
$mysqli = connect_mysqli();

date_default_timezone_set('America/Tegucigalpa');

$pacientes_id = $_GET['pacientes_id'];
$noAtencion = 1;
$anulada = '';

$queryPostOperatorio = "SELECT CONCAT(c.nombre, ' ',c.apellido) AS 'profesional', CONCAT(p.nombre, ' ',p.apellido) AS 'cliente', p.fecha_nacimiento AS 'fecha_nacimiento', p.email AS 'email', p.telefono1 AS 'telefono', po.*, s.nombre AS 'servicio'
	FROM postoperacion AS po
	INNER JOIN pacientes AS p
	ON po.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON po.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON po.servicio_id = s.servicio_id
	WHERE po.pacientes_id = '$pacientes_id'";	
$resultPostOperatorio = $mysqli->query($queryPostOperatorio) or die($mysqli->error);

if($resultPostOperatorio->num_rows>0){	
	$consultaPostOperatorio = $resultPostOperatorio->fetch_assoc();
	//OBTENER LA EDAD DEL USUARIO 
	/*********************************************************************************/
	$valores_array = getEdad($consultaPostOperatorio['fecha_nacimiento']);
	$anos = $valores_array['anos'];
	$meses = $valores_array['meses'];	  
	$dias = $valores_array['dias'];	

	if ($anos>1 ){
	$palabra_anos = "Años";
	}else{
	$palabra_anos = "Año";
	}

	if ($meses>1 ){
	$palabra_mes = "Meses";
	}else{
	$palabra_mes = "Mes";
	}

	if($dias>1){
		$palabra_dia = "Días";
	}else{
		$palabra_dia = "Día";
	}		
	
	/*********************************************************************************/

	$image_server = SERVERURL."img/fondo_pagina.jpg";
	ob_start();
	include(dirname('__FILE__').'/reportePostOperatorio.php');
	$html = ob_get_clean();

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	
	$dompdf->set_option('isRemoteEnabled', true);

	$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('letter', 'portrait');
	// Render the HTML as PDF
	$dompdf->render();
	file_put_contents(dirname('__FILE__').'/Reportes/hc_poroperatorio_'.$noAtencion.'.pdf', $dompdf->output());
	
	// Output the generated PDF to Browser
	$dompdf->stream('reporte_'.$noAtencion.'.pdf',array('Attachment'=>0));
	
	exit;	
}
?>