<?php
	$estados = modules::run('services/relations/get_all','estado','true');
?>


		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

				<!-- Formulario Buscar FAQ -->
				<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';

				echo form_open('backend/habitaciones','id="gen_form" class="custom"');?>
					<fieldset>
						<div class="row">
							<div class="six columns centered">
								<div class="row">
				                    <div class="three columns">
										<label class="inline" for="estado">
											<span> <?php echo lang('estado'); ?> </span>
										</label>
									</div>
									<div class="nine columns estado">
										<select class="custom six" id="estado" name="id_estado">
											<option value=""> <?php echo lang('habitaciones_ficha_estado'); ?> </option>
											<?php foreach(json_decode($estados) as $estado){
													echo '<option value="'.$estado->id_estado.'">'.$estado->estado.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="row" >
									<div class="three columns">
										<label class="inline" for="id_tipo_estado">
											<span> <?php echo lang('tipo_habitacion'); ?> </span>
										</label>
									</div>
									<div class="nine columns">
										<?php if(isset($tipo_habitacion)): ?>
											<?php echo form_dropdown('id_tipo_habitacion', $tipo_habitacion, ''); ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="row">
									<div class="twelve columns alinear-derecha">
										<button class="button radius wtc" type="submit" style="margin-top:10px"> <?php echo lang('buscar'); ?> </button>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
					<!-- Formulario Buscar Obra cierre -->
			</div>
		</div>