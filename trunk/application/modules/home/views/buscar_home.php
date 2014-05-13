<?php $categorias=modules::run('services/relations/get_all','categoria','true');
$estados=modules::run('services/relations/get_all','estado','true');

?>

		<div id="ficha">

			<h2>Buscar obra</h2>

			<!-- Formulario Buscar Obra -->
			<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">No se ha encontrado ningún resultado con el criterio de búsqueda seleccionado.</p>';

			echo form_open('backend/obras','id="gen_form"');?>
				<fieldset>
					<legend>Buscar Obra</legend>
					<p>
						<label for="titulo">
							<span>Título</span>
							<input id="titulo" name="titulo" type="text" />
						</label>
					</p>
					<p>
						<label for="categoria">
							<span>Categoría</span>
							<select id="categoria" name="id_categoria">
							<option value="">Todas</option>
							<?php foreach(json_decode($categorias) as $categoria){
								echo '
							<option value="'.$categoria->id_categoria.'</option>">'.$categoria->nombre.'</option>';
								
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
							<option value="'.$estado->id_estado.'">'.$estado->estado.'</option>';
								
							}
								?>
							</select>
						</label>
					</p>							
					<p>
						<label for="fecha_desde">
							<span>Desde Fecha Obra (aaaa-mm-dd)</span>
							<input id="fecha_desde" name="fecha_desde" type="text" />
						</label>
					</p>
					<p>
						<label for="fecha_hasta">
							<span>Hasta Fecha Obra (aaaa-mm-dd)</span>
							<input id="fecha_hasta" name="fecha_hasta" type="text" />
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
