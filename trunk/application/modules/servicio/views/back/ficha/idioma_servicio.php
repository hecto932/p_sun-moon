<!-- Formulario Nuevo Idioma servicio -->

				<?php echo form_open(lang('backend_url').'/'.lang('servicios_url').'/'.lang('guardar_url').'_'.lang('idioma_url'),'id="gen_form" class="custom"'); ?>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">

						<label for="nombre"  <?php echo (form_error('nombre') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('titulo'); ?> * </span> <?php echo (form_error('nombre') != '') ? '('.form_error('nombre', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($servicio->nombre)) ? $servicio->nombre : ''; ?>
						<input class='<?php echo (form_error("nombre") != "") ? "error" : "" ; ?>' name="nombre" type="text" value="<?php echo idioma_values(set_value('nombre'), $temp, $accion); ?>" />

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="subtitulo">
							<span> <?php echo lang('subtitulo'); ?> </span>
						</label>
						<?php $temp = (isset($servicio->subtitulo)) ? $servicio->subtitulo : ''; ?>
						<input name="subtitulo" type="text" value="<?php echo idioma_values(set_value('subtitulo'), $temp, $accion); ?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="titulo_pagina" <?php echo (form_error('titulo_pagina') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('servicios_ficha_paginaT'); ?> *</span> <?php echo (form_error('titulo_pagina') != '') ? '('.form_error('titulo_pagina', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($servicio->titulo_pagina)) ? $servicio->titulo_pagina : ''; ?>
                        <input class='<?php echo (form_error("titulo_pagina") != "") ? "error" : "" ; ?>' name="titulo_pagina" type="text" value="<?php echo idioma_values(set_value('titulo_pagina'), $temp, $accion); ?>" />

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
											echo ((isset($servicio->id_idioma) && $servicio->id_idioma==$im->id_idioma) ? ' selected="selected"' : '')?>><?php echo lang(strtolower($im->nombre)) ?></option>
									<?php endforeach; ?>

							</select>

						<?php //endif; ?>

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="keywords" <?php echo (form_error('keywords') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('servicios_ficha_pclave'); ?> *</span> <?php echo (form_error('keywords') != '') ? '('.form_error('keywords', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($servicio->keywords)) ? $servicio->keywords : ''; ?>
						<input class="<?php echo (form_error("keywords") != "") ? "error" : "" ; ?>" name="keywords" type="text" value="<?php echo idioma_values(set_value('keywords'), $temp, $accion); ?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="url" <?php echo (form_error('url') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('servicios_ficha_url'); ?> *</span> <?php echo (form_error('url') != '') ? '('.form_error('url', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($servicio->url)) ? $servicio->url : ''; ?>
						<input class="<?php echo (form_error("url") != "") ? "error" : "" ; ?>" name="url" type="text" value="<?php echo idioma_values(set_value('url'), $temp, $accion) ; ?>" />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_pagina" <?php echo (form_error('descripcion_pagina') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('servicios_ficha_paginaD'); ?> *</span> <?php echo (form_error('descripcion_pagina') != '') ? '('.form_error('descripcion_pagina', '<span>', '</span>').')' : '' ; ?>
						</label>
						<?php $temp = (isset($servicio->descripcion_pagina)) ? $servicio->descripcion_pagina : ''; ?>
						<input type="text" class='<?php echo (form_error("descripcion_pagina") != "") ? "error" : "" ; ?>' name="descripcion_pagina" rows="10" cols="50" value="<?php echo idioma_values(set_value('descripcion_pagina'), $temp, $accion); ?>" />
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_breve" <?php echo (form_error('descripcion_breve') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('servicios_ficha_dscB'); ?> *</span> <?php echo (form_error('descripcion_breve') != '') ? '('.form_error('descripcion_breve', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <?php $temp = (isset($servicio->descripcion_breve)) ? $servicio->descripcion_breve : ''; ?>
						<textarea class='<?php echo (form_error("descripcion_breve") != "") ? "error" : "" ; ?>' name="descripcion_breve" rows="10" cols="50"><?php echo idioma_values(set_value('descripcion_breve'), $temp, $accion); ?></textarea>
						<p style="text-align: right;" id='contador_descbreve'><span class="" id="actual_breve">0</span> <?php echo lang('caracteres_de'); ?> <span>200 </span><?php echo lang('caracteres'); ?></p>
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">

						<label for="descripcion_ampliada">
								<span> <?php echo lang('servicios_ficha_dscA'); ?> </span>
						</label>
						<?php if(form_error('descripcion_ampliada') != ''): ?>
							<div class="alert-box alert">
								<?php echo form_error('descripcion_ampliada'); ?>
								<a class="close" href="">×</a>

							</div>
						<?php endif; ?>
						<?php $temp = (isset($servicio->descripcion_ampliada)) ? $servicio->descripcion_ampliada : ''; ?>
						<textarea class="ckeditor" id="descripcion_ampliada" name="descripcion_ampliada"><?php echo idioma_values(set_value('descripcion_ampliada'), $temp, $accion); ?></textarea>

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<input type="hidden" name="id_servicio" value="<?php echo (isset($id_servicio)) ? $id_servicio : $servicio->id_servicio; ?>" />
					<?php if (isset($servicio->id_detalle_servicio) || $accion != 'normal'): ?>

						<input type="hidden" name="id_detalle_servicio" value="<?php echo $servicio->id_detalle_servicio ?>" />
                       	<?php	//echo '<input type="hidden" name="id_idioma" value="'.$servicio->id_idioma.'" />'; ?>

					<?php endif; ?>
					<div class="row">
						<div class="twelve columns area_botns">
							<button type="submit" class="button radius wtc"> <?php echo ($accion == 'editar') ? lang('idioma_guardar') : lang('idioma_crear'); ?> </button>
						</div>
					</div>
					<?php echo form_hidden('accion', $accion); ?>
				</form>
				<!-- Formulario Formulario Nuevo Idioma servicio cierre -->
