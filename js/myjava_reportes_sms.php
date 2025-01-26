<script>
$(document).ready(function() {
	setInterval('pagination(1)',8000);	
});

$(document).ready(function() {
   getServicio();
   getProfesional();
   pagination(1);
});

$(document).ready(function() {
  $('#form_main_sms #profesional').on('change', function(){	
     pagination(1);
  });
});

$(document).ready(function() {
  $('#form_main_sms #fecha_i').on('change', function(){	
     pagination(1);
  });
});

$(document).ready(function() {
  $('#form_main_sms #fecha_f').on('change', function(){	
     pagination(1);
  });
});

$(document).ready(function() {
  $('#form_main_sms #bs_regis').on('keyup', function(){	
     pagination(1);
  });
});

$(document).ready(function() {
  $('#form_main_sms #usuario').on('change', function(){	
     pagination(1);
  });
});

//BOTONES DE ACCIÓN PARA EJECUTAR EL REPORTE EN EXCEL
$('#form_main_sms #reportes_exportar').on('click', function(e){
 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){	
	e.preventDefault();
	if($('#form_main_sms #servicio').val() != ""){
	   reporteEXCEL();
	}else{
		swal({
			title: "Error", 
			text: "Error al exportar, debe seleccionar el servicio",
			icon: "error", 
			dangerMode: true
		});		  
	}
}else{
	swal({
		title: "Acceso Denegado", 
		text: "No tiene permisos para ejecutar esta acción",
		icon: "error", 
		dangerMode: true
	});			 
}	
});

$('#form_main_sms #reportes_exportar_diario').on('click', function(e){
 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){	
	e.preventDefault();
	if($('#form_main_sms #servicio').val() != ""){
	   reporteDiarioEXCEL();
	}else{
		swal({
			title: "Error", 
			text: "Error al exportar, debe seleccionar el servicio",
			icon: "error", 
			dangerMode: true
		});				 
	}
}else{
	swal({
		title: "Acceso Denegado", 
		text: "No tiene permisos para ejecutar esta acción",
		icon: "error", 
		dangerMode: true
	});				 
}	
});

$('#form_main_sms #reportes_exportar_diario_colaboradores').on('click', function(e){
 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){	
	e.preventDefault();
	if($('#form_main_sms #servicio').val() != ""){
	   reporteDiarioColaboradorEXCEL();
	}else{
		swal({
			title: "Error", 
			text: "Error al exportar, debe seleccionar el servicio",
			icon: "error", 
			dangerMode: true
		});	
	}
}else{
	swal({
		title: "Acceso Denegado", 
		text: "No tiene permisos para ejecutar esta acción",
		icon: "error", 
		dangerMode: true
	});			 
}	
});

//OBTENER EL USUARIO
function getUsuario(){
    var url = '<?php echo SERVERURL; ?>php/sms/getUsuario.php';
		
	$.ajax({
	    type:'POST',
		url:url,
		async: true,
		success:function(data){		
		   $('#form_main_sms #usuario').html("");
		   $('#form_main_sms #usuario').html(data);
		}
	});
	return false;		
}

//OBTENER EL SERVICIO
function getProfesional(){
    var url = '<?php echo SERVERURL; ?>php/citas/getMedico.php';
		
	$.ajax({
	    type:'POST',
		url:url,
		async: true,
		success:function(data){		
		   $('#form_main_sms #profesional').html("");
		   $('#form_main_sms #profesional').html(data);
		}
	});
	return false;		
}

//CAMBIAR VALORES DE LA UNDIAD AL SELECCIONAR EL SERVICIO
$(document).ready(function() {
	  $('#form_main_sms #servicio').on('change', function(){
		var servicio = $('#form_main_sms #servicio').val();
        var url = '<?php echo SERVERURL; ?>php/citas/getUnidad.php';		
		
		$.ajax({
            type: "POST",
            url: url,
			data:'servicio='+servicio,
			async: true,
            success: function(data){
				$('#form_main_sms #unidad').html(data);				
				$('#form_main_sms #profesional').html("");				
            }
         });
		 
      });					
});

//CAMBIAR VALORES DEL PROFESIONAL AL SELECCIONAR LA UNIDAD DE SERVICIO
$(document).ready(function() {
	  $('#form_main_sms #unidad').on('change', function(){
		var servicio_id = $('#form_main_sms #servicio').val();
		var puesto_id = $('#form_main_sms #unidad').val();
        var url = '<?php echo SERVERURL; ?>php/citas/getMedico.php';		
		
		$.ajax({
            type: "POST",
            url: url,
			async: true,
            data:'servicio='+servicio_id+'&puesto_id='+puesto_id,
            success: function(data){
				$('#form_main_sms #profesional').html(data);				
            }
         });
		 
      });					
});

function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/sms/paginar.php';
	var fechai = $('#form_main_sms #fecha_i').val();
	var fechaf = $('#form_main_sms #fecha_f').val();
	var servicio;
	var unidad;
	var profesional;
	var usuario;
	var dias;
	var dato = $('#form_main_sms #bs_regis').val();
	
	if ($('#form_main_sms #servicio').val() == "" || $('#form_main_sms #servicio').val() == null){
	  servicio = 1;	
	}else{
	  servicio = $('#form_main_sms #servicio').val();
	}
	
	if ($('#form_main_sms #unidad').val() == "" || $('#form_main_sms #unidad').val() == null){
	  unidad = '';	
	}else{
	  unidad = $('#form_main_sms #unidad').val();
	}	
	
	if ($('#form_main_sms #profesional').val() == "" || $('#form_main_sms #profesional').val() == null){
	  profesional = '';	
	}else{
	  profesional = $('#form_main_sms #profesional').val();
	}	
	
	if ($('#form_main_sms #usuario').val() == "" || $('#form_main_sms #usuario').val() == null){
	  usuario = '';	
	}else{
	  usuario = $('#form_main_sms #usuario').val();
	}	

	if ($('#form_main_sms #dias').val() == "" || $('#form_main_sms #dias').val() == null){
	  dias = '';	
	}else{
	  dias = $('#form_main_sms #dias').val();
	}		
	
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&fechai='+fechai+'&fechaf='+fechaf+'&dato='+dato+'&servicio='+servicio+'&unidad='+unidad+'&profesional='+profesional+'&usuario='+usuario+'&dias='+dias,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}

function reporteEXCEL(){
	var fechai = $('#form_main_sms #fecha_i').val();
	var fechaf = $('#form_main_sms #fecha_f').val();
	var servicio;
	var unidad;
	var profesional;
	var usuario;
	var dias;
	var dato = $('#form_main_sms #bs_regis').val();
	
	if ($('#form_main_sms #servicio').val() == "" || $('#form_main_sms #servicio').val() == null){
	  servicio = 1;	
	}else{
	  servicio = $('#form_main_sms #servicio').val();
	}
	
	if ($('#form_main_sms #unidad').val() == "" || $('#form_main_sms #unidad').val() == null){
	  unidad = '';	
	}else{
	  unidad = $('#form_main_sms #unidad').val();
	}	
	
	if ($('#form_main_sms #profesional').val() == "" || $('#form_main_sms #profesional').val() == null){
	  profesional = '';	
	}else{
	  profesional = $('#form_main_sms #profesional').val();
	}	
	
	if ($('#form_main_sms #usuario').val() == "" || $('#form_main_sms #usuario').val() == null){
	  usuario = '';	
	}else{
	  usuario = $('#form_main_sms #usuario').val();
	}	

	if ($('#form_main_sms #dias').val() == "" || $('#form_main_sms #dias').val() == null){
	  dias = '';	
	}else{
	  dias = $('#form_main_sms #dias').val();
	}
	var url = '<?php echo SERVERURL; ?>php/sms/reporteSMS.php?dato='+dato+'&profesional='+profesional+'&usuario='+usuario+'&dias='+dias+'&fechai='+fechai+'&fechaf='+fechaf;
    window.open(url);		 
}

function reporteDiarioEXCEL(){
	var fechai = $('#form_main_sms #fecha_i').val();
	var fechaf = $('#form_main_sms #fecha_f').val();
	var profesional;
	var usuario;
	var dias;
	var dato = $('#form_main_sms #bs_regis').val();	
	
	if ($('#form_main_sms #profesional').val() == "" || $('#form_main_sms #profesional').val() == null){
	  profesional = '';	
	}else{
	  profesional = $('#form_main_sms #profesional').val();
	}	
	
	if ($('#form_main_sms #usuario').val() == "" || $('#form_main_sms #usuario').val() == null){
	  usuario = '';	
	}else{
	  usuario = $('#form_main_sms #usuario').val();
	}	

	if ($('#form_main_sms #dias').val() == "" || $('#form_main_sms #dias').val() == null){
	  dias = '';	
	}else{
	  dias = $('#form_main_sms #dias').val();
	}
	
	var url = '<?php echo SERVERURL; ?>php/sms/reporteDiarioSMS.php?profesional='+profesional+'&usuario='+usuario+'&dias='+dias+'&fechai='+fechai+'&fechaf='+fechaf;
    window.open(url);		 
}

function reporteDiarioColaboradorEXCEL(){
	var fechai = $('#form_main_sms #fecha_i').val();
	var fechaf = $('#form_main_sms #fecha_f').val();
	var profesional;
	var usuario;
	var dato = $('#form_main_sms #bs_regis').val();
	
	if ($('#form_main_sms #profesional').val() == "" || $('#form_main_sms #profesional').val() == null){
	  profesional = '';	
	}else{
	  profesional = $('#form_main_sms #profesional').val();
	}	
	
	if ($('#form_main_sms #usuario').val() == "" || $('#form_main_sms #usuario').val() == null){
	  usuario = '';	
	}else{
	  usuario = $('#form_main_sms #usuario').val();
	}
	
	var url = '<?php echo SERVERURL; ?>php/sms/reporteDiarioSMSColaborador.php?profesional='+profesional+'&usuario='+usuario+'&fechai='+fechai+'&fechaf='+fechaf;
    window.open(url);		 
}

function limpiar(){
	$('#form_main_sms #servicio').html("");
	$('#form_main_sms #unidad').html("");
	$('#form_main_sms #profesional').html("");	
	$('#form_main_sms #usuario').html("");		
    $('#form_main_sms #agrega-registros').html("");
	$('#form_main_sms #pagination').html("");		
   getSercicio();
   getUsuario();
   pagination(1);
}

$('#form_main_sms #limpiar').on('click', function(e){
    e.preventDefault();
    limpiar();
});
</script>