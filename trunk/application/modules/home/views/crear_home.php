		<div id="ficha">

			<h2><?php echo (isset($obra) ? 'Editar' : 'Crear')?> Obra</h2>

			<!-- Formulario Crear Obra -->
<?php echo validation_errors();
if (isset($obra_obras)) $obras_rel=json_decode($obra_obras);
//echo $obra_obras;
if (isset($obra_videos)) $videos_rel=json_decode($obra_videos);
if (isset($obra_catalogos)) $catalogos_rel=json_decode($obra_catalogos);
if (isset($obra_microsites)) $microsites_rel=json_decode($obra_microsites);
if (isset($obra_colecciones)){
	$colecciones_rel=json_decode($obra_colecciones);
	foreach($colecciones_rel as $cr){
		$col_rel[$cr->id_coleccion]=$cr->nombre;
	}
}
//echo '<pre>'.print_r($obra,true).'</pre>';
$id=(isset($obra->id_obra) ? $obra->id_obra : '');

?>




			<?php echo form_open('obra/create/'.$id,'id="gen_form" class="editar_obra"')?>
				<fieldset>
					<legend>Crear obra</legend>
					<p>
						<label for="dia">
							<span>Día (dd)</span>
							<input id="dia" name="dia" type="text" value="<?php echo ((set_value('dia')!='' || !isset($obra->dia)) ? set_value('dia') : $obra->dia);?>" />
						</label>
					</p>
					<p>
						<label for="mes">
							<span>Mes (mm)</span>
							<input id="mes" name="mes" type="text" value="<?php echo ((set_value('mes')!='' || !isset($obra->mes)) ? set_value('mes') : $obra->mes);?>" />
						</label>
					</p>
					<p>
						<label for="ano">
							<span>Año (aaaa)</span>
							<input id="ano" name="ano" type="text" value="<?php echo ((set_value('ano')!='' || !isset($obra->ano)) ? set_value('ano') : $obra->ano);?>" />
						</label>
					</p>
					<p class="inputCheckbox">
						<label for="fecha_aprox">
							<input id="fecha_aprox" name="fecha_aprox" type="checkbox" value="1" <?php echo ((isset($obra->fecha_aprox) && $obra->fecha_aprox==1) ? 'checked="checked"' : set_checkbox('fecha_aprox', '1')); ?> />
							<span>Fecha aproximada</span>
						</label>
					</p>
					<p>
						<label for="ancho">
							<span>Ancho (<abbr title="Centímetro - Unidad de medida">cm</abbr>, separador&nbsp;',')</span>
							<input id="ancho" name="ancho" type="text" value="<?php echo ((set_value('ancho')!='' || !isset($obra->ancho)) ? set_value('ancho') : $obra->ancho);?>" />
						</label>
					</p>
					<p>
						<label for="alto">
							<span>Alto (<abbr title="Centímetro - Unidad de medida">cm</abbr>, separador&nbsp;',')</span>
							<input id="alto" name="alto" type="text" value="<?php echo ((set_value('alto')!='' || !isset($obra->alto)) ? set_value('alto') : $obra->alto);?>" />
						</label>
					</p>
					<p class="inputCheckbox">
						<label for="nuevaAdquisicion">
							<input id="nuevaAdquisicion" name="nueva_adquisicion" type="checkbox" value="1" <?php echo ((isset($obra->nueva_adquisicion) && $obra->nueva_adquisicion==1)? 'checked="checked"' : set_checkbox('nueva_adquisicion', '1')); ?> />
							<span>Nueva adquisición</span>
						</label>
					</p>
					<p>
						<label for="ninventario">
							<span>Número de inventario</span>
							<input id="ninventario" name="numero_inventario" type="text" value="<?php echo ((set_value('numero_inventario')!='' || !isset($obra->numero_inventario)) ? set_value('numero_inventario') : $obra->numero_inventario);?>" />
						</label>
					</p>
					<?php /*/p class="inputCheckbox">
						<label for="destacado">
							<input id="destacado" name="destacado" type="checkbox" value="1" <?php echo ((isset($obra->destacado) && $obra->destacado==1) ? 'checked="checked"' : set_checkbox('destacado', '1')); ?> />
							<span>Destacado</span>
						</label>
					</p>
					* */ ?>
					<p><?php $artistas=json_decode($artistas,true);

					//echo '<pre>'.print_r($artistas,true).'</pre>'; ?>
						<label for="artista">
							<span>Artista</span>
							<select id="artista" name="id_artista">
							<?php echo $obra->id_artista?>
							<?php
								foreach($artistas as $ar){
									echo '<option value="'.$ar['id_artista'].'" '.(isset($obra->id_artista) && $ar['id_artista']==$obra->id_artista ? 'selected="selected"' : set_select('id_artista', $ar['id_artista'])).'>'.$ar['apellidos'].', '.$ar['nombre'].'</option>';
								}
								
								?>
							</select>
						</label>
					</p>

					<p>
						<label for="estado">
							<span>Estado</span>
							<select id="estado" name="id_estado">
							<?php
								foreach(json_decode($estados) as $estado){
									echo '<option value="'.$estado->id_estado.'" '.($estado->id_estado==$obra->id_estado ? 'selected="selected"'  : set_select('id_estado', $estado->id_estado)).'>'.ucwords($estado->estado).'</option>';
								}
								?>
							</select>
						</label>
					</p>
					<p>
						<label for="tecnica">
							<span>Técnica</span>
							<select id="tecnica" name="id_tecnica">
								<?php
								foreach(json_decode($tecnicas) as $tecnica){
									echo '<option value="'.$tecnica->id_tecnica.'" '.($tecnica->id_tecnica==$obra->id_tecnica ? 'selected="selected"'  : set_select('id_tecnica', $tecnica->id_tecnica)).'>'.ucwords($tecnica->nombre).'</option>';
								}
								?>
							</select>
						</label>
					</p>
					<p>
						<label for="categoria">
							<span>Categoría</span>
							<select id="categoria" name="id_categoria">
								<?php
								foreach(json_decode($categorias) as $categoria){
									echo '<option value="'.$categoria->id_categoria.'" '.($categoria->id_categoria==$obra->id_categoria ? 'selected="selected"'  : set_select('id_categoria',$categoria->id_categoria)).'>'.ucwords($categoria->nombre).'</option>';
								}
								?>
							</select>
						</label>
					</p>
					<p>
						<label for="valoracion">
							<span>Valoración</span>
							<input id="valoracion" name="valoracion" type="text" value="<?php $r=((set_value('valoracion')!='' || !isset($obra->valoracion)) ? set_value('valoracion') : $obra->valoracion);
							echo ($r=='' ? '0' : $r);
							?>" />
						</label>
					</p>

					<p class="inputFile">
					<?php 
					if (isset($obra)) $img=json_decode(modules::run('services/relations/get_rel','obra','imagen',$obra->id_obra,'true','multimedia.id_multimedia'));
					if (isset($img) && is_array($img) && !empty($img)){
					//echo '<pre>'.print_r(json_decode($imagenes),true).'</pre>';
					foreach($img as $im){ ?>
					<input type="hidden" name="imagenActual" value="<?php echo $im->fichero?>" />
						<img src="/assets/img/med/<?php echo $im->fichero?>" alt="<?php echo (isset($obra->titulo) ? 'Ficha de '.$obra->titulo : 'Obra sin titulo')?>" />
						<?php }
						}
						?>
						<label for="imagen">
							 <span id="uploadImage">Subir imagen</span>
							 <span>Imagen</span>
							<input id="imagen" name="imagen" type="file" />
							<input id="imagenName" name="imagenName" type="hidden" />
						</label>
					</p>

					<!-- OBRAS RELACIONADAS -->

					<div class="relationsDiv">
						<div>
							<label for="relObras">
								<span>Obras relacionadas:</span>
								<select id="relObras" class="multiple" name="obras[]" multiple>
									<?php 
									
									$set_o=$this->input->post('obras');
									if (!empty($set_o)){
										foreach($set_o as $so){
											$so_data=modules::run('services/relations/get_from_id','obra',$so);
											echo '<option value="'.$so.'" selected="selected">'.$so_data->id_obra.' - '.$so_data->titulo.'</option>';
										}
										
									}elseif (isset($obras_rel) && !empty($obras_rel)){
										foreach($obras_rel as $obra_rel){
											$or=json_decode(modules::run('obra/read',$obra_rel->id_obra,'true'));
											echo '<option value="'.$obra_rel->id_obra_relacionado.'" selected="selected">'.$obra_rel->id_obra_relacionado.' - '.$obra_rel->titulo.'</option>';
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeObras">Quitar &rArr;</button></strong>
						</div>
						<div>
							<label for="categoriaRel">
								<select id="categoriaRel">
									<option selected="selected">Elije una categoría</option>
									<?php
									foreach(json_decode($categorias) as $categoria){
										echo '<option value="'.$categoria->id_categoria.'" '.($categoria->id_categoria==$obra->id_categoria ? ''  : set_select('categoria_id',$categoria->id_categoria)).'>'.ucwords($categoria->nombre).'</option>';
									}
									?>
								</select>
							</label>
							<label for="relObrasView">
								<select id="relObrasView" class="multiple charge" multiple>
								</select>
							</label>
							<strong class="boton"><button id="addObras">&lArr; Añadir</button></strong>
						</div>
					</div>

					<!-- acaba OBRAS RELACIONADAS -->
<?php /*
					<p>
						<label for="obrasrelacionadas">
							<span>Obras relacionadas</span>
							<select id="obrasrelacionadas" name="obras[]" multiple>
								<?php
								foreach(json_decode($obras) as $obra){
									$o[$obra->nombre][]=$obra;
									//echo '<option value="'.$obra->id_obra.'" '.set_select('obras[]',$obra->id_obra).'>'.$obra->id_obra.' - '.$obra->titulo.'</option>';
								}
								foreach($o as $n=>$c){
									echo '<optgroup label="'.$n.'">';
									foreach($c as $ob){
										echo '<option value="'.$ob->id_obra.'" '.set_select('obras[]',$ob->id_obra).'>'.$ob->id_obra.' - '.$ob->titulo.'</option>';
									}
									echo '</optgroup>';
								}
								?>
							</select>
						</label>
					</p>*/?>


					<!-- videos relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relVideos">
								<span>Videos relacionados:</span>
								<select id="relVideos" class="multiple" name="videos[]" multiple>
									<?php
									//$obra_videos=json_decode($videos);
									
									$set_v=$this->input->post('videos');
									if (!empty($set_v)){
										foreach($set_v as $sv){
											$sv_data=modules::run('services/relations/get_from_id','multimedia',$sv);
											echo '<option value="'.$sv.'" selected="selected">'.$sv_data->nombre_multimedia.'</option>';
										}
										
									}elseif (isset($videos_rel) && !empty($videos_rel)){
									foreach($videos_rel as $ov){
										echo '<option value="'.$ov->id_multimedia.'" '.set_select('videos[]',$ov->id_multimedia).'>'.$ov->nombre_multimedia.'</option>';
										}
									}
									?>
									
								</select>
							</label>
							<strong class="boton"><button id="removeVideos">Quitar &rArr;</button></strong>
						</div>
						<div>
							<label for="relVideosView">
								<select id="relVideosView" class="multiple charge" multiple>
									<?php
									$videos=json_decode($videos);
									if (isset($videos) && !empty($videos)){
									foreach($videos as $video){
										echo '<option value="'.$video->id_multimedia.'" '.set_select('videos[]',$video->id_multimedia).'>'.$video->nombre_multimedia.'</option>';
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="addVideos">&lArr; Añadir</button></strong>
						</div>


					<!-- FIN videos relacionados -->

					<!-- microsites relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relMicrosites">
								<span>Microsites relacionados:</span>
								<select id="relMicrosites" class="multiple" name="microsites[]" multiple>
									<?php
									//$obra_microsites=json_decode($microsites);
									
									$set_m=$this->input->post('microsites');
									if (!empty($set_m)){
										foreach($set_m as $sm){
											$sm_data=modules::run('services/relations/get_from_id','microsite',$sm);
											echo '<option value="'.$sm.'" selected="selected">'.$sm_data->id_microsite.' - '.$sm_data->nombre.'</option>';
										}
										
									}elseif (isset($microsites_rel) && !empty($microsites_rel)){
									foreach($microsites_rel as $m){
										echo '<option value="'.$m->id_microsite.'" '.set_select('microsite[]',$m->id_microsite).'>'.$m->nombre.'</option>';
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeMicrosites">Quitar &rArr;</button></strong>
						</div>
						<div>
							<label for="relMicrositesView">
								<select id="relMicrositesView" class="multiple charge" multiple>
									<?php
									$microsites=json_decode($microsites);
									if (isset($microsites) && !empty($microsites)){
									foreach($microsites as $microsite){
										echo '<option value="'.$microsite->id_microsite.'" '.set_select('microsites[]',$microsite->id_microsite).'>'.$microsite->nombre.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addMicrosites">&lArr; Añadir</button></strong>
						</div>


					<!-- FIN microsites relacionados -->
					<!-- catalogos relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relCatalogos">
								<span>Catalogos relacionados:</span>
								<select id="relCatalogos" class="multiple" name="catalogos[]" multiple>
									<?php
									//$obra_catalogos=json_decode($catalogos);
									
									$set_cat=$this->input->post('catalogos');
									if (!empty($set_cat)){
										foreach($set_cat as $sc){
											$sc_data=modules::run('services/relations/get_from_id','multimedia',$sc);
											echo '<option value="'.$sc.'" selected="selected">'.$sc_data->nombre_multimedia.'</option>';
										}
										
									}elseif (isset($catalogos_rel) && !empty($catalogos_rel)){
										foreach($catalogos_rel as $cr){
											echo '<option value="'.$cr->id_multimedia.'" selected="selected">'.$cr->nombre_multimedia.'</option>';
										}
									}
									
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeCatalogos">Quitar &rArr;</button></strong>
						</div>
						<div>
							<label for="relCatalogosView">
								<select id="relCatalogosView" class="multiple charge" multiple>
									<?php
									$catalogos=json_decode($catalogos);
									if (isset($catalogos) && !empty($catalogos)){
									foreach($catalogos as $catalogo){
										echo '<option value="'.$catalogo->id_multimedia.'" '.set_select('catalogos[]',$catalogo->id_multimedia).'>'.$catalogo->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addCatalogos">&lArr; Añadir</button></strong>
						</div>


					<!-- FIN catalogos relacionados -->
					<!-- Colecciones RELACIONADAS -->

					<?php
					$colecciones=json_decode($colecciones);
					if (isset($colecciones) && !empty($colecciones)){
					?>


					<div class="relationsDiv">
						<div>
							<label for="relColeccs">
								<span>Colecciones relacionadas:</span>
								<select id="relColeccs" class="multiple" name="colecciones[]" multiple>
									<?php
										
									$set_col=$this->input->post('colecciones');
									if (!empty($set_col)){
										foreach($set_col as $sco){
											$sco_data=modules::run('services/relations/get_from_id','coleccion',$sco);
											echo '<option value="'.$sco.'" selected="selected">'.$sco_data->nombre.'</option>';
										}
										
									}elseif (isset($colecciones) && !empty($colecciones)){
										foreach($colecciones as $coleccion){
											if (isset($obra) && isset($col_rel[$coleccion->id_coleccion]) && $col_rel[$coleccion->id_coleccion]==$coleccion->nombre){
												$s='selected="selected"';
												echo '<option value="'.$coleccion->id_coleccion.'" '.$s.set_select('colecciones[]',$coleccion->id_coleccion).'>'.$coleccion->nombre.'</option>';
											}
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeColeccs">Quitar &rArr;</button></strong>
						</div>
						<div>
							<label for="relColeccsView">
								<select id="relColeccsView" class="multiple charge" multiple>
									<?php
									foreach($colecciones as $coleccion){
										if (isset($obra) && isset($col_rel[$coleccion->id_coleccion]) && $col_rel[$coleccion->id_coleccion]==$coleccion->nombre)
										{}
										else
										{
										$s='';
										echo '<option value="'.$coleccion->id_coleccion.'" '.$s.set_select('colecciones[]',$coleccion->id_coleccion).'>'.$coleccion->nombre.'</option>';
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="addColeccs">&lArr; Añadir</button></strong>
						</div>
					</div>
					<!-- acaba colecciones RELACIONADAS -->
					<?php } /*?>


					<?php

					$colecciones=json_decode($colecciones);
					if (isset($colecciones) && !empty($colecciones)){ ?>
					<p>
						<label for="colrelacionadas">
							<span>Colecciones relacionadas</span>
							<select id="colrelacionadas" name="colecciones[]" multiple>
								<?php
								foreach($colecciones as $coleccion){
									if (isset($obra) && isset($col_rel[$coleccion->id_coleccion]) && $col_rel[$coleccion->id_coleccion]==$coleccion->nombre)
										$s='selected="selected"';
									else $s='';
									echo '<option value="'.$coleccion->id_coleccion.'" '.$s.set_select('colecciones[]',$coleccion->id_coleccion).'>'.$coleccion->nombre.'</option>';
								}
								?>
							</select>
						</label>
					</p>
					<?php }*/ ?>
					<?php echo (isset($obra) ? '<input type="hidden" name="id_obra" value="'.$obra->id_obra.'" />' : '')?>


					<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($obra) ? 'Guardar' : 'Crear')?> obra</button></strong>
				</fieldset>
			</form>
			<!-- Formulario Formulario Crear Obra cierre -->

		</div>
