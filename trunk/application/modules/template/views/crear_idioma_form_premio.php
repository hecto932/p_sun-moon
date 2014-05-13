<!-- Formulario Nuevo Idioma premio -->
				<?php
				$ni = 0;				
				echo validation_errors();
				echo form_open_multipart(lang('backend_url').'/'.lang('premios_url').'/'.lang('guardar_url').'_'.lang('detalles_url'),'id="gen_form" class="idioma"')?>
					<fieldset>
						<legend> <?php echo lang('idioma_crear'); ?> </legend>

						<p>
					
							<label for="idioma">
								<span> <?php echo lang('premio_ficha_idioma'); ?>  </span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im): ?>
									<option value="<?php echo $im->id_idioma; ?>" 
									
									<?php if (set_select('id_idioma',$im->id_idioma) != ''): ?>
										<?php echo set_select('id_idioma', $im->id_idioma); ?>
									<?php else: ?>
										<?php if($nuevo != true): ?>
											<?php echo (isset($premio->id_idioma) && $premio->id_idioma == $im->id_idioma ? ' selected="selected"' : '')?>><?php echo lang($im->nombre) ?>
										</option>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span> <?php echo lang('premio_ficha_nombre'); ?> </span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($premio->nombre)) ? set_value('nombre') : $premio->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_breve">
								<span> <?php echo lang('premio_ficha_descB'); ?> </span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($premio->descripcion_breve)) ? set_value('descripcion_breve') : $premios->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="descripcion_amp">
								<span> <?php echo lang('premio_ficha_descA'); ?> </span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($premio->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $premios->descripcion_ampliada);?></textarea>
							</label>
						</p>
						<p>
							<label for="keywords">
								<span> <?php echo lang('premio_ficha_pclave'); ?> </span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($premio->keywords)) ? set_value('keywords') : $premio->keywords);?>" />
							</label>
						</p>
						


						<input type="hidden" name="id_premio" value="<?php if (isset($id_premio)) echo $id_premio;	else echo (isset($premio)) ? $premio->id_premio : $premio->id_premio;  ?>" />
						<?php if (isset($premio->id_detalle_premio) && $nuevo!=true): ?>
								<input type="hidden" name="id_detalle_premio" value="<?php echo $premio->id_detalle_premio ?>" />

						<?php 
								$id = json_decode(modules::run('services/relations/get_from_id','idioma',$premio->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
								endif;
						 ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($premio->id_detalle_premio) ? lang('idioma_guardar') : lang('idioma_crear'))?> </button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma premio cierre -->
