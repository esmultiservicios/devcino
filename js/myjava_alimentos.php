<script>
$(document).ready(function() {
	getPacienteAlimentos();
});

function getPacienteAlimentos(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getPacientesAlimentos.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){		
		    $('#formulario_alimentos #paciente_alimentos').html("");
			$('#formulario_alimentos #paciente_alimentos').html(data);	
		}			
     });		
}

$('#formulario_alimentos #buscar_pacientes_alimentos').on('click', function(e){
	listar_pacientes_alimentos();
	 $('#modal_pacientes_alimentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_pacientes_alimentos = function(){
	var table_pacientes_alimentos = $("#dataTablePacientesAlimentos").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/getPacientesTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view_alimentos btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"paciente"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,
	});	 
	table_pacientes_alimentos.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_alimentos_dataTable("#dataTablePacientesAlimentos tbody", table_pacientes_alimentos);
}

var view_pacientes_alimentos_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view_alimentos");		
	$(tbody).on("click", "button.view_alimentos", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_alimentos #paciente_alimentos').val(data.pacientes_id);
		$('#formulario_alimentos #paciente_alimentos_id').val(data.pacientes_id);
		
		$('#modal_pacientes_alimentos').modal('hide');
	});
}

$("#formulario_alimentos #paciente_alimentos").on("change", function(e) {
    $('#formulario_alimentos #paciente_alimentos_id').val($("#formulario_alimentos #paciente_alimentos").val());
});

$(document).ready(function(){
    $("#modal_pacientes_alimentos").on('shown.bs.modal', function(){
        $(this).find('#formulario_pacientes_alimentos #buscar').focus();
    });
});

$('#enviar_formulario_alimentacion').on('click', function(e){
	e.preventDefault();
	$('#formulario_alimentos').attr({ 'data-form': 'save' });
	$('#formulario_alimentos').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes_nutricion/addAlimentos.php' });
	$("#formulario_alimentos").submit();
});
</script>