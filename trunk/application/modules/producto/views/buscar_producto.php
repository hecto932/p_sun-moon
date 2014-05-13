<?php $categorias=modules::run('services/relations/get_all','categoria','true');
$estados=modules::run('services/relations/get_all','estado','true');

?>

		<div id="ficha">

			<h2> <?php echo lang('buscar_tit_prod'); ?> </h2>

			<!-- Formulario Buscar Obra -->
			<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';

			echo form_open('backend/productos','id="gen_form"');?>
				<fieldset>
					<legend> <?php echo $this->lang->line('buscar')?> </legend>
					<p>
						<label for="codigo_coloplas">
							<span> <?php echo ($this->session->userdata('idioma') == 'es') ? 'Codigo '.lang('producto') : lang('producto').' Code' ; ?> </span>
							<input id="codigo_coloplas" name="codigo_coloplas" type="text" />
						</label>
					</p>
					<p>
						<label for="nombre">
							<span> <?php echo lang('ficha_nombre'); ?> </span>
							<input id="nombre" name="nombre" type="text" />
						</label>
					</p>
					<p>
						<label for="categoria">
							<span> <?php echo lang('categoria'); ?> </span>
							<select id="categoria" name="id_categoria">
							<option value=""> <?php echo lang('producto_busq_categA'); ?> </option>
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
							<span> <?php echo lang('estado'); ?>  </span>
							<select id="estado" name="id_estado">
							<option value=""> <?php echo lang('producto_busq_estadoO'); ?> </option>
							<?php foreach(json_decode($estados) as $estado){
								echo '
							<option value="'.$estado->id_estado.'">'.$estado->estado.'</option>';
								
							}
								?>
							</select>
						</label>
					</p>							
					<p class="inputCheckbox">
						<label for="destacado">
							
							<input id="destacado" name="destacado" type="checkbox" value="1" />
							<span> <?php echo lang('destacado'); ?> </span>
						</label>
					</p>
					
					<strong class="boton"><button type="submit"> <?php echo lang('buscar'); ?> </button></strong>
				</fieldset>
			</form>
			<!-- Formulario Buscar Obra cierre -->
			
		</div>
