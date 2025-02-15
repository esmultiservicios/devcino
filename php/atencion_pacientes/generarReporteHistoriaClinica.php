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

$queryHistoriaClinica = "SELECT  CONCAT(co.nombre, ' ',co.apellido) AS 'profesional', CONCAT(p.nombre, ' ',p.apellido) AS 'cliente', p.fecha_nacimiento AS 'fecha_nacimiento', p.email AS 'email', p.telefono1 AS 'telefono', c.*, s.nombre AS 'servicio'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS co
	ON c.colaborador_id = co.colaborador_id
	INNER JOIN servicios AS s
	ON c.servicio_id = s.servicio_id		
	WHERE c.pacientes_id = '$pacientes_id'";	
$resultHistoriaClinica = $mysqli->query($queryHistoriaClinica) or die($mysqli->error);

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

$queryNotaOperatoria = "SELECT CONCAT(c.nombre, ' ',c.apellido) AS 'profesional', CONCAT(p.nombre, ' ',p.apellido) AS 'cliente', p.fecha_nacimiento AS 'fecha_nacimiento', p.email AS 'email', p.telefono1 AS 'telefono', no.*, (CASE WHEN no.prueba = '1' THEN 'Sí' ELSE 'No' END) AS 'resultado_prueba', (CASE WHEN no.blake = '1' THEN 'Sí' ELSE 'No' END) AS 'resultado_blake', (CASE WHEN no.extraccion = '1' THEN 'Sí' ELSE 'No' END) AS 'resultado_extraccion', (CASE WHEN no.evacuo = '1' THEN 'Sí' ELSE 'No' END) AS 'resultado_evacuo', (CASE WHEN no.cierro = '1' THEN 'Sí' ELSE 'No' END) AS 'resultado_cierro', s.nombre AS 'servicio'
	FROM notaoperacion AS no
	INNER JOIN pacientes AS p
	ON no.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON no.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON no.servicio_id = s.servicio_id
	WHERE no.pacientes_id = '$pacientes_id'";	
$resultNotaOperatoria = $mysqli->query($queryNotaOperatoria) or die($mysqli->error);

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

if($resultHistoriaClinica->num_rows>0){
	$consultaHistoriaClinica = $resultHistoriaClinica->fetch_assoc();
	
	//OBTENER LA EDAD DEL USUARIO 
	/*********************************************************************************/
	$valores_array = getEdad($consultaHistoriaClinica['fecha_nacimiento']);
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
	include(dirname('__FILE__').'/reporteHistoriaClinica.php');
	$html = ob_get_clean();

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	
	$dompdf->set_option('isRemoteEnabled', true);

	$dompdf->loadHtml(utf8_decode(utf8_encode($html)));
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('letter', 'portrait');
	// Render the HTML as PDF
	$dompdf->render();
	file_put_contents(dirname('__FILE__').'/Reportes/atencion_hc_'.$noAtencion.'.pdf', $dompdf->output());
	
	// Output the generated PDF to Browser
	$dompdf->stream('reporte_'.$noAtencion.'.pdf',array('Attachment'=>0));
	
	exit;	
}
?>