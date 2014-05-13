<div class="row">
	<div class="twelve columns">
		
		
		

			<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

			<!-- Formulario Buscar Obra -->

			<?php 
			if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';
		    echo form_open(lang('backend_url').'/'.lang('usuarios_url'),'id="gen_form"');?>
				<fieldset>
					<div class="row">
						<div class="six columns centered">
							<div class="row">
								<div class="two columns">
									<label class="inline" for="nombre">
										<span> <?php echo lang('usuarios_bus_nom'); ?> </span>
									</label>
								</div>
								<div class="ten columns">
									<input  name="nombre" type="text" />
								</div>
							</div>
							
							<div class="row">
								<div class="two columns">
									<label class="inline" for="apellidos">
										<span> <?php echo lang('usuarios_bus_ape'); ?> </span>
									</label>
								</div>
								<div class="ten columns">
									<input name="apellidos" type="text" />
								</div>
							</div>
												
							<div class="row">
								<div class="two columns">
									<label class="inline" for="email">
										<span>Email</span>
									</label>
								</div>
								<div class="ten columns">
									<input  name="email" type="text" />
								</div>
							</div>
							
							<div class="row">
								<div class="twelve columns alinear-derecha">
									<button class="button radius wtc" type="submit"> <?php echo lang('buscar'); ?> </button>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			<?php form_close(); ?>	
			<!-- Formulario Buscar Obra cierre -->
	</div>
</div>