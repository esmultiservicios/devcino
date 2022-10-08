<script>
/*
------------------------------------------------------------------------------------------------------------------
***********************************CARGAR DATOS A SELECT CORPORACION*********************************************
------------------------------------------------------------------------------------------------------------------
*/
$(function(){
	$('#departamento').on('load', function(){
		var id = $('#departamento').val();
		var url = '<?php echo SERVERURL; ?>php/selects/departamentos_municipios.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#municipio option').remove();
				$('#municipio').append(data);
			}
		});
		return false;
	});
});

$(document).ready(function() {    
	$('#departamento').on('blur', function(){
		var id = $('#departamento').val();
		var url = '<?php echo SERVERURL; ?>php/selects/departamentos_municipios.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#municipio option').remove();
				$('#municipio').append(data);
			}
		});
		return false;
	});
}); 

$(function(){
	$('#departamento1').on('load', function(){
		var id = $('#departamento1').val();
		var url = '<?php echo SERVERURL; ?>php/selects/departamentos_municipios.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#municipio1 option').remove();
				$('#municipio1').append(data);
			}
		});
		return false;
	});
});

$(function(){
	$('#departamento').on('click', function(){
		var id = $('#departamento').val();
		var url = '<?php echo SERVERURL; ?>php/selects/departamentos_municipios.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,			
			success: function(data){
				$('#municipio option').remove();
				$('#municipio').append(data);
			}
		});
		return false;
	});
});

$(function(){
	$('#departamento1').on('click', function(){
		var id = $('#departamento1').val();
		var url = '<?php echo SERVERURL; ?>php/selects/departamentos_municipios.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#municipio1 option').remove();
				$('#municipio1').append(data);
			}
		});
		return false;
	});
});

//MODULO ATAS
$(document).ready(function() {    
    $('#exp').keypress(function(){
        //Obtenemos el value del input
		var id = $('#exp').val();
		var url = '<?php echo SERVERURL; ?>php/selects/paciente.php';

        //Le pasamos el valor del input al ajax
        $.ajax({
            type: "POST",
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#expediente option').remove();
				$('#expediente').append(data);
			}
		});
      });
   });   
   
 //MODULO REPORTES
$(document).ready(function() { 
$(function(){
	$('#first-disabled2').on('change', function(){
		var id = $('#first-disabled2').val();
		var url = '<?php echo SERVERURL; ?>php/selects/colaboradores.php';

		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success: function(data){
				$('#first-disabled3').html(data);
			}
		});
		return false;
	});
}); 
}); 
</script>