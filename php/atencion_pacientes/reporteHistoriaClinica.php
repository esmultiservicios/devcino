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
						<h2>REPORTE HISTORIA CLÍNICA</h2>
						<h2><?php echo 'Profesional: '.$consultaHistoriaClinica['profesional']; ?></h2>										
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
					<p><?php echo $consultaHistoriaClinica['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p><?php echo $consultaHistoriaClinica['fecha_nacimiento']; ?></p>					
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
					<p><?php echo $consultaHistoriaClinica['clinico_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaHistoriaClinica['telefono']; ?></p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p><?php echo $consultaHistoriaClinica['email']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p><?php echo $consultaHistoriaClinica['fecha']; ?></p>					
				</td>											
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="12.5%">
					<p>Inicio Obecidad</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['inicio_obesidad']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Habito Alimenticio</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['habito_alimenticio']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Tipo Obecidad</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['tipo_obesidad']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Intentos Perdida peso</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['intentos_perdida_peso']; ?></p>					
				</td>																					
			</tr>

			<tr>
				<td class="td" width="12.5%">
					<p>Peso Maximo Alcansado</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['peso_maximo_alcansado']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Sedentarismo</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['sedentarismo']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Ejercicio</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['ejercicio_respuesta']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Erge</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_erge']; ?></p>					
				</td>																				
			</tr>				

			<tr>
				<td class="td" width="12.5%">
					<p>HTA</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_hta']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Higado Graso</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_higado_graso']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>SAOS</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_saos']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Articulares</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_articulares']; ?></p>					
				</td>																								
			</tr>

			<tr>
				<td class="td" width="12.5%">
					<p>Ovarios Poliquisticos</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_ovarios_poliquisticos']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Varices</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_varices']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Drogas</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_drogas']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Ant Fami Diabetes</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_ant_fami_diabetes']; ?></p>					
				</td>																								
			</tr>
			
			<tr>
				<td class="td" width="12.5%">
					<p>Ant Fami Obecidad</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_ant_fami_obesidad']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Ant Fami Gastrico</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_ant_fami_cancer_gastrico']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Enf Psiquiatricas</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_respuesta_ant_fami_psiquiatricas']; ?></p>					
				</td>																					
				<td class="td" width="12.5%">
					<p>DM</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_ant_dm']; ?></p>					
				</td>				
			</tr>
							
			<tr>
				<td class="td" width="12.5%">
					<p>Alergias</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_alergias']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Alcohol</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_alcohol']; ?></p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Tabaquismo</p>					
				</td>	
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_tabaquismo']; ?></p>					
				</td>
				<td class="td" width="12.5%">
					<p>Dislipidemia</p>					
				</td>
				<td class="td" width="12.5%">
					<p><?php echo $consultaHistoriaClinica['respuesta_dislipidemia']; ?></p>					
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
					<p><?php echo $consultaHistoriaClinica['cirugia_abdominal']; ?></p>				
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
					<p><?php echo $consultaHistoriaClinica['talla']; ?></p>					
				</td>
				<td class="td" width="25%">
					<p>Peso</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaHistoriaClinica['peso']." lbs"; ?></p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>IMC</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaHistoriaClinica['imc']; ?></p>					
				</td>
				<td class="td" width="25%">
					<p>Peso Ideal</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaHistoriaClinica['peso_ideal']." lbs"; ?></p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>Exceso de Peso</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p><?php echo $consultaHistoriaClinica['exceso_peso']." lbs"; ?></p>					
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
				<p><?php echo $consultaHistoriaClinica['diagnostico']; ?></p>			
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
					<p><?php echo $consultaHistoriaClinica['estudios_imagenes']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Referencia A</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaHistoriaClinica['referencia_a']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Recomendaciones Quirúrgicas</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaHistoriaClinica['recomendaciones']; ?></p>					
				</td>
			</tr>
			<tr>
				<td class="td" width="15%">
					<p>Presupuesto Estimado</p>					
				</td>
				<td class="td" width="85%">
					<p><?php echo $consultaHistoriaClinica['presupuesto']; ?></p>					
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
					<p><?php echo $consultaHistoriaClinica['observaciones']; ?></p>			
				</td>
			</tr>			
		</table>

		<!--Inicio Pre Operacion-->
		<?php
			$table = '<table class="table">';
				while($consultaPreoperatorio = $resultPreoperatorio->fetch_assoc()){
					$table = $table.'
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Pre Operación</b></p>					
							</td>							
						</tr>
						<tr>
							<td class="td" width="10%">
								<p>NCH</p>					
							</td>
							<td class="td" width="55%" colspan="7">
								<p>'.$consultaPreoperatorio['preoperacion_id'].'</p>					
							</td>
							</tr>						
						<tr>
							<td class="td" width="12.5%" colspan="4">
								<p><b>Fecha Consulta</b></p>					
							</td>
							<td class="td" width="12.5%" colspan="4">
								<p><b>'.$consultaPreoperatorio['fecha'].'</b></p>					
							</td>							
						</tr>
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
								<p>'.$consultaPreoperatorio['talla'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Peso Actual</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['peso_actual'].' lbs</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Peso Perdido</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['peso_perdido'].' lbs</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>IMC Actual</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['imc_actual'].'</p>					
							</td>																					
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p>Resultado de Examenes y Estudios de Imagenes Pre-OP</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="8" >
								<p>'.$consultaPreoperatorio['resultados'].'</p>					
							</td>
						</tr>	
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
								<p>'.$consultaPreoperatorio['psquiatria_visto'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Psicólogo</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['psicologia_visto'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Nutrición</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['nutricion_visto'].'</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>Medicina Interna</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaPreoperatorio['medicina_interna_visto'].'</p>					
							</td>																					
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p>Recomendaciones</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="8" >
								<p>'.$consultaPreoperatorio['recomendaciones'].'</p>					
							</td>
						</tr>	
						<tr>
							<td class="td" width="10%" colspan="4">
								<p>Fecha Cirugía</p>					
							</td>	
							<td class="td" width="90%" colspan="4">
								<p>'.$consultaPreoperatorio['fecha_cirugia'].'</p>					
							</td>	
						</tr>
						<tr>
							<td class="td" width="10%" colspan="4">
								<p>Tipo Cirugía</p>					
							</td>	
							<td class="td" width="90%" colspan="4">
								<p>'.$consultaPreoperatorio['tipo_cirugia'].'</p>					
							</td>	
						</tr>	
						<tr>
							<td class="td" width="10%" colspan="4">
								<p>Servicio</p>					
							</td>	
							<td class="td" width="90%" colspan="4">
							<p>'.$consultaPreoperatorio['servicio'].'</p>					
							</td>	
						</tr>																																														
					';
				}
			$table = $table.'</table>';	
			echo $table;
		?>	
		
		<!--Fin Pre Operacion-->

		<!--Inicio Nota Operatoria-->
		<?php
			$table = '<table class="table">';
				while($consultaNotaOperatoria = $resultNotaOperatoria->fetch_assoc()){
					$table = $table.'
						<tr>
							<td class="td" width="100%" colspan="11" align="center" valign="middle">
								<p><b>Nota Operatoria</b></p>					
							</td>							
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="5">
								<p><b>Fecha Consulta</b></p>					
							</td>
							<td class="td" width="12.5%" colspan="6">
								<p><b>'.$consultaNotaOperatoria['fecha'].'</b></p>					
							</td>							
						</tr>	
						<tr>
							<td class="td" width="10%">
								<p>NCH</p>					
							</td>
							<td class="td" colspan="10">
								<p>'.$consultaNotaOperatoria['notaoperacion_id'].'</p>					
							</td>						
						</tr>							
						<tr>
							<td class="td" colspan="11" align="center" valign="middle">
								<p>Antecedentes</p>					
							</td>										
						</tr>			
						<tr>
							<td class="td" width="12.5%">
								<p>Talla</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['talla'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Peso Actual</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['peso_actual'].' lbs</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Peso Perdido</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['peso_perdido'].' lbs</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>IMC Actual</p>					
							</td>	
							<td class="td" width="12.5%" colspan="4">
								<p>'.$consultaNotaOperatoria['imc_actual'].'</p>					
							</td>																					
						</tr>							
						<tr>
							<td class="td" width="100%" colspan="11" align="center" valign="middle">
								<p>Técnica</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="11">
								<p>'.$consultaNotaOperatoria['tecnica'].'</p>					
							</td>
						</tr>							
						<tr>
							<td class="td" width="10%" colspan="11" align="center" valign="middle">
								<p>Otros</p>					
							</td>										
						</tr>			
						<tr>
							<td class="td" width="12.5%">
								<p>Cirujano</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['cirujano'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Asistente</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['asistente'].' lbs</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Camara</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['camara'].' lbs</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>Anestesia</p>					
							</td>	
							<td class="td" width="12.5%" colspan="4">
								<p>'.$consultaNotaOperatoria['anestesia'].'</p>					
							</td>																					
						</tr>
						<tr>
							<td class="td" width="10%" colspan="2">
								<p>Antestesiologo</p>					
							</td>
							<td class="td" width="90%" colspan="9">
								<p>'.$consultaNotaOperatoria['anestesiologo'].'</p>					
							</td>																					
						</tr>						
						<tr>
							<td class="td" width="100%" align="center" valign="middle" colspan="11">
								<p>Otros</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="11">
								<p>'.$consultaNotaOperatoria['otros'].'</p>					
							</td>
						</tr>						
						<tr>
							<td class="td" width="15%" colspan="1">
								<p>Hallazgos Operativos</p>					
							</td>
							<td class="td" width="85%" colspan="10">
								<p>'.$consultaNotaOperatoria['hallazgos_operativos'].'</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="15%" colspan="1">
								<p>Descripción Operatoria</p>					
							</td>
							<td class="td" width="85%" colspan="10">
								<p>'.$consultaNotaOperatoria['descripcion_operativos'].'</p>					
							</td>
						</tr>						
						<tr>
							<td class="td" width="10%" colspan="11" align="center" valign="middle">
								<p>Otros Resultados</p>					
							</td>										
						</tr>			
						<tr>
							<td class="td" width="12.5%" colspan="4">
								<p>Prueba de Estanqueidad con azul de metileno</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['resultado_prueba'].'</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Dreno Blake</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['resultado_blake'].' lbs</p>					
							</td>
							<td class="td" width="12.5%">
								<p>Extracción de Piezas</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['resultado_extraccion'].' lbs</p>					
							</td>	
							<td class="td" width="12.5%">
								<p> Evacuo Neumoperitoneo</p>					
							</td>	
							<td class="td" width="12.5%">
								<p>'.$consultaNotaOperatoria['resultado_evacuo'].'</p>					
							</td>																					
						</tr>
						<tr>
							<td class="td" width="10%" colspan="2">
								<p>Cierro Piel</p>					
							</td>
							<td class="td" width="90%" colspan="9">
								<p>'.$consultaNotaOperatoria['resultado_cierro'].'</p>					
							</td>																					
						</tr>						
						<tr>
							<td class="td" width="15%" colspan="1">
								<p>Indicaciones</p>					
							</td>
							<td class="td" width="85%" colspan="10">
								<p>'.$consultaNotaOperatoria['indicaciones'].'</p>					
							</td>
						</tr>	
						
						<tr>
							<td class="td" width="100%" align="center" valign="middle" colspan="11"> 
								<p>Recomendaciones</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="11">
								<p>'.$consultaNotaOperatoria['recomendaciones'].'</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" align="center" valign="middle" colspan="11">
								<p>Comentarios</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="11">
								<p>'.$consultaNotaOperatoria['comentarios'].'</p>					
							</td>
						</tr>						
						<tr>
							<td class="td" width="100%" align="center" valign="middle" colspan="11">
								<p>Servicio</p>					
							</td>
						</tr>
						<tr>
							<td class="td" width="100%" colspan="11">
								<p>'.$consultaNotaOperatoria['servicio'].'</p>					
							</td>
						</tr>
					';
				}
			$table = $table.'</table>';	
			echo $table;
		?>	
		
		<!--Fin Nota Operatoria-->	
		
		<!--Inicio Post Operacion-->
		<?php
			$table = '<table class="table">';
				while($registro_postoperatorio = $resultPostOperatorio->fetch_assoc()){
					$table = $table.'
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Post Operacion</b></p>					
							</td>							
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="4">
								<p><b>Fecha Consulta</b></p>					
							</td>
							<td class="td" width="12.5%" colspan="4">
								<p><b>'.$registro_postoperatorio['fecha'].'</b></p>					
							</td>							
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="1">
								<p><b>NHC</b></p>					
							</td>
							<td class="td" width="12.5%" colspan="7">
								<p><b>'.$registro_postoperatorio['postoperacion_id'].'</b></p>					
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
							<td class="td" width="12.5%" colspan="3">
								<p>'.$registro_postoperatorio['peso_perdido'].'</p>					
							</td>															
						</tr>	
						<tr>
							<td class="td" width="12.5%">
								<p>IMC Actual</p>					
							</td>
							<td class="td" width="12.5%">
								<p>'.$registro_postoperatorio['imc_actual'].'</p>					
							</td>	
							<td class="td" width="12.5%" colspan="3">
								<p>EWL</p>					
							</td>
							<td class="td" width="12.5%" colspan="3">
								<p>'.$registro_postoperatorio['ewl'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Otros</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['otros'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Mejoría Enfermedades</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['mejoria'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Estado Actual</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['estado_actual'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Medicamentos que usa</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['medicamentos'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Hallazgos</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['hallazgos'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Comentarios</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['comentarios'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Plan</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['plan'].'</p>					
							</td>														
						</tr>
						<tr>
							<td class="td" width="12.5%" colspan="8">
								&nbsp;&nbsp;&nbsp;
							</td>													
						</tr>
						<tr>
							<td class="td" width="100%" colspan="8" align="center" valign="middle">
								<p><b>Servicio</b></p>					
							</td>														
						</tr>	
						<tr>
							<td class="td" width="100%" colspan="8">
								<p>'.$registro_postoperatorio['servicio'].'</p>					
							</td>														
						</tr>																					
					';
				}	
			$table = $table.'</table>';	
			echo $table;
		?>
		<!--Fin Post Operacion-->		
	</div>
</body>
</html>