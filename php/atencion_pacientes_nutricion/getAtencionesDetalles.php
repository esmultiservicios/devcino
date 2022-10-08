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

$sql_peso = "SELECT peso
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_peso = $mysqli->query($sql_peso) or die($mysqli->error);

$sql_estatura = "SELECT estatura
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_estatura = $mysqli->query($sql_estatura) or die($mysqli->error);

$sql_cintura = "SELECT cintura
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_cintura = $mysqli->query($sql_cintura) or die($mysqli->error);

$sql_cadera = "SELECT cadera
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_cadera = $mysqli->query($sql_cadera) or die($mysqli->error);

$sql_indice_cc = "SELECT indice_cc
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_indice_cc = $mysqli->query($sql_indice_cc) or die($mysqli->error);

$sql_brazo = "SELECT brazo
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_brazo = $mysqli->query($sql_brazo) or die($mysqli->error);

$sql_imc = "SELECT imc
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_imc = $mysqli->query($sql_imc) or die($mysqli->error);

$sql_msj = "SELECT msj
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_msj = $mysqli->query($sql_msj) or die($mysqli->error);

$sql_pa = "SELECT pa
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_pa = $mysqli->query($sql_pa) or die($mysqli->error);

$sql_g = "SELECT g
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_g = $mysqli->query($sql_g) or die($mysqli->error);

$sql_m = "SELECT m
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_m = $mysqli->query($sql_m) or die($mysqli->error);

$sql_gv = "SELECT gv
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_gv = $mysqli->query($sql_gv) or die($mysqli->error);

$sql_sedentario = "SELECT sedentario
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_sedentario = $mysqli->query($sql_sedentario) or die($mysqli->error);

$sql_act_moderada = "SELECT act_moderada
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_act_moderada = $mysqli->query($sql_act_moderada) or die($mysqli->error);

$sql_act_vigorosa = "SELECT act_vigorosa
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_act_vigorosa = $mysqli->query($sql_act_vigorosa) or die($mysqli->error);

$sql_alimentacion = "SELECT alimentacion
	FROM atenciones_nutricion_detalles
	WHERE pacientes_id = '$pacientes_id'"; 
$result_alimentacion = $mysqli->query($sql_alimentacion) or die($mysqli->error);

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
				<td>Peso</td>
			';
			while($consulta_peso = $result_peso->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_peso['peso'].'</td>
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
				<td>Indice CC</td>
			';
			while($consulta_indice_cc = $result_indice_cc->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_indice_cc['indice_cc'].'</td>
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
				<td>Impendancia G</td>
			';
			while($consulta_g = $result_g->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_g['g'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
		
		<tr>';
			$tabla = $tabla.'
				<td>Impedancia M</td>
			';
			while($consulta_m = $result_m->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_m['m'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Impedancia GV</td>
			';
			while($consulta_gv = $result_gv->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_gv['gv'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Sedentario</td>
			';
			while($consulta_sedentario = $result_sedentario->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_sedentario['sedentario'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Act Moderada</td>
			';
			while($consulta_act_moderada = $result_act_moderada->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_act_moderada['act_moderada'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>
		
		<tr>';
			$tabla = $tabla.'
				<td>Act Vigorosa</td>
			';
			while($consulta_act_vigorosa = $result_act_vigorosa->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_act_vigorosa['act_vigorosa'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>		
		
		<tr>';
			$tabla = $tabla.'
				<td>Alimentación</td>
			';
			while($consulta_alimentacion = $result_alimentacion->fetch_assoc()){
				$tabla = $tabla.'
					<td>'.$consulta_alimentacion['alimentacion'].'</td>
				';
			}			
			$tabla = $tabla.'
		<tr>	
	</table>';
	
echo $tabla;
?>