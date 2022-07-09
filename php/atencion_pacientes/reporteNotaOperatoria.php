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
						<h2>REGISTRO NOTA OPERATORIA</h2>
						<h2>DR. LENNYN ALVARENGA</h2>								
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
					<p><?php echo $consulta_registro['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $consulta_registro['fecha_nacimiento']; ?></p>					
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
					<p><?php echo $consulta_registro['notaoperacion_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consulta_registro['telefono']; ?></p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consulta_registro['email']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consulta_registro['fecha']; ?></p>					
				</td>											
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="10%" colspan="8" align="center" valign="middle">
					<p>Antecedentes</p>					
				</td>										
			</tr>			
			<tr>
				<td class="td" width="12.5%">
					<p>Talla</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['talla']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Peso Actual</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['peso_actual'].' lbs'; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Peso Perdido</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['peso_perdido'].' lbs'; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>IMC Actual</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['imc_actual']; ?></p>					
				</td>																					
			</tr>	
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="100%" align="center" valign="middle">
					<p>Técnica</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%">
					<p><?php echo $consulta_registro['tecnica']; ?></p>					
				</td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="10%" colspan="8" align="center" valign="middle">
					<p>Otros</p>					
				</td>										
			</tr>			
			<tr>
				<td class="td" width="12.5%">
					<p>Cirujano</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['cirujano']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Asistente</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['asistente'].' lbs'; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Camara</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['camara'].' lbs'; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Anestesia</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['anestesia']; ?></p>					
				</td>																					
			</tr>
			<tr>
				<td class="td" width="10%" colspan="2">
					<p>Antestesiologo</p>					
				</td>
				<td class="td" width="90%" colspan="6">
					<p><?php echo $consulta_registro['anestesiologo']; ?></p>					
				</td>																					
			</tr>				
		</table>		

		<table class="table">
			<tr>
				<td class="td" width="100%" align="center" valign="middle">
					<p>Otros</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%">
					<p><?php echo $consulta_registro['otros']; ?></p>					
				</td>
			</tr>
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="15%">
					<p>Hallazgos Operativos</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consulta_registro['hallazgos_operativos']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Descripción Operatoria</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consulta_registro['descripcion_operativos']; ?></p>					
				</td>
			</tr>			
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="10%" colspan="8" align="center" valign="middle">
					<p>Otros Resultados</p>					
				</td>										
			</tr>			
			<tr>
				<td class="td" width="12.5%">
					<p>Prueba de Estanqueidad con azul de metileno</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['resultado_prueba']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Dreno Blake</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['resultado_blake'].' lbs'; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Extracción de Piezas</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['resultado_extraccion'].' lbs'; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p> Evacuo Neumoperitoneo</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consulta_registro['resultado_evacuo']; ?></p>					
				</td>																					
			</tr>
			<tr>
				<td class="td" width="10%" colspan="2">
					<p>Cierro Piel</p>					
				</td>
				<td class="td" width="90%" colspan="6">
					<p><?php echo $consulta_registro['resultado_cierro']; ?></p>					
				</td>																					
			</tr>				
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="15%">
					<p>Indicaciones</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consulta_registro['indicaciones']; ?></p>					
				</td>
			</tr>		
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="100%" align="center" valign="middle">
					<p>Recomendaciones</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%">
					<p><?php echo $consulta_registro['recomendaciones']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" align="center" valign="middle">
					<p>Comentarios</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%">
					<p><?php echo $consulta_registro['comentarios']; ?></p>					
				</td>
			</tr>			
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="100%" align="center" valign="middle">
					<p>Servicio</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%">
					<p><?php echo $consulta_registro['servicio']; ?></p>					
				</td>
			</tr>
		</table>
	</div>
</body>
</html>