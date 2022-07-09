<script>
$(document).ready(function() {
	pagination(1);
	mainExpediente();
});

$(document).ready(function() {
  $('#form_main_atenciones_medicas #bs_regis').on('keyup', function(){
     pagination(1);
  });
});

function mainExpediente(){
	$('#label_busqueda').html("Búsqueda");
}

//INICIO PAGINACION DE REGISTROS
function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/paginar.php';
	var dato = $('#form_main_atenciones_medicas #bs_regis').val();

	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&dato='+dato,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}
//FIN PAGINACION DE REGISTROS

function viewExpediente(pacientes_id){
	$('#main_expediente_clinico').hide();
	$('#view_expediente_clinico').show();
	$('#label_busqueda').html("Búsqueda");
	$('#acciones_busqueda').removeClass("active");
	$('#label_expediente_clinico').html("Expediente Clínico");
	$('#acciones_expediente').addClass("active");
	$('#formulario_buscarAtencion #expediente_identidad').focus();
	$('body, html').animate({
		scrollTop: '0px'
	}, 0);	

	$('.card-body').animate({
		scrollTop: '0px'
	}, 0);		

	//DATOS GENERALES DEL PACIENTE
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/viewDatosGenerales.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);
			$('#formulario_buscarAtencion #expediente_identidad').val(datos[0]);		
			$('#formulario_buscarAtencion #expediente_cliente').val(datos[1]);
			$('#formulario_buscarAtencion #expediente_fecha_nacimiento').val(datos[2]);
			$('#formulario_buscarAtencion #expediente_edad').val(datos[3]);						
			$('#formulario_buscarAtencion #expediente_telefono').val(datos[4]);	
			$('#formulario_buscarAtencion #expediente_departamento').val(datos[5]);		
			$('#formulario_buscarAtencion #expediente_municipio').val(datos[6]);
			$('#formulario_buscarAtencion #expediente_procedencia').val(datos[7]);
			$('#formulario_buscarAtencion #expediente_profesion').val(datos[8]);						
			$('#formulario_buscarAtencion #expediente_nch').val(datos[9]);	
			$('#formulario_buscarAtencion #expediente_correo').val(datos[10]);
			$('#formulario_buscarAtencion #expediente_genero').val(datos[11]);
			$('#formulario_buscarAtencion #expediente_referido').val(datos[12]);
			$('#formulario_buscarAtencion #expediente_fecha_consulta').val(datos[13]);
			$('#formulario_buscarAtencion #expediente_inicio_obesidad').val(datos[14]);	
			$('#formulario_buscarAtencion #expediente_habito_alimenticio').val(datos[15]);	
			$('#formulario_buscarAtencion #expediente_tipo_obecidad').val(datos[16]);	
			$('#formulario_buscarAtencion #expediente_intento_perdida_peso').val(datos[17]);	
			$('#formulario_buscarAtencion #expediente_peso_maximo_alcanzado').val(datos[18]);
			$('#formulario_buscarAtencion #expediente_sedentarismo').val(datos[19]);
			
			if (datos[20] == 1){
				$('#formulario_buscarAtencion #expediente_ejercicio_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_ejercicio_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_ejercicio_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_ejercicio_activo').html("No");
			}

			$('#formulario_buscarAtencion #ejercicio_respuesta').val(datos[21]);

			//INICIO PRIMERA FILA
			if (datos[24] == 1){
				$('#formulario_buscarAtencion #expediente_erge_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_erge_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_erge_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_erge_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_erge_respuesta').val(datos[67]);

			if (datos[25] == 1){
				$('#formulario_buscarAtencion #expediente_hta_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_hta_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_hta_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_hta_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_hta_respuesta').val(datos[68]);

			if (datos[27] == 1){
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_higado_graso_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_higado_graso_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_higado_graso_respuesta').val(datos[70]);

			if (datos[28] == 1){
				$('#formulario_buscarAtencion #expediente_saos_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_saos_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_saos_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_saos_activo').html("No");
			}

			$('#formulario_buscarAtencion #expediente_saos_respuesta').val(datos[80]);

			if (datos[29] == 1){
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_hipotiroidismo_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_hipotiroidismo_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_hipotiroidismo_respuesta').val(datos[71]);

			if (datos[30] == 1){
				$('#formulario_buscarAtencion #expediente_articulares_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_articulares_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_articulares_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_articulares_activo').html("No");
			}				

			$('#formulario_buscarAtencion #expediente_articulares_respuesta').val(datos[72]);
			//FIN PRIMERA FILA

			//INICIO SEGUNDA FILA
			if (datos[31] == 1){
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_ovarios_poliquisticos_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_ovarios_poliquisticos_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_ovarios_respuesta').val(datos[73]);

			if (datos[32] == 1){
				$('#formulario_buscarAtencion #expediente_varices_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_varices_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_varices_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_varices_activo').html("No");
			}					

			$('#formulario_buscarAtencion #expediente_varices_respuesta').val(datos[74]);

			if (datos[37] == 1){
				$('#formulario_buscarAtencion #expediente_drogas_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_drogas_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_drogas_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_drogas_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_drogas_respuesta').val(datos[38]);	
			
			if (datos[39] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_diabetes_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_diabetes_activo').html("No");
			}		
			
			$('#formulario_buscarAtencion #expediente_ant_fam_respuesta').val(datos[75]);

			if (datos[40] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_Obesidad_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_Obesidad_activo').html("No");
			}			
			
			$('#formulario_buscarAtencion #expediente_ant_fam_obecidad_respuesta').val(datos[76]);

			if (datos[41] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_cancer_gastrico_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_cancer_gastrico_activo').html("No");
			}		
			
			$('#formulario_buscarAtencion #expediente_ant_fam_gastrico_respuesta').val(datos[77]);
			//FIN SEGUNDA FILA

			//INICIO TERCERA FILA
			if (datos[42] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_psiquiatricas_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_psiquiatricas_activo').html("No");
			}	

			$('#formulario_buscarAtencion #expediente_enf_psiquiatricas_respuesta').val(datos[78]);

			if (datos[43] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_dm_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_dm_activo').html("No");
			}	
			
			$('#formulario_buscarAtencion #expediente_dm_respuesta').val(datos[79]);

			if (datos[22] == 1){
				$('#formulario_buscarAtencion #expediente_alergias_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_alergias_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_alergias_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_alergias_activo').html("No");
			}	
			
			$('#formulario_buscarAtencion #expediente_alergias_respuesta').val(datos[23]);		
			
			if (datos[35] == 1){
				$('#formulario_buscarAtencion #expediente_alcohol_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_alcohol_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_alcohol_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_alcohol_activo').html("No");
			}	
			
			$('#formulario_buscarAtencion #expediente_alcohol_respuesta').val(datos[36]);
			
			if (datos[33] == 1){
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_tabaquismo_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_tabaquismo_activo').html("No");
			}		
			
			$('#formulario_buscarAtencion #expediente_tabaquismo_respuesta').val(datos[34]);
			
			if (datos[26] == 1){
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_dislipidemia_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_dislipidemia_activo').html("No");
			}				
			$('#formulario_buscarAtencion #expediente_dislipidemia_respuesta').val(datos[69]);
			//FIN TERCERA FILA

			$('#formulario_buscarAtencion #expediente_otros').val(datos[44]);

			$('#formulario_buscarAtencion #expediente_expediente_cirugia_abodominal').val(datos[45]);
			$('#formulario_buscarAtencion #expediente_talla').val(datos[46]);
			$('#formulario_buscarAtencion #expediente_peso_ideal').val(datos[47]);
			$('#formulario_buscarAtencion #expediente_peso').val(datos[48]);
			$('#formulario_buscarAtencion #expediente_exceso_peso').val(datos[49]);
			$('#formulario_buscarAtencion #expediente_pre_imc_actual').val(datos[50]);
			$('#formulario_buscarAtencion #expediente_expediente_hallazgos_anormales').val(datos[51]);
			$('#formulario_buscarAtencion #expediente_expediente_estudios_imagenes').val(datos[52]);
			$('#formulario_buscarAtencion #expediente_referencia_a').val(datos[53]);
			$('#formulario_buscarAtencion #expediente_recomendaciones_quirurgicas').val(datos[54]);
			$('#formulario_buscarAtencion #expediente_presupuesto').val(datos[55]);
			$('#formulario_buscarAtencion #expediente_observacion').val(datos[66]);
			$('#formulario_buscarAtencion #expediente_peso_maximo_alcanzado_kg').val(datos[59]);
			$('#formulario_buscarAtencion #expediente_peso_ideal_kg').val(datos[60]);
			$('#formulario_buscarAtencion #expediente_peso_kg').val(datos[61]);
			$('#formulario_buscarAtencion #expediente_exceso_peso_kg').val(datos[62]);

			$('#formulario_buscarAtencion #expediente_edad_').val(datos[63]);

			viewPreOperatorio(pacientes_id);
			viewNotaOperatoria(pacientes_id);
			viewNotaPostOperatorio(pacientes_id);
			mostrarArchivos(pacientes_id)
			mostrarArchivosNotaOperatoria(pacientes_id);

			return false;
		}
	});		
}

function viewPreOperatorio(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/viewDatosPreOperatorio.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);	

			if(datos.length == 0){
				$('#main_seguimiento_preo_operatorio').append("<b style='color: red;'>No hay datos que mostrar</b>");	
				$('#main_seguimiento_preo_operatorio_clinicare-size').css("height", "73");
			}else{
				$('#main_seguimiento_preo_operatorio').append("");
				$('#main_seguimiento_preo_operatorio_clinicare-size').css("height", "400");
			}

			for(var fila=0; fila < datos.length; fila++){
				llenarPreOperatorio(fila);
				$('#formulario_buscarAtencion #expediente_pre_fecha_consulta_'+ fila).val(datos[fila]["fecha"]);
				$('#formulario_buscarAtencion #expediente_pre_nch_'+ fila).val(datos[fila]["preoperacion_id"]);
				$('#formulario_buscarAtencion #expediente_pre_talla_'+ fila).val(datos[fila]["talla"]);				
				$('#formulario_buscarAtencion #expediente_pre_peso_actual_'+ fila).val(datos[fila]["peso_actual"]);				
				$('#formulario_buscarAtencion #expediente_pre_peso_actual_kg_'+ fila).val(datos[fila]["peso_actual_kg"]);	
				$('#formulario_buscarAtencion #expediente_pre_peso_perdido_'+ fila).val(datos[fila]["peso_perdido"]);				
				$('#formulario_buscarAtencion #expediente_pre_imc_actual_'+ fila).val(datos[fila]["imc_actual"]);				
				$('#formulario_buscarAtencion #expediente_pre_fecha_cirugia_'+ fila).val(datos[fila]["fecha_cirugia"]);				
				$('#formulario_buscarAtencion #expediente_pre_edad_'+ fila).val(datos[fila]["edad"]);				
				$('#formulario_buscarAtencion #expediente_pre_tipo_cirugia_'+ fila).val(datos[fila]["tipo_cirugia"]);				
				$('#formulario_buscarAtencion #expediente_pre_examenes_'+ fila).val(datos[fila]["resultados"]);				
				$('#formulario_buscarAtencion #expediente_pre_recomendacion_'+ fila).val(datos[fila]["recomendaciones"]);

				if(datos[fila]["psquiatria"] == 1){
					$('#formulario_buscarAtencion #expediente_pre_psiquiatra_activo_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_pre_psiquiatra_activo_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_pre_psiquiatra_activo_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_pre_psiquiatra_activo_'+ fila).html("Sí");					
				}

				if(datos[fila]["psicologia"] == 1){
					$('#formulario_buscarAtencion #expediente_pre_psicologo_activo_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_pre_psicologo_activo_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_pre_psicologo_activo_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_pre_psicologo_activo_'+ fila).html("Sí");					
				}
				
				if(datos[fila]["nutricion"] == 1){
					$('#formulario_buscarAtencion #expediente_pre_nutricion_activo_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_pre_nutricion_activo_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_pre_nutricion_activo_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_pre_nutricion_activo_'+ fila).html("Sí");					
				}
				
				if(datos[fila]["medicina_interna"] == 1){
					$('#formulario_buscarAtencion #expediente_pre_medicina_interna_activo_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_pre_medicina_interna_activo_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_pre_medicina_interna_activo_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_pre_medicina_interna_activo_'+ fila).html("Sí");					
				}
			}

			return false;
		}
	});				
}

function viewNotaOperatoria(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/viewDatosNotaOperatoria.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);

			if(datos.length == 0){
				$('#main_seguimiento_nota_operatorio').append("<b style='color: red;'>No hay datos que mostrar</b>");
				$('#main_seguimiento_nota_operatorio_clinicare-size').css("height", "73");	
			}else{
				$('#main_seguimiento_nota_operatorio').append("");
				$('#main_seguimiento_nota_operatorio_clinicare-size').css("height", "400");
			}

			for(var fila=0; fila < datos.length; fila++){
				llenarNotaOperatoria(fila);
				$('#formulario_buscarAtencion #expediente_nota_fecha_consulta_'+ fila).val(datos[fila]["fecha"]);
				$('#formulario_buscarAtencion #expediente_nota_nch_'+ fila).val(datos[fila]["notaoperacion_id"]);
				$('#formulario_buscarAtencion #expediente_nota_talla_'+ fila).val(datos[fila]["talla"]);				
				$('#formulario_buscarAtencion #expediente_nota_peso_actual_'+ fila).val(datos[fila]["peso_actual"]);				
				$('#formulario_buscarAtencion #expediente_nota_peso_actual_kg_'+ fila).val(datos[fila]["peso_actual_kg"]);			
				$('#formulario_buscarAtencion #expediente_nota_imc_actual_'+ fila).val(datos[fila]["imc_actual"]);				
				$('#formulario_buscarAtencion #expediente_nota_edad_'+ fila).val(datos[fila]["edad"]);				
				$('#formulario_buscarAtencion #expediente_nota_cirujano_'+ fila).val(datos[fila]["cirujano"]);				
				$('#formulario_buscarAtencion #expediente_nota_asistente_'+ fila).val(datos[fila]["asistente"]);				
				$('#formulario_buscarAtencion #expediente_nota_camara_'+ fila).val(datos[fila]["camara"]);
				$('#formulario_buscarAtencion #expediente_nota_anestesia_'+ fila).val(datos[fila]["anestesia"]);				
				$('#formulario_buscarAtencion #expediente_nota_anestesiologo_'+ fila).val(datos[fila]["anestesiologo"]);				
				$('#formulario_buscarAtencion #expediente_nota_tecnica_'+ fila).val(datos[fila]["tecnica"]);		
				$('#formulario_buscarAtencion #expediente_nota_otros_'+ fila).val(datos[fila]["otros"]);	
				$('#formulario_buscarAtencion #expediente_nota_hallazgos_operativos_'+ fila).val(datos[fila]["hallazgos_operativos"]);				
				$('#formulario_buscarAtencion #expediente_nota_descripcion_operativa_'+ fila).val(datos[fila]["descripcion_operativos"]);				
				$('#formulario_buscarAtencion #expediente_nota_indicaciones_'+ fila).val(datos[fila]["indicaciones"]);				
				$('#formulario_buscarAtencion #expediente_nota_recomendaciones_'+ fila).val(datos[fila]["recomendaciones"]);					

				if(datos[fila]["prueba"] == 1){
					$('#formulario_buscarAtencion #expediente_nota_prueba_estanqueidad_azul_metileno_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_nota_prueba_estanqueidad_azul_metileno_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_nota_prueba_estanqueidad_azul_metileno_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_nota_prueba_estanqueidad_azul_metileno_'+ fila).html("Sí");					
				}

				if(datos[fila]["blake"] == 1){
					$('#formulario_buscarAtencion #expediente_nota_dreno_blake_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_nota_dreno_blake_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_nota_dreno_blake_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_nota_dreno_blake_'+ fila).html("Sí");					
				}	
				
				if(datos[fila]["extraccion"] == 1){
					$('#formulario_buscarAtencion #expediente_nota_extracción_piezas_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_nota_extracción_piezas_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_nota_extracción_piezas_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_nota_extracción_piezas_'+ fila).html("Sí");					
				}	
				
				if(datos[fila]["evacuo"] == 1){
					$('#formulario_buscarAtencion #expediente_nota_evacuo_neumoperitoneo_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_nota_evacuo_neumoperitoneo_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_nota_evacuo_neumoperitoneo_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_nota_evacuo_neumoperitoneo_'+ fila).html("Sí");					
				}	
				
				if(datos[fila]["cierro"] == 1){
					$('#formulario_buscarAtencion #expediente_nota_cierro_piel_'+ fila).prop('checked', true);
					$('#formulario_buscarAtencion #label_expediente_nota_cierro_piel_'+ fila).html("Sí");					
				}else{
					$('#formulario_buscarAtencion #expediente_nota_cierro_piel_'+ fila).prop('checked', false);
					$('#formulario_buscarAtencion #label_expediente_nota_cierro_piel_'+ fila).html("Sí");					
				}					

				$('#formulario_buscarAtencion #expediente_nota_comentarios_'+ fila).val(datos[fila]["comentarios"]);
			}
			return false;
		}
	});		
}

function viewNotaPostOperatorio(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/viewDatosPostOperatorio.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);

			if(datos.length == 0){
				$('#main_seguimiento_post_operatorio').append("<b style='color: red;'>No hay datos que mostrar</b>");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "73");	
			}else{
				$('#main_seguimiento_post_operatorio').append("");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "400");
			}

			for(var fila=0; fila < datos.length; fila++){
				llenarPostOperatorio(fila);
				$('#formulario_buscarAtencion #expediente_post_fecha_consulta_'+ fila).val(datos[fila]["fecha"]);
				$('#formulario_buscarAtencion #expediente_post_nch_'+ fila).val(datos[fila]["postoperacion_id"]);
				$('#formulario_buscarAtencion #expediente_post_talla_'+ fila).val(datos[fila]["talla"]);				
				$('#formulario_buscarAtencion #expediente_post_peso_actual_'+ fila).val(datos[fila]["peso_actual"]);				
				$('#formulario_buscarAtencion #expediente_post_peso_actual_kg_'+ fila).val(datos[fila]["peso_actual_kg"]);				
				$('#formulario_buscarAtencion #expediente_post_imc_actual_'+ fila).val(datos[fila]["imc_actual"]);				
				$('#formulario_buscarAtencion #expediente_post_edad_'+ fila).val(datos[fila]["edad"]);				
				$('#formulario_buscarAtencion #expediente_post_peso_perdido_'+ fila).val(datos[fila]["peso_perdido"]);
				$('#formulario_buscarAtencion #expediente_post_ewl_'+ fila).val(datos[fila]["ewl"]);				
				$('#formulario_buscarAtencion #expediente_post_otros_'+ fila).val(datos[fila]["otros"]);//pendiente revisar				
				$('#formulario_buscarAtencion #expediente_post_mejoria_enfermedades_'+ fila).val(datos[fila]["mejoria"]);
				$('#formulario_buscarAtencion #expediente_post_estado_actual_'+ fila).val(datos[fila]["estado_actual"]);				
				$('#formulario_buscarAtencion #expediente_post_medicamentos_que_usa_'+ fila).val(datos[fila]["medicamentos"]);				
				$('#formulario_buscarAtencion #expediente_post_hallazgos_'+ fila).val(datos[fila]["hallazgos"]);		
				$('#formulario_buscarAtencion #expediente_post_comentario_'+ fila).val(datos[fila]["comentarios"]);	
				$('#formulario_buscarAtencion #expediente_post_plan_'+ fila).val(datos[fila]["plan"]);
			}
			return false;
		}
	});		
}

function llenarPreOperatorio(count){
	var htmlRows = '';
	//INICIO PRIMER FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_fecha_consulta">Fecha Consulta</label>';
			htmlRows += '<input type="date" required id="expediente_pre_fecha_consulta_'+count+'" name="expediente_pre_fecha_consulta[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_nch">NCH</label>';
			htmlRows += '<input type="text" required id="expediente_pre_nch_'+count+'" name="expediente_pre_nch[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_talla">Talla</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" required id="expediente_pre_talla_'+count+'" name="expediente_pre_talla[]" class="form-control" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_peso_actual">Peso Actual LB</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_pre_peso_actual_'+count+'" name="expediente_pre_peso_actual[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_peso_actual">Peso Actual KG</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_pre_peso_actual_kg_'+count+'" name="expediente_pre_peso_actual_kg[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_peso_perdido">Peso Perdido</label>';
			htmlRows += '<input type="text" required id="expediente_pre_peso_perdido_'+count+'" name="expediente_pre_peso_perdido[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_imc_actual">IMC Actual</label>';
			htmlRows += '<input type="text" required id="expediente_pre_imc_actual_'+count+'" name="expediente_pre_imc_actual[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_fecha_cirugia">Fecha Cirugía</label>';
			htmlRows += '<input type="date" required id="expediente_pre_fecha_cirugia_'+count+'" name="expediente_pre_fecha_cirugia[]" class="form-control" readonly value="<?php echo date ("Y-m-d");?>" />';	
		htmlRows += '</div>';	
	htmlRows += '</div>';	
	// FIN PRIMER FILA

	//INICIO SEGUNDA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_edad">Edad</label>';
			htmlRows += '<input type="text" id="expediente_pre_edad_'+count+'" name="expediente_pre_edad[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-10 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_tipo_cirugia">Tipo Cirugía</label>';
			htmlRows += '<input type="text" required id="expediente_pre_tipo_cirugia_'+count+'" name="expediente_pre_tipo_cirugia[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	htmlRows += '</div>';	
	//FIN SEGUNDA FILA

	//INICIO TERCERA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_examenes">Resultado de Examenes</label>';
			htmlRows += '<textarea id="expediente_pre_examenes_'+count+'" name="expediente_pre_examenes[]" placeholder="Resultado Examenes" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_recomendacion">Recomendaciones</label>';
			htmlRows += '<textarea id="expediente_pre_recomendacion_'+count+'" name="expediente_pre_recomendacion[]" placeholder="Recomendaciones" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

	//INICIO SELECTORES
	htmlRows += '<div class="form-group custom-control custom-checkbox custom-control-inline" style=" margin-left: auto; margin-right: auto;">';  	
		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Psiquiatra</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_pre_psiquiatra_activo_'+count+'" name="expediente_pre_psiquiatra_activo[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';	
		htmlRows += '<span class="question mb-2" id="label_expediente_pre_psiquiatra_activo_'+count+'"></span>';			
		htmlRows += '</div>';	

		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Psicólogo</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_pre_psicologo_activo_'+count+'" name="expediente_pre_psicologo_activo[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_pre_psicologo_activo_'+count+'"></span>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Nutrición</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_pre_nutricion_activo_'+count+'" name="expediente_pre_nutricion_activo[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_pre_nutricion_activo_'+count+'"></span>';	
		htmlRows += '</div>';
		
		htmlRows += '<div class="col-md-4">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Medicina Interna</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_pre_medicina_interna_activo_'+count+'" name="expediente_pre_medicina_interna_activo[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_pre_medicina_interna_activo_'+count+'"></span>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN SELECTORE

	htmlRows += '</div>';
	htmlRows += '<hr/>';
	//FIN TERCERA FILA	

	$('#main_seguimiento_preo_operatorio').append(htmlRows);	
}

function llenarNotaOperatoria(count){
	var htmlRows = '';
	//INICIO PRIMER FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_fecha_consulta">Fecha Consulta</label>';
			htmlRows += '<input type="date" required id="expediente_nota_fecha_consulta_'+count+'" name="expediente_nota_fecha_consulta[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_nch">NCH</label>';
			htmlRows += '<input type="text" required id="expediente_nota_nch_'+count+'" name="expediente_nota_nch[]" class="form-control" readonly />';	
		htmlRows += '</div>';	

		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_talla">Talla</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" required id="expediente_nota_talla_'+count+'" name="expediente_nota_talla[]" class="form-control" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_peso_actual">Peso Actual LB</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_nota_peso_actual_'+count+'" name="expediente_nota_peso_actual[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_peso_actual_kg">Peso Actual KG</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_nota_peso_actual_kg_'+count+'" name="expediente_nota_peso_actual_kg[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_imc_actual">IMC Actual</label>';
			htmlRows += '<input type="text" required id="expediente_nota_imc_actual_'+count+'" name="expediente_nota_imc_actual[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_edad">Edad</label>';
			htmlRows += '<input type="text" id="expediente_nota_edad_'+count+'" name="expediente_nota_edad[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	htmlRows += '</div>';	
	// FIN PRIMER FILA

	//INICIO SEGUNDA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-3 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_cirujano">Cirujano</label>';
			htmlRows += '<input type="text" required id="expediente_nota_cirujano_'+count+'" name="expediente_nota_cirujano[]" class="form-control" readonly />';	
		htmlRows += '</div>';
		htmlRows += '<div class="col-md-3 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_asistente">Asistente</label>';
			htmlRows += '<input type="text" required id="expediente_nota_asistente_'+count+'" name="expediente_nota_asistente[]" class="form-control" readonly />';	
		htmlRows += '</div>';	
		htmlRows += '<div class="col-md-3 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_camara">Camara</label>';
			htmlRows += '<input type="text" required id="expediente_nota_camara_'+count+'" name="expediente_nota_camara[]" class="form-control" readonly />';	
		htmlRows += '</div>';	
		htmlRows += '<div class="col-md-3 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_anestesia">Anestesia</label>';
			htmlRows += '<input type="text" required id="expediente_nota_anestesia_'+count+'" name="expediente_nota_anestesia[]" class="form-control" readonly />';	
		htmlRows += '</div>';		
	htmlRows += '</div>';	
	//FIN SEGUNDA FILA

	//INICO TERCAR FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-3 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_anestesiologo">Anestesiólogo</label>';
			htmlRows += '<input type="text" required id="expediente_nota_anestesiologo_'+count+'" name="expediente_nota_anestesiologo[]" class="form-control" readonly />';	
		htmlRows += '</div>';	
	htmlRows += '</div>';	
	//FIN TERCERA FILA

	//INICIO CUARTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_tecnica">Técnica</label>';
			htmlRows += '<textarea id="expediente_nota_tecnica_'+count+'" name="expediente_nota_tecnica[]" placeholder="Resultado Examenes" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_otros">Otros</label>';
			htmlRows += '<textarea id="expediente_nota_otros_'+count+'" name="expediente_nota_otros[]" placeholder="Recomendaciones" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN CUARTA FILA

	//INICIO QUINTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_hallazgos_operativos">Hallazgos Operativos</label>';
			htmlRows += '<textarea id="expediente_nota_hallazgos_operativos_'+count+'" name="expediente_nota_hallazgos_operativos[]" placeholder="Hallazgos Operativos" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_descripcion_operativa">Descripción Operatoria</label>';
			htmlRows += '<textarea id="expediente_nota_descripcion_operativa_'+count+'" name="expediente_nota_descripcion_operativa[]" placeholder="Descripción Operatoria" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN QUINTA FILA	

	//INICIO SEXTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_indicaciones">Indicaciones</label>';
			htmlRows += '<textarea id="expediente_nota_indicaciones_'+count+'" name="expediente_nota_indicaciones[]" placeholder="Indicaciones" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_recomendaciones">Recomendaciones</label>';
			htmlRows += '<textarea id="expediente_nota_recomendaciones_'+count+'" name="expediente_nota_recomendaciones[]" placeholder="Recomendaciones" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN SEXTA FILA		

	//INICIO SEPTIMA FILA
	//INICIO SELECTORES
	htmlRows += '<div class="form-group custom-control custom-checkbox custom-control-inline" style=" margin-left: auto; margin-right: auto;">';  	
		htmlRows += '<div class="col-md-4">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Prueba de Estanqueidad con azul de metileno</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_nota_prueba_estanqueidad_azul_metileno_'+count+'" name="expediente_nota_prueba_estanqueidad_azul_metileno_[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';	
		htmlRows += '<span class="question mb-2" id="label_expediente_nota_prueba_estanqueidad_azul_metileno_'+count+'"></span>';			
		htmlRows += '</div>';	

		htmlRows += '<div class="col-md-2">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Dreno Blake</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_nota_dreno_blake_'+count+'" name="expediente_nota_dreno_blake[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_nota_dreno_blake_'+count+'"></span>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Extracción de Piezas</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_nota_extracción_piezas_'+count+'" name="expediente_nota_extracción_piezas[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_nota_extracción_piezas_'+count+'"></span>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Evacuo Neumoperitoneo</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_nota_evacuo_neumoperitoneo_'+count+'" name="expediente_nota_evacuo_neumoperitoneo[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_nota_evacuo_neumoperitoneo_'+count+'"></span>';	
		htmlRows += '</div>';
		
		htmlRows += '<div class="col-md-3">';                    	
		htmlRows += '<label class="form-check-label" for="defaultCheck1">Cierro Piel</label>';
		htmlRows += '<label class="switch">';
			htmlRows += '<input type="checkbox" id="expediente_nota_cierro_piel_'+count+'" name="expediente_nota_cierro_piel[]" value="1" disabled>">';
			htmlRows += '<div class="slider round"></div>">';
		htmlRows += '</label>';		
		htmlRows += '<span class="question mb-2" id="label_expediente_nota_cierro_piel_'+count+'"></span>';	
		htmlRows += '</div>';		
	htmlRows += '</div>';
	//FIN SELECTORE
	//FIN SEPTIMA FILA

	//INICIO OCTAVA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-12 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_comentarios">Comentarios</label>';
			htmlRows += '<textarea id="expediente_nota_comentarios_'+count+'" name="expediente_nota_comentarios[]" placeholder="Comentarios" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN OCTAVA FILA
	htmlRows += '<hr/>';

	$('#main_seguimiento_nota_operatorio').append(htmlRows);	
}

function llenarPostOperatorio(count){
	var htmlRows = '';
	//INICIO PRIMER FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_post_fecha_consulta">Fecha Consulta</label>';
			htmlRows += '<input type="date" required id="expediente_post_fecha_consulta_'+count+'" name="expediente_post_fecha_consulta[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_post_nch">NCH</label>';
			htmlRows += '<input type="text" required id="expediente_post_nch_'+count+'" name="expediente_post_nch[]" class="form-control" readonly />';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-1 mb-3">';                    	
			htmlRows += '<label for="expediente_post_talla">Talla</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" required id="expediente_post_talla_'+count+'" name="expediente_post_talla[]" class="form-control" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>M</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_post_peso_actual">Peso Actual LB</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_post_peso_actual_'+count+'" name="expediente_post_peso_actual[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_post_peso_actual_kg">Peso Actual KG</label>';
			htmlRows += '<div class="input-group mb-3">';
				htmlRows += '<input type="text" id="expediente_post_peso_actual_kg_'+count+'" name="expediente_post_peso_actual_kg[]" class="form-control" step="0.01" readonly />';
				htmlRows += '<div class="input-group-append">';
				htmlRows += '<span class="input-group-text"><div class="sb-nav-link-icon"></div>LB</i></span>';
			htmlRows += '</div>';
			htmlRows += '</div>';
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_post_imc_actual">IMC Actual</label>';
			htmlRows += '<input type="text" required id="expediente_post_imc_actual_'+count+'" name="expediente_post_imc_actual[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	
		htmlRows += '<div class="col-md-2 mb-3">';                    	
			htmlRows += '<label for="expediente_post_edad">Edad</label>';
			htmlRows += '<input type="text" id="expediente_post_edad_'+count+'" name="expediente_post_edad[]" class="form-control" readonly />';	
		htmlRows += '</div>';
	htmlRows += '</div>';	
	// FIN PRIMER FILA

	//INICIO SEGUNDA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_peso_perdido">Peso Perdido</label>';
			htmlRows += '<input type="text" required id="expediente_post_peso_perdido_'+count+'" name="expediente_post_peso_perdido[]" class="form-control" readonly />';	
		htmlRows += '</div>';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_ewl">%EWL</label>';
			htmlRows += '<input type="text" required id="expediente_post_ewl_'+count+'" name="expediente_post_ewl[]" class="form-control" readonly />';	
		htmlRows += '</div>';		
	htmlRows += '</div>';	
	//FIN SEGUNDA FILA

	//INICIO TERCERA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_otros">Otros</label>';
			htmlRows += '<textarea id="expediente_post_otros_'+count+'" name="expediente_post_otros[]" placeholder="Otros" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_mejoria_enfermedades">Mejoría Enfermedades</label>';
			htmlRows += '<textarea id="expediente_post_mejoria_enfermedades_'+count+'" name="expediente_post_mejoria_enfermedades[]" placeholder="Mejoría Enfermedades" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN TERCERA FILA

	//INICIO CUARTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_estado_actual">Estado Actual</label>';
			htmlRows += '<textarea id="expediente_post_estado_actual_'+count+'" name="expediente_post_estado_actual[]" placeholder="Estado Actual" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_medicamentos_que_usa">Medicamentos que Usa</label>';
			htmlRows += '<textarea id="expediente_post_medicamentos_que_usa_'+count+'" name="expediente_post_medicamentos_que_usa[]" placeholder="Medicamentos que Usa" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN CUARTA FILA	

	//INICIO QUITA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_hallazgos">Hallazgos</label>';
			htmlRows += '<textarea id="expediente_post_hallazgos_'+count+'" name="expediente_post_hallazgos[]" placeholder="Hallazgos" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_comentario">Comentario</label>';
			htmlRows += '<textarea id="expediente_post_comentario_'+count+'" name="expediente_post_comentario[]" placeholder="Comentario" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN QUITA FILA	
	
	//INICIO SEXTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-12 mb-3">';                    	
			htmlRows += '<label for="expediente_post_plan">Plan</label>';
			htmlRows += '<textarea id="expediente_post_plan_'+count+'" name="expediente_post_plan[]" placeholder="Plan" class="form-control" maxlength="2500" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN SEXTA FILA
	htmlRows += '<hr/>';

	$('#main_seguimiento_post_operatorio').append(htmlRows);	
}

$('#acciones_busqueda').on("click", function(e){
	$('#main_expediente_clinico').show();
	$('#view_expediente_clinico').hide();
	$('#label_busqueda').html("Búsqueda");
	$('#acciones_busqueda').addClass("active");
	$('#label_expediente_clinico').html("");
	$('#acciones_expediente').removeClass("active");
	$('#formulario_buscarAtencion #expediente_identidad').focus();
	$('#formulario_buscarAtencion')[0].reset();	
	$('#main_seguimiento_preo_operatorio').empty();
	$('#main_seguimiento_nota_operatorio').empty();
	$('#main_seguimiento_post_operatorio').empty();
});

function mostrarArchivos(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/mostrarSeguimiento.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id,
	   success: function(valores){
			$('#formulario_buscarAtencion #mostrar_datos').html(valores);	
			return false;
		}	
	});	
}

function mostrarArchivosNotaOperatoria(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/mostrarSeguimientoNotaOperatoria.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id,
	   success: function(valores){
			$('#formulario_buscarAtencion #mostrar_datos_nota_operatoria').html(valores);		
			return false;
		}	
	});	
}
</script>