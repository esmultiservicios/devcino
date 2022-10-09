<?php
session_start(); 
include "../php/funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

if( isset($_SESSION['colaborador_id']) == false ){
   header('Location: login.php'); 
}    

$_SESSION['menu'] = "Atenciones Medicas";

if(isset($_SESSION['colaborador_id'])){
 $colaborador_id = $_SESSION['colaborador_id'];  
}else{
   $colaborador_id = "";
}

$type = $_SESSION['type'];

$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);//HOSTNAME	
$fecha = date("Y-m-d H:i:s"); 
$comentario = mb_convert_case("Ingreso al Modulo de Atenciones Medicas", MB_CASE_TITLE, "UTF-8");   

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
    <title>Atenciones Medicas :: <?php echo $empresa; ?></title>
	<?php include("script_css.php"); ?>		
</head>
<body>
   <!--Ventanas Modales-->

<!--INICIO MODAL-->   
  <?php include("templates/modals.php"); ?>
  
 <!--MODAL BUSCAR ATENCIONES-->
<div class="modal fade" id="buscar_atencion">
	<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Búsqueda de Atenciones</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div>
        <div class="modal-body">		
			<form class="FormularioAjax" id="formulario_buscarAtencion" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">			
				<div class="form-row">
					<div class="col-md-12 mb-3">
					  <input type="hidden" id="atencion_id" name="atencion_id" class="form-control" required="required">
					  <input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control" required="required">
					</div>				
				</div>
				<div class="form-row" id="grupo_expediente">
					<div class="col-md-12 mb-3">
					  <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por: Nombre, Apellido o Identidad" data-toggle="tooltip" data-placement="top" title="Búsqueda de Atenciones por: Nombre, Apellido o Identidad" class="form-control">
					</div>				
				</div>				
				<div class="form-row">
					<div class="col-md-12 mb-3">
					   <div class="registros overflow-auto" id="agrega_registros_busqueda"></div>
					</div>					
				</div>	
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center" id="pagination_busqueda"></ul>
						</nav>	
					</div>					
				</div>			
			</form>
        </div>		
		<div class="modal-footer">
			
		</div>			
      </div>
    </div>
</div>	
<!-- FIN MODAL BUSCAR ATENCIONES-->

  <?php include("modals/modals.php");?>	
<!--FIN MODAL-->

<!--MENU-->	  
	<?php include("templates/menu.php"); ?>
<!--FIN MENU--> 
	
<br><br><br>
<div class="container-fluid">
	<ol class="breadcrumb mt-2 mb-4">
		<li class="breadcrumb-item" id="acciones_atras"><a id="ancla_volver" class="breadcrumb-link" href="#">Atenciones Medicas</a></li>
		<li class="breadcrumb-item active" id="acciones_factura"><span id="label_acciones_factura"></span></li>
	</ol>
	
	<div id="main_facturacion">
    <form class="form-inline" id="form_main_atencion_nutricion_medica">
		<div class="form-group mr-1">
			<div class="input-group">				
				<div class="input-group-append">				
					<span class="input-group-text"><div class="sb-nav-link-icon"></div>Atención</span>
				</div>
				<select id="estado" name="estado" class="form-control" data-toggle="tooltip" data-placement="top" title="Atención">   				   		 
					<option value="">Seleccione</option>	         
				</select>	
			</div>		   
		</div>
		<div class="form-group mr-1">
			<div class="input-group">				
				<div class="input-group-append">				
					<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Inicial</span>
				</div>
				<input type="date" required="required" id="fecha_b" name="fecha_b" style="width: 159px;" value="<?php echo date ("Y-m-d");?>" class="form-control"/>
			</div>		   
		</div>	  
		<div class="form-group mr-1">
			<div class="input-group">				
				<div class="input-group-append">				
					<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fecha Final</span>
				</div>
				<input type="date" required="required" id="fecha_f" name="fecha_f" style="width: 159px;" value="<?php echo date ("Y-m-d");?>" class="form-control"/>
			</div>		   
		</div>
      <div class="form-group mr-1">
         <input type="text" placeholder="Buscar por: Expediente, Nombre o Identidad" data-toggle="tooltip" data-placement="top" title="Buscar por: Expediente, Nombre, Apellido o Identidad" id="bs_regis" autofocus class="form-control" size="40"/>
      </div>
	  <div class="form-group">
		<div class="dropdown show" data-toggle="tooltip" data-placement="top" title="Agregar Registro">
		  <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			 <i class="fas fa-plus-circle fa-lg"></i> Crear
		  </a>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
			<a class="dropdown-item" href="#" id="nuevoRegistro" data-toggle="tooltip" data-placement="top" title="Pacientes por Primera Vez">Expediente Clínico</a>
			<a class="dropdown-item" href="#" id="nuevoPreOperacion">Pre-Operatorio</a>	
			<a class="dropdown-item" href="#" id="nuevoNotaOperacion">Nota Operatoria</a>	
			<a class="dropdown-item" href="#" id="nuevoPostOperacion">Post-Operatorio</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#" id="transito_enviada">Transito Enviada</a>
			<a class="dropdown-item" href="#" id="transito_recibida">Transito Recibida</a>							
		  </div>
		</div>		  
	  </div>
      <div class="form-group mr-1">
	    <button class="btn btn-primary ml-1" type="submit" id="nueva_factura"><div class="sb-nav-link-icon"></div><i class="fas fa-file-invoice fa-lg"></i> Pre Factura</button>
      </div>	  
      <div class="form-group">
	    <button class="btn btn-success" type="submit" id="historial"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i> Buscar</button>
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

	<div id="main_atencion_nutricion" style="display: none;">
		<?php include("templates/atenciones_nutricion.php"); ?>	
	</div>		
	
	<?php include("templates/factura.php"); ?>
	<?php include("templates/footer.php"); ?>
	<?php include("templates/footer_facturas.php"); ?>	
</div>

    <!-- add javascripts -->
	<?php 
		include "script.php"; 
		
		include "../js/main.php"; 
		include "../js/invoice.php"; 	
		include "../js/myjava_atencion_medica_nutricion.php";		
		include "../js/select.php"; 	
		include "../js/functions.php"; 
		include "../js/myjava_cambiar_pass.php"; 		
	?>
	 
</body>
</html>