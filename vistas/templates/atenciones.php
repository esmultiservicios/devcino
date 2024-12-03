<div id="perfil_paciente">
   <b>PERFIL PACIENTE</b>
   <br/>
   <b><span id="perfil_nombre"><span></b>
</div>

<!--INICIO MENU TAB CONTENT-->
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link active" id="primera_consulta_tab" data-toggle="tab" href="#primera_consulta" role="tab" aria-controls="referencia_form1" aria-selected="false">1era Consulta</a>
	</li>  
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="preo_operatorio_tab" data-toggle="tab" href="#pre_operatorio" role="tab" aria-controls="pre_operatorio" aria-selected="false">Pre-operatorio</a>
	</li> 
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="nota_operatoria_consulta_tab" data-toggle="tab" href="#nota_operatoria" role="tab" aria-controls="post_operatorio" aria-selected="false">Nota Operatoria</a>
	</li> 	 	
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="post_consulta_tab" data-toggle="tab" href="#post_operatorio" role="tab" aria-controls="post_operatorio" aria-selected="false">Post-Operatoria</a>
	</li> 	 		
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="datos_personales_tab" data-toggle="tab" href="#datos_personales" role="tab" aria-controls="datos_personales" aria-selected="false">Datos Personales</a>
	</li> 
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="home-tab" data-toggle="tab" href="#home_form2" role="tab" aria-controls="home_form1" aria-selected="false">Historia Clínica</a>
	</li>
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="home-tab" data-toggle="tab" href="#home_form3_hc_nutricion" role="tab" aria-controls="home_form1" aria-selected="false">Historia Clínica Nutrición</a>
	</li>		
	<li class="nav-item waves-effect waves-light">
		<button class="btn btn-dark ml-2" type="submit" id="end_atencion"><div class="sb-nav-link-icon"></div><i class="fas fa-window-close"></i> Finalizar Atención</button>
	</li>			
</ul>
<!--FIN MENU TAB CONTENT-->

<!-- INICIO TAB CONTENT-->
<div class="tab-content" id="myTabContent">
	<!-- INICIO ANTECEDENTES-->
	<div class="tab-pane fade active show" id="primera_consulta" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">		
			<form class="FormularioAjax" id="formulario_atenciones" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">

				<div class="form-row">
					<button class="btn btn-danger ml-2" type="submit" id="report_prieravez"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
				</div>	

				<div class="form-row">
						<div class="col-md-12 mb-3">
						<input type="hidden" id="agenda_id" name="agenda_id" class="form-control">
						<input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control">	
						<input type="hidden" id="colaborador_id" name="colaborador_id" class="form-control">	
						<input type="hidden" id="servicio_id" name="servicio_id" class="form-control">
						<input type="hidden" id="edad_consulta" name="edad_consulta" class="form-control">	
						</div>				
					</div>	
					
					<div class="col-md-12 mb-3">
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Datos Generales
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="paciente_consulta">Paciente <span class="priority">*<span/></label>
									<input type="text" id="paciente_consulta" name="paciente_consulta" class="form-control"/>						  
								</div>
								<div class="col-md-3 mb-3">
									<label>Fecha de Registro <span class="priority">*<span/></label>
									<input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Edad</label>
									<input type="text" id="edad" name="edad" readonly class="form-control" value="0" />
								</div>						
							</div>
							<div class="form-row" id="fechaConsultaGrupo" style="display: none">
								<div class="col-md-3 mb-3">
									<label>Fecha Consulta</label>
									<input type="date" id="fecha_consulta" name="fecha_consulta" class="form-control"/>
								</div>						
							</div>							
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Antecedentes
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="col-md-3 mb-3">
								<label>Inicio Obesidad</label>
								<input type="text" id="inicio_obesidad" name="inicio_obesidad" class="form-control" maxlength="20" />
								</div>	
								<div class="col-md-3 mb-3">
								<label>Habito Alimenticio</label>
								<input type="text" id="habito_alimenticio" name="habito_alimenticio" class="form-control" maxlength="20" />
								</div>	
								<div class="col-md-3 mb-3">
								<label>Tipo Obesidad</label>
								<input type="text" id="tipo_obesidad" name="tipo_obesidad" class="form-control" maxlength="20" />
								</div>	
								<div class="col-md-3 mb-3">
								<label>Intentos de Perdida de Peso</label>
								<input type="text" id="intentos_perdida_peso" name="intentos_perdida_peso" class="form-control" maxlength="20" />
								</div>					
							</div>	
					
							<div class="form-row">	
								<div class="col-md-3 mb-3">
									<label>Peso Máximo Alcanzado</label>
									<div class="input-group mb-3">								
										<input type="number" id="peso_maximo_alcanzado" name="peso_maximo_alcanzado" class="form-control"/>
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>
								<div class="col-md-3 mb-3">
									<label>Peso Máximo Alcanzado</label>
									<div class="input-group mb-3">								
										<input type="text" id="peso_maximo_alcanzado_kg" name="peso_maximo_alcanzado_kg" class="form-control" value="0.00" readonly />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
										</div>
									</div>							  
								</div>							
								<div class="col-md-3 mb-3">
								<label>Sedentarismo</label>
								<input type="text" id="sedentarismo" name="sedentarismo" class="form-control" maxlength="20" />
								</div>								
							</div>

							<div class="form-row">							
								<div class="col-md-4">	
									<span class="question">Ejercicio</span>	
									<label class="switch">
										<input type="checkbox" id="ejercicio_activo" name="ejercicio_activo" value="1">
										<div class="slider round"></div>
									</label>
									<span class="question" id="label_ejercicio_activo"></span>				
								</div>																
							</div>
							<div class="form-row">	
								<div class="col-md-12 mb-3">
								<input type="text" id="ejercicio_respuesta" name="ejercicio_respuesta" placeholder="Ejercicio" class="form-control" maxlength="250" />
								</div>								
							</div>						
						</div>
						</div>
						
						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Antecedentes Patologicos
							</div>
							<div class="card-body">				  
								<div class="form-group custom-control custom-checkbox custom-control-inline">			  	
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Erge</label>
										<label class="switch">
											<input type="checkbox" id="erge_activo" name="erge_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_erge_activo"></span>				
									</div>
									<div class="col-md-3">	
										<label class="form-check-label" for="defaultCheck1">HTA&nbsp;</label>
										<label class="switch">
											<input type="checkbox" id="hta_activo" name="hta_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_hta_activo"></span>				
									</div>	
									<div class="col-md-4">		
										<label class="form-check-label" for="defaultCheck1">Higado Graso</label>
										<label class="switch">
											<input type="checkbox" id="higado_graso_activo" name="higado_graso_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_higado_graso_activo"></span>				
									</div>	
									
									<div class="col-md-3">	
										<label class="form-check-label" for="defaultCheck1">SAOS</label>
										<label class="switch">
											<input type="checkbox" id="saos_activo" name="saos_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_saos_activo"></span>				
									</div>								  							
									<div class="col-md-4">	
										<label class="form-check-label" for="defaultCheck1">Hipotiroidismo&nbsp;</label>
										<label class="switch">
											<input type="checkbox" id="hipotiroidismo_activo" name="hipotiroidismo_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_hipotiroidismo_activo"></span>				
									</div>	
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Articulares</label>
										<label class="switch" data-toggle="tooltip" data-placement="top" title="Problemas Articulares">
											<input type="checkbox" id="articulares_activo" name="articulares_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_articulares_activo"></span>				
									</div>								
								</div>	
								<br/>
								<div class="form-row">	
									<div class="col-md-2 mb-3">
										<input type="text" id="erge_respuesta" name="erge_respuesta" placeholder="Erge" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="hta_respuesta" name="hta_respuesta" placeholder="HTA" class="form-control" maxlength="250" />
									</div>									
									<div class="col-md-2 mb-3">
										<input type="text" id="higado_graso_respuesta" name="higado_graso_respuesta" placeholder="Higado Graso" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="saos_respuesta" name="saos_respuesta" placeholder="SAOS" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="hipotiroidismo_respuesta" name="hipotiroidismo_respuesta" placeholder="Hipotiroidismo" class="form-control" maxlength="250" />
									</div>									
									<div class="col-md-2 mb-3">
										<input type="text" id="articulares_respuesta" name="articulares_respuesta" placeholder="Articulares" class="form-control" maxlength="250" />
									</div>																
								</div>	
								<br/>							
								<div class="form-group custom-control custom-checkbox custom-control-inline">													
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Ovarios Poliquisticos</label>
										<label class="switch">
											<input type="checkbox" id="ovarios_poliquisticos_activo" name="ovarios_poliquisticos_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_ovarios_poliquisticos_activo"></span>				
									</div>	
									<div class="col-md-2">		
										<label class="form-check-label" for="defaultCheck1">&nbsp;&nbsp;Varices&nbsp;&nbsp;&nbsp;</label>
										<label class="switch">
											<input type="checkbox" id="varices_activo" name="varices_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_varices_activo"></span>				
									</div>	
									<div class="col-md-2">		
										<label class="form-check-label" for="defaultCheck1">Drogas</label>
										<label class="switch">
											<input type="checkbox" id="drogas_activo" name="drogas_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_drogas_activo"></span>				
									</div>	
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Ant Fami Diabetes&nbsp;</label>
										<label class="switch">
											<input type="checkbox" id="antecedentes_fami_diabetes_activo" name="antecedentes_fami_diabetes_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_antecedentes_fami_diabetes_activo"></span>				
									</div>							
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Ant Fami Obesidad</label>
										<label class="switch">
											<input type="checkbox" id="antecedentes_fami_Obesidad_activo" name="antecedentes_fami_Obesidad_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_antecedentes_fami_Obesidad_activo"></span>				
									</div>
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Ant Fami Gastrico</label>
										<label class="switch">
											<input type="checkbox" id="antecedentes_fami_cancer_gastrico_activo" name="antecedentes_fami_cancer_gastrico_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_antecedentes_fami_cancer_gastrico_activo"></span>				
									</div>																								
								</div>
								<br/>
								<div class="form-row">	
									<div class="col-md-2 mb-3">
										<input type="text" id="ovarios_respuesta" name="ovarios_respuesta" placeholder="Ovarios" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="varices_respuesta" name="varices_respuesta" placeholder="Varices" class="form-control" maxlength="250" />
									</div>									
									<div class="col-md-2 mb-3">
										<input type="text" id="drogas_respuesta" name="drogas_respuesta" placeholder="Drogas" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="ant_fam_respuesta" name="ant_fam_respuesta" placeholder="Ant Fami Diabetes" class="form-control" maxlength="250" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="ant_fam_obecidad_respuesta" name="ant_fam_obecidad_respuesta" placeholder="Ant Fami Obesidad" class="form-control" maxlength="250" />
									</div>									
									<div class="col-md-2 mb-3">
										<input type="text" id="ant_fam_gastrico_respuesta" name="ant_fam_gastrico_respuesta" placeholder="Ant Fami Ca Gastrico" class="form-control" maxlength="250" />
									</div>																
								</div>	
								<br/>
								<div class="form-group custom-control custom-checkbox custom-control-inline">												
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">Enf Psiquiatricas</label>
										<label class="switch">
											<input type="checkbox" id="antecedentes_fami_psiquiatricas_activo" name="antecedentes_fami_psiquiatricas_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_antecedentes_fami_psiquiatricas_activo"></span>				
									</div>	
									<div class="col-md-3">		
										<label class="form-check-label" for="defaultCheck1">DM</label>
										<label class="switch">
											<input type="checkbox" id="antecedentes_dm_activo" name="antecedentes_dm_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_antecedentes_dm_activo"></span>				
									</div>
									<div class="col-md-3">	
										<label class="form-check-label" for="defaultCheck1">Alergias</label>
										<label class="switch">
											<input type="checkbox" id="alergias_activo" name="alergias_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_alergias_activo"></span>				
									</div>	
									<div class="col-md-3">	
										<label class="form-check-label" for="defaultCheck1">Alcohol</label>
										<label class="switch">
											<input type="checkbox" id="alcohol_activo" name="alcohol_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_alcohol_activo"></span>				
									</div>	
									<div class="col-md-3">	
										<label class="form-check-label" for="defaultCheck1">Tabaquismo</label>
										<label class="switch">
											<input type="checkbox" id="tabaquismo_activo" name="tabaquismo_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_tabaquismo_activo"></span>				
									</div>	
									<div class="col-md-3 mb-3">
										<label class="form-check-label" for="defaultCheck1">Dislipidemia</label>
										<label class="switch">
											<input type="checkbox" id="dislipidemia_activo" name="dislipidemia_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_dislipidemia_activo"></span>	
									</div>																									
								</div>			

								<div class="form-row">	
									<div class="col-md-2 mb-3">
										<input type="text" id="enf_psiquiatricas_respuesta" name="enf_psiquiatricas_respuesta" placeholder="Enf Psiquiatricas" class="form-control" maxlength="50" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="dm_respuesta" name="dm_respuesta" placeholder="DM" class="form-control" maxlength="50" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="alergias_respuesta" name="alergias_respuesta" placeholder="Alergias" class="form-control" maxlength="50" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="alcohol_respuesta" name="alcohol_respuesta" placeholder="Alcohol" class="form-control" maxlength="50" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="tabaquismo_respuesta" name="tabaquismo_respuesta" placeholder="Tabaquismo" class="form-control" maxlength="50" />
									</div>	
									<div class="col-md-2 mb-3">
										<input type="text" id="dislipidemia_respuesta" name="dislipidemia_respuesta" placeholder="Dislipidemia" class="form-control" maxlength="50" />
									</div>																
								</div>						
								
								<div class="form-row">						
									<div class="col-md-12 mb-3">
									<label>Otros</label>
									<input type="text" id="otros" name="otros" class="form-control" maxlength="100" />
									</div>					
								</div>	

							</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Cirugía Abdominales
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<div class="input-group">
									<textarea id="cirugia_abdominal_expediente" name="cirugia_abdominal_expediente" placeholder="Resultado de Examenes" class="form-control" maxlength="1000" rows="8"></textarea>	
									<div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_cirugia_abdominal_expediente_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_cirugia_abdominal_expediente_stop"></i>
										</span>
									</div>								  
									</div>	
									<p id="charNum_cirugia_abdominal_expediente">1000 Caracteres</p>
								</div>						
							</div>
						</div>
						</div>	

							<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Examen Físico
							</div>
							<div class="card-body">
								<div class="form-row">						
									<div class="col-md-3 mb-3">
									<label>Talla</label>
									<div class="input-group mb-3">								
										<input type="number" id="talla" name="talla" class="form-control" maxlength="20" step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>
										</div>
									</div>								  
									</div>
									<div class="col-md-2 mb-3">
										<label>Peso</label>
										<div class="input-group mb-3">								
											<input type="number" id="peso" name="peso" class="form-control" step="0.01"/>
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
											</div>
										</div>							  
									</div>
									<div class="col-md-2 mb-3">
										<label>Peso</label>
										<div class="input-group mb-3">								
											<input type="text" id="peso_kg" name="peso_kg" class="form-control" value="0.00" readonly />
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
											</div>
										</div>							  
									</div>	
									<div class="col-md-3 mb-3">
									<label>IMC</label>
									<input type="number" id="imc" name="imc" class="form-control" maxlength="20" readonly step="0.01" value="0.0" />
									</div>					
								</div>
								<div class="form-row">	
									<div class="col-md-2 mb-3">
										<label>Peso Ideal</label>
										<div class="input-group mb-3">								
											<input type="number" id="peso_ideal" name="peso_ideal" class="form-control" step="0.01"/>
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
											</div>
										</div>							  
									</div>
									<div class="col-md-2 mb-3">
										<label>Peso Ideal</label>
										<div class="input-group mb-3">								
											<input type="number" id="peso_ideal_kg" name="peso_ideal_kg" class="form-control" value="0.00" readonly step="0.01" />
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
											</div>
										</div>							  
									</div>
									
									<div class="col-md-2 mb-3">
										<label>Exceso de Peso</label>
										<div class="input-group mb-3">								
											<input type="number" id="exceso_peso" name="exceso_peso" class="form-control" step="0.01"/>
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
											</div>
										</div>							  
									</div>
									<div class="col-md-2 mb-3">
										<label>Exceso de Peso</label>
										<div class="input-group mb-3">								
											<input type="number" id="exceso_peso_kg" name="exceso_peso_kg" class="form-control" value="0.00" readonly step="0.01" />
											<div class="input-group-append">	
												<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
											</div>
										</div>							  
									</div>							
								</div>							
							</div>
							</div>						  
						
							<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Hallazgos Anormales al Examen Físico
							</div>
							<div class="card-body">
								<div class="form-row">						
									<div class="col-md-12 mb-3">
										<div class="input-group">
											<textarea id="diagnostico" name="diagnostico" placeholder="Diagnóstico" class="form-control" maxlength="3000" rows="8"></textarea>	
											<div class="input-group-prepend">						  
											<span class="input-group-text">
												<i class="btn btn-outline-success fas fa-microphone-alt" id="search_diagnostico_start"></i>
												<i class="btn btn-outline-success fas fa-microphone-slash" id="search_diagnostico_stop"></i>
											</span>
											</div>								  
										</div>	
										<p id="charNum_diagnostico">3000 Caracteres</p>								  
									</div>						
								</div>								
							</div>
							</div>	

							<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Examen de Laboratorio Solicitados
							</div>
							<div class="card-body">
								<div class="form-row">						
									<div class="col-md-12 mb-3">
									<label>Estudios de Imágenes Solicitados</label>
									<input type="text" id="estudios_imagenes" name="estudios_imagenes" class="form-control" maxlength="150" />
									</div>						
								</div>	
								<div class="form-row">						
									<div class="col-md-12 mb-3">
									<label>Referencia A</label>
									<input type="text" id="referencia_a" name="referencia_a" class="form-control" maxlength="150" />
									</div>						
								</div>	
								<div class="form-row">						
									<div class="col-md-12 mb-3">
									<label>Recomendaciones Quirúrgicas</label>
									<input type="text" id="recomendaciones_quirurgicas" name="recomendaciones_quirurgicas" class="form-control" maxlength="150" />
									</div>						
								</div>		
								<div class="form-row">						
									<div class="col-md-12 mb-3">
									<label>Presupuesto Estimado</label>
									<input type="text" id="presupuesto" name="presupuesto" class="form-control" maxlength="150" />
									</div>						
								</div>									
							</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
						Observaciones
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="expe_observaciones" name="expe_observaciones" placeholder="Observaciones" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_expe_observaciones_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_expe_observaciones_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_expe_observaciones">2000 Caracteres</p>			
							</div>	
						</div>
						</div>						

						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								ARCHIVOS
							</div>
							<div class="card-body">
								<div class="form-row clinicare-size-450">
									<div class="col-md-10 mb-3">
										<input type="file" class="form-control" id="files" name="files[]" multiple accept=".jpg, .png, .pdf"/>
									</div>
									<div class="col-md-2 mb-3">
									<button class="btn btn-success ml-2" type="submit" id="btn_actualizar" form="formulario_atenciones"><div class="sb-nav-link-icon"></div><i class="fas fa-sync-alt"></i> Actualizar</button>
									</div>										
									<div class="col-md-12 mb-3">
										<div class="modal-title" id="mostrar_datos"></div>
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
									<div class="col-md-6 mb-3">
									<label for="expedoente">Servicio <span class="priority">*<span/></label>
									<div class="input-group mb-3">
										<select id="atenciones_servicio_id" name="atenciones_servicio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes" required="required"></select>
										<div class="input-group-append" id="buscar_servicios_atenciones" style="display: none">				
											<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
										</div>
									</div>						  
									</div>					
								</div>							
							</div>
						</div>	

					</div>	
					<div class="RespuestaAjax"></div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" type="submit" id="reg_atencion" form="formulario_atenciones"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="btn btn-warning ml-2" type="submit" id="edi_atencion" form="formulario_atenciones"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>
		</div>	
	</div>
	<!-- FIN PRIMERA CONSULTA-->  

	<!-- INICIO PREOPERATORIO-->
	<div class="tab-pane fade" id="pre_operatorio" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formularioAtencionesPreoperatorio" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
					<div class="form-row">
						<button class="btn btn-danger ml-2" type="submit" id="report_preoperatorio"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<input type="hidden" id="agenda_id" name="agenda_id" class="form-control">
							<input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control">	
							<input type="hidden" id="colaborador_id" name="colaborador_id" class="form-control">	
							<input type="hidden" id="servicio_id" name="servicio_id" class="form-control">
							<input type="hidden" id="pre_edad_consulta" name="pre_edad_consulta" class="form-control">
						</div>				
					</div>	
					
					<div class="col-md-12 mb-3">
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Datos Generales
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="pre_paciente_consulta">Paciente <span class="priority">*<span/></label>
									<input type="text" id="pre_paciente_consulta" name="pre_paciente_consulta" class="form-control"/>						  
								</div>
								<div class="col-md-3 mb-3">
									<label>Fecha de Registro <span class="priority">*<span/></label>
									<input type="date" id="pre_fecha" name="pre_fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Edad</label>
									<input type="text" id="pre_edad" name="pre_edad" readonly class="form-control" value="0" />
								</div>						
							</div>
							<div class="form-row" id="fechaConsultaGrupo" style="display: none">
								<div class="col-md-3 mb-3">
									<label>Fecha Consulta</label>
									<input type="date" id="fecha_consulta" name="fecha_consulta" class="form-control"/>
								</div>						
							</div>								
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Antecedentes
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="col-md-3 mb-3">
								<label>Talla</label>							  
								<div class="input-group mb-3">								
									<input type="number" id="pre_talla" name="pre_talla" class="form-control" step="0.01" readonly />
									<div class="input-group-append">	
										<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>
									</div>
								</div>							  
								</div>	
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="text" id="pre_peso_actual" name="pre_peso_actual" class="form-control" step="0.01"/>
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="number" id="pre_peso_actual_kg" name="pre_peso_actual_kg" class="form-control" value="0.00" readonly />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
										</div>
									</div>							  
								</div>	
								<div class="col-md-2 mb-3">
									<label>Peso Perdido</label>
									<div class="input-group mb-3">								
										<input type="number" id="pre_peso_perdido" name="pre_peso_perdido" class="form-control" value="0.00" readonly step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>															
								<div class="col-md-2 mb-3">
								<label>IMC Actual</label>
								<input type="number" id="pre_imc_actual" name="pre_imc_actual" class="form-control" readonly value="0.0" />
								</div>													
							</div>	
						</div>
						</div>
						
						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Resultados Examenes y Estudios de Imagenes Pre-OP
							</div>
							<div class="card-body">				  
								<div class="input-group">
								<textarea id="pre_resultados_examenes" name="pre_resultados_examenes" placeholder="Resultado de Examenes" class="form-control" maxlength="3000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt fa-lg" id="search_pre_resultados_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash fa-lg" id="search_pre_resultados_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_pre_resultados">3000 Caracteres</p>
							</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Visto Bueno
						</div>
						<div class="card-body">
							<div class="form-group custom-control custom-checkbox custom-control-inline">
								<div class="col-md-4">		
									<label class="form-check-label" for="defaultCheck1">Psiquiatra</label>
									<label class="switch">
										<input type="checkbox" id="psiquiatra_activo" name="psiquiatra_activo" value="1">
										<div class="slider round"></div>
									</label>
									<span class="question mb-2" id="label_psiquiatra_activo"></span>				
								</div>							
								<div class="col-md-4">		
									<label class="form-check-label" for="defaultCheck1">Psicólogo</label>
									<label class="switch">
										<input type="checkbox" id="psicologo_activo" name="psicologo_activo" value="1">
										<div class="slider round"></div>
									</label>
									<span class="question mb-2" id="label_psicologo_activo"></span>				
								</div>							
								<div class="col-md-4">		
									<label class="form-check-label" for="defaultCheck1">Nutrición</label>
									<label class="switch">
										<input type="checkbox" id="nutricion_activo" name="nutricion_activo" value="1">
										<div class="slider round"></div>
									</label>
									<span class="question mb-2" id=""></span>				
								</div>	
								<div class="col-md-4">		
									<label class="form-check-label" for="defaultCheck1">Medicina Interna</label>
									<label class="switch">
										<input type="checkbox" id="medicina_interna_activo" name="medicina_interna_activo" value="1">
										<div class="slider round"></div>
									</label>
									<span class="question mb-2" id="label_medicina_interna_activo"></span>				
								</div>								
							</div>							
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Recomendaciones
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="pre_recomendaciones" name="pre_recomendaciones" placeholder="Recomendaciones" class="form-control" maxlength="3000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt fa-lg" id="search_pre_recomendaciones_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash fa-lg" id="search_pre_recomendaciones_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_pre_recomendaciones">3000 Caracteres</p>			
							</div>
							<div class="form-row">
								<div class="col-md-4">		
								<label>Cirugía Fecha <span class="priority">*<span/></label>
								<input type="date" id="pre_fecha_cirugia" name="pre_fecha_cirugia" value="<?php echo date('Y-m-d'); ?>" class="form-control" required/>			
								</div>
								<div class="col-md-8">		
								<label>Tipo Cirugía</label>
								<input type="text" id="pre_tipo_cirugia" name="pre_tipo_cirugia" class="form-control" maxlength="250"/>			
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
								<div class="col-md-6 mb-3">
								<label for="expedoente">Servicio <span class="priority">*<span/></label>
								<div class="input-group mb-3">
									<select id="servicio_preoperatorio_id" name="servicio_preoperatorio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes"></select>
									<div class="input-group-append" id="buscar_servicios_preoperatorio_id" style="display: none">				
										<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
									</div>
								</div>						  
								</div>					
							</div>
						</div>
						</div>					
					</div>	
					<div class="RespuestaAjax"></div>
				</form>			
			</div>
		<div class="modal-footer">
				<button class="btn btn-primary ml-2" type="submit" id="reg_pre" form="formularioAtencionesPreoperatorio"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
				<button class="btn btn-warning ml-2" type="submit" id="edi_pre" form="formularioAtencionesPreoperatorio"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>
		</div>	
	</div>
	<!-- FIN PREOPERATORIO-->  	

	<!-- INICIO NOTA OPERATORIA-->
	<div class="tab-pane fade" id="nota_operatoria" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">			
			<form class="FormularioAjax" id="formularioAtencionesNotaOperatoria" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
					<div class="form-row">
						<button class="btn btn-danger ml-2" type="submit" id="report_notaoperatoria"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
						<input type="hidden" id="agenda_id" name="agenda_id" class="form-control">
						<input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control">	
						<input type="hidden" id="colaborador_id" name="colaborador_id" class="form-control">	
						<input type="hidden" id="servicio_id" name="servicio_id" class="form-control">
						<input type="hidden" id="nota_edad_consulta" name="nota_edad_consulta" class="form-control">	
						</div>				
					</div>	
					
					<div class="col-md-12 mb-3">
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Datos Generales
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-6 mb-3">
									<label for="nota_paciente_consulta">Paciente <span class="priority">*<span/></label>
									<input type="text" id="nota_paciente_consulta" name="nota_paciente_consulta" class="form-control"/>					  
								</div>
								<div class="col-md-3 mb-3">
									<label>Fecha de Registro <span class="priority">*<span/></label>
									<input type="date" id="nota_fecha" name="nota_fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Edad</label>
									<input type="text" id="nota_edad" name="nota_edad" readonly class="form-control" value="0" />
								</div>																
							</div>
							<div class="form-row" id="fechaConsultaGrupo" style="display: none">
									<div class="col-md-3 mb-3">
										<label>Fecha Consulta</label>
										<input type="date" id="fecha_consulta" name="fecha_consulta" class="form-control"/>
									</div>						
							</div>								
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Antecedentes
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="col-md-3 mb-3">
								<label>Talla</label>							  
								<div class="input-group mb-3">								
									<input type="number" id="nota_talla" name="nota_talla" class="form-control" step="0.01" readonly />
									<div class="input-group-append">	
										<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>
									</div>
								</div>							  
								</div>	
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="number" id="nota_peso_actual" name="nota_peso_actual" class="form-control" step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="number" id="nota_peso_actual_kg" name="nota_peso_actual_kg" class="form-control" value="0.00" readonly step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
										</div>
									</div>							  
								</div>
								<div class="col-md-2 mb-3">
									<label>Peso Perdido</label>
									<div class="input-group mb-3">								
										<input type="number" id="nota_peso_perdido" name="nota_peso_perdido" class="form-control" value="0.00" readonly step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>									
								<div class="col-md-2 mb-3">
								<label>IMC Actual</label>
								<input type="number" id="nota_imc_actual" name="nota_imc_actual" class="form-control" readonly step="0.01" value="0.0" />
								</div>													
							</div>	
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Técnica
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="nota_tecnica" name="nota_tecnica" placeholder="Técnica" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_tecnica_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_tecnica_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_nota_tecnica">2000 Caracteres</p>			
							</div>	
						</div>
						</div>

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
						Otros
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="col-md-3 mb-3">
									<label>Cirujano</label>
									<input type="text" id="nota_cirujano" name="nota_cirujano" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Asistente</label>
									<input type="text" id="nota_asistente" name="nota_asistente" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Camara</label>
									<input type="text" id="nota_camara" name="nota_camara" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
									<label>Anestesia</label>
									<input type="text" id="nota_anestesia" name="nota_anestesia" class="form-control"/>
								</div>								
							</div>	
							<div class="form-row">						
								<div class="col-md-3 mb-3">
									<label>Anestesiólogo</label>
									<input type="text" id="nota_anestesiologo" name="nota_anestesiologo" class="form-control"/>
								</div>								
							</div>
						</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Otros 
						</div>
						<div class="card-body">					
							<div class="form-row">						
								<div class="input-group">
									<textarea id="nota_otros" name="nota_otros" placeholder="Otros" class="form-control" maxlength="2000" rows="8"></textarea>	
									<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_otros_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_otros_stop"></i>
									</span>
									</div>								  
								</div>	
								<p id="charNum_nota_otros">2000 Caracteres</p>			
							</div>	
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Hallazgos Operativos 
						</div>
						<div class="card-body">
							<div class="form-row">	
								<label>Plantilla Hallazgos Operativos</label>					
								<div class="input-group mb-3">
								<select id="plantilla_notas_hallazgos_operativos" name="plantilla_notas_hallazgos_operativos" class="custom-select" data-toggle="tooltip" data-placement="top" title="Plantilla Hallazgos Operativos">
										<option value="">Seleccione</option>						  
								</select>
								<div class="input-group-append" id="buscar_plantilla_notas_hallazgos_operativos" style="display: none">				
									<a data-toggle="modal" href="#" class="btn btn-outline-success" id="servicio_boton"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
								</div>
								</div>						
							</div>						
							<div class="form-row">						
								<div class="input-group">
									<textarea id="nota_hallazgos_operativos" name="nota_hallazgos_operativos" placeholder="Hallazgos Operativos" class="form-control" maxlength="2000" rows="8"></textarea>	
									<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_hallazgos_operativos_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_hallazgos_operativos_stop"></i>
									</span>
									</div>								  
								</div>	
								<p id="charNum_nota_hallazgos_operativos">2000 Caracteres</p>			
							</div>	
						</div>
						</div>	
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Descripción Operatoria 
						</div>
						<div class="card-body">
							<div class="form-row">	
								<label>Plantilla Descripción Operatoria</label>					
								<div class="input-group mb-3">
								<select id="plantilla_notas_descripcion_operativa" name="plantilla_notas_descripcion_operativa" class="custom-select" data-toggle="tooltip" data-placement="top" title="Plantilla Descripción Operatoria">
										<option value="">Seleccione</option>						  
								</select>
								<div class="input-group-append" id="buscar_plantilla_notas_descripcion_operativa" style="display: none">				
									<a data-toggle="modal" href="#" class="btn btn-outline-success" id="servicio_boton"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
								</div>
								</div>						
							</div>					  
							<div class="form-row">						
								<div class="input-group">
									<textarea id="nota_descripcion_operatoria" name="nota_descripcion_operatoria" placeholder="Descripción Operatoria" class="form-control" maxlength="2000" rows="8"></textarea>	
									<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_descripcion_operatoria_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_descripcion_operatoria_stop"></i>
									</span>
									</div>								  
								</div>	
								<p id="charNum_nota_descripcion_operatoria">2000 Caracteres</p>			
							</div>	
						</div>
						</div>	

						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Otros Resultados
							</div>
							<div class="card-body">
								<div class="form-group custom-control custom-checkbox custom-control-inline">
									<div class="col-md-9">		
										<label class="form-check-label" for="defaultCheck1">Prueba de Estanqueidad con azul de metileno</label>
										<label class="switch">
											<input type="checkbox" id="nota_prueba_metileno_activo" name="nota_prueba_metileno_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_nota_prueba_metileno_activo"></span>				
									</div>							
									<div class="col-md-6">		
										<label class="form-check-label" for="defaultCheck1">Dreno Blake</label>
										<label class="switch">
											<input type="checkbox" id="nota_dreno_blake_activo" name="nota_dreno_blake_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_nota_dreno_blake_activo"></span>				
									</div>															
								</div>		
								<div class="form-group custom-control custom-checkbox custom-control-inline">						
									<div class="col-md-9">		
										<label class="form-check-label" for="defaultCheck1">Extracción de Piezas</label>
										<label class="switch">
											<input type="checkbox" id="nota_extraccion_activo" name="nota_extraccion_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_nota_extraccion_activo"></span>				
									</div>	
									<div class="col-md-12">		
										<label class="form-check-label" for="defaultCheck1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Evacuo Neumoperitoneo</label>
										<label class="switch">
											<input type="checkbox" id="nota_evacuo_activo" name="nota_evacuo_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_nota_evacuo_activo"></span>				
									</div>								
								</div>	
								<br/>
								<div class="form-group custom-control custom-checkbox custom-control-inline">
									<div class="col-md-12">		
										<label class="form-check-label" for="defaultCheck1">Cierro Piel</label>
										<label class="switch">
											<input type="checkbox" id="nota_cierro_piel_activo" name="nota_cierro_piel_activo" value="1">
											<div class="slider round"></div>
										</label>
										<span class="question mb-2" id="label_nota_cierro_piel_activo"></span>				
									</div>														
								</div>						
							</div>
						</div>						
						
						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
							Indicaciones
							</div>
							<div class="card-body">
								<div class="form-row">	
									<label>Plantilla Indicaciones</label>					
									<div class="input-group mb-3">
									<select id="plantilla_notas_indicaciones" name="plantilla_notas_indicaciones" class="custom-select" data-toggle="tooltip" data-placement="top" title="Plantilla Indicaciones">
											<option value="">Seleccione</option>						  
									</select>
									<div class="input-group-append" id="buscar_plantilla_notas_indicaciones" style="display: none;">				
										<a data-toggle="modal" href="#" class="btn btn-outline-success" id="servicio_boton"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
									</div>
									</div>						
								</div>					  
								<div class="form-row">						
									<div class="input-group">
										<textarea id="nota_indicaciones" name="nota_indicaciones" placeholder="Indicaciones" class="form-control" maxlength="2000" rows="8"></textarea>	
										<div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_indicaciones_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_indicaciones_stop"></i>
										</span>
										</div>								  
									</div>	
									<p id="charNum_nota_indicaciones">2000 Caracteres</p>			
								</div>	
							</div>
						</div>	

						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								Recomendaciones
							</div>
							<div class="card-body">
								<div class="form-row">						
									<div class="input-group">
									<textarea id="nota_recomendaciones" name="nota_recomendaciones" placeholder="Recomendaciones" class="form-control" maxlength="2000" rows="8"></textarea>	
									<div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_recomendaciones_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_recomendaciones_stop"></i>
										</span>
									</div>								  
									</div>	
									<p id="charNum_nota_recomendaciones">2000 Caracteres</p>			
								</div>						
							</div>
						</div>										
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Comentarios
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="nota_comentarios" name="nota_comentarios" placeholder="Comentarios" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_nota_comentarios_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_nota_comentarios_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_nota_comentarios">2000 Caracteres</p>			
							</div>							
						</div>
						</div>
						
						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								ARCHIVOS
							</div>
							<div class="card-body">
								<div class="form-row clinicare-size-450">
									<div class="col-md-10 mb-3">
										<input type="file" class="form-control" id="files" name="files[]" multiple accept=".jpg, .png, .pdf"/>
									</div>
									<div class="col-md-2 mb-3">
									<button class="btn btn-success ml-2" type="submit" id="btn_actualizar" form="formulario_atenciones"><div class="sb-nav-link-icon"></div><i class="fas fa-sync-alt"></i> Actualizar</button>
									</div>										
									<div class="col-md-12 mb-3">
										<div class="modal-title" id="mostrar_datos"></div>
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
								<div class="col-md-6 mb-3">
								<label for="expedoente">Servicio <span class="priority">*<span/></label>
								<div class="input-group mb-3">
									<select id="servicio_notaOperatoria_id" name="servicio_notaOperatoria_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes"></select>
									<div class="input-group-append" id="buscar_servicios_notaOperatoria_id" style="display: none">				
										<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
									</div>
								</div>						  
								</div>					
							</div>
						</div>
						</div>					
					</div>	
					<div class="RespuestaAjax"></div>
			</form>
		</div>
		<div class="modal-footer">
				<button class="btn btn-primary ml-2" type="submit" id="reg_nota" form="formularioAtencionesNotaOperatoria"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
				<button class="btn btn-warning ml-2" type="submit" id="edi_nota" form="formularioAtencionesNotaOperatoria"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>	
		</div>	
	</div>
	<!-- FIN NOTA OPERATORIA-->  	

	<!-- INICIO POST OPERATORIO-->
	<div class="tab-pane fade" id="post_operatorio" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">			
			<form class="FormularioAjax" id="formularioAtencionesPostOperatoria" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
					<div class="form-row">
						<button class="btn btn-danger ml-2" type="submit" id="report_postoperatorio"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
						<input type="hidden" id="agenda_id" name="agenda_id" class="form-control">
						<input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control">	
						<input type="hidden" id="colaborador_id" name="colaborador_id" class="form-control">	
						<input type="hidden" id="servicio_id" name="servicio_id" class="form-control">
						<input type="hidden" id="post_edad_consulta" name="post_edad_consulta" class="form-control">
						</div>				
					</div>	
					
					<div class="col-md-12 mb-3">					
						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
							Historico Expediente Clínico Seguimiento Post Operatorio
							</div>
							<div class="card-body clinicare-size-450" id="main_seguimiento_post_operatorio_clinicare-size">
								<div id="main_seguimiento_post_operatorio_historico"></div>				
							
							</div>
						</div>						

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Datos Generales
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-6 mb-3">
								<label for="post_paciente_consulta">Paciente <span class="priority">*<span/></label>
								<input type="text" id="post_paciente_consulta" name="post_paciente_consulta" class="form-control"/>						  
								</div>
								<div class="col-md-3 mb-3">
								<label>Fecha de Registro <span class="priority">*<span/></label>
								<input type="date" id="post_fecha" name="post_fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
								</div>	
								<div class="col-md-3 mb-3">
								<label>Edad</label>
								<input type="text" id="post_edad" name="post_edad" readonly class="form-control" value="0" />
								</div>						
							</div>
						</div>
						</div>
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Antecedentes
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="col-md-3 mb-3">
								<label>Talla</label>							  
								<div class="input-group mb-3">								
									<input type="number" id="post_talla" name="post_talla" class="form-control" step="0.01" readonly />
									<div class="input-group-append">	
										<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>
									</div>
								</div>							  
								</div>
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="number" id="post_peso_actual" name="post_peso_actual" class="form-control" step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>
								<div class="col-md-2 mb-3">
									<label>Peso Actual</label>
									<div class="input-group mb-3">								
										<input type="number" id="post_peso_actual_kg" name="post_peso_actual_kg" class="form-control" value="0.00" readonly step="0.01" />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
										</div>
									</div>							  
								</div>	
								<div class="col-md-2 mb-3">
									<label>Peso Perdido</label>
									<div class="input-group mb-3">								
										<input type="number" id="post_peso_perdido" name="post_peso_perdido" class="form-control" value="0.00" readonly step="0.01" readonly />
										<div class="input-group-append">	
											<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>
										</div>
									</div>							  
								</div>															
								<div class="col-md-2 mb-3">
								<label>IMC Actual</label>
								<input type="number" id="post_imc_actual" name="post_imc_actual" class="form-control" step="0.01" readonly value="0.0" readonly/>
								</div>														
								<div class="col-md-3 mb-3">
								<label>%EWL</label>
								<input type="text" id="post_ewl" name="post_ewl" class="form-control" readonly />
								</div>														
							</div>							
						</div>
						</div>
						
						
						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Otros
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_otros" name="post_otros" placeholder="Otros" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_otros_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_otros_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_otros">2000 Caracteres</p>							
							</div>							
						</div>
						</div>

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Mejoría Enfermedades
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_mejoria" name="post_mejoria" placeholder="Mejoría de Enfermedades" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_mejoria_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_mejoria_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_mejoria">2000 Caracteres</p>						
							</div>							
						</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Estado Actual
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_estado_actual" name="post_estado_actual" placeholder="Estado Actual" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_estado_actual_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_estado_actual_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_estado_actual">2000 Caracteres</p>						
							</div>							
						</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Medicamentos que Usa
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_medicamentos" name="post_medicamentos" placeholder="Medicamentos que usa" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_medicamentos_actual_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_medicamentos_actual_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_medicamentos">2000 Caracteres</p>					
							</div>							
						</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Hallazgos
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_hallazgos" name="post_hallazgos" placeholder="Hallazgos" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_hallazgos_actual_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_hallazgos_actual_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_hallazgos">2000 Caracteres</p>					
							</div>							
						</div>
						</div>		

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Comentario
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_comentarios" name="post_comentarios" placeholder="Comentarios" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_comentarios_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_comentarios_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_comentarios">2000 Caracteres</p>				
							</div>							
						</div>
						</div>	

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Plan
						</div>
						<div class="card-body">
							<div class="form-row">						
								<div class="input-group">
								<textarea id="post_plan" name="post_plan" placeholder="Plan" class="form-control" maxlength="2000" rows="8"></textarea>	
								<div class="input-group-prepend">						  
									<span class="input-group-text">
										<i class="btn btn-outline-success fas fa-microphone-alt" id="search_post_plan_start"></i>
										<i class="btn btn-outline-success fas fa-microphone-slash" id="search_post_plan_stop"></i>
									</span>
								</div>								  
								</div>	
								<p id="charNum_post_plan">2000 Caracteres</p>					
							</div>							
						</div>
						</div>

						<div class="card">
						<div class="card-header text-white bg-info mb-3" align="center">
							Servicio de Atención
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-6 mb-3">
								<label for="expedoente">Servicio <span class="priority">*<span/></label>
								<div class="input-group mb-3">
									<select id="servicio_PostOperatorio_id" name="servicio_PostOperatorio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes"></select>
									<div class="input-group-append" id="buscar_servicios_PostOperatorio_id" style="display: none">				
										<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
									</div>
								</div>						  
								</div>					
							</div>
						</div>
						</div>

					</div>	

					<div class="RespuestaAjax"></div>
			</form>
		</div>		
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" type="submit" id="reg_post" form="formularioAtencionesPostOperatoria"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
		</div>	
	</div>
	<!-- FIN POST OPERATORIO-->  	

	<!-- INICIO DATOS PERSONALES-->
	<div class="tab-pane fade" id="datos_personales" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formulario_pacientes_atenciones" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="pacientes_id" class="form-control" id="pacientes_id">
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="expediente">Expediente</label>
						<input type="text" name="expediente" class="form-control" id="expediente" placeholder="Expediente o Identidad">
					</div>
					<div class="col-md-6 mb-3">
						<label for="edad">Edad</label>
						<input type="text" class="form-control" name="edad" id="edad" maxlength="100" readonly />
					</div>				
				</div>				
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="name">Nombre <span class="priority">*<span/></label>
						<input type="text" required id="name" name="name" placeholder="Nombre" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="lastname">Apellido <span class="priority">*<span/></label>
						<input type="text" required id="lastname" name="lastname" placeholder="Apellido" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="identidad">Identidad o RTN<span class="priority">*<span/></label>
						<input type="text" required id="identidad" name="identidad" maxlength="14" placeholder="Identidad o RTN" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="fecha_nac">Fecha de Nacimiento <span class="priority">*<span/></label>
						<input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
					</div>							
				</div>	
				<div class="form-row">	
					<div class="col-md-3 mb-3">
						<label for="sexo">Sexo <span class="priority">*<span/></label>
						<select class="form-control" id="sexo" name="sexo" required data-toggle="tooltip" data-placement="top" title="Sexo">	
							<option value="">Seleccione</option>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="telefono1">Teléfono 1 <span class="priority">*<span/></label>
						<input type="number" id="telefono1" name="telefono1" class="form-control" placeholder="Primer Teléfono" required maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
					</div>				
					<div class="col-md-3 mb-3">
						<label for="telefono2">Teléfono 2</label>
						<input type="number" id="telefono2" name="telefono2" class="form-control" placeholder="Segundo Teléfono" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
					</div>						
					<div class="col-md-3 mb-3">
						<label for="profesion_pacientes">Profesión <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="profesion_pacientes" name="profesion_pacientes" class="form-control" data-toggle="tooltip" data-placement="top" title="Profesión">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_profesion_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>					
				</div>					
						
				<div class="form-row">											
					<div class="col-md-4 mb-3">
						<label for="pais_id">País <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="pais_id" name="pais_id" class="form-control" data-toggle="tooltip" data-placement="top" title="País">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_pais_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>				
					<div class="col-md-4 mb-3">
						<label for="departamento_id">Departamentos <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="departamento_id" name="departamento_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Departamentos">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_departamento_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>
					<div class="col-md-4 mb-3">
						<label for="municipio_id">Municipios <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="municipio_id" name="municipio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Municipios">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_municipio_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>											
				</div>
						
				<div class="form-row">			  
					<div class="col-md-12 mb-3">
					  <label for="direccion">Dirección <span class="priority">*<span/></label>
					  <textarea id="direccion" name="direccion" placeholder="Dirección" class="form-control" maxlength="250" rows="3" required></textarea>	
				      <p id="charNum_direccion_pacientes">250 Caracteres</p>
					</div>
				</div>

				<div class="form-row">			  
					<div class="col-md-12 mb-3">
						<label for="correo">Correo</label>
						<input type="email" name="correo" id="correo" placeholder="alguien@algo.com" class="form-control" data-toggle="tooltip" data-placement="top" title="Este correo será utilizado para enviar las citas creadas y las reprogramaciones, como las notificaciones de las citas pendientes de los usuarios." maxlength="100"/><label id="validate"></label>
					</div>
				</div>	

				<div class="form-row">			  
					<div class="col-md-12 mb-3">
					  <label for="referido">Referido</label>
					  <textarea id="referido" name="referido" placeholder="Refererido por" class="form-control" maxlength="100" rows="2" maxlength="255"></textarea>	
				      <p id="charNum_referido">255 Caracteres</p>					  
					</div>					
				</div>	

				<div class="form-row">
					<div class="col-md-8 mb-3">
						<label for="responsable">Responsable </label>
						<input type="text" id="responsable" name="responsable" class="form-control" placeholder="Responsable" maxlength="70" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
					</div>
					<div class="col-md-4 mb-3">
						<label for="responsable_id">Parentesco </label>
						<select class="form-control" id="responsable_id" name="responsable_id" data-toggle="tooltip" data-placement="top" title="Parentesco">	
							<option value="">Seleccione</option>
						</select>
						</div>					
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" form="formulario_pacientes_atenciones" type="submit" id="regPacientes"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="btn btn-warning ml-2" form="formulario_pacientes_atenciones" type="submit" id="ediPacientes"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>	
		</div>				
	</div>
	<!-- FIN DATOS PERSONALES-->

	<!-- INICIO TAB HOME HISTORIA CLINICA-->
	<div class="tab-pane fade" id="home_form2" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form id="formulario_buscarAtencion">
				<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
					Datos Generales
					</div>
					<div class="card-body">
						<div class="form-row">
							<button class="btn btn-danger ml-2" type="submit" id="report_historiaclinica"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
						</div>	
						<br>					
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
								<input type="date"  id="expediente_fecha_nacimiento" name="expediente_fecha_nacimiento" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly/>
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
								<input type="date" required id="expediente_fecha_consulta" name="expediente_fecha_consulta" class="form-control" readonly/>
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
								<label for="expediente_peso_maximo_alcanzado_kg">Peso Máximo Alcanzado KG</label>
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
									<textarea id="expediente_expediente_cirugia_abodominal" name="expediente_expediente_cirugia_abodominal" placeholder="Cirugía Abdominal" class="form-control" maxlength="2000" rows="5" readonly></textarea>
								</div>	
								<div class="col-md-6 mb-3">
									<label for="expediente_hallazgos_anormales">Hallazgos Anormales</label>
									<textarea id="expediente_expediente_hallazgos_anormales" name="expediente_expediente_hallazgos_anormales" placeholder="Hallazgos Anormales" class="form-control" maxlength="2000" rows="5" readonly></textarea>
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
							
							<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								ARCHIVOS
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
		<div class="modal-footer">
		
		</div>
	</div>
	<!-- FIN TAB HOME HISTORIA CLINICA-->

	<!-- INICIO TAB HOME HISTORIA CLINICA NUTRICION-->
	<div class="tab-pane fade" id="home_form3_hc_nutricion" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<div class="form-group">
			  <div class="col-sm-12">
				<div class="registros overflow-auto" id="agrega_registros_historia_clinica_nutricion"></div>
			   </div>		   
			</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-center" id="pagination_historia_clinica_nutricion"></ul>
			</nav>
		</div>
		<div class="modal-footer">
		
		</div>
	</div>
	<!-- FIN TAB HOME HISTORIA CLINICA NUTRICION-->	

</div>
<!-- FIN TAB CONTENT-->
<br>