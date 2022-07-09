<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

$postoperacion_id = $_POST['postoperacion_id'];

$query = "SELECT pacientes_id
	FROM postoperacion
	WHERE postoperacion_id = '$postoperacion_id'";
$result = $mysqli->query($query) or die($mysqli->error);

$pacientes_id = '';

if($result->num_rows>0){
    $consulta_registro = $result->fetch_assoc();
	$pacientes_id = $consulta_registro['pacientes_id'];
}

echo $pacientes_id;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>