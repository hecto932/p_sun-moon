<!-- Formulario Nuevo Idioma trabajo -->
				<?php
					$ni = 0;
					echo validation_errors();
					echo form_open_multipart(lang('backend_url').'/'.lang('trabajos_url').'/'.lang('guardar_url').'_'.lang('idioma_url'),'id="gen_form" class="idioma"');
				?>
					<fieldset>
						<legend> <?php echo lang('idioma_crear'); ?> </legend>
						<input id = "lugar_trabajo" name="lugar_trabajo" type="hidden" value="<?php echo (isset($lugar_trabajo)) ? $lugar_trabajo->nombre_lugar : '' ?>">
						
						<p>
					
							<label for="idioma">
								<span> <?php echo lang('trabajo_ficha_idioma'); ?>  </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im): ?>
									<option value="<?php echo $im->id_idioma; ?>"
								 
									<?php	
										if (set_select('id_idioma',$im->id_idioma) != '')
											echo set_select('id_idioma', $im->id_idioma);
										elseif ($nuevo!=true)
											echo (isset($trabajo->id_idioma) && $trabajo->id_idioma==$im->id_idioma ? ' selected="selected"' : '')
									?>>
									<?php echo lang($im->nombre) ?></option>
								<?php endforeach; ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span> <?php echo lang('trabajo_ficha_nombre'); ?> </span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($trabajo->nombre)) ? set_value('nombre') : $trabajo->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('trabajo_ficha_descB'); ?> </span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($trabajo->descripcion_breve)) ? set_value('descripcion_breve') : $trabajo->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span> <?php echo lang('trabajo_ficha_descA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($trabajo->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $trabajo->descripcion_ampliada);?></textarea>
							</label>
						</p>												
						<p>
							<label for="url">
								<span>URL</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($trabajo->url)) ? set_value('url') : $trabajo->url);?>" />
							</label>
						</p>
						<p>
							<label for="tit_pag">
								<span> <?php echo lang('trabajo_ficha_paginaT'); ?> </span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($trabajo->titulo_pagina)) ? set_value('titulo_pagina') : $trabajo->titulo_pagina);?>" />
							</label>
						</p>
		
						<p>
							<label for="keywords">
								<span> <?php echo lang('trabajo_ficha_pclave'); ?> </span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($trabajo->keywords)) ? set_value('keywords') : $trabajo->keywords);?>" />
							</label>
						</p>
						


						<input type="hidden" name="id_trabajo" value="<?php if (isset($id_trabajo)) echo $id_trabajo;
						else echo $trabajo->id_trabajo?>" />
						<?php if (isset($trabajo->id_detalle_trabajo) && $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_trabajo" value="<?php echo $trabajo->id_detalle_trabajo ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$trabajo->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($trabajo->id_detalle_trabajo) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma trabajo cierre -->
