<script type="text/javascript">
	
	$(document).ready(function()
	{
		//Solo numeros float
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
	});
	
</script>

	<div class="row">
		<div class="twelve columns">
				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

			    <!-- Formulario Crear tipo habitacion -->
			    <?php
			    	echo validation_errors();
			    	if (isset($error))
			        echo $error;

			    	$id = (isset($tipo_habitacion->id_tipo_habitacion) ? $tipo_habitacion->id_tipo_habitacion : '');
			    ?>

			    <?php echo form_open_multipart('/tipo_habitacion/tipo_habitacion/create/' . $id, array('id' => "gen_form", 'class' => 'custom')) ?>
			    <?php echo (isset($tipo_habitacion) ? '<input type="hidden" name="id_tipo_habitacion" value="' . $tipo_habitacion->id_tipo_habitacion . '" />' : '') ?>
			    <fieldset>
					<div class="row">
						<div class="six columns centered">
							
							<!-- Estado -->
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
						                            echo '<option value="' . $estado->id_estado . '" ' . (isset($tipo_habitacion->id_estado) && $tipo_habitacion->id_estado == $key ? 'selected="selected"' : set_select('id_estado', $estado->id_estado)) . '>' . ucwords($estado->estado) . '</option>';
						                        }
						                        ?>
						            </select>
					        	</div>
							</div>
							
							<!-- Personas -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="estado">
						        		<span> <?php echo lang('personas'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($tipo_habitacion->personas) && !empty($tipo_habitacion->personas)) ? $tipo_habitacion->personas : ''; ?>
						        	<input type="text" name="personas" value="<?php echo set_value('personas', $temp); ?>" />
					        	</div>
							</div>
							
							<!--
							<div class="row">
								<div class="twelve columns">
									
									<table class="twelve">
										
										<thead>
											<tr>
												<th width="60%" style="text-align: right;">Costo</th>
												<?php foreach($temporadas as $temporada): ?>
													<th width="20%" style="text-align: center;"><?php echo 'Temporada '.ucwords(strtolower($temporada->nombre)); ?></th>
												<?php endforeach; ?>
											</tr>
										</thead>
										<tbody>
											
											<?php foreach($monedas as $moneda): ?>
												
												<tr>
													<td style="text-align: right;" ><?php echo ucwords(strtolower($moneda->nombre)); ?></td>
												
												<?php foreach($temporadas as $temporada): ?>
													
													<?php
														$valor = '';
														if(!empty($costos_tipo_habitacion))
														{
															$valor = filtrar($costos_tipo_habitacion, 'id_temporada='.$temporada->id_temporada.':id_moneda='.$moneda->id_moneda);
															$valor = (!empty($valor)) ? $valor[0]->valor : '';
														}
													?>
													
													<td><input name="<?php echo $temporada->id_temporada.'_'.$moneda->id_moneda; ?>" class="invisible_input" value="<?php echo $valor; ?>" /></td>
													
												<?php endforeach; ?>
												
												</tr>
												
											<?php endforeach; ?>
											
										</tbody>
									</table>
									
								</div>
							</div>
							-->
							
					        <div class="row">
					        	<div class="twelve columns alinear-derecha">
					        		<button type="submit" class="button radius wtc"><?php echo (isset($tipo_habitacion) ? lang('guardar') : lang('crear')) ?></button>
					        	</div>
					        </div>
						</div>
					</div>
			   	</fieldset>
			</form>
			<!-- Formulario Formulario Crear Tipo habitacion cierre -->
		</div>
	</div>
