<?php 
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$colaborador_id = $_SESSION['colaborador_id'];
$paginaActual = $_POST['partida'];
$dato = $_POST['dato'];

$where = "WHERE CONCAT(p.nombre,' ',p.apellido) LIKE '%$dato%' OR p.apellido LIKE '$dato%' OR p.identidad LIKE '$dato%'";

$query = "SELECT p.pacientes_id AS 'pacientes_id', p.identidad AS 'identidad', CONCAT(p.nombre, ' ', p.apellido) AS 'cliente', p.telefono1 AS 'telefono',
(CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', p.fecha_nacimiento AS 'fecha_nacimiento', p.localidad AS 'localidad'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	".$where."
	GROUP BY c.pacientes_id";

$result = $mysqli->query($query) or die($mysqli->error);

$nroLotes = 25;
$nroProductos = $result->num_rows;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.(1).');void(0);">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual-1).');void(0);">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual+1).');void(0);">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($nroPaginas).');void(0);">Ultima</a></li>';
}

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$registro = "SELECT p.pacientes_id AS 'pacientes_id', p.identidad AS 'identidad', CONCAT(p.nombre, ' ', p.apellido) AS 'cliente', p.telefono1 AS 'telefono',
(CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', p.fecha_nacimiento AS 'fecha_nacimiento', p.localidad AS 'localidad'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	".$where."
	GROUP BY c.pacientes_id
	LIMIT $limit, $nroLotes";
$result = $mysqli->query($registro) or die($mysqli->error);


$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			<tr>
			<th width="2.28%">Ver</th>
			<th width="14.28">Identidad</th>
			<th width="27.28%">Paciente</th>				
			<th width="6.28%">Genero</th>
			<th width="6.28%">Teléfono</th>
			<th width="12.28%">Fecha de Nacimiento</th>
			<th width="27.28%">Dirección</th>
			</tr>';
$i = 1;				
while($registro2 = $result->fetch_assoc()){		  
  $telefonousuario = '<a style="text-decoration:none" title = "Teléfono Usuario" href="tel:9'.$registro2['telefono'].'">'.$registro2['telefono'].'</a>';     
  
	$tabla = $tabla.'<tr>
			<td>
				<a style="text-decoration:none;" data-toggle="tooltip" data-placement="right" title="Ver Expediente" href="javascript:viewExpediente('.$registro2['pacientes_id'].');void(0);" class="far fa-eye fa-lg"></a> 
			</td>
			<td>'.$registro2['identidad'].'</td>	
			<td>'.$registro2['cliente'].'</td>	
			<td>'.$registro2['genero'].'</td>
			<td>'.$telefonousuario.'</td>
			<td>'.$registro2['fecha_nacimiento'].'</td>			
			<td>'.$registro2['localidad'].'</td>	
			</tr>';	
			$i++;				
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="12" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="12"><b><p ALIGN="center">Total de Registros Encontrados: '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>