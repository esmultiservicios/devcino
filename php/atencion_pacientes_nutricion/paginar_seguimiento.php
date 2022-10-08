<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$paginaActual = $_POST['partida'];
	
$where = "WHERE colaborador_id = '$colaborador_id' AND pacientes_id = '$pacientes_id'";

$query = "SELECT *
	FROM atenciones_nutricion_detalles
	".$where."
	ORDER BY fecha_registro DESC";

$result = $mysqli->query($query) or die($mysqli->error);

$nroLotes = 10;
$nroProductos = $result->num_rows;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.(1).');void(0);">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual-1).');void(0);">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual+1).');void(0);">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<liclass="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($nroPaginas).');void(0);">Ultima</a></li>';
}

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$registro = "SELECT *
	FROM atenciones_nutricion_detalles
	".$where."
	ORDER BY fecha_registro DESC
	LIMIT $limit, $nroLotes";
$result = $mysqli->query($registro) or die($mysqli->error);


$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			<tr>
			<th width="7.69%">No.</th>
			<th width="7.69%">Fecha</th>
			<th width="7.69%">Peso HAB</th>
			<th width="7.69%">Peso</th>
			<th width="7.69%">Estatura/th>
			<th width="7.69%">Cintura</th>
			<th width="7.69%">Cadera</th>	
			<th width="7.69%">Indice CC</th>
			<th width="7.69%">Brazo</th>
			<th width="7.69%">IMC</th>			
			<th width="7.69%">MSJ</th>			
			<th width="7.69%">PA</th>
			<th width="7.69%">Alimentación</th>				
			</tr>';
$i = 1;				
while($registro2 = $result->fetch_assoc()){  
	$tabla = $tabla.'<tr>
			<td>'.$i.'</td> 		         		
			<td>'.$registro2['fecha'].'</td>
			<td>'.$registro2['peso_hab'].'</td>
			<td>'.$registro2['peso'].'</td>
			<td>'.$registro2['estatura'].'</td>
			<td>'.$registro2['cintura'].'</td>
			<td>'.$registro2['cadera'].'</td>
			<td>'.$registro2['indice_cc'].'</td>
			<td>'.$registro2['brazo'].'</td>
			<td>'.$registro2['imc'].'</td>			
			<td>'.$registro2['msj'].'</td>
			<td>'.$registro2['pa'].'</td>
			<td>'.$registro2['alimentacion'].'</td>			
			</tr>';	
			$i++;				
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="13" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="13"><b><p ALIGN="center">Total de Registros Encontrados: '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>