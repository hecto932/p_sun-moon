<!-- Formulario Nuevo Idioma evento -->
<script type="text/javascript">
	$(function()
	{
		$('input[name=nombre]').focusout(function()
		{
			$.ajax
			({
				type: 'POST',
				url: '<?php echo base_url(); ?>evento/evento/exist_url',
				data: 'url='+$('input[name=url]').val(),
				success: function(respuesta)
				{
					if(respuesta=='true')
					{
						$('input[name=url]').val($('input[name=url]').val()+'-a')
					}
				}
			});
		});
		return false;
	});
</script>
				<?php echo form_open(lang('backend_url').'/'.lang('eventos_url').'/'.lang('guardar_url').'_'.lang('idioma_url') , array('id'=>"form_idioma", 'class' => 'custom')); ?>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">

						<label for="nombre"  <?php echo (form_error('nombre') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('titulo'); ?> * </span> <?php echo (form_error('nombre') != '') ? '('.form_error('nombre', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($evento->nombre)) ? $evento->nombre : ''; ?>
						<input class="<?php echo (form_error('nombre') != '') ? 'error' : '' ; ?>" name="nombre" type="text" value='<?php echo idioma_values(set_value('nombre'), $temp, $accion); ?>' />

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="subtitulo">
							<span> <?php echo lang('subtitulo'); ?> </span>
						</label>
						<?php $temp = (isset($evento->subtitulo)) ? $evento->subtitulo : ''; ?>
						<input name="subtitulo" type="text" value='<?php echo idioma_values(set_value('subtitulo'), $temp, $accion); ?>' />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">
						<?php //if (!isset($evento->id_detalle_evento)): ?>

							<?php $idioma_select = json_decode(modules::run('services/relations/get_all','idioma','true')); ?>

							<label for="idioma">
								<span> <?php echo lang('idioma_titulo'); ?> </span>
							</label>

							<select class="custom" id="idioma" name="id_idioma">

									<?php foreach($idioma_select as $im): ?>
										<option value="<?php echo $im->id_idioma; ?>"<?php

										if (set_select('id_idioma',$im->id_idioma)!='')
											echo set_select('id_idioma',$im->id_idioma);
										elseif ($accion != 'normal')
											echo ((isset($evento->id_idioma) && $evento->id_idioma==$im->id_idioma) ? ' selected="selected"' : '')?>><?php echo ucfirst($im->nombre); ?></option>
									<?php endforeach; ?>

							</select>

						<?php //endif; ?>

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="keywords" <?php echo (form_error('keywords') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_pclave'); ?> *</span> <?php echo (form_error('keywords') != '') ? '('.form_error('keywords', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($evento->keywords)) ? $evento->keywords : ''; ?>
						<input class="<?php echo (form_error("keywords") != "") ? "error" : "" ; ?>" name="keywords" type="text" value="<?php echo idioma_values(set_value('keywords'), $temp, $accion); ?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="url" <?php echo (form_error('url') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_url'); ?> *</span> <?php echo (form_error('url') != '') ? '('.form_error('url', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($evento->url)) ? $evento->url : ''; ?>
						<input class="<?php echo (form_error("url") != "") ? "error" : "" ; ?>" name="url" type="text" value="<?php echo idioma_values(set_value('url'), $temp, $accion) ; ?>" />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<div class="twelve columns">
							<label for="lugar_evento" <?php echo (form_error('lugar_evento') != '') ? 'class="error"' : '' ; ?>>
	                        	<span> <?php echo lang('eventos_ficha_levento'); ?> </span> <?php echo (form_error('lugar_evento') != '') ? '('.form_error('lugar_evento', '<span>', '</span>').')' : '' ; ?>
	                        </label>
	                        <?php $temp = (isset($evento->lugar_evento)) ? $evento->lugar_evento : ''; ?>
	                        <input class='<?php echo (form_error("lugar_evento") != "") ? "error" : "" ; ?>' name="lugar_evento" type="text" value="<?php echo idioma_values(set_value('lugar_evento'), $temp, $accion); ?>" />
						</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="centros_pago" <?php echo (form_error('centros_pago') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('eventos_ficha_cpagos'); ?> </span> <?php echo (form_error('centros_pago') != '') ? '('.form_error('centros_pago', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($evento->centros_pago)) ? $evento->centros_pago : ''; ?>
                        <input class='<?php echo (form_error("centros_pago") != "") ? "error" : "" ; ?>' name="centros_pago" type="text" value="<?php echo idioma_values(set_value('centros_pago'), $temp, $accion); ?>" />
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="titulo_pagina" <?php echo (form_error('titulo_pagina') != '') ? 'class="error"' : '' ; ?>>
                       		<span> <?php echo lang('eventos_ficha_paginaT'); ?> *</span> <?php echo (form_error('titulo_pagina') != '') ? '('.form_error('titulo_pagina', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($evento->titulo_pagina)) ? $evento->titulo_pagina : ''; ?>
                        <input class='<?php echo (form_error("titulo_pagina") != "") ? "error" : "" ; ?>' name="titulo_pagina" type="text" value="<?php echo idioma_values(set_value('titulo_pagina'), $temp, $accion); ?>" />
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_pagina" <?php echo (form_error('descripcion_pagina') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_paginaD'); ?> *</span> <?php echo (form_error('descripcion_pagina') != '') ? '('.form_error('descripcion_pagina', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($evento->descripcion_pagina)) ? $evento->descripcion_pagina : ''; ?>
						<input type="text" class='<?php echo (form_error("descripcion_pagina") != "") ? "error" : "" ; ?>' name="descripcion_pagina" rows="10" cols="50" value='<?php echo idioma_values(set_value('descripcion_pagina'), $temp, $accion); ?>' />
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_breve" <?php echo (form_error('descripcion_breve') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('eventos_ficha_dscB'); ?> *</span> <?php echo (form_error('descripcion_breve') != '') ? '('.form_error('descripcion_breve', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($evento->descripcion_breve)) ? $evento->descripcion_breve : ''; ?>
						<textarea class='<?php echo (form_error("descripcion_breve") != "") ? "error" : "" ; ?>' name="descripcion_breve" rows="10" cols="50"><?php echo idioma_values(set_value('descripcion_breve'), $temp, $accion); ?></textarea>
						<p style="text-align: right;" id='contador_descbreve'><span class="" id="actual_breve">0</span> <?php echo lang('caracteres_de'); ?> <span>200 </span><?php echo lang('caracteres'); ?></p>
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">

						<label for="descripcion_ampliada">
								<span> <?php echo lang('eventos_ficha_dscA'); ?> </span>
						</label>
						<?php if(form_error('descripcion_ampliada') != ''): ?>
							<div class="alert-box alert">
								<?php echo form_error('descripcion_ampliada'); ?>
								<a class="close" href="">×</a>

							</div>
						<?php endif; ?>
						<?php $temp = (isset($evento->descripcion_ampliada)) ? $evento->descripcion_ampliada : ''; ?>
						<textarea class="ckeditor" id="descripcion_ampliada" name="descripcion_ampliada">
							<?php echo idioma_values(set_value('descripcion_ampliada'), $temp, $accion); ?>
						</textarea>

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<input type="hidden" name="id_evento" value="<?php echo (isset($id_evento)) ? $id_evento : $evento->id_evento; ?>" />
					<?php if (isset($evento->id_detalle_evento) || $accion != 'normal'): ?>

						<input type="hidden" name="id_detalle_evento" value="<?php echo $evento->id_detalle_evento ?>" />
                       	<?php	//echo '<input type="hidden" name="id_idioma" value="'.$evento->id_idioma.'" />'; ?>

					<?php endif; ?>
					<div class="row">
						<div class="twelve columns area_botns">
							<button type="submit" id="boton_idioma" class="button radius wtc"> <?php echo ($accion == 'editar') ? lang('idioma_guardar') : lang('idioma_crear'); ?> </button>
						</div>
					</div>
					<?php echo form_hidden('accion', $accion); ?>
				</form>
				<!-- Formulario Formulario Nuevo Idioma evento cierre -->
