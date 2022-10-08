<div class="card">
	<div class="card-header text-white bg-info mb-3" align="center">
		Marque los alimentos que le gustan
	</div>
	<div class="card-body">
		<form  class="FormularioAjax" id="formulario_alimentos" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
			<input type="hidden" required id="paciente_alimentos_id" name="paciente_alimentos_id" placeholder="Paciente" class="form-control"/>
			<div class="form-row" id="grupo_pacientes">
				<div class="col-md-6 mb-6">
					<label for="paciente_alimentos">Paciente <span class="priority">*<span/></label>
					<div class="input-group mb-3">
						<select id="paciente_alimentos" name="paciente_alimentos" class="form-control" data-toggle="tooltip" data-placement="top" title="Paciente">
							<option value="">Seleccione</option>						  
						</select>
						<div class="input-group-append" id="buscar_pacientes_alimentos">				
						<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
						</div>	
					</div>
				</div>							
			</div>				
			<div class="form-group form-check">
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="cafe" value="1">
					<label class="form-check-label" for="cafe">Café</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="tes"  value="1">
					<label class="form-check-label" for="tes">Tes (manzanilla, limon, etc)</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="leche" value="1">
					<label class="form-check-label" for="leche">Leche</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="yogurt" value="1">
					<label class="form-check-label" for="yogurt">Yogurt</label>
				</div>							
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="requeson" value="1">
					<label class="form-check-label" for="requeson">Requeson</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="cuajada" value="1">
					<label class="form-check-label" for="cuajada">Cuajada</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="queso_fresco" value="1">
					<label class="form-check-label" for="queso_fresco">Queso Fresco</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="queso_crema" value="1">
					<label class="form-check-label" for="queso_crema">Queso Crema (tipo philadelphia)</label>
				</div>	
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="mermelada" value="1">
					<label class="form-check-label" for="mermelada">Mermeladas</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="mantequilla" value="1">
					<label class="form-check-label" for="mantequilla">Mantequilla de mani</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="pan_molde" value="1">
					<label class="form-check-label" for="pan_molde">Pan Molde</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="pan_baguette" value="1">
					<label class="form-check-label" for="pan_baguette">Pan Baguette</label>
				</div>							
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="bagels" value="1">
					<label class="form-check-label" for="bagels">Bagels</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="pancakes" value="1">
					<label class="form-check-label" for="pancakes">Pancakes</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="avena" value="1">
					<label class="form-check-label" for="avena">Avena</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="cereal" value="1">
					<label class="form-check-label" for="cereal">Cereal de desayuno</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="tortilla_maiz" value="1">
					<label class="form-check-label" for="tortilla_maiz">Tortillas de maíz</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="tortilla_harina" value="1">
					<label class="form-check-label" for="tortilla_harina">Tortillas de harina</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="arroz" value="1">
					<label class="form-check-label" for="arroz">Arroz</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="papa" value="1">
					<label class="form-check-label" for="papa">Papa</label>
				</div>							
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="camote" value="1">
					<label class="form-check-label" for="camote">Camote</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="pastas" value="1">
					<label class="form-check-label" for="pastas">Pastas (Macarrones, spaguettis, etc)</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="quinoa" value="1">
					<label class="form-check-label" for="quinoa">Quinoa</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="garbanzos" value="1">
					<label class="form-check-label" for="garbanzos">Garbanzos</label>
				</div>	
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="lentejas" value="1">
					<label class="form-check-label" for="lentejas">Lentejas</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="frijoles" value="1">
					<label class="form-check-label" for="frijoles">Frijoles</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="aguacate" value="1">
					<label class="form-check-label" for="aguacate">Aguacate</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="platano_maduro" value="1">
					<label class="form-check-label" for="platano_maduro">Platano Maduro</label>
				</div>							
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="banana_verde" value="1">
					<label class="form-check-label" for="banana_verde">Banano Verde</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="huevos" value="1">
					<label class="form-check-label" for="huevos">Huevos</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="jamon" value="1">
					<label class="form-check-label" for="jamon">Jamon</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="pollo" value="1">
					<label class="form-check-label" for="pollo">Pollo</label>
				</div>	
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="res" value="1">
					<label class="form-check-label" for="res">Res</label>
				</div>							
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="lomo_cerdo" value="1">
					<label class="form-check-label" for="lomo_cerdo">Lomo de cerdo</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="filete_pescado" value="1">
					<label class="form-check-label" for="filete_pescado">Filete de pescado</label>
				</div>			
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="atun" value="1">
					<label class="form-check-label" for="atun">Atun</label>
				</div>
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="sardinas" value="1">
					<label class="form-check-label" for="sardinas">Sardinas</label>
				</div>	
				<div class="col-md-3">
					<input type="checkbox" class="form-check-input" id="camarones" value="1">
					<label class="form-check-label" for="camarones">Camarones</label>
				</div>				
			</div>	

			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
					Vegetales y frutas de su preferencia
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="vegetales">Vegetales:</label>
							<input type="text" required id="vegetales" name="vegetales" placeholder="Vegetales" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="frutas">Frutas:</label>
							<input type="text" required id="frutas" name="frutas" placeholder="Frutas" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>				
				</div>
			</div>	

			<div class="card">
				<div class="card-header text-white bg-info mb-3" align="center">
					Sus comidas en un día comun suelen ser:
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="desayuno">Desayuno:</label>
							<input type="text" required id="desayuno" name="desayuno" placeholder="Desayuno" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="merienda1">Merienda (si hace):</label>
							<input type="text" required id="merienda1" name="merienda1" placeholder="Merienda" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="almuerzo">Almuerzo:</label>
							<input type="text" required id="almuerzo" name="almuerzo" placeholder="Almuerzo" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="merienda2">Merienda (si hace):</label>
							<input type="text" required id="merienda2" name="merienda2" placeholder="Merienda" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="cena">Cena:</label>
							<input type="text" required id="cena" name="cena" placeholder="Cena" class="form-control" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
						</div>							
					</div>														
				</div>
			</div>	
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary ml-2" type="submit" id="enviar_formulario_alimentacion"><div class="sb-nav-link-icon"></div><i class="fas fa-paper-plane"></i> Enviar Registros</button>
	</div>		
</div>	