<script>
/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
	getColaborador();

    $("#modalEliminarSecuenciaFacturacion").on('shown.bs.modal', function(){
        $(this).find('#formularioSecuenciaFacturacion #comentario').focus();
    });
});

$(document).ready(function(){
    $("#secuenciaFacturacion").on('shown.bs.modal', function(){
        $(this).find('#formularioSecuenciaFacturacion #cai').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
/****************************************************************************************************************************************************************/
//INICIO CONTROLES DE ACCION
$(document).ready(function() {
	//LLAMADA A LAS FUNCIONES
	funciones();	
	
	//INICIO ABRIR VENTANA MODAL PARA EL REGISTRO DE DESCUENTOS
	$('#nuevo_registro').on('click',function(e){
		e.preventDefault();
		funciones();
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 5){	
		    $('#formularioSecuenciaFacturacion')[0].reset();
            limpiarSeciencia();	
            //HABILITAR CONTROLES PARA SOLO LECTURA
			$("#formularioSecuenciaFacturacion #cai").attr('disabled', false);
			$("#formularioSecuenciaFacturacion #prefijo").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #relleno").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #incremento").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #rango_inicial").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #rango_final").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #fecha_activacion").attr('readonly', false);			
			$("#formularioSecuenciaFacturacion #fecha_limite").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #siguiente").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #comentario").attr('readonly', false);
			$("#formularioSecuenciaFacturacion #secuencia_profesional").attr('disabled', false);
				
			 $('#reg').show();
			 $('#edi').hide(); 
			 $('#delete').hide(); 

			 $('#formularioSecuenciaFacturacion').attr({ 'data-form': 'save' });
			 $('#formularioSecuenciaFacturacion').attr({ 'action': '<?php echo SERVERURL;?>php/secuencia_facturacion/agregarSecuencia.php' });			 
			 
			 $('#formularioSecuenciaFacturacion #group_comentario').hide();
			 $('#secuenciaFacturacion').modal({
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
				dangerMode: true
			});		 
		}			
	});
	//FIN ABRIR VENTANA MODAL PARA EL REGISTRO DE DESCUENTOS	
    //INICIO PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
	$('#form_main_secuencia #bs_regis').on('keyup',function(){
	  pagination(1);
	}); 

	$('#form_main_secuencia #servicio').on('change',function(){
	  pagination(1);
	});
	
	$('#form_main_secuencia #estado').on('change',function(){
	  pagination(1);
	});	
	
	$('#form_main_secuencia #profesional').on('change',function(){
	  pagination(1);
	});	
	//FIN PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
});
//FIN CONTROLES DE ACCION
/****************************************************************************************************************************************************************/
/***************************************************************************************************************************************************************************/
//INICIO FUNCIONES
function eliminarRegistro(){
	var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/eliminar.php';
		
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formularioSecuenciaFacturacion').serialize(),
		success: function(registro){
			if(registro == 1){
			   $('#formularioSecuenciaFacturacion')[0].reset();  			   
				swal({
					title: "Success", 
					text: "Registro eliminado correctamente",
					icon: "success",
					timer: 3000,
				});	
				$('#secuenciaFacturacion').modal('hide');
				getEstado();
				$('#formularioSecuenciaFacturacion #pro').val('Eliminar Registro');
				pagination(1);
				return false;				
			}else if(registro == 2){
				swal({
					title: "Error", 
					text: "Error, no se puede eliminar este registro",
					icon: "error", 
					dangerMode: true
				});
				return false;				
			}else if(registro == 3){
				swal({
					title: "Error", 
					text: "Lo sentimos este registro cuenta con información almacenada, no se puede eliminar",
					icon: "error", 
					dangerMode: true
				});
				return false;				
			}else{
				swal({
					title: "Error", 
					text: "Error al procesar su solicitud, por favor intentelo de nuevo mas tarde",
					icon: "error", 
					dangerMode: true
				});
				return false;	
			}
		}
	});
	return false;
}
//FIN FUNCION QUE GUARDA LOS REGISTROS DE PACIENTES QUE NO ESTAN ALMACENADOS EN LA AGENDA

function editarRegistro(secuencia_facturacion_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 5){	
		$('#formularioSecuenciaFacturacion')[0].reset();		
		var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/editar.php';

			$.ajax({
			type:'POST',
			url:url,
			data:'secuencia_facturacion_id='+secuencia_facturacion_id,
			success: function(valores){
				var array = eval(valores);
				$('#reg').hide();
				$('#edi').show();
				$('#delete').hide(); 			 
				$('#formularioSecuenciaFacturacion #pro').val('Edición');
                $('#formularioSecuenciaFacturacion #secuencia_facturacion_id').val(secuencia_facturacion_id);	
                $('#formularioSecuenciaFacturacion #secuencia_profesional').val(array[0]);
				$('#formularioSecuenciaFacturacion #cai').val(array[1]);
                $('#formularioSecuenciaFacturacion #prefijo').val(array[2]);
				$('#formularioSecuenciaFacturacion #relleno').val(array[3]);	
                $('#formularioSecuenciaFacturacion #incremento').val(array[4]);
				$('#formularioSecuenciaFacturacion #siguiente').val(array[5]);	
                $('#formularioSecuenciaFacturacion #rango_inicial').val(array[6]);
                $('#formularioSecuenciaFacturacion #rango_final').val(array[7]);
				$('#formularioSecuenciaFacturacion #fecha_limite').val(array[8]);	
                $('#formularioSecuenciaFacturacion #estado').val(array[9]);
                $('#formularioSecuenciaFacturacion #comentario').val(array[10]);		
				$("#edi").attr('disabled', false);	

				$('#formularioSecuenciaFacturacion').attr({ 'data-form': 'save' });
			    $('#formularioSecuenciaFacturacion').attr({ 'action': '<?php echo SERVERURL;?>php/secuencia_facturacion/modificarSecuencia.php' });	

                //HABILITAR CONTROLES PARA SOLO LECTURA
				$("#formularioSecuenciaFacturacion #cai").attr('disabled', false);				
				$("#formularioSecuenciaFacturacion #prefijo").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #relleno").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #incremento").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #rango_inicial").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #rango_final").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #fecha_activacion").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #fecha_limite").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #siguiente").attr('readonly', false);
				$("#formularioSecuenciaFacturacion #comentario").attr('readonly', false);
				
				//DESHABILITAR OBJETOS
				$("#formularioSecuenciaFacturacion #secuencia_profesional").attr('disabled', true);
				$('#formularioSecuenciaFacturacion #group_comentario').hide();
							
				$('#secuenciaFacturacion').modal({
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
			dangerMode: true
		});					 
	}		
}

function modal_eliminar(secuencia_facturacion_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 4 || getUsuarioSistema() == 5){	
		$('#formularioSecuenciaFacturacion')[0].reset();		
		var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/editar.php';

			$.ajax({
			type:'POST',
			url:url,
			data:'secuencia_facturacion_id='+secuencia_facturacion_id,
			success: function(valores){
				var array = eval(valores);
				$('#delete').show();
				$('#formularioSecuenciaFacturacion #pro').val('Eliminar Registro');
				$("#formularioSecuenciaFacturacion #comentario").val("");
                $('#formularioSecuenciaFacturacion #secuencia_facturacion_id').val(secuencia_facturacion_id);
                $('#formularioSecuenciaFacturacion #cai').val(array[1]);
                $('#formularioSecuenciaFacturacion #prefijo').val(array[2]);
				$('#formularioSecuenciaFacturacion #relleno').val(array[3]);	
                $('#formularioSecuenciaFacturacion #incremento').val(array[4]);
				$('#formularioSecuenciaFacturacion #siguiente').val(array[5]);	
                $('#formularioSecuenciaFacturacion #rango_inicial').val(array[6]);
                $('#formularioSecuenciaFacturacion #rango_final').val(array[7]);
				$('#formularioSecuenciaFacturacion #fecha_limite').val(array[8]);	
                $('#formularioSecuenciaFacturacion #estado').val(array[9]);	
                $('#formularioSecuenciaFacturacion #comentario').val(array[10]);					
				$("#edi").attr('disabled', false);	

                //DESHABILITAR CONTROLES PARA SOLO LECTURA
				$("#formularioSecuenciaFacturacion #cai").attr('disabled', true);				
                $("#formularioSecuenciaFacturacion #estado").attr('disabled', true);				
				$("#formularioSecuenciaFacturacion #prefijo").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #relleno").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #siguiente").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #incremento").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #rango_inicial").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #rango_final").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #fecha_activacion").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #fecha_limite").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #comentario").attr('readonly', true);
				$("#formularioSecuenciaFacturacion #secuencia_profesional").attr('disabled', true);				
				
				$('#reg').hide();
				$('#edi').hide();
				$('#delete').show();
				$('#formularioSecuenciaFacturacion #group_comentario').show();				
				
				$('#secuenciaFacturacion').modal({
					show:true,
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
			dangerMode: true
		});				 
	}	
}

function limpiarSeciencia(){
   	$('#formularioSecuenciaFacturacion #pro').val("Registro");
}

//INICIO FUNCION PARA OBTENER LOS COLABORADORES	
function funciones(){
    pagination(1);
    getEstado();
}

//INICIO PAGINACION DE REGISTROS
function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/paginar.php';
	var dato = '';
	var profesional = '';
	
    if($('#form_main_secuencia #secuencia_profesional').val() == "" || $('#form_main_secuencia #secuencia_profesional').val() == null){
		profesional = 0;
	}else{
		profesional = $('#form_main_secuencia #secuencia_profesional').val();
	}	

	if($('#form_main_secuencia #estado').val() == "" || $('#form_main_secuencia #estado').val() == null){
		estado = 1;
	}else{
		estado = $('#form_main_secuencia #estado').val();
	}	
	
	if($('#form_main_secuencia #bs_regis').val() == "" || $('#form_main_secuencia #bs_regis').val() == null){
		dato = '';
	}else{
		dato = $('#form_main_secuencia #bs_regis').val();
	}

	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&dato='+dato+'&estado='+estado+'&profesional='+profesional,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}
//FIN PAGINACION DE REGISTROS

//INICIO FUNCION PARA OBTENER LA EMPRESA
function getColaborador(){
    var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/getColaboradores.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_secuencia #profesional').html("");
			$('#form_main_secuencia #profesional').html(data);

		    $('#formularioSecuenciaFacturacion #secuencia_profesional').html("");
			$('#formularioSecuenciaFacturacion #secuencia_profesional').html(data);			
        }
     });		
}
//FIN FUNCION PARA OBTENER LA EMPRESA	

//INICIO FUNCION PARA OBTENER EL ESTADO
function getEstado(){
    var url = '<?php echo SERVERURL; ?>php/secuencia_facturacion/getEstado.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#form_main_secuencia #estado').html("");
			$('#form_main_secuencia #estado').html(data);	

		    $('#formularioSecuenciaFacturacion #estado').html("");
			$('#formularioSecuenciaFacturacion #estado').html(data);				
        }
     });		
}
//FIN FUNCION PARA OBTENER EL ESTADO
//FIN FUNCIONES
/***************************************************************************************************************************************************************************/

/***************************************************************************************************************************************************************************/
</script>