<html>
<head>
  <style>
	@import url('fonts/BrixSansRegular.css');
	@import url('fonts/Helvetica.css');

    @page { 
		margin: 20px 3px; 
		width: 100%;
	}

	#footer .page:after { 
		content: counter(page, upper-roman);
	}

	p, label, span{
		font-family: 'Helvetica';
		font-size: 8pt;
		word-wrap: break-word;
		margin: 0 !important;	
	}
	h2{
		font-family: 'Helvetica';
		font-size: 12pt;
		word-wrap: break-word;
		margin: 0 !important;	
	}
	#reporte_head, #factura_cliente, #factura_detalle{
		width: 100%;
		padding-left: 10px;
		padding-top: 10px;   
		padding-bottom: 10px;
	}
	.reporte_logo{
		width: 20%;
	}
	#logo{
		width: 40px;
		height:auto;
	}
	.info_empresa{
		width: 90%;
		text-align: center;
		padding-left: 70px;
		padding-top: 10px;   
		padding-bottom: 10px;		
	}
	.info_factura{
		width: 20%;
	}
	.info_reporte{
		width: 100%;
	}
	.table{
		width:100%; 
		margin: 15 !important;		
	}
	.table, .th, .td{
		border: 1px solid #000;
		border-spacing: 0;
		clear:both;
	}
    #footer .page:after { 
		content: counter(page, upper-roman);
	}	
  </style>
</head>
<body>
	<div id="content" style="page-break-before: auto;">
		<table id="reporte_head">
			<tr>
				<td class="reporte_logo">
					<div id="logo">
						<img src="<?php echo SERVERURL; ?>img/logo_factura.jpg" width="220px" height="80px">
					</div>
				</td>
				<td class="info_empresa">
					<div>
						<h2>PRIMERA CONSULTA</h2>
						<h2>EXPEDIENTE CLINICO</h2>	
						<h2><?php echo 'Profesional: '.$consultaAtencion['profesional']; ?></h2>									
					</div>
				</td>
				<td class="info_reporte">

				</td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Apellidos, Nombre</p>					
				</td>
				<td class="td" width="80%">
					<p><?php echo $consultaAtencion['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $consultaAtencion['fecha_nacimiento']; ?></p>					
				</td>
				<td class="td" width="20%">
					<p>
						Edad
					</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia; ?></p>					
				</td>												
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p>NCH</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consultaAtencion['atenciones_nutricion_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaAtencion['telefono']; ?></p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consultaAtencion['email']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaAtencion['fecha']; ?></p>					
				</td>											
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Motivo Consulta</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['motivo_consulta']; ?></p>				
				</td>
			</tr>			
			<tr>
				<td class="td" width="50%">
					<p>Fecha Consulta</p>					
				</td>				
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['fecha']; ?></p>					
				</td>																					
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Antecedentes Personales</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['ante_perso']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Antecedentes Familiares</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['ante_fam']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Alergias</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['alergias']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Adicciones</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['adicciones']; ?></p>				
				</td>
			</tr>	
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Niveles de Estres</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['niveles_estres']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Niveles de Actividad Física</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['niveles_actividad_fisica']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Intento Perdidad de Peso</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['intento_perdida_peso']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Antecedentes Quirurgicos</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['antecedentes_quirurgicos']; ?></p>				
				</td>
			</tr>					
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Observaciones</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['observaciones']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Diagnostico</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['diagnostico']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Indicaciones</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['indicaciones']; ?></p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Candidato a Bariatrica</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php 
						if($consultaAtencion['candidato_bariatrica'] == 1){
							echo 'Sí';
						}else{
							echo 'No';
						}					
					?></p>				
				</td>
			</tr>			
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Servicio</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2">
					<p><?php echo $consultaAtencion['servicio']; ?></p>				
				</td>
			</tr>						
		</table>
	</div>
</body>
</html>