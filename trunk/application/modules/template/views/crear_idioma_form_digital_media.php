<!-- Formulario Nuevo Idioma digital_media -->
				<?php
				
				
				echo validation_errors();
				echo form_open_multipart('digital_media/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend> <?php echo lang('idioma_crear'); ?> </legend>

						<p>
					
							<label for="idioma">
								<span> <?php echo lang('digital_media_ficha_idioma'); ?>  </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma', $im->id_idioma);
									elseif ($nuevo != true)
										echo (isset($digital_media->id_idioma) && $digital_media->id_idioma == $im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span> <?php echo lang('digital_media_ficha_nombre'); ?> </span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($digital_media->nombre)) ? set_value('nombre') : $digital_media->nombre);?>" />
							</label>
						</p>
						
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('digital_media_ficha_descB'); ?> </span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($digital_media->descripcion_breve)) ? set_value('descripcion_breve') : $digital_media->descripcion_breve);?></textarea>
							</label>
						</p>
						
						<p>
							<label for="descripcion_amp">
								<span> <?php echo lang('digital_media_ficha_descA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($digital_media->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $digital_media->descripcion_ampliada);?></textarea>
							</label>
						</p>
						
						<p>
							<label for="keywords">
								<span> <?php echo lang('digital_media_ficha_pclave'); ?> </span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($digital_media->keywords)) ? set_value('keywords') : $digital_media->keywords);?>" />
							</label>
						</p>
						
						<input type="hidden" name="id_digital_media" value="<?php if (isset($id_digital_media)) echo $id_digital_media;	else echo (isset($digital_media)) ? $digital_media->id_digital_media : $digital_media->id_digital_media;  ?>" />
						<?php if (isset($digital_media->id_detalle_digital_media) && $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_digital_media" value="<?php echo $digital_media->id_detalle_digital_media ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$digital_media->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($digital_media->id_detalle_digital_media) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma digital_media cierre -->
