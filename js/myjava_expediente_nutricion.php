<script>
$(document).ready(function() {
	pagination(1);
	mainExpediente();
	getConsultorio();
});

function getConsultorio(){
	var url = '<?php echo SERVERURL; ?>php/citas/getServicio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   success:function(data){
	      $('#formulario_buscarAtencion #atenciones_servicio_id').html("");
		  $('#formulario_buscarAtencion #atenciones_servicio_id').html(data); 		  
	  }
	});
	return false;	
}

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
	var url = '<?php echo SERVERURL; ?>php/expedienteClinicoNutricion/paginar.php';
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

	getHistoriaClincia(pacientes_id);
	getDetallesAtencion(pacientes_id);			
}

function getHistoriaClincia(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/consultarHistoriaClinica.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);
			if(datos[0] != ""){
				//DATOS DE LA HISTORIA CLINICA DEL PACIENTE
				$('#formulario_buscarAtencion #motivo_consulta').val(datos[0]);				
				$('#formulario_buscarAtencion #fecha_consulta').val(datos[1]);	
				$('#formulario_buscarAtencion #ante_perso').val(datos[2]);	
				$('#formulario_buscarAtencion #ante_fam').val(datos[3]);	
				$('#formulario_buscarAtencion #alergias').val(datos[4]);
				$('#formulario_buscarAtencion #adicciones').val(datos[5]);																									
				$('#formulario_buscarAtencion #niveles_estres').val(datos[6]);
				$('#formulario_buscarAtencion #niveles_actividad_fisica').val(datos[7]);
				$('#formulario_buscarAtencion #intento_perdida_peso').val(datos[8]);
				$('#formulario_buscarAtencion #antecedentes_quirurgicos').val(datos[9]);
				$('#formulario_buscarAtencion #observaciones').val(datos[10]);
				$('#formulario_buscarAtencion #atenciones_servicio_id').val(datos[10]);

				$('#formulario_buscarAtencion #diagnostico').val(datos[11]);
				$('#formulario_buscarAtencion #indicaciones').val(datos[12]);
				$('#formulario_buscarAtencion #atenciones_servicio_id').val(datos[17]);
				$('#formulario_buscarAtencion #edad_consulta').val(datos[18]);

				$('#formulario_buscarAtencion #candidato_bariatrica').attr('disabled', true);
				$('#formulario_buscarAtencion #atenciones_servicio_id').attr('disabled', true);

				if(datos[13] == 1){
					$('#formulario_buscarAtencion #candidato_bariatrica').attr('checked', true);
				}else{
					$('#formulario_buscarAtencion #candidato_bariatrica').attr('checked', false);
				}									
			}					
			return false;
		}
	});	
}

function getDetallesAtencion(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getAtencionesDetalles.php';
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'pacientes_id='+pacientes_id,
		success:function(data){
			$('#reporte_consulta').html(data);
		}
	});
	return false;
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


</script>