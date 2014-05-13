<!-- Formulario Nuevo Idioma Producto -->
				<?php
				$ni=0;
				
				$imagen=json_decode($imagen);
				//echo '<pre>'.print_r($producto,true).'</pre>';
				if (isset($imagen) && !empty($imagen)){
					foreach($imagen as $k=>$i){
						if (isset($producto->id_idioma) && $i->id_idioma==$producto->id_idioma)
							$ni=$k;
					}
				}
				
				echo validation_errors();
				echo form_open_multipart('producto/guardar_idioma','id="gen_form" class="idioma"')?>
					<fieldset>
						<legend>Nuevo Idioma producto</legend>

						<p>
					
							<label for="idioma">
								<span>Idioma</span>
								<select id="idioma" name="id_idioma">
								<?php foreach(json_decode(modules::run('services/relations/get_all','idioma','true')) as $im){ ?>
									<option value="<?php echo $im->id_idioma?>"<?php 
									
									if (set_select('id_idioma',$im->id_idioma)!='')
										echo set_select('id_idioma',$im->id_idioma);
									elseif ($nuevo!=true)
										echo (isset($producto->id_idioma) && $producto->id_idioma==$im->id_idioma ? ' selected="selected"' : '')?>><?php echo $im->nombre?></option>
								<?php } ?>
								</select>
							</label>
							
							
						</p>
						<p>
							<label for="nombre">
								<span>Nombre</span>
								<input id="nombre" name="nombre" type="text" value="<?php echo ((set_value('nombre')!='' || !isset($producto->nombre)) ? set_value('nombre') : $producto->nombre);?>" />
							</label>
						</p>
						<p>
							<label for="descripcion_breve">
								<span>Descripción Breve</span>
								<textarea id="descripcion_breve" name="descripcion_breve" rows="10" cols="100"><?php echo ((set_value('descripcion_breve')!='' || !isset($producto->descripcion_breve)) ? set_value('descripcion_breve') : $producto->descripcion_breve);?></textarea>
							</label>
						</p>
						<p>
							<label for="titulo">
								<span>Titulo</span>
									<textarea id="titulo" name="titulo" rows="10" cols="100"><?php echo ((set_value('titulo')!='' || !isset($producto->titulo)) ? set_value('titulo') : $producto->titulo);?></textarea>
							</label>
						</p>

						<p>
							<label for="descripcion_amp">
								<span>Descripción Ampliada</span>
								<textarea id="descripcion_amp" name="descripcion_ampliada" rows="10" cols="100"><?php echo ((set_value('descripcion_ampliada')!='' || !isset($producto->descripcion_ampliada)) ? set_value('descripcion_ampliada') : $producto->descripcion_ampliada);?></textarea>
							</label>
						</p>
						<p>
							<label for="presentacion">
								<span>Presentación</span>
								<input id="presentacion" name="presentacion" type="text" value="<?php echo ((set_value('presentacion')!='' || !isset($producto->presentacion)) ? set_value('presentacion') : $producto->presentacion);?>" />
							</label>
						</p>
						<!--<p class="inputFile">
                        <?php
                        if (isset($producto) && isset($producto->pdf) ) $pdf=$producto->pdf;
                        if (isset($pdf) && !empty($pdf)){
                        //echo '<pre>'.print_r(json_decode($imagenes),true).'</pre>';
                            ?>
                            <a href="/assets/front/pdf/<?php echo $pdf?>" alt="<?php echo (isset($producto->nombre) ? 'Ficha de '.$producto->nombre : 'Producto sin titulo')?>">Ficha PDF de <?php echo (isset($producto->nombre) ? $producto->nombre : 'PDF sin titulo')?>
                            </a>
                        <?php 
                            }
                            ?>
                            <label for="pdf">
                                <span>Ficha Bochure PDF</span>
                                <input id="pdf" name="pdf" type="file" class="producto_pdf" />
                            </label>
                    	</p>-->
                        <!--
						<?php if (isset($imagen[$ni]) && !empty($imagen[$ni])){ ?>
						<p>
							<label for="descripcion_imagen">
								<span>Descripción Imagen</span>
								<textarea id="descripcion_imagen" name="descripcion_imagen" rows="10" cols="50"><?php echo ((set_value('descripcion_imagen')!='' || !isset($imagen[$ni]->descripcion_multimedia)) ? set_value('descripcion_imagen') : $imagen[$ni]->descripcion_multimedia);?></textarea>
							</label>
							<input id="descripcion_imagen_id" name="descripcion_imagen_id" type="hidden" value="<?php echo $imagen[$ni]->id_multimedia?>" />
							<input id="id_detalle_multimedia" name="id_detalle_multimedia" type="hidden" value="<?php echo $imagen[$ni]->id_detalle_multimedia?>" />
						</p>
						<?php } ?>-->
						<?php /*<p>
							<label for="fecha_vis">
								<span>Fecha Visible</span>
								<input id="fecha_vis" name="fecha_vis" type="text" />
							</label>
						</p>
						* */
					//echo  $producto->titulo_y_pie ?>
					
						<p>
							<label for="url">
								<span>URL</span>
								<input id="url" name="url" type="text" value="<?php echo ((set_value('url')!='' || !isset($producto->url)) ? set_value('url') : $producto->url);?>" />
							</label>
						</p>
						<p>
							<label for="tit_pag">
								<span>Título Página</span>
								<input id="tit_pag" name="titulo_pagina" type="text" value="<?php echo ((set_value('titulo_pagina')!='' || !isset($producto->titulo_pagina)) ? set_value('titulo_pagina') : $producto->titulo_pagina);?>" />
							</label>
						</p>
						<!--<p>
							<label for="descripcion_pag">
								<span>Descripción Página</span>
								<textarea id="descripcion_pag" name="descripcion_pagina" rows="10" cols="50"><?php echo ((set_value('descripcion_pagina')!='' || !isset($producto->descripcion_pagina)) ? set_value('descripcion_pagina') : $producto->descripcion_pagina);?></textarea>
							</label>
						</p>-->
						<!--<p>
							<label for="email_empresa_contacto">
								<span>Email Contacto</span>
								<input id="email_empresa_contacto" name="email_empresa_contacto" type="text" value="<?php echo ((set_value('email_empresa_contacto')!='' || !isset($producto->email_empresa_contacto)) ? set_value('email_empresa_contacto') : $producto->email_empresa_contacto);?>" />
							</label>
						</p>
						<p>
							<label for="telefono_1">
								<span>Telefono 1</span>
								<input class="maskTlf" id="telefono_1" name="telefono_1" type="text" value="<?php echo ((set_value('telefono_1')!='' || !isset($producto->telefono_1)) ? set_value('telefono_1') : $producto->telefono_1);?>" />
							</label>
						</p>
						<p>
							<label for="telefono_2">
								<span>Telefono 2</span>
								<input class="maskTlf" id="telefono_2" name="telefono_2" type="text" value="<?php echo ((set_value('telefono_2')!='' || !isset($producto->telefono_2)) ? set_value('telefono_2') : $producto->telefono_2);?>" />
							</label>
						</p>
						<p>
							<label for="url_facebook">
								<span>URL Facebook</span>
								<input id="url_facebook" name="url_facebook" type="text" value="<?php echo ((set_value('url_facebook')!='' || !isset($producto->url_facebook)) ? set_value('url_facebook') : $producto->url_facebook);?>" />
							</label>
						</p>
						<p>
							<label for="url_twitter">
								<span>URL Twitter</span>
								<input id="url_twitter" name="url_twitter" type="text" value="<?php echo ((set_value('url_twitter')!='' || !isset($producto->url_twitter)) ? set_value('url_twitter') : $producto->url_twitter);?>" />
							</label>
						</p>
						<p>
							<label for="url_gmap">
								<span>URL Google Maps</span>
								<input id="url_gmap" name="url_gmap" type="text" value="<?php echo ((set_value('url_gmap')!='' || !isset($producto->url_gmap)) ? set_value('url_gmap') : $producto->url_gmap);?>" />
							</label>
						</p>-->
						<p>
							<label for="keywords">
								<span>Palabras clave</span>
								<input id="keywords" name="keywords" type="text" value="<?php echo ((set_value('keywords')!='' || !isset($producto->keywords)) ? set_value('keywords') : $producto->keywords);?>" />
							</label>
						</p>
						


						<input type="hidden" name="id_producto" value="<?php if (isset($id_producto)) echo $id_producto;
						else echo $producto->id_producto?>" />
						<?php if (isset($producto->id_detalle_producto) && $nuevo!=true){ ?>
						<input type="hidden" name="id_detalle_producto" value="<?php echo $producto->id_detalle_producto ?>" />

						<?php 
								$id=json_decode(modules::run('services/relations/get_from_id','idioma',$producto->id_idioma,'true'));
								echo '<input type="hidden" name="id_idioma" value="'.$id->id_idioma.'" />';
						} ?>
						<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($producto->id_detalle_producto) ? 'Guardar' : 'Crear Nuevo')?> Idioma</button></strong>
					</fieldset>
				</form>
				<!-- Formulario Formulario Nuevo Idioma Producto cierre -->
