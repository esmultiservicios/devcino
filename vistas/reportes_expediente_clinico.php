<?php
session_start(); 
include "../php/funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

if( isset($_SESSION['colaborador_id']) == false ){
   header('Location: login.php'); 
}    

$_SESSION['menu'] = "Reporte de Atenciones Medicas";

if(isset($_SESSION['colaborador_id'])){
 $colaborador_id = $_SESSION['colaborador_id'];  
}else{
   $colaborador_id = "";
}

$type = $_SESSION['type'];

$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);//HOSTNAME	
$fecha = date("Y-m-d H:i:s"); 
$comentario = mb_convert_case("Ingreso al Modulo de Reporte Expediente Clinico Cirugia", MB_CASE_TITLE, "UTF-8");   

if($colaborador_id != "" || $colaborador_id != null){
   historial_acceso($comentario, $nombre_host, $colaborador_id);  
}  

//OBTENER NOMBRE DE EMPRESA
$usuario = $_SESSION['colaborador_id'];

$query_empresa = "SELECT e.nombre AS 'nombre'
	FROM users AS u
	INNER JOIN empresa AS e
	ON u.empresa_id = e.empresa_id
	WHERE u.colaborador_id = '$usuario'";
$result = $mysqli->query($query_empresa) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$empresa = '';

if($result->num_rows>0){
  $empresa = $consulta_registro['nombre'];
}

$mysqli->close();//CERRAR CONEXIÓN     
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="author" content="Script Tutorials" />
    <meta name="description" content="Responsive Websites Orden Hospitalaria de San Juan de Dios">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Reporte Expediente Clínico :: <?php echo $empresa; ?></title>
	<?php include("script_css.php"); ?>	
</head>
<body>
   <!--Ventanas Modales-->
   <!-- Small modal -->  
  <?php include("templates/modals.php"); ?>    

<!--INICIO MODAL-->

   <?php include("modals/modals.php");?>	

   <!--Fin Ventanas Modales-->
	<!--MENU-->	  
       <?php include("templates/menu.php"); ?>
    <!--FIN MENU--> 
	
<br><br><br>
<div class="container-fluid">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mt-2 mb-4">
			<li class="breadcrumb-item active"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>vistas/inicio.php">Dashboard</a></li>
			<li class="breadcrumb-item" id="acciones_busqueda"><a id="ancla_busqueda" class="breadcrumb-link" style="text-decoration: none;" href="#"><span id="label_busqueda"></a></li>
			<li class="breadcrumb-item" id="acciones_expediente"><span id="label_expediente_clinico"></span></li>
		</ol>
	</nav>
	
	<div id="main_expediente_clinico">
		<form class="form-inline" id="form_main_atenciones_medicas">
			<div class="form-group mr-1">
				<div class="input-group">				
					<div class="input-group-append">				
						<span class="input-group-text"><div class="sb-nav-link-icon"></div>Buscar</span>
					</div>
					<input type="text" placeholder="Buscar por: Expediente, Nombre o Identidad" data-toggle="tooltip" data-placement="top" title="Buscar por: Expediente, Nombre, Apellido o Identidad" id="bs_regis" autofocus class="form-control" size="60"/>	
				</div>		   
			</div>	  
			<div class="form-group">
				<div class="dropdown show" data-toggle="tooltip" data-placement="top" title="Exportar">
				<a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-download fa-lg"></i> Exportar
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="#" id="reporte_excel">Reporte</a>		
				</div>
				</div>		  
			</div>	  
			<div class="form-group">
				<button class="btn btn-danger ml-1" type="submit" id="limpiar"><div class="sb-nav-link-icon" data-toggle="tooltip" data-placement="top" title="Limpiar"></div><i class="fas fa-broom fa-lg"></i> Limpiar</button>
			</div>	   
		</form>	
		<hr/>   
		<div class="form-group">
			<div class="col-sm-12">
				<div class="registros overflow-auto" id="agrega-registros"></div>
			</div>		   
		</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-center" id="pagination"></ul>
			</nav>
		</div>

	<div id="view_expediente_clinico" style="display:none;">
		<form id="formulario_buscarAtencion">
			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
				Datos Generales
				</div>
				<div class="card-body">
				<input type="hidden" required id="expediente_pacientes_id" name="expediente_pacientes_id" class="form-control" readonly/>
					<div class="form-row">
						<button class="btn btn-danger ml-2" type="submit" id="report_historiaclinica"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
					</div>
					<br/>
					<div class="form-row">
						<div class="col-md-2 mb-3">
							<label for="expediente_identidad">Identidad <span class="priority">*<span/></label>
							<input type="number" required id="expediente_identidad" name="expediente_identidad" class="form-control" readonly/>
						</div>		
						<div class="col-md-5 mb-3">
							<label for="expediente_cliente">Paciente</label>
							<input type="text" id="expediente_cliente" name="expediente_cliente" class="form-control" readonly />
						</div>								
						<div class="col-md-2 mb-3">
							<label for="expediente_fecha_nacimiento">Fecha Nacimiento</label>
							<input type="date"  id="expediente_fecha_nacimiento" name="expediente_fecha_nacimiento" class="form-control" value="<?php echo date ("Y-m-d");?>" readonly/>
						</div>						
						<div class="col-md-3 mb-3">
							<label for="expediente_edad">Edad</label>
							<input type="text" id="expediente_edad" name="expediente_edad" class="form-control" readonly/>
						</div>						
					</div>
					<div class="form-row">
						<div class="col-md-1 mb-3">
							<label for="expediente_genero">Genero</label>
							<input type="text" id="expediente_genero" name="expediente_genero" class="form-control" readonly/>
						</div>							
						<div class="col-md-1 mb-3">
							<label for="expediente_telefono">Teléfono</label>
							<input type="number" id="expediente_telefono" name="expediente_telefono" class="form-control" readonly/>
						</div>
						<div class="col-md-1 mb-3">
							<label for="expediente_nch">NCH</label>
							<input type="text" id="expediente_nch" name="expediente_nch" class="form-control" readonly/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="expediente_profesion">Profesión</label>
							<input type="text" id="expediente_profesion" name="expediente_profesion" class="form-control" readonly/>
						</div>			
						<div class="col-md-3 mb-3">
							<label for="expediente_departamento">Departamento</label>
							<input type="text" required id="expediente_departamento" name="expediente_departamento" class="form-control" readonly/>
						</div>						
						<div class="col-md-3 mb-3">
							<label for="expediente_municipio">Municipio</label>
							<input type="text"  id="expediente_municipio" name="expediente_municipio" class="form-control" readonly/>
						</div>																	
					</div>	
					<div class="form-row">								
						<div class="col-md-4 mb-3">
							<label for="expediente_procedencia">Procedencia</label>
							<input type="text" id="expediente_procedencia" name="expediente_procedencia" class="form-control" readonly/>
						</div>																			
						<div class="col-md-4 mb-3">
							<label for="expediente_telefono">Correo</label>
							<input type="text" id="expediente_correo" name="expediente_correo" class="form-control" readonly/>
						</div>	
						<div class="col-md-4 mb-3">
							<label for="expediente_referido">Referido por</label>
							<input type="text" id="expediente_referido" name="expediente_referido" class="form-control" readonly/>
						</div>																	
					</div>														
				</div>
			</div>

			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
				Expediente Clinico
				</div>
				<div class="card-body clinicare-size-450">
					<div class="form-row">
						<div class="col-md-2 mb-3">
							<label for="expediente_fecha_consulta">Fecha Consulta</label>
							<input type="date" required id="expediente_fecha_consulta" name="expediente_fecha_consulta" class="form-control" value="<?php echo date ("Y-m-d");?>" readonly/>
						</div>			
						<div class="col-md-2 mb-3">
							<label for="expediente_inicio_obesidad">Inicio Obesidad</label>
							<input type="text" required id="expediente_inicio_obesidad" name="expediente_inicio_obesidad" class="form-control" readonly/>
						</div>						
						<div class="col-md-2 mb-3">
							<label for="expediente_habito_alimenticio">Habito Alimenticio</label>
							<input type="text" required id="expediente_habito_alimenticio" name="expediente_habito_alimenticio" class="form-control" readonly/>
						</div>	
						<div class="col-md-2 mb-3">
							<label for="expediente_tipo_obecidad">Tipo Obesidad</label>
							<input type="text" required id="expediente_tipo_obecidad" name="expediente_tipo_obecidad" class="form-control" readonly/>
						</div>	
						
						<div class="col-md-2 mb-3">
							<label for="expediente_intento_perdida_peso">Intento Perdida de Peso</label>
							<input type="text" required id="expediente_intento_perdida_peso" name="expediente_intento_perdida_peso" class="form-control" readonly/>
						</div>	
						<div class="col-md-2 mb-3">
							<label for="expediente_peso_maximo_alcanzado">Peso Máximo Alcanzado</label>
							<div class="input-group mb-3">								
								<input type="text" required id="expediente_peso_maximo_alcanzado" name="expediente_peso_maximo_alcanzado" class="form-control" readonly/>
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
								</div>
							</div>							
						</div>							
					</div>

					<div class="form-row">
						<div class="col-md-2 mb-3">
							<label for="expediente_peso_maximo_alcanzado">Peso Máximo Alcanzado KG</label>
							<div class="input-group mb-3">								
							<input type="text" required id="expediente_peso_maximo_alcanzado_kg" name="expediente_peso_maximo_alcanzado_kg" class="form-control" readonly/>
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
								</div>
							</div>	
						</div>						
						<div class="col-md-2 mb-3">
							<label for="expediente_fecha_consulta">Sedentarismo</label>
							<input type="text" required id="expediente_sedentarismo" name="expediente_sedentarismo" class="form-control" readonly/>
						</div>	
						<div class="col-md-2 mb-3">
							<label for="expediente_fecha_consulta">Drogas</label>
							<input type="text" required id="drogas_respuesta" name="drogas_respuesta" class="form-control" readonly />
						</div>	
						<div class="col-md-2 mb-3">
							<label for="expediente_fecha_consulta">Edad</label>
							<input type="text" required id="expediente_edad_" name="expediente_edad_" class="form-control" readonly />
						</div>							
					</div>

					<div class="form-group custom-control custom-checkbox custom-control-inline">			  	
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Erge</label>
							<label class="switch">
								<input type="checkbox" id="expediente_erge_activo" name="expediente_erge_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_erge_activo"></span>				
						</div>
						<div class="col-md-3">	
							<label class="form-check-label" for="defaultCheck1">HTA&nbsp;</label>
							<label class="switch">
								<input type="checkbox" id="expediente_hta_activo" name="expediente_hta_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_hta_activo"></span>				
						</div>	
						<div class="col-md-4">		
							<label class="form-check-label" for="defaultCheck1">Higado Graso</label>
							<label class="switch">
								<input type="checkbox" id="expediente_higado_graso_activo" name="expediente_higado_graso_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_higado_graso_activo"></span>				
						</div>	
						
						<div class="col-md-3">	
							<label class="form-check-label" for="defaultCheck1">SAOS</label>
							<label class="switch">
								<input type="checkbox" id="expediente_saos_activo" name="expediente_saos_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_saos_activo"></span>				
						</div>								  							
						<div class="col-md-4">	
							<label class="form-check-label" for="defaultCheck1">Hipotiroidismo&nbsp;</label>
							<label class="switch">
								<input type="checkbox" id="expediente_hipotiroidismo_activo" name="expediente_hipotiroidismo_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_hipotiroidismo_activo"></span>				
						</div>	
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Articulares</label>
							<label class="switch" data-toggle="tooltip" data-placement="top" title="Problemas Articulares">
								<input type="checkbox" id="expediente_articulares_activo" name="expediente_articulares_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_articulares_activo"></span>				
						</div>								
					</div>	
					<br/>
					<div class="form-row">	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_erge_respuesta" name="expediente_erge_respuesta" placeholder="Erge" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_hta_respuesta" name="expediente_hta_respuesta" placeholder="HTA" class="form-control" maxlength="250" />
						</div>									
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_higado_graso_respuesta" name="expediente_higado_graso_respuesta" placeholder="Higado Graso" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_saos_respuesta" name="expediente_saos_respuesta" placeholder="SAOS" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_hipotiroidismo_respuesta" name="expediente_hipotiroidismo_respuesta" placeholder="Hipotiroidismo" class="form-control" maxlength="250" />
						</div>									
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_articulares_respuesta" name="expediente_articulares_respuesta" placeholder="Articulares" class="form-control" maxlength="250" />
						</div>																
					</div>	
					<br/>							
					<div class="form-group custom-control custom-checkbox custom-control-inline">													
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Ovarios Poliquisticos</label>
							<label class="switch">
								<input type="checkbox" id="expediente_ovarios_poliquisticos_activo" name="expediente_ovarios_poliquisticos_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_ovarios_poliquisticos_activo"></span>				
						</div>	
						<div class="col-md-2">		
							<label class="form-check-label" for="defaultCheck1">&nbsp;&nbsp;Varices&nbsp;&nbsp;&nbsp;</label>
							<label class="switch">
								<input type="checkbox" id="expediente_varices_activo" name="expediente_varices_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_varices_activo"></span>				
						</div>	
						<div class="col-md-2">		
							<label class="form-check-label" for="defaultCheck1">Drogas</label>
							<label class="switch">
								<input type="checkbox" id="expediente_drogas_activo" name="expediente_drogas_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_drogas_activo"></span>				
						</div>	
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Ant Fami Diabetes&nbsp;</label>
							<label class="switch">
								<input type="checkbox" id="expediente_antecedentes_fami_diabetes_activo" name="expediente_antecedentes_fami_diabetes_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_antecedentes_fami_diabetes_activo"></span>				
						</div>							
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Ant Fami Obesidad</label>
							<label class="switch">
								<input type="checkbox" id="expediente_antecedentes_fami_Obesidad_activo" name="expediente_antecedentes_fami_Obesidad_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_antecedentes_fami_Obesidad_activo"></span>				
						</div>
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Ant Fami Ca Gastrico</label>
							<label class="switch">
								<input type="checkbox" id="expediente_antecedentes_fami_cancer_gastrico_activo" name="expediente_antecedentes_fami_cancer_gastrico_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_antecedentes_fami_cancer_gastrico_activo"></span>				
						</div>																								
					</div>
					<br/>
					<div class="form-row">	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_ovarios_respuesta" name="expediente_ovarios_respuesta" placeholder="Ovarios" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_varices_respuesta" name="expediente_varices_respuesta" placeholder="Varices" class="form-control" maxlength="250" />
						</div>									
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_drogas_respuesta" name="expediente_drogas_respuesta" placeholder="Drogas" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_ant_fam_respuesta" name="expediente_ant_fam_respuesta" placeholder="Ant Fami Diabetes" class="form-control" maxlength="250" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_ant_fam_obecidad_respuesta" name="expediente_ant_fam_obecidad_respuesta" placeholder="Ant Fami Obesidad" class="form-control" maxlength="250" />
						</div>									
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_ant_fam_gastrico_respuesta" name="expediente_ant_fam_gastrico_respuesta" placeholder="Ant Fami Ca Gastrico" class="form-control" maxlength="250" />
						</div>																
					</div>	
					<br/>
					<div class="form-group custom-control custom-checkbox custom-control-inline">												
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">Enf Psiquiatricas</label>
							<label class="switch">
								<input type="checkbox" id="expediente_antecedentes_fami_psiquiatricas_activo" name="expediente_antecedentes_fami_psiquiatricas_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_antecedentes_fami_psiquiatricas_activo"></span>				
						</div>	
						<div class="col-md-3">		
							<label class="form-check-label" for="defaultCheck1">DM</label>
							<label class="switch">
								<input type="checkbox" id="expediente_antecedentes_dm_activo" name="expediente_antecedentes_dm_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_antecedentes_dm_activo"></span>				
						</div>
						<div class="col-md-3">	
							<label class="form-check-label" for="defaultCheck1">Alergias</label>
							<label class="switch">
								<input type="checkbox" id="expediente_alergias_activo" name="expediente_alergias_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_alergias_activo"></span>				
						</div>	
						<div class="col-md-3">	
							<label class="form-check-label" for="defaultCheck1">Alcohol</label>
							<label class="switch">
								<input type="checkbox" id="expediente_alcohol_activo" name="expediente_alcohol_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_alcohol_activo"></span>				
						</div>	
						<div class="col-md-3">	
							<label class="form-check-label" for="defaultCheck1">Tabaquismo</label>
							<label class="switch">
								<input type="checkbox" id="expediente_tabaquismo_activo" name="expediente_tabaquismo_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_tabaquismo_activo"></span>				
						</div>	
						<div class="col-md-3 mb-3">
							<label class="form-check-label" for="defaultCheck1">Dislipidemia</label>
							<label class="switch">
								<input type="checkbox" id="expediente_dislipidemia_activo" name="expediente_dislipidemia_activo" value="1">
								<div class="slider round"></div>
							</label>
							<span class="question mb-2" id="label_expediente_dislipidemia_activo"></span>	
						</div>																									
					</div>			
					<br/>	
					<div class="form-row">	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_enf_psiquiatricas_respuesta" name="expediente_enf_psiquiatricas_respuesta" placeholder="Enf Psiquiatricas" class="form-control" maxlength="50" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_dm_respuesta" name="expediente_dm_respuesta" placeholder="DM" class="form-control" maxlength="50" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_alergias_respuesta" name="expediente_alergias_respuesta" placeholder="Alergias" class="form-control" maxlength="50" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_alcohol_respuesta" name="expediente_alcohol_respuesta" placeholder="Alcohol" class="form-control" maxlength="50" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_tabaquismo_respuesta" name="expediente_tabaquismo_respuesta" placeholder="Tabaquismo" class="form-control" maxlength="50" />
						</div>	
						<div class="col-md-2 mb-3">
							<input type="text" id="expediente_dislipidemia_respuesta" name="expediente_dislipidemia_respuesta" placeholder="Dislipidemia" class="form-control" maxlength="50" />
						</div>																
					</div>	
						
					<div class="form-row">						
						<div class="col-md-12 mb-3">
						  <label>Otros</label>
						  <input type="text" id="expediente_otros" name="expediente_otros" class="form-control" maxlength="100" readonly />
						</div>					
					</div>	

					<div class="form-row">						
						<div class="col-md-3 mb-3">
						  <label>Talla</label>
						  <div class="input-group mb-3">								
						  	<input type="text" id="expediente_talla" name="expediente_talla" class="form-control" maxlength="20" step="0.01" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>
								</div>
						  </div>
						</div>	

						<div class="col-md-3 mb-3">
							<label>Peso</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_peso" name="expediente_peso" class="form-control" step="0.01" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
								</div>
							</div>							  
						</div>
						<div class="col-md-3 mb-3">
							<label>Peso KG</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_peso_kg" name="expediente_peso_kg" class="form-control" value="0.00" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
								</div>
							</div>							  
						</div>	
						<div class="col-md-3 mb-3">
						  <label>IMC</label>
						  <input type="text" id="imc" name="imc" class="form-control" maxlength="20" readonly step="0.01" value="0.0" readonly />
						</div>							
					</div>
							
					<div class="form-row">							
						<div class="col-md-3 mb-3">
							<label>Peso Ideal</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_peso_ideal" name="expediente_peso_ideal" class="form-control" step="0.01" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
								</div>
							</div>							  
						</div>	
						<div class="col-md-3 mb-3">
							<label>Peso Ideal KG</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_peso_ideal_kg" name="expediente_peso_ideal_kg" class="form-control" value="0.00" readonly step="0.01" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
								</div>
							</div>							  
						</div>
						<div class="col-md-3 mb-3">
							<label>Exceso de Peso</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_exceso_peso" name="expediente_exceso_peso" class="form-control" step="0.01" readonly />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
								</div>
							</div>							  
						</div>	
						<div class="col-md-3 mb-3">
							<label>Exceso de Peso KG</label>
							<div class="input-group mb-3">								
								<input type="text" id="expediente_exceso_peso_kg" name="expediente_exceso_peso_kg" class="form-control" value="0.00" readonly step="0.01" />
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
								</div>
							</div>							  
						</div>								
					</div>
						
						<div class="form-row">
							<div class="col-md-6 mb-3">
								<label for="expediente_cirugia_abodominal">Cirugía Abdominal</label>
								<textarea id="expediente_expediente_cirugia_abodominal" name="expediente_expediente_cirugia_abodominal" placeholder="Cirugía Abdominal" class="form-control" maxlength="2500" rows="5" readonly></textarea>
							</div>	
							<div class="col-md-6 mb-3">
								<label for="expediente_hallazgos_anormales">Hallazgos Anormales</label>
								<textarea id="expediente_expediente_hallazgos_anormales" name="expediente_expediente_hallazgos_anormales" placeholder="Hallazgos Anormales" class="form-control" maxlength="2500" rows="5" readonly></textarea>
							</div>	
						</div>
						
						<div class="form-row">						
							<div class="col-md-12 mb-3">
							  <label>Estudios de Imágenes Solicitados</label>
							  <input type="text" id="expediente_expediente_estudios_imagenes" name="expediente_estudios_imagenes" class="form-control" maxlength="150" readonly />
							</div>						
						</div>	
						<div class="form-row">						
							<div class="col-md-12 mb-3">
							  <label>Referencia A</label>
							  <input type="text" id="expediente_referencia_a" name="expediente_referencia_a" class="form-control" maxlength="150" readonly />
							</div>						
						</div>	
						<div class="form-row">						
							<div class="col-md-12 mb-3">
							  <label>Recomendaciones Quirúrgicas</label>
							  <input type="text" id="expediente_recomendaciones_quirurgicas" name="expediente_recomendaciones_quirurgicas" class="form-control" maxlength="150" readonly />
							</div>						
						</div>		
						<div class="form-row">						
							<div class="col-md-12 mb-3">
							  <label for="expediente_presupuesto">Presupuesto Estimado</label>
							  <input type="text" id="expediente_presupuesto" name="expediente_presupuesto" class="form-control" maxlength="150" readonly />
							</div>						
						</div>
						<div class="form-row">						
							<div class="col-md-12 mb-3">
							<label for="expediente_observacion">Observacion</label>
							<input type="text" id="expediente_observacion" name="expediente_observacion" class="form-control" maxlength="150" readonly />
							</div>						
						</div>							
						<div class="form-row">							
							<div class="col-md-4">	
									<span class="question">Ejercicio</span>	
									<label class="switch">
										<input type="checkbox" id="expediente_ejercicio_activo" name="expediente_ejercicio_activo" value="1" disabled>
										<div class="slider round"></div>
									</label>
									<span class="question" id="label_expediente_ejercicio_activo"></span>				
							</div>																
						</div>
						<div class="form-row">	
							<div class="col-md-12 mb-3">
							  <input type="text" id="expediente_ejercicio_respuesta" name="expediente_ejercicio_respuesta" placeholder="Ejercicio" class="form-control" maxlength="250" readonly />
							</div>								
						</div>	
						
						<div class="card-body">
							<div class="form-row clinicare-size-450">									
								<div class="col-md-12 mb-3">
									<div class="modal-title" id="mostrar_datos"></div>
								</div>																					
							</div>									
						</div>

				</div>
			</div>	
			
			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
				Expediente Clínico Seguimiento Pre-Peratorio
				</div>
				<div class="card-body clinicare-size-450" id="main_seguimiento_preo_operatorio_clinicare-size">
					<div id="main_seguimiento_preo_operatorio"></div>
				
				   </div>
			</div>
			
			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
				Expediente Clínico Seguimiento Nota Operatoria
				</div>
				<div class="card-body clinicare-size-450" id="main_seguimiento_nota_operatorio_clinicare-size">
					<div id="main_seguimiento_nota_operatorio"></div>	
					
					<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								ARCHIVOS
							</div>
							<div class="card-body">
								<div class="form-row clinicare-size-450">									
									<div class="col-md-12 mb-3">
										<div class="modal-title" id="mostrar_datos_nota_operatoria"></div>
									</div>																					
							   </div>									
						   </div>
					</div> 										
				</div>
			</div>	

			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
				Expediente Clínico Seguimiento Post Operatorio
				</div>
				<div class="card-body clinicare-size-450" id="main_seguimiento_post_operatorio_clinicare-size">
					<div id="main_seguimiento_post_operatorio"></div>				
				
				  </div>
			</div>	
			
		</form>
	</div>
	<?php include("templates/factura.php"); ?>
	<?php include("templates/footer.php"); ?>	
</div>

    <!-- add javascripts -->
	<?php 
		include "script.php"; 
		
		include "../js/main.php"; 
		include "../js/myjava_expediente_clinico.php"; 		
		include "../js/select.php"; 	
		include "../js/functions.php"; 
		include "../js/myjava_cambiar_pass.php"; 		
	?>
	  
</body>
</html>