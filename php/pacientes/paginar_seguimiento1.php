<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$paginaActual = $_POST['partida'];
	
$where = "WHERE pacientes_id = '$pacientes_id'";

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
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.('1,'.$pacientes_id).');void(0);">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual.'-1,'.$pacientes_id).');void(0);">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual.'+1,'.$pacientes_id).');void(0);">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<liclass="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($nroPaginas.','.$pacientes_id).');void(0);">Ultima</a></li>';
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
			<th width="2.26%">No.</th>
			<th width="8.26%">Fecha</th>
			<th width="5.26%">Peso HAB</th>
			<th width="5.26%">Peso</th>
			<th width="5.26%">Estatura</th>				
			<th width="5.26%">Cintura</th>		
			<th width="5.26%">Cadera</th>
			<th width="5.26%">Indice CC</th>
			<th width="5.26%">Brazo</th>				
			<th width="5.26%">IMC</th>
			<th width="5.26%">MSJ</th>
			<th width="5.26%">PA</th>
			<th width="5.26%">Impedancia G</th>				
			<th width="5.26%">Impedancia M</th>				
			<th width="5.26%">Impedancia GV</th>
			<th width="5.26%">Sedentario</th>
			<th width="5.26%">Act Moderado</th>
			<th width="5.26%">Act Viugorosa</th>
			<th width="5.26%">Alimentacion G</th>				
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
				<td>'.$registro2['g'].'</td>					
				<td>'.$registro2['m'].'</td>
				<td>'.$registro2['gv'].'</td>			
				<td>'.$registro2['sedentario'].'</td>
				<td>'.$registro2['act_moderada'].'</td>
				<td>'.$registro2['act_vigorosa'].'</td>	
				<td>'.$registro2['alimentacion'].'</td>				
			</tr>';	
			$i++;				
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="19" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="19"><b><p ALIGN="center">Total de Registros Encontrados: '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>