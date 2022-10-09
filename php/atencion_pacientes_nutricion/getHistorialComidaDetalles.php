<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();
$pacientes_id = $_POST['pacientes_id'];

//CONSULTAR FECHA
$consulta = "SELECT a.alimentos_id AS 'alimentos_id', CONCAT(c.nombre, ' ', c.apellido) AS 'profesional', a.pacientes_id AS 'pacientes_id', CONCAT(p.nombre, ' ', p.apellido) AS 'cliente', DATE_FORMAT(a.fecha, '%d/%m/%Y') AS 'fecha',
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
$result = $mysqli->query($consulta) or die($mysqli->error);

$tabla = '';

while($consultaAtencion = $result->fetch_assoc()){
	$tabla = $tabla.'
		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Paciente: </b>'.$consultaAtencion['cliente'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Registro#: </b>'.$consultaAtencion['alimentos_id'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Fecha: </b>'.$consultaAtencion['fecha'].'
			</div>								
		</div>

		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Café: </b>'.$consultaAtencion['cafe'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Lomo de Cerdo: </b>'.$consultaAtencion['lomo_cerdo'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Desayuno: </b>'.$consultaAtencion['desayuno'].'
			</div>								
		</div>

		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Tes: </b>'.$consultaAtencion['tes'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Filete de Pescado: </b>'.$consultaAtencion['filete_pescado'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Merienda: </b>'.$consultaAtencion['merienda1'].'
			</div>								
		</div>	
		
		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Leche: </b>'.$consultaAtencion['leche'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Atun: </b>'.$consultaAtencion['atun'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Almuerzo: </b>'.$consultaAtencion['almuerzo'].'
			</div>								
		</div>	
		
		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Yogurt: </b>'.$consultaAtencion['yogurt'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Sardinas: </b>'.$consultaAtencion['sardinas'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Merienda: </b>'.$consultaAtencion['merienda2'].'
			</div>								
		</div>	
		
		<div class="form-row">
			<div class="col-md-3 mb-3">
				<b>Requeson: </b>'.$consultaAtencion['requeson'].'
			</div>
			<div class="col-md-3 mb-3">
				<b>Camarones: </b>'.$consultaAtencion['camarones'].'
			</div>	
			<div class="col-md-4 mb-3">
				<b>Cena: </b>'.$consultaAtencion['cena'].'
			</div>								
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Cuajada: </b>'.$consultaAtencion['cuajada'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Queso Fresco: </b>'.$consultaAtencion['queso_fresco'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Queso Crema: </b>'.$consultaAtencion['queso_crema'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Mermeladas: </b>'.$consultaAtencion['mermeladas'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Mantequilla de mani: </b>'.$consultaAtencion['mantequilla_mani'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Pan Molde: </b>'.$consultaAtencion['pan_molde'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Pan Baguette: </b>'.$consultaAtencion['pan_baguete'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<b>Bagels: </b>'.$consultaAtencion['bagels'].'
			</div>		
			<div class="col-md-6 mb-6">
				<b>Vegetales: </b>'.$consultaAtencion['vegetales'].'
			</div>										
		</div>	
		
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<b>Pancakes: </b>'.$consultaAtencion['pancakes'].'
			</div>		
			<div class="col-md-6 mb-6">
				<b>Frutas: </b>'.$consultaAtencion['frutas'].'
			</div>										
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Avena: </b>'.$consultaAtencion['avena'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Cereal de desayuno: </b>'.$consultaAtencion['cereal'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Tortilla de maiz: </b>'.$consultaAtencion['tortilla_maiz'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Tortilla de harina: </b>'.$consultaAtencion['tortilla_harina'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Arroz: </b>'.$consultaAtencion['arroz'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Papa: </b>'.$consultaAtencion['papa'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Camote: </b>'.$consultaAtencion['camote'].'
			</div>							
		</div>		
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Pastas (macarrones, spaguettis, etc): </b>'.$consultaAtencion['pastas'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Quinoa: </b>'.$consultaAtencion['quinoa'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Garbanzos: </b>'.$consultaAtencion['garbanzos'].'
			</div>							
		</div>
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Lentejas: </b>'.$consultaAtencion['lentejas'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Frijoles: </b>'.$consultaAtencion['frijoles'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Aguacate: </b>'.$consultaAtencion['aguacate'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Platano maduro: </b>'.$consultaAtencion['platano_maduro'].'
			</div>							
		</div>	
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Banano verde: </b>'.$consultaAtencion['banano_verde'].'
			</div>							
		</div>			
		
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Huevos: </b>'.$consultaAtencion['huevos'].'
			</div>							
		</div>				

		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Jamon: </b>'.$consultaAtencion['jamon'].'
			</div>							
		</div>				

		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Pollo: </b>'.$consultaAtencion['pollo'].'
			</div>							
		</div>				

		<div class="form-row">
			<div class="col-md-12 mb-12">
				<b>Res: </b>'.$consultaAtencion['res'].'
			</div>							
		</div>				
	';
}
	
echo $tabla;
?>