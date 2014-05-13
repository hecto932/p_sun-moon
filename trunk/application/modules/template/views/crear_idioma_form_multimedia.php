<!-- Formulario Nuevo Idioma Multimedia -->
				<?php

				echo validation_errors();
				echo form_open('multimedia/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma Multimedia</legend>

						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($multimedia->id_idioma) && $multimedia->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span>Nombre</span>
								<input id="nombre" name="nombre_multimedia" type="text" value="<?php echo ((set_value('nombre_multimedia')!='' || !isset($multimedia->nombre_multimedia)) ? set_value('nombre_multimedia') : $multimedia->nombre_multimedia);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_multimedia">
								<span>Descripción</span>
								<textarea id="descripcion_multimedia" name="descripcion_multimedia" rows="10" cols="50"><?php echo ((set_value('descripcion_multimedia')!='' || !isset($multimedia->descripcion_multimedia)) ? set_value('descripcion_multimedia') : $multimedia->descripcion_multimedia);?></textarea>
							</label>
						</p>

						<p>
							<label for="url">
								<span>URL (xxx_yyy_zzz)</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($multimedia->url)) ? set_value('url') : $multimedia->url);?>" />
							</label>
						</p>
						<p>
							<label for="tit_pag">
								<span>Título Página</span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($multimedia->titulo_pagina)) ? set_value('titulo_pagina') : $multimedia->titulo_pagina);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_pag">
								<span>Descripción Página</span>
								<textarea id="descripcion_pag" name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($multimedia->descripcion_pagina)) ? set_value('descripcion_pagina') : $multimedia->descripcion_pagina);?></textarea>
							</label>
						</p>
						<p>
							<label for="keywords">
								<span>Palabras clave (xx, yy, ...)</span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($multimedia->keywords)) ? set_value('keywords') : $multimedia->keywords);?>" />
							</label>
						</p>
						<?php
						/*<p class="inputCheckbox">
							<label for="destacado">
								<input id="destacado" name="destacado" type="checkbox" />
								<span>Destacado</span>
							</label>
						</p>
						* */ ?>

						<p>
							<label for="tagsSugerencia">
								<span>Tags</span>
								<input id="tagsSugerencia" name="tagsSugerencia" type="text" />
								<button type="submit" id="addTag">OK</button>
							</label>
														
						</p>
<?php 			
$t=array();
if (isset($multimedia->id_detalle_multimedia)){
				$tags=json_decode(modules::run('services/relations/get_rel','detalle_multimedia','tag',$multimedia->id_detalle_multimedia,'true'),true);
				
				if (!empty($tags)){
					foreach($tags as $tag){
						$t[]=$tag['tag'];
						//echo '<li>'.$tag['tag'].' <span>&#10008;</span></li>';
					}
					$lista_tags=implode(', ',$t);
				}else{
					$lista_tags='';
				}
					?>
					<?php } ?>
						<ul id="previewTags">
							<?php foreach($t as $tag_name){
								echo '<li>'.$tag_name.'<span rel="'.$tag_name.'">&#10008;</span></li>';
							}
							?>
							<!--
							aqui se tiene que cargar los tags que ya tiene relacionados y luego se van añadiendo/quitando el resto
							<li>(nombreTag)<span rel="(nombreTag)">&#10008;</span></li>
							-->
						</ul>
						
						<select id="tags" name="tags[]" multiple="multiple" class="multiple">
						<?php foreach($t as $tag_name){
								echo '<option selected="selected" value="'.$tag_name.'">'.$tag_name.'</option>';
							}
							?>
						</select>


						<input type="hidden" name="id_multimedia" value="<?php if (isset($id_multimedia)) echo $id_multimedia;
						else echo $multimedia->id_multimedia?>" />
						<?php if (isset($multimedia->id_detalle_multimedia)){ ?>
						<input type="hidden" name="id_detalle_multimedia" value="<?php echo $multimedia->id_detalle_multimedia ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$multimedia->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($multimedia->id_detalle_multimedia) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma Multimedia cierre -->
