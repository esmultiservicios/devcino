<html>
<head>
  <style>
	@import url('fonts/BrixSansRegular.css');
	@import url('fonts/Helvetica.css');

    @page { 
		margin: 20px 3px; 
		width: 100%;
	}

	#footer .page:after { 
		content: counter(page, upper-roman);
	}

	p, label, span{
		font-family: 'Helvetica';
		font-size: 8pt;
		word-wrap: break-word;
		margin: 0 !important;	
	}
	h2{
		font-family: 'Helvetica';
		font-size: 12pt;
		word-wrap: break-word;
		margin: 0 !important;	
	}
	#reporte_head, #factura_cliente, #factura_detalle{
		width: 100%;
		padding-left: 10px;
		padding-top: 10px;   
		padding-bottom: 10px;
	}
	.reporte_logo{
		width: 20%;
	}
	#logo{
		width: 40px;
		height:auto;
	}
	.info_empresa{
		width: 90%;
		text-align: center;
		padding-left: 70px;
		padding-top: 10px;   
		padding-bottom: 10px;		
	}
	.info_factura{
		width: 20%;
	}
	.info_reporte{
		width: 100%;
	}
	.table{
		width:100%; 
		margin: 15 !important;		
	}
	.table, .th, .td{
		border: none;
		border-spacing: 0;
		clear:both;
	}
    #footer .page:after { 
		content: counter(page, upper-roman);
	}	
  </style>
</head>
<body>
	<div id="content" style="page-break-before: auto;">
		<table id="reporte_head">
			<tr>
				<td class="reporte_logo">
					<div id="logo">
						<img src="<?php echo SERVERURL; ?>img/logo_factura.jpg" width="220px" height="80px">
					</div>
				</td>
				<td class="info_empresa">
					<div>
						<h2>REGISTRO DE COMIDA</h2>	
						<h2><?php echo 'Profesional: '.$consultaAtencion['profesional']; ?></h2>									
					</div>
				</td>
				<td class="info_reporte">

				</td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="14%">
					<p><b>Apellidos, Nombre:</b></p>					
				</td>
				<td class="td" width="86%">
					<p><?php echo $consultaAtencion['cliente']; ?></p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p><b>Registro #:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['alimentos_id']; ?></p>					
				</td>
				<td class="td" width="10%">
					<p><b>Fecha:</b></p>					
				</td>
				<td class="td" width="70%">
					<p><?php echo $consultaAtencion['fecha']; ?></p>					
				</td>													
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td colspan="4">Marque los Alimentos que le gustan</td>
				<td colspan="2">Sus comidas en un día común, pueden ser, deme 2 ejemplos</td>
			</tr>		
		</table>	
		
		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p><b>Café:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['cafe']; ?></p>					
				</td>	
				<td class="td" width="12%">
					<p><b>Lomo de Cerdo:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['lomo_cerdo']; ?></p>					
				</td>
				<td class="td" width="12%">
					<p><b>Desayuno:</b></p>					
				</td>					
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['desayuno']; ?></p>					
				</td>																	
			</tr>
						
			<tr>
				<td class="td" width="10%">
					<p><b>Tes:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['tes']; ?></p>					
				</td>	
				<td class="td" width="12%">
					<p><b>Filete de Pescado:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['filete_pescado']; ?></p>					
				</td>
				<td class="td" width="12%">
					<p><b>Merienda (si hace):</b></p>					
				</td>					
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['merienda1']; ?></p>					
				</td>																	
			</tr>

			<tr>
				<td class="td" width="10%">
					<p><b>Leche:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['leche']; ?></p>					
				</td>	
				<td class="td" width="12%">
					<p><b>Atun:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['atun']; ?></p>					
				</td>
				<td class="td" width="12%">
					<p><b>Almuerzo:</b></p>					
				</td>					
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['almuerzo']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%">
					<p><b>Yogurt:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['yogurt']; ?></p>					
				</td>	
				<td class="td" width="12%">
					<p><b>Sardinas:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['sardinas']; ?></p>					
				</td>
				<td class="td" width="12%">
					<p><b>Merienda (si hace):</b></p>					
				</td>					
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['merienda2']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%">
					<p><b>Cuajada:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['cuajada']; ?></p>					
				</td>	
				<td class="td" width="12%">
					<p><b>Camarones:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['camarones']; ?></p>					
				</td>
				<td class="td" width="12%">
					<p><b>Cena:</b></p>					
				</td>					
				<td class="td" width="50%">
					<p><?php echo $consultaAtencion['cena']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Requeson:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['requeson']; ?></p>					
				</td>																	
			</tr>	

			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Queso Fresco:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['queso_fresco']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Queso Crema (Tipo philadelphia):</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['queso_crema']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Mermeladas:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['mermeladas']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Mantequilla de mani:</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['mantequilla_mani']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Pan Molde:</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['pan_molde']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Pan Baguette:</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['pan_baguete']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Bagels:</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['bagels']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Pancakes:</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['pancakes']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Avena:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['avena']; ?></p>					
				</td>	
				<td class="td" width="10%" colspan="3">
					Vegetales y frutas de su preferencia					
				</td>																												
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Cereales de Desayuno:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['cereal']; ?></p>					
				</td>	
				<td class="td" width="10%">
					<p><b>Vegetales:</b></p>					
				</td>
				<td class="td" width="10%" colspan="4">
					<p><?php echo $consultaAtencion['vegetales']; ?></p>					
				</td>																								
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Tortilla de Maíz:</b></p>					
				</td>
				<td class="td" width="10%">
					<p><?php echo $consultaAtencion['tortilla_maiz']; ?></p>					
				</td>	
				<td class="td" width="10%">
					<p><b>Frutas:</b></p>					
				</td>
				<td class="td" width="10%" colspan="4">
					<p><?php echo $consultaAtencion['frutas']; ?></p>					
				</td>																								
			</tr>				

			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Tortilla de Harina:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['tortilla_harina']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Arroz:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['arroz']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Papa:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['papa']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Camote:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['camote']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="3">
					<p><b>Pastas (macarrones, spaguettis, etc):</b></p>					
				</td>
				<td class="td" width="90%" colspan="3">
					<p><?php echo $consultaAtencion['pastas']; ?></p>					
				</td>																	
			</tr>	

			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Quinoa:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['quinoa']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Garbanzos:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['garbanzos']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Lentejas:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['lentejas']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Frijoles:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['frijoles']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Aguacate:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['aguacate']; ?></p>					
				</td>																	
			</tr>
						
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Platano Maduro:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['platano_maduro']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Banano Verde:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['banano_verde']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Huevos:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['huevos']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Jamon:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['jamon']; ?></p>					
				</td>																	
			</tr>	
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Pollo:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['pollo']; ?></p>					
				</td>																	
			</tr>
			
			<tr>
				<td class="td" width="10%" colspan="2">
					<p><b>Res:</b></p>					
				</td>
				<td class="td" width="90%" colspan="4">
					<p><?php echo $consultaAtencion['res']; ?></p>					
				</td>																	
			</tr>			
		</table>
	</div>
</body>
</html>