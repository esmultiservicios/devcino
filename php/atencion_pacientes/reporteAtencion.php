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
					<p><?php echo $consultaAtencion['clinico_id']; ?></p>					
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
				<td class="td" width="12.5%">
					<p>Inicio Obecidad</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['inicio_obesidad']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Habito Alimenticio</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['habito_alimenticio']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Tipo Obecidad</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['tipo_obesidad']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Intentos Perdida peso</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['intentos_perdida_peso']; ?></p>					
				</td>																					
			</tr>

			<tr>
				<td class="td" width="12.5%">
					<p>Peso Maximo Alcansado</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['peso_maximo_alcansado']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Sedentarismo</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['sedentarismo']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Ejercicio</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['ejercicio_respuesta']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Erge</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_erge']; ?></p>					
				</td>																				
			</tr>				

			<tr>
				<td class="td" width="12.5%">
					<p>HTA</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_hta']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Higado Graso</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_higado_graso']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>SAOS</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_saos']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Articulares</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_articulares']; ?></p>					
				</td>																								
			</tr>

			<tr>
				<td class="td" width="12.5%">
					<p>Ovarios Poliquisticos</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_ovarios_poliquisticos']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Varices</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_varices']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Drogas</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_drogas']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Ant Fami Diabetes</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_ant_fami_diabetes']; ?></p>					
				</td>																								
			</tr>
			
			<tr>
				<td class="td" width="12.5%">
					<p>Ant Fami Obecidad</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_ant_fami_obesidad']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Ant Fami Gastrico</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_ant_fami_cancer_gastrico']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Enf Psiquiatricas</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_respuesta_ant_fami_psiquiatricas']; ?></p>					
				</td>																					
				<td class="td" width="12.5%">
					<p>DM</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_ant_dm']; ?></p>					
				</td>				
			</tr>
							
			<tr>
				<td class="td" width="12.5%">
					<p>Alergias</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_alergias']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Alcohol</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_alcohol']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Tabaquismo</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_tabaquismo']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Dislipidemia</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaAtencion['respuesta_dislipidemia']; ?></p>					
				</td>																									
			</tr>				
		</table>

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
				<p>Resultado de Examenes</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" >
					<p><?php echo $consultaAtencion['cirugia_abdominal']; ?></p>				
				</td>
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="25%"  colspan="8" align="center" valign="middle">
					<p>Examen Fisico</p>					
				</td>				
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>Talla</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaAtencion['talla']; ?></p>					
				</td>
				<td class="td" width="25%">
					<p>Peso</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaAtencion['peso']." lbs"; ?></p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>IMC</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaAtencion['imc']; ?></p>					
				</td>
				<td class="td" width="25%">
					<p>Peso Ideal</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaAtencion['peso_ideal']." lbs"; ?></p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>Exceso de Peso</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaAtencion['exceso_peso']." lbs"; ?></p>					
				</td>									
			</tr>												
		</table>
			
		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
				<p>Hallazgos Anormales al Examen Físico (Diagnostico)</p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" >
				<p><?php echo $consultaAtencion['diagnostico']; ?></p>			
				</td>
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="15%" colspan="2" align="center" valign="middle">
					<p>Examanes de Laboratorio</p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Estudios de Imágenes Solicitados</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaAtencion['estudios_imagenes']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Referencia A</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaAtencion['referencia_a']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Recomendaciones Quirúrgicas</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaAtencion['recomendaciones']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Presupuesto Estimado</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaAtencion['presupuesto']; ?></p>					
				</td>
			</tr>														
		</table>		

		<table class="table">
			<tr>
				<td class="td" width="100%" colspan="2" align="center" valign="middle">
					<p>Observaciones</p>				
				</td>
			</tr>
			<tr>
				<td class="td" width="100%" colspan="2" >						
					<p><?php echo $consultaAtencion['observaciones']; ?></p>			
				</td>
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p>Servicio</p>					
				</td>	
				<td class="td" width="90%">
				<p><?php echo $consultaAtencion['servicio']; ?></p>					
				</td>	
			</tr>		
		</table>		
	</div>
</body>
</html>