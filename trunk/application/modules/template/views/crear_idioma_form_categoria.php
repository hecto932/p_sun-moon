<!-- Formulario Nuevo Idioma Obra -->
				<?php
				$ni=0;

				if (isset($imagen) && !empty($imagen)){
					$imagen=json_decode($imagen);
					foreach($imagen as $k=>$i){
						if (isset($obra->id_idioma) && $i->id_idioma==$obra->id_idioma)
							$ni=$k;
					}
				}
				
				echo (validation_errors()!='' ? '<div class="error">'.validation_errors().'</div>' : '');
				echo form_open('categoria/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma Categoria</legend>
							<?php if (isset($nuevo) && $nuevo==true && !isset($categoria->id_detalle_categoria)){ ?>
						<p>
					
							<label for="idioma">
								<span> <?php echo lang('idioma_titulo'); ?> </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php echo (isset($categoria->id_idioma) && $categoria->id_idioma==$im->id_idioma) ? ' selected="selected"' : ''?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
						</p>
						<?php }
							
								?>
						<p>
							<label for="nombre">
								<span> <?php echo lang('categoria_fic_nom'); ?> *</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($categoria->nombre)) ? set_value('nombre') : $categoria->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('categoria_fic_dscB'); ?> *</span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="50"><?php echo ((set_value('descripcion_breve')!='' || !isset($categoria->descripcion_breve)) ? set_value('descripcion_breve') : $categoria->descripcion_breve);?></textarea>
							</label>

						</p>
                        <p>
							<label for="descripcion_amp">
								<span> <?php echo lang('categoria_fic_dscA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="50"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($categoria->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $categoria->descripcion_ampliada);?></textarea>
							</label>
                          <!--   <span class="info">Con el tag &lt;columna&gt; cambiara de columna</span>  -->
						</p>

						<?php if (isset($imagen[$ni]) && !empty($imagen[$ni])){ ?>
						<p>
							<label for="descripcion_imagen">
								<span> <?php echo lang('categoria_fic_dscI'); ?> </span>
								<textarea id="descripcion_imagen" name="descripcion_imagen" rows="10" cols="50"><?php echo ((set_value('descripcion_imagen')!='' || !isset($imagen[$ni]->descripcion_multimedia)) ? set_value('descripcion_imagen') : $imagen[$ni]->descripcion_multimedia);?></textarea>
							</label>
							<input id="descripcion_imagen_id" name="descripcion_imagen_id" type="hidden" value="<?php echo $imagen[$ni]->id_multimedia?>" />
							<input id="id_detalle_multimedia" name="id_detalle_multimedia" type="hidden" value="<?php echo $imagen[$ni]->id_detalle_multimedia?>" />
						</p>
						<?php } ?>
						<p>
							<label for="url">
								<span> <?php echo lang('categoria_fic_url'); ?> *</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($categoria->url)) ? set_value('url') : $categoria->url);?>" />
							</label>
						</p>
						<p>
							<label for="titulo_pagina">
								<span> <?php echo lang('categoria_fic_pagT'); ?> *</span>
								<input id="titulo_pagina" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($categoria->titulo_pagina)) ? set_value('titulo_pagina') : $categoria->titulo_pagina);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_pagina">
								<span> <?php echo lang('categoria_fic_pagD'); ?> *</span>
								<textarea id="descripcion_pagina" name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($categoria->descripcion_pagina)) ? set_value('descripcion_pagina') : $categoria->descripcion_pagina);?></textarea>
							</label>
						</p>
                        <p>
							<label for="keywords">
								<span> <?php echo lang('categoria_fic_pclave'); ?> *</span>
								<input type="text" id="keywords" name="keywords" rows="10" value="<?php echo ((set_value('keywords')!='' || !isset($categoria->keywords)) ? set_value('keywords') : $categoria->keywords);?>" />
							</label>
						</p>
						<input type="hidden" name="id_categoria" value="<?php if (isset($id_categoria)) echo $id_categoria;
						else echo $categoria->id_categoria?>" />
						<?php if ((!isset($nuevo) || $nuevo!=true) && isset($categoria->id_detalle_categoria)){ ?>
						<input type="hidden" name="id_detalle_categoria" value="<?php echo $categoria->id_detalle_categoria ?>" />

						<?php 
								//$id=json_decode(modules::run('services/relations/get_from_id','idioma',$categoria->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$categoria->id_idioma.'" />';
						}
                        if ($this->input->post('id_idioma')) echo '<input type="hidden" name="id_idioma" value="'.$this->input->post('id_idioma').'" />';?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo ((!isset($nuevo) || $nuevo!=true) && isset($categoria->id_detalle_categoria) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma Obra cierre -->
