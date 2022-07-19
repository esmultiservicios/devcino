<div id="perfil_paciente">
   <b>PERFIL PACIENTE</b>
   <br/>
   <b><span id="perfil_nombre_nutricion"><span></b>
</div>

<!--INICIO MENU TAB CONTENT-->
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link active" id="primera_consulta_nutricion_tab" data-toggle="tab" href="#primera_consulta_nutricion" role="tab" aria-controls="referencia_form1" aria-selected="false">Antecedentes</a>
	</li>  
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="datos_personales_nutricion_tab" data-toggle="tab" href="#datos_personales_nutricion" role="tab" aria-controls="transito_form1" aria-selected="false">Datos Personales</a>
	</li> 
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="home-tab" data-toggle="tab" href="#home_form2_nutricion" role="tab" aria-controls="home_form1" aria-selected="false">Historia Clínica</a>
	</li>
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="home-tab" data-toggle="tab" href="#home_form3_nutricion" role="tab" aria-controls="home_form1" aria-selected="false">Historia Clínica Cirigía</a>
	</li>	
</ul>
<!--FIN MENU TAB CONTENT-->

<!-- INICIO TAB CONTENT-->
<div class="tab-content" id="myTabContent">
	<!-- INICIO ANTECEDENTES-->
	<div class="tab-pane fade active show" id="primera_consulta_nutricion" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formulario_antecedentes" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="agenda_id" id="agenda_id" class="form-control">
				<input type="hidden" name="pacientes_id" id="pacientes_id" class="form-control">
				<input type="hidden" name="fecha_cita" id="fecha_cita" class="form-control">
				<input type="hidden" name="colaborador_id" id="colaborador_id" class="form-control">
				<input type="hidden" name="atenciones_nutricion_id" id="atenciones_nutricion_id" class="form-control">

				<div class="form-row">
					<button class="btn btn-danger ml-2" type="submit" id="report_prieravez"><div class="sb-nav-link-icon"></div><i class="fas fa-file-pdf"></i> Reporte</button>				
				</div>	
				<br/>				
				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					MOTIVO CONSULTA
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="ante_perso">Morivo Consulta</label>
							<input type="text" class="form-control" name="motivo_consulta" id="motivo_consulta" placeholder="Motivo consulta" maxlength="254"/>
						</div>					
						<div class="col-md-4 mb-3">
							<label for="ante_perso">Fecha Cosulta</label>
							<input type="date" class="form-control" name="fecha_consulta" id="fecha_consulta" value="<?php echo date("Y-m-d"); ?>" maxlength="254"/>
						</div>	
						<div class="col-md-4 mb-3">
							<label for="ante_perso">Edad</label>
							<input type="text" class="form-control" name="edad_consulta" id="edad_consulta" plasholder="Edad" maxlength="254"/>
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
							  <textarea id="ante_perso" name="ante_perso" placeholder="Antecedentes Personales" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ante_perso_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ante_perso_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ante_perso">1000 Caracteres</p>
						</div>					
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ante_fam">Antecedentes Familiares</label>
							<div class="input-group">
							  <textarea id="ante_fam" name="ante_fam" placeholder="Antecedentes Familiares" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ante_fam_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ante_fam_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ante_fam">1000 Caracteres</p>
						</div>					
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="alergias">Alergias</label>
							<div class="input-group">
							  <textarea id="alergias" name="alergias" placeholder="Alergias" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_alergias_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_alergias_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_alergias">1000 Caracteres</p>
						</div>					
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="adicciones">Adicciones</label>
							<div class="input-group">
							  <textarea id="adicciones" name="adicciones" placeholder="Adicciones" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_adicciones_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_adicciones_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_adicciones">1000 Caracteres</p>
						</div>					
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="niveles_estres">Niveles de Estres</label>
							<div class="input-group">
							  <textarea id="niveles_estres" name="niveles_estres" placeholder="Niveles de Estres" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_niveles_estres_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_niveles_estres_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_niveles_estres">1000 Caracteres</p>
						</div>					
					</div>						
					
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="niveles_actividad_fisica">Niveles de Actividad Física</label>
							<div class="input-group">
							  <textarea id="niveles_actividad_fisica" name="niveles_actividad_fisica" placeholder="Niveles de Actividad Física" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_niveles_actividad_fisica_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_niveles_actividad_fisica_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_niveles_actividad_fisica">1000 Caracteres</p>
						</div>					
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="intento_perdida_peso">Intento Perdidad de Peso</label>
							<div class="input-group">
							  <textarea id="intento_perdida_peso" name="intento_perdida_peso" placeholder="Intento Perdida de Peso" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_intento_perdida_peso_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_intento_perdida_peso_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_intento_perdida_peso">1000 Caracteres</p>
						</div>					
					</div>	
					
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="antecedentes_quirurgicos">Antecedentes Quirurgicos</label>
							<div class="input-group">
							  <textarea id="antecedentes_quirurgicos" name="antecedentes_quirurgicos" placeholder="Antecedentes Quirurgicos" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_antecedentes_quirurgicos_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_antecedentes_quirurgicos_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_antecedentes_quirurgicos">1000 Caracteres</p>
						</div>					
					</div>
					
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="observaciones">Observaciones</label>
							<div class="input-group">
							  <textarea id="observaciones" name="observaciones" placeholder="Observaciones" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_observaciones_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_observaciones_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_observaciones">1000 Caracteres</p>
						</div>					
					</div>					

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="diagnostico">Diagnostico</label>
							<div class="input-group">
							  <textarea id="diagnostico" name="diagnostico" placeholder="Diagnostico" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_diagnostico_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_diagnostico_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_diagnostico">1000 Caracteres</p>
						</div>					
					</div>
					
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="indicaciones">Indicaciones</label>
							<div class="input-group">
							  <textarea id="indicaciones" name="indicaciones" placeholder="Indicaciones" class="form-control" maxlength="1000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_indicaciones_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_indicaciones_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_indicaciones">1000 Caracteres</p>
						</div>					
					</div>					

					<div class="form-group custom-control custom-checkbox custom-control-inline">	
						<div class="col-md-12">	
							<label for="candidato_bariatrica">Candidato a Bariatrica </label>		
							<label class="switch">
								<input type="checkbox" id="candidato_bariatrica" name="candidato_bariatrica" value="1">
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
							  <select id="atenciones_servicio_id" name="atenciones_servicio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Pacientes"></select>
							  <div class="input-group-append" id="buscar_servicios_atenciones" style="display: none">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							  </div>
						   </div>						  
						</div>					
					</div>

				  </div>
				</div>	
				
				<div class="modal-footer">
					<button class="btn btn-primary ml-2" form="formulario_antecedentes" type="submit" id="regConsulta"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>	
					<button class="btn btn-warning ml-2" form="formulario_antecedentes" type="submit" id="ediConsulta"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>	
				</div>	

				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					Otra Información
				  </div>
				  <div class="card-body">

				  	<div class="form-row">						  
					  <div class="col-md-3 mb-3">
							<label for="fecha_otros">Fecha Registro</label>
							<input type="date" class="form-control" name="fecha_otros" id="fecha_otros" value="<?php echo date("Y-m-d"); ?>" maxlength="10" />
						</div>						  
						<div class="col-md-3 mb-3">
							<label for="peso_hab">Peso Habitual</label>
							<input type="text" class="form-control" name="peso_hab" id="peso_hab" placeholder="Peso Habitual" maxlength="10" />
						</div>					
						<div class="col-md-3 mb-3">
							<label for="peso_p25">Peso P25</label>
							<input type="text" class="form-control" name="peso_p25" id="peso_p25" placeholder="Peso P2P" maxlength="10" />
						</div>	
						<div class="col-md-3 mb-3">
							<label for="brazo">Brazo</label>
							<input type="text" class="form-control" name="brazo" id="brazo" placeholder="Brazo"  maxlength="10" />
						</div>																				
					</div>	

					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="muneca">Muñeca</label>
							<input type="text" class="form-control" name="muneca" id="muneca" placeholder="Muñeca"  maxlength="10" />
						</div>						
						<div class="col-md-3 mb-3">
							<label for="msj">MSJ</label>
							<input type="text" class="form-control" name="msj" id="msj" placeholder="MSJ" maxlength="10" />
						</div>					
						<div class="col-md-3 mb-3">
							<label for="cintura">Cintura</label>
							<input type="text" class="form-control" name="cintura" id="cintura" placeholder="Cintura" maxlength="10" />
						</div>	
						<div class="col-md-3 mb-3">
							<label for="cadera">Cadera</label>
							<input type="text" class="form-control" name="cadera" id="cadera" placeholder="Cadera"  maxlength="10" />
						</div>																				
					</div>	

					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="estatura">Estatura</label>
							<input type="text" class="form-control" name="estatura" id="estatura" placeholder="Estatura"  maxlength="10" />
						</div>						
						<div class="col-md-3 mb-3">
							<label for="imc">IMC</label>
							<input type="text" class="form-control" name="imc" id="imc" placeholder="IMC" maxlength="10" />
						</div>					
						<div class="col-md-3 mb-3">
							<label for="talla">Talla</label>
							<input type="text" class="form-control" name="talla" id="talla" placeholder="Talla" maxlength="10" />
						</div>	
						<div class="col-md-3 mb-3">
							<label for="indice_cc">Indice CC</label>
							<input type="text" class="form-control" name="indice_cc" id="indice_cc" placeholder="Indice CC"  maxlength="10" />
						</div>																											
					</div>	
					
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="peso_activo">Peso Activo</label>
							<input type="text" class="form-control" name="peso_activo" id="peso_activo" placeholder="Peso Activo" maxlength="10" />
						</div>						
						<div class="col-md-3 mb-3">
							<label for="riesgo_vascular">Riesgo Cardiovascular</label>
							<input type="text" class="form-control" name="riesgo_vascular" id="riesgo_vascular" placeholder="Riesgo Cardiovascular" maxlength="10" />
						</div>					
						<div class="col-md-3 mb-3">
							<label for="porcentaje_grasa">% Grasa</label>
							<input type="text" class="form-control" name="porcentaje_grasa" id="porcentaje_grasa" placeholder="% Grasa" maxlength="10" />
						</div>	
						<div class="col-md-3 mb-3">
							<label for="tipo_dieta">Tipo de Dieta</label>
							<input type="text" class="form-control" name="tipo_dieta" id="tipo_dieta" placeholder="Tipo de Dieta"  maxlength="10" />
						</div>																											
					</div>	
					
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="pa">PA</label>
							<input type="text" class="form-control" name="pa" id="pa" placeholder="PA" maxlength="10" />
						</div>	
						<div class="col-md-3 mb-3">
							<label for="abdomen">Abodomen</label>
							<input type="text" class="form-control" name="abdomen" id="abdomen" placeholder="Abdomen" maxlength="10" />
						</div>																																							
					</div>						

				  </div>
				</div>

			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" form="formulario_antecedentes" type="submit" id="regOtro"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>	
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
	<!-- FIN PRIMERA CONSULTA-->  

	<!-- INICIO DATOS PERSONALES-->
	<div class="tab-pane fade" id="datos_personales_nutricion" role="tabpanel" aria-labelledby="home-tab">
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
						<input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo date ("Y-m-d");?>" class="form-control"/>
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
	<div class="tab-pane fade" id="home_form2_nutricion" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<div class="form-group">
			  <div class="col-sm-12">
				<div class="registros overflow-auto" id="agrega_registros_historia_clinica"></div>
			   </div>		   
			</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-center" id="pagination_historia_clinica"></ul>
			</nav>
		</div>
		<div class="modal-footer">
		
		</div>
	</div>
	<!-- FIN TAB HOME HISTORIA CLINICA-->

	<!-- INICIO TAB HOME HISTORIA CLINICA CIRUGIA-->
	<div class="tab-pane fade" id="home_form3_nutricion" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form id="formulario_buscarAtencion">
				<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
					Datos Generales
					</div>
					<div class="card-body">
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
								<input type="date"  id="expediente_fecha_nacimiento" name="expediente_fecha_nacimiento" class="form-control" value="<?php echo date ("Y-m-d");?>" readonly/>
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
								<label for="expediente_fecha_consulta">Drogas</label>
								<input type="text" required id="drogas_respuesta" name="drogas_respuesta" class="form-control" readonly />
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
										<div class="modal-title" id="mostrar_datos_cirugia"></div>
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
					<div class="card-body clinicare-size-450" id="main_seguimiento_preo_operatorio_cirugia_clinicare-size">
						<div id="main_seguimiento_preo_operatorio_cirugia"></div>
					
					</div>
				</div>
				
				<div class="card">
					<div class="card-header text-white bg-info mb-3" align="center">
					Expediente Clínico Seguimiento Nota Operatoria
					</div>
					<div class="card-body clinicare-size-450" id="main_seguimiento_nota_operatorio_clinicare-size">
						<div id="main_seguimiento_nota_operatorio"></div>	
						<div id="main_seguimiento_nota_operatorio_cirugua"></div>

						<div class="card">
							<div class="card-header text-white bg-info mb-3" align="center">
								ARCHIVOS
							</div>
							<div class="card-body">
								<div class="form-row clinicare-size-450">									
									<div class="col-md-12 mb-3">
										<div class="modal-title" id="mostrar_datos_nota_operatoria_cirugia"></div>
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
						<div id="main_seguimiento_post_operatorio_cirugia"></div>				
					
					</div>
				</div>							
			</form>	
		</div>
		<div class="modal-footer">
		
		</div>
	</div>
	<!-- FIN TAB HOME HISTORIA CLINICA CIRUGIA-->	

</div>
<!-- FIN TAB CONTENT-->
<br>