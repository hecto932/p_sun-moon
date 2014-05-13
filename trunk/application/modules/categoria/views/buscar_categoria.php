		<div id="ficha">

			<h2> <?php echo lang('categoria_bus_tit'); ?> </h2>

			<!-- Formulario Buscar Obra -->

			<?php 
			if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';
			echo form_open('backend/categorias','id="gen_form"');?>
				<fieldset>
					<legend> <?php echo lang('categoria_bus_tit'); ?> </legend>
					<p>
						<label for="nombre">
							<span> <?php echo lang('categoria_bus_nom'); ?> </span>
							<input id="nombre" name="nombre" type="text" />
						</label>
					</p>
					<p>
						<label for="descripcion">
							<span> <?php echo lang('categoria_bus_dsc'); ?> </span>
							<input id="descripcion" name="descripcion" type="text" />
						</label>
					</p>					
					<strong class="boton"><button type="submit"> <?php echo lang('buscar'); ?> </button></strong>
				</fieldset>
			</form>
            <?php form_close(); ?>
			<!-- Formulario Buscar Obra cierre -->
			
		</div>
