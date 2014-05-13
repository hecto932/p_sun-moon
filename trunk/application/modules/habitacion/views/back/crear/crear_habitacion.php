
	<div class="row">
		<div class="twelve columns">
				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

			    <!-- Formulario Crear habitacion -->
			    <?php
			    	echo validation_errors();
			    	if (isset($error))
			        echo $error;

			    	$id = (isset($habitacion->id_habitacion) ? $habitacion->id_habitacion : '');
			    ?>

			    <?php echo form_open_multipart('habitacion/create/' . $id, array('id' => "gen_form", 'class' => 'custom')) ?>
			    <fieldset>
					<div class="row">
						<div class="six columns centered">
							<div class="row">
								<div class="four columns">
						        	<label class="inline" for="estado">
						        		<span> <?php echo lang('estado'); ?> </span>
						        	</label>
						        </div>
					        	<div class="eight columns">
						        	<select class="custom" id="estado" name="id_estado">
						                        <?php
						                        foreach (json_decode($estados) as $key => $estado)
						                        {
						                        	$key++;
						                            echo '<option value="' . $estado->id_estado . '" ' . (isset($habitacion->id_estado) && $habitacion->id_estado == $key ? 'selected="selected"' : set_select('id_estado', $estado->id_estado)) . '>' . ucwords($estado->estado) . '</option>';
						                        }
						                        ?>
						            </select>
					        	</div>
							</div>
		
							<div class="row">
								<div class="four columns">
									<label class="inline" for="estado">
						        		<span> <?php echo lang('tipo_habitacion'); ?> </span>
						        	</label>
								</div>
								<div class="eight columns">
									<?php if(isset($tipo_habitacion)): ?>
										<?php if(isset($habitacion)): ?>
											<?php echo form_dropdown('id_tipo_habitacion', $tipo_habitacion, $habitacion->id_tipo_habitacion, 'class="select_back" id="tipo_habitacion" '); ?>
										<?php else: ?>
											<?php echo form_dropdown('id_tipo_habitacion', $tipo_habitacion, '', 'class="select_back" id="tipo_habitacion" '); ?>
										<?php endif; ?>
									<?php endif; ?>
								</div>
		
							</div>
							
							<div class="row">
								<div class="four columns">
									<label class="inline" for="estado">
						        		<span> <?php echo lang('habitaciones_codigo'); ?> </span>
						        	</label>
								</div>
								<div class="eight columns">
									<?php $temp = (isset($habitacion->codigo)) ? $habitacion->codigo : '' ?>
									<input type="text" name="codigo" value="<?php echo set_value('codigo', $temp); ?>" />
								</div>
							</div>
							
							<!--
							<div class="row">
								<div class="four columns">
									<label class="inline" for="estado_habitacion">
						        		<span> <?php echo 'Estado habitación'; ?> </span>
						        	</label>
								</div>
								<div class="eight columns">
									<?php if(isset($estado_habitacion)): ?>
										<?php if(isset($habitacion)): ?>
											<?php echo form_dropdown('id_estado_habitacion', $estado_habitacion, $habitacion->id_estado_habitacion, 'class="select_back" id="estado_habitacion" '); ?>
										<?php else: ?>
											<?php echo form_dropdown('id_estado_habitacion', $estado_habitacion, '', 'class="select_back" id="estado_habitacion" '); ?>
										<?php endif; ?>
									<?php endif; ?>
								</div>
		
							</div>
							-->
							
					        <?php echo (isset($habitacion) ? '<input type="hidden" name="id_habitacion" value="' . $habitacion->id_habitacion . '" />' : '') ?>
		
					        <div class="row">
					        	<div class="twelve columns alinear-derecha">
					        		<button type="submit" class="button radius wtc"><?php echo (isset($habitacion) ? lang('guardar') : lang('crear')) ?></button>
					        	</div>
					        </div>
						</div>
					</div>
			   	</fieldset>
			</form>
			<!-- Formulario Formulario Crear habitacion cierre -->
		</div>
	</div>
