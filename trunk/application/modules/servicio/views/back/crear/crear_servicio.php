<script type="text/javascript">
	
	$(document).ready(function()
	{
		/*
		$('#tipo_servicio').change(function()
		{
			var servicio = $('#tipo_servicio').val();
			
			//Si el tipo de servicio es hospedaje
			if(servicio == 1)
			{
				$('#datos_habitacion').show();
			}
			else $('#datos_habitacion').hide();
			
		});
		*/
		
		/*
		$(".invisible_input").keypress(function(event)
		{
  			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    			event.preventDefault();
  			}
		});
		*/
		
		//Solo numeros foat
		/*
		var parseInput = function(val)
		{
			var floatValue = parseFloat(val);
			return isNaN(floatValue) ? '' : floatValue;
		}
		
		$('.invisible_input').keyup(function()
		{
			var value = $(this).val()+'';
			if (value[value.length-1] !== '.')
			{
				$(this).val(parseInput(value));
			}
		}).focusout(function()
		{
			$(this).val(parseInput($(this).val()+''));
		});
		*/
	});
	
</script>

	<div class="row">
		<div class="twelve columns">
				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

			    <!-- Formulario Crear servicio -->
			    <?php
			    	echo validation_errors();
			    	if (isset($error))
			        echo $error;

			    	$id = (isset($servicio->id_servicio) ? $servicio->id_servicio : '');
			    ?>

			    <?php echo form_open_multipart('servicio/create/' . $id, array('id' => "gen_form", 'class' => 'custom')) ?>
			    <fieldset>
					<div class="row">
						<div class="six columns centered">
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="estado">
						        		<span> <?php echo lang('estado'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
						        	<select class="custom" id="estado" name="id_estado">
						                        <?php
						                        foreach (json_decode($estados) as $key => $estado)
						                        {
						                        	$key++;
						                            echo '<option value="' . $estado->id_estado . '" ' . (isset($servicio->id_estado) && $servicio->id_estado == $key ? 'selected="selected"' : set_select('id_estado', $estado->id_estado)) . '>' . ucwords($estado->estado) . '</option>';
						                        }
						                        ?>
						            </select>
					        	</div>
							</div>
		
							<div class="row">
								<div class="three columns">
									<label class="inline" for="estado">
						        		<span> <?php echo lang('tipo_servicio'); ?> </span>
						        	</label>
								</div>
								<div class="nine columns">
									<?php if(isset($tipo_servicio)): ?>
										<?php if(isset($servicio)): ?>
											<?php echo form_dropdown('id_tipo_servicio', $tipo_servicio, $servicio->id_tipo_servicio, 'class="select_back" id="tipo_servicio" '); ?>
										<?php else: ?>
											<?php echo form_dropdown('id_tipo_servicio', $tipo_servicio, '', 'class="select_back" id="tipo_servicio" '); ?>
										<?php endif; ?>
									<?php endif; ?>
								</div>
		
							</div>
							
							<!-- <div id="datos_habitacion" style="display: none;"> -->
							
								<?php /*
								<div class="row">
									<div class="three columns">
										<label class="inline" for="estado">
							        		<span> <?php echo 'Tipo Habitación'; ?> </span>
							        	</label>
									</div>
									<div class="nine columns">
										<?php echo form_dropdown('id_tipo_habitacion', $tipos_habitacion, set_value('id_tipo_habitacion'), 'class="select_back"'); ?>
									</div>
			
								</div>
								
								<div class="row">
									<div class="three columns">
										<label class="inline" for="estado">
							        		<span> <?php echo 'Estado Hab.'; ?> </span>
							        	</label>
									</div>
									<div class="nine columns">
										<?php echo form_dropdown('id_estado_habitacion', $estados_habitacion, set_value('id_eatado_habitacion'), 'class="select_back"'); ?>
									</div>
			
								</div>
								*/ ?>
								
								<?php /*
								<div class="row">
									<div class="twelve columns">
										
										<table class="twelve">
											
											<thead>
												<tr>
													<th width="60%" style="text-align: right;">Temporada</th>
													<?php foreach($temporadas as $temporada): ?>
														<th width="20%" style="text-align: center;"><?php echo ucwords(strtolower($temporada->nombre)); ?></th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>
												
												<?php foreach($monedas as $moneda): ?>
													
													<tr>
														<td style="text-align: right;" ><?php echo ucwords(strtolower($moneda->nombre)); ?></td>
													
													<?php foreach($temporadas as $temporada): ?>
														
														<td><input name="<?php echo $temporada->id_temporada.'_'.$moneda->id_moneda; ?>" class="invisible_input" /></td>
														
													<?php endforeach; ?>
													
													</tr>
													
												<?php endforeach; ?>
												
											</tbody>
										</table>
										
									</div>
								</div>
								*/ ?>
								
							<!-- </div> -->
							
					        <?php echo (isset($servicio) ? '<input type="hidden" name="id_servicio" value="' . $servicio->id_servicio . '" />' : '') ?>
		
					        <div class="row">
					        	<div class="twelve columns alinear-derecha">
					        		<button type="submit" class="button radius wtc"><?php echo (isset($servicio) ? lang('guardar') : lang('crear')) ?></button>
					        	</div>
					        </div>
						</div>
					</div>
			   	</fieldset>
			</form>
			<!-- Formulario Formulario Crear servicio cierre -->
		</div>
	</div>
