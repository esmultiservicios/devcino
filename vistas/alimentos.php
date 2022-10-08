<?php
session_start(); 
include "../php/funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli(); 

$_SESSION['menu'] = "Alimentos";

$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);//HOSTNAME	
$fecha = date("Y-m-d H:i:s"); 
$comentario = mb_convert_case("Ingreso al Modulo de Registro de Alimentos", MB_CASE_TITLE, "UTF-8");

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
    <title>Registro de alimentos :: CIN-O</title>
	<?php include("script_css.php"); ?>  	
</head>
<body>
   <!--Ventanas Modales-->
   <!-- Small modal -->  
<!--INICIO MODAL-->
<!--INICIO MODAL BUSCAR PACIENTE-->
<div class="modal fade" id="modal_pacientes_alimentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Pacientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form id="formulario_pacientes_alimentos">		
				<div class="table-responsive">
					<table id="dataTablePacientesAlimentos" class="table table-striped table-condensed table-hover" style="width:100%">
						<thead align="center">
							<tr>
								<th>Seleecionar</th>
								<th>Nombre</th>				
							</tr>
						</thead>
					</table>  
				</div>			
			  </div>															  
			</form>
      </div>
    </div>
  </div>
</div>
<!--FIN MODAL BUSCAR PACIENTE-->
<!--FIN MODAL-->

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">
		<a class="navbar-brand" href="#"><a href="#"><img src="<?php echo SERVERURL; ?>img/logo.png" width="130" height="45" alt=""/></a></a>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      	   <ul class="navbar-nav ms-auto">
				<li class="nav-item">
				<a class="nav-link active" aria-current="page" href="#">Registro de Alimentos</a>
				</li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br><br><br>
<div class="container-fluid">
	<?php include("templates/alimentos.php"); ?>
	<br />
	<?php include("templates/footer.php"); ?>	
</div>

    <!-- add javascripts -->
	<?php 
		include "script.php"; 
		
		include "../js/myjava_alimentos.php"; 		
		include "../js/select.php"; 	
		include "../js/functions.php"; 		
	?>
			 
</body>
</html>