<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli(); 

$colaborador_id = $_SESSION['colaborador_id'];
$paginaActual = $_POST['partida'];

$paginaActual = $_POST['partida'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$dato = $_POST['dato'];	
$colaborador = $_POST['colaborador'];

$colaborador_where = "";
$dato_where = "";

if($colaborador != ""){
	$where = "WHERE c.fecha BETWEEN '$desde' AND '$hasta' AND c.colaborador_id = '$profesional'";
}else if($dato != ""){
	$where = "WHERE CONCAT(p.nombre,' ',p.apellido) LIKE '%$dato%' OR p.apellido LIKE '$dato%' OR p.identidad LIKE '$dato%'";
}else{
	$where = "WHERE c.fecha BETWEEN '$desde' AND '$hasta'";
}

$query = "SELECT c.clinico_id AS 'clinico_id',  DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', CONCAT(p.nombre,' ',p.apellido) AS 'paciente', p.identidad AS 'identidad', CONCAT(co.nombre,' ',co.apellido) AS 'colaborador', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'sexo',
(CASE WHEN c.paciente = 'N' THEN 'N' ELSE 'S' END) AS 'paciente_tipo', c.inicio_obesidad AS 'inicio_obesidad', c.habito_alimenticio AS 'habito_alimenticio'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS co
	ON c.colaborador_id = co.colaborador_id
	INNER JOIN servicios AS s
	ON c.servicio_id = s.servicio_id
	".$where."
    ORDER BY c.fecha DESC";	

$result = $mysqli->query($query);
$nroProductos = $result->num_rows;
  
$nroLotes = 15;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.(1).');">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual-1).');">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual+1).');">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($nroPaginas).');">Ultima</a></li>';
}	

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$registro = "SELECT c.clinico_id AS 'clinico_id',  DATE_FORMAT(c.fecha, '%d/%m/%Y') AS 'fecha', CONCAT(p.nombre,' ',p.apellido) AS 'paciente', p.identidad AS 'identidad', CONCAT(co.nombre,' ',co.apellido) AS 'colaborador', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'sexo',
(CASE WHEN c.paciente = 'N' THEN 'N' ELSE 'S' END) AS 'paciente_tipo', c.inicio_obesidad AS 'inicio_obesidad', c.habito_alimenticio AS 'habito_alimenticio'
	FROM clinico AS c
	INNER JOIN pacientes AS p
	ON c.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS co
	ON c.colaborador_id = co.colaborador_id
	INNER JOIN servicios AS s
	ON c.servicio_id = s.servicio_id
	".$where."
    ORDER BY c.fecha DESC
	LIMIT $limit, $nroLotes";
$result = $mysqli->query($registro);

$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			<tr>
			<th width="7.11%">Fecha</th>
			<th width="18.11%">Paciente</th>
			<th width="11.11%">Identidad</th>
			<th width="4.11%">Sexo</th>
			<th width="4.11%">Paciente</th>
			<th width="16.11%">Colaborador</th>
			<th width="13.11%">Servicio</th>
			<th width="13.11%">Inicio Obecidad</th>
			<th width="13.11%">Habito Alimenticio</th>			
			</tr>';			
			
while($registro2 = $result->fetch_assoc()){	
	$tabla = $tabla.'<tr>
	   <td>'.$registro2['fecha'].'</td>
	   <td>'.$registro2['paciente'].'</td>		   
	   <td>'.$registro2['identidad'].'</td>	
       <td>'.$registro2['sexo'].'</td>	
       <td>'.$registro2['paciente_tipo'].'</td>		   
	   <td>'.$registro2['colaborador'].'</td>
	   <td>'.$registro2['servicio'].'</td>		   
	   <td>'.$registro2['inicio_obesidad'].'</td>	
	   <td>'.$registro2['habito_alimenticio'].'</td>	   
	</tr>';	        
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="17" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="17"><b><p ALIGN="center">Total de Registros Encontrados '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>