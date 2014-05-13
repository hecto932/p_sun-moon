<!-- Formulario Nuevo Idioma noticia -->
				<?php
                $ni=0;


				//echo '<pre>'.print_r($producto,true).'</pre>';
				if (isset($imagen) && !empty($imagen)){
                    $imagen=json_decode($imagen);
					foreach($imagen as $k=>$i){
						if (isset($producto->id_idioma) && $i->id_idioma==$producto->id_idioma)
							$ni=$k;
					}
				}

				echo form_open(lang('backend_url').'/'.lang('noticias_url').'/'.lang('guardar_url').'_'.lang('idioma_url'),'id="gen_form" class="custom"');

				?>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<h3 class = "nuevo_idioma"> <?php echo lang('datos'); ?> </h3>

					<div class="six columns">

						<label for="nombre"  <?php echo (form_error('nombre') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-page"></i>
							<span> <?php echo lang('titulo'); ?> * </span> <?php echo (form_error('nombre') != '') ? '('.form_error('nombre', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input class='<?php echo (form_error("nombre") != "") ? "error" : "" ; ?>' name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($noticia->nombre)) ? set_value('nombre') : $noticia->nombre);?>" />

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="subtitulo">
							<i class="foundicon-add-doc"></i>
							<span> <?php echo lang('subtitulo'); ?> </span>
						</label>
						<input name="subtitulo" type="text" value="<?php echo ((set_value('subtitulo')!='' || !isset($noticia->subtitulo)) ? set_value('subtitulo') : $noticia->subtitulo);?>" />


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="titulo_pagina" <?php echo (form_error('titulo_pagina') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-paper-clip"></i>
                        	<span> <?php echo lang('noticias_ficha_paginaT'); ?> *</span> <?php echo (form_error('titulo_pagina') != '') ? '('.form_error('titulo_pagina', '<span>', '</span>').')' : '' ; ?>
                        </label>
                        <input class='<?php echo (form_error("titulo_pagina") != "") ? "error" : "" ; ?>' name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($noticia->titulo_pagina)) ? set_value('titulo_pagina') : $noticia->titulo_pagina);?>" />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="six columns">
						<?php if (!isset($noticia->id_detalle_noticia)): ?>

							<label for="idioma">
								<i class="foundicon-globe"></i>
								<span> <?php echo lang('idioma_titulo'); ?> </span>
							</label>

							<select class="custom lenguaje_noticias" id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im): ?>
									<option value="<?php echo $im->id_idioma; ?>"<?php

									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($noticia->id_idioma) && $noticia->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?></option>
								<?php endforeach; ?>
							</select>

						<?php endif; ?>

						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

						<label for="keywords" <?php echo (form_error('keywords') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-lock"></i>
							<span> <?php echo lang('noticias_ficha_pclave'); ?> *</span> <?php echo (form_error('keywords') != '') ? '('.form_error('keywords', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input
								class="<?php echo (form_error("keywords") != "") ? "error" : "" ; ?>"
								name="keywords" type="text"
								value="<?php echo ((set_value('keywords') != '' || !isset($noticia->keywords)) ? set_value('keywords') : $noticia->keywords);?>"
							/>


						<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>


						<label for="url" <?php echo (form_error('url') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-website"></i>
							<span> <?php echo lang('noticias_ficha_url'); ?> *</span> <?php echo (form_error('url') != '') ? '('.form_error('url', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input class="<?php echo (form_error("url") != "") ? "error" : "" ; ?>" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($noticia->url)) ? set_value('url') : $noticia->url);?>" />

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_pagina" <?php echo (form_error('descripcion_pagina') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-quote"></i>
							<span> <?php echo lang('noticias_ficha_paginaD'); ?> *</span> <?php echo (form_error('descripcion_pagina') != '') ? '('.form_error('descripcion_pagina', '<span>', '</span>').')' : '' ; ?>
						</label>
						<input type="text" class='<?php echo (form_error("descripcion_pagina") != "") ? "error" : "" ; ?>' name="descripcion_pagina" rows="10" cols="50" value"<?php echo ((set_value('descripcion_pagina')!='' || !isset($noticia->descripcion_pagina)) ? set_value('descripcion_pagina') : $noticia->descripcion_pagina);?>"/>
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">
						<label for="descripcion_breve" <?php echo (form_error('descripcion_breve') != '') ? 'class="error"' : '' ; ?>>
							<i class="foundicon-quote"></i>
                        	<span> <?php echo lang('noticias_ficha_dscB'); ?> *</span> <?php echo (form_error('descripcion_breve') != '') ? '('.form_error('descripcion_breve', '<span>', '</span>').')' : '' ; ?>
                        </label>
						<textarea class='<?php echo (form_error("descripcion_breve") != "") ? "error" : "" ; ?>' id="descripcion_breve" name="descripcion_breve" rows="10" cols="50"><?php echo ((set_value('descripcion_breve')!='' || !isset($noticia->descripcion_breve)) ? set_value('descripcion_breve') : $noticia->descripcion_breve);?></textarea>
					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<div class="twelve columns">

						<label for="descripcion_amp">
							<i class="foundicon-quote"></i>
							<span> <?php echo lang('noticias_ficha_dscA'); ?> </span>
						</label>

						<textarea class="ckeditor" id="descripcion_ampliada" name="descripcion_ampliada" rows="10" cols="50">
							<?php echo ((set_value('descripcion_ampliada')!='' || !isset($noticia->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $noticia->descripcion_ampliada); ?>
						</textarea>

					</div>

					<?php /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/ ?>

					<input type="hidden" name="id_noticia" value="<?php echo (isset($id_noticia)) ? $id_noticia : $noticia->id_noticia; ?>" />
					<?php if (isset($noticia->id_detalle_noticia) || $nuevo!=true): ?>

						<input type="hidden" name="id_detalle_noticia" value="<?php echo $noticia->id_detalle_noticia ?>" />
                       	<?php	echo '<input type="hidden" name="id_idioma" value="'.$noticia->id_idioma.'" />'; ?>

					<?php endif; ?>
					<div class="row">
						<div class="twelve columns area_botns">
							<button type="submit" class="button radius wtc"> <?php echo ($accion == 'editar') ? lang('idioma_guardar') : lang('idioma_crear'); ?> </button>
						</div>
					</div>

					<?php echo form_hidden('accion', $accion); ?>
				</form>
				<!-- Formulario Formulario Nuevo Idioma noticia cierre -->
