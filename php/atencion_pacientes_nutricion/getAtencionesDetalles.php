<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();
$pacientes_id = $_POST['pacientes_id'];

//CONSULTAR FECHA
$sql_fecha = "SELECT DATE_FORMAT(CAST(fecha AS DATE ), '%d/%m/%Y') AS 'fecha'
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_fecha = $mysqli->query($sql_fecha) or die($mysqli->error);

$sql_peso_hab = "SELECT peso_hab
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_peso_hab = $mysqli->query($sql_peso_hab) or die($mysqli->error);

$sql_peso_activo = "SELECT peso_activo
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_peso_activo = $mysqli->query($sql_peso_activo) or die($mysqli->error);

$sql_talla = "SELECT talla
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'";  
$result_talla = $mysqli->query($sql_talla) or die($mysqli->error);

$sql_imc = "SELECT imc
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_imc = $mysqli->query($sql_imc) or die($mysqli->error);

$sql_peso_p25 = "SELECT peso_p25
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_peso_p25 = $mysqli->query($sql_peso_p25) or die($mysqli->error);

$sql_abdomen = "SELECT abdomen
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_abdomen = $mysqli->query($sql_abdomen) or die($mysqli->error);

$sql_brazo = "SELECT brazo
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_brazo = $mysqli->query($sql_brazo) or die($mysqli->error);

$sql_muneca = "SELECT muneca
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_muneca = $mysqli->query($sql_muneca) or die($mysqli->error);

$sql_msj = "SELECT msj
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_msj = $mysqli->query($sql_msj) or die($mysqli->error);

$sql_riesgo_vascular = "SELECT riesgo_vascular
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_riesgo_vascular = $mysqli->query($sql_riesgo_vascular) or die($mysqli->error);

$sql_porcentaje_grasa = "SELECT porcentaje_grasa
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_porcentaje_grasa = $mysqli->query($sql_porcentaje_grasa) or die($mysqli->error);

$sql_tipo_dieta = "SELECT tipo_dieta
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_tipo_dieta = $mysqli->query($sql_tipo_dieta) or die($mysqli->error);

$sql_pa = "SELECT pa
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_pa = $mysqli->query($sql_pa) or die($mysqli->error);

$sql_cintura = "SELECT cintura
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_cintura = $mysqli->query($sql_cintura) or die($mysqli->error);

$sql_cadera = "SELECT cadera
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_cadera = $mysqli->query($sql_cadera) or die($mysqli->error);

$sql_estatura = "SELECT estatura
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_estatura = $mysqli->query($sql_estatura) or die($mysqli->error);

$sql_indice_cc = "SELECT indice_cc
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_indice_cc = $mysqli->query($sql_indice_cc) or die($mysqli->error);

$tabla = '';

$tabla = $tabla.'
	<table class="table table-striped table-condensed table-hover">
		<tr>';
			$tabla = $tabla.'
				<td><b>Fecha</b></td>
			';
			while($consulta_fecha = $result_fecha->fetch_assoc()){
				$tabla = $tabla.'
					<td><b>'.$consulta_fecha['fecha'].'</b></td>
				';
			}			
			$tabla = $tabla.'
		<tr>

		<tr>';
			$tabla = $tabla.'
				<td>Peso Hab</td>
			';
			while($consulta_peso_hab = $result_peso_hab->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_peso_hab['peso_hab'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>Peso Act</td>
			';
			while($consulta_peso_activo = $result_peso_activo->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_peso_activo['peso_activo'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>Talla</td>
			';
			while($consulta_talla = $result_talla->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_talla['talla'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>IMC</td>
			';
			while($consulta_imc = $result_imc->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_imc['imc'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>Peso P25</td>
			';
			while($consulta_peso_p25 = $result_peso_p25->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_peso_p25['peso_p25'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Abdomen</td>
			';
			while($consulta_abdomen = $result_abdomen->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_abdomen['abdomen'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Brazo</td>
			';
			while($consulta_brazo = $result_brazo->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_brazo['brazo'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Muñeca</td>
			';
			while($consulta_muneca = $result_muneca->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_muneca['muneca'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>MSJ</td>
			';
			while($consulta_msj = $result_msj->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_msj['msj'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Riesgo Cardiovascular</td>
			';
			while($consulta_riesgo_vascular = $result_riesgo_vascular->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_riesgo_vascular['riesgo_vascular'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>% Grasa</td>
			';
			while($consulta_porcentaje_grasa = $result_porcentaje_grasa->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_porcentaje_grasa['porcentaje_grasa'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>Tipo Dieta</td>
			';
			while($consulta_tipo_dieta = $result_tipo_dieta->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_tipo_dieta['tipo_dieta'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>PA</td>
			';
			while($consulta_pa = $result_pa->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_pa['pa'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Cintura</td>
			';
			while($consulta_cintura = $result_cintura->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_cintura['cintura'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Cadera</td>
			';
			while($consulta_cadera = $result_cadera->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_cadera['cadera'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Estatura</td>
			';
			while($consulta_estatura = $result_estatura->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_estatura['estatura'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Indice CC</td>
			';
			while($consulta_indice_cc = $result_indice_cc->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_indice_cc['indice_cc'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>		
	</table>';
	
echo $tabla;
?>