<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];

//CONSULTAR ARCHIVOS
$query_archivos = "SELECT cd.file_name
	FROM clinico_detalles AS cd
	INNER JOIN clinico AS c
	ON cd.clinico_id = c.clinico_id
	WHERE c.pacientes_id = $pacientes_id";
$result_archivos = $mysqli->query($query_archivos) or die($mysqli->error);

$datos_archivos = "
	<div class='form-row'>
		<div class='col-md-12 mb-6 sm-3'>
		<p style='color: #077A2F;' align='center'><b>Archivos</b></p>
		</div>					
	</div>
";
if($result_archivos->num_rows>0){
	while($consulta2 = $result_archivos->fetch_assoc()){
		$file_name = $consulta2['file_name'];
		$path = "../upload/".$file_name;
		
		$datos_archivos .= "
			<div class='alert alert-primary' role='alert'>
				<a target='_BLANK' href='".$path."' class='alert-link'>".$file_name."</a>
				</div>
		";
	}
}else{
	$datos_archivos = "
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #FF0000;' align='center'><b>No hay datos que mostrar</b></p>
			</div>			
		</div>			
	";
}
	
echo $datos_archivos;
?>