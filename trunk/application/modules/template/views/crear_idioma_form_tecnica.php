<!-- Formulario Nuevo Idioma Obra -->
				<?php
				echo form_open('tecnica/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma Tecnica</legend>
							<?php if (!isset($tecnica->id_detalle_tecnica)){ ?>
						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php echo (isset($tecnica->id_idioma) && $tecnica->id_idioma==$im->id_idioma) ? ' selected="selected"' : ''?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
						</p>
						<?php }
							
								?>
						<p>
							<label for="nombre">
								<span>Nombre</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($tecnica->nombre)) ? set_value('nombre') : $tecnica->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion">
								<span>Descripción</span>
								<textarea id="descripcion" name="descripcion" rows="10" cols="50"><?php echo ((set_value('descripcion')!='' || !isset($tecnica->descripcion)) ? set_value('descripcion') : $tecnica->descripcion);?></textarea>
							</label>
						</p>
						

						<input type="hidden" name="id_tecnica" value="<?php if (isset($id_tecnica)) echo $id_tecnica;
						else echo $tecnica->id_tecnica?>" />
						<?php if (isset($tecnica->id_detalle_tecnica)){ ?>
						<input type="hidden" name="id_detalle_tecnica" value="<?php echo $tecnica->id_detalle_tecnica ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$tecnica->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($tecnica->id_detalle_tecnica) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma Obra cierre -->
