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
						<h2>REGISTRO PRE-OPERATORIO</h2>
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
					<p><?php echo $consultaPreoperatorio['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $consultaPreoperatorio['fecha_nacimiento']; ?></p>					
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
					<p><?php echo $consultaPreoperatorio['preoperacion_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaPreoperatorio['telefono']; ?></p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consultaPreoperatorio['email']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaPreoperatorio['fecha']; ?></p>					
				</td>											
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="8" align="center" valign="middle">
					<p>Antecedentes</p>					
				</td>																				
			</tr>	
			<tr>
				<td class="td" width="12.5%">
					<p>Talla</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['talla']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Peso Actual</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['peso_actual'].' lbs'; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Peso Perdido</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['peso_perdido'].' lbs'; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>IMC Actual</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['imc_actual']; ?></p>					
				</td>																					
			</tr>					
		</table>

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Resultados de Examenes y Estudios de Imagenes Pre-OP</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" >
					<p><?php echo $consultaPreoperatorio['resultados']; ?></p>					
				</td>
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="8" align="center" valign="middle">
					<p>Visto Bueno</p>					
				</td>																				
			</tr>	
			<tr>
				<td class="td" width="12.5%">
					<p>Psiquiatra</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['psquiatria_visto']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Psicólogo</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['psicologia_visto']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Nutrición</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['nutricion_visto']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Medicina Interna</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaPreoperatorio['medicina_interna_visto']; ?></p>					
				</td>																					
			</tr>					
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Recomendaciones</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" >
					<p><?php echo $consultaPreoperatorio['recomendaciones']; ?></p>					
				</td>
			</tr>			
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p>Fecha Cirugía</p>					
				</td>	
				<td class="td" width="90%">
					<p><?php echo $consultaPreoperatorio['fecha_cirugia']; ?></p>					
				</td>	
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>Tipo Cirugía</p>					
				</td>	
				<td class="td" width="90%">
					<p><?php echo $consultaPreoperatorio['tipo_cirugia']; ?></p>					
				</td>	
			</tr>			
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p>Servicio</p>					
				</td>	
				<td class="td" width="90%">
				<p><?php echo $consultaPreoperatorio['servicio']; ?></p>					
				</td>	
			</tr>		
		</table>
	</div>
</body>
</html>