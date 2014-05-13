<!-- Formulario Nuevo Idioma evento -->
				<?php
                $ni=0;
				
				if($this->session->userdata('idioma') == 'es'):
					echo form_open(lang('backend_url').'/'.lang('eventos_url').'/'.lang('guardar_url').'_'.lang('idioma_url'),'id="gen_form" class="custom"');
				else:
					echo form_open(lang('backend_url').'/'.lang('eventos_url').'/'.lang('guardar_url').'_'.lang('detalles_url'),'id="gen_form" class="custom"');
				endif;
				?>

					<div class="six columns">
						<label for="nombre"  <?php echo (form_error('nombre') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('titulo'); ?> * </span> <?php echo (form_error('nombre') != '') ? '('.form_error('nombre', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input class='<?php echo (form_error("nombre") != "") ? "error" : "" ; ?>' name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($evento->nombre)) ? set_value('nombre') : $evento->nombre);?>" />

						<label for="subtitulo">
							<span> <?php echo lang('subtitulo'); ?> </span>
						</label>
						<input name="subtitulo" type="text" value="<?php echo ((set_value('subtitulo')!='' || !isset($evento->subtitulo)) ? set_value('subtitulo') : $evento->subtitulo);?>" />

						<label for="titulo_pagina" <?php echo (form_error('titulo_pagina') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('eventos_ficha_paginaT'); ?> *</span> <?php echo (form_error('titulo_pagina') != '') ? '('.form_error('titulo_pagina', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <input class='<?php echo (form_error("titulo_pagina") != "") ? "error" : "" ; ?>' name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($evento->titulo_pagina)) ? set_value('titulo_pagina') : $evento->titulo_pagina);?>" />
					</div>


					<div class="six columns">
						<?php if (!isset($evento->id_detalle_evento)): ?>

							<label for="idioma">
								<span> <?php echo lang('idioma_titulo'); ?> </span>
							</label>

							<select class="custom lenguaje_eventos" id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im): ?>
									<option value="<?php echo $im->id_idioma; ?>"<?php

									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($evento->id_idioma) && $evento->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?></option>
								<?php endforeach; ?>
							</select>

						<?php endif; ?>

						<label for="keywords" <?php echo (form_error('keywords') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_pclave'); ?> *</span> <?php echo (form_error('keywords') != '') ? '('.form_error('keywords', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input class="<?php echo (form_error("keywords") != "") ? "error" : "" ; ?>" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($evento->keywords)) ? set_value('keywords') : $evento->keywords);?>" />

						<label for="url" <?php echo (form_error('url') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_url'); ?> *</span> <?php echo (form_error('url') != '') ? '('.form_error('url', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input class="<?php echo (form_error("url") != "") ? "error" : "" ; ?>" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($evento->url)) ? set_value('url') : $evento->url);?>" />

					</div>

					<div class="twelve columns">
						<label for="descripcion_pagina" <?php echo (form_error('descripcion_pagina') != '') ? 'class="error"' : '' ; ?>>
							<span> <?php echo lang('eventos_ficha_paginaD'); ?> *</span> <?php echo (form_error('descripcion_pagina') != '') ? '('.form_error('descripcion_pagina', '<span>', '</span>').')' : '' ; ?>
						</label>
						<textarea class='<?php echo (form_error("descripcion_pagina") != "") ? "error" : "" ; ?>' name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($evento->descripcion_pagina)) ? set_value('descripcion_pagina') : $evento->descripcion_pagina);?></textarea>
					</div>

					<div class="twelve columns">
						<label for="descripcion_breve" <?php echo (form_error('descripcion_breve') != '') ? 'class="error"' : '' ; ?>>
                        		<span> <?php echo lang('eventos_ficha_dscB'); ?> *</span> <?php echo (form_error('descripcion_breve') != '') ? '('.form_error('descripcion_breve', '<span>', '</span>').')' : '' ; ?>
                        </label>
						<textarea class='<?php echo (form_error("descripcion_breve") != "") ? "error" : "" ; ?>' name="descripcion_breve" rows="10" cols="50"><?php echo ((set_value('descripcion_breve')!='' || !isset($evento->descripcion_breve)) ? set_value('descripcion_breve') : $evento->descripcion_breve);?></textarea>
					</div>

					<div class="twelve columns">
						<label for="descripcion_amp">
								<span> <?php echo lang('eventos_ficha_dscA'); ?> </span>
						</label>
						<textarea class="ckeditor" id="descripcion_ampliada" name="descripcion_ampliada" rows="10" cols="50"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($evento->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $evento->descripcion_ampliada);?></textarea>
					</div>

					<input type="hidden" name="id_evento" value="<?php echo (isset($id_evento)) ? $id_evento : $evento->id_evento; ?>" />
					<?php if (isset($evento->id_detalle_evento) || $nuevo!=true): ?>

						<input type="hidden" name="id_detalle_evento" value="<?php echo $evento->id_detalle_evento ?>" />
                       	<?php	echo '<input type="hidden" name="id_idioma" value="'.$evento->id_idioma.'" />'; ?>

					<?php endif; ?>
					<div class="row">
						<div class="twelve columns area_botns">
							<button type="submit" class="button radius wtc"> <?php echo (isset($evento->id_detalle_evento) ? $this->lang->line('idioma_guardar') : $this->lang->line('idioma_crear')) ?> </button>
						</div>
					</div>
				</form>
				<!-- Formulario Formulario Nuevo Idioma evento cierre -->
