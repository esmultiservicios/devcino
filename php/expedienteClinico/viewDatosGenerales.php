<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$usuario = $_SESSION['colaborador_id'];	

$consulta_expediente = "SELECT c.*, p.expediente AS 'expediente', p.pacientes_id AS 'pacientes_id', p.identidad AS 'identidad', CONCAT(p.nombre, ' ', p.apellido) AS 'cliente', p.telefono1 AS 'telefono',
(CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', p.fecha_nacimiento AS 'fecha_nacimiento', d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad', pr.nombre AS 'profesion', p.email AS 'correo', p.referidopor AS 'referido', 
(CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', p.fecha_nacimiento AS 'fecha_nacimiento', d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad', pr.nombre AS 'profesion', p.email AS 'correo', p.referidopor AS 'referido'
	FROM pacientes AS p
	INNER JOIN departamentos AS d
	ON p.departamento_id = d.departamento_id
	INNER JOIN municipios AS m
	ON p.municipio_id = m.municipio_id
	LEFT JOIN profesion AS pr
	ON p.profesion_id = pr.profesion_id
	LEFT JOIN clinico AS c
	ON p.pacientes_id = c.pacientes_id
	WHERE p.pacientes_id = '$pacientes_id'";

$result = $mysqli->query($consulta_expediente);   

$expediente = "";
$identidad = "";
$fecha_nacimiento = "";
$cliente = "";
$telefono = "";
$departamento = "";
$municipio = "";
$procedencia = "";
$profesion = "";
$nch = "";
$departamento = "";
$correo = "";
$genero = "";
$referido = "";
$fecha = "";
$inicio_obesidad = "";
$habito_alimenticio = "";
$tipo_obesidad = "";
$intentos_perdida_peso = "";
$peso_maximo_alcansado = "";
$sedentarismo = "";
$ejercicio = 0;
$ejercicio_respuesta = "";
$alergias = 0;
$respuesta_alergias = "";
$erge = 0;
$hta = 0;
$dislipidemia = 0;
$higado_graso = 0;
$saos = 0;
$hipotiroidismo = 0;
$articulares = 0;
$ovarios_poliquisticos = 0;
$varices = 0;
$tabaquismo = 0;
$respuesta_tabaquismo = "";
$alcohol = 0;
$respuesta_alcohol = "";
$drogas = 0;
$respuesta_drogas = "";
$ant_fami_diabetes = 0;
$ant_fami_obesidad = 0;
$ant_fami_cancer_gastrico = 0;
$ant_fami_psiquiatricas = 0;
$ant_dm = 0;
$otros = "";
$cirugia_abdominal ="";
$talla = "";
$peso_ideal = "";
$peso = "";
$exceso_peso = "";
$imc = "";
$diagnostico = "";
$estudios_imagenes = "";
$referencia_a = "";
$recomendaciones = "";
$presupuesto = "";
$paciente = "";
$estado	= "";
$fecha_registro = "";
$peso_maximo_alcansado_kg = "";
$peso_ideal_kg = "";
$peso_kg ="";
$exceso_peso_kg = "";
$edad = 0;
$servicio_id = 0;
$clinico_id = "";
$observaciones = "";
$respuesta_dislipidemia = "";
$respuesta_higado_graso = "";
$respuesta_hipotiroidismo = "";
$respuesta_articulares = "";
$respuesta_ovarios_poliquisticos = "";
$respuesta_varices = "";
$respuesta_ant_fami_diabetes = "";
$respuesta_ant_fami_obesidad = "";
$respuesta_ant_fami_cancer_gastrico = "";
$respuesta_respuesta_ant_fami_psiquiatricas = "";
$respuesta_ant_dm = "";
$respuesta_saos = "";
$respuesta_erge = "";
$respuesta_hta  = "";
$anos = 0;
$meses = 0;	  
$dias = 0;	

if($result->num_rows>0){
	$consulta_expediente1 = $result->fetch_assoc();
	$expediente = $consulta_expediente1['expediente'];
	$identidad = $consulta_expediente1['identidad'];
	$cliente = $consulta_expediente1['cliente'];
	$fecha_nacimiento = $consulta_expediente1['fecha_nacimiento'];
	$telefono = $consulta_expediente1['telefono'];
	$departamento = $consulta_expediente1['departamento'];
	$municipio = $consulta_expediente1['municipio'];
	$procedencia = $consulta_expediente1['localidad'];
	$profesion = $consulta_expediente1['profesion'];
	$nch = $consulta_expediente1['clinico_id'];
	$correo = $consulta_expediente1['correo'];	
	$genero = $consulta_expediente1['genero'];
	$referido = $consulta_expediente1['referido'];
	$fecha = $consulta_expediente1['fecha'];
	$inicio_obesidad = $consulta_expediente1['inicio_obesidad'];
	$habito_alimenticio = $consulta_expediente1['habito_alimenticio'];
	$tipo_obesidad = $consulta_expediente1['tipo_obesidad'];
	$intentos_perdida_peso = $consulta_expediente1['intentos_perdida_peso'];
	$peso_maximo_alcansado = $consulta_expediente1['peso_maximo_alcansado'];					
	$sedentarismo = $consulta_expediente1['sedentarismo'];
	$ejercicio = $consulta_expediente1['ejercicio'];					
	$ejercicio_respuesta = $consulta_expediente1['ejercicio_respuesta'];		
	$alergias = $consulta_expediente1['alergias'];	
	$respuesta_alergias = $consulta_expediente1['respuesta_alergias'];
	$erge = $consulta_expediente1['erge'];
	$hta = $consulta_expediente1['hta'];
	$dislipidemia = $consulta_expediente1['dislipidemia'];
	$higado_graso = $consulta_expediente1['higado_graso'];
	$saos = $consulta_expediente1['saos'];
	$hipotiroidismo = $consulta_expediente1['hipotiroidismo'];
	$articulares = $consulta_expediente1['articulares'];
	$ovarios_poliquisticos = $consulta_expediente1['ovarios_poliquisticos'];
	$varices = $consulta_expediente1['varices'];
	$tabaquismo = $consulta_expediente1['tabaquismo'];
	$respuesta_tabaquismo = $consulta_expediente1['respuesta_tabaquismo'];
	$alcohol = $consulta_expediente1['alcohol'];
	$respuesta_alcohol = $consulta_expediente1['respuesta_alcohol'];
	$drogas = $consulta_expediente1['drogas'];
	$respuesta_drogas = $consulta_expediente1['respuesta_drogas'];
	$ant_fami_diabetes = $consulta_expediente1['ant_fami_diabetes']; 
	$ant_fami_obesidad = $consulta_expediente1['ant_fami_obesidad'];
	$ant_fami_cancer_gastrico = $consulta_expediente1['ant_fami_cancer_gastrico'];
	$ant_fami_psiquiatricas = $consulta_expediente1['ant_fami_psiquiatricas'];
	$ant_dm = $consulta_expediente1['ant_dm'];
	$otros = $consulta_expediente1['otros'];
	$cirugia_abdominal = $consulta_expediente1['cirugia_abdominal'];
	$talla = $consulta_expediente1['talla'];
	$peso_ideal = $consulta_expediente1['peso_ideal'];
	$peso = $consulta_expediente1['peso'];
	$exceso_peso = $consulta_expediente1['exceso_peso'];
	$imc = $consulta_expediente1['imc'];
	$diagnostico = $consulta_expediente1['diagnostico'];
	$estudios_imagenes = $consulta_expediente1['estudios_imagenes'];
	$referencia_a = $consulta_expediente1['referencia_a'];
	$recomendaciones = $consulta_expediente1['recomendaciones'];
	$presupuesto = $consulta_expediente1['presupuesto'];
	$paciente = $consulta_expediente1['paciente'];
	$estado	= $consulta_expediente1['estado'];
	$fecha_registro = $consulta_expediente1['fecha_registro'];
	$peso_maximo_alcansado_kg = $consulta_expediente1['peso_maximo_alcansado_kg'];
	$peso_ideal_kg = $consulta_expediente1['peso_ideal_kg'];
	$peso_kg = $consulta_expediente1['peso_kg'];
	$exceso_peso_kg = $consulta_expediente1['exceso_peso_kg'];
	$edad = $consulta_expediente1['edad'];
	$servicio_id = $consulta_expediente1['servicio_id'];
	$clinico_id = $consulta_expediente1['clinico_id'];
	$observaciones = $consulta_expediente1['observaciones'];
	$respuesta_dislipidemia = $consulta_expediente1['respuesta_dislipidemia'];
	$respuesta_higado_graso = $consulta_expediente1['respuesta_higado_graso'];
	$respuesta_hipotiroidismo = $consulta_expediente1['respuesta_hipotiroidismo'];
	$respuesta_articulares = $consulta_expediente1['respuesta_articulares'];
	$respuesta_ovarios_poliquisticos = $consulta_expediente1['respuesta_ovarios_poliquisticos'];
	$respuesta_varices = $consulta_expediente1['respuesta_varices'];
	$respuesta_ant_fami_diabetes = $consulta_expediente1['respuesta_ant_fami_diabetes'];
	$respuesta_ant_fami_obesidad = $consulta_expediente1['respuesta_ant_fami_obesidad'];
	$respuesta_ant_fami_cancer_gastrico = $consulta_expediente1['respuesta_ant_fami_cancer_gastrico'];
	$respuesta_respuesta_ant_fami_psiquiatricas = $consulta_expediente1['respuesta_respuesta_ant_fami_psiquiatricas'];
	$respuesta_ant_dm = $consulta_expediente1['respuesta_ant_dm'];
	$respuesta_saos = $consulta_expediente1['respuesta_saos'];	
	$respuesta_erge = $consulta_expediente1['respuesta_erge'];
	$respuesta_hta = $consulta_expediente1['respuesta_hta'];

	$valores_array = getEdad($fecha_nacimiento);
	$anos = $valores_array['anos'];
	$meses = $valores_array['meses'];	  
	$dias = $valores_array['dias'];	
}

//OBTENER LA EDAD DEL USUARIO 
/*********************************************************************************/
/*********************************************************************************/
if ($anos>1 ){
   $palabra_anos = "Años";
}else{
  $palabra_anos = "Año";
}

if ($meses>1 ){
   $palabra_mes = "Meses";
}else{
  $palabra_mes = "Mes";
}

if($dias>1){
	$palabra_dia = "Días";
}else{
	$palabra_dia = "Día";
}

$datos = array(
	0 => $identidad,
	1 => $cliente,
	2 => $fecha_nacimiento,
	3 => $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia,	
	4 => $telefono,	
	5 => $departamento,
	6 => $municipio,	
	7 => $procedencia,	
	8 => $profesion,	
	9 => $nch,	
	10 => $correo,
	11 => $genero,	
	12 => $referido,	
	13 => $fecha,
	14 => $inicio_obesidad,
	15 => $habito_alimenticio,
	16 => $tipo_obesidad,
	17 => $intentos_perdida_peso,
	18 => $peso_maximo_alcansado,																		
	19 => $sedentarismo,	
	20 => $ejercicio,																		
	21 => $ejercicio_respuesta,	
	22 => $alergias,	
	23 => $respuesta_alergias,
	24 => $erge,
	25 => $hta,
	26 => $dislipidemia,
	27 => $higado_graso,
	28 => $saos,																		
	29 => $hipotiroidismo,	
	30 => $articulares,																		
	31 => $ovarios_poliquisticos,	
	32 => $varices,	
	33 => $tabaquismo,
	34 => $respuesta_tabaquismo,			
	35 => $alcohol,	
	36 => $respuesta_alcohol,	
	37 => $drogas,	
	38 => $respuesta_drogas,	
	39 => $ant_fami_diabetes,
	40 => $ant_fami_obesidad,
	41 => $ant_fami_cancer_gastrico,
	42 => $ant_fami_psiquiatricas,
	43 => $ant_dm,	
	44 => $otros,
	45 => $cirugia_abdominal,	
	46 => $talla,
	47 => $peso_ideal,
	48 => $peso,
	49 => $exceso_peso,
	50 => $imc,	
	51 => $diagnostico,	
	52 => $estudios_imagenes,	
	53 => $referencia_a,
	54 => $recomendaciones,
	55 => $presupuesto,
	56 => $paciente,
	57 => $estado,	
	58 => $fecha_registro,		
	59 => $peso_maximo_alcansado_kg,
	60 => $peso_ideal_kg,
	61 => $peso_kg,
	62 => $exceso_peso_kg,
	63 => $edad,
	64 => $servicio_id,	
	65 => $clinico_id,	
	66 => $observaciones,
	67 => $respuesta_erge,
	68 => $respuesta_hta,
	69 => $respuesta_dislipidemia,
	70 => $respuesta_higado_graso,
	71 => $respuesta_hipotiroidismo,
	72 => $respuesta_articulares,	
	73 => $respuesta_ovarios_poliquisticos,	
	74 => $respuesta_varices,
	75 => $respuesta_ant_fami_diabetes,
	76 => $respuesta_ant_fami_obesidad,
	77 => $respuesta_ant_fami_cancer_gastrico,
	78 => $respuesta_respuesta_ant_fami_psiquiatricas,
	79 => $respuesta_ant_dm,
	80 => $respuesta_saos
);
echo json_encode($datos);
?>