<!-- Formulario Nuevo Idioma tipo habitacion -->

				<?php echo form_open(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('guardar_url').'_'.lang('idioma_url'),'id="gen_form" class="custom"'); ?>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">

						<label for="nombre"  <?php echo (form_error('nombre') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('titulo'); ?> * </span> <?php echo (form_error('nombre') != '') ? '('.form_error('nombre', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($tipo_habitacion->nombre)) ? $tipo_habitacion->nombre : ''; ?>
						<input class='<?php echo (form_error("nombre") != "") ? "error" : "" ; ?>' name="nombre" type="text" value="<?php echo idioma_values(set_value('nombre'), $temp, $accion); ?>" />

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="subtitulo">
							<span> <?php echo lang('subtitulo'); ?> </span>
						</label>
						<?php $temp = (isset($tipo_habitacion->subtitulo)) ? $tipo_habitacion->subtitulo : ''; ?>
						<input name="subtitulo" type="text" value="<?php echo idioma_values(set_value('subtitulo'), $temp, $accion); ?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="titulo_pagina" <?php echo (form_error('titulo_pagina') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('tipo_habitacion_ficha_paginaT'); ?> *</span> <?php echo (form_error('titulo_pagina') != '') ? '('.form_error('titulo_pagina', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($tipo_habitacion->titulo_pagina)) ? $tipo_habitacion->titulo_pagina : ''; ?>
                        <input class='<?php echo (form_error("titulo_pagina") != "") ? "error" : "" ; ?>' name="titulo_pagina" type="text" value="<?php echo idioma_values(set_value('titulo_pagina'), $temp, $accion); ?>" />
						
						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>
						
						<label for="costo_alta" <?php echo (form_error('costo_alta') != '') ? 'class="error"' : '' ; ?>>
                        	<span> <?php echo lang('costo_alta'); ?> *</span> <?php echo (form_error('costo_alta') != '') ? '('.form_error('costo_alta', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php
                        	//Temporada alta
                        	if(isset($costos)) $filtro = filtrar($costos, "id_temporada=2");
                        	$temp = (isset($filtro[0]) && !empty($filtro[0])) ? $filtro[0]->valor : '';
                        ?>
                        <input class='<?php echo (form_error("costo_alta") != "") ? "error" : "" ; ?>' name="costo_alta" type="text" value="<?php echo idioma_values(set_value('costo_alta'), $temp, $accion); ?>" />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">
						<?php //if (!isset($servicio->id_detalle_servicio)): ?>

							<?php $idioma_select = json_decode(modules::run('services/relations/get_all','idioma','true')); ?>

							<label for="idioma">
								<span> <?php echo lang('idioma_titulo'); ?> </span>
							</label>

							<select class="custom lenguaje_servicios" id="idioma" name="id_idioma">

									<?php foreach($idioma_select as $im): ?>
										<option value="<?php echo $im->id_idioma; ?>"<?php

										if (set_select('id_idioma',$im->id_idioma)!='')
											echo set_select('id_idioma',$im->id_idioma);
										elseif ($accion != 'normal')
											echo ((isset($tipo_habitacion->id_idioma) && $tipo_habitacion->id_idioma==$im->id_idioma) ? ' selected="selected"' : '')?>><?php echo lang(strtolower($im->nombre)) ?></option>
									<?php endforeach; ?>

							</select>

						<?php //endif; ?>

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="keywords" <?php echo (form_error('keywords') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('tipo_habitacion_ficha_pclave'); ?> *</span> <?php echo (form_error('keywords') != '') ? '('.form_error('keywords', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($tipo_habitacion->keywords)) ? $tipo_habitacion->keywords : ''; ?>
						<input class="<?php echo (form_error("keywords") != "") ? "error" : "" ; ?>" name="keywords" type="text" value="<?php echo idioma_values(set_value('keywords'), $temp, $accion); ?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="url" <?php echo (form_error('url') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('tipo_habitacion_ficha_url'); ?> *</span> <?php echo (form_error('url') != '') ? '('.form_error('url', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($tipo_habitacion->url)) ? $tipo_habitacion->url : ''; ?>
						<input class="<?php echo (form_error("url") != "") ? "error" : "" ; ?>" name="url" type="text" value="<?php echo idioma_values(set_value('url'), $temp, $accion) ; ?>" />
						
						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>
						
						<label for="costo_baja" <?php echo (form_error('costo_baja') != '') ? 'class="error"' : '' ; ?>>
                        	<span> <?php echo lang('costo_baja'); ?> *</span> <?php echo (form_error('costo_baja') != '') ? '('.form_error('costo_baja', '<span>', '</span>').')' : '' ; ?>
                        </label>
						<?php
                        	//Temporada baja
                        	if(isset($costos)) $filtro = filtrar($costos, 'id_temporada=1');
                        	$temp = (isset($filtro[0]) && !empty($filtro[0])) ? $filtro[0]->valor : '';
						?>
                        <input class='<?php echo (form_error("costo_baja") != "") ? "error" : "" ; ?>' name="costo_baja" type="text" value="<?php echo idioma_values(set_value('costo_baja'), $temp, $accion); ?>" />
						
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>
					
					<div class="twelve columns">
						<label for="moneda" <?php echo (form_error('moneda') != '') ? 'class="error"' : '' ; ?> >
                        	<span> <?php echo lang('tipo_habitacion_moneda'); ?> *</span> <?php echo (form_error('moneda') != '') ? '('.form_error('moneda', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php
                        	$temp = (isset($costos) && !empty($costos)) ? $costos[0]->id_moneda : '';
						?>
                        <?php echo form_dropdown('id_moneda', $opt_moneda, set_value('id_moneda', $temp), 'class=" "'); ?>
					</div>
					
					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_pagina" <?php echo (form_error('descripcion_pagina') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('tipo_habitacion_ficha_paginaD'); ?> *</span> <?php echo (form_error('descripcion_pagina') != '') ? '('.form_error('descripcion_pagina', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($tipo_habitacion->descripcion_pagina)) ? $tipo_habitacion->descripcion_pagina : ''; ?>
						<input type="text" class='<?php echo (form_error("descripcion_pagina") != "") ? "error" : "" ; ?>' name="descripcion_pagina" rows="10" cols="50" value="<?php echo idioma_values(set_value('descripcion_pagina'), $temp, $accion); ?>" />
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_breve" <?php echo (form_error('descripcion_breve') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('tipo_habitacion_ficha_dscB'); ?> *</span> <?php echo (form_error('descripcion_breve') != '') ? '('.form_error('descripcion_breve', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($tipo_habitacion->descripcion_breve)) ? $tipo_habitacion->descripcion_breve : ''; ?>
						<textarea class='<?php echo (form_error("descripcion_breve") != "") ? "error" : "" ; ?>' name="descripcion_breve" rows="10" cols="50"><?php echo idioma_values(set_value('descripcion_breve'), $temp, $accion); ?></textarea>
						<p style="text-align: right;" id='contador_descbreve'><span class="" id="actual_breve">0</span> <?php echo lang('caracteres_de'); ?> <span>200 </span><?php echo lang('caracteres'); ?></p>
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">

						<label for="descripcion_ampliada">
								<span> <?php echo lang('tipo_habitacion_ficha_dscA'); ?> </span>
						</label>
						<?php if(form_error('descripcion_ampliada') != ''): ?>
							<div class="alert-box alert">
								<?php echo form_error('descripcion_ampliada'); ?>
								<a class="close" href="">×</a>

							</div>
						<?php endif; ?>
						<?php $temp = (isset($tipo_habitacion->descripcion_ampliada)) ? $tipo_habitacion->descripcion_ampliada : ''; ?>
						<textarea class="ckeditor" id="descripcion_ampliada" name="descripcion_ampliada"><?php echo idioma_values(set_value('descripcion_ampliada'), $temp, $accion); ?></textarea>

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<input type="hidden" name="id_tipo_habitacion" value="<?php echo (isset($id_tipo_habitacion)) ? $id_tipo_habitacion : $tipo_habitacion->id_tipo_habitacion; ?>" />
					<?php if (isset($tipo_habitacion->id_detalle_tipo_habitacion) || $accion != 'normal'): ?>

						<input type="hidden" name="id_detalle_tipo_habitacion" value="<?php echo $tipo_habitacion->id_detalle_tipo_habitacion; ?>" />
                       	<?php	//echo '<input type="hidden" name="id_idioma" value="'.$servicio->id_idioma.'" />'; ?>

					<?php endif; ?>
					<div class="row">
						<div class="twelve columns area_botns">
							<button type="submit" class="button radius wtc"> <?php echo ($accion == 'editar') ? lang('idioma_guardar') : lang('idioma_crear'); ?> </button>
						</div>
					</div>
					<?php echo form_hidden('accion', $accion); ?>
				</form>
				<!-- Formulario Formulario Nuevo Idioma tipo habitacion cierre -->
