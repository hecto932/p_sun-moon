<div class="row">
	<div class="twelve columns">

			<?php if(isset($breadcrumbs)): ?> <?php echo $breadcrumbs; ?> <?php endif; ?>

			<?php 
			if (isset($mensaje) && $mensaje != '') echo '<p class="error">'.lang('listado_error').'</p>';
		    echo form_open(lang('backend_url').'/'.lang('testimonios_url'),'id="gen_form" class="custom" ');?>
				<fieldset>
					<div class="row">
						<div class="six columns centered">
							<div class="row">
								<div class="two columns">
									<label class="inline" for="texto">
										<span> <?php echo 'Texto'; ?> </span>
									</label>
								</div>
								<div class="ten columns">
									<input  name="texto" type="text" />
								</div>
							</div>
							
							<div class="row">
								<div class="two columns">
									<label class="inline" for="rating">
										<span>Rating</span>
									</label>
								</div>
								<div class="ten columns estado">
									<?php echo form_dropdown('rating', array('' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), set_value('rating')); ?>
								</div>
							</div>
							
							<div class="row">
								<div class="two columns">
									<label class="inline" for="estado">
										<span>Estado</span>
									</label>
								</div>
								<div class="ten columns">
									<select name="id_estado">
										<option value=""></option>
										<?php foreach(json_decode($estados) as $estado){
												echo '<option value="'.$estado->id_estado.'">'.$estado->estado.'</option>';
											}
										?>
									</select>
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