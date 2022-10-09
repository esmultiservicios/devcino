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

$queryAtencion = "SELECT a.alimentos_id AS 'alimentos_id', CONCAT(c.nombre, ' ', c.apellido) AS 'profesional', a.pacientes_id AS 'pacientes_id', CONCAT(p.nombre, ' ', p.apellido) AS 'cliente', DATE_FORMAT(a.fecha, '%d/%m/%Y') AS 'fecha',
	(CASE WHEN a.cafe = '1' THEN 'Sí' ELSE 'No' END) AS 'cafe',
	(CASE WHEN a.tes = '1' THEN 'Sí' ELSE 'No' END) AS 'tes',
	(CASE WHEN a.leche = '1' THEN 'Sí' ELSE 'No' END) AS 'leche',
	(CASE WHEN a.yogurt = '1' THEN 'Sí' ELSE 'No' END) AS 'yogurt',
	(CASE WHEN a.requeson = '1' THEN 'Sí' ELSE 'No' END) AS 'requeson',
	(CASE WHEN a.cuajada = '1' THEN 'Sí' ELSE 'No' END) AS 'cuajada',
	(CASE WHEN a.queso_fresco = '1' THEN 'Sí' ELSE 'No' END) AS 'queso_fresco',
	(CASE WHEN a.queso_crema = '1' THEN 'Sí' ELSE 'No' END) AS 'queso_crema',
	(CASE WHEN a.mermeladas = '1' THEN 'Sí' ELSE 'No' END) AS 'mermeladas',
	(CASE WHEN a.mantequilla_mani = '1' THEN 'Sí' ELSE 'No' END) AS 'mantequilla_mani',
	(CASE WHEN a.pan_molde = '1' THEN 'Sí' ELSE 'No' END) AS 'pan_molde',
	(CASE WHEN a.pan_baguete = '1' THEN 'Sí' ELSE 'No' END) AS 'pan_baguete',
	(CASE WHEN a.bagels = '1' THEN 'Sí' ELSE 'No' END) AS 'bagels',
	(CASE WHEN a.pancakes = '1' THEN 'Sí' ELSE 'No' END) AS 'pancakes',
	(CASE WHEN a.avena = '1' THEN 'Sí' ELSE 'No' END) AS 'avena',
	(CASE WHEN a.cereal = '1' THEN 'Sí' ELSE 'No' END) AS 'cereal',
	(CASE WHEN a.tortilla_maiz = '1' THEN 'Sí' ELSE 'No' END) AS 'tortilla_maiz',
	(CASE WHEN a.tortilla_harina = '1' THEN 'Sí' ELSE 'No' END) AS 'tortilla_harina',
	(CASE WHEN a.arroz = '1' THEN 'Sí' ELSE 'No' END) AS 'arroz',
	(CASE WHEN a.papa = '1' THEN 'Sí' ELSE 'No' END) AS 'papa',
	(CASE WHEN a.camote = '1' THEN 'Sí' ELSE 'No' END) AS 'camote',
	(CASE WHEN a.pastas = '1' THEN 'Sí' ELSE 'No' END) AS 'pastas',
	(CASE WHEN a.quinoa = '1' THEN 'Sí' ELSE 'No' END) AS 'quinoa',
	(CASE WHEN a.garbanzos = '1' THEN 'Sí' ELSE 'No' END) AS 'garbanzos',
	(CASE WHEN a.lentejas = '1' THEN 'Sí' ELSE 'No' END) AS 'lentejas',
	(CASE WHEN a.frijoles = '1' THEN 'Sí' ELSE 'No' END) AS 'frijoles',
	(CASE WHEN a.aguacate = '1' THEN 'Sí' ELSE 'No' END) AS 'aguacate',
	(CASE WHEN a.platano_maduro = '1' THEN 'Sí' ELSE 'No' END) AS 'platano_maduro',
	(CASE WHEN a.banano_verde = '1' THEN 'Sí' ELSE 'No' END) AS 'banano_verde',
	(CASE WHEN a.huevos = '1' THEN 'Sí' ELSE 'No' END) AS 'huevos',
	(CASE WHEN a.jamon = '1' THEN 'Sí' ELSE 'No' END) AS 'jamon',
	(CASE WHEN a.pollo = '1' THEN 'Sí' ELSE 'No' END) AS 'pollo',
	(CASE WHEN a.res = '1' THEN 'Sí' ELSE 'No' END) AS 'res',
	(CASE WHEN a.lomo_cerdo = '1' THEN 'Sí' ELSE 'No' END) AS 'lomo_cerdo',
	(CASE WHEN a.filete_pescado = '1' THEN 'Sí' ELSE 'No' END) AS 'filete_pescado',
	(CASE WHEN a.atun = '1' THEN 'Sí' ELSE 'No' END) AS 'atun',
	(CASE WHEN a.sardinas = '1' THEN 'Sí' ELSE 'No' END) AS 'sardinas',
	(CASE WHEN a.camarones = '1' THEN 'Sí' ELSE 'No' END) AS 'camarones',
	a.vegetales AS 'vegetales', a.frutas AS 'frutas', a.desayuno AS 'desayuno', a.merienda1 AS 'merienda1', a.almuerzo AS 'almuerzo', a.merienda2 AS 'merienda2', a.cena AS 'cena', a.fecha_registro AS 'fecha_registro'
	FROM alimentos AS a
	INNER JOIN pacientes AS p
	ON a.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON a.colaborador_id = c.colaborador_id	
	WHERE a.pacientes_id = '$pacientes_id'";	
$resultAtencion = $mysqli->query($queryAtencion) or die($mysqli->error);

if($resultAtencion->num_rows>0){
	$consultaAtencion = $resultAtencion->fetch_assoc();

	$image_server = SERVERURL."img/fondo_pagina.jpg";
	ob_start();
	include(dirname('__FILE__').'/reporteComida.php');
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