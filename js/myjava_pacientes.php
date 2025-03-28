<script>
$(document).ready(function(){
	getSexo();
	pagination(1);
	getStatus();
	getDepartamentos();
	getPais();
	getResponsable();
	getProfesion();
	
	$('#form_main_pacientes #nuevo-registro').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){
			$('#formulario_pacientes #reg').show();
			$('#formulario_pacientes #edi').hide();
			cleanPacientes();
			$('#formulario_pacientes #grupo_expediente').hide();
			$('#formulario_pacientes')[0].reset();	
			$('#formulario_pacientes #pro').val('Registro');
			$("#formulario_pacientes #fecha").attr('readonly', false);
			$("#formulario_pacientes #pais_id").val(1);
			$("#formulario_pacientes #identidad").attr('readonly', false);		
			$('#formulario_pacientes').attr({ 'data-form': 'save' }); 
			$('#formulario_pacientes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarPacientes.php' });	
			$('#modal_pacientes').modal({
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

	$('#form_main_pacientes #profesion').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){
			$('#formulario_profesiones #reg').show();
			$('#formulario_profesiones #edi').hide();		 	 
			$('#formulario_profesiones')[0].reset();	
			$('#formulario_profesiones #proceso').val('Registro');
			paginationPorfesionales(1);
			$('#formulario_profesiones').attr({ 'data-form': 'save' }); 
			$('#formulario_profesiones').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregar_profesional.php' });				
			 $('#modal_profesiones').modal({
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

	$('#form_main_pacientes #bs_regis').on('keyup',function(){
	  pagination(1);
	});
	
	$('#formulario_profesiones #profesionales_buscar').on('keyup',function(){
	  paginationPorfesionales(1);
	});	

	$('#form_main_pacientes #estado').on('change',function(){
	  pagination(1);
	});
	
	$('#formulario_agregar_expediente_manual #identidad_ususario_manual').on('keyup',function(){
		busquedaUsuarioManualIdentidad();
    });	

	$('#formulario_agregar_expediente_manual #expediente_usuario_manual').on('keyup',function(){
		busquedaUsuarioManualExpediente();
    });		
});

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#modal_profesiones").on('shown.bs.modal', function(){
        $(this).find('#formulario_profesiones #profesionales_buscar').focus();
    });
});

$(document).ready(function(){
    $("#agregar_expediente_manual").on('shown.bs.modal', function(){
        $(this).find('#formulario_agregar_expediente_manual #identidad_ususario_manual').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

$('#reg_manual').on('click', function(e){ // delete event clicked // We don't want this to act as a link so cancel the link action
   e.preventDefault();
   if ($('#formulario_agregar_expediente_manual #expediente_usuario_manual').val()!="" || $('#formulario_agregar_expediente_manual #identidad_ususario_manual').val() !=""){		 
	  registrarExpedienteManual();	   	  	   
   }else{
		swal({
			title: "Error", 
			text: "Hay registros en blanco, por favor corregir",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
		});			   
	   return false;
   }	   
});

$('#convertir_manual').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	 e.preventDefault();
	 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){
	     convertirExpedientetoTemporal(); 
	 }else{
		  swal({
			title: 'Acceso Denegado', 
			text: 'No tiene permisos para ejecutar esta acción',
			icon: 'error', 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
		  });		 
	}
});

$('#form_main_pacientes #reporte').on('click', function(e){
    e.preventDefault();
    reporteEXCEL();
});

function reporteEXCEL(){
 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){	
	var estado = "";
	var dato = $('#form_main_pacientes #bs_regis').val();
	
	if ($('#estado').val() == ""){
		estado = 1;
	}else{
		estado = $('#estado').val();
	}
	
	var url = '<?php echo SERVERURL; ?>php/pacientes/reportePacientes.php?dato='+dato+'&estado='+estado;
    window.open(url);
}else{
	swal({
		title: "Acceso Denegado", 
		text: "No tiene permisos para ejecutar esta acción",
		icon: "error", 
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
	});						
	return false;	  
  }	
}

function asignarExpedienteaRegistro(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/pacientes/agregar_expediente.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success: function(registro){
			swal.close();
			showExpediente(pacientes_id);
			pagination(1);			
			return false;
		}
	});
	return false;
}

function getStatus(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getStatus.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#form_main_pacientes #estado').html("");
			$('#form_main_pacientes #estado').html(data);
		}			
     });		
}

function showExpediente(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/pacientes/getExpediente.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success:function(data){
			if(data == 1){	
				swal({
					title: "Error", 
					text: "Por favor intentelo de nuevo más tarde",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera 
				});				   
			}else{				
  	           $('#mensaje_show').modal({
				show:true,
				keyboard: false,
				backdrop:'static'  
     	       });	
               $('#mensaje_mensaje_show').html(data);
	           $('#bad').hide();
	           $('#okay').show();				
			}
		}
	});	
}

function modal_eliminarProfesional(profesional_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){
		swal({
			title: "¿Estas seguro?",
			text: "¿Desea eliminar este registro?",
			icon: "warning",
			buttons: {
				cancel: {
					text: "Cancelar",
					visible: true
				},
				confirm: {
					text: "¡Sí, eliminar el registro!",
				}
			},
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		}).then((willConfirm) => {
			if (willConfirm === true) {
				eliminarProfesional(profesional_id);
			}
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

function modal_eliminar(pacientes_id){
  if (consultarExpediente(pacientes_id) != 0 && (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6)){
    var nombre_usuario = consultarNombre(pacientes_id);
    var expediente_usuario = consultarExpediente(pacientes_id);
    var dato;

    if(expediente_usuario == 0){
		dato = nombre_usuario;
	}else{
		dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
	}
	
	swal({
		title: "¿Estas seguro?",
		text: "¿Desea eliminar este registro: " + dato + "?",
		icon: "warning",
		buttons: {
			cancel: {
				text: "Cancelar",
				visible: true
			},
			confirm: {
				text: "¡Sí, eliminar el registro!",
			}
		},
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
	}).then((willConfirm) => {
		if (willConfirm === true) {
			eliminarRegistro(pacientes_id);
		}
	});
  }else if (consultarExpediente(pacientes_id) == 0 && (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6)){
    var nombre_usuario = consultarNombre(pacientes_id);
    var expediente_usuario = consultarExpediente(pacientes_id);
    var dato;

    if(expediente_usuario == 0){
		dato = nombre_usuario;
	}else{
		dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
	}
	
	swal({
		title: "¿Estas seguro?",
		text: "¿Desea eliminar este registro: " + dato + "?",
		icon: "warning",
		buttons: {
			cancel: {
				text: "Cancelar",
				visible: true
			},
			confirm: {
				text: "¡Sí, eliminar el registro!",
			}
		},
		dangerMode: true,
		closeOnEsc: false, // Desactiva el cierre con la tecla Esc
		closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
	}).then((willConfirm) => {
		if (willConfirm === true) {
			eliminarRegistro(pacientes_id);
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

function cleanPacientes(){
	$('#formulario_pacientes #validate').removeClass('bien_email');	
	$('#formulario_pacientes #validate').removeClass('error_email');
	$('#formulario_pacientes #validate').html('');	
	$("#formulario #correo").css("border-color", "none");	
}

function editarRegistro(pacientes_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){
		var url = '<?php echo SERVERURL; ?>php/pacientes/editar.php';
		   $.ajax({
			   type:'POST',
			   url:url,
			   data:'pacientes_id='+pacientes_id,
			   success: function(valores){
					var datos = eval(valores);
					$('#formulario_pacientes #reg').hide();
					$('#formulario_pacientes #edi').show();	
					$('#formulario_pacientes #pro').val('Edición');
					$('#formulario_pacientes #grupo_expediente').show();
					$('#formulario_pacientes #pacientes_id').val(pacientes_id);					
					$('#formulario_pacientes #name').val(datos[0]);				
					$('#formulario_pacientes #lastname').val(datos[1]);	
					$('#formulario_pacientes #telefono1').val(datos[2]);	
					$('#formulario_pacientes #telefono2').val(datos[3]);
					$('#formulario_pacientes #sexo').val(datos[4]);					
					$('#formulario_pacientes #correo').val(datos[5]);
					$('#formulario_pacientes #edad').val(datos[6]);	
					$('#formulario_pacientes #expediente').val(datos[7]);
					$('#formulario_pacientes #direccion').val(datos[8]);					
					$('#formulario_pacientes #fecha_nac').val(datos[9]);
					$('#formulario_pacientes #departamento_id').val(datos[10]);
					getMunicipioEditar(datos[10], datos[11]);
					$('#formulario_pacientes #pais_id').val(datos[12]);
					$('#formulario_pacientes #responsable').val(datos[13]);
					$('#formulario_pacientes #responsable_id').val(datos[14]);
					$('#formulario_pacientes #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes #identidad').val(datos[16]);
					$("#formulario_pacientes #fecha").attr('readonly', true);
					$("#formulario_pacientes #expediente").attr('readonly', true);
					$("#formulario_pacientes #identidad").attr('readonly', true);
					$('#formulario_pacientes #validate').html('');
					caracteresDireccionPacientes();
					caracteresReferidoPor();

					cleanPacientes();
					$('#formulario_pacientes').attr({ 'data-form': 'update' }); 
					$('#formulario_pacientes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/editarPacientes.php' });						
					$('#modal_pacientes').modal({
						show:true,
						keyboard: false,
						backdrop:'static'
					});
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

function eliminarProfesional(id){	
	var url = '<?php echo SERVERURL; ?>php/pacientes/eliminar_profesional.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(registro){
			if(registro == 1){
				swal({
					title: "Success", 
					text: "Registro eliminado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-clos
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				paginationPorfesionales(1);
				$('#modal_profesiones').modal('hide');
			   return false;				
			}else if(registro == 2){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});		
	           return false;				
			}else if(registro == 3){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro, cuenta con información almacenada",
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
	return false;
}

function eliminarRegistro(pacientes_id){	
	var url = '<?php echo SERVERURL; ?>php/pacientes/eliminar.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+pacientes_id,
		success: function(registro){
			if(registro == 1){
				swal({
					title: "Success", 
					text: "Registro eliminado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-clos
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				pagination(1);
			   return false;				
			}else if(registro == 2){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});		
	           return false;				
			}else if(registro == 3){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro, cuenta con información almacenada",
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
	return false;
}

function convertirExpedientetoTemporal(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/convertirExpedienteTemporal.php';		
    var pacientes_id = $('#formulario_agregar_expediente_manual #pacientes_id').val();	
	
	$.ajax({
        type: "POST",
        url: url,
	    data:'pacientes_id='+pacientes_id,		
	    async: true,
        success: function(data){	
            if(data == 1){
				swal({
					title: "Usuario convertido", 
					text: "El usuario se ha convertido a temporal",
					icon: "success", 
					timer: 3000, //timeOut for auto-close
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				$('#agregar_expediente_manual').modal('hide');
			    $('#formulario_agregar_expediente_manual #expediente_manual').val('TEMP');
			    $('#formulario_agregar_expediente_manual #temporal').hide();
			    $('#convertir_manual').hide();
			    $('#reg_manual').show();
                pagination(1);			   
	            return false;				
			}else{
				swal({
					title: "Error", 
					text: "No se puede procesar su solicitud",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
                return false;			   
			}
		}			
     });	
}

function registrarExpedienteManual(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/agregarExpedienteManual.php';

	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_agregar_expediente_manual').serialize(),
		success: function(registro){
		   if(registro==1){
			   $('#formulario_agregar_expediente_manual #pro_manual').val('Registro');
				swal({
					title: "Success", 
					text: "Registro completado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-clos
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				$('#agregar_expediente_manual').modal('hide');
				pagination(1);
		   }else if(registro==2){
				swal({
					title: "Error", 
					text: "No se pudo guardar el registro, por favor verifique la información",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
		   }else if(registro==3){
				swal({
					title: "Error", 
					text: "Error al ejecutar esta acción",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});		   
		   }else if(registro==4){
				swal({
					title: "Error", 
					text: "Error en los datos",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});		   
		   }else{
				swal({
					title: "Error", 
					text: "Error al guardar el registro",
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

function busquedaUsuarioManualIdentidad(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarIdentidad.php';
       		
	var identidad = $('#formulario_agregar_expediente_manual #identidad_ususario_manual').val();
	
   $.ajax({
	  type:'POST',
	  url:url,
	  data:'identidad='+identidad,
	  success:function(data){
		 if(data == 1){	
			swal({
				title: "Error", 
				text: "Este numero de Identidad ya existe, por favor corriga el numero e intente nuevamente",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});					 
			 $("#formulario_agregar_expediente_manual #reg").attr('disabled', true);
			 return false;
		 }else{		  
			 $("#formulario_agregar_expediente_manual #reg").attr('disabled', false); 
		}	  
	}
   });			
}

function busquedaUsuarioManualExpediente(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarExpediente.php';
       		
	var expediente = $('#formulario_agregar_expediente_manual #expediente_usuario_manual').val();
	
   $.ajax({
	  type:'POST',
	  url:url,
	  data:'expediente='+expediente,
	  success:function(data){
		 if(data == 1){
			swal({
				title: "Error", 
				text: "Este numero de Expediente ya existe, por favor corriga el numero e intente nuevamente",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});				  
			$("#formulario_agregar_expediente_manual #reg").attr('disabled', true);
			return false;
		 }else{ 			  
			$("#formulario_agregar_expediente_manual #reg").attr('disabled', false); 
		}	  
	  }
   });		
}

function consultarExpediente(pacientes_id){	
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

function consultarNombre(pacientes_id){	
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

function modal_agregar_expediente_manual(id, expediente){
   if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 6){	
	  $('#formulario_agregar_expediente_manual')[0].reset();
	  var url = '<?php echo SERVERURL; ?>php/pacientes/buscarUsuario.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
			var datos = eval(valores);
			if(expediente == 0){
				$("#formulario_agregar_expediente_manual #temporal").hide();
			}else{
				$("#formulario_agregar_expediente_manual #temporal").show();						
			}
			$("#formulario_agregar_expediente_manual #pacientes_id").val(id);
			$("#formulario_agregar_expediente_manual #expediente").val(expediente);
			$("#formulario_agregar_expediente_manual #name_manual").val(datos[0]);
			$("#formulario_agregar_expediente_manual #identidad_manual").val(datos[1]);
			$('#formulario_agregar_expediente_manual #sexo_manual').val(datos[2]);
			$("#formulario_agregar_expediente_manual #fecha_manual").val(datos[3]);
			$("#formulario_agregar_expediente_manual #edad_manual").val(datos[6]);
			$("#formulario_agregar_expediente_manual #expediente_manual").val(datos[5]);
			$("#formulario_agregar_expediente_manual #edad_manual").show();
			$('#formulario_agregar_expediente_manual #pro').val('Registrar');
			$("#reg_manual").show();
			$("#convertir_manual").hide();
			$('#agregar_expediente_manual').modal({
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
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});	
	}
 }
 
function paginationPorfesionales(partida){
	var url = '<?php echo SERVERURL; ?>php/pacientes/paginarProfesionales.php';
	var profesional = $('#formulario_profesiones #profesionales_buscar').val();
		
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&profesional='+profesional,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_profesionales').html(array[0]);
			$('#pagination_profesionales').html(array[1]);
		}
	});
	return false;
}

function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/pacientes/paginar.php';
	var estado = "";
	var paciente = "";
	var dato = $('#form_main_pacientes #bs_regis').val();
	
	if ($('#form_main_pacientes #estado').val() == "" || $('#form_main_pacientes #estado').val() == null){
		estado = 1;
	}else{
		estado = $('#form_main_pacientes #estado').val();
	}
	
	if ($('#form_main_pacientes #tipo').val() == "" || $('#form_main_pacientes #tipo').val() == null){
		paciente = 1;
	}else{
		paciente = $('#form_main_pacientes #tipo').val();
	}	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&estado='+estado+'&dato='+dato+'&paciente='+paciente,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
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
		}			
     });		
}

/*INICIO AUTO COMPLETAR*/
/*INICIO SUGGESTION NOMBRE*/
$(document).ready(function() {
   $('#formulario #name').on('keyup', function() {
	   if($('#formulario #name').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_name').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #name').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_name').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_name').fadeIn(1000).html("");
		   $('#formulario #suggestions_name').fadeOut(1000);
	   }
     });		
});

//OCULTAR EL SUGGESTION
$(document).ready(function() {
   $('#formulario #name').on('blur', function() {
	   $('#formulario #suggestions_name').fadeOut(1000);
   });		
});  

$(document).ready(function() {
   $('#formulario #name').on('click', function() {
	   if($('#formulario #name').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_name').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #name').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_name').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_name').fadeIn(1000).html("");
		   $('#formulario #suggestions_name').fadeOut(1000);
	   }
     });		
}); 
/*FIN SUGGESTION NOMBRE*/

/*INICIO SUGGESTION APELLIDO*/
$(document).ready(function() {
   $('#formulario #lastname').on('keyup', function() {
	   if($('#formulario #lastname').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_apellido').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #lastname').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_apellido').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_apellido').fadeIn(1000).html("");
		   $('#formulario #suggestions_apellido').fadeOut(1000);
	   }
     });		
});

//OCULTAR EL SUGGESTION
$(document).ready(function() {
   $('#formulario #lastname').on('blur', function() {
	   $('#formulario #suggestions_apellido').fadeOut(1000);
   });		
});  

$(document).ready(function() {
   $('#formulario #lastname').on('cli', function() {
	   if($('#formulario #lastname').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_apellido').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #lastname').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_apellido').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_apellido').fadeIn(1000).html("");
		   $('#formulario #suggestions_apellido').fadeOut(1000);
	   }
     });		
});
/*FIN SUGGESTION APELLIDO*/
/*FIN AUTO COMPLETAR*/

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

//SÍ
$(document).ready(function() {
	$('#formulario_agregar_expediente_manual #respuestasi').on('click', function(){
        $("#convertir_manual").show();
		$("#reg_manual").hide();
    });					
});

//NO
$(document).ready(function() {
	$('#formulario_agregar_expediente_manual #respuestano').on('click', function(){
		$("#convertir_manual").hide();
		$("#reg_manual").show();		
    });					
});

$('#form_main_pacientes #limpiar').on('click', function(e){
    e.preventDefault();
	$('#form_main_pacientes #bs_regis').val("");
	$('#form_main_pacientes #bs_regis').focus();	
	getSexo();
	pagination(1);
	getStatus();
});

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
$('#formulario_pacientes #buscar_pais_form_pacientes').on('click', function(e){
	listar_pais_pacientes_buscar(); 
	$('#modal_busqueda_pais').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

var listar_pais_pacientes_buscar = function(){
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
	
	view_pais_pacientes_busqueda_dataTable("#dataTablePais tbody", table_pais_buscar);
}

var view_pais_pacientes_busqueda_dataTable = function(tbody, table){
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
	listar_departamentos_pacientes_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

var listar_departamentos_pacientes_buscar = function(){
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
	
	view_departamentos_pacientes_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_pacientes_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		alert(data.departamento_id);
		$('#formulario_pacientes #departamento_id').val(data.departamento_id);
		getMunicipio();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}
//FIN DEPARTAMENTOS

//INICIO BUSQUEDA MUNICIPIOS
$('#formulario_pacientes #buscar_municipio_form_pacientes').on('click', function(e){
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
		listar_municipios_pacientes_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_municipios_pacientes_buscar = function(){
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
	
	view_municipios_pacientes_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_pacientes_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}
//FIN BUSQUEDA MUNICIPIOS

//INICIO BUSQUEDA PROFESION
function getProfesion(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getProfesion.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_pacientes #profesion_pacientes').html("");
			$('#formulario_pacientes #profesion_pacientes').html(data);	
        }
     });	
}

$('#formulario_pacientes #buscar_profesion_pacientes').on('click', function(e){
	listar_profesion_pacientes_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_pacientes_buscar = function(){
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

$('#formulario_pacientes #direccion').keyup(function() {
	    var max_chars = 250;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_pacientes #charNum_direccion_pacientes').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresDireccionPacientes(){
	var max_chars = 250;
	var chars = $('#formulario_pacientes #direccion').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_pacientes #charNum_direccion_pacientes').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN BUSQUEDA PROFESION

$('#formulario_pacientes #referido').keyup(function() {
	    var max_chars = 255;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_pacientes #charNum_referido').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresReferidoPor(){
	var max_chars = 255;
	var chars = $('#formulario_pacientes #referido').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_pacientes #charNum_referido').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

//INICIO ATENCIONES MEDICAS CIRUGIA BARIATRICA
$(document).ready(function() {
	getSexoAtencion();
	getStatusAtencion();
	getDepartamentosAtencion();
	getMunicipioAtencion();
	getPaisAtencion();
	getResponsableAtencion();
	getProfesionAtencionCirugiaPacientes();
	fillPlantillasAtencion();
	$('.footer').show();
	$('.footer1').hide();	

	//INICIO FORMULARIO DE ATENCIONES EXPEDIENTE CLINICO
	$('#formulario_atenciones #label_ejercicio_activo').html("No");
	$('#formulario_atenciones #ejercicio_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=ejercicio_activo]').is(':checked')){
			$('#formulario_atenciones #label_ejercicio_activo').html("Sí");
			$('#formulario_atenciones #ejercicio_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_ejercicio_activo').html("No");
			$('#formulario_atenciones #ejercicio_respuesta').hide();
			return false;
		}
	});

	//INICIO PRIMERA FILA
	$('#formulario_atenciones #label_erge_activo').html("No");
	$('#formulario_atenciones #erge_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=erge_activo]').is(':checked')){
			$('#formulario_atenciones #label_erge_activo').html("Sí");
			$('#formulario_atenciones #erge_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_erge_activo').html("No");
			$('#formulario_atenciones #erge_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_hta_activo').html("No");
	$('#formulario_atenciones #hta_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=hta_activo]').is(':checked')){
			$('#formulario_atenciones #label_hta_activo').html("Sí");
			$('#formulario_atenciones #hta_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_hta_activo').html("No");
			$('#formulario_atenciones #hta_respuesta').hide();
			return false;
		}
	});	
	
	$('#formulario_atenciones #label_higado_graso_activo').html("No");
	$('#formulario_atenciones #higado_graso_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=higado_graso_activo]').is(':checked')){
			$('#formulario_atenciones #label_higado_graso_activo').html("Sí");
			$('#formulario_atenciones #higado_graso_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_higado_graso_activo').html("No");
			$('#formulario_atenciones #higado_graso_respuesta').hide();
			return false;
		}
	});	
	
	$('#formulario_atenciones #label_saos_activo').html("No");
	$('#formulario_atenciones #saos_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=saos_activo]').is(':checked')){
			$('#formulario_atenciones #label_saos_activo').html("Sí");
			$('#formulario_atenciones #saos_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_saos_activo').html("No");
			$('#formulario_atenciones #saos_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_hipotiroidismo_activo').html("No");
	$('#formulario_atenciones #hipotiroidismo_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=hipotiroidismo_activo]').is(':checked')){
			$('#formulario_atenciones #label_hipotiroidismo_activo').html("Sí");
			$('#formulario_atenciones #hipotiroidismo_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_hipotiroidismo_activo').html("No");
			$('#formulario_atenciones #hipotiroidismo_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_articulares_activo').html("No");
	$('#formulario_atenciones #articulares_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=articulares_activo]').is(':checked')){
			$('#formulario_atenciones #label_articulares_activo').html("Sí");
			$('#formulario_atenciones #articulares_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_articulares_activo').html("No");
			$('#formulario_atenciones #articulares_respuesta').hide();
			return false;
		}
	});	
	//FIN PRIMERA FILA

	//INICIO SEGUNDA FILA
	$('#formulario_atenciones #label_ovarios_poliquisticos_activo').html("No");
	$('#formulario_atenciones #ovarios_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=ovarios_poliquisticos_activo]').is(':checked')){
			$('#formulario_atenciones #label_ovarios_poliquisticos_activo').html("Sí");
			$('#formulario_atenciones #ovarios_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_ovarios_poliquisticos_activo').html("No");
			$('#formulario_atenciones #ovarios_respuesta').hide();
			return false;
		}
	});

	$('#formulario_atenciones #label_varices_activo').html("No");
	$('#formulario_atenciones #varices_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=varices_activo]').is(':checked')){
			$('#formulario_atenciones #label_varices_activo').html("Sí");
			$('#formulario_atenciones #varices_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_varices_activo').html("No");
			$('#formulario_atenciones #varices_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_drogas_activo').html("No");
	$('#formulario_atenciones #drogas_respuesta').hide();	

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=drogas_activo]').is(':checked')){
			$('#formulario_atenciones #label_drogas_activo').html("Sí");
			$('#formulario_atenciones #drogas_respuesta').show();		
			return true;
		}
		else{
			$('#formulario_atenciones #label_drogas_activo').html("No");
			$('#formulario_atenciones #drogas_respuesta').hide();			
			return false;
		}
	});	

	$('#formulario_atenciones #label_antecedentes_fami_diabetes_activo').html("No");
	$('#formulario_atenciones #ant_fam_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=antecedentes_fami_diabetes_activo]').is(':checked')){
			$('#formulario_atenciones #label_antecedentes_fami_diabetes_activo').html("Sí");
			$('#formulario_atenciones #ant_fam_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_antecedentes_fami_diabetes_activo').html("No");
			$('#formulario_atenciones #ant_fam_respuesta').hide();
			return false;
		}
	});	
	
	$('#formulario_atenciones #label_antecedentes_fami_Obesidad_activo').html("No");
	$('#formulario_atenciones #ant_fam_obecidad_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=antecedentes_fami_Obesidad_activo]').is(':checked')){
			$('#formulario_atenciones #label_antecedentes_fami_Obesidad_activo').html("Sí");
			$('#formulario_atenciones #ant_fam_obecidad_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_antecedentes_fami_Obesidad_activo').html("No");
			$('#formulario_atenciones #ant_fam_obecidad_respuesta').hide();
			return false;
		}
	});		

	$('#formulario_atenciones #label_antecedentes_fami_obecidad_activo').html("No");
	
	
	$('#formulario_atenciones #label_antecedentes_fami_cancer_gastrico_activo').html("No");
	$('#formulario_atenciones #ant_fam_gastrico_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=antecedentes_fami_cancer_gastrico_activo]').is(':checked')){
			$('#formulario_atenciones #label_antecedentes_fami_cancer_gastrico_activo').html("Sí");
			$('#formulario_atenciones #ant_fam_gastrico_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_antecedentes_fami_cancer_gastrico_activo').html("No");
			$('#formulario_atenciones #ant_fam_gastrico_respuesta').hide();
			return false;
		}
	});	
	//FIN SEGUNDA FILA

	//INICIO TERCERA FILA
	$('#formulario_atenciones #label_antecedentes_fami_psiquiatricas_activo').html("No");
	$('#formulario_atenciones #enf_psiquiatricas_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=antecedentes_fami_psiquiatricas_activo]').is(':checked')){
			$('#formulario_atenciones #label_antecedentes_fami_psiquiatricas_activo').html("Sí");
			$('#formulario_atenciones #enf_psiquiatricas_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_antecedentes_fami_psiquiatricas_activo').html("No");
			$('#formulario_atenciones #enf_psiquiatricas_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_antecedentes_dm_activo').html("No");
	$('#formulario_atenciones #dm_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=antecedentes_dm_activo]').is(':checked')){
			$('#formulario_atenciones #label_antecedentes_dm_activo').html("Sí");
			$('#formulario_atenciones #dm_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_antecedentes_dm_activo').html("No");
			$('#formulario_atenciones #dm_respuesta').hide();
			return false;
		}
	});	

	$('#formulario_atenciones #label_alergias_activo').html("No");
	$('#formulario_atenciones #alergias_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=alergias_activo]').is(':checked')){
			$('#formulario_atenciones #label_alergias_activo').html("Sí");
			$('#formulario_atenciones #alergias_respuesta').show();			
			return true;
		}
		else{
			$('#formulario_atenciones #label_alergias_activo').html("No");
			$('#formulario_atenciones #alergias_respuesta').hide();
			return false;
		}
	});	
	
	$('#formulario_atenciones #label_alcohol_activo').html("No");
	$('#formulario_atenciones #alcohol_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=alcohol_activo]').is(':checked')){
			$('#formulario_atenciones #label_alcohol_activo').html("Sí");
			$('#formulario_atenciones #alcohol_respuesta').show();		
			return true;
		}
		else{
			$('#formulario_atenciones #label_alcohol_activo').html("No");
			$('#formulario_atenciones #alcohol_respuesta').hide();			
			return false;
		}
	});		

	$('#formulario_atenciones #label_tabaquismo_activo').html("No");
	$('#formulario_atenciones #tabaquismo_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=tabaquismo_activo]').is(':checked')){
			$('#formulario_atenciones #label_tabaquismo_activo').html("Sí");
			$('#formulario_atenciones #tabaquismo_respuesta').show();			
			return true;
		}
		else{
			$('#formulario_atenciones #label_tabaquismo_activo').html("No");
			$('#formulario_atenciones #tabaquismo_respuesta').hide();			
			return false;
		}
	});	
	
	$('#formulario_atenciones #label_dislipidemia_activo').html("No");
	$('#formulario_atenciones #dislipidemia_respuesta').hide();

	$('#formulario_atenciones .switch').change(function(){    
		if($('input[name=dislipidemia_activo]').is(':checked')){
			$('#formulario_atenciones #label_dislipidemia_activo').html("Sí");
			$('#formulario_atenciones #dislipidemia_respuesta').show();
			return true;
		}
		else{
			$('#formulario_atenciones #label_dislipidemia_activo').html("No");
			$('#formulario_atenciones #dislipidemia_respuesta').hide();
			return false;
		}
	});		
		
	//FIN TERCERA FILA

	//FIN FORMULARIO DE ATENCIONES EXPEDIENTE CLINICO
	
	//INICIO FORMULARIO PRE OPERATORIO
	$('#formularioAtencionesPreoperatorio #label_psiquiatra_activo').html("No");

	$('#formularioAtencionesPreoperatorio .switch').change(function(){    
		if($('input[name=psiquiatra_activo]').is(':checked')){
			$('#formularioAtencionesPreoperatorio #label_psiquiatra_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesPreoperatorio #label_psiquiatra_activo').html("No");
			return false;
		}
	});

	$('#formularioAtencionesPreoperatorio #label_psicologo_activo').html("No");

	$('#formularioAtencionesPreoperatorio .switch').change(function(){    
		if($('input[name=psicologo_activo]').is(':checked')){
			$('#formularioAtencionesPreoperatorio #label_psicologo_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesPreoperatorio #label_psicologo_activo').html("No");
			return false;
		}
	});

	$('#formularioAtencionesPreoperatorio #label_nutricion_activo').html("No");

	$('#formularioAtencionesPreoperatorio .switch').change(function(){    
		if($('input[name=nutricion_activo]').is(':checked')){
			$('#formularioAtencionesPreoperatorio #label_nutricion_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesPreoperatorio #label_nutricion_activo').html("No");
			return false;
		}
	});

	$('#formularioAtencionesPreoperatorio #label_medicion_interna_activo').html("No");

	$('#formularioAtencionesPreoperatorio .switch').change(function(){    
		if($('input[name=medicion_interna_activo]').is(':checked')){
			$('#formularioAtencionesPreoperatorio #label_medicion_interna_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesPreoperatorio #label_medicion_interna_activo').html("No");
			return false;
		}
	});	
	
	//FIN FORMULARIO PRE OPERATORIO	
	
	//INICIO FORMULARIO NOTA OPERATORIA
	$('#formularioAtencionesNotaOperatoria #label_nota_prueba_metileno_activo').html("No");

	$('#formularioAtencionesNotaOperatoria .switch').change(function(){    
		if($('input[name=nota_prueba_metileno_activo]').is(':checked')){
			$('#formularioAtencionesNotaOperatoria #label_nota_prueba_metileno_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesNotaOperatoria #label_nota_prueba_metileno_activo').html("No");
			return false;
		}
	});	

	$('#formularioAtencionesNotaOperatoria #label_nota_dreno_blake_activo').html("No");

	$('#formularioAtencionesNotaOperatoria .switch').change(function(){    
		if($('input[name=nota_dreno_blake_activo]').is(':checked')){
			$('#formularioAtencionesNotaOperatoria #label_nota_dreno_blake_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesNotaOperatoria #label_nota_dreno_blake_activo').html("No");
			return false;
		}
	});		
	
	$('#formularioAtencionesNotaOperatoria #label_nota_extraccion_activo').html("No");

	$('#formularioAtencionesNotaOperatoria .switch').change(function(){    
		if($('input[name=nota_extraccion_activo]').is(':checked')){
			$('#formularioAtencionesNotaOperatoria #label_nota_extraccion_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesNotaOperatoria #label_nota_extraccion_activo').html("No");
			return false;
		}
	});		

	$('#formularioAtencionesNotaOperatoria #label_nota_evacuo_activo').html("No");

	$('#formularioAtencionesNotaOperatoria .switch').change(function(){    
		if($('input[name=nota_evacuo_activo]').is(':checked')){
			$('#formularioAtencionesNotaOperatoria #label_nota_evacuo_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesNotaOperatoria #label_nota_evacuo_activo').html("No");
			return false;
		}
	});	

	$('#formularioAtencionesNotaOperatoria #label_nota_cierro_piel_activo').html("No");

	$('#formularioAtencionesNotaOperatoria .switch').change(function(){    
		if($('input[name=nota_cierro_piel_activo]').is(':checked')){
			$('#formularioAtencionesNotaOperatoria #label_nota_cierro_piel_activo').html("Sí");
			return true;
		}
		else{
			$('#formularioAtencionesNotaOperatoria #label_nota_cierro_piel_activo').html("No");
			return false;
		}
	});		
	//FIN FORMULARIO NOTA OPERATORIA	
});

function getStatusAtencion(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getStatus.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#form_main_atencion_medica #estado').html("");
			$('#form_main_atencion_medica #estado').html(data);
		}			
     });		
}

function getSexoAtencion(){
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

function getResponsableAtencion(){
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

function getDepartamentosAtencion(){
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

function getPaisAtencion(){
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
$('#formulario_pacientes #buscar_departamento_form_pacientes').on('click', function(e){
	listar_departamentos_pacientes_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

var listar_departamentos_pacientes_buscar = function(){
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
	
	view_departamentos_pacientes_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_pacientes_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #departamento_id').val(data.departamento_id);
		getMunicipioAtencion();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}
//FIN DEPARTAMENTOS

//INICIO BUSQUEDA MUNICIPIOS
$('#formulario_pacientes #buscar_municipio_form_pacientes').on('click', function(e){
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
		listar_municipios_pacientes_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_municipios_pacientes_buscar = function(){
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
	
	view_municipios_pacientes_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_pacientes_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}
//FIN BUSQUEDA MUNICIPIOS

//INICIO BUSQUEDA PROFESION
function getProfesionAtencionCirugiaPacientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getProfesionAtencionCirugia.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_pacientes #profesion_pacientes').html("");
			$('#formulario_pacientes #profesion_pacientes').html(data);	
        }
     });	
}

$('#formulario_pacientes #profesion_form_pacientes').on('click', function(e){
	listar_profesion_pacientes_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_pacientes_buscar = function(){
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
	
	view_profesion_pacientes_busqueda_dataTable("#dataTableProfesiones tbody", table_profeision_buscar);
}

var view_profesion_pacientes_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}
//FIN BUSQUEDA PROFESION

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
	
	//INICIO CONSULTRAR USUARIOS ATENDIDOS
	$('#form_main_atencion_medica #historial').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
			e.preventDefault();
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
	  
});
//FIN CONTROLES DE ACCION
/****************************************************************************************************************************************************************/

//INICIO FUNCION PARA OBTENER LOS COLABORADORES
//INICIO FUNCION AUSENCIA DE USUARIOS
function nosePresentoRegistroAtencion(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		if( getAtencionPaciente(agenda_id) == 1 || getAtencionPacientePreOperatorio(agenda_id) == 1 || getAtencionPacienteNotaOperatoria(agenda_id) == 1 || getAtencionPacientePostOperatorio(agenda_id) == 1){
			swal({
				title: "Error", 
				text: "Error al ejecutar esta acción, este usuario tiene una atención almacenada, no se le puede marcar una ausencia",
				icon: "error", 
				dangerMode: true,
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
			});				
	   }else{	
			  var nombre_usuario = consultarNombre(pacientes_id);
			  var expediente_usuario = consultarExpediente(pacientes_id);
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
				eliminarRegistroAtencion(agenda_id, inputValue);
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

function eliminarRegistroAtencion(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/usuario_no_presento.php';
	
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
				timer: 3000, //timeOut for auto-close
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera				
			});
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
function CulminarAtencionPacienteCirugia(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){		
		if(getAtencionPaciente(agenda_id) == 0){ 			  
			  var nombre_usuario = consultarNombre(pacientes_id);
			  var expediente_usuario = consultarExpediente(pacientes_id);
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
				marcarAtencionCirugia(agenda_id, inputValue);
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

function marcarAtencionCirugia(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/marcarAtencion.php';
	
    $.ajax({
	  type:'POST',
	  url:url,
	  data:'agenda_id='+agenda_id+'&fecha='+fecha+'&comentario='+comentario,
	  success: function(registro){
		var datos = eval(registro);
		
		if (datos[1] == "AtencionMedica"){
			showFacturaAgenda(datos[2]);//LLAMAMOS LA FACTURA .-Función se encuenta en myjava_atencioN_medica.js
		}
		
		if(datos[0] == 1){
			swal({
				title: "Success", 
				text: "Atencion marcada correctamente",
				icon: "success",
				timer: 3000, //timeOut for auto-close
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera				
			});		
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

//INICIO BUSQUEDA DE VALORES PARA EL PACIENTE, SEGUN EL PACIENTE SELECCIONADO
$(document).ready(function(e){
    $('#formulario_atenciones #paciente_consulta').on('change', function(){
	 if($('#formulario_atenciones #paciente_consulta').val() != "" || $('#formulario_atenciones #servicio_id').val() != ""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formulario_atenciones #paciente_consulta').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formulario_atenciones #edad').val(array[2]);
				$('#formulario_atenciones #edad_consulta').val(array[3]);
				$('#formulario_atenciones #pro').val("Registro");
				return false;			 				
			}		  			  
	    });
	    return false;		
	 }else{ 
		$('#formulario_atenciones')[0].reset();	
		$('#formulario_atenciones #pro').val("Registro");		
	 }
	});
});

$(document).ready(function(e){
    $('#formularioAtencionesPreoperatorio #pre_paciente_consulta').on('change', function(){
	 if($('#formularioAtencionesPreoperatorio #pre_paciente_consulta').val() != "" || $('#formularioAtencionesPreoperatorio #servicio_id').val() != ""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formularioAtencionesPreoperatorio #pre_paciente_consulta').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesPreoperatorio #pre_edad').val(array[2]);
				$('#formularioAtencionesPreoperatorio #pre_edad_consulta').val(array[3]);
				$('#formularioAtencionesPreoperatorio #pro_preoperatorio').val("Registro");				
				return false;			 				
			}		  			  
	    });
	    return false;		
	 }else{ 
		$('#formularioAtencionesPreoperatorio')[0].reset();	
		$('#formularioAtencionesPreoperatorio #pro_preoperatorio').val("Registro");		
	 }
	});
});

$(document).ready(function(e){
    $('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').on('change', function(){
	 if($('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').val() != "" || $('#formularioAtencionesNotaOperatoria #servicio_id').val() != ""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesNotaOperatoria #nota_edad').val(array[2]);
				$('#formularioAtencionesNotaOperatoria #nota_edad_consulta').val(array[3]);
				$('#formularioAtencionesNotaOperatoria #pro_notaoperatoria').val("Registro");					
				return false;			 				
			}		  			  
	    });
	    return false;		
	 }else{ 
		$('#formularioAtencionesNotaOperatoria')[0].reset();
		$('#formularioAtencionesNotaOperatoria #pro_notaoperatoria').val("Registro");		
	 }
	});
});

$(document).ready(function(e){
    $('#formularioAtencionesPostOperatoria #post_paciente_consulta').on('change', function(){
	 if($('#formularioAtencionesPostOperatoria #post_paciente_consulta').val() != "" || $('#formularioAtencionesPostOperatoria #servicio_id').val() != ""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formularioAtencionesPostOperatoria #post_paciente_consulta').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesPostOperatoria #post_edad').val(array[2]);
				$('#formularioAtencionesPostOperatoria #post_edad_consulta').val(array[3]);
				$('#formularioAtencionesPostOperatoria #pro_Postoperatoria').val("Registro");				
				return false;			 				
			}		  			  
	    });
	    return false;		
	 }else{ 
		$('#formularioAtencionesPostOperatoria')[0].reset();
		$('#formularioAtencionesPostOperatoria #pro_Postoperatoria').val("Registro");		
	 }
	});
});
//FIN BUSQUEDA DE VALORES PARA EL PACIENTE, SEGUN EL PACIENTE SELECCIONADO

//CONSULTAMOS TODAS LAS HISTORIAS CLINICAS DE ESTE USUARIO
function detallesAtencion(pacientes_id){
	$('#formulario_buscarAtencion #pacientes_id').val(pacientes_id);
	paginarSeguimientoCirugia(1);
}

function paginarSeguimientoCirugia(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/paginar_historias_clinicas.php';

	var pacientes_id = $('#formulario_buscarAtencion #pacientes_id').val();
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&pacientes_id='+pacientes_id,
		success:function(data){
			var array = eval(data);
			$('#formulario_buscarAtencion #paciente_consulta').html('<b>Paciente:</b> ' + getNombrePacienteAtencionCirugia(pacientes_id));
			$('#formulario_buscarAtencion #agrega_registros_busqueda_').html(array[0]);
			$('#formulario_buscarAtencion #paginationAtencionCirugia_busqueda_').html(array[1]);
		}
	});
	return false;	
}

//INICIO OBTENER EL AGENDA ID, DE LA ENTIDAD AGENDA DE PACIENTES
function getAgendaIDCirugia(pacientes_id, fecha, servicio){	
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAgendaIDCirugia.php';
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
	getEstadoAtencionCirugia();
	getPacientesAtencionCirugia();
	getProfesionAtencionCirugia();
	getReligionAtencionCirugia();
	getConsultorioAtencionCirugia();
}
//FIN AGRUPAR FUNCIONES DE PACIENTES

//INICIO OBTENER EL NOMBRE DEL PACIENTE
function getNombrePacienteAtencionCirugia(pacientes_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getNombrePaciente.php';
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
function getColaboradorAtencion_idAtencionCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getColaboradorAtencion.php';
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

//INICIO FUNCION PARA OBTENER LOS PACIENTES
function getPacientesAtencionCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getPacientes.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_atenciones #paciente_consulta').html("");
			$('#formulario_atenciones #paciente_consulta').html(data);
			
		    $('#formularioAtencionesPreoperatorio #pre_paciente_consulta').html("");
			$('#formularioAtencionesPreoperatorio #pre_paciente_consulta').html(data);

		    $('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').html("");
			$('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').html(data);

		    $('#formularioAtencionesPostOperatoria #post_paciente_consulta').html("");
			$('#formularioAtencionesPostOperatoria #post_paciente_consulta').html(data);			
        }
     });	
}
//FIN FUNCION PARA OBTENER LOS PACIENTES

//INICIO FUNCION PARA OBTENER LA RELIGION
function getReligionAtencionCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getReligion.php';		
		
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
function geEstadpCivlCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getEstadoCivil.php';		
		
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
function getProfesionAtencionCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getProfesion.php';		
		
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

//INICIO PARA OBTENER EL SERVICIO DEL FORMULARIO DE PACIENTES
function getServicioAtencion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/servicios.php';
	
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
function getEstadoAtencionCirugia(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getEstado.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){		
		    $('#form_main_atencion_medica #estado').html("");
			$('#form_main_atencion_medica #estado').html(data);	
		}			
     });		
}
//FIN PARA OBTENER EL ESTADO DE LOS PACIENTES (ATENDIDOS, AUSENTES)

function getConsultorioAtencionCirugia(){
	var url = '<?php echo SERVERURL; ?>php/citas/getServicio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   success:function(data){
	      $('#formulario_atenciones #atenciones_servicio_id').html("");
		  $('#formulario_atenciones #atenciones_servicio_id').html(data); 

	      $('#formularioAtencionesPreoperatorio #servicio_preoperatorio_id').html("");
		  $('#formularioAtencionesPreoperatorio #servicio_preoperatorio_id').html(data); 

	      $('#formularioAtencionesNotaOperatoria #servicio_notaOperatoria_id').html("");
		  $('#formularioAtencionesNotaOperatoria #servicio_notaOperatoria_id').html(data); 

	      $('#formularioAtencionesPostOperatoria #servicio_PostOperatorio_id').html("");
		  $('#formularioAtencionesPostOperatoria #servicio_PostOperatorio_id').html(data); 		  
	  }
	});
	return false;	
}

function convertDate(inputFormat) {
	function pad(s) { return (s < 10) ? '0' + s : s; }
	var d = new Date(inputFormat);
	return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

function getMes(fecha){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getMes.php';
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

function consultarNombre(pacientes_id){	
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

function consultarExpediente(pacientes_id){	
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
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
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

//INICIO FORMULARIO DE BUSQUEDA DE ATENCIONES PREOPERATORIO
$('#formularioAtencionesPreoperatorio #buscar_pacientes_atenciones_pre').on('click', function(e){
	listar_pacientes_buscar_atenciones_preoperatorio();
	 $('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_pacientes_buscar_atenciones_preoperatorio = function(){
	var table_pacientes_buscar_atenciones_preoperatorio = $("#dataTablePacientes").DataTable({		
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
	table_pacientes_buscar_atenciones_preoperatorio.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_atenciones_preoperatorio_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_atenciones_preoperatorio);
}

var view_pacientes_busqueda_atenciones_preoperatorio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesPreoperatorio #pacientes_id').val(data.pacientes_id);
		$('#formularioAtencionesPreoperatorio #pre_paciente_consulta').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = data.pacientes_id;
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesPreoperatorio #pre_edad').val(array[2]);
				$('#formularioAtencionesPreoperatorio #pre_edad_consulta').val(array[3]);				
				$("#reg_pre").attr('disabled', false);
				return false;			 				
			}		  			  
	    });
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA DE ATENCIONES PREOPERATORIO

//INICIO FORMULARIO DE BUSQUEDA DE ATENCIONES NOTA OPERATORIA
$('#formularioAtencionesNotaOperatoria #buscar_pacientes_atenciones_nota').on('click', function(e){
	listar_pacientes_buscar_atenciones_nota_operatoria();
	 $('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_pacientes_buscar_atenciones_nota_operatoria = function(){
	var table_pacientes_buscar_atenciones_nota_operatoria = $("#dataTablePacientes").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getPacienteTabla.php"
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
	table_pacientes_buscar_atenciones_nota_operatoria.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_atenciones_nota_operatoria_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_atenciones_nota_operatoria);
}

var view_pacientes_busqueda_atenciones_nota_operatoria_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesNotaOperatoria #pacientes_id').val(data.pacientes_id);
		$('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = data.pacientes_id;
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesNotaOperatoria #nota_edad').val(array[2]);
				$('#formularioAtencionesNotaOperatoria #nota_edad_consulta').val(array[3]);				
				$("#reg_pre").attr('disabled', false);
				return false;			 				
			}		  			  
	    });
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA DE ATENCIONESNOTA OPERATORIA

//INICIO FORMULARIO DE BUSQUEDA DE ATENCIONES POST-OPERATORIA
$('#formularioAtencionesPostOperatoria #buscar_pacientes_atenciones_post').on('click', function(e){
	listar_pacientes_buscar_atenciones_post_operatoria();
	 $('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_pacientes_buscar_atenciones_post_operatoria = function(){
	var table_pacientes_buscar_atenciones_post_operatoria = $("#dataTablePacientes").DataTable({		
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
	table_pacientes_buscar_atenciones_post_operatoria.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_atenciones_post_operatoria_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_atenciones_post_operatoria);
}

var view_pacientes_busqueda_atenciones_post_operatoria_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesPostOperatoria #pacientes_id').val(data.pacientes_id);
		$('#formularioAtencionesPostOperatoria #post_paciente_consulta').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = data.pacientes_id;
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
				var array = eval(data);		  				 
				$('#formularioAtencionesPostOperatoria #post_edad').val(array[2]);
				$('#formularioAtencionesPostOperatoria #post_edad_consulta').val(array[3]);					
				$("#reg_pre").attr('disabled', false);
				return false;			 				
			}		  			  
	    });
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA DE ATENCIONESNOTA POST-OPERATORIA

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

//INICIO BUSQUEDA DE SERVICIOS DE ATENCIONES PRE-OPERATORIO
$('#formularioAtencionesPreoperatorio #buscar_servicios_preoperatorio_id').on('click', function(e){
	listar_servicios_buscar_pre_operatorio();
	 $('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_servicios_buscar_pre_operatorio = function(){
	var table_servicios_buscar_pre_operatorio = $("#dataTableServicios").DataTable({		
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
	table_servicios_buscar_pre_operatorio.search('').draw();
	$('#buscar').focus();
	
	view_servicios_busqueda_preo_operatorio_dataTable("#dataTableServicios tbody", table_servicios_buscar_pre_operatorio);
}

var view_servicios_busqueda_preo_operatorio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesPreoperatorio #servicio_preoperatorio_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA DE SERVICIOS DE ATENCIONES PRE-OPERATORIO

//INICIO BUSQUEDA DE SERVICIOS DE ATENCIONES NOTA OPERATORIA
$('#formularioAtencionesNotaOperatoria #buscar_servicios_notaOperatoria_id').on('click', function(e){
	listar_servicios_buscar_nota_operatoria();
	 $('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_servicios_buscar_nota_operatoria = function(){
	var table_servicios_buscar_nota_operatoria = $("#dataTableServicios").DataTable({		
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
	table_servicios_buscar_nota_operatoria.search('').draw();
	$('#buscar').focus();
	
	view_servicios_busqueda_nota_operatoria_dataTable("#dataTableServicios tbody", table_servicios_buscar_nota_operatoria);
}

var view_servicios_busqueda_nota_operatoria_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesNotaOperatoria #servicio_notaOperatoria_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA DE SERVICIOS DE ATENCIONES NOTA OPERATORIA

//INICIO BUSQUEDA DE SERVICIOS DE ATENCIONES POST-OPERATORIO
$('#formularioAtencionesPostOperatoria #buscar_servicios_PostOperatorio_id').on('click', function(e){
	listar_servicios_buscar_post_operatorio();
	 $('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_servicios_buscar_post_operatorio = function(){
	var table_servicios_buscar_post_operatorio = $("#dataTableServicios").DataTable({		
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
	table_servicios_buscar_post_operatorio.search('').draw();
	$('#buscar').focus();
	
	view_servicios_busqueda_post_operatorio_dataTable("#dataTableServicios tbody", table_servicios_buscar_post_operatorio);
}

var view_servicios_busqueda_post_operatorio_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formularioAtencionesPostOperatoria #servicio_PostOperatorio_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA DE SERVICIOS DE ATENCIONES POST-OPERATORIO

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

$('#form_main_atencion_medica #nueva_factura').on('click', function(e){
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
	 $('#formulario_facturacion #colaborador_id').val(getColaboradorAtencion_idAtencionCirugia());
	 $('#formulario_facturacion #colaborador_nombre').val(getProfesionAtencionCirugial());
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

function getProfesionAtencionCirugial(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getProfesion.php';
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

function showFactura(agenda_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/editarFactura.php';
	
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
            $('#formulario_facturacion #fecha').val(getFechaActual());
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

function showFacturaAgenda(agenda_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/editarFacturaAgenda.php';
	
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
            $('#formulario_facturacion #fecha').val(getFechaActual());
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
			$('#main_atencion').hide();
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

function getFechaActual(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getFechaActual.php';
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

//INICIO FORMULARIO EXPEDIENTE CLINICO
$('#formulario_atenciones #cirugia_abdominal_expediente').keyup(function() {
	    var max_chars = 1000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_atenciones #charNum_cirugia_abdominal_expediente').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresCirugiaAbdominalExpedienteClinico(){
	var max_chars = 1000;
	var chars = $('#formulario_atenciones #cirugia_abdominal_expediente').val().length;
	var diff = max_chars - chars;

	$('#formulario_atenciones #charNum_cirugia_abdominal_expediente').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_atenciones #diagnostico').keyup(function() {
	    var max_chars = 3000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_atenciones #charNum_diagnostico').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresDiagnosticoExpedienteClinico(){
	var max_chars = 3000;
	var chars = $('#formulario_atenciones #diagnostico').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_atenciones #charNum_diagnostico').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_atenciones #expe_observaciones').keyup(function() {
	    var max_chars = 3000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_atenciones #charNum_expe_observaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresExpObservaciones(){
	var max_chars = 1000;
	var chars = $('#formulario_atenciones #expe_observaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_atenciones #charNum_expe_observaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN FORMULARIO EXPEDIENTE CLINICO

//INICIO FORMULARIO ATENCIONES PRE OPERATORIO	
$('#formularioAtencionesPreoperatorio #pre_resultados_examenes').keyup(function() {
	    var max_chars = 3000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formularioAtencionesPreoperatorio #charNum_pre_resultados').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosExamenesPre(){
	var max_chars = 3000;
	var chars = $('#formularioAtencionesPreoperatorio #pre_resultados_examenes').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPreoperatorio #charNum_pre_resultados').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPreoperatorio #pre_recomendaciones').keyup(function() {
	    var max_chars = 3000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formularioAtencionesPreoperatorio #charNum_pre_recomendaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresRecomendaciones(){
	var max_chars = 3000;
	var chars = $('#formularioAtencionesPreoperatorio #pre_recomendaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPreoperatorio #charNum_pre_recomendaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN FORMULARIO ATENCIONES PRE OPERATORIO

//INICIO FORMULARIO ATENCIONES NOTA OPERATORIA
$('#formularioAtencionesNotaOperatoria #nota_tecnica').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_tecnica').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaTecnica(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_tecnica').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_tecnica').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}	

$('#formularioAtencionesNotaOperatoria #nota_otros').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_otros').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaOtros(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_otros').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_otros').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_hallazgos_operativos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaHallazgosOperativos(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_hallazgos_operativos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_descripcion_operatoria').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaDescripcionOperatoria(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_descripcion_operatoria').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesNotaOperatoria #nota_indicaciones').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_indicaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaIndicaciones(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_indicaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_indicaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesNotaOperatoria #nota_recomendaciones').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_recomendaciones').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaRecomendaciones(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_recomendaciones').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_recomendaciones').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesNotaOperatoria #nota_comentarios').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesNotaOperatoria #charNum_nota_comentarios').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosNotaOperatoriaComentarios(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesNotaOperatoria #nota_comentarios').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesNotaOperatoria #charNum_nota_comentarios').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN FORMULARIO ATENCIONES NOTA OPERATORIA

//INICIO FORMULARIO ATENCIONES POST OPERATORIA
$('#formularioAtencionesPostOperatoria #post_otros').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_otros').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaOtros(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_otros').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_mejoria').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_mejoria').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_mejoria').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaMejoria(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_mejoria').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_mejoria').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_estado_actual').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_estado_actual').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaEstadoActual(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_estado_actual').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_estado_actual').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_medicamentos').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_medicamentos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaMedicamentos(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_medicamentos').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_medicamentos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_hallazgos').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_hallazgos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaHallazgos(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_hallazgos').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_hallazgos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_comentarios').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_comentarios').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaComentarios(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_comentarios').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_comentarios').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formularioAtencionesPostOperatoria #post_plan').keyup(function() {
		var max_chars = 2000;
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		
		$('#formularioAtencionesPostOperatoria #charNum_post_plan').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresResultadosPostOperatoriaPlan(){
	var max_chars = 2000;
	var chars = $('#formularioAtencionesPostOperatoria #post_plan').val().length;
	var diff = max_chars - chars;
	
	$('#formularioAtencionesPostOperatoria #charNum_post_plan').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

//FIN FORMULARIO ATENCIONES POST OPERATORIA
	
$(document).ready(function() {
	//INICIO FORMULARIO ATENCIONES EXPEDIENTE CLINICO
	$('#formulario_atenciones #search_cirugia_abdominal_expediente_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_atenciones #search_cirugia_abdominal_expediente_start').on('click',function(event){
		$('#formulario_atenciones #search_cirugia_abdominal_expediente_start').hide();
		$('#formulario_atenciones #search_cirugia_abdominal_expediente_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_atenciones #cirugia_abdominal_expediente').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_atenciones #cirugia_abdominal_expediente').val(valor_anterior + ' ' + finalResult);
						caracteresCirugiaAbdominalExpedienteClinico();
					}else{
						$('#formulario_atenciones #cirugia_abdominal_expediente').val(finalResult);
						caracteresCirugiaAbdominalExpedienteClinico();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_atenciones #search_cirugia_abdominal_expediente_stop').on("click", function(event){
		$('#formulario_atenciones #search_cirugia_abdominal_expediente_start').show();
		$('#formulario_atenciones #search_cirugia_abdominal_expediente_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_atenciones #search_diagnostico_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_atenciones #search_diagnostico_start').on('click',function(event){
		$('#formulario_atenciones #search_diagnostico_start').hide();
		$('#formulario_atenciones #search_diagnostico_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_atenciones #diagnostico').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_atenciones #diagnostico').val(valor_anterior + ' ' + finalResult);
						caracteresDiagnosticoExpedienteClinico();
					}else{
						$('#formulario_atenciones #diagnostico').val(finalResult);
						caracteresDiagnosticoExpedienteClinico();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_atenciones #search_diagnostico_stop').on("click", function(event){
		$('#formulario_atenciones #search_diagnostico_start').show();
		$('#formulario_atenciones #search_diagnostico_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_atenciones #search_expe_observaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_atenciones #search_expe_observaciones_start').on('click',function(event){
		$('#formulario_atenciones #search_expe_observaciones_start').hide();
		$('#formulario_atenciones #search_expe_observaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_atenciones #expe_observaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_atenciones #expe_observaciones').val(valor_anterior + ' ' + finalResult);
						caracteresExpObservaciones();
					}else{
						$('#formulario_atenciones #expe_observaciones').val(finalResult);
						caracteresExpObservaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_atenciones #search_expe_observaciones_stop').on("click", function(event){
		$('#formulario_atenciones #search_expe_observaciones_start').show();
		$('#formulario_atenciones #search_diagnostico_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/



	//INICIO FORMULARIO ATENCIONES PRE OPERATORIO
	$('#formularioAtencionesPreoperatorio #search_pre_resultados_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPreoperatorio #search_pre_resultados_start').on('click',function(event){
		$('#formularioAtencionesPreoperatorio #search_pre_resultados_start').hide();
		$('#formularioAtencionesPreoperatorio #search_pre_resultados_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPreoperatorio #pre_resultados_examenes').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPreoperatorio #pre_resultados_examenes').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosExamenesPre();
					}else{
						$('#formularioAtencionesPreoperatorio #pre_resultados_examenes').val(finalResult);
						caracteresResultadosExamenesPre();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPreoperatorio #search_pre_resultados_stop').on("click", function(event){
		$('#formularioAtencionesPreoperatorio #search_pre_resultados_start').show();
		$('#formularioAtencionesPreoperatorio #search_pre_resultados_stop').hide();
		recognition.stop();
	});		
	
	/*###################################################################################################*/
	$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_start').on('click',function(event){
		$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_start').hide();
		$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPreoperatorio #pre_recomendaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPreoperatorio #pre_recomendaciones').val(valor_anterior + ' ' + finalResult);
						caracteresRecomendaciones();
					}else{
						$('#formularioAtencionesPreoperatorio #pre_recomendaciones').val(finalResult);
						caracteresRecomendaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_stop').on("click", function(event){
		$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_start').show();
		$('#formularioAtencionesPreoperatorio #search_pre_recomendaciones_stop').hide();
		recognition.stop();
	});		
	//FIN FORMULARIO ATENCIONES PRE OPERATORIO
	
	//INICIO FORMULARIO ATENCIONES NOTA OPERATORIA
	$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesNotaOperatoria #search_nota_tecnica_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_tecnica').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_tecnica').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaTecnica();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_tecnica').val(finalResult);
						caracteresResultadosNotaOperatoriaTecnica();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_tecnica_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/
	$('#formularioAtencionesNotaOperatoria #search_nota_otros_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesNotaOperatoria #search_nota_otros_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_otros_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_otros_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_otros').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_otros').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaOtros();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_otros').val(finalResult);
						caracteresResultadosNotaOperatoriaOtros();
					}				
				}
			}
		};		
		return false;
    });	
	
		$('#formularioAtencionesNotaOperatoria #search_nota_otros_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_otros_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_otros_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/
	$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaHallazgosOperativos();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val(finalResult);
						caracteresResultadosNotaOperatoriaHallazgosOperativos();
					}				
				}
			}
		};		
		return false;
    });	
	
		$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_hallazgos_operativos_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/
	$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaDescripcionOperatoria();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val(finalResult);
						caracteresResultadosNotaOperatoriaDescripcionOperatoria();
					}				
				}
			}
		};		
		return false;
    });	
	
		$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_descripcion_operatoria_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/
	$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";

    $('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_indicaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_indicaciones').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaIndicaciones();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_indicaciones').val(finalResult);
						caracteresResultadosNotaOperatoriaIndicaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_indicaciones_stop').hide();
		recognition.stop();
	});		

	/*###################################################################################################*/
	$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";

    $('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_recomendaciones').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_recomendaciones').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaRecomendaciones();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_recomendaciones').val(finalResult);
						caracteresResultadosNotaOperatoriaRecomendaciones();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_recomendaciones_stop').hide();
		recognition.stop();
	});

	/*###################################################################################################*/	
	$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesNotaOperatoria #search_nota_comentarios_start').on('click',function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_start').hide();
		$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesNotaOperatoria #nota_comentarios').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesNotaOperatoria #nota_comentarios').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosNotaOperatoriaComentarios();
					}else{
						$('#formularioAtencionesNotaOperatoria #nota_comentarios').val(finalResult);
						caracteresResultadosNotaOperatoriaComentarios();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_stop').on("click", function(event){
		$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_start').show();
		$('#formularioAtencionesNotaOperatoria #search_nota_comentarios_stop').hide();
		recognition.stop();
	});			
	//FIN FORMULARIO ATENCIONES NOTA OPERATORIA
	
	//INICIO FORMULARIO ATENCIONES POST OPERATORIA
	$('#formularioAtencionesPostOperatoria #search_post_otros_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_otros_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_otros_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_otros_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_otros').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_otros').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaOtros();
					}else{
						$('#formularioAtencionesPostOperatoria #post_otros').val(finalResult);
						caracteresResultadosPostOperatoriaOtros();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_otros_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_otros_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_otros_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/
	$('#formularioAtencionesPostOperatoria #search_post_mejoria_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_mejoria_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_mejoria_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_mejoria_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_mejoria').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_mejoria').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaMejoria();
					}else{
						$('#formularioAtencionesPostOperatoria #post_mejoria').val(finalResult);
						caracteresResultadosPostOperatoriaMejoria();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_mejoria_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_mejoria_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_mejoria_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/

	$('#formularioAtencionesPostOperatoria #search_post_estado_actual_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_estado_actual_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_estado_actual_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_estado_actual_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_estado_actual').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_estado_actual').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaEstadoActual();
					}else{
						$('#formularioAtencionesPostOperatoria #post_estado_actual').val(finalResult);
						caracteresResultadosPostOperatoriaEstadoActual();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_estado_actual_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_estado_actual_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_estado_actual_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/	
	
	$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_medicamentos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_medicamentos').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaMedicamentos();
					}else{
						$('#formularioAtencionesPostOperatoria #post_medicamentos').val(finalResult);
						caracteresResultadosPostOperatoriaMedicamentos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_medicamentos_actual_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/	
	
	$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_hallazgos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_hallazgos').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaHallazgos();
					}else{
						$('#formularioAtencionesPostOperatoria #post_hallazgos').val(finalResult);
						caracteresResultadosPostOperatoriaHallazgos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_hallazgos_actual_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/		
	
	$('#formularioAtencionesPostOperatoria #search_post_comentarios_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_comentarios_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_comentarios_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_comentarios_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_comentarios').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_comentarios').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaComentarios();
					}else{
						$('#formularioAtencionesPostOperatoria #post_comentarios').val(finalResult);
						caracteresResultadosPostOperatoriaComentarios();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_comentarios_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_comentarios_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_comentarios_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/	
	
	$('#formularioAtencionesPostOperatoria #search_post_plan_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formularioAtencionesPostOperatoria #search_post_plan_start').on('click',function(event){
		$('#formularioAtencionesPostOperatoria #search_post_plan_start').hide();
		$('#formularioAtencionesPostOperatoria #search_post_plan_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formularioAtencionesPostOperatoria #post_plan').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formularioAtencionesPostOperatoria #post_plan').val(valor_anterior + ' ' + finalResult);
						caracteresResultadosPostOperatoriaPlan();
					}else{
						$('#formularioAtencionesPostOperatoria #post_plan').val(finalResult);
						caracteresResultadosPostOperatoriaPlan();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formularioAtencionesPostOperatoria #search_post_plan_stop').on("click", function(event){
		$('#formularioAtencionesPostOperatoria #search_post_plan_start').show();
		$('#formularioAtencionesPostOperatoria #search_post_plan_stop').hide();
		recognition.stop();
	});		
	/*###################################################################################################*/		
	//FIN FORMULARIO ATENCIONES POST OPERATORIA	
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
function getAtencionPaciente(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionPaciente.php';
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

function getAtencionPacientePreOperatorio(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionPacientePreOperatorio.php';
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

function getAtencionPacienteNotaOperatoria(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionPacienteNotaOperatoria.php';
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

function getAtencionPacientePostOperatorio(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionPacientePostOperatorio.php';
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

$(document).ready(function() {
	//Seguimiento Paciente Nuevo
	$("#formulario_atenciones #peso_maximo_alcanzado").on("keyup", function(e){
		var lb = 0.00;

		if($("#formulario_atenciones #peso_maximo_alcanzado").val() == "" || $("#formulario_atenciones #peso_maximo_alcanzado").val() == null){
			lb = 0.00;			
		}else{
			lb = parseFloat($("#formulario_atenciones #peso_maximo_alcanzado").val());
		}
		
		var kg = 0.00;
		if(kg != 0 ||  kg != "" || kg != null){
			var kg = lb/2.205;
			kg = parseFloat(kg).toFixed(2);
		}

		$("#formulario_atenciones #peso_maximo_alcanzado_kg").val(kg);
	});

	function pacienteNuevoCalculo(){
		var lb = 0.00;
		var talla = 0.00;

		if($("#formulario_atenciones #peso").val() == "" || $("#formulario_atenciones #peso").val() == null){
			lb = 0.00;			
		}else{
			lb = parseFloat($("#formulario_atenciones #peso").val());
		}

		if($("#formulario_atenciones #talla").val() == "" || $("#formulario_atenciones #talla").val() == null){
			talla = 0.00;			
		}else{
			talla = parseFloat($("#formulario_atenciones #talla").val());
		}		
		
		var kg = 0.00;
		var imc = 0.00;

		var kg = lb/2.205;
		kg = parseFloat(kg).toFixed(2);

		if(talla == 0){
			imc = 0;
		}else{
			imc = kg / (talla * talla);
			imc = parseFloat(imc).toFixed(2);
		}

		if(kg == null || kg == ""){
			kg = 0.0;
		}

		if(imc == null || imc == ""){
			imc = 0.0;
		}		

		$("#formulario_atenciones #peso_kg").val(kg);
		$("#formulario_atenciones #imc").val(imc);		
	}

	$("#formulario_atenciones #talla").on("keyup", function(e){
		pacienteNuevoCalculo();
	});	

	$("#formulario_atenciones #peso").on("keyup", function(e){
		pacienteNuevoCalculo();
	});	

	$("#formulario_atenciones #peso_ideal").on("keyup", function(e){
		var lb = 0.00;

		if($("#formulario_atenciones #peso_ideal").val() == "" || $("#formulario_atenciones #peso_ideal").val() == null){
			lb = 0.00;			
		}else{
			lb = parseFloat($("#formulario_atenciones #peso_ideal").val());
		}
		
		var kg = 0.00;
		if(kg != 0 ||  kg != "" || kg != null){
			var kg = lb/2.205;
			kg = parseFloat(kg).toFixed(2);
		}

		$("#formulario_atenciones #peso_ideal_kg").val(kg);
	});	
	
	$("#formulario_atenciones #exceso_peso").on("keyup", function(e){
		var lb = 0.00;

		if($("#formulario_atenciones #exceso_peso").val() == "" || $("#formulario_atenciones #exceso_peso").val() == null){
			lb = 0.00;			
		}else{
			lb = parseFloat($("#formulario_atenciones #exceso_peso").val());
		}
		
		var kg = 0.00;
		if(kg != 0 ||  kg != "" || kg != null){
			var kg = lb/2.205;
			kg = parseFloat(kg).toFixed(2);
		}

		$("#formulario_atenciones #exceso_peso_kg").val(kg);
	});		

	//Seguimiento Pre-Operatorio
	function preOperatorioCalculo(){
		var lb = 0.00;
		var talla = 0.00;

		if($("#formularioAtencionesPreoperatorio #pre_peso_actual").val() == "" || $("#formularioAtencionesPreoperatorio #pre_peso_actual").val() == null){
			lb = 0.00;			
		}else{
			lb = parseFloat($("#formularioAtencionesPreoperatorio #pre_peso_actual").val());
		}

		if($("#formularioAtencionesPreoperatorio #pre_talla").val() == "" || $("#formularioAtencionesPreoperatorio #pre_talla").val() == null){
			talla = 0.00;			
		}else{
			talla = parseFloat($("#formularioAtencionesPreoperatorio #pre_talla").val());
		}

		var kg = 0.00;
		var imc = 0.00;

		var kg = lb/2.205;
		kg = parseFloat(kg).toFixed(2);

		if(talla == 0){
			imc = 0;
		}else{
			imc = kg / (talla * talla);
			imc = parseFloat(imc).toFixed(2);
		}

		if(kg == null || kg == ""){
			kg = 0.0;
		}

		if(imc == null || imc == ""){
			imc = 0.0;
		}			

		$("#formularioAtencionesPreoperatorio #pre_peso_actual_kg").val(kg);
		$("#formularioAtencionesPreoperatorio #pre_imc_actual").val(imc);		

		var peso_anterior = $('#formulario_atenciones #peso').val();
		var peso_actual = $('#formularioAtencionesPreoperatorio #pre_peso_actual').val();
		$('#formularioAtencionesPreoperatorio #pre_peso_perdido').val(peso_anterior - peso_actual);	
	}

	$("#formularioAtencionesPreoperatorio #pre_talla").on("keyup", function(e){
		preOperatorioCalculo();
	});

	$("#formularioAtencionesPreoperatorio #pre_peso_actual").on("keyup", function(e){
		preOperatorioCalculo();
	});

	//SeguimientoNota Operatoria
	function postOperatorioCalculo() {
		// Obtener valores del formulario
		let lb = parseFloat($("#formularioAtencionesPostOperatoria #post_peso_actual").val()) || 0.00;
		let talla = parseFloat($("#formularioAtencionesPostOperatoria #post_talla").val()) || 0.00;

		// Convertir libras a kilogramos
		let kg = lb > 0 ? (lb / 2.205).toFixed(2) : "0.00";

		// Calcular IMC
		let imc = talla > 0 ? (kg / (talla * talla)).toFixed(2) : "0.00";

		// Actualizar campos de peso en kg e IMC
		$("#formularioAtencionesPostOperatoria #post_peso_actual_kg").val(kg);
		$("#formularioAtencionesPostOperatoria #post_imc_actual").val(imc);

		// Obtener valores iniciales y calcular peso perdido
		let pesoInicial = parseFloat($('#formulario_atenciones #peso').val()) || 0.00; // Peso inicial
		let pesoActual = parseFloat($("#formularioAtencionesPostOperatoria #post_peso_actual").val()) || 0.00; // Peso actual
		let pesoIdeal = parseFloat($('#formulario_atenciones #peso_ideal').val()) || 0.00; // Peso ideal

		let pesoPerdido = pesoInicial > pesoActual ? (pesoInicial - pesoActual).toFixed(2) : "0.00";
		$("#formularioAtencionesPostOperatoria #post_peso_perdido").val(pesoPerdido);

		// Calcular EWL (Excess Weight Loss)
		let excesoPesoInicial = pesoInicial > pesoIdeal ? (pesoInicial - pesoIdeal) : 0.00; // Validar exceso de peso inicial
		let ewl = excesoPesoInicial > 0
			? ((pesoInicial - pesoActual) / excesoPesoInicial * 100).toFixed(2)
			: "0.00";
		
		$("#formularioAtencionesPostOperatoria #post_ewl").val(ewl);
	}

	$("#formularioAtencionesNotaOperatoria #nota_talla").on("keyup", function(e){
		notaOperatoriaCalculo();
	});	

	$("#formularioAtencionesNotaOperatoria #nota_peso_actual").on("keyup", function(e){
		notaOperatoriaCalculo();
	});	

	//Seguimiento Post-Operatorio
	function postOperatorioCalculo() {
		let lb = parseFloat($("#formularioAtencionesPostOperatoria #post_peso_actual").val()) || 0.00;
		let talla = parseFloat($("#formularioAtencionesPostOperatoria #post_talla").val()) || 0.00;

		// Convertir libras a kilogramos
		let kg = lb > 0 ? (lb / 2.205).toFixed(2) : "0.00";

		// Calcular IMC
		let imc = talla > 0 ? (kg / (talla * talla)).toFixed(2) : "0.00";

		// Actualizar campos de peso en kg e IMC
		$("#formularioAtencionesPostOperatoria #post_peso_actual_kg").val(kg);
		$("#formularioAtencionesPostOperatoria #post_imc_actual").val(imc);

		// Calcular peso perdido
		let pesoInicial = parseFloat($('#formulario_atenciones #peso').val()) || 0.00;
		let pesoActual = parseFloat($("#formularioAtencionesPostOperatoria #post_peso_actual").val()) || 0.00; //Peso Actual
		let pesoIdeal = parseFloat($('#formulario_atenciones #peso_ideal').val()) || 0.00;
		let pesoPerdido = (pesoInicial - pesoActual).toFixed(2);
		$("#formularioAtencionesPostOperatoria #post_peso_perdido").val(pesoPerdido);

		// Calcular %EWL (Excess Weight Loss)
		let ewl = (pesoIdeal < pesoInicial && pesoInicial > pesoActual)
			? (((pesoInicial - pesoActual) / (pesoInicial - pesoIdeal)) * 100).toFixed(2)
			: "0.00";
		$("#formularioAtencionesPostOperatoria #post_ewl").val(ewl);
	}

	$("#formularioAtencionesPostOperatoria #post_talla").on("keyup", function(e){
		postOperatorioCalculo();
	});		

	$("#formularioAtencionesPostOperatoria #post_peso_actual").on("keyup", function(e){
		postOperatorioCalculo();
	});		
});

function fillPlantillasAtencion(){
	getHallazgosOperatorios();
	getDescripcionOperatoria();
	getIndicaciones();	
}

function getHallazgosOperatorios(){
	var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantilla.php';
	var atenciones_id = 1;
	
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'atenciones_id='+atenciones_id,			
        success: function(data){		
		    $('#formularioAtencionesNotaOperatoria #plantilla_notas_hallazgos_operativos').html("");
			$('#formularioAtencionesNotaOperatoria #plantilla_notas_hallazgos_operativos').html(data);	
		}			
     });
}

$(document).ready(function(e) {
    $('#formularioAtencionesNotaOperatoria #plantilla_notas_hallazgos_operativos').on('change', function(){
		var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantillaDescripcion.php';
        var plantillas_id = $('#formularioAtencionesNotaOperatoria #plantilla_notas_hallazgos_operativos').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'plantillas_id='+plantillas_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val(array[0]);
			  $('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').focus();			  
		  }
	  });
	  return false;		
	});
});

function getDescripcionOperatoria(){
	var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantilla.php';	
	var atenciones_id = 2;
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'atenciones_id='+atenciones_id,			
        success: function(data){		
		    $('#formularioAtencionesNotaOperatoria #plantilla_notas_descripcion_operativa').html("");
			$('#formularioAtencionesNotaOperatoria #plantilla_notas_descripcion_operativa').html(data);	
		}			
     });
}

$(document).ready(function(e) {
    $('#formularioAtencionesNotaOperatoria #plantilla_notas_descripcion_operativa').on('change', function(){
		var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantillaDescripcion.php';
        var plantillas_id = $('#formularioAtencionesNotaOperatoria #plantilla_notas_descripcion_operativa').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'plantillas_id='+plantillas_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val(array[0]);
			  $('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').focus();			  
		  }
	  });
	  return false;		
	});
});

function getIndicaciones(){
	var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantilla.php';	
	var atenciones_id = 3;
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
		data:'atenciones_id='+atenciones_id,			
        success: function(data){		
		    $('#formularioAtencionesNotaOperatoria #plantilla_notas_indicaciones').html("");
			$('#formularioAtencionesNotaOperatoria #plantilla_notas_indicaciones').html(data);	
		}			
     });
}

$(document).ready(function(e) {
    $('#formularioAtencionesNotaOperatoria #plantilla_notas_indicaciones').on('change', function(){
		var url = '<?php echo SERVERURL; ?>php/plantillas/getPlantillaDescripcion.php';
        var plantillas_id = $('#formularioAtencionesNotaOperatoria #plantilla_notas_indicaciones').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'plantillas_id='+plantillas_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formularioAtencionesNotaOperatoria #nota_indicaciones').val(array[0]);
			  $('#formularioAtencionesNotaOperatoria #nota_indicaciones').focus();			  
		  }
	  });
	  return false;		
	});
});

function setAtencion(pacientes_id, colaborador_id){
	$('#main_facturacion').hide();
	$('#main_atencion').show();

	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		$('#formulario_pacientes_atenciones')[0].reset();		

		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/consultarPaciente.php';
		   $.ajax({
			   type:'POST',
			   url:url,
			   data:'pacientes_id='+pacientes_id,
			   success: function(valores){
					var datos = eval(valores);
					$('#regPacientes').hide();
					$('#ediPacientes').show();	

					$('#formulario_pacientes_atenciones #pro').val('Edición');
					$('#formulario_pacientes_atenciones #grupo_expediente').show();
					$('#formulario_pacientes_atenciones #pacientes_id').val(pacientes_id);
					$('#formulario_pacientes_atenciones #fecha_cita').val(getFechaCita(agenda_id));
					$('#formulario_seguimiento #fecha_cita').val(getFechaCita(agenda_id));										
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
					getMunicipioAtencionEditar(datos[10], datos[11]);
					$('#formulario_pacientes_atenciones #pais_id').val(datos[12]);
					$('#formulario_pacientes_atenciones #responsable').val(datos[13]);
					$('#formulario_pacientes_atenciones #responsable_id').val(datos[14]);
					$('#formulario_pacientes_atenciones #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes_atenciones #identidad').val(datos[16]);					
					$('#perfil_nombre').html(datos[17]);				
					$('#formulario_pacientes_atenciones #referido').val(datos[18]);

					$('#formulario_atenciones #edad_consulta').val(datos[6]);
					$('#formulario_atenciones #edad_consulta').attr('readonly', true);
					$('#formulario_atenciones #atenciones_servicio_id').val(datos[19]);

					//DATOS DE LA HISTORIA CLINICA DEL PACIENTE
					$('#formulario_atenciones #motivo_consulta').val(datos[19]);
	
					$("#formulario_pacientes_atenciones #fecha").attr('readonly', true);
					$("#formulario_pacientes_atenciones #expediente").attr('readonly', true);
					$("#formulario_pacientes_atenciones #identidad").attr('readonly', true);
					$('#formulario_pacientes_atenciones #validate').removeClass('bien_email');
					$('#formulario_pacientes_atenciones #validate').removeClass('error_email');
					$("#formulario_pacientes_atenciones #correo").css("border-color", "none");
					$('#formulario_pacientes_atenciones #validate').html('');

					//FORMULARIO ATENCIONES MEDICAS 1ERA CONSULTA

					//EXPEDIENTE CLINICO
					$('#formulario_atenciones #agenda_id').val(agenda_id);

					$('#formulario_atenciones #pacientes_id').val(pacientes_id);
					$('#formulario_atenciones #colaborador_id').val(colaborador_id);
					$('#formulario_atenciones #servicio_id').val(servicio_id);

					$('#formulario_atenciones #paciente_consulta').val(datos[17]);
					$('#formulario_atenciones #edad').val(datos[6]);
					$('#formulario_atenciones #edad_consulta').val(datos[19]);
					$('#formulario_atenciones #atenciones_servicio_id').val(servicio_id);

					$('#formulario_atenciones #paciente_consulta').attr('readonly', true);

					//INICIO PREOPERATORIO
					$('#formularioAtencionesPreoperatorio #agenda_id').val(agenda_id);
					$('#formularioAtencionesPreoperatorio #pacientes_id').val(pacientes_id);
					$('#formularioAtencionesPreoperatorio #colaborador_id').val(colaborador_id);
					$('#formularioAtencionesPreoperatorio #servicio_id').val($('#servicio_preoperatorio_id').val());
					$('#formularioAtencionesPreoperatorio #pre_paciente_consulta').val(datos[17]);
					$('#formularioAtencionesPreoperatorio #pre_edad').val(datos[6]);
					$('#formularioAtencionesPreoperatorio #pre_edad_consulta').val(datos[19]);
					$('#formularioAtencionesPreoperatorio #servicio_preoperatorio_id').val(servicio_id);

					$('#formularioAtencionesPreoperatorio #pre_paciente_consulta	').attr('readonly', true);

					//INICIO NOTA OPERATORIA
					$('#formularioAtencionesNotaOperatoria #agenda_id').val(agenda_id);
					$('#formularioAtencionesNotaOperatoria #pacientes_id').val(pacientes_id);
					$('#formularioAtencionesNotaOperatoria #colaborador_id').val(colaborador_id);
					$('#formularioAtencionesNotaOperatoria #servicio_id').val(servicio_id);
					$('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').val(datos[17]);
					$('#formularioAtencionesNotaOperatoria #nota_edad').val(datos[6]);
					$('#formularioAtencionesNotaOperatoria #nota_edad_consulta').val(datos[19]);
					$('#formularioAtencionesNotaOperatoria #servicio_notaOperatoria_id').val(servicio_id);

					$('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').attr('readonly', true);
				

					//INICIO POST OPERTATORIO
					$('#formularioAtencionesPostOperatoria #agenda_id').val(agenda_id);
					$('#formularioAtencionesPostOperatoria #pacientes_id').val(pacientes_id);
					$('#formularioAtencionesPostOperatoria #colaborador_id').val(colaborador_id);
					$('#formularioAtencionesPostOperatoria #servicio_id').val(servicio_id);
					$('#formularioAtencionesPostOperatoria #post_paciente_consulta').val(datos[17]);
					$('#formularioAtencionesPostOperatoria #post_edad').val(datos[6]);
					$('#formularioAtencionesPostOperatoria #post_edad_consulta').val(datos[19]);
					$('#formularioAtencionesPostOperatoria #servicio_PostOperatorio_id').val(servicio_id);

					$('#formularioAtencionesPostOperatoria #post_paciente_consulta').attr('readonly', true);
					
					viewExpediente(pacientes_id);
					viewPreoOperatorio(pacientes_id);
					viewNotaOperatoria(pacientes_id);
					viewPostOperatorio(pacientes_id);	
					mostrarArchivos(pacientes_id);
					mostrarArchivosNotaOperatoria(pacientes_id);

					setPreOperatorio();
					setNotaOperatorio();

					paginationSeguimiento1(1, pacientes_id);

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

function setPreOperatorio(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarDatosPreOperatorio.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formularioAtencionesPreoperatorio').serialize(),
		success: function(valores){
			var datos = eval(valores);

			if(datos[0] == "" || datos[0] == null){
				$('#reg_pre').show();
				$('#edi_pre').hide();
				$('#formularioAtencionesPreoperatorio #fechaConsultaGrupo').hide();	
				$('#formularioAtencionesPreoperatorio #fecha_consulta').attr("readonly", true);					
			}else{
				$('#reg_pre').hide();
				$('#edi_pre').show();
				$('#formularioAtencionesPreoperatorio #fechaConsultaGrupo').show();
				$('#formularioAtencionesPreoperatorio #fecha_consulta').val(datos[12]);	
				$('#formularioAtencionesPreoperatorio #fecha_consulta').attr("readonly", true);					
			}	

			$('#formularioAtencionesPreoperatorio #pro').val('Edición');				
			$('#formularioAtencionesPreoperatorio #pre_peso_actual').val(datos[0]);	
			$('#formularioAtencionesPreoperatorio #pre_peso_actual_kg').val(datos[1]);
			$('#formularioAtencionesPreoperatorio #pre_peso_perdido').val(datos[2]);	
			$('#formularioAtencionesPreoperatorio #pre_imc_actual').val(datos[3]);
			$('#formularioAtencionesPreoperatorio #pre_resultados_examenes').val(datos[4]);	
			
			if(datos[5] == 1){
				$('#formularioAtencionesPreoperatorio #psiquiatra_activo').prop('checked', true);
				$('#formularioAtencionesPreoperatorio #label_psiquiatra_activo').html("Sí");				
			}else{
				$('#formularioAtencionesPreoperatorio #psiquiatra_activo').prop('checked', false);
				$('#formularioAtencionesPreoperatorio #label_psiquiatra_activo').html("No");	
			}

			if(datos[6] == 1){
				$('#formularioAtencionesPreoperatorio #psicologo_activo').prop('checked', true);
				$('#formularioAtencionesPreoperatorio #label_psicologo_activo').html("Sí");				
			}else{
				$('#formularioAtencionesPreoperatorio #psicologo_activo').prop('checked', false);
				$('#formularioAtencionesPreoperatorio #label_psicologo_activo').html("No");	
			}			

			if(datos[7] == 1){
				$('#formularioAtencionesPreoperatorio #nutricion_activo').prop('checked', true);
				$('#formularioAtencionesPreoperatorio #label_nutricion_activo').html("Sí");				
			}else{
				$('#formularioAtencionesPreoperatorio #nutricion_activo').prop('checked', false);
				$('#formularioAtencionesPreoperatorio #label_nutricion_activo').html("No");	
			}	
			
			if(datos[8] == 1){
				$('#formularioAtencionesPreoperatorio #medicina_interna_activo').prop('checked', true);
				$('#formularioAtencionesPreoperatorio #label_medicina_interna_activo').html("Sí");				
			}else{
				$('#formularioAtencionesPreoperatorio #medicina_interna_activo').prop('checked', false);
				$('#formularioAtencionesPreoperatorio #label_medicina_interna_activo').html("No");	
			}				


			$('#formularioAtencionesPreoperatorio #pre_recomendaciones').val(datos[9]);		
			$('#formularioAtencionesPreoperatorio #pre_fecha_cirugia').val(datos[10]);	
			$('#formularioAtencionesPreoperatorio #pre_tipo_cirugia').val(datos[11]);
			$('#formularioAtencionesPreoperatorio #servicio_preoperatorio_id').val(datos[13]);		
			
			caracteresRecomendaciones();
		}
	});
}

function setNotaOperatorio(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarDatosNotaOperatorio.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formularioAtencionesNotaOperatoria').serialize(),
		success: function(valores){
			var datos = eval(valores);

			if(datos[0] == "" || datos[0] == null){
				$('#reg_nota').show();
				$('#edi_nota').hide();	
				$('#formularioAtencionesNotaOperatoria #fechaConsultaGrupo').hide();	
				$('#formularioAtencionesNotaOperatoria #fecha_consulta').attr("readonly", true);								
			}else{
				$('#reg_nota').hide();
				$('#edi_nota').show();
				$('#formularioAtencionesNotaOperatoria #fechaConsultaGrupo').show();
				$('#formularioAtencionesNotaOperatoria #fecha_consulta').val(datos[21]);	
				$('#formularioAtencionesNotaOperatoria #fecha_consulta').attr("readonly", true);					
			}

			$('#formularioAtencionesNotaOperatoria #pro').val('Edición');				
			$('#formularioAtencionesNotaOperatoria #nota_peso_actual').val(datos[0]);	
			$('#formularioAtencionesNotaOperatoria #nota_peso_actual_kg').val(datos[1]);
			$('#formularioAtencionesNotaOperatoria #nota_peso_perdido').val(datos[2]);	
			$('#formularioAtencionesNotaOperatoria #nota_imc_actual').val(datos[3]);
			$('#formularioAtencionesNotaOperatoria #nota_tecnica').val(datos[4]);
			$('#formularioAtencionesNotaOperatoria #nota_cirujano').val(datos[5]);	
			$('#formularioAtencionesNotaOperatoria #nota_asistente').val(datos[6]);
			$('#formularioAtencionesNotaOperatoria #nota_camara').val(datos[7]);	
			$('#formularioAtencionesNotaOperatoria #nota_anestesia').val(datos[8]);
			$('#formularioAtencionesNotaOperatoria #nota_anestesiologo').val(datos[9]);	
			
			$('#formularioAtencionesNotaOperatoria #nota_otros').val(datos[10]);	
			$('#formularioAtencionesNotaOperatoria #nota_hallazgos_operativos').val(datos[11]);	
			$('#formularioAtencionesNotaOperatoria #nota_descripcion_operatoria').val(datos[12]);
			$('#formularioAtencionesNotaOperatoria #nota_indicaciones').val(datos[13]);	
			$('#formularioAtencionesNotaOperatoria #nota_recomendaciones').val(datos[14]);		
					

			if(datos[15] == 1){
				$('#formularioAtencionesNotaOperatoria #nota_prueba_metileno_activo').prop('checked', true);
				$('#formularioAtencionesNotaOperatoria #label_nota_prueba_metileno_activo').html("Sí");				
			}else{
				$('#formularioAtencionesNotaOperatoria #nutricion_activo').prop('checked', false);
				$('#formularioAtencionesNotaOperatoria #label_nota_prueba_metileno_activo').html("No");	
			}	
			
			if(datos[16] == 1){
				$('#formularioAtencionesNotaOperatoria #nota_dreno_blake_activo').prop('checked', true);
				$('#formularioAtencionesNotaOperatoria #label_nota_dreno_blake_activo').html("Sí");				
			}else{
				$('#formularioAtencionesNotaOperatoria #nota_dreno_blake_activo').prop('checked', false);
				$('#formularioAtencionesNotaOperatoria #label_nota_dreno_blake_activo').html("No");	
			}				

			if(datos[17] == 1){
				$('#formularioAtencionesNotaOperatoria #nota_extraccion_activo').prop('checked', true);
				$('#formularioAtencionesNotaOperatoria #label_nota_extraccion_activo').html("Sí");				
			}else{
				$('#formularioAtencionesNotaOperatoria #nota_extraccion_activo').prop('checked', false);
				$('#formularioAtencionesNotaOperatoria #label_nota_extraccion_activo').html("No");	
			}	
			
			if(datos[18] == 1){
				$('#formularioAtencionesNotaOperatoria #nota_evacuo_activo').prop('checked', true);
				$('#formularioAtencionesNotaOperatoria #label_nota_evacuo_activo').html("Sí");				
			}else{
				$('#formularioAtencionesNotaOperatoria #nota_evacuo_activo').prop('checked', false);
				$('#formularioAtencionesNotaOperatoria #label_nota_evacuo_activo').html("No");	
			}	
			
			if(datos[19] == 1){
				$('#formularioAtencionesNotaOperatoria #nota_cierro_piel_activo').prop('checked', true);
				$('#formularioAtencionesNotaOperatoria #label_nota_cierro_piel_activo').html("Sí");				
			}else{
				$('#formularioAtencionesNotaOperatoria #nota_cierro_piel_activo').prop('checked', false);
				$('#formularioAtencionesNotaOperatoria #label_nota_cierro_piel_activo').html("No");	
			}				

			$('#formularioAtencionesNotaOperatoria #nota_comentarios').val(datos[20]);	
			$('#formularioAtencionesNotaOperatoria #servicio_notaOperatoria_id').val(datos[22]);			
			
			caracteresResultadosNotaOperatoriaTecnica();
			caracteresResultadosNotaOperatoriaOtros();
			caracteresResultadosNotaOperatoriaHallazgosOperativos();
			caracteresResultadosNotaOperatoriaDescripcionOperatoria();
			caracteresResultadosNotaOperatoriaIndicaciones();
			caracteresResultadosNotaOperatoriaRecomendaciones();
			caracteresResultadosNotaOperatoriaComentarios();
		}
	});
}

function getFechaCita(agenda_id){
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

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 $('#main_facturacion').show();
	 $('#main_atencion').hide();
});

//INICIO DATOS DEL PACIENTE
//INICIO BUSQUEDA PROFESION
function getResponsableAtencion(){
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

function getSexoAtencion(){
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

function getDepartamentosAtencion(){
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

function getMunicipioAtencion(){
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

function getMunicipioAtencionEditar(departamento_id, municipio_id){
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

function getProfesionAtencionCirugia(){
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

function getPaisAtencion(){
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
		getMunicipioAtencion();
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
		$('#formulario_pacientes_atenciones #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 $('#main_facturacion').show();
	 $('#main_atencion').hide();
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
	$('#formulario_pacientes_atenciones').attr({ 'data-form': 'update' });
	$('#formulario_pacientes_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarPacientes.php' });
	$("#formulario_pacientes_atenciones").submit();
});


$('#ediPacientesNutricion').on('click', function(e){
	e.preventDefault();
	$('#formulario_pacientes_atenciones').attr({ 'data-form': 'update' });
	$('#formulario_pacientes_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/editarPacientes.php' });
	$("#formulario_pacientes_atenciones").submit();
});

function getProfesionAtencionCirugiaPacientes(){
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
//FIN BUSQUEDA PROFESION
//INICIO DATOS DEL PACIENTE

//GUARDA REGISTROS
/*$('#reg_atencion').on('click', function(e){
	e.preventDefault();	
	$('#formulario_atenciones').attr({ 'data-form': 'save' }); 
	$('#formulario_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarExpedienteClinico.php' });
	$("#formulario_atenciones").submit();
});*/

/*$('#reg_pre').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesPreoperatorio').attr({ 'data-form': 'save' }); 
	$('#formularioAtencionesPreoperatorio').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarPreOperacion.php' });
	$("#formularioAtencionesPreoperatorio").submit();
});*/

$('#reg_atencion').on('click', (e) => {
    e.preventDefault();

    // Obtener los valores de los campos
    let servicio_id = $('#atenciones_servicio_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera	
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    // Si todas las validaciones pasan, enviar el formulario por AJAX
    let url = '<?php echo SERVERURL; ?>php/pacientes/agregarExpedienteClinico.php';
    let formData = new FormData($('#formulario_atenciones')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false, // Evitar que jQuery procese los datos
        contentType: false, // Evitar que jQuery establezca el tipo de contenido
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#edi_atencion').on('click', (e) => {
    e.preventDefault();

    // Obtener los valores de los campos
    let servicio_id = $('#atenciones_servicio_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    // Si todas las validaciones pasan, enviar el formulario por AJAX
    let url = '<?php echo SERVERURL; ?>php/pacientes/modificarExpedienteClinico.php';
    let formData = new FormData($('#formulario_atenciones')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false, // Evitar que jQuery procese los datos
        contentType: false, // Evitar que jQuery establezca el tipo de contenido
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#reg_pre').on('click', (e) => {
    e.preventDefault();

    // Obtener los valores de los campos
    let servicio_id = $('#servicio_preoperatorio_id').val();
    let pre_fecha_cirugia = $('#pre_fecha_cirugia').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    // Validar que pre_fecha_cirugia no esté vacío
    if (!pre_fecha_cirugia) {
        swal({
            title: 'Error',
            text: 'Por favor, ingresa la fecha de la cirugía.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si pre_fecha_cirugia está vacío
    }

    // Si todas las validaciones pasan, enviar el formulario por AJAX
    let url = '<?php echo SERVERURL; ?>php/pacientes/agregarPreOperacion.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: $('#formularioAtencionesPreoperatorio').serialize(),
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});


$('#edi_pre').on('click', (e) => {
    e.preventDefault();

    // Obtener los valores de los campos
    let servicio_id = $('#servicio_preoperatorio_id').val();
    let pre_fecha_cirugia = $('#pre_fecha_cirugia').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            type: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    // Validar que pre_fecha_cirugia no esté vacío
    if (!pre_fecha_cirugia) {
        swal({
            title: 'Error',
            text: 'Por favor, ingresa la fecha de la cirugía.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si pre_fecha_cirugia está vacío
    }	
    
    let url = '<?php echo SERVERURL; ?>php/pacientes/modificarPreOperacion.php';
    let formData = new FormData($('#formularioAtencionesPreoperatorio')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#reg_nota').on('click', (e) => {
    e.preventDefault();
    
    // Obtener los valores de los campos
    let servicio_id = $('#servicio_notaOperatoria_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    let url = '<?php echo SERVERURL; ?>php/pacientes/agregarNotaOperatoria.php';
    let formData = new FormData($('#formularioAtencionesNotaOperatoria')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#edi_nota').on('click', (e) => {
    e.preventDefault();
    
    // Obtener los valores de los campos
    let servicio_id = $('#servicio_notaOperatoria_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    let url = '<?php echo SERVERURL; ?>php/pacientes/modificarNotaOperatoria.php';
    let formData = new FormData($('#formularioAtencionesNotaOperatoria')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#reg_post').on('click', (e) => {
    e.preventDefault();
    
	let servicio_id = $('#servicio_PostOperatorio_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    let url = '<?php echo SERVERURL; ?>php/pacientes/agregarPostOperatorio.php';
    let formData = new FormData($('#formularioAtencionesPostOperatoria')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

$('#edi_nota').on('click', (e) => {
    e.preventDefault();
    
	let servicio_id = $('#buscar_servicios_notaOperatoria_id').val();

    // Validar que servicio_id no esté vacío
    if (!servicio_id) {
        swal({
            title: 'Error',
            text: 'Por favor, selecciona un servicio.',
            icon: 'error',
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
        });
        return; // Detener el proceso si servicio_id está vacío
    }

    let url = '<?php echo SERVERURL; ?>php/pacientes/modificarNotaOperatoria.php';
    let formData = new FormData($('#formularioAtencionesNotaOperatoria')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: (respuesta) => {
            respuesta = JSON.parse(respuesta);

            swal({
                title: respuesta.title, 
                text: respuesta.message,
                icon: respuesta.type, 
				closeOnEsc: false, // Desactiva el cierre con la tecla Esc
				closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
            });
        }
    });
});

/*$('#reg_nota').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesNotaOperatoria').attr({ 'data-form': 'save' }); 
	$('#formularioAtencionesNotaOperatoria').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarNotaOperatoria.php' });
	$("#formularioAtencionesNotaOperatoria").submit();
});*/

/*$('#reg_post').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesPostOperatoria').attr({ 'data-form': 'save' }); 
	$('#formularioAtencionesPostOperatoria').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarPostOperatorio.php' });
	$("#formularioAtencionesPostOperatoria").submit();
});*/

//EDITAR REGISTROS
/*$('#edi_atencion').on('click', function(e){
	e.preventDefault();	
	$('#formulario_atenciones').attr({ 'data-form': 'update' }); 
	$('#formulario_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/modificarExpedienteClinico.php' });
	$("#formulario_atenciones").submit();
});*/

/*$('#edi_pre').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesPreoperatorio').attr({ 'data-form': 'update' }); 
	$('#formularioAtencionesPreoperatorio').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/.php' });
	$("#formularioAtencionesPreoperatorio").submit();
});*/

/*
$('#edi_nota').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesNotaOperatoria').attr({ 'data-form': 'update' }); 
	$('#formularioAtencionesNotaOperatoria').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/modificarNotaOperatoria.php' });
	$("#formularioAtencionesNotaOperatoria").submit();
});*/

$('#edi_post').on('click', function(e){
	e.preventDefault();	
	$('#formularioAtencionesPostOperatoria').attr({ 'data-form': 'update' }); 
	$('#formularioAtencionesPostOperatoria').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/modificarPostOperatorio.php' });
	$("#formularioAtencionesPostOperatoria").submit();pacientes
});

$('#formulario_atenciones #btn_actualizar').on('click', function(e){
	e.preventDefault();	
	mostrarArchivos($('#formulario_atenciones #pacientes_id').val());	
});

$('#formularioAtencionesNotaOperatoria #btn_actualizar').on('click', function(e){
	e.preventDefault();	
	mostrarArchivosNotaOperatoria(($('#formularioAtencionesNotaOperatoria #pacientes_id').val()));	
});
//FINALIZAR ATENCION
$('#end_atencion').on('click', function(e){
	e.preventDefault();	
	var nombre_usuario = consultarNombre($('#formulario_atenciones #pacientes_id').val());
	var expediente_usuario = consultarExpediente($('#formulario_atenciones #pacientes_id').val());
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
		marcarAtencionCirugia($('#formulario_atenciones #agenda_id').val(), value);
	});
});

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
			//INICIO EXPEDIENTE CLINICO
			$('#formulario_atenciones #inicio_obesidad').val(datos[14]);	
			$('#formulario_atenciones #habito_alimenticio').val(datos[15]);	
			$('#formulario_atenciones #tipo_obesidad').val(datos[16]);	
			$('#formulario_atenciones #intentos_perdida_peso').val(datos[17]);	
			$('#formulario_atenciones #peso_maximo_alcanzado').val(datos[18]);
			$('#formulario_atenciones #peso_maximo_alcanzado_kg').val(datos[59]);		
			$('#formulario_atenciones #sedentarismo').val(datos[19]);			
			
			if (datos[20] == 1){
				$('#formulario_atenciones #ejercicio_activo').prop('checked', true);
				$('#formulario_atenciones #label_ejercicio_activo').html("Sí");
			}else{
				$('#formulario_atenciones #ejercicio_activo').prop('checked', false);
				$('#formulario_atenciones #label_ejercicio_activo').html("No");
			}			

			$('#formulario_atenciones #ejercicio_respuesta').val(datos[21]);

			if (datos[22] == 1){
				$('#formulario_atenciones #alergias_activo').prop('checked', true);
				$('#formulario_atenciones #label_alergias_activo').html("Sí");
				$('#formulario_atenciones #alergias_respuesta').show();
			}else{
				$('#formulario_atenciones #alergias_activo').prop('checked', false);
				$('#formulario_atenciones #label_alergias_activo').html("No");
				$('#formulario_atenciones #alergias_respuesta').hide();
			}	
			
			$('#formulario_atenciones #alergias_respuesta').val(datos[23]);

			if (datos[24] == 1){
				$('#formulario_atenciones #erge_activo').prop('checked', true);
				$('#formulario_atenciones #label_erge_activo').html("Sí");
				$('#formulario_atenciones #erge_respuesta').show();
			}else{
				$('#formulario_atenciones #erge_activo').prop('checked', false);
				$('#formulario_atenciones #label_erge_activo').html("No");
				$('#formulario_atenciones #erge_respuesta').hide();
			}	

			$('#formulario_atenciones #erge_respuesta').val(datos[23]);

			if (datos[25] == 1){
				$('#formulario_atenciones #hta_activo').prop('checked', true);
				$('#formulario_atenciones #label_hta_activo').html("Sí");
				$('#formulario_atenciones #hta_respuesta').show();
			}else{
				$('#formulario_atenciones #hta_activo').prop('checked', false);
				$('#formulario_atenciones #label_hta_activo').html("No");
				$('#formulario_atenciones #hta_respuesta').hide();
			}	
			
			$('#formulario_atenciones #hta_respuesta').val(datos[68]);

			if (datos[26] == 1){
				$('#formulario_atenciones #dislipidemia_activo').prop('checked', true);
				$('#formulario_atenciones #label_dislipidemia_activo').html("Sí");
				$('#formulario_atenciones #dislipidemia_respuesta').show();
			}else{
				$('#formulario_atenciones #dislipidemia_activo').prop('checked', false);
				$('#formulario_atenciones #label_dislipidemia_activo').html("No");
				$('#formulario_atenciones #dislipidemia_respuesta').hide();
			}			
			
			$('#formulario_atenciones #dislipidemia_respuesta').val(datos[69]);

			if (datos[27] == 1){
				$('#formulario_atenciones #higado_graso_activo').prop('checked', true);
				$('#formulario_atenciones #label_higado_graso_activo').html("Sí");
				$('#formulario_atenciones #higado_graso_respuesta').show();
			}else{
				$('#formulario_atenciones #higado_graso_activo').prop('checked', false);
				$('#formulario_atenciones #label_higado_graso_activo').html("No");
				$('#formulario_atenciones #higado_graso_respuesta').hide();
			}	
			
			$('#formulario_atenciones #higado_graso_respuesta').val(datos[70]);

			if (datos[28] == 1){
				$('#formulario_atenciones #saos_activo').prop('checked', true);
				$('#formulario_atenciones #label_saos_activo').html("Sí");
				$('#formulario_atenciones #saos_respuesta').show();
			}else{
				$('#formulario_atenciones #saos_activo').prop('checked', false);
				$('#formulario_atenciones #label_saos_activo').html("No");
				$('#formulario_atenciones #saos_respuesta').hide();
			}
			
			$('#formulario_atenciones #saos_respuesta').val(datos[80]);

			if (datos[29] == 1){
				$('#formulario_atenciones #hipotiroidismo_activo').prop('checked', true);
				$('#formulario_atenciones #label_hipotiroidismo_activo').html("Sí");
				$('#formulario_atenciones #hipotiroidismo_respuesta').show();
			}else{
				$('#formulario_atenciones #hipotiroidismo_activo').prop('checked', false);
				$('#formulario_atenciones #label_hipotiroidismo_activo').html("No");
				$('#formulario_atenciones #hipotiroidismo_respuesta').hide();
			}

			$('#formulario_atenciones #hipotiroidismo_respuesta').val(datos[71]);

			if (datos[30] == 1){
				$('#formulario_atenciones #articulares_activo').prop('checked', true);
				$('#formulario_atenciones #articulares_activo').html("Sí");
				$('#formulario_atenciones #articulares_respuesta').show();
			}else{
				$('#formulario_atenciones #expediente_articulares_activo').prop('checked', false);
				$('#formulario_atenciones #label_articulares_activo').html("No");
				$('#formulario_atenciones #articulares_respuesta').hide();
			}	
			
			$('#formulario_atenciones #articulares_respuesta').val(datos[72]);

			if (datos[31] == 1){
				$('#formulario_atenciones #ovarios_poliquisticos_activo').prop('checked', true);
				$('#formulario_atenciones #label_ovarios_poliquisticos_activo').html("Sí");
				$('#formulario_atenciones #ovarios_respuesta').show();
			}else{
				$('#formulario_atenciones #ovarios_poliquisticos_activo').prop('checked', false);
				$('#formulario_atenciones #label_ovarios_poliquisticos_activo').html("No");
				$('#formulario_atenciones #ovarios_respuesta').hide();
			}		
			
			$('#formulario_atenciones #ovarios_respuesta').val(datos[73]);

			if (datos[32] == 1){
				$('#formulario_atenciones #varices_activo').prop('checked', true);
				$('#formulario_atenciones #label_varices_activo').html("Sí");
				$('#formulario_atenciones #varices_respuesta').show();
			}else{
				$('#formulario_atenciones #varices_activo').prop('checked', false);
				$('#formulario_atenciones #label_varices_activo').html("No");
				$('#formulario_atenciones #varices_respuesta').hide();
			}					
			
			$('#formulario_atenciones #varices_respuesta').val(datos[74]);

			if (datos[33] == 1){
				$('#formulario_atenciones #tabaquismo_activo').prop('checked', true);
				$('#formulario_atenciones #label_tabaquismo_activo').html("Sí");
				$('#formulario_atenciones #tabaquismo_respuesta').show();
			}else{
				$('#formulario_atenciones #tabaquismo_activo').prop('checked', false);
				$('#formulario_atenciones #label_tabaquismo_activo').html("No");
				$('#formulario_atenciones #tabaquismo_respuesta').hide();
			}		
			
			$('#formulario_atenciones #tabaquismo_respuesta').val(datos[34]);

			if (datos[35] == 1){
				$('#formulario_atenciones #alcohol_activo').prop('checked', true);
				$('#formulario_atenciones #label_alcohol_activo').html("Sí");
				$('#formulario_atenciones #alcohol_respuesta').show();
			}else{
				$('#formulario_atenciones #alcohol_activo').prop('checked', false);
				$('#formulario_atenciones #label_alcohol_activo').html("No");
				$('#formulario_atenciones #alcohol_respuesta').hide();
			}	
			
			$('#formulario_atenciones #alcohol_respuesta').val(datos[36]);

			if (datos[37] == 1){
				$('#formulario_atenciones #drogas_activo').prop('checked', true);
				$('#formulario_atenciones #label_drogas_activo').html("Sí");
				$('#formulario_atenciones #drogas_respuesta').show();
			}else{
				$('#formulario_atenciones #drogas_activo').prop('checked', false);
				$('#formulario_atenciones #label_drogas_activo').html("No");
				$('#formulario_atenciones #drogas_respuesta').hide();
			}	

			$('#formulario_atenciones #drogas_respuesta').val(datos[38]);

			if (datos[39] == 1){
				$('#formulario_atenciones #antecedentes_fami_diabetes_activo').prop('checked', true);
				$('#formulario_atenciones #label_antecedentes_fami_diabetes_activo').html("Sí");
				$('#formulario_atenciones #ant_fam_respuesta').show();
			}else{
				$('#formulario_atenciones #antecedentes_fami_diabetes_activo').prop('checked', false);
				$('#formulario_atenciones #label_antecedentes_fami_diabetes_activo').html("No");
				$('#formulario_atenciones #ant_fam_respuesta').hide();
			}	

			$('#formulario_atenciones #ant_fam_respuesta').val(datos[75]);

			if (datos[40] == 1){
				$('#formulario_atenciones #antecedentes_fami_Obesidad_activo').prop('checked', true);
				$('#formulario_atenciones #label_antecedentes_fami_Obesidad_activo').html("Sí");
				$('#formulario_atenciones #ant_fam_obecidad_respuesta').show();
			}else{
				$('#formulario_atenciones #antecedentes_fami_Obesidad_activo').prop('checked', false);
				$('#formulario_atenciones #label_antecedentes_fami_Obesidad_activo').html("No");
				$('#formulario_atenciones #ant_fam_obecidad_respuesta').hide();
			}	
			
			$('#formulario_atenciones #ant_fam_obecidad_respuesta').val(datos[76]);

			if (datos[41] == 1){
				$('#formulario_atenciones #antecedentes_fami_cancer_gastrico_activo').prop('checked', true);
				$('#formulario_atenciones #label_antecedentes_fami_cancer_gastrico_activo').html("Sí");
				$('#formulario_atenciones #ant_fam_gastrico_respuesta').show();
			}else{
				$('#formulario_atenciones #antecedentes_fami_cancer_gastrico_activo').prop('checked', false);
				$('#formulario_atenciones #label_antecedentes_fami_cancer_gastrico_activo').html("No");
				$('#formulario_atenciones #ant_fam_gastrico_respuesta').hide();
			}	
			
			$('#formulario_atenciones #ant_fam_gastrico_respuesta').val(datos[77]);

			if (datos[42] == 1){
				$('#formulario_atenciones #antecedentes_fami_psiquiatricas_activo').prop('checked', true);
				$('#formulario_atenciones #label_antecedentes_fami_psiquiatricas_activo').html("Sí");
				$('#formulario_atenciones #enf_psiquiatricas_respuesta').show();
			}else{
				$('#formulario_atenciones #antecedentes_fami_psiquiatricas_activo').prop('checked', false);
				$('#formulario_atenciones #label_antecedentes_fami_psiquiatricas_activo').html("No");
				$('#formulario_atenciones #enf_psiquiatricas_respuesta').hide();
			}	
			
			$('#formulario_atenciones #enf_psiquiatricas_respuesta').val(datos[78]);

			if (datos[43] == 1){
				$('#formulario_atenciones #antecedentes_dm_activo').prop('checked', true);
				$('#formulario_atenciones #label_antecedentes_dm_activo').html("Sí");
				$('#formulario_atenciones #dm_respuesta').show();
			}else{
				$('#formulario_atenciones #antecedentes_dm_activo').prop('checked', false);
				$('#formulario_atenciones #label_antecedentes_dm_activo').html("No");
				$('#formulario_atenciones #dm_respuesta').hide();
			}				

			$('#formulario_atenciones #dm_respuesta').val(datos[79]);	

			$('#formulario_atenciones #otros').val(datos[44]);

			$('#formulario_atenciones #cirugia_abdominal_expediente').val(datos[45]);	
			$('#formulario_atenciones #talla').val(datos[46]);	
			$('#formulario_atenciones #peso').val(datos[48]);	
			$('#formulario_atenciones #peso_kg').val(datos[61]);
			$('#formulario_atenciones #imc').val(datos[50]);
			$('#formulario_buscarAtencion #imc').val(datos[50]);
			$('#formulario_atenciones #peso_ideal').val(datos[47]);	
			$('#formulario_atenciones #peso_ideal_kg').val(datos[60]);	
			$('#formulario_atenciones #exceso_peso').val(datos[49]);	
			$('#formulario_atenciones #exceso_peso_kg').val(datos[62]);
			$('#formulario_atenciones #diagnostico').val(datos[51]);			
			$('#formulario_atenciones #estudios_imagenes').val(datos[52]);	
			$('#formulario_atenciones #referencia_a').val(datos[53]);	
			$('#formulario_atenciones #recomendaciones_quirurgicas').val(datos[54]);	
			$('#formulario_atenciones #presupuesto').val(datos[55]);
			$('#formulario_atenciones #expe_observaciones').val(datos[66]);
			$('#formulario_atenciones #atenciones_servicio_id').val(datos[64]);

			$('#formulario_atenciones #servicio_id').val(datos[64]);
			$('#formulario_atenciones #colaborador_id').val(datos[81]);					
			$('#formulario_atenciones #agenda_id').val(datos[82]);			

			if(datos[65] == null || datos[65] == ""){
				$('#reg_atencion').show();
				$('#edi_atencion').hide();
				$('#formulario_atenciones #fechaConsultaGrupo').hide();
				$('#formulario_atenciones #fecha_consulta').attr("readonly", true);					
			}else{
				$('#reg_atencion').hide();
				$('#edi_atencion').show();
				$('#formulario_atenciones #fechaConsultaGrupo').show();
				$('#formulario_atenciones #fecha_consulta').val(datos[13]);	
				$('#formulario_atenciones #fecha_consulta').attr("readonly", true);					
			}

			//AGREGAMOS LA TALLA EN TODOS LAS PESTAÑAS
			$('#formularioAtencionesPreoperatorio #pre_talla').val(datos[46]);
			$('#formularioAtencionesNotaOperatoria #nota_talla').val(datos[46]);
			$('#formularioAtencionesPostOperatoria #post_talla').val(datos[46]);

			caracteresCirugiaAbdominalExpedienteClinico();
			caracteresDiagnosticoExpedienteClinico();					
			caracteresExpObservaciones();			
			//FIN EXPEDIENTE CLINICO

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

				caracteresResultadosExamenesPre();
				caracteresRecomendaciones();
				
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

				caracteresResultadosNotaOperatoriaComentarios();
				caracteresResultadosNotaOperatoriaDescripcionOperatoria();
				caracteresResultadosNotaOperatoriaHallazgosOperativos();
				caracteresResultadosNotaOperatoriaIndicaciones();
				caracteresResultadosNotaOperatoriaOtros();
				caracteresResultadosNotaOperatoriaRecomendaciones();
				caracteresResultadosNotaOperatoriaTecnica();	
				
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
				caracteresResultadosPostOperatoriaOtros();
				caracteresResultadosPostOperatoriaMejoria();
				caracteresResultadosPostOperatoriaEstadoActual();
				caracteresResultadosPostOperatoriaMedicamentos();
				caracteresResultadosPostOperatoriaHallazgos();
				caracteresResultadosPostOperatoriaComentarios();
				caracteresResultadosPostOperatoriaPlan();	
				
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
			htmlRows += '<input type="date" required id="expediente_pre_fecha_cirugia_'+count+'" name="expediente_pre_fecha_cirugia[]" class="form-control" readonly value="<?php echo date('Y-m-d'); ?>" />';	
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
	$('#main_seguimiento_post_operatorio_historico').append(htmlRows);
	$('#main_seguimiento_post_operatorio_cirugia').append(htmlRows);		
}

function getPacientes_idExpedienteClinico(clinico_id){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getAtencionExpedienteClinico.php';
	var pacientes_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		data:'clinico_id='+clinico_id,
		success:function(data){	
			pacientes_id = data;			  		  		  			  
		}
	});
	return pacientes_id;
	
}

function getPacientes_idPreoperatorio(preoperacion_id){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getAtencionPreOpertorio.php';
	var pacientes_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		data:'preoperacion_id='+preoperacion_id,
		success:function(data){	
			pacientes_id = data;			  		  		  			  
		}
	});
	return pacientes_id;
	
}

function getPacientes_idNotaOperatoria(notaoperacion_id){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getAtencionNotaOperatoria.php';
	var pacientes_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		data:'notaoperacion_id='+notaoperacion_id,
		success:function(data){	
			pacientes_id = data;			  		  		  			  
		}
	});
	return pacientes_id;
	
}

function getPacientes_idPostOPeratorio(postoperacion_id){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getAtencionPostOperatorio.php';
	var pacientes_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		data:'postoperacion_id='+postoperacion_id,
		success:function(data){	
			pacientes_id = data;			  		  		  			  
		}
	});
	return pacientes_id;
	
}

function getPacientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getPacientes.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_atenciones #paciente_consulta').html("");
			$('#formulario_atenciones #paciente_consulta').html(data);
			
		    $('#formularioAtencionesPreoperatorio #pre_paciente_consulta').html("");
			$('#formularioAtencionesPreoperatorio #pre_paciente_consulta').html(data);

		    $('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').html("");
			$('#formularioAtencionesNotaOperatoria #nota_paciente_consulta').html(data);

		    $('#formularioAtencionesPostOperatoria #post_paciente_consulta').html("");
			$('#formularioAtencionesPostOperatoria #post_paciente_consulta').html(data);			
        }
     });	
}

$('#formulario_atenciones #report_prieravez').on('click', function(e){
    e.preventDefault();
    reportePDFPrimeraVez($('#formulario_atenciones #pacientes_id').val());
});

function reportePDFPrimeraVez(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/generarReporteAtencion.php?pacientes_id='+pacientes_id;
    window.open(url);
}

$('#formularioAtencionesPreoperatorio #report_preoperatorio').on('click', function(e){
    e.preventDefault();
    reportePDFPreoPeratorio($('#formularioAtencionesPreoperatorio #pacientes_id').val());
});

function reportePDFPreoPeratorio(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/generarReportePreOperatorio.php?pacientes_id='+pacientes_id;
    window.open(url);
}

$('#formularioAtencionesNotaOperatoria #report_notaoperatoria').on('click', function(e){
    e.preventDefault();
    reportePDFNotaOperatoria($('#formularioAtencionesNotaOperatoria #pacientes_id').val());
});

function reportePDFNotaOperatoria(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/generarReporteNotaOperatoria.php?pacientes_id='+pacientes_id;
    window.open(url);
}

$('#formularioAtencionesPostOperatoria #report_postoperatorio').on('click', function(e){
    e.preventDefault();
    reportePDFPostOperatorio($('#formularioAtencionesPostOperatoria #pacientes_id').val());
});

function reportePDFPostOperatorio(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/generarReportePostOperatorio.php?pacientes_id='+pacientes_id;
    window.open(url);
}

$('#formulario_buscarAtencion #report_historiaclinica').on('click', function(e){
    e.preventDefault();
    reportePDFHistoriaClinica($('#formulario_atenciones #pacientes_id').val());
});

function reportePDFHistoriaClinica(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/generarReporteHistoriaClinica.php?pacientes_id='+pacientes_id;
    window.open(url);
}
//FIN ATENCIONES MEDICAS CIRUGIA BARIATRICA

//INICIO NUTRICION
$(document).ready(function() {
	getConsultorioNutricion();
	$('.footer').show();
	$('.footer1').hide();
});	

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

//INICIO FUNCION QUITAR ATENCION
function CulminarAtencionPacienteNutricion(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){		
		if(getAtencionPacienteNutricion(agenda_id) == 0){ 			  
			  var nombre_usuario = consultarNombre(pacientes_id);
			  var expediente_usuario = consultarExpediente(pacientes_id);
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
				marcarAtencionNutricion(agenda_id, value);
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
            $('#formulario_facturacion #fecha').val(getFechaActual());
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
					$('#formulario_pacientes_atenciones #fecha_cita').val(getFechaCita(agenda_id));
					$('#formulario_seguimiento #fecha_cita').val(getFechaCita(agenda_id));										
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
					getMunicipioAtencionEditar(datos[10], datos[11]);
					$('#formulario_pacientes_atenciones #pais_id').val(datos[12]);
					$('#formulario_pacientes_atenciones #responsable').val(datos[13]);
					$('#formulario_pacientes_atenciones #responsable_id').val(datos[14]);
					$('#formulario_pacientes_atenciones #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes_atenciones #identidad').val(datos[16]);					
					$('#perfil_nombre_nutricion').html(datos[17]);
					$('#formulario_pacientes_atenciones #referido').val(datos[18]);

					$('#formulario_antecedentes #edad_consulta').val(datos[6]);
					$('#formulario_antecedentes #edad_consulta').attr('readonly', true);
					$('#formulario_antecedentes #atenciones_servicio_id').val(datos[19]);
					$('#formulario_pacientes_atenciones #edad_paciente').val(datos[20]);

					//DATOS DE LA HISTORIA CLINICA DEL PACIENTE
					$('#formulario_antecedentes #motivo_consulta').val(datos[19]);

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
					paginationSeguimiento(1, pacientes_id, getColaborador_idNutricion());
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

function perfilNombreNutricion(nombre){
	$('#perfil_nombre').html(nombre);
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

function paginationSeguimiento1(partida, pacientes_id,){
	var url = '<?php echo SERVERURL; ?>php/pacientes/paginar_seguimiento1.php';
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&pacientes_id='+pacientes_id,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_historia_clinica_nutricion').html(array[0]);
			$('#pagination_historia_clinica_nutricion').html(array[1]);			
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
	$('#formulario_antecedentes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarAtencionNutricion.php' });
	$("#formulario_antecedentes").submit();
});

$('#ediConsulta').on('click', function(e){
	e.preventDefault();
	$('#formulario_antecedentes').attr({ 'data-form': 'update' }); 
	$('#formulario_antecedentes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/modificarAtencionNutricion.php' });
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
//FIN NUTRICION


function calcularIMC(){
	let peso = $('#formulario_antecedentes #peso').val();
	let estatura = $('#formulario_antecedentes #estatura').val();
	let imc = 0;

	if(estatura != 0 || estatura != ""){
		imc = peso / estatura;
	}


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