<?php $tipos=modules::run('services/relations/get_all','tipo_multimedia','true');
$estados=modules::run('services/relations/get_all','estado','true');
?>
		<div id="ficha">

			<h2>Buscar multimedia</h2>

			<!-- Formulario Buscar Obra -->

			<?php 
			if (isset($mensaje) && $mensaje!='') echo '<p class="error">No se ha encontrado ningún resultado con el criterio de búsqueda seleccionado.</p>';
			echo form_open('backend/multimedia','id="gen_form"');?>
				<fieldset>
					<legend>Buscar multimedia</legend>
					<p>
						<label for="id_multimedia">
							<span>ID</span>
							<input id="id_multimedia" name="id_multimedia" type="text" />
						</label>
					</p>
					<p>
						<label for="nombre">
							<span>Nombre</span>
							<input id="nombre" name="nombre_multimedia" type="text" />
						</label>
					</p>
					<p>
						<label for="tipo">
							<span>Tipo</span>
							<select id="tipo" name="id_tipo">
							<option value="">Todos</option>
							<?php foreach(json_decode($tipos) as $tipo){
								echo '
							<option value="'.$tipo->id_tipo.'</option>">'.$tipo->nombre.'</option>';
								
							}
								?>
							</select>
						</label>
					</p>	
					<p>
						<label for="estado">
							<span>Estado</span>
							<select id="estado" name="id_estado">
							<option value="">Todos</option>
							<?php foreach(json_decode($estados) as $estado){
								echo '
							<option value="'.$estado->id_estado.'</option>">'.$estado->estado.'</option>';
								
							}
								?>
							</select>
						</label>
					</p>							
					<p>
						<label for="tag">
							<span>Tag</span>
							<input id="tag" name="tag" type="text" />
						</label>
					</p>
					<strong class="boton"><button type="submit">Buscar</button></strong>
				</fieldset>
			</form>
			<!-- Formulario Buscar Obra cierre -->
			
		</div>
