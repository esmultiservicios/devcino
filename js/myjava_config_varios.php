<script>
$(document).ready(pagination(1));getConsulta();
 $(function(){
	  $('#form_main_varios #nuevo_registro').on('click',function(e){
		e.preventDefault();
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){
		  $('#formulario_registros')[0].reset();
     	  $('#formulario_registros #pro').val('Registro');
		  $('#formulario_registros #nombre_registro').val('');
		  $('#edi').hide();
		  $('#reg').show();
   	      $('#formulario_registros #mensaje').html('');				
		  $('#formulario_registros #mensaje').removeClass('error');		  
		  $('#formulario_registros #mensaje').removeClass('bien');
		  $('#formulario_registros #mensaje').removeClass('alerta');
		  $('#formulario_registros').attr({ 'data-form': 'save' }); 
		  $('#formulario_registros').attr({ 'action': '<?php echo SERVERURL; ?>php/config_varios/agregar.php' });			  
		  getConsulta();
		  $('#registrar').modal({
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
	   
                      			   
	   $('#form_main_varios #bs_regis').on('keyup',function(){
		  pagination(1);
   	      return false;
   });	
});

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#registrar").on('shown.bs.modal', function(){
        $(this).find('#formulario_registros #nombre_registro').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

function getConsulta(){
    var url = '<?php echo SERVERURL; ?>php/config_varios/getConsulta.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){		
		    $('#form_main_varios #consulta').html("");
			$('#form_main_varios #consulta').html(data);	

		    $('#formulario_registros #consulta_registro').html("");
			$('#formulario_registros #consulta_registro').html(data);				
		}			
     });		
}

function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/config_varios/paginar.php';
	var dato = $('#form_main_varios #bs_regis').val();
	var entidad;
	
	if( $('#form_main_varios #consulta').val() == "" || $('#form_main_varios #consulta').val() == null){
		entidad = "banco";
	}else{
		entidad = $('#form_main_varios #consulta').val();
	}
	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&entidad='+entidad+'&dato='+dato,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}

function agregar(){
	var url = '<?php echo SERVERURL; ?>php/config_varios/agregar.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_registros').serialize(),
		success: function(registro){
			if (registro == 1){
				$('#formulario_registros')[0].reset();
				$('#formulario_registros #pro').val('Registro');
				swal({
					title: "Success", 
					text: "Registro almacenado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-close
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				$('#registrar').modal('hide');
				getConsulta();
				pagination(1);
			   return false;
			}else if (registro == 2){
			   $('#formulario_registros #mensaje').html('');				
				swal({
					title: "Error", 
					text: "Error al guardar el registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});				
			}else if (registro == 3){
			   $('#formulario_registros #mensaje').html('');				
				swal({
					title: "Error", 
					text: "Este registro ya existe",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});			   
			}else{
			   $('#formulario_registros #mensaje').html('');				
				swal({
					title: "Error", 
					text: "Error al procesar su solicitud",
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

function modificar(){
	var url = '<?php echo SERVERURL; ?>php/config_varios/modificar.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_registros').serialize(),
		success: function(registro){
			if (registro == 1){
				$('#formulario_registros #pro').val('Edición');
				swal({
					title: "Success", 
					text: "Registro modificado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-close
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});	
				$('#registrar').modal('hide');
				pagination(1);
				return false;
			}else if (registro == 2){
			   $('#formulario_registros #mensaje').html('');				
				swal({
					title: "Error", 
					text: "Error al modificar el registro",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});				
			}else{
			   $('#formulario_registros #mensaje').html('');				
				swal({
					title: "Error", 
					text: "Error al procesar su solicitud",
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

function editarRegistro(id,entidad){
	$('#formulario_registros')[0].reset();		
	var url = '<?php echo SERVERURL; ?>php/config_varios/editar.php';
		
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&entidad='+entidad,
		success: function(valores){
				var datos = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#formulario_registros #pro').val('Edicion');
				$('#formulario_registros #id_registro').val(id);
                $('#formulario_registros #consulta_registro').val(datos[0]);				
				$('#formulario_registros #nombre_registro').val(datos[1]);				
				
				$('#formulario_registros').attr({ 'data-form': 'update' }); 
				$('#formulario_registros').attr({ 'action': '<?php echo SERVERURL; ?>php/config_varios/modificar.php' });
		  
				$('#registrar').modal({
					show:true,
					keyboard: false,
					backdrop:'static'
				});
			return false;
		}
	});
	return false;	
}

function modal_eliminar(id,entidad){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4){	
		swal({
			title: "¿Esta seguro?",
			text: "¿Desea eliminar el usuario " + consultarNombre(id) + "",
			icon: "warning",
			buttons: {
				cancel: {
					text: "Cancelar",
					visible: true
				},
				confirm: {
					text: "¡Sí, Eliminar el usuario!",
				}
			},
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		}).then((willConfirm) => {
			if (willConfirm === true) {
				eliminarRegistro(id, entidad);
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

function eliminarRegistro(id, entidad){
	var url = '<?php echo SERVERURL; ?>php/config_varios/eliminar.php';
	
	$.ajax({
		type:'POST',
		url:url,
		data:'entidad='+entidad+'&id='+id,
		success: function(registro){
			if (registro == 1){
				swal({
					title: "Success", 
					text: "Registro almacenado correctamente",
					icon: "success",
					timer: 3000, //timeOut for auto-close
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera					
				});			       				
			   pagination(1);
			   return false;
			}else if (registro == 2){
				swal({
					title: "Error", 
					text: "Error al intentar eliminar el registro, por favor intente de nuevo",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
				return false;			
			}else if (registro == 3){
				swal({
					title: "Error", 
					text: "Error al intentar eliminar el registro, cuenta con información almacenada",
					icon: "error", 
					dangerMode: true,
					closeOnEsc: false, // Desactiva el cierre con la tecla Esc
					closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
				});
				return false;			
			}else{
				swal({
					title: "Error", 
					text: "Error procesar su solicitud",
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

$(document).ready(function() {
	$('#form_main_varios #consulta').on('change', function(){
          pagination(1);
    });					
});


//BOTONES DE ACCION
$('#formulario_registros #reg').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	 if ($('#formulario_registros #nombre_registro').val() != "" && $('#formulario_registros #consulta_registro').val() != ""){
		e.preventDefault();
		agregar();			   
		return false;
	 }else{
       $('#formulario_registros #pro').val('Registro');	
		swal({
			title: "Error", 
			text: "No se pueden enviar los datos, los campos estan vacíos",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});	
	   return false;	   
	 }  
});

$('#formulario_registros #edi').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	 if ($('#formulario_registros #nombre_registro').val() != "" && $('#formulario_registros #consulta_registro').val() != ""){
		e.preventDefault();
		modificar();			   
		return false;
	 }else{
		$('#formulario_registros #pro').val('Edición');		
		swal({
			title: "Error", 
			text: "No se pueden enviar los datos, los campos estan vacíos",
			icon: "error", 
			dangerMode: true,
			closeOnEsc: false, // Desactiva el cierre con la tecla Esc
			closeOnClickOutside: false // Desactiva el cierre al hacer clic fuera
		});			
		return false;	   
	 }  
});

function consultarNombre(id){	
    var url = '<?php echo SERVERURL; ?>php/config_varios/getNombre.php';
	var entidad = '';
	if($('#form_main_varios #consulta').val() == "" || $('#form_main_varios #consulta').val() == null){
		entidad = 'motivo_traslado';
	}else{
		entidad = $('#form_main_varios #consulta').val();
	}
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'entidad='+entidad+'&id='+id,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp;		
}
</script>