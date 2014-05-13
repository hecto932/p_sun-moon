		<div id="ficha">

			<h2><?php echo (isset($promocion) ? 'Editar' : 'Crear')?> promocion</h2>

			<!-- Formulario Crear promocion -->
<?php echo validation_errors();
if (isset($error)) echo $error;
//echo $promocion_promociones;

//echo '<pre>'.print_r($promocion,true).'</pre>';
$id=(isset($promocion->id_promocion) ? $promocion->id_promocion : '');
?>




			<?php echo form_open_multipart('promocion/create/'.$id,array('id'=>"gen_form", 'class'=>"editar_promocion"))?>
				<fieldset>
					<legend>Crear Promocion</legend>
					
					


					<p>
						<label for="estado">
							<span>Estado</span>
							<select id="estado" name="id_estado">
							<?php
								foreach(json_decode($estados) as $estado){
									echo '<option value="'.$estado->id_estado.'" '.(isset($promocion->estado) && $estado->id_estado==$promocion->id_estado ? 'selected="selected"'  : set_select('id_estado', $estado->id_estado)).'>'.ucwords($estado->estado).'</option>';
								}
								?>
							</select>
						</label>
					</p>
                    <p>
						<label for="creado">
								<span>Fecha (YYYY-MM-DD)</span>
                        <?php
                        if (set_value('creado')){
                            $fecha=set_value('creado');

                        }else{
                            $fecha=(isset($promocion->creado) && $promocion->creado!='' ? date('Y-m-d',mysql_to_unix($promocion->creado)) : date('Y-m-d'));
                           
                        }
?>                              <input class="maskYear" id="creado" name="creado" type="text" value="<?php echo $fecha?>" />
                          
							</label>
					</p>
                    <p>
						<label for="enlace">
								<span>Enlace</span>
                        <?php
                        if (set_value('enlace')){
                            $enlace=set_value('enlace');

                        }else{
                            $enlace=(isset($promocion->enlace) && $promocion->enlace!='' ? $promocion->enlace : '');

                        }
?>                              <input id="enlace" name="enlace" type="text" value="<?php echo $enlace?>" />

							</label>
					</p>
                    <p class="inputCheckbox">
						<label for="destacado">
							<input id="destacado" name="destacado" type="checkbox" value="1" <?php echo ((isset($promocion->destacado) && $promocion->destacado==1)? 'checked="checked"' : set_checkbox('destacado', '1')); ?> />
							<span>Destacada</span>
						</label>
					</p>
					<p class="inputFile">
					<?php
					if (isset($promocion)) $img=json_decode(modules::run('services/relations/get_rel','promocion','imagen',$promocion->id_promocion,'true','true'));
					if (isset($img) && is_array($img) && !empty($img)){
					//echo '<pre>'.print_r($img,true).'</pre>';
					//foreach($img as $im){ ?>
					<input type="hidden" name="imagenActual" value="<?php echo $img[0]->fichero?>" />
						<img src="/assets/front/img/med/<?php echo $img[0]->fichero?>" alt="<?php echo (isset($promocion->nombre) ? 'Ficha de '.$promocion->nombre : 'Promocion sin titulo')?>" />
						<?php }
						//}
						?>
						<label for="imagen">
							 <span id="uploadImage">Subir imagen</span>
							 <span>Imagen (280x180)</span>
							<input id="imagen" name="imagen" type="file" class="promocion" />
							<input id="imagenName" name="imagenName" type="hidden" />
						</label>
					</p>


					<?php echo (isset($promocion) ? '<input type="hidden" name="id_promocion" value="'.$promocion->id_promocion.'" />' : '')?>


					<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($promocion) ? 'Guardar' : 'Crear')?> promocion</button></strong>
				</fieldset>
			</form>
			<!-- Formulario Formulario Crear promocion cierre -->

		</div>
