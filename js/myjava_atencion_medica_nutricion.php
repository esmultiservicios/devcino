<script>
$(document).ready(function() {
	getSexo();
	getStatusNutricion();
	getDepartamentos();
	getMunicipio();
	getPais();
	getResponsable();
	getProfesionPacientes();
	getProfesion();
	getMunicipio();
	getSexo();
	getConsultorioNutricion();
	$('.footer').show();
	$('.footer1').hide();
	evaluarRegistrosPendientes();
	evaluarRegistrosPendientesEmail();
	setInterval('pagination(1)',22000);
});	

$(document).ready(function() {
	setInterval('pagination(1)',22000); 	
	setInterval('evaluarRegistrosPendientes()',1800000 ); //CADA MEDIA HORA
	getColaborador();
});

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#modal_registro_atenciones").on('shown.bs.modal', function(){
        $(this).find('#formulario_atenciones #expediente').focus();
    });
});

$(document).ready(function(){
    $("#buscar_atencion").on('shown.bs.modal', function(){
        $(this).find('#formulario_buscarAtencion #busqueda').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

/****************************************************************************************************************************************************************/
//INICIO CONTROLES DE ACCION
$(document).ready(function() {
	//LLAMADA A LAS FUNCIONES
	funcionesFormPacientes();
	
	//INICIO ABRIR VENTANA MODAL PARA EL REGISTRO DE ATENCIONES DE PACIENTES
	$('#form_main_atencion_nutricion_medica #nuevoRegistro').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
			$('#formulario_atenciones')[0].reset();	
			$('#formulario_atenciones #pro').val('Registro');
			$('#reg_atencion').show();
			$('#edi_atencion').hide();

			$('#formulario_atenciones #paciente_consulta').attr('disabled', false);	
			$('#formulario_atenciones #fecha').attr('readonly', true);			
			$('#formulario_atenciones #buscar_pacientes_atenciones').show();	
			$('#formulario_atenciones #atenciones_servicio_id').attr('disabled', false);					
			$('#formulario_atenciones #buscar_servicios_atenciones').show();	
				
			//HABILITAR OBJETOS
			$('#formulario_atenciones #paciente_consulta').attr('disabled', false);			 

			$('#formulario_atenciones').attr({ 'data-form': 'save' }); 
			$('#formulario_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarExpedienteClinico.php' });	

			$('#modal_registro_atenciones').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			return false;
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});	 		 
		}			
	});
	//FIN ABRIR VENTANA MODAL PARA EL REGISTRO DE ATENCIONES DE PACIENTES
	
	//INICIO CONSULTRAR USUARIOS ATENDIDOS
	$('#form_main_atencion_nutricion_medica #historial').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
			e.preventDefault();
             paginationBusqueda(1);
			 $('#formulario_buscarAtencion #pro').val("Búsqueda de Atenciones");
			 $('#formulario_buscarAtencion #paciente_consulta').html("");
			 $('#formulario_buscarAtencion #agrega_registros_busqueda_').html('<td colspan="3" style="color:#C7030D">No se encontraron resultados, seleccione un paciente para visualizar sus datos</td>');
			 $('#buscar_atencion').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			 });  
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});	 
		}	 
	});	
	//FIN CONSULTRAR USUARIOS ATENDIDOS

    //INICIO PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
	$('#form_main_atencion_nutricion_medica #bs_regis').on('keyup',function(){
	  pagination(1);
	});

	$('#form_main_atencion_nutricion_medica #fecha_b').on('change',function(){
	  pagination(1);
	});

	$('#form_main_atencion_nutricion_medica #fecha_f').on('change',function(){
	  pagination(1);
	});	  

	$('#form_main_atencion_nutricion_medica #estado').on('change',function(){
	  pagination(1);
	});
	
	$('#formulario_buscarAtencion #busqueda').on('keyup',function(){
	  paginationBusqueda(1);
      $('#formulario_buscarAtencion #paciente_consulta').html('');
	  $('#formulario_buscarAtencion #agrega_registros_busqueda_').html('<td colspan="12" style="color:#C7030D">No se encontraron resultados</td>');
	  $('#formulario_buscarAtencion #pagination_busqueda_').html('');	  
	});	
	//FIN PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
	  
});
//FIN CONTROLES DE ACCION
/****************************************************************************************************************************************************************/

//INICIO FUNCION PARA OBTENER LOS COLABORADORES
function editarRegistroPacientesNutricion(pacientes_id, agenda_id, colaborador_id, servicio_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){	
	   if( getAtencionPacienteNutricion(agenda_id) == 0 ){
			$('#formulario_atenciones')[0].reset();		
			var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editar.php';

				$.ajax({
				type:'POST',
				url:url,
				data:'pacientes_id='+pacientes_id+'&agenda_id='+agenda_id,
				success: function(valores){
					var array = eval(valores);
					$('#reg_atencion').hide();
					$('#edi_atencion').show();
					$('#formulario_atenciones #pro').val('Registro');
					$('#formulario_atenciones #pacientes_id').val(pacientes_id);
					$('#formulario_atenciones #colaborador_id').val(colaborador_id);
					$('#formulario_atenciones #servicio_id').val(servicio_id);
					$('#formulario_atenciones #atenciones_servicio_id').val(servicio_id);					
					$('#formulario_atenciones #agenda_id').val(agenda_id);
					$('#formulario_atenciones #paciente_consulta').val(array[1]);					 
					$('#formulario_atenciones #edad').val(array[2]);
					$('#formulario_atenciones #edad_consulta').val(array[3]);					
					
					//DESHABILITAR OBJETOS			
					$('#formulario_atenciones #fecha').attr('readonly', true);
					$('#formulario_atenciones #paciente_consulta').attr('disabled', true);					
					$('#formulario_atenciones #buscar_pacientes_atenciones').hide();	
					$('#formulario_atenciones #atenciones_servicio_id').attr('disabled', true);					
					$('#formulario_atenciones #buscar_servicios_atenciones').hide();
					caracteresCirugiaAbdominalExpedienteClinico();
					caracteresDiagnosticoExpedienteClinico();					

					$('#formulario_atenciones').attr({ 'data-form': 'save' }); 
					$('#formulario_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarExpedienteClinico.php' });

					$('#modal_registro_atenciones').modal({
						show:true,
						keyboard: false,
						backdrop:'static'
					});
					return false;
				}
			});
			return false;
 	   }else{
			swal({
				title: "Error", 
				text: "Lo sentimos, este registro ya existe, no se puede agregar su atención",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});				
	   }
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});		   
	}		
}

//INICIO FUNCION AUSENCIA DE USUARIOS
function nosePresentoRegistro(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		var nombre_usuario = consultarNombreNutricion(pacientes_id);
		var expediente_usuario = consultarExpedienteNutricion(pacientes_id);
		var dato;

		if(expediente_usuario == 0){
			dato = nombre_usuario;
		}else{
			dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
		}

		swal({
			title: "¿Esta seguro?",
			text: "¿Desea remover este usuario: " + dato + " que no se presento a su cita?",
			content: {
				element: "input",
				attributes: {
					placeholder: "Comentario",
					type: "text",
				},
			},
			icon: "warning",
			buttons: {
				cancel: "Cancelar",
				confirm: {
					text: "¡Sí, remover el usuario!",
					closeModal: false,
				},
			},
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera			
		}).then((value) => {
			if (value === null || value.trim() === "") {
				swal("¡Necesita escribir algo!", { icon: "error" });
				return false;
			}
			eliminarRegistro(agenda_id, value);
		});				  
	 }else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});					 
	  }	
}

function eliminarRegistro(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/usuario_no_presento.php';
	
    $.ajax({
	  type:'POST',
	  url:url,
	  data:'agenda_id='+agenda_id+'&fecha='+fecha+'&comentario='+comentario,
	  success: function(registro){
		  if(registro == 1){
			swal({
				title: "Success", 
				text: "Ausencia almacenada correctamente",
				icon: "success",
				timer: 1000, //timeOut for auto-close
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera				
			});
			pagination(1);
			return false; 
		  }else if(registro == 2){	
				swal({
					title: "Error", 
					text: "Error al remover este registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
				return false; 
		  }else if(registro == 3){	
				swal({
					title: "Error", 
					text: "Este registro ya tiene almacenada una ausencia",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
				return false; 
		  }else{		
				swal({
					title: "Error", 
					text: "Error al ejecutar esta acción",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});					 
		  }
	  }
   });
   return false;		
}
//FIN FUNCION AUSENCIA DE USUARIOS

//INICIO FUNCION UITAR ATENCION
function CulminarAtencionPacienteNutricion(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){		
		if(getAtencionPacienteNutricion(agenda_id) == 0){ 			  
			  var nombre_usuario = consultarNombreNutricion(pacientes_id);
			  var expediente_usuario = consultarExpedienteNutricion(pacientes_id);
			  var dato;

			  if(expediente_usuario == 0){
				  dato = nombre_usuario;
			  }else{
				  dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
			  }

			  swal({
				title: "¿Esta seguro?",
				text: "¿Desea marcar la atención para el paciente: " + dato + " Atención culminada",
				content: {
					element: "input",
					attributes: {
						placeholder: "Comentario",
						type: "text",
					},
				},
				icon: "warning",
				buttons: {
					cancel: "Cancelar",
					confirm: {
						text: "¡Sí, marcar la atención!",
						closeModal: false,
					},
				},
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera				
			}).then((value) => {
				if (value === null || value.trim() === "") {
					swal("¡Necesita escribir algo!", { icon: "error" });
					return false;
				}
				marcarAtencionNutricion(agenda_id, inputValue);
			});	
	   }else{	
			swal({
				title: "Error", 
				text: "Error al ejecutar esta acción, el usuario debe estar en estatus pendiente",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});			  
	   }
	 }else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});					 
	  }	
}

function marcarAtencionNutricion(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/marcarAtencion.php';
	
    $.ajax({
	  type:'POST',
	  url:url,
	  data:'agenda_id='+agenda_id+'&fecha='+fecha+'&comentario='+comentario,
	  success: function(registro){
		var datos = eval(registro);
		
		if (datos[1] == "AtencionMedica"){
			showFacturaAgendaNutricion(datos[2]);//LLAMAMOS LA FACTURA .-Función se encuenta en myjava_atencioN_medica.js
		}
		
		if(datos[0] == 1){
			swal({
				title: "Success", 
				text: "Atencion marcada correctamente",
				icon: "success",
				timer: 1000, //timeOut for auto-close
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera				
			});
			pagination(1);
		}else if(datos[0] == 2){
			swal({
				title: "Error", 
				text: "Error al marcar la atención",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});
			return false;		 
		}else{
			swal({
				title: "Error", 
				text: "Error al ejecutar esta acción",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});				
		}
	  }
   });
   return false;		
}
//FIN FUNCION QUITAR ATENCION

//INICIO PAGINACION DE REGISTROS
function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/paginar.php';
    var fechai = $('#form_main_atencion_nutricion_medica #fecha_b').val();
	var fechaf = $('#form_main_atencion_nutricion_medica #fecha_f').val();
	var dato = '';
	var estado = '';
	
    if($('#form_main_atencion_nutricion_medica #estado').val() == "" || $('#form_main_atencion_nutricion_medica #estado').val() == null){
		estado = 0;
	}else{
		estado = $('#form_main_atencion_nutricion_medica #estado').val();
	}
	
	if($('#form_main_atencion_nutricion_medica #bs_regis').val() == "" || $('#form_main_atencion_nutricion_medica #bs_regis').val() == null){
		dato = '';
	}else{
		dato = $('#form_main_atencion_nutricion_medica #bs_regis').val();
	}

	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&fechai='+fechai+'&fechaf='+fechaf+'&dato='+dato+'&estado='+estado,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}
//FIN PAGINACION DE REGISTROS

//INICIO PAGINACION DE HISTORIAL DE ATENCIONES
function paginationBusqueda(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/paginar_buscar.php';

	if($('#formulario_buscarAtencion #busqueda').val() == "" || $('#formulario_buscarAtencion #busqueda').val() == null){
		dato = '';
	}else{
		dato = $('#formulario_buscarAtencion #busqueda').val();
	}
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&dato='+dato,
		success:function(data){
			var array = eval(data);
			$('#formulario_buscarAtencion #agrega_registros_busqueda').html(array[0]);
			$('#formulario_buscarAtencion #pagination_busqueda').html(array[1]);
		}
	});
	return false;
}
//FIN PAGINACION DE HISTORIAL DE ATENCIONES

//INICIO OBTENER EL AGENDA ID, DE LA ENTIDAD AGENDA DE PACIENTES
function getAgendaIDNutricion(pacientes_id, fecha, servicio){	
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getAgendaID.php';
	var agenda_id;
	
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		data:'pacientes_id='+pacientes_id+'&fecha='+fecha+'&servicio='+servicio,
		success:function(data){		
          agenda_id = data;			  		  		  			  
		}
	});
	return agenda_id;	
}
//FIN OBTENER EL AGENDA ID, DE LA ENTIDAD AGENDA DE PACIENTES

//INICIO AGRUPAR FUNCIONES DE PACIENTES
function funcionesFormPacientes(){
	getServicioTransito();
	getServicioAtencionNutricion();
	getEstadoNutricion();
	getProfesion();
	getReligion();
	getEstadoCivil();
	getConsultorioNutricion();
	pagination(1);
}
//FIN AGRUPAR FUNCIONES DE PACIENTES

//INICIO OBTENER EL NOMBRE DEL PACIENTE
function getNombrePacienteNutricion(pacientes_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getNombrePaciente.php';
	var paciente;
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          paciente = data;			  		  		  			  
		}
	});
	return paciente;	
}
//FIN OBTENER EL NOMBRE DEL PACIENTE

//INICIO PARA OBTENER EL COLABORADOR_ID
function getColaborador_idNutricion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getColaborador.php';
	var colaborador_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){	
          colaborador_id = data;			  		  		  			  
		}
	});
	return colaborador_id;	
}
//FIN PARA OBTENER EL COLABORADOR_ID	

//INICIO PARA OBTENER EL SERVICIO DEL FORMULARIO DE PACIENTES
function getServicioAtencionNutricion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/servicios.php';
	
	var servicio_id;
	$.ajax({
	    type:'POST',
		data:'agenda_id='+agenda_id,
		url:url,
		async: false,
		success:function(data){	
          servicio_id = data;			  		  		  			  
		}
	});
	return servicio_id;		
}
//FIN PARA OBTENER EL SERVICIO DEL FORMULARIO DE PACIENTES

//INICIO PARA OBTENER EL ESTADO DE LOS PACIENTES (ATENDIDOS, AUSENTES)
function getEstadoNutricion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getEstado.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){		
		    $('#form_main_atencion_nutricion_medica #estado').html("");
			$('#form_main_atencion_nutricion_medica #estado').html(data);	
		}			
     });		
}
//FIN PARA OBTENER EL ESTADO DE LOS PACIENTES (ATENDIDOS, AUSENTES)

//INICIO PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL
function evaluarRegistrosPendientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/evaluarPendientes.php';
	var string = '';
	
	$.ajax({
	    type:'POST',
		data:'fecha='+fecha,
		url:url,
		success: function(valores){	
		   var datos = eval(valores);
		   if(datos[0]>0){			   
			  if(datos[0] == 1 || datos[0] == 0){
				  string = 'Registro pendiente';
			  }else{
				  string = 'Registros pendientes';
			  }
			  			  
			  swal({
					title: 'Advertencia', 
					text: "Se le recuerda que tiene " + datos[0] + " " + string + " de subir en las Atenciones Medicas en este mes de " + datos[1] + ". Debe revisar sus registros pendientes.", 
					icon: 'warning', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			  });			  
		   }
           		  		  		  			  
		}
	});	
}
//FIN PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL

//INICIO PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL Y ENVIARLOS POR CORREO ELECTRONICO COMO RECORDATORIO
function evaluarRegistrosPendientesEmail(){
    var url = '<?php echo SERVERURL; ?>php/mail/evaluarPendientes_atencionesMedicas.php';
	
	$.ajax({
	    type:'POST',
		url:url,
		success: function(valores){	
           		  		  		  			  
		}
	});	
}
//FIN PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL Y ENVIARLOS POR CORREO ELECTRONICO COMO RECORDATORIO

function getConsultorioNutricion(){
	var url = '<?php echo SERVERURL; ?>php/citas/getServicio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   success:function(data){
	      $('#formulario_antecedentes #atenciones_servicio_id').html("");
		  $('#formulario_antecedentes #atenciones_servicio_id').html(data); 		  
	  }
	});
	return false;	
}

function convertDate(inputFormat) {
	function pad(s) { return (s < 10) ? '0' + s : s; }
	var d = new Date(inputFormat);
	return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

function getMesNutricion(fecha){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getMes.php';
	var resp;
	
	$.ajax({
	    type:'POST',
		data:'fecha='+fecha,
		url:url,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp	;	
}

function consultarNombreNutricion(pacientes_id){	
    var url = '<?php echo SERVERURL; ?>php/pacientes/getNombre.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp;	
}

function consultarExpedienteNutricion(pacientes_id){	
    var url = '<?php echo SERVERURL; ?>php/pacientes/getExpedienteInformacion.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp;		
}
/**********************************************************************************************************************************************************************************************/
/**********************************************************************************************************************************************************************************************/
$('#formulario_atenciones #buscar_religion_atenciones').on('click', function(e){
	listar_religion_buscar();
	 $('#modal_busqueda_religion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

$('#formulario_atenciones #buscar_profesion_atenciones').on('click', function(e){
	listar_profesion_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

//INICIO FORMULARIO DE BUSQUEDA DE ATENCIONES
function cleanPacientes(){
	$('#formulario_pacientes #validate').removeClass('bien_email');	
	$('#formulario_pacientes #validate').removeClass('error_email');
	$('#formulario_pacientes #validate').html('');	
	$("#formulario #correo").css("border-color", "none");	
}

$('#formulario_atenciones #buscar_pacientes_atenciones').on('click', function(e){
	listar_pacientes_buscar_atenciones();
	 $('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_pacientes_buscar_atenciones = function(){
	var table_pacientes_buscar_atenciones = $("#dataTablePacientes").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getPacientesTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"paciente"},
			{"data":"identidad"},
			{"data":"expediente"},
			{"data":"email"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
		"dom": dom,
		"buttons":[
			{
				text:      '<i class="fas fa-sync-alt fa-lg"></i> Actualizar',
				titleAttr: 'Actualizar Clientes',
				className: 'actualizar btn btn-secondary',
				action: 	function(){
					listar_pacientes_buscar_atenciones();
				}
			},
			{
				text:      '<i class="fas fas fa-plus fa-lg crear"></i> Crear',
				titleAttr: 'Agregar Clientes',
				className: 'crear btn btn-primary',
				action: 	function(){
					modal_clientes();
				}
			}
		]
	});	 
	table_pacientes_buscar_atenciones.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_atenciones_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_atenciones);
}

var view_pacientes_busqueda_atenciones_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_atenciones #pacientes_id').val(data.pacientes_id);
		$('#formulario_atenciones #paciente_consulta').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/buscar_expediente.php';
        var pacientes_id = data.pacientes_id;
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formulario_atenciones #edad').val(array[2]);
				$('#formulario_atenciones #edad_consulta').val(array[3]);	
				$("#reg_atencion").attr('disabled', false);
				return false;			 				
			}		  			  
	    });
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA DE ATENCIONES

//INICIO BUSQUEDA DE SERVICIOS DE ATENCIONES
$('#formulario_atenciones #buscar_servicios_atenciones').on('click', function(e){
	listar_servicios_buscar();
	 $('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_servicios_buscar = function(){
	var table_servicios_buscar = $("#dataTableServicios").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/citas/getServiciosTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_servicios_buscar.search('').draw();
	$('#buscar').focus();
	
	view_servicios_busqueda_dataTable("#dataTableServicios tbody", table_servicios_buscar);
}

var view_servicios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_atenciones #atenciones_servicio_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA DE SERVICIOS DE ATENCIONES

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#modal_busqueda_profesion").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_profesion #buscar').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_religion").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_religion #buscar').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_pacientes").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_pacientes #buscar').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

$('#form_main_atencion_nutricion_medica #nueva_factura').on('click', function(e){
	e.preventDefault();
	formFactura();
});

function formFactura(){
	 $('#formulario_facturacion')[0].reset();
	 $('#main_facturacion').hide();	
	 $('#facturacion').show();	
	 $('#label_acciones_volver').html("Volver");
	 $('#acciones_atras').removeClass("active");
	 $('#acciones_factura').addClass("active");
	 $('#label_acciones_factura').html("Factura");
	 $('#formulario_facturacion #fecha').attr('readonly', true);
	 $('#formulario_facturacion #grupo_buscar_colaboradores').show();
	 $('#formulario_facturacion #colaborador_id').val(getColaborador_idNutricion());
	 $('#formulario_facturacion #colaborador_nombre').val(getProfesionalNutricion());
	 $('#formulario_facturacion').attr({ 'data-form': 'save' }); 
	 $('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/facturacion/addPreFactura.php' }); 	 
	 limpiarTabla();

	 $('.footer').hide();
	 $('.footer1').show();	 
	 $('#formulario_facturacion #validar').hide();	
	 $('#formulario_facturacion #guardar1').hide();
}

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 if($('#formulario_facturacion #cliente_nombre').val() != "" || $('#formulario_facturacion #colaborador_nombre').val() != ""){
		swal({
			title: "Tiene datos en la factura",
			text: "¿Esta seguro que desea volver, recuerde que tiene información en la factura la perderá?",
			icon: "warning",
			buttons: {
				cancel: {
					text: "Cancelar",
					visible: true
				},
				confirm: {
					text: "¡Si, deseo volver!",
				}
			},
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		}).then((willConfirm) => {
			if (willConfirm === true) {
				$('#main_facturacion').show();
				$('#label_acciones_factura').html("");
				$('#facturacion').hide();
				$('#acciones_atras').addClass("breadcrumb-item active");
				$('#acciones_factura').removeClass("active");
				$('#formulario_facturacion')[0].reset();
				$('.footer').show();
				$('.footer1').hide();
			}
		});	 			 	
	 }else{	 
		 $('#main_facturacion').show();
		 $('#label_acciones_factura').html("");
		 $('#facturacion').hide();
		 $('#acciones_atras').addClass("breadcrumb-item active");
		 $('#acciones_factura').removeClass("active");
		 $('.footer').show();
		 $('.footer1').hide();		 	 
	 }
});

$(document).ready(function(){
	getServicio();
	listar_pacientes_buscar();
	listar_servicios_buscar();
	listar_servicios_factura_buscar();
	listar_productos_facturas_buscar();
});

function getProfesionalNutricion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getProfesional.php';
	var profesional
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){	
          profesional = data;			  		  		  			  
		}
	});
	return profesional;	
}

function showFacturaNutricion(atenciones_nutricion_detalles_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarFactura.php';
	
	$.ajax({
	    type:'POST',
		url:url,
		data:'atenciones_nutricion_detalles_id='+atenciones_nutricion_detalles_id,
		success:function(data){	
		    var datos = eval(data);
	        $('#formulario_facturacion')[0].reset();
	        $('#formulario_facturacion #pro').val("Registro");
			$('#formulario_facturacion #pacientes_id').val(datos[0]);
            $('#formulario_facturacion #cliente_nombre').val(datos[1]);
            $('#formulario_facturacion #fecha').val(getFechaActualNutricion());
            $('#formulario_facturacion #colaborador_id').val(datos[3]);
			$('#formulario_facturacion #colaborador_nombre').val(datos[4]);
			$('#formulario_facturacion #factura_servicio_id').val(datos[5]);
			$('#formulario_facturacion #grupo_buscar_colaboradores').hide();			
			$('#label_acciones_volver').html("ATA");
			$('#label_acciones_receta').html("Receta");
			
			$('#formulario_facturacion #fecha').attr("readonly", true);
			$('#formulario_facturacion #validar').attr("disabled", false);
			$('#formulario_facturacion #addRows').attr("disabled", false);
			$('#formulario_facturacion #removeRows').attr("disabled", false);
		    $('#formulario_facturacion #validar').show();
		    $('#formulario_facturacion #editar').hide();
		    $('#formulario_facturacion #eliminar').hide();
			limpiarTabla();				
			
			$('#main_facturacion').hide();	
			$('#facturacion').show();
			$('#main_atencion_nutricion').hide();
			
			$('#formulario_facturacion').attr({ 'data-form': 'save' }); 
			$('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/facturacion/addPreFactura.php' });
			
			$('#formulario_facturacion #validar').hide();
			$('#formulario_facturacion #guardar1').hide();
			
			$('.footer').hide();
			$('.footer1').show();	
			
			cleanFooterValueBill();
		}
	});
}

function showFacturaAgendaNutricion(agenda_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarFacturaAgenda.php';
	
	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		success:function(data){	
		    var datos = eval(data);
	        $('#formulario_facturacion')[0].reset();
	        $('#formulario_facturacion #pro').val("Registro");
			$('#formulario_facturacion #pacientes_id').val(datos[0]);
            $('#formulario_facturacion #cliente_nombre').val(datos[1]);
            $('#formulario_facturacion #fecha').val(getFechaActualNutricion());
            $('#formulario_facturacion #colaborador_id').val(datos[3]);
			$('#formulario_facturacion #colaborador_nombre').val(datos[4]);
			$('#formulario_facturacion #factura_servicio_id').val(datos[5]);
			$('#formulario_facturacion #grupo_buscar_colaboradores').hide();			
			$('#label_acciones_volver').html("ATA");
			$('#label_acciones_receta').html("Receta");
			
			$('#formulario_facturacion #fecha').attr("readonly", true);
			$('#formulario_facturacion #validar').attr("disabled", false);
			$('#formulario_facturacion #addRows').attr("disabled", false);
			$('#formulario_facturacion #removeRows').attr("disabled", false);
		    $('#formulario_facturacion #validar').show();
		    $('#formulario_facturacion #editar').hide();
		    $('#formulario_facturacion #eliminar').hide();
			limpiarTabla();				
			
			$('#main_facturacion').hide();	
			$('#facturacion').show();
			
			$('#formulario_facturacion #validar').hide();
			$('#formulario_facturacion #guardar1').hide();			
			
			$('#formulario_facturacion').attr({ 'data-form': 'save' }); 
			$('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/facturacion/addPreFactura.php' }); 
			
			$('.footer').hide();
			$('.footer1').show();			
		}
	});
}

$(document).ready(function() {
	$('#formulario_atenciones #fecha_nac').on('change', function(){
		var fecha_nac = $('#formulario_atenciones #fecha_nac').val();
		var url = '<?php echo SERVERURL; ?>php/pacientes/getEdad.php';		
			
		$.ajax({
			type: "POST",
			url: url,
			async: true,
			data:'fecha_nac='+fecha_nac,
			success: function(data){
				var array = eval(data);	
				$('#formulario_atenciones #edad').val(array[3]);
			}
		 });
	});		 
});

function volver(){
	$('#main_facturacion').show();
	$('#label_acciones_factura').html("");
	$('#facturacion').hide();
	$('#main_atencion_nutricion').hide();
	$('#acciones_atras').addClass("breadcrumb-item active");
	$('#acciones_factura').removeClass("active");
	$('.footer').show();
	$('.footer1').hide();			
}

function getFechaActualNutricion(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getFechaActual.php';
	var fecha_actual;

	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
          fecha_actual = data;
		}
	});
	return fecha_actual;	
}

//INICIO FORMULARIO ANTECEDENTES
$('#formulario_antecedentes #ante_perso').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_ante_perso').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesPersonales(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #ante_perso').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_ante_perso').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #ante_fam').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_ante_fam').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesFamiliares(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #ante_fam').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_ante_fam').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #alergias').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_alergias').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAlergias(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #alergias').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_alergias').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #adicciones').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_adicciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAdicciones(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #adicciones').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_adicciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #niveles_estres').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_niveles_estres').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresNivelesEstres(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #niveles_estres').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_niveles_estres').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #niveles_actividad_fisica').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_niveles_actividad_fisica').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresActividadFisica(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #niveles_actividad_fisica').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_niveles_actividad_fisica').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #intento_perdida_peso').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_intento_perdida_peso').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresIntentoPerdidaPeso(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #intento_perdida_peso').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_intento_perdida_peso').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #antecedentes_quirurgicos').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_antecedentes_quirurgicos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesQuirurgicos(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #antecedentes_quirurgicos').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_antecedentes_quirurgicos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #observaciones').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_observaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresObservaciones(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #observaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_observaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #diagnostico').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_diagnostico').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresDiagnostico(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #diagnostico').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_diagnostico').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_antecedentes #indicaciones').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_indicaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresIndicaciones(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #indicaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_indicaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}


$('#formulario_antecedentes #alimentos').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_antecedentes #charNum_alimentos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAlimentos(){
	var max_chars = 1000;
	var chars = $('#formulario_antecedentes #alimentos').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_antecedentes #charNum_alimentos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN FORMULARIO ANTECEDENTES
	
$(document).ready(function() {
	//INICIO FORMULARIO ANTECEDENTES
	$('#formulario_antecedentes #search_ante_perso_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_ante_perso_start').on('click',function(event){
		$('#formulario_antecedentes #search_ante_perso_start').hide();
		$('#formulario_antecedentes #search_ante_perso_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #ante_perso').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #ante_perso').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesPersonales();
					}else{
						$('#formulario_antecedentes #ante_perso').val(finalResult);
						caracteresAntecedentesPersonales();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_ante_perso_stop').on("click", function(event){
		$('#formulario_antecedentes #search_ante_perso_start').show();
		$('#formulario_antecedentes #search_ante_perso_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_ante_fam_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_ante_fam_start').on('click',function(event){
		$('#formulario_antecedentes #search_ante_fam_start').hide();
		$('#formulario_antecedentes #search_ante_fam_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #ante_fam').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #ante_fam').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesFamiliares();
					}else{
						$('#formulario_antecedentes #ante_fam').val(finalResult);
						caracteresAntecedentesFamiliares();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_ante_fam_stop').on("click", function(event){
		$('#formulario_antecedentes #search_ante_fam_start').show();
		$('#formulario_antecedentes #search_ante_fam_stop').hide();
		recognition.stop();
	});		
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_alergias_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_alergias_start').on('click',function(event){
		$('#formulario_antecedentes #search_alergias_start').hide();
		$('#formulario_antecedentes #search_alergias_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #alergias').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #alergias').val(valor_anterior + ' ' + finalResult);
						caracteresAlergias();
					}else{
						$('#formulario_antecedentes #alergias').val(finalResult);
						caracteresAlergias();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_alergias_stop').on("click", function(event){
		$('#formulario_antecedentes #search_alergias_start').show();
		$('#formulario_antecedentes #search_alergias_stop').hide();
		recognition.stop();
	});		
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_adicciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_adicciones_start').on('click',function(event){
		$('#formulario_antecedentes #search_adicciones_start').hide();
		$('#formulario_antecedentes #search_adicciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #adicciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #adicciones').val(valor_anterior + ' ' + finalResult);
						caracteresAdicciones();
					}else{
						$('#formulario_antecedentes #adicciones').val(finalResult);
						caracteresAdicciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_adicciones_stop').on("click", function(event){
		$('#formulario_antecedentes #search_adicciones_start').show();
		$('#formulario_antecedentes #search_adicciones_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_niveles_estres_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_niveles_estres_start').on('click',function(event){
		$('#formulario_antecedentes #search_niveles_estres_start').hide();
		$('#formulario_antecedentes #search_niveles_estres_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #niveles_estres').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #niveles_estres').val(valor_anterior + ' ' + finalResult);
						caracteresNivelesEstres();
					}else{
						$('#formulario_antecedentes #niveles_estres').val(finalResult);
						caracteresNivelesEstres();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_niveles_estres_stop').on("click", function(event){
		$('#formulario_antecedentes #search_niveles_estres_start').show();
		$('#formulario_antecedentes #search_niveles_estres_stop').hide();
		recognition.stop();
	});
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_niveles_actividad_fisica_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_niveles_actividad_fisica_start').on('click',function(event){
		$('#formulario_antecedentes #search_niveles_actividad_fisica_start').hide();
		$('#formulario_antecedentes #search_niveles_actividad_fisica_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #niveles_actividad_fisica').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #niveles_actividad_fisica').val(valor_anterior + ' ' + finalResult);
						caracteresActividadFisica();
					}else{
						$('#formulario_antecedentes #niveles_actividad_fisica').val(finalResult);
						caracteresActividadFisica();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_niveles_actividad_fisica_stop').on("click", function(event){
		$('#formulario_antecedentes #search_niveles_actividad_fisica_start').show();
		$('#formulario_antecedentes #search_niveles_actividad_fisica_stop').hide();
		recognition.stop();
	});
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_intento_perdida_peso_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_intento_perdida_peso_start').on('click',function(event){
		$('#formulario_antecedentes #search_intento_perdida_peso_start').hide();
		$('#formulario_antecedentes #search_intento_perdida_peso_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #intento_perdida_peso').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #intento_perdida_peso').val(valor_anterior + ' ' + finalResult);
						caracteresIntentoPerdidaPeso();
					}else{
						$('#formulario_antecedentes #intento_perdida_peso').val(finalResult);
						caracteresIntentoPerdidaPeso();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_intento_perdida_peso_stop').on("click", function(event){
		$('#formulario_antecedentes #search_intento_perdida_peso_start').show();
		$('#formulario_antecedentes #search_intento_perdida_peso_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_antecedentes_quirurgicos_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_antecedentes_quirurgicos_start').on('click',function(event){
		$('#formulario_antecedentes #search_antecedentes_quirurgicos_start').hide();
		$('#formulario_antecedentes #search_antecedentes_quirurgicos_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #antecedentes_quirurgicos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #antecedentes_quirurgicos').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesQuirurgicos();
					}else{
						$('#formulario_antecedentes #antecedentes_quirurgicos').val(finalResult);
						caracteresAntecedentesQuirurgicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_antecedentes_quirurgicos_stop').on("click", function(event){
		$('#formulario_antecedentes #search_antecedentes_quirurgicos_start').show();
		$('#formulario_antecedentes #search_antecedentes_quirurgicos_stop').hide();
		recognition.stop();
	});		
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_observaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_observaciones_start').on('click',function(event){
		$('#formulario_antecedentes #search_observaciones_start').hide();
		$('#formulario_antecedentes #search_observaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #observaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #observaciones').val(valor_anterior + ' ' + finalResult);
						caracteresObservaciones();
					}else{
						$('#formulario_antecedentes #observaciones').val(finalResult);
						caracteresObservaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_observaciones_stop').on("click", function(event){
		$('#formulario_antecedentes #search_observaciones_start').show();
		$('#formulario_antecedentes #search_observaciones_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_diagnostico_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_diagnostico_start').on('click',function(event){
		$('#formulario_antecedentes #search_diagnostico_start').hide();
		$('#formulario_antecedentes #search_diagnostico_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #diagnostico').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #diagnostico').val(valor_anterior + ' ' + finalResult);
						caracteresDiagnostico();
					}else{
						$('#formulario_antecedentes #diagnostico').val(finalResult);
						caracteresDiagnostico();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_diagnostico_stop').on("click", function(event){
		$('#formulario_antecedentes #search_diagnostico_start').show();
		$('#formulario_antecedentes #search_diagnostico_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_indicaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_indicaciones_start').on('click',function(event){
		$('#formulario_antecedentes #search_indicaciones_start').hide();
		$('#formulario_antecedentes #search_indicaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #indicaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #indicaciones').val(valor_anterior + ' ' + finalResult);
						caracteresIndicaciones();
					}else{
						$('#formulario_antecedentes #indicaciones').val(finalResult);
						caracteresIndicaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_indicaciones_stop').on("click", function(event){
		$('#formulario_antecedentes #search_indicaciones_start').show();
		$('#formulario_antecedentes #search_indicaciones_stop').hide();
		recognition.stop();
	});	
	/*###############################################################################################################################*/
	$('#formulario_antecedentes #search_alimentos_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_antecedentes #search_alimentos_start').on('click',function(event){
		$('#formulario_antecedentes #search_alimentos_start').hide();
		$('#formulario_antecedentes #search_alimentos_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_antecedentes #alimentos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_antecedentes #alimentos').val(valor_anterior + ' ' + finalResult);
						caracteresAlimentos();
					}else{
						$('#formulario_antecedentes #alimentos').val(finalResult);
						caracteresAlimentos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_antecedentes #search_alimentos_stop').on("click", function(event){
		$('#formulario_antecedentes #search_alimentos_start').show();
		$('#formulario_antecedentes #search_alimentos_stop').hide();
		recognition.stop();
	});												
	//FIN FORMULARIO ANTECEDENTES
});	

//INICIO BUSQUEDA SERVICIOS
$('#formulario_facturacion #buscar_servicios').on('click', function(e){
	e.preventDefault();
	listar_servicios_factura_buscar();
	$('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

var listar_servicios_factura_buscar = function(){
	var table_servicios_factura_buscar = $("#dataTableServicios").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getServiciosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"},		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_servicios_factura_buscar.search('').draw();
	$('#buscar').focus();
	
	view_servicios_busqueda_dataTable("#dataTableServicios tbody", table_servicios_factura_buscar);
}

var view_servicios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		$('#formulario_facturacion #factura_servicio_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA SERVICIOS
//CONSULTAR ATENCION DE PACIENTE
function getAtencionPacienteNutricion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getAtencionPaciente.php';
	var atencion;
	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
			atencion = data;			  		  		  			  
		}
	});
	return atencion;	
}

function setAtencionNutricion(pacientes_id, colaborador_id, servicio_id, agenda_id){
	$('#main_facturacion').hide();
	$('#main_atencion_nutricion').show();
	$('#formulario_alimentos #grupo_pacientes').hide();


	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/consultarPaciente.php';
		   $.ajax({
			   type:'POST',
			   url:url,
			   data:'pacientes_id='+pacientes_id,
			   success: function(valores){
					var datos = eval(valores);
					$('#regPacientesNutricion').hide();
					$('#ediPacientesNutricion').show();	
					$('#grupo_pacientes').hide();

					$('#formulario_pacientes_atenciones #pro').val('Edición');
					$('#formulario_pacientes_atenciones #grupo_expediente').show();
					$('#formulario_pacientes_atenciones #pacientes_id').val(pacientes_id);
					$('#formulario_alimentos #paciente_alimentos_id').val(pacientes_id);
					$('#formulario_pacientes_atenciones #fecha_cita').val(getFechaCitaNutricion(agenda_id));
					$('#formulario_seguimiento #fecha_cita').val(getFechaCitaNutricion(agenda_id));										
					$('#formulario_pacientes_atenciones #agenda_id').val(agenda_id);					
					$('#formulario_pacientes_atenciones #name').val(datos[0]);				
					$('#formulario_pacientes_atenciones #lastname').val(datos[1]);	
					$('#formulario_pacientes_atenciones #telefono1').val(datos[2]);	
					$('#formulario_pacientes_atenciones #telefono2').val(datos[3]);
					$('#formulario_pacientes_atenciones #sexo').val(datos[4]);					
					$('#formulario_pacientes_atenciones #correo').val(datos[5]);
					$('#formulario_pacientes_atenciones #edad').val(datos[6]);	
					$('#formulario_pacientes_atenciones #expediente').val(datos[7]);
					$('#formulario_pacientes_atenciones #direccion').val(datos[8]);					
					$('#formulario_pacientes_atenciones #fecha_nac').val(datos[9]);
					$('#formulario_pacientes_atenciones #departamento_id').val(datos[10]);
					getMunicipioEditar(datos[10], datos[11]);
					$('#formulario_pacientes_atenciones #pais_id').val(datos[12]);
					$('#formulario_pacientes_atenciones #responsable').val(datos[13]);
					$('#formulario_pacientes_atenciones #responsable_id').val(datos[14]);
					$('#formulario_pacientes_atenciones #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes_atenciones #identidad').val(datos[16]);					
					$('#perfil_nombre_nutricion').html(datos[17]);
					$('#formulario_pacientes_atenciones #referido').val(datos[18]);

					$('#formulario_antecedentes #edad_consulta').val(datos[6]);
					$('#formulario_antecedentes #edad_consulta').attr('readonly', true);
					$('#formulario_antecedentes #atenciones_servicio_id').val(servicio_id);

					//DATOS DE LA HISTORIA CLINICA DEL PACIENTE
					$('#formulario_antecedentes #motivo_consulta').val(datos[19]);
					$('#formulario_pacientes_atenciones #edad_paciente').val(datos[20]);

					$('#formulario_antecedentes #agenda_id').val(agenda_id);
					$('#formulario_antecedentes #pacientes_id').val(pacientes_id);
					$('#formulario_antecedentes #colaborador_id').val(servicio_id);
	
					$("#formulario_pacientes_atenciones #fecha").attr('readonly', true);
					$("#formulario_pacientes_atenciones #expediente").attr('readonly', true);
					$("#formulario_pacientes_atenciones #identidad").attr('readonly', true);
					$('#formulario_pacientes_atenciones #validate').removeClass('bien_email');
					$('#formulario_pacientes_atenciones #validate').removeClass('error_email');
					$("#formulario_pacientes_atenciones #correo").css("border-color", "none");
					$('#formulario_pacientes_atenciones #validate').html('');
					
					caracteresDireccionPacientes();
					caracteresReferidoPor();
					caracteresIndicaciones();
					caracteresAlimentos();
					caracteresDiagnostico();
					caracteresObservaciones();
					caracteresAntecedentesQuirurgicos();
					caracteresIntentoPerdidaPeso();
					caracteresActividadFisica();
					caracteresNivelesEstres();
					caracteresAdicciones();
					caracteresAlergias();
					caracteresAntecedentesFamiliares();
					caracteresAntecedentesPersonales();	
					
					$('#regConsulta').show();
					$('#ediConsulta').hide();
					$('#regOtro').show();					

					getHistoriaClincia(pacientes_id);
					paginationSeguimiento(1, pacientes_id, colaborador_id);
					paginationHistorialAlimentos(1);

					getDetallesAtencion(pacientes_id);

					viewExpediente(pacientes_id);
					viewPreoOperatorio(pacientes_id);
					viewNotaOperatoria(pacientes_id);
					viewPostOperatorio(pacientes_id);	
					mostrarArchivos(pacientes_id);
					mostrarArchivosNotaOperatoria(pacientes_id);

					return false;
			}
		});	
	}else{
		swal({
			title: 'Acceso Denegado', 
			text: 'No tiene permisos para ejecutar esta acción',
			icon: 'error', 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});				
		return false;			
	}	
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
						$('#formulario_antecedentes #motivo_consulta').val(datos[0]);				
						$('#formulario_antecedentes #fecha_consulta').val(datos[1]);
						$('#formulario_antecedentes #fecha_consulta').attr("readonly", true);	
						$('#formulario_antecedentes #ante_perso').val(datos[2]);	
						$('#formulario_antecedentes #ante_fam').val(datos[3]);	
						$('#formulario_antecedentes #alergias').val(datos[4]);
						$('#formulario_antecedentes #adicciones').val(datos[5]);																									
						$('#formulario_antecedentes #niveles_estres').val(datos[6]);
						$('#formulario_antecedentes #niveles_actividad_fisica').val(datos[7]);
						$('#formulario_antecedentes #intento_perdida_peso').val(datos[8]);
						$('#formulario_antecedentes #antecedentes_quirurgicos').val(datos[9]);
						$('#formulario_antecedentes #observaciones').val(datos[10]);

						$('#formulario_antecedentes #diagnostico').val(datos[11]);
						$('#formulario_antecedentes #indicaciones').val(datos[12]);
						$('#formulario_antecedentes #atenciones_nutricion_id').val(datos[16]);

						if(datos[13] == 1){
							$('#formulario_antecedentes #candidato_bariatrica').attr('checked', true);
						}else{
							$('#formulario_antecedentes #candidato_bariatrica').attr('checked', false);
						}					
						
						$('#regConsulta').hide();
						$('#ediConsulta').show();
						$('#regOtro').show();						
					}else{
						$('#regConsulta').show();
						$('#ediConsulta').hide();
						$('#regOtro').show();	
						$('#formulario_antecedentes #fecha_consulta').attr("readonly", false);						
					}					
					return false;
			}
		});	
}

$('#formulario_pacientes_atenciones #referido').keyup(function() {
	    var max_chars = 255;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_pacientes_atenciones #charNum_referido').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresReferidoPor(){
	var max_chars = 255;
	var chars = $('#formulario_pacientes_atenciones #referido').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_pacientes_atenciones #charNum_referido').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_pacientes_atenciones #direccion').keyup(function() {
	    var max_chars = 250;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_pacientes_atenciones #charNum_direccion_pacientes').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresDireccionPacientes(){
	var max_chars = 250;
	var chars = $('#formulario_pacientes_atenciones #direccion').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_pacientes_atenciones #charNum_direccion_pacientes').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

function perfilNombreNutricion(nombre){
	$('#perfil_nombre_nutricion').html(nombre);
}

function getFechaCitaNutricion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getFechaCita.php';
	var fecha_cita;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  fecha_cita = data;			  		  		  			  
		}
	});
	return fecha_cita;
}

function paginationSeguimiento(partida, pacientes_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/paginar_seguimiento.php';
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_historia_clinica').html(array[0]);
			$('#pagination_historia_clinica').html(array[1]);
		}
	});
	return false;
}

function paginationHistorialAlimentos(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/paginarHistorialAlimentos.php';
	let pacientes_id = $('#formulario_pacientes_atenciones #pacientes_id').val();
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&pacientes_id='+pacientes_id,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_historia_alimentos').html(array[0]);
			$('#pagination_historia_alimentos').html(array[1]);
		}
	});
	return false;
}

function consultaHistoriaClinica(pacientes_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/consultaHistoriaClinica.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id,
		async: false,
		success:function(data){	
			var datos = eval(data);
         	 resp = datos[0];			  		  		  			  
		}
	});
	return resp;	
}

$('#regConsulta').on('click', function(e){
	e.preventDefault();
	$('#formulario_antecedentes').attr({ 'data-form': 'save' });
	$('#formulario_antecedentes').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarAtencionNutricion.php' });
	$("#formulario_antecedentes").submit();
});

$('#ediConsulta').on('click', function(e){
	e.preventDefault();
	$('#formulario_antecedentes').attr({ 'data-form': 'update' }); 
	$('#formulario_antecedentes').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/modificarAtencionNutricion.php' });
	$("#formulario_antecedentes").submit();
});

$('#regOtro').on('click', function(e){
	e.preventDefault();	
	$('#formulario_antecedentes').attr({ 'data-form': 'update' }); 
	$('#formulario_antecedentes').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarAtencionNutricionDetalles.php' });
	$("#formulario_antecedentes").submit();
});

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

function getServicioAtencionNutricion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/servicios.php';
	
	var servicio_id;
	$.ajax({
	    type:'POST',
		data:'agenda_id='+agenda_id,
		url:url,
		async: false,
		success:function(data){	
          servicio_id = data;			  		  		  			  
		}
	});
	return servicio_id;		
}

//INICIO PACIENTES
function getSexo(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getSexo.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #sexo').html("");
			$('#formulario_pacientes #sexo').html(data);	
		}			
     });		
}

function getStatusNutricion(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getStatus.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#form_main_atencion_nutricion_medica #estado').html("");
			$('#form_main_atencion_nutricion_medica #estado').html(data);
		}			
     });		
}

function getResponsable(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getResponsable.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #responsable_id').html("");
			$('#formulario_pacientes #responsable_id').html(data);
		}			
     });		
}

function getDepartamentos(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getDepartamentos.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #departamento_id').html("");
			$('#formulario_pacientes #departamento_id').html(data);
		}			
     });		
}

function getPais(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getPais.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #pais_id').html("");
			$('#formulario_pacientes #pais_id').html(data);
		}			
     });		
}

//INICIO PAIS
$('#formulario_pacientes #buscar_pais_pacientes').on('click', function(e){
	listar_pais_buscar(); 
	$('#modal_busqueda_pais').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

var listar_pais_buscar = function(){
	var table_pais_buscar = $("#dataTablePais").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getPaisTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pais_buscar.search('').draw();
	$('#buscar').focus();
	
	view_pais_busqueda_dataTable("#dataTablePais tbody", table_pais_buscar);
}

var view_pais_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #pais_id').val(data.pais_id);
		$('#modal_busqueda_pais').modal('hide');
	});
}
//FIN PAIS

//INICIO DEPARTAMENTOS
$('#formulario_pacientes #buscar_departamento_pacientes').on('click', function(e){
	listar_departamentos_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

var listar_departamentos_buscar = function(){
	var table_departamentos_buscar = $("#dataTableDepartamentos").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getDepartamentosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_departamentos_buscar.search('').draw();
	$('#buscar').focus();
	
	view_departamentos_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #departamento_id').val(data.departamento_id);
		getMunicipio();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}
//FIN DEPARTAMENTOS

//INICIO BUSQUEDA MUNICIPIOS
$('#formulario_pacientes #buscar_municipio_pacientes').on('click', function(e){
	if($('#formulario_pacientes #departamento_id').val() == "" || $('#formulario_pacientes #departamento_id').val() == null){
		swal({
			title: "Error", 
			text: "Lo sentimos el departamento no debe estar vacío, antes de seleccionar esta opción por favor seleccione un departamento, por favor corregir",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});			
	}else{
		listar_municipios_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_municipios_buscar = function(){
	var departamento = $('#formulario_pacientes #departamento_id').val();
	var table_municipios_buscar = $("#dataTableMunicipios").DataTable({
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getMunicipiosTabla.php",
			"data":{ 'departamento' : departamento },
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"municipio"},
			{"data":"departamento"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_municipios_buscar.search('').draw();
	$('#buscar').focus();
	
	view_municipios_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}
//FIN BUSQUEDA MUNICIPIOS

//INICIO DATOS DEL PACIENTE
//INICIO BUSQUEDA PROFESION
function getResponsable(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getResponsable.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #responsable_id').html("");
			$('#formulario_pacientes #responsable_id').html(data);
			
		    $('#formulario_pacientes_atenciones #responsable_id').html("");
			$('#formulario_pacientes_atenciones #responsable_id').html(data);			
		}			
     });		
}

function getSexo(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getSexo.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #sexo').html("");
			$('#formulario_pacientes #sexo').html(data);

		    $('#formulario_agregar_expediente_manual #sexo_manual').html("");
			$('#formulario_agregar_expediente_manual #sexo_manual').html(data);	

		    $('#formulario_pacientes_atenciones #sexo').html("");
			$('#formulario_pacientes_atenciones #sexo').html(data);				
		}			
     });		
}

function getDepartamentos(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getDepartamentos.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #departamento_id').html("");
			$('#formulario_pacientes #departamento_id').html(data);
			
		    $('#formulario_pacientes_atenciones #departamento_id').html("");
			$('#formulario_pacientes_atenciones #departamento_id').html(data);			
		}			
     });		
}

function getMunicipio(){
	var url = '../php/pacientes/getMunicipio.php';
		
	var departamento_id = $('#formulario_pacientes #departamento_id').val();
	
	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamento_id='+departamento_id,
	   success:function(data){
		  $('#formulario_pacientes #municipio_id').html("");
		  $('#formulario_pacientes #municipio_id').html(data);

		  $('#formulario_pacientes_atenciones #municipio_id').html("");
		  $('#formulario_pacientes_atenciones #municipio_id').html(data);		  
	  }
  });	
}

$(document).ready(function() {
	$('#formulario_pacientes #departamento_id').on('change', function(){
		var url = '../php/pacientes/getMunicipio.php';
       		
		var departamento_id = $('#formulario_pacientes #departamento_id').val();
		
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamento_id='+departamento_id,
		   success:function(data){
		      $('#formulario_pacientes #municipio_id').html("");
			  $('#formulario_pacientes #municipio_id').html(data);		  
		  }
	  });
	  return false;			 				
    });					
});

$(document).ready(function() {
	$('#formulario_pacientes_atenciones #departamento_id').on('change', function(){
		var url = '../php/pacientes/getMunicipio.php';
       		
		var departamento_id = $('#formulario_pacientes_atenciones #departamento_id').val();
		
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamento_id='+departamento_id,
		   success:function(data){
		      $('#formulario_pacientes_atenciones #municipio_id').html("");
			  $('#formulario_pacientes_atenciones #municipio_id').html(data);		  
		  }
	  });
	  return false;			 				
    });					
});

function getMunicipioEditar(departamento_id, municipio_id){
	var url = '../php/pacientes/getMunicipio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamento_id='+departamento_id,
	   success:function(data){
	      $('#formulario_pacientes #municipio_id').html("");
		  $('#formulario_pacientes #municipio_id').html(data);
		  $('#formulario_pacientes #municipio_id').val(municipio_id);		  
		  
	      $('#formulario_pacientes_atenciones #municipio_id').html("");
		  $('#formulario_pacientes_atenciones #municipio_id').html(data);
		  $('#formulario_pacientes_atenciones #municipio_id').val(municipio_id);		  
	  }
	});
	return false;		
}

function getProfesion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getProfesion.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){

		    $('#formulario_pacientes #profesion_pacientes').html("");
			$('#formulario_pacientes #profesion_pacientes').html(data);	
			
		    $('#formulario_pacientes_atenciones #profesion_pacientes').html("");
			$('#formulario_pacientes_atenciones #profesion_pacientes').html(data);			
        }
     });	
}

function getPais(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getPais.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #pais_id').html("");
			$('#formulario_pacientes #pais_id').html(data);
			
		    $('#formulario_pacientes_atenciones #pais_id').html("");
			$('#formulario_pacientes_atenciones #pais_id').html(data);			
		}			
     });		
}

$('#formulario_pacientes_atenciones #buscar_pais_pacientes').on('click', function(e){
	listar_pais_buscar(); 
	$('#modal_busqueda_pais').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes_atenciones #buscar_departamento_pacientes').on('click', function(e){
	listar_departamentos_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes_atenciones #buscar_municipio_pacientes').on('click', function(e){
	if($('#formulario_pacientes_atenciones #departamento_id').val() == "" || $('#formulario_pacientes_atenciones #departamento_id').val() == null){
		swal({
			title: "Error", 
			text: "Lo sentimos el departamento no debe estar vacío, antes de seleccionar esta opción por favor seleccione un departamento, por favor corregir",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});			
	}else{
		listar_municipios_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_pais_buscar = function(){
	var table_pais_buscar = $("#dataTablePais").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getPaisTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pais_buscar.search('').draw();
	$('#buscar').focus();
	
	view_pais_busqueda_dataTable("#dataTablePais tbody", table_pais_buscar);
}

var view_pais_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #pais_id').val(data.pais_id);
		$('#modal_busqueda_pais').modal('hide');
	});
}

var listar_departamentos_buscar = function(){
	var table_departamentos_buscar = $("#dataTableDepartamentos").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getDepartamentosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_departamentos_buscar.search('').draw();
	$('#buscar').focus();
	
	view_departamentos_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #departamento_id').val(data.departamento_id);
		getMunicipio();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}

var listar_municipios_buscar = function(){
	var departamento = $('#formulario_pacientes_atenciones #departamento_id').val();
	var table_municipios_buscar = $("#dataTableMunicipios").DataTable({
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getMunicipiosTabla.php",
			"data":{ 'departamento' : departamento },
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"municipio"},
			{"data":"departamento"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_municipios_buscar.search('').draw();
	$('#buscar').focus();
	
	view_municipios_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}

$('#formulario_pacientes_atenciones #buscar_profesion_pacientes').on('click', function(e){
	listar_profesion_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_buscar = function(){
	var table_profesion_buscar = $("#dataTableProfesiones").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/pacientes/getProfesionTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_profesion_buscar.search('').draw();
	$('#buscar').focus();
	
	view_profesion_busqueda_dataTable("#dataTableProfesiones tbody", table_profesion_buscar);
}

var view_profesion_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 $('#main_facturacion').show();
	 $('#main_atencion_nutricion').hide();
});

$('#formulario_antecedentes #label_candidato_bariatrica').html("No");

$('#formulario_antecedentes .switch').change(function(){    
	if($('input[name=candidato_bariatrica]').is(':checked')){
		$('#formulario_antecedentes #label_candidato_bariatrica').html("Sí");
		return true;
	}
	else{
		$('#formulario_antecedentes #label_candidato_bariatrica').html("No");
		return false;
	}
});


$('#ediPacientes').on('click', function(e){
	e.preventDefault();
	$('#formulario_pacientes_atenciones').attr({ 'data-form': 'save' });
	$('#formulario_pacientes_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarPacientes.php' });
	$("#formulario_pacientes_atenciones").submit();
});

function getProfesionPacientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getProfesion.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_pacientes_atenciones #profesion_pacientes').html("");
			$('#formulario_pacientes_atenciones #profesion_pacientes').html(data);	
        }
     });	
}

$('#formulario_pacientes #buscar_profesion_pacientes').on('click', function(e){
	listar_profesion_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_buscar = function(){
	var table_profeision_buscar = $("#dataTableProfesiones").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/pacientes/getProfesionTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_profeision_buscar.search('').draw();
	$('#buscar').focus();
	
	view_profesion_busqueda_dataTable("#dataTableProfesiones tbody", table_profeision_buscar);
}

var view_profesion_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}
//FIN BUSQUEDA PROFESION
//FIN DATOS DEL PACIENTE
//FIN PACIENTES

//INICIO TRANSITO
	//INICIO ABRIR VENTANA MODAL TRANSITO ENVIADA
	$('#form_main_atencion_nutricion_medica #transito_enviada').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){	
		     $('#formulario_transito_enviada #pro').val("Registro");
			 $('#registro_transito_eviada').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			limpiarTE();
			return false;
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});	 		 
		}	
	});	
	//FIN ABRIR VENTANA MODAL TRANSITO ENVIADA
	
	//INICIO ABRIR VENTANA MODAL TRANSITO RECIBIDA
	$('#form_main_atencion_nutricion_medica #transito_recibida').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		     $('#formulario_transito_recibida #pro').val("Registro");			
			 $('#registro_transito_recibida').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			limpiarTR();
			return false;
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});	 		 
		}	
	});
	//FIN ABRIR VENTANA MODAL TRANSITO RECIBIDA

$(document).ready(function(){
	$("#registro_transito_eviada").on('shown.bs.modal', function(){
		$(this).find('#formulario_transito_enviada #expediente').focus();
	});
});

$(document).ready(function(){
    $("#registro_transito_recibida").on('shown.bs.modal', function(){
        $(this).find('#formulario_transito_recibida #expediente').focus();
    });
});

function getColaborador(){
    var url = '<?php echo SERVERURL; ?>php/citas/getMedico.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#registro_transito_eviada #enviada').html("");
			$('#registro_transito_eviada #enviada').html(data);

		    $('#formulario_transito_recibida #recibida').html("");
			$('#formulario_transito_recibida #recibida').html(data);		
        }
     });		
}

//TANSITO ENVIADA
$('#formulario_transito_enviada #motivo').keyup(function() {
	    var max_chars = 255;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_transito_enviada #charNumMotivoTE').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

//TRANSITO RECIBIDA
$('#formulario_transito_recibida #motivo').keyup(function() {
	    var max_chars = 255;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_transito_recibida #charNumMotivoTR').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

//INICIO TRANSITO USUARIO
$(document).ready(function(e) {
    $('#formulario_transito_enviada #paciente_te').on('change', function(){
	 if($('#formulario_transito_enviada #paciente_te').val()!=""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/buscar_expediente.php';
		var pacientes_id = $('#formulario_transito_enviada #paciente_te').val();
		
		$.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_enviada #identidad').val(array[0]);	  			  
		  }
		});
	   return false;		
	 }else{
		$('#formulario_transito_enviada')[0].reset();
        $('#formulario_transito_enviada #pro').val("Registro");		
        $("#reg_transitoe").attr('disabled', true);			
	 }
	});
});

$(document).ready(function(e) {
    $('#formulario_transito_recibida #paciente_tr').on('change', function(){
	 if($('#formulario_transito_recibida #paciente_tr').val()!=""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/buscar_expediente.php';
        var pacientes_id = $('#formulario_transito_recibida #paciente_tr').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_recibida #identidad').val(array[0]);	  			  
		  }
	  });
	  return false;		
	 }else{
		$('#formulario_transito_recibida')[0].reset();	
		$('#formulario_transito_recibida #pro').val("Registro");
        $("#reg_transitor").attr('disabled', true);		
	 }
	});
});

$('#reg_transitoe').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		 if ($('#formulario_transito_enviada #expediente').val() == "" && $('#formulario_transito_enviada #motivo').val() == "" && $('#formulario_agregar_referencias_recibidas #enviadaa').val() == ""){
			 $('#formulario_transito_enviada')[0].reset();						   
			swal({
				title: 'Error', 
				text: 'No se pueden enviar los datos, los campos estan vacíos',
				icon: 'error', 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});			
			return false;
		 }else{
			e.preventDefault();
			agregarTransitoEnviadas();		
		 } 		
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});		   
	} 
});

$('#reg_transitor').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		 if ($('#formulario_transito_recibida #expediente').val() == "" && $('#formulario_transito_recibida #motivo').val() == "" && $('#formulario_agregar_referencias_recibidas #enviadaa').val() == ""){
			$('#formulario_transito_recibida')[0].reset();							   
			swal({
				title: 'Error', 
				text: 'No se pueden enviar los datos, los campos estan vacíos',
				icon: 'error', 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});				
			return false;
		 }else{
			e.preventDefault();
			agregarTransitoRecibidas();		
		 }  		
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});		   
	} 
});
//FIN TRANSITO USUARIOS

//INICIO TRANSITO DE PACIENTES
function agregarTransitoEnviadas(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarTransitoEnviadas.php';
	
   	var fecha = $('#formulario_transito_enviada #fecha').val();	
    var hoy = new Date();
    fecha_actual = convertDate(hoy);
	
   if(getMesNutricion(fecha)==2){
	swal({
		title: 'Error', 
		text: 'No se puede agregar/modificar registros fuera de este periodo',
		icon: 'error', 
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
	});		
	return false;	
   }else{	
    if ( fecha <= fecha_actual){
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_transito_enviada').serialize(),
		success: function(registro){
			if (registro == 1){
			    $('#formulario_transito_enviada')[0].reset();
			    $('#formulario_transito_enviada #pro').val('Registro');		   
				swal({
					title: 'Almacenado', 
					text: 'Registro almacenado correctamente',
					icon: 'success', 
					timer: 1000,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				limpiarTE();
				$('#registro_transito_eviada').modal('hide');
			    return false;
			}else if(registro == 2){							   				   			   
				swal({
					title: 'Error', 
					text: 'Error al intentar almacenar este registro',
					icon: 'error', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   		   
			   return false;
			}else if(registro == 3){							   				   			   
				swal({
					title: "Error", 
					text: "Este registro no cuenta con atencion almacenada",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   		   
			   return false;
			}else if(registro == 4){							   				   			   
				swal({
					title: "Error", 
					text: "Este registro ya existe",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   		   
			   return false;
			}else{							   					   			   
				swal({
					title: "Error", 
					text: "Error al completar el registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});			   
			    return false;
			}
		}
	});	
   }else{
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de esta fecha',
			icon: 'error', 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
		});				
		return false;	   
   }
  }
}

function agregarTransitoRecibidas(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/agregarTransitoRecibidas.php';
	
   	var fecha = $('#formulario_transito_recibida #fecha').val();	
    var hoy = new Date();
    fecha_actual = convertDate(hoy);
	
   if(getMesNutricion(fecha)==2){
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de este periodo',
			icon: 'error', 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
		});				
		return false;	
   }else{	
    if ( fecha <= fecha_actual){    
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_transito_recibida').serialize(),
		success: function(registro){
			if (registro == 1){
			    $('#formulario_transito_recibida')[0].reset();
			    $('#pro').val('Registro');
				swal({
					title: 'Almacenado', 
					text: 'Registro almacenado correctamente',
					icon: 'success',
					timer: 1000,		
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera									
				});
				$('#registro_transito_recibida').modal('hide');
				limpiarTR();
			    return false;
			}else if(registro == 2){							   					   			   
				swal({
					title: 'Error', 
					text: 'Error al intentar almacenar este registro',
					icon: 'error', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   				   
			    return false;
			}else if(registro == 3){							   					   			   
				swal({
					title: 'Error', 
					text: 'Este registro no cuenta con atencion almacenada',
					icon: 'error', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   				   
			    return false;
			}else if(registro == 4){							   					   			   
				swal({
					title: 'Error', 
					text: 'Este registro ya existe',
					icon: 'error', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});				   				   
			    return false;
			}else{				   			   
				swal({
					title: 'Error', 
					text: 'Error al completar el registro',
					icon: 'error', 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});			    
			    return false;
			}
		}
	});	
   }else{
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de esta fecha',
			icon: 'error', 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
		});
	    return false;	 
   }
  }
}
//FIN TRANSITO DE PACIENTES

function getServicioTransito(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/servicios_transito.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_transito_enviada #servicio').html("");
			$('#formulario_transito_enviada #servicio').html(data);
			
		    $('#formulario_transito_recibida #servicio').html("");
			$('#formulario_transito_recibida #servicio').html(data);			
        }
     });		
}

//INICIO FUNCION PARA OBTENER LA RELIGION
function getReligion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getReligion.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_atenciones #religion_id').html("");
			$('#formulario_atenciones #religion_id').html(data);		
        }
     });	
}
//FIN FUNCION PARA OBTENER LOS PACIENTES

//INICIO FUNCION PARA OBTENER EL ESTADO CIVIL
function getEstadoCivil(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getEstadoCivil.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_atenciones #estado_civil').html("");
			$('#formulario_atenciones #estado_civil').html(data);		
        }
     });	
}
//FIN FUNCION PARA OBTENER EL ESTADO CIVIL

//INICIO FUNCION PARA OBTENER LA PROFESION
function getProfesion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getProfesion.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_atenciones #profesion_id').html("");
			$('#formulario_atenciones #profesion_id').html(data);	
        }
     });	
}
//FIN FUNCION PARA OBTENER LOS PACIENTES
//FIN PARA OBTENER EL SERVICIO DEL TRANSITO DE USUARIOS

//INICIO FUNCION LIMPIAR TRANSITO
function limpiarTE(){
	getColaborador();
	$('#formulario_transito_enviada #pro').val("Registro");
	$('#formulario_transito_enviada #motivo').val("");
	$("#reg_transitoe").attr('disabled', false);
}

function limpiarTR(){
	getColaborador();
	$('#formulario_transito_recibida #pro').val("Registro");	
	$('#formulario_transito_recibida #motivo').val("");
	$("#reg_transitor").attr('disabled', false);	
}
//FIN FUNCION LIMPIAR TRANSITO

$('#formulario_transito_enviada #buscar_pacientes_te').on('click', function(e){
	listar_pacientes_buscar_te();
	$('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

$('#formulario_transito_enviada #buscar_colaboradores_te').on('click', function(e){
	listar_colaboradores_buscar_te();
	$('#modal_busqueda_colaboradores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

$('#formulario_transito_recibida #buscar_pacientes_tr').on('click', function(e){
	listar_pacientes_buscar_tr();
	$('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

$('#formulario_transito_recibida #buscar_colaboradores_tr').on('click', function(e){
	listar_colaboradores_buscar_tr();
	$('#modal_busqueda_colaboradores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

//INICIO BUSQUEDA EN TRANSITO DE USUARIOS
var listar_pacientes_buscar_te = function(){
	var table_pacientes_buscar_te = $("#dataTablePacientes").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getPacientesTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"paciente"},
			{"data":"identidad"},
			{"data":"expediente"},
			{"data":"email"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pacientes_buscar_te.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_te_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_te);
}

var view_pacientes_busqueda_te_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_transito_enviada #pacientes_id').val(data.pacientes_id);
		$('#formulario_transito_enviada #paciente_te').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/buscar_expediente.php';
		var pacientes_id = $('#formulario_transito_enviada #paciente_te').val();
		
		$.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_enviada #identidad').val(array[0]);	  			  
		  }
		});
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}

var listar_colaboradores_buscar_te = function(){
	var table_colaboradores_buscar_te = $("#dataTableColaboradores").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getColaboradoresTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"colaborador"},
			{"data":"identidad"},
			{"data":"puesto"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_colaboradores_buscar_te.search('').draw();
	$('#buscar').focus();
	
	view_colaboradores_busqueda_te_dataTable("#dataTableColaboradores tbody", table_colaboradores_buscar_te);
}

var view_colaboradores_busqueda_te_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  		
		$('#formulario_transito_enviada #colaborador_id').val(data.colaborador_id);
		$('#formulario_transito_enviada #enviada').val(data.colaborador_id);		
		$('#modal_busqueda_colaboradores').modal('hide');
	});
}

var listar_pacientes_buscar_tr = function(){
	var table_pacientes_buscar_tr = $("#dataTablePacientes").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getPacientesTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"paciente"},
			{"data":"identidad"},
			{"data":"expediente"},
			{"data":"email"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pacientes_buscar_tr.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_tr_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_tr);
}

var view_pacientes_busqueda_tr_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		
		$('#formulario_transito_recibida #pacientes_id').val(data.pacientes_id);
		$('#formulario_transito_recibida #paciente_tr').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/buscar_expediente.php';
		var pacientes_id = $('#formulario_transito_recibida #paciente_tr').val();
		
		$.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_recibida #identidad').val(array[0]);	  			  
		  }
		});	
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}

var listar_colaboradores_buscar_tr = function(){
	var table_colaboradores_buscar_tr = $("#dataTableColaboradores").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getColaboradoresTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"colaborador"},
			{"data":"identidad"},
			{"data":"puesto"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_colaboradores_buscar_tr.search('').draw();
	$('#buscar').focus();
	
	view_colaboradores_busqueda_tr_dataTable("#dataTableColaboradores tbody", table_colaboradores_buscar_tr);
}

var view_colaboradores_busqueda_tr_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_transito_recibida #colaborador_id').val(data.colaborador_id);
		$('#formulario_transito_recibida #recibida').val(data.colaborador_id);
		$('#modal_busqueda_colaboradores').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA TRANSITO DE USUARIOS
//FIN TRANSITO


//INICIO ATENCION CIRUGIA
//CONSULTAR TODOS LOS REPORTES
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


			//INICIO EXPEDIENTE CLINICO DEL PACIENTE
			if(datos[65] != ""){

			}
			$('#formulario_buscarAtencion #expediente_fecha_consulta').val(datos[13]);
			$('#formulario_buscarAtencion #expediente_inicio_obesidad').val(datos[14]);	
			$('#formulario_buscarAtencion #expediente_habito_alimenticio').val(datos[15]);	
			$('#formulario_buscarAtencion #expediente_tipo_obecidad').val(datos[16]);	
			$('#formulario_buscarAtencion #expediente_intento_perdida_peso').val(datos[17]);	
			$('#formulario_buscarAtencion #expediente_peso_maximo_alcanzado').val(datos[18]);
			$('#formulario_buscarAtencion #expediente_sedentarismo').val(datos[19]);

			//INICIO PRIMERA FILA
			if (datos[24] == 1){
				$('#formulario_buscarAtencion #expediente_erge_activo').prop('checked', true);
				$('#formulario_buscarAtencion #expediente_erge_activo').attr("disabled", true);
				$('#formulario_buscarAtencion #label_expediente_erge_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_erge_respuesta').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_erge_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_erge_activo').html("No");
				$('#formulario_buscarAtencion #expediente_erge_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_erge_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_erge_respuesta').val(datos[67]);

			if (datos[25] == 1){
				$('#formulario_buscarAtencion #expediente_hta_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_hta_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_hta_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_hta_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_hta_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_hta_activo').html("No");
				$('#formulario_buscarAtencion #expediente_hta_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_hta_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_hta_respuesta').val(datos[68]);

			if (datos[27] == 1){
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_higado_graso_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_higado_graso_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_higado_graso_activo').html("No");
				$('#formulario_buscarAtencion #expediente_higado_graso_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_higado_graso_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_higado_graso_respuesta').val(datos[70]);

			if (datos[28] == 1){
				$('#formulario_buscarAtencion #expediente_saos_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_saos_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_saos_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_saos_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_saos_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_saos_activo').html("No");
				$('#formulario_buscarAtencion #expediente_saos_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_saos_activo').attr("disabled", true);
			}

			$('#formulario_buscarAtencion #expediente_saos_respuesta').val(datos[80]);

			if (datos[29] == 1){
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_hipotiroidismo_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_hipotiroidismo_activo').html("No");
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_hipotiroidismo_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_hipotiroidismo_respuesta').val(datos[71]);

			if (datos[30] == 1){
				$('#formulario_buscarAtencion #expediente_articulares_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_articulares_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_articulares_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_articulares_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_articulares_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_articulares_activo').html("No");
				$('#formulario_buscarAtencion #expediente_articulares_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_articulares_activo').attr("disabled", true);
			}				

			$('#formulario_buscarAtencion #expediente_articulares_respuesta').val(datos[72]);
			//FIN PRIMERA FILA

			//INICIO SEGUNDA FILA
			if (datos[31] == 1){
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_ovarios_poliquisticos_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_ovarios_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_ovarios_poliquisticos_activo').html("No");
				$('#formulario_buscarAtencion #expediente_ovarios_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_ovarios_poliquisticos_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_ovarios_respuesta').val(datos[73]);

			if (datos[32] == 1){
				$('#formulario_buscarAtencion #expediente_varices_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_varices_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_varices_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_varices_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_varices_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_varices_activo').html("No");
				$('#formulario_buscarAtencion #expediente_varices_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_varices_activo').attr("disabled", true);
			}					

			$('#formulario_buscarAtencion #expediente_varices_respuesta').val(datos[74]);

			if (datos[37] == 1){
				$('#formulario_buscarAtencion #expediente_drogas_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_drogas_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_drogas_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_drogas_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_drogas_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_drogas_activo').html("No");
				$('#formulario_buscarAtencion #expediente_drogas_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_drogas_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_drogas_respuesta').val(datos[38]);	
			
			if (datos[39] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_diabetes_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_ant_fam_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_diabetes_activo').html("No");
				$('#formulario_buscarAtencion #expediente_ant_fam_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_diabetes_activo').attr("disabled", true);
			}		
			
			$('#formulario_buscarAtencion #expediente_ant_fam_respuesta').val(datos[75]);

			if (datos[40] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_Obesidad_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_ant_fam_obecidad_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_Obesidad_activo').html("No");
				$('#formulario_buscarAtencion #expediente_ant_fam_obecidad_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_Obesidad_activo').attr("disabled", true);
			}			
			
			$('#formulario_buscarAtencion #expediente_ant_fam_obecidad_respuesta').val(datos[76]);

			if (datos[41] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_cancer_gastrico_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_ant_fam_gastrico_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_cancer_gastrico_activo').html("No");
				$('#formulario_buscarAtencion #expediente_ant_fam_gastrico_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_cancer_gastrico_activo').attr("disabled", true);
			}		
			
			$('#formulario_buscarAtencion #expediente_ant_fam_gastrico_respuesta').val(datos[77]);
			//FIN SEGUNDA FILA

			//INICIO TERCERA FILA
			if (datos[42] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_psiquiatricas_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_enf_psiquiatricas_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_fami_psiquiatricas_activo').html("No");
				$('#formulario_buscarAtencion #expediente_enf_psiquiatricas_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_fami_psiquiatricas_activo').attr("disabled", true);
			}	

			$('#formulario_buscarAtencion #expediente_enf_psiquiatricas_respuesta').val(datos[78]);

			if (datos[43] == 1){
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_dm_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_dm_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_antecedentes_dm_activo').html("No");
				$('#formulario_buscarAtencion #expediente_dm_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_antecedentes_dm_activo').attr("disabled", true);
			}	
			
			$('#formulario_buscarAtencion #expediente_dm_respuesta').val(datos[79]);

			if (datos[22] == 1){
				$('#formulario_buscarAtencion #expediente_alergias_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_alergias_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_alergias_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_alergias_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_alergias_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_alergias_activo').html("No");
				$('#formulario_buscarAtencion #expediente_alergias_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_alergias_activo').attr("disabled", true);
			}	
			
			$('#formulario_buscarAtencion #expediente_alergias_respuesta').val(datos[23]);		
			
			if (datos[35] == 1){
				$('#formulario_buscarAtencion #expediente_alcohol_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_alcohol_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_alcohol_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_alcohol_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_alcohol_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_alcohol_activo').html("No");
				$('#formulario_buscarAtencion #expediente_alcohol_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_alcohol_activo').attr("disabled", true);
			}	
			
			$('#formulario_buscarAtencion #expediente_alcohol_respuesta').val(datos[36]);
			
			if (datos[33] == 1){
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_tabaquismo_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_tabaquismo_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_tabaquismo_activo').html("No");
				$('#formulario_buscarAtencion #expediente_tabaquismo_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_tabaquismo_activo').attr("disabled", true);
			}		
			
			$('#formulario_buscarAtencion #expediente_tabaquismo_respuesta').val(datos[34]);
			
			if (datos[26] == 1){
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_dislipidemia_activo').html("Sí");
				$('#formulario_buscarAtencion #expediente_dislipidemia_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').attr("disabled", true);
			}else{
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_dislipidemia_activo').html("No");
				$('#formulario_buscarAtencion #expediente_dislipidemia_respuesta').attr("disabled", true);
				$('#formulario_buscarAtencion #expediente_dislipidemia_activo').attr("disabled", true);
			}				
			$('#formulario_buscarAtencion #expediente_dislipidemia_respuesta').val(datos[69]);
			//FIN TERCERA FILA

			if (datos[20] == 1){
				$('#formulario_buscarAtencion #expediente_ejercicio_activo').prop('checked', true);
				$('#formulario_buscarAtencion #label_expediente_ejercicio_activo').html("Sí");
			}else{
				$('#formulario_buscarAtencion #expediente_ejercicio_activo').prop('checked', false);
				$('#formulario_buscarAtencion #label_expediente_ejercicio_activo').html("No");
			}

			$('#formulario_buscarAtencion #ejercicio_respuesta').val(datos[21]);

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

			return false;
		}
	});		
}

function viewPreoOperatorio(pacientes_id){
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
				$('#formulario_buscarAtencion #expediente_pre_recomendacion_'+ fila).val(datos[fila]["recomendaciones"]);;

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
				
				$('#main_seguimiento_preo_operatorio').append("");
				$('#main_seguimiento_preo_operatorio_clinicare-size').css("height", "400");	
				
				$('#main_seguimiento_preo_operatorio_cirugia').append("");
				$('#main_seguimiento_preo_operatorio_cirugia_clinicare-size').css("height", "400");					
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
				
				$('#main_seguimiento_nota_operatorio').append("");
				$('#main_seguimiento_nota_operatorio_clinicare-size').css("height", "400");				
			}
			return false;
		}
	});		
}

function viewPostOperatorio(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/expedienteClinico/viewDatosPostOperatorio.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(valores){
			var datos = eval(valores);

			if(datos.length == 0){
				$('#main_seguimiento_post_operatorio').append("<b style='color: red;'>No hay datos que mostrar</b>");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "400");
				
				$('#main_seguimiento_post_operatorio_historico').append("<b style='color: red;'>No hay datos que mostrar</b>");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "400");				
			}else{
				$('#main_seguimiento_post_operatorio').append("");
				$('#main_seguimiento_post_operatorio_historico').append("");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "400");
			}

			for(var fila=0; fila < datos.length; fila++){
				llenarPostOperatorio(fila);
				//POST OPERATORIO
				$('#formularioAtencionesPostOperatoria #expediente_post_fecha_consulta_'+ fila).val(datos[fila]["fecha"]);
				$('#formularioAtencionesPostOperatoria #expediente_post_nch_'+ fila).val(datos[fila]["postoperacion_id"]);
				$('#formularioAtencionesPostOperatoria #expediente_post_talla_'+ fila).val(datos[fila]["talla"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_peso_actual_'+ fila).val(datos[fila]["peso_actual"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_peso_actual_kg_'+ fila).val(datos[fila]["peso_actual_kg"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_imc_actual_'+ fila).val(datos[fila]["imc_actual"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_edad_'+ fila).val(datos[fila]["edad"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_peso_perdido_'+ fila).val(datos[fila]["peso_perdido"]);
				$('#formularioAtencionesPostOperatoria #expediente_post_ewl_'+ fila).val(datos[fila]["ewl"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_otros_'+ fila).val(datos[fila]["otros"]);//pendiente revisar				
				$('#formularioAtencionesPostOperatoria #expediente_post_mejoria_enfermedades_'+ fila).val(datos[fila]["mejoria"]);
				$('#formularioAtencionesPostOperatoria #expediente_post_estado_actual_'+ fila).val(datos[fila]["estado_actual"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_medicamentos_que_usa_'+ fila).val(datos[fila]["medicamentos"]);				
				$('#formularioAtencionesPostOperatoria #expediente_post_hallazgos_'+ fila).val(datos[fila]["hallazgos"]);		
				$('#formularioAtencionesPostOperatoria #expediente_post_comentario_'+ fila).val(datos[fila]["comentarios"]);	
				$('#formularioAtencionesPostOperatoria #expediente_post_plan_'+ fila).val(datos[fila]["plan"]);

				//HISTORICA CLINICA
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
				
				$('#main_seguimiento_post_operatorio').append("");
				$('#main_seguimiento_post_operatorio_historico').append("");
				$('#main_seguimiento_post_operatorio_clinicare-size').css("height", "400");				
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
			htmlRows += '<textarea id="expediente_pre_examenes_'+count+'" name="expediente_pre_examenes[]" placeholder="Resultado Examenes" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_pre_recomendacion">Recomendaciones</label>';
			htmlRows += '<textarea id="expediente_pre_recomendacion_'+count+'" name="expediente_pre_recomendacion[]" placeholder="Recomendaciones" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
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

	$('#main_seguimiento_preo_operatorio_cirugia').append(htmlRows);
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
			htmlRows += '<textarea id="expediente_nota_tecnica_'+count+'" name="expediente_nota_tecnica[]" placeholder="Resultado Examenes" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_otros">Otros</label>';
			htmlRows += '<textarea id="expediente_nota_otros_'+count+'" name="expediente_nota_otros[]" placeholder="Recomendaciones" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN CUARTA FILA

	//INICIO QUINTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_hallazgos_operativos">Hallazgos Operativos</label>';
			htmlRows += '<textarea id="expediente_nota_hallazgos_operativos_'+count+'" name="expediente_nota_hallazgos_operativos[]" placeholder="Hallazgos Operativos" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_descripcion_operativa">Descripción Operatoria</label>';
			htmlRows += '<textarea id="expediente_nota_descripcion_operativa_'+count+'" name="expediente_nota_descripcion_operativa[]" placeholder="Descripción Operatoria" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN QUINTA FILA	

	//INICIO SEXTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_indicaciones">Indicaciones</label>';
			htmlRows += '<textarea id="expediente_nota_indicaciones_'+count+'" name="expediente_nota_indicaciones[]" placeholder="Indicaciones" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_nota_recomendaciones">Recomendaciones</label>';
			htmlRows += '<textarea id="expediente_nota_recomendaciones_'+count+'" name="expediente_nota_recomendaciones[]" placeholder="Recomendaciones" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
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
			htmlRows += '<textarea id="expediente_nota_comentarios_'+count+'" name="expediente_nota_comentarios[]" placeholder="Comentarios" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN OCTAVA FILA
	htmlRows += '<hr/>';

	$('#main_seguimiento_nota_operatorio').append(htmlRows);
	$('#main_seguimiento_nota_operatorio_cirugua').append(htmlRows);	
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
			htmlRows += '<textarea id="expediente_post_otros_'+count+'" name="expediente_post_otros[]" placeholder="Otros" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_mejoria_enfermedades">Mejoría Enfermedades</label>';
			htmlRows += '<textarea id="expediente_post_mejoria_enfermedades_'+count+'" name="expediente_post_mejoria_enfermedades[]" placeholder="Mejoría Enfermedades" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN TERCERA FILA

	//INICIO CUARTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_estado_actual">Estado Actual</label>';
			htmlRows += '<textarea id="expediente_post_estado_actual_'+count+'" name="expediente_post_estado_actual[]" placeholder="Estado Actual" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_medicamentos_que_usa">Medicamentos que Usa</label>';
			htmlRows += '<textarea id="expediente_post_medicamentos_que_usa_'+count+'" name="expediente_post_medicamentos_que_usa[]" placeholder="Medicamentos que Usa" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN CUARTA FILA	

	//INICIO QUITA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_hallazgos">Hallazgos</label>';
			htmlRows += '<textarea id="expediente_post_hallazgos_'+count+'" name="expediente_post_hallazgos[]" placeholder="Hallazgos" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';

		htmlRows += '<div class="col-md-6 mb-3">';                    	
			htmlRows += '<label for="expediente_post_comentario">Comentario</label>';
			htmlRows += '<textarea id="expediente_post_comentario_'+count+'" name="expediente_post_comentario[]" placeholder="Comentario" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN QUITA FILA	
	
	//INICIO SEXTA FILA
	htmlRows += '<div class="form-row">';
		htmlRows += '<div class="col-md-12 mb-3">';                    	
			htmlRows += '<label for="expediente_post_plan">Plan</label>';
			htmlRows += '<textarea id="expediente_post_plan_'+count+'" name="expediente_post_plan[]" placeholder="Plan" class="form-control" maxlength="2000" rows="5" readonly></textarea>';	
		htmlRows += '</div>';
	htmlRows += '</div>';
	//FIN SEXTA FILA
	htmlRows += '<hr/>';

	$('#main_seguimiento_post_operatorio').append(htmlRows);
	$('#main_seguimiento_post_operatorio_cirugia').append(htmlRows);		
}

function mostrarArchivos(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/pacientes/mostrarSeguimiento.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id,
	   success: function(valores){
			$('#formulario_atenciones #mostrar_datos').html(valores);
			$('#formulario_buscarAtencion #mostrar_datos').html(valores);	
			$('#formulario_buscarAtencion #mostrar_datos_cirugia').html(valores);		
			return false;
		}	
	});	
}

function mostrarArchivosNotaOperatoria(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/pacientes/mostrarSeguimientoNotaOperatoria.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id,
	   success: function(valores){
			$('#formularioAtencionesNotaOperatoria #mostrar_datos').html(valores);
			$('#formulario_buscarAtencion #mostrar_datos_nota_operatoria').html(valores);
			$('#formulario_buscarAtencion #mostrar_datos_nota_operatoria_cirugia').html(valores);	
			return false;
		}	
	});	
}
//FIN ATENCION CIRUGIA

$('#primera_consulta_nutricion #report_prieravez').on('click', function(e){
    e.preventDefault();
    reportePDFPrimeraVez($('#primera_consulta_nutricion #pacientes_id').val());
});

function reportePDFPrimeraVez(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/generarReporteAtencion.php?pacientes_id='+pacientes_id;
    window.open(url);
}

//INICIO CALCULO ICC
$("#primera_consulta_nutricion #cintura").on("keyup", function(e){
	calcularICC();
});

$("#primera_consulta_nutricion #cadera").on("keyup", function(e){
	calcularICC();
});

function calcularICC(){
	let icc = 0;
	let cintura = 0;
	let cadera = 0;

	if($("#primera_consulta_nutricion #cintura").val() != ""){
		cintura = $("#primera_consulta_nutricion #cintura").val();
	}

	if($("#primera_consulta_nutricion #cadera").val() != ""){
		cadera = $("#primera_consulta_nutricion #cadera").val();
	}

	if(cadera != 0){
		icc = parseFloat(cintura) / parseFloat(cadera);	
	}

	$("#primera_consulta_nutricion #indice_cc").val(icc.toFixed(2));
}

//FIN CALCULO ICC

//INICIO CALCULO IMC
$("#primera_consulta_nutricion #peso").on("keyup", function(e){
	caclularIMC_MSJ();
});

$("#primera_consulta_nutricion #estatura").on("keyup", function(e){
	caclularIMC_MSJ();	
});

function caclularIMC_MSJ(){
	let imc = 0;
	let peso = 0;
	let estatura = 0;
	let msj = 0;
	let genero = $("#formulario_pacientes_atenciones #sexo").val();
	let edad = $("#formulario_pacientes_atenciones #edad_paciente").val();
	let sedentario = 0;
	let act_moderada = 0;
	let act_vigorosa = 0;

	if($("#primera_consulta_nutricion #peso").val() != ""){
		peso = parseFloat($("#primera_consulta_nutricion #peso").val())/2.2;
	}

	if($("#primera_consulta_nutricion #estatura").val() != ""){
		estatura = (parseFloat($("#primera_consulta_nutricion #estatura").val()))/100;
	}

	if(estatura != 0){
		imc = parseFloat(peso) / (parseFloat(estatura) * parseFloat(estatura));	
	}

	$("#primera_consulta_nutricion #imc").val(imc.toFixed(2));

	//calculo MSJ
	if(genero == "H"){
		msj = ((10*peso) + (6.25 * (estatura * 100))-(5*edad) + 5);
 	}else{
		msj = ((10*peso) + (6.25 * (estatura * 100))-(5*edad) - 161);
	}

	$("#primera_consulta_nutricion #msj").val(msj.toFixed(2));

	sedentario = msj*1.4;
	act_moderada = msj*1.7;
	act_vigorosa = msj*2;	

	$("#primera_consulta_nutricion #sedentario").val(sedentario.toFixed(2));
	$("#primera_consulta_nutricion #act_moderada").val(act_moderada.toFixed(2));
	$("#primera_consulta_nutricion #act_vigorosa").val(act_vigorosa.toFixed(2));
}
//FIN CALCULO IMC

//INICIO ENVIAR ENLACE PARA FORMULARIO DE ALIMENTOS
$("#enviar_enlace_alimentacion").on("click", function (e) {
	e.preventDefault();
	var url = '<?php echo SERVERURL; ?>php/mail/enviarEnlaceAlimentos.php';

	$.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+$('#formulario_pacientes_atenciones #pacientes_id').val(),
	   success: function(valores){
		if(valores == 1){
				swal({
					title: "Success", 
					text: "El enlace fue enviado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-clos
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera						
				});	
			}else if(valores == 2){
				swal({
					title: "Error", 
					text: "No fue posible enviar el correo electrónico",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});					
			}else{
				swal({
					title: "Error", 
					text: "Lo sentimos, el paciente no tiene registrado un correo electrónico, debe ir a la ficha del paciente y actualizar los datos antes de proceder",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
				});					
			}
			return false;
		}	
	});	
});
//FIN ENVIAR ENLACE PARA FORMULARIO DE ALIMENTOS

$('#enviar_formulario_alimentacion').on('click', function(e){
	e.preventDefault();
	$('#formulario_alimentos').attr({ 'data-form': 'save' });
	$('#formulario_alimentos').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/addAlimentos.php' });
	$("#formulario_alimentos").submit();
});

$('#report_prieravez_nutricion').on('click', function(e){
    e.preventDefault();
});

$('#ediPacientesNutricion').on('click', function(e){
	e.preventDefault();
	$('#formulario_pacientes_atenciones').attr({ 'data-form': 'update' });
	$('#formulario_pacientes_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarPacientes.php' });
	$("#formulario_pacientes_atenciones").submit();
});

$('#enviar_formulario_alimentacion').on('click', function(e){
	e.preventDefault();
	$('#formulario_alimentos').attr({ 'data-form': 'save' });
	$('#formulario_alimentos').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/addAlimentos.php' });
	$("#formulario_alimentos").submit();
});

function modalHistorialComida(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getHistorialComidaDetalles.php';

	$('#mostrarHistorialAlimentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});

	$.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id,
	   success: function(valores){
			$("#formularioHistorialAlimentos #registros").html(valores);
			return false;
		}	
	});	
}

function reportePDFHistorialComida(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/generarReporteHistorialcomida.php?pacientes_id='+pacientes_id;
    window.open(url);
}

$('#exportReport').on('click', function(e){
	e.preventDefault();
	swal({
		title: "Matenimiento", 
		text: "Esta opción se encuentra en desarrollo",
		icon: "warning", 
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
	});		
});

$('#report_prieravez_nutricion').on('click', function(e){
	e.preventDefault();
	swal({
		title: "Matenimiento", 
		text: "Esta opción se encuentra en desarrollo",
		icon: "warning", 
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
	});		
});
</script>