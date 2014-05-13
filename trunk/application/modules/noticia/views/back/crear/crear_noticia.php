<?php //die_pre($noticia); ?>
	<div class="row">
		<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

			    <!-- Formulario Crear noticia -->
			    <?php
			    	echo validation_errors();
			    	if (isset($error))
			        echo $error;

			    	$id = (isset($noticia->id_noticia) ? $noticia->id_noticia : '');
			    ?>
			    <?php echo form_open_multipart('noticia/create/' . $id, array('id' => "gen_form", 'class' => 'custom')) ?>
			    <fieldset>
					<div class="row">
						<div class="six columns centered">
							<div class="row">
								<div class="two columns">
						        	<label class="inline" for="estado">
						        		<span> <?php echo lang('estado'); ?> </span>
						        	</label>
						        </div>
		
					        	<div class="ten columns">
						        	<select class="custom" id="estado" name="id_estado">
						                        <?php
						                        foreach ($estados as $key => $estado)
						                        {
						                        	$key++;
						                            echo '<option value="' . $estado->id_estado . '" ' . (isset($noticia->id_estado) && $noticia->id_estado == $key ? 'selected="selected"' : set_select('id_estado', $estado->id_estado)) . '>' . ucwords($estado->estado) . '</option>';
						                        }
						                        ?>
						            </select>
					        	</div>
							</div>
							<div class="row">
								<div class="two columns">
						        	<label class="inline" for="creado">
						        		<span> <?php echo lang('noticias_crear_fecha'); ?>  </span>
						        	</label>
					        	</div>
						        <div class="ten columns">
						        	<?php
						                        if (set_value('creado')) {
						                            $fecha = set_value('creado');
						                        }
						                        else
						                        {
						                            $fecha = (isset($noticia->creado) && $noticia->creado != '' ? date('Y/m/d', mysql_to_unix($noticia->creado)) : date('Y/m/d'));
						                        }
						             ?>
		
						             <input id="fecha" name="creado" type="text" value="<?php echo $fecha ?>" /></td>
						        </div>
							</div>
							<div class="row">
								<div class="two columns">
									<label class="inline" for="destacado">
											<span> <?php echo lang('destacada'); ?> </span>
						            </label>
								</div>
		
						        <div class="ten columns">
		
						        	<?php echo form_dropdown('destacado', $array_destacado, '', 'class="select_back" '); ?>
						        </div>
							</div>
							<div class="row">
								<div class="two columns">
									<label class="inline" for="destacado">
											<span> Sección </span>
						            </label>
								</div>
								<div class="ten columns">
						        	<select name="seccion">
						        		<option <?php echo (isset($noticia->seccion) && ($noticia->seccion=='regulares')) ? 'selected' : ''; ?> value="regulares">Noticias regulares</option>
						        		<option <?php echo (isset($noticia->seccion) && ($noticia->seccion=='economia')) ? 'selected' : ''; ?> value="economia">Noticias económicas</option>
						        		<option <?php echo (isset($noticia->seccion) && ($noticia->seccion=='ambas')) ? 'selected' : ''; ?> value="ambas">Ambas categorías</option>
						        	</select>
						        </div>
							</div>
				        	<?php echo (isset($noticia) ? '<input type="hidden" name="id_noticia" value="' . $noticia->id_noticia . '" />' : '') ?>
					        <div class="row">
					        	<div class="twelve columns alinear-derecha">
					        		<button type="submit" class="button radius wtc"><?php echo (isset($noticia) ? lang('guardar') : lang('crear')) ?></button>
					        	</div>
					        </div>
			       </div>
				</div>
			    	</fieldset>
			    	
				</form>





			<!-- Formulario Formulario Crear noticia cierre -->
		</div>
	</div>
