<!-- Formulario Nuevo Idioma proyecto -->
				<?php
				$ni=0;
				
				$imagen=json_decode($imagen);
				//echo '<pre>'.print_r($proyecto,true).'</pre>';
				if (isset($imagen) && !empty($imagen)){
					foreach($imagen as $k=>$i){
						if (isset($proyecto->id_idioma) && $i->id_idioma==$proyecto->id_idioma)
							$ni=$k;
					}
				}
				
				echo validation_errors();
				echo form_open_multipart('proyecto/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend> <?php echo lang('idioma_crear'); ?> </legend>

						<p>
					
							<label for="idioma">
								<span> <?php echo lang('proyecto_ficha_idioma'); ?>  </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma', $im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($proyecto->id_idioma) && $proyecto->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span> <?php echo lang('proyecto_ficha_nombre'); ?> </span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($proyecto->nombre)) ? set_value('nombre') : $proyecto->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('proyecto_ficha_descB'); ?> </span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($proyecto->descripcion_breve)) ? set_value('descripcion_breve') : $proyecto->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span> <?php echo lang('proyecto_ficha_descA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($proyecto->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $proyecto->descripcion_ampliada);?></textarea>
							</label>
						</p>
						
						<p>
							<label for="alcance_breve">
								<span> <?php echo lang('proyecto_ficha_alcB'); ?> </span>
								<textarea id="alcance_breve" name="alcance_breve" rows="10" cols="100"><?php echo ((set_value('alcance_breve')!='' || !isset($proyecto->alcance_breve)) ? set_value('alcance_breve') : $proyecto->alcance_breve);?></textarea>
							</label>
						</p>
						
						<p>
							<label for="alcance_ampliado">
								<span> <?php echo lang('proyecto_ficha_alcA'); ?> </span>
								<textarea id="alcance_ampliado" name="alcance_ampliado" rows="10" cols="100"><?php echo ((set_value('alcance_ampliado')!='' || !isset($proyecto->alcance_ampliado)) ? set_value('alcance_ampliado') : $proyecto->alcance_ampliado);?></textarea>
							</label>
						</p>
						
						<p>
							<label for="url">
								<span>URL</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($proyecto->url)) ? set_value('url') : $proyecto->url);?>" />
							</label>
						</p>
						<p>
							<label for="tit_pag">
								<span> <?php echo lang('proyecto_ficha_paginaT'); ?> </span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($proyecto->titulo_pagina)) ? set_value('titulo_pagina') : $proyecto->titulo_pagina);?>" />
							</label>
						</p>
		
						<p>
							<label for="keywords">
								<span> <?php echo lang('proyecto_ficha_pclave'); ?> </span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($proyecto->keywords)) ? set_value('keywords') : $proyecto->keywords);?>" />
							</label>
						</p>
						


						<input type="hidden" name="id_proyecto" value="<?php if (isset($id_proyecto)) echo $id_proyecto;
						else echo $proyecto->id_proyecto?>" />
						<?php if (isset($proyecto->id_detalle_proyecto) && $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_proyecto" value="<?php echo $proyecto->id_detalle_proyecto ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$proyecto->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($proyecto->id_detalle_proyecto) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma proyecto cierre -->
