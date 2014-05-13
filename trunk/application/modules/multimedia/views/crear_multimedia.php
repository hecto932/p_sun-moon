		<div id="ficha">

			<h2><?php echo (isset($multimedia) ? 'Editar' : 'Crear')?> Multimedia</h2>

			<!-- Formulario Crear Multimedia -->
<?php echo validation_errors();
if (isset($error)) echo '<p class="error">'.$error.'</p>';
//echo '<pre>'.print_r($multimedia,true).'</pre>';
if (isset($multimedia_obras)) $obras_rel=json_decode($multimedia_obras);
//echo $multimedia_multimedias;
if (isset($multimedia_videos)) $videos_rel=json_decode($multimedia_videos);

if (isset($multimedia_catalogos)) $catalogos_rel=json_decode($multimedia_catalogos);
if (isset($multimedia_microsites)) $microsites_rel=json_decode($multimedia_microsites);
//echo '<pre>'.print_r($multimedia,true).'</pre>';
$id=(isset($multimedia->id_multimedia) ? $multimedia->id_multimedia : '');

?>




			<?php echo form_open_multipart('multimedia/create/'.$id, array('class' => 'editar_multimedia', 'id' => 'gen_form'))?>
				<fieldset>
					<legend>Crear multimedia</legend>
					<p><?php $estados=modules::run('services/relations/get_all','estado');

					//echo '<pre>'.print_r($artistas,true).'</pre>'; ?>
						<label for="id_estado">
							<span>Estado</span>
							<select id="id_estado" name="id_estado">
							<?php //echo $multimedia->id_artista?>
							<?php
								foreach($estados as $estado){

									echo '<option value="'.$estado->id_estado.'" '.(isset($multimedia->id_estado) && $estado->id_estado==$multimedia->id_estado ? 'selected="selected"' : set_select('id_tipo', $estado->id_estado)).'>'.$estado->estado.'</option>';
                                }
								?>
							</select>
						</label>
					</p>
					<p><?php $tipos=modules::run('services/relations/get_all','tipo_multimedia');

					//echo '<pre>'.print_r($artistas,true).'</pre>'; ?>
						<label for="tipo">
							<span>Tipo</span>
							<select id="tipo" name="id_tipo" <?php echo (isset($multimedia->id_multimedia) ? 'disabled="disabled"' : '' )?>>
							<?php //echo $multimedia->id_artista?>
							<?php
								foreach($tipos as $tipo){
                                if ($tipo->nombre !='imagen')
									echo '<option value="'.$tipo->id_tipo.'" '.(isset($multimedia->id_tipo) && $tipo->id_tipo==$multimedia->id_tipo ? 'selected="selected"' : set_select('id_tipo', $tipo->id_tipo)).'>'.$tipo->nombre.'</option>';
								}
								?>
							</select>
						</label>
					</p>
                    <p class="inputFile">
					<label for="videourl">
							 <span>URL</span>
							<input id="videourl" name="videourl" type="text" value="<?php  echo(isset($multimedia->fichero) ? $multimedia->fichero : '')?>"  />
					</label>
                    </p>
					<!-- OBRAS RELACIONADAS -->

					<div class="relationsDiv">
						<div>
							<label for="relObras">
								<span>Obras relacionadas:</span>
								<select id="relObras" class="multiple" name="obras[]" multiple>
									<?php
                                    if (isset($obras_rel) && !empty($obras_rel)){
                                    foreach($obras_rel as $obra_rel){
										
										echo '<option value="'.$obra_rel->id_obra.'" selected="selected">'.$obra_rel->id_obra.' - '.$obra_rel->titulo.'</option>';
									}}
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeObras">Quitar &rarr;</button></strong>
						</div>
						<div>
							<label for="categoriaRel">
								<select id="categoriaRel">
									<option selected="selected">Elije una categoría</option>
									<?php
									foreach(json_decode($categorias) as $categoria){
										echo '<option value="'.$categoria->id_categoria.'" '.(isset($multimedia) && isset($multimedia->id_categoria) && $categoria->id_categoria==$multimedia->id_categoria ? ''  : set_select('categoria_id',$categoria->id_categoria)).'>'.ucwords($categoria->nombre).'</option>';
									}
									?>
								</select>
							</label>
							<label for="relObrasView">
								<select id="relObrasView" class="multiple charge" multiple>
								</select>
							</label>
							<strong class="boton"><button id="addObras">&larr; Añadir</button></strong>
						</div>
					</div>

					<!-- acaba OBRAS RELACIONADAS -->
<?php /*
					<p>
						<label for="multimediasrelacionadas">
							<span>Multimedias relacionadas</span>
							<select id="multimediasrelacionadas" name="multimedias[]" multiple>
								<?php
								foreach(json_decode($multimedias) as $multimedia){
									$o[$multimedia->nombre][]=$multimedia;
									//echo '<option value="'.$multimedia->id_multimedia.'" '.set_select('multimedias[]',$multimedia->id_multimedia).'>'.$multimedia->id_multimedia.' - '.$multimedia->titulo.'</option>';
								}
								foreach($o as $n=>$c){
									echo '<optgroup label="'.$n.'">';
									foreach($c as $ob){
										echo '<option value="'.$ob->id_multimedia.'" '.set_select('multimedias[]',$ob->id_multimedia).'>'.$ob->id_multimedia.' - '.$ob->titulo.'</option>';
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
									//$multimedia_videos=json_decode($videos);
									if (isset($videos_rel) && !empty($videos_rel)){
									foreach($videos_rel as $ov){
										echo '<option value="'.$ov->id_multimedia.'" '.set_select('videos[]',$ov->id_multimedia).'>'.$ov->fichero.' - '.$ov->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="removeVideos">Quitar &rarr;</button></strong>
						</div>
						<div>
							<label for="relVideosView">
								<select id="relVideosView" class="multiple charge" multiple>
									<?php
									$videos=json_decode($videos);
									if (isset($videos) && !empty($videos)){
									foreach($videos as $video){
										echo '<option value="'.$video->id_multimedia.'" '.set_select('videos[]',$video->id_multimedia).'>'.$video->fichero.' - '.$video->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addVideos">&larr; Añadir</button></strong>
						</div>
                    </div>

					<!-- FIN videos relacionados -->
                    <!-- Enlaces relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relEnlaces">
								<span>Enlaces relacionados:</span>
								<select id="relEnlaces" class="multiple" name="enlaces[]" multiple>
									<?php
									//$multimedia_videos=json_decode($videos);
									if (isset($multimedia_enlaces) && !empty($multimedia_enlaces)){
									foreach($multimedia_enlaces as $oe){
										echo '<option value="'.$oe->id_multimedia.'" '.set_select('enlaces[]',$oe->id_multimedia).'>'.$oe->fichero.' - '.$oe->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="removeEnlaces">Quitar &rarr;</button></strong>
						</div>
						<div>
							<label for="relEnlacesView">
								<select id="relEnlacesView" class="multiple charge" multiple>
									<?php
									//$enlaces=json_decode($enlaces);
									if (isset($enlaces) && !empty($enlaces)){
									foreach($enlaces as $enlace){
										echo '<option value="'.$enlace->id_multimedia.'" '.set_select('$enlaces[]',$enlace->id_multimedia).'>'.$enlace->fichero.' - '.$enlace->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addEnlaces">&larr; Añadir</button></strong>
						</div>


					<!-- FIN Enlaces relacionados -->

					<!-- microsites relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relMicrosites">
								<span>Microsites relacionados:</span>
								<select id="relMicrosites" class="multiple" name="microsites[]" multiple>
									<?php
									//$multimedia_microsites=json_decode($microsites);
									if (isset($microsites_rel) && !empty($microsites_rel)){
									foreach($microsites_rel as $m){
										echo '<option value="'.$m->id_microsite.'" '.set_select('microsite[]',$m->id_microsite).'>'.$m->nombre.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="removeMicrosites">Quitar &rarr;</button></strong>
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
							<strong class="boton"><button id="addMicrosites">&larr; Añadir</button></strong>
						</div>
                    </div>

					<!-- FIN microsites relacionados -->
					<!-- catalogos relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relCatalogos">
								<span>Catalogos relacionados:</span>
								<select id="relCatalogos" class="multiple" name="catalogos[]" multiple>
									<?php
									//$multimedia_catalogos=json_decode($catalogos);
									if (isset($catalogos_rel) && !empty($catalogos_rel)){
									foreach($catalogos_rel as $cc){
										echo '<option value="'.$cc->id_multimedia_relacionado.'" '.set_select('catalogos[]',$cc->id_multimedia_relacionado).'>'.$cc->fichero.' - '.$cc->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="removeCatalogos">Quitar &rarr;</button></strong>
						</div>
						<div>
							<label for="relCatalogosView">
								<select id="relCatalogosView" class="multiple charge" multiple>
									<?php
									$catalogos=json_decode($catalogos);
									if (isset($catalogos) && !empty($catalogos)){
									foreach($catalogos as $clogo){
										echo '<option value="'.$clogo->id_multimedia.'" '.set_select('catalogos[]',$clogo->id_multimedia).'>'.$clogo->fichero.' - '.$clogo->nombre_multimedia.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addCatalogos">&larr; Añadir</button></strong>
						</div>
                    </div>

					<!-- FIN catalogos relacionados -->

                         <!-- artistas relacionados -->

					<div class="relationsDiv">
						<div>
							<label for="relArtistas">
								<span>Artistas relacionados:</span>
								<select id="relArtistas" class="multiple" name="artistas[]" multiple>
									<?php
									//$obra_catalogos=json_decode($catalogos);

									$set_art=$this->input->post('artistas');
									if (!empty($set_art)){
										foreach($set_art as $sa){
											$sa_data=modules::run('services/relations/get_from_id','artista',$sa);
											echo '<option value="'.$sa.'" selected="selected">'.$sa_data->apellidos.', '.$sa_data->nombre.'</option>';
										}

									}elseif (isset($multimedia_artistas) && !empty($multimedia_artistas)){
										foreach($multimedia_artistas as $ar){
											echo '<option value="'.$ar->id_artista.'" selected="selected">'.$ar->apellidos.', '.$ar->nombre.'</option>';
										}
									}

									?>
								</select>
							</label>
							<strong class="boton"><button id="removeArtistas">Quitar &rarr;</button></strong>
						</div>
						<div>
							<label for="relArtistasView">
								<select id="relArtistasView" class="multiple charge" multiple>
									<?php



									if (isset($artistas) && !empty($artistas)){
									foreach($artistas as $artista_rel){
                                       // echo '<pre>'.print_r($artista_rel,true).'</pre>';
										echo '<option value="'.$artista_rel->id_artista.'" '.set_select('artistas[]',$artista_rel->id_artista).'>'.$artista_rel->apellidos.', '.$artista_rel->nombre.'</option>';
										}
									}?>
								</select>
							</label>
							<strong class="boton"><button id="addArtistas">&larr; Añadir</button></strong>
						</div>
					</div>


					<!-- FIN artistas relacionados -->
					
					<?php  /*?>


					<?php

					$colecciones=json_decode($colecciones);
					if (isset($colecciones) && !empty($colecciones)){ ?>
					<p>
						<label for="colrelacionadas">
							<span>Colecciones relacionadas</span>
							<select id="colrelacionadas" name="colecciones[]" multiple>
								<?php
								foreach($colecciones as $coleccion){
									if (isset($multimedia) && isset($col_rel[$coleccion->id_coleccion]) && $col_rel[$coleccion->id_coleccion]==$coleccion->nombre)
										$s='selected="selected"';
									else $s='';
									echo '<option value="'.$coleccion->id_coleccion.'" '.$s.set_select('colecciones[]',$coleccion->id_coleccion).'>'.$coleccion->nombre.'</option>';
								}
								?>
							</select>
						</label>
					</p>
					<?php }*/ ?>
					<?php echo (isset($multimedia) ? '<input type="hidden" name="id_multimedia" value="'.$multimedia->id_multimedia.'" />' : '')?>
				</fieldset>
				<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($multimedia) ? 'Guardar' : 'Crear')?> multimedia</button></strong>
			</form>
			<!-- Formulario Formulario Crear Multimedia cierre -->

		</div>
