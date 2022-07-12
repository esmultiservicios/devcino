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
						<h2>REGISTRO POST-OPERATORIO</h2>
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
					<p><?php echo $consultaPostOperatorio['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $consultaPostOperatorio['fecha_nacimiento']; ?></p>					
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
					<p><?php echo $consultaPostOperatorio['postoperacion_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaPostOperatorio['telefono']; ?></p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consultaPostOperatorio['email']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaPostOperatorio['fecha']; ?></p>					
				</td>											
			</tr>			
		</table>
				
		<?php
			$table = '<table class="table">';
				while($registro_postoperatorio = $resultPostOperatorio->fetch_assoc()){
					$table = $table.'
						<tr>
							<td class="td" width="12.5%" colspan="3">
								<p><b>Fecha Consulta</b></p>					
							</td>
							<td class="td" width="12.5%" colspan="3">
							<p><b>'.$registro_postoperatorio['fecha'].'</b></p>					
							</td>							
						</tr>
						<tr>
							<td class="td" width="12.5%">
								<p>Talla</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$registro_postoperatorio['talla'].'</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>Peso Actual</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$registro_postoperatorio['peso_actual'].'</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>Peso Perdido</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$registro_postoperatorio['peso_perdido'].'</p>					
							</td>															
						</tr>	
						<tr>
							<td class="td" width="12.5%">
								<p>IMC Actual</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$registro_postoperatorio['talla'].'</p>					
							</td>	
							<td class="td" width="12.5%" colspan="2">
								<p>EWL</p>					
							</td>
							<td class="td" width="12.5%" colspan="2">
								<p>'.$registro_postoperatorio['talla'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Otros</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['otros'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Mejoría Enfermedades</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['mejoria'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Estado Actual</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['estado_actual'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Medicamentos que usa</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['medicamentos'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Hallazgos</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['hallazgos'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Comentarios</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['comentarios'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Plan</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['plan'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="6">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="6" align="center" valign="middle">
								<p><b>Servicio</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="6">
								<p>'.$registro_postoperatorio['servicio'].'</p>					
							</td>														
						</tr>																					
					';
				}	
			$table = $table.'</table>';	
			echo $table;
		?>
	</div>
</body>
</html>