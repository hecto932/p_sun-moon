<?php
$estados=modules::run('services/relations/get_all','estado','true');
$productos=modules::run('services/relations/get_all','producto','true','producto.id_producto');
?>

		<div id="ficha">

			<h2>Buscar FAQ</h2>

			<!-- Formulario Buscar FAQ -->
			<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">No se ha encontrado ningún resultado con el criterio de búsqueda seleccionado.</p>';

			echo form_open('backend/noticias','id="gen_form"');?>
				<fieldset>
					<legend>Buscar Noticia</legend>
					<p>
						<label for="id_noticia">
							<span>ID</span>
							<input id="id_noticia" name="id_noticia" type="text" />
						</label>
					</p>
                    <p>
						<label for="texto">
							<span>Texto</span>
							<input id="texto" name="texto" type="text" />
						</label>
					</p>
                    <p class="inputCheckbox">
						<label for="destacado">
							<input id="destacado" name="destacado" type="checkbox" value="1" />
							<span>Destacada</span>
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
					
					<strong class="boton"><button type="submit">Buscar</button></strong>
				</fieldset>
			</form>
			<!-- Formulario Buscar Obra cierre -->
			
		</div>
