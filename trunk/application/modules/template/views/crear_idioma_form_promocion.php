<!-- Formulario Nuevo Idioma promocion -->
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
				echo form_open('promocion/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma promocion</legend>
							<?php if (!isset($promocion->id_detalle_promocion)){ ?>
						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($promocion->id_idioma) && $promocion->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<?php }
							
								?>
						<p>
							<label for="nombre">
								<span>Titulo *</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($promocion->nombre)) ? set_value('nombre') : $promocion->nombre);?>" />
							</label>
						</p>

                        <p>
							<label for="subtitulo">
								<span>Subtitulo</span>
								<input id="subtitulo" name="subtitulo" type="text" value="<?php echo ((set_value('subtitulo')!='' || !isset($promocion->subtitulo)) ? set_value('subtitulo') : $promocion->subtitulo);?>" />
							</label>
						</p>
						
						<p>
							<label for="descripcion_breve">
								<span>Descripción Breve *</span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="50"><?php echo ((set_value('descripcion_breve')!='' || !isset($promocion->descripcion_breve)) ? set_value('descripcion_breve') : $promocion->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span>Descripción Ampliada</span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="50"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($promocion->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $promocion->descripcion_ampliada);?></textarea>
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
                        <p>
                              <label for="url">
                                   <span>URL *</span>
                                   <input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($promocion->url)) ? set_value('url') : $promocion->url);?>" />
                               </label>
                        </p>
                        <p>
							<label for="tit_pag">
								<span>Título Página *</span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($promocion->titulo_pagina)) ? set_value('titulo_pagina') : $promocion->titulo_pagina);?>" />
							</label>
						</p>
                        <p>
							<label for="descripcion_pagina">
								<span>Descripción pagina *</span>
								<textarea id="descripcion_pagina" name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($promocion->descripcion_pagina)) ? set_value('descripcion_pagina') : $promocion->descripcion_pagina);?></textarea>
							</label>

						</p>
                        <p>
                              <label for="keywords">
                                   <span>Palabras clave *</span>
                                   <input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($promocion->keywords)) ? set_value('keywords') : $promocion->keywords);?>" />
                               </label>
                        </p>

						<input type="hidden" name="id_promocion" value="<?php if (isset($id_promocion)) echo $id_promocion;
						else echo $promocion->id_promocion?>" />
						<?php if (isset($promocion->id_detalle_promocion) || $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_promocion" value="<?php echo $promocion->id_detalle_promocion ?>" />


                        <?php
								//$idi=json_decode(modules::run('services/relations/get_from_id','idioma',$promocion->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$promocion->id_idioma.'" />';
						} ?>

						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($promocion->id_detalle_promocion) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma promocion cierre -->
