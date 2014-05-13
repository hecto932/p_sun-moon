<!-- Formulario Nuevo Idioma canal -->
				<?php
				$ni=0;
				
				$imagen=json_decode($imagen);
				//echo '<pre>'.print_r($canal,true).'</pre>';
				if (isset($imagen) && !empty($imagen)){
					foreach($imagen as $k=>$i){
						if (isset($canal->id_idioma) && $i->id_idioma==$canal->id_idioma)
							$ni=$k;
					}
				}
				
				echo validation_errors();
				echo form_open_multipart('canales/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend> <?php echo lang('idioma_crear'); ?> </legend>

						<p>
					
							<label for="idioma">
								<span> <?php echo lang('canal_ficha_idioma'); ?>  </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma', $im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($canales->id_idioma) && $canales->id_idioma == $im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span> <?php echo lang('canal_ficha_nombre'); ?> </span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($canales->nombre)) ? set_value('nombre') : $canales->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="info_canal">
								<span> <?php echo lang('canal_ficha_info'); ?> </span>
								<textarea id="info_canal" name="info_canal" rows="10" cols="100"><?php echo ((set_value('info_canal')!='' || !isset($canales->info_canal)) ? set_value('info_canal') : $canales->info_canal);?></textarea>
							</label>
						</p>
						
						
						<p>
							<label for="objetivo">
								<span> <?php echo lang('canal_ficha_objetivo'); ?> </span>
								<input id="objetivo" name="objetivo" type="text" value="<?php echo ((set_value('objetivo')!='' || !isset($canales->objetivo)) ? set_value('objetivo') : $canales->objetivo);?>" />
							</label>
						</p>
						
						
						<p>
							<label for="genero">
								<span> <?php echo lang('canal_ficha_genero'); ?> </span>
								<input id="genero" name="genero" type="text" value="<?php echo ((set_value('genero')!='' || !isset($canales->genero)) ? set_value('genero') : $canales->genero);?>" />
							</label>
						</p>
						
						<p>
							<label for="dist_redes_sociales">
								<span> <?php echo lang('canal_ficha_redes_sociales'); ?> </span>
								<input id="dist_redes_sociales" name="dist_redes_sociales" type="text" value="<?php echo ((set_value('dist_redes_sociales')!='' || !isset($canales->dist_redes_sociales)) ? set_value('dist_redes_sociales') : $canales->dist_redes_sociales);?>" />
							</label>
						</p>
						
						<p>
							<label for="encuestas">
								<span> <?php echo lang('canal_ficha_encuestas'); ?> </span>
								<input id="encuestas" name="encuestas" type="text" value="<?php echo ((set_value('encuestas')!='' || !isset($canales->encuestas)) ? set_value('encuestas') : $canales->encuestas);?>" />
							</label>
						</p>
						
						<p>
							<label for="en_pantalla">
								<span> <?php echo lang('canal_ficha_en_pantalla'); ?> </span>
								<input id="en_pantalla" name="en_pantalla" type="text" value="<?php echo ((set_value('en_pantalla')!='' || !isset($canales->en_pantalla)) ? set_value('en_pantalla') : $canales->en_pantalla);?>" />
							</label>
						</p>
						
						<p>
							<label for="investigacion">
								<span> <?php echo lang('canal_ficha_investigacion'); ?> </span>
								<input id="investigacion" name="investigacion" type="text" value="<?php echo ((set_value('investigacion')!='' || !isset($canales->investigacion)) ? set_value('investigacion') : $canales->investigacion);?>" />
							</label>
						</p>
						<p>
							<label for="contenido_televidente">
								<span> <?php echo lang('canal_ficha_ctelevidente'); ?> </span>
								<input id="contenido_televidente" name="contenido_televidente" type="text" value="<?php echo ((set_value('contenido_televidente')!='' || !isset($canales->contenido_televidente)) ? set_value('contenido_televidente') : $canales->contenido_televidente);?>" />
							</label>
						</p>
						<p>
							<label for="alcance_twitter">
								<span> <?php echo lang('canal_ficha_alcance_twitter'); ?> </span>
								<input id="alcance_twitter" name="alcance_twitter" type="text" value="<?php echo ((set_value('alcance_twitter')!='' || !isset($canales->alcance_twitter)) ? set_value('alcance_twitter') : $canales->alcance_twitter);?>" />
							</label>
						</p>
						
						<p>
							<label for="alcance_facebook">
								<span> <?php echo lang('canal_ficha_alcance_facebook'); ?> </span>
								<input id="alcance_facebook" name="alcance_facebook" type="text" value="<?php echo ((set_value('alcance_facebook')!='' || !isset($canales->alcance_facebook)) ? set_value('alcance_facebook') : $canales->alcance_facebook);?>" />
							</label>
						</p>
						
						<p>
							<label for="alcance_youtube">
								<span> <?php echo lang('canal_ficha_alcance_facebook'); ?> </span>
								<input id="alcance_youtube" name="alcance_youtube" type="text" value="<?php echo ((set_value('alcance_youtube')!='' || !isset($canales->alcance_youtube)) ? set_value('alcance_youtube') : $canales->alcance_youtube);?>" />
							</label>
						</p>
						
						<p>
							<label for="alcance_web">
								<span> <?php echo lang('canal_ficha_alcance_web'); ?> </span>
								<input id="alcance_web" name="alcance_web" type="text" value="<?php echo ((set_value('alcance_web')!='' || !isset($canales->alcance_web)) ? set_value('alcance_web') : $canales->alcance_web);?>" />
							</label>
						</p>
						
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('canal_ficha_descB'); ?> </span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($canales->descripcion_breve)) ? set_value('descripcion_breve') : $canales->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span> <?php echo lang('canal_ficha_descA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($canales->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $canales->descripcion_ampliada);?></textarea>
							</label>
						</p>
						
						
						<p>
							<label for="url">
								<span>URL</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($canales->url)) ? set_value('url') : $canales->url);?>" />
							</label>
						</p>
						<p>
							<label for="tit_pag">
								<span> <?php echo lang('canal_ficha_paginaT'); ?> </span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($canales->titulo_pagina)) ? set_value('titulo_pagina') : $canales->titulo_pagina);?>" />
							</label>
						</p>
		
						<p>
							<label for="keywords">
								<span> <?php echo lang('canal_ficha_pclave'); ?> </span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($canales->keywords)) ? set_value('keywords') : $canales->keywords);?>" />
							</label>
						</p>
						


						<input type="hidden" name="id_canal" value="<?php if (isset($id_canal)) echo $id_canal;	else echo (isset($canal)) ? $canal->id_canal : $canales->id_canal;  ?>" />
						<?php if (isset($canales->id_detalle_canal) && $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_canal" value="<?php echo $canales->id_detalle_canal ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$canales->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($canales->id_detalle_canal) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma canal cierre -->
