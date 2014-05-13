<!-- Formulario Nuevo Idioma banner -->
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
				echo validation_errors();
				echo form_open('banner/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma banner</legend>
							<?php if (!isset($banner->id_detalle_banner)){ ?>
						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($banner->id_idioma) && $banner->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<?php }
							
								?>
						<p>
							<label for="nombre">
								<span>Titulo *</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($banner->nombre)) ? set_value('nombre') : $banner->nombre);?>" />
							</label>
						</p>

                        <p>
							<label for="subtitulo">
								<span>Subtitulo</span>
								<input id="subtitulo" name="subtitulo" type="text" value="<?php echo ((set_value('subtitulo')!='' || !isset($banner->subtitulo)) ? set_value('subtitulo') : $banner->subtitulo);?>" />
							</label>
						</p>
						
						<p>
							<label for="descripcion_breve">
								<span>Descripción Breve *</span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="50"><?php echo ((set_value('descripcion_breve')!='' || !isset($banner->descripcion_breve)) ? set_value('descripcion_breve') : $banner->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span>Descripción Ampliada</span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="50"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($banner->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $banner->descripcion_ampliada);?></textarea>
							</label>

						</p>

						<?php if (isset($imagen[$ni]) && !empty($imagen[$ni])){ ?>
						<p>
							<label for="descripcion_imagen">
								<span>Descripción Imagen</span>
								<textarea id="descripcion_imagen" name="descripcion_imagen" rows="10" cols="50"><?php echo ((set_value('descripcion_imagen')!='' || !isset($imagen[$ni]->descripcion_multimedia)) ? set_value('descripcion_imagen') : $imagen[$ni]->descripcion_multimedia);?></textarea>
							</label>
							<input id="descripcion_imagen_id" name="descripcion_imagen_id" type="hidden" value="<?php echo $imagen[$ni]->id_multimedia?>" />
							<input id="id_detalle_multimedia" name="id_detalle_multimedia" type="hidden" value="<?php echo $imagen[$ni]->id_detalle_multimedia?>" />
						</p>
						<?php } ?>
						
						<!-- 
                        <p>
                              <label for="url">
                                   <span>URL *</span>
                                   <input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($banner->url)) ? set_value('url') : $banner->url);?>" />
                               </label>
                        </p>
                        <p>
							<label for="tit_pag">
								<span>Título Página *</span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($banner->titulo_pagina)) ? set_value('titulo_pagina') : $banner->titulo_pagina);?>" />
							</label>
						</p>
                        <p>
							<label for="descripcion_pagina">
								<span>Descripción pagina *</span>
								<textarea id="descripcion_pagina" name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($banner->descripcion_pagina)) ? set_value('descripcion_pagina') : $banner->descripcion_pagina);?></textarea>
							</label>

						</p>
                        <p>
                              <label for="keywords">
                                   <span>Palabras clave *</span>
                                   <input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($banner->keywords)) ? set_value('keywords') : $banner->keywords);?>" />
                               </label>
                        </p>
						 -->
						 	
						<input type="hidden" name="id_banner" value="<?php if (isset($id_banner)) echo $id_banner;
						else echo $banner->id_banner?>" />
						<?php if (isset($banner->id_detalle_banner) || $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_banner" value="<?php echo $banner->id_detalle_banner ?>" />


                        <?php
								//$idi=json_decode(modules::run('services/relations/get_from_id','idioma',$banner->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$banner->id_idioma.'" />';
						} ?>

						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($banner->id_detalle_banner) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma banner cierre -->
