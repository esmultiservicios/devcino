<?php
session_start();   
include "../funtions.php";

header("Content-Type: text/html;charset=utf-8");

include_once "../../dompdf/autoload.inc.php";
require_once '../../pdf/vendor/autoload.php';

use Dompdf\Dompdf;
		
//CONEXION A DB
$mysqli = connect_mysqli();

date_default_timezone_set('America/Tegucigalpa');

$pacientes_id = $_GET['pacientes_id'];
$noAtencion = 1;
$anulada = '';

$queryAtencion = "SELECT CONCAT(co.nombre, ' ',co.apellido) AS 'profesional', CONCAT(p.nombre, ' ',p.apellido) AS 'cliente', p.fecha_nacimiento AS 'fecha_nacimiento', p.email AS 'email', p.telefono1 AS 'telefono', c.*, s.nombre AS 'servicio'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS co
	ON c.colaborador_id = co.colaborador_id
	INNER JOIN servicios AS s
	ON c.servicio_id = s.servicio_id	
	WHERE c.pacientes_id = '$pacientes_id'";	
$resultAtencion = $mysqli->query($queryAtencion) or die($mysqli->error);

if($resultAtencion->num_rows>0){
	$consultaAtencion = $resultAtencion->fetch_assoc();
	
	//OBTENER LA EDAD DEL USUARIO 
	/*********************************************************************************/
	$valores_array = getEdad($consultaAtencion['fecha_nacimiento']);
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
	include(dirname('__FILE__').'/reporteAtencion.php');
	$html = ob_get_clean();

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	
	$dompdf->set_option('isRemoteEnabled', true);

	$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('letter', 'portrait');
	// Render the HTML as PDF
	$dompdf->render();
	file_put_contents(dirname('__FILE__').'/Reportes/atencion_'.$noAtencion.'.pdf', $dompdf->output());
	
	// Output the generated PDF to Browser
	$dompdf->stream('reporte_'.$noAtencion.'.pdf',array('Attachment'=>0));
	
	exit;	
}
?>