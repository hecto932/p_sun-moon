<!-- Formulario Nuevo Idioma FAQ -->
				<?php

				echo validation_errors();
				echo form_open('faq/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma artista</legend>
							<?php if (!isset($artista->id_detalle_artista)){ ?>
						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($artista->id_idioma) && $artista->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<?php }
							
								?>
						<p>
							<label for="nombre">
								<span>Nombre</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($artista->nombre)) ? set_value('nombre') : $artista->nombre);?>" />
							</label>
						</p>
						
						<p>
							<label for="descripcion">
								<span>Descripción</span>
								<textarea id="descripcion" name="descripcion" rows="10" cols="50"><?php echo ((set_value('descripcion')!='' || !isset($artista->descripcion)) ? set_value('descripcion') : $artista->descripcion);?></textarea>
							</label>
						</p>
						

						<input type="hidden" name="id_faq" value="<?php if (isset($id_faq)) echo $id_faq;
						else echo $faq->id_faq?>" />
						<?php if (isset($faq->id_detalle_faq)){ ?>
						<input type="hidden" name="id_detalle_faq" value="<?php echo $faq->id_detalle_faq ?>" />

						<?php 
								//$id=json_decode(modules::run('services/relations/get_from_id','idioma',$artista->id_idioma,'true'));
								//echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($faq->id_detalle_faq) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma FAQ cierre -->
