<?php	
	session_start();   
	include "../funtions.php";

	//CONEXION A DB
	$mysqli = connect_mysqli(); 

	$colaborador_id = $_SESSION['colaborador_id'];

	//CONSULTA LOS DATOS DE LA ENTIDAD CORPORACION
	$consulta = "SELECT sf.secuencia_facturacion_id AS 'secuencia_facturacion_id', e.nombre AS 'empresa', sf.cai AS 'cai', e.rtn AS 'rtn', sf.prefijo AS 'prefijo', sf.siguiente AS 'siguiente', CONCAT(sf.prefijo, '', sf.rango_inicial) AS 'rango_inicial', CONCAT(sf.prefijo, '', sf.rango_final) AS 'rango_final', sf.fecha_limite AS 'fecha_limite', sf.fecha_activacion AS 'fecha_activacion',
	(CASE WHEN sf.activo = '1' THEN 'Sí' ELSE 'No' END) AS 'activo', 
	CAST(sf.fecha_registro AS DATE) AS 'fecha_registro', sf.relleno AS 'relleno', CONCAT(c.nombre, ' ', c.apellido) AS 'profesional', d.nombre AS 'documento'
		FROM secuencia_facturacion AS sf
		INNER JOIN colaboradores AS c
		ON sf.colaborador_id = c.colaborador_id
		INNER JOIN empresa AS e
		ON c.empresa_id = e.empresa_id
		INNER JOIN documento as d
		ON sf.documento_id = d.documento_id		
		WHERE sf.activo = 1 AND sf.colaborador_id = '$colaborador_id'
		ORDER BY sf.fecha_registro";
	$result = $mysqli->query($consulta);	

	$arreglo = array();
	$data = array();
	
	while($row = $result->fetch_assoc()){				
		$data[] = array( 
			"secuencia_facturacion_id"=>$row['secuencia_facturacion_id'],
			"empresa"=>$row['empresa'],
			"documento"=>$row['documento'],
			"cai"=>$row['cai'],
			"inicio"=>$row['rango_inicial'],
			"fin"=>$row['rango_final'],
			"fecha"=>$row['fecha_limite'],
			"siguiente"=>$row['siguiente']			
		);		
	}
	
	$arreglo = array(
		"echo" => 1,
		"totalrecords" => count($data),
		"totaldisplayrecords" => count($data),
		"data" => $data
	);

	echo json_encode($arreglo);
	
?>