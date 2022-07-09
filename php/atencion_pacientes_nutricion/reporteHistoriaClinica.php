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
		width: 60%;
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
		border: 1px solid #000;
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
						<h2>HOSTIRIA CLÍNICA</h2>
						<h2>OBECIDAD MORBIDA</h2>	
						<h2>DR. LENNYN ALVARENGA</h2>									
					</div>
				</td>
				<td class="info_reporte">

				</td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Apellidos, Nombre</p>					
				</td>
				<td class="td" width="80%">
					<p>Edwin Javier Velasquez Cortes</p>					
				</td>
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="20%">
					<p>Fecha de Nacimiento</p>					
				</td>
				<td class="td" width="20%">
					<p>02/09/1991</p>					
				</td>
				<td class="td" width="20%">
					<p>Edad</p>					
				</td>
				<td class="td" width="20%">
					<p>30 años</p>					
				</td>
				<td class="td" width="20%">
					<p>L:</p>					
				</td>												
			</tr>
		</table>

		<table class="table">
			<tr>
				<td class="td" width="10%">
					<p>NCH</p>					
				</td>
				<td class="td" width="55%">
					<p>1020</p>					
				</td>
				<td class="td" width="10%">
					<p>Teléfono</p>					
				</td>
				<td class="td" width="25%">
					<p>97079577</p>					
				</td>											
			</tr>
			<tr>
				<td class="td" width="10%">
					<p>E-mail</p>					
				</td>
				<td class="td" width="55%">
					<p>edwin.velasquez@clinicarehn.com</p>					
				</td>
				<td class="td" width="10%">
					<p>Fecha</p>					
				</td>
				<td class="td" width="25%">
					<p>18/10/2021</p>					
				</td>											
			</tr>			
		</table>

		<table class="table">
			<tr>
				<td class="td" width="12.5%">
					<p>Datos</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Edad Inicio</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Alcoholismo</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>HTA</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>

			<tr>
				<td class="td" width="12.5%">
					<p>Peso</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Peso Ideal</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Tabaquismo</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>DM</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>
			
			<tr>
				<td class="td" width="12.5%">
					<p>Altura</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Exceso Peso</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Alergías</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Dislepidemia</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>
							
			<tr>
				<td class="td" width="12.5%">
					<p>IMC</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Híabito Alimen</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>SAS</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Artropatía</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>	
			
			<tr>
				<td class="td" width="12.5%">
					<p>Complexión</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Tipo Obeciadad</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>CPAP</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Insuf. Venosa</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>
			
			<tr>
				<td class="td" width="12.5%">
					<p>Hepatitis</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>Ulcus</p>					
				</td>
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>
				<td class="td" width="12.5%">
					<p>RGE</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>Cardiopatia</p>					
				</td>	
				<td class="td" width="12.5%">
					<p>..</p>					
				</td>																					
			</tr>				
		</table>

		<table class="table">
			<tr>
				<td class="td" width="25%">
					<p>Antecedentes Patologicos</p>					
				</td>
				<td class="td" width="25%">
					<p>..</p>					
				</td>
				<td class="td" width="25%">
					<p>Medicación Habital</p>					
				</td>
				<td class="td" width="25%">
					<p>..</p>					
				</td>					
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>I.Q. Abodominales</p>					
				</td>
				<td class="td" width="75%" colspan="3">
					<p>..</p>					
				</td>					
			</tr>				
		</table>

		<table class="table">
			<tr>
				<td class="td" width="25%">
					<p>Analitica</p>					
				</td>
				<td class="td" width="75%" colspan="7">
					<p>..</p>					
				</td>				
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>T4 TSH</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>
				<td class="td" width="25%">
					<p>Endoscopia</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>RX Tórax</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>
				<td class="td" width="25%">
					<p>PRF</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>										
			</tr>
			<tr>
				<td class="td" width="25%">
					<p>USG</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>
				<td class="td" width="25%">
					<p>PSQ</p>					
				</td>
				<td class="td" width="25%" colspan="3">
					<p>..</p>					
				</td>										
			</tr>												
		</table>
			
		<table class="table">
			<tr>
				<td class="td" width="16.66%">
					<p>Fecha IQ</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Adherencias</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Pouch</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>
			
			<tr>
				<td class="td" width="16.66%">
					<p>Cirujano</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Hernia Hiato</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Long AA</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>		
			
			<tr>
				<td class="td" width="16.66%">
					<p>Técnica IQ</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Cierre Pilares</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Long ABP</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>
			
			<tr>
				<td class="td" width="16.66%">
					<p>Peso</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Tamaño Hígado</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Long AC</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>	
			
			<tr>
				<td class="td" width="16.66%">
					<p>IMC</p>
				</td>											
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Sangrado</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Tamaño Bujía</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>
			
			<tr>
				<td class="td" width="16.66%">
					<p>Colelap asociada</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Perforación</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Seamguard</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>	
			
			<tr>
				<td class="td" width="16.66%">
					<p>Tiempo op</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Grapado</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Refuerzo Manual</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>
			
			<tr>
				<td class="td" width="16.66%">
					<p>Fecha Alta</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>
				<td class="td" width="16.66%">
					<p>Fuga Azul</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>	
				<td class="td" width="16.66%">
					<p>Color Cargas</p>					
				</td>
				<td class="td" width="16.66%">
					<p>..</p>					
				</td>										
			</tr>	
		</table>	
			
		<table class="table">
			<tr>
				<td class="td" width="15%">
					<p>Observaciones</p>					
				</td>
				<td class="td" width="85%">
					<p>..</p>					
				</td>
			</tr>
		</table>
			
		<table class="table">
			<tr>
				<td class="td" width="7.14%">
					<p>Evolución</p>					
				</td>
				<td class="td" width="7.14%">
					<p>10 d</p>					
				</td>
				<td class="td" width="7.14%">
					<p>1 m</p>					
				</td>
				<td class="td" width="7.14%">
					<p>3 m</p>					
				</td>
				<td class="td" width="7.14%">
					<p>6 m</p>					
				</td>
				<td class="td" width="7.14%">
					<p>9 m</p>					
				</td>
				<td class="td" width="7.14%">
					<p>12 m</p>					
				</td>
				<td class="td" width="7.14%">
					<p>18 m</p>					
				</td>	
				<td class="td" width="7.14%">
					<p>2 a</p>					
				</td>
				<td class="td" width="7.14%">
					<p>3 a</p>					
				</td>					
				<td class="td" width="7.14%">
					<p>4 a</p>					
				</td>
				<td class="td" width="7.14%">
					<p>5 a</p>					
				</td>
				<td class="td" width="7.14%">
					<p>6 a</p>					
				</td>
				<td class="td" width="7.14%">
					<p>7 a</p>					
				</td>																														
			</tr>
			<tr>
				<td class="td" width="7.14%">
					<p>Peso Actual</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>	
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>					
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>																														
			</tr>
			<tr>
				<td class="td" width="7.14%">
					<p>Peso Perdido</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>	
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>					
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>																														
			</tr>
			<tr>
				<td class="td" width="7.14%">
					<p>% Perdido</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>	
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>					
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>																														
			</tr>	
			<tr>
				<td class="td" width="7.14%">
					<p>IMC Actual</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>	
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>					
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>
				<td class="td" width="7.14%">
					<p>..</p>					
				</td>																														
			</tr>															
		</table>		
	</div>
</body>
</html>