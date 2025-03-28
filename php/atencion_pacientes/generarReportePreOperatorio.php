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

$queryPreoperatorio = "SELECT CONCAT(c.nombre, ' ',c.apellido) AS 'profesional', CONCAT(p.nombre, ' ',p.apellido) AS 'cliente', p.fecha_nacimiento AS 'fecha_nacimiento', p.email AS 'email', p.telefono1 AS 'telefono', pre.*, 		(CASE WHEN pre.psquiatria = '1' THEN 'Sí' ELSE 'No' END) AS 'psquiatria_visto', (CASE WHEN pre.psicologia = '1' THEN 'Sí' ELSE 'No' END) AS 'psicologia_visto', (CASE WHEN pre.nutricion = '1' THEN 'Sí' ELSE 'No' END) AS 'nutricion_visto', (CASE WHEN pre.medicina_interna = '1' THEN 'Sí' ELSE 'No' END) AS 'medicina_interna_visto', s.nombre AS 'servicio'
	FROM preoperacion AS pre
	INNER JOIN pacientes AS p
	ON pre.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON pre.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON pre.servicio_id = s.servicio_id
	WHERE pre.pacientes_id = '$pacientes_id'";	
$resultPreoperatorio = $mysqli->query($queryPreoperatorio) or die($mysqli->error);

if($resultPreoperatorio->num_rows>0){
	$consultaPreoperatorio = $resultPreoperatorio->fetch_assoc();
	
	//OBTENER LA EDAD DEL USUARIO 
	/*********************************************************************************/
	$valores_array = getEdad($consultaPreoperatorio['fecha_nacimiento']);
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
	include(dirname('__FILE__').'/reportePreOperatorio.php');
	$html = ob_get_clean();

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	
	$dompdf->set_option('isRemoteEnabled', true);

	$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('letter', 'portrait');
	// Render the HTML as PDF
	$dompdf->render();
	file_put_contents(dirname('__FILE__').'/Reportes/hc_preoperacion_'.$noAtencion.'.pdf', $dompdf->output());
	
	// Output the generated PDF to Browser
	$dompdf->stream('reporte_'.$noAtencion.'.pdf',array('Attachment'=>0));
	
	exit;	
}
?>