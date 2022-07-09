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
$comentario = mb_convert_case("Ingreso al Modulo de Reporte Expediente Clinico Nutricion", MB_CASE_TITLE, "UTF-8");   

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
			<div class="modal-body">
					<input type="hidden" name="agenda_id" id="agenda_id" class="form-control">
					<input type="hidden" name="pacientes_id" id="pacientes_id" class="form-control">
					<input type="hidden" name="fecha_cita" id="fecha_cita" class="form-control">
					<input type="hidden" name="colaborador_id" id="colaborador_id" class="form-control">
					<input type="hidden" name="atenciones_nutricion_id" id="atenciones_nutricion_id" class="form-control">

					<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
						MOTIVO CONSULTA
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-4 mb-3">
								<label for="ante_perso">Morivo Consulta</label>
								<input type="text" class="form-control" name="motivo_consulta" id="motivo_consulta" readonly="readonly" placeholder=""Motivo consulta" maxlength="254"/>
							</div>					
							<div class="col-md-4 mb-3">
								<label for="ante_perso">Fecha Cosulta</label>
								<input type="date" class="form-control" name="fecha_consulta" id="fecha_consulta" readonly="readonly" value="<?php echo date("Y-m-d"); ?>" maxlength="254"/>
							</div>	
							<div class="col-md-4 mb-3">
								<label for="ante_perso">Edad</label>
								<input type="text" class="form-control" name="edad_consulta" id="edad_consulta" readonly="readonly" plasholder="Edad" maxlength="254"/>
							</div>													
						</div>	
						
					</div>
					</div>

					<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
						ANTECEDENTES
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="ante_perso">Antecedentes Personales</label>
								<div class="input-group">
									<textarea id="ante_perso" name="ante_perso" placeholder="Antecedentes Personales" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>			  
								</div>	
								<p id="charNum_ante_perso">1000 Caracteres</p>
							</div>					
						</div>	
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="ante_fam">Antecedentes Familiares</label>
								<div class="input-group">
								<textarea id="ante_fam" name="ante_fam" placeholder="Antecedentes Familiares" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_ante_fam">1000 Caracteres</p>
							</div>					
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="alergias">Alergias</label>
								<div class="input-group">
								<textarea id="alergias" name="alergias" placeholder="Alergias" class="form-control" readonly="readonly" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_alergias">1000 Caracteres</p>
							</div>					
						</div>	

						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="adicciones">Adicciones</label>
								<div class="input-group">
								<textarea id="adicciones" name="adicciones" placeholder="Adicciones" class="form-control" readonly="readonly" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_adicciones">1000 Caracteres</p>
							</div>					
						</div>	

						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="niveles_estres">Niveles de Estres</label>
								<div class="input-group">
								<textarea id="niveles_estres" name="niveles_estres" placeholder="Niveles de Estres" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_niveles_estres">1000 Caracteres</p>
							</div>					
						</div>						
						
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="niveles_actividad_fisica">Niveles de Actividad Física</label>
								<div class="input-group">
								<textarea id="niveles_actividad_fisica" name="niveles_actividad_fisica" readonly="readonly" placeholder="Niveles de Actividad Física" class="form-control" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_niveles_actividad_fisica">1000 Caracteres</p>
							</div>					
						</div>	

						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="intento_perdida_peso">Intento Perdidad de Peso</label>
								<div class="input-group">
								<textarea id="intento_perdida_peso" name="intento_perdida_peso" readonly="readonly" placeholder="Intento Perdida de Peso" class="form-control" maxlength="1000" rows="8"></textarea>	
								  
								</div>	
								<p id="charNum_intento_perdida_peso">1000 Caracteres</p>
							</div>					
						</div>	
						
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="antecedentes_quirurgicos">Antecedentes Quirurgicos</label>
								<div class="input-group">
								<textarea id="antecedentes_quirurgicos" name="antecedentes_quirurgicos" readonly="readonly" placeholder="Antecedentes Quirurgicos" class="form-control" maxlength="1000" rows="8"></textarea>								  
								</div>	
								<p id="charNum_antecedentes_quirurgicos">1000 Caracteres</p>
							</div>					
						</div>
						
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="observaciones">Observaciones</label>
								<div class="input-group">
								<textarea id="observaciones" name="observaciones" placeholder="Observaciones" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>							  
								</div>	
								<p id="charNum_observaciones">1000 Caracteres</p>
							</div>					
						</div>					

						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="antecedentes_quirurgicos">Diagnostico</label>
								<div class="input-group">
								<textarea id="diagnostico" name="diagnostico" placeholder="Diagnostico" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>									  
								</div>	
								<p id="charNum_diagnostico">1000 Caracteres</p>
							</div>					
						</div>
						
						<div class="form-row">
							<div class="col-md-12 mb-3">
								<label for="indicaciones">Indicaciones</label>
								<div class="input-group">
								<textarea id="indicaciones" name="indicaciones" placeholder="Indicaciones" readonly="readonly" class="form-control" maxlength="1000" rows="8"></textarea>								  
								</div>	
								<p id="charNum_indicaciones">1000 Caracteres</p>
							</div>					
						</div>					

						<div class="form-group custom-control custom-checkbox custom-control-inline">	
							<div class="col-md-12">	
								<label for="candidato_bariatrica">Candidato a Bariatrica </label>		
								<label class="switch">
									<input type="checkbox" id="candidato_bariatrica" name="candidato_bariatrica" readonly="readonly" value="1">
									<div class="slider round"></div>
								</label>
								<span class="question mb-2" id="label_candidato_bariatrica"></span>				
							</div>				  			  
						</div>	
					</div>
					</div>

					<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
						Servicio de Atención
					</div>
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-3 mb-3">
							<label for="atenciones_servicio_id">Servicio <span class="priority">*<span/></label>
							<div class="input-group mb-3">
								<select id="atenciones_servicio_id" name="atenciones_servicio_id" readonly="readonly" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes"></select>
								<div class="input-group-append" id="buscar_servicios_atenciones" style="display: none">				
									<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
								</div>
							</div>						  
							</div>					
						</div>

					</div>
					</div>

					<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
						Reporte
						</div>
						<div class="card-body">
							<div class="form-row">
							<div class="col-md-12 mb-3 scrollbar-div">
								<span id="reporte_consulta"></span>
							</div>																																	
							</div>							
						</div>
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
		include "../js/myjava_expediente_nutricion.php"; 		
		include "../js/select.php"; 	
		include "../js/functions.php"; 
		include "../js/myjava_cambiar_pass.php"; 		
	?>
	  
</body>
</html>