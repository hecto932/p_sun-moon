		<ul id="tabs">
			<li><a href="#tabFicha" title="">Ficha de multimedia</a></li>
			<?php
			$idiomas=json_decode(modules::run('services/relations/get_all','idioma','true'));
			foreach($multimedia_idiomas as $multimedia_idioma){ 
				$idioma[$multimedia_idioma->id_idioma]=json_decode(modules::run('services/relations/get_from_id','idioma',$multimedia_idioma->id_idioma,'true'));
				?>
			<li><a href="#tabLang<?php echo $multimedia_idioma->id_idioma ?>" title=""><?php echo $idioma[$multimedia_idioma->id_idioma]->nombre?></a></li>
			<?php } 
			if (count($idiomas) > count($multimedia_idiomas)) { ?>
			<li class="toNewLang"><a href="#tabNewLang" title="">Crear nuevo idioma</a></li>	
			<?php } ?>		
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">	
			<!-- Ficha Multimedia -->
				<h2>Ficha Multimedia</h2>
	<?php 
	//echo '<pre>'.print_r($multimedia,true).'</pre>';
	?>
				<dl class="ficha_obra">
				<?php if($this->session->flashdata('error')!='') echo $this->session->flashdata('error'); 
					if ($multimedia->id_tipo!='') { ?>
					<dt>Tipo</dt>
					<dd><?php echo $tipo_multimedia=modules::run('services/relations/get_from_id','tipo_multimedia',$multimedia->id_tipo)->nombre?></dd>
					<?php } 
				?>
					<dt>Estado</dt>
					<dd><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$multimedia->id_estado,'true'));
					echo $estado->estado?></dd>
					<?php 
					if ($tipo_multimedia=='imagen'){ ?>
					<dt>Imagen</dt>	
					<dd>
					<img src="/assets/img/thumb/<?php echo $multimedia->fichero?>" />
					</dd>
						
				<?php	}elseif ($tipo_multimedia=='catalogo' && $multimedia->fichero!='' && is_file('assets/pdf/'.$multimedia->fichero)){ ?>
					<dt>Fichero</dt>	
					<dd>
				<a href="/assets/pdf/<?php echo $multimedia->fichero?>"><?php echo (isset($multimedia->nombre_multimedia) ? $multimedia->nombre_multimedia : 'Multimedia sin titulo')?></a>
					</dd>
				<?php	}elseif ($tipo_multimedia=='enlace' && $multimedia->fichero!=''){ ?>
					<dt>Enlace</dt>
					<dd>
				<a href="<?php echo (strpos('http://',$multimedia->fichero) ? $multimedia->fichero : 'http://'.$multimedia->fichero)?>"><?php echo (isset($multimedia->nombre_multimedia) ? $multimedia->nombre_multimedia : 'Multimedia sin titulo')?></a>
					</dd>
				<?php	}elseif ($tipo_multimedia=='video' && $multimedia->fichero!=''){ 
					if (preg_match('/([0-9]+)/',$multimedia->fichero,$vi))
						$video_id=$vi[1];
					//echo $video_id;
					?>
					
					

					<dt>Video</dt>	
					<dd>
					<object width="400" height="300"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id?>&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object>
					</dd>
						
				<?php	}
					if (isset($multimedia_videos) && is_array($multimedia_videos) && !empty($multimedia_videos)){ ?>
					<dt>Vídeos relacionados</dt>
					<dd>
						<ul>
							<?php 
							foreach ($multimedia_videos as $v){
								echo '<li>'.$v->nombre_multimedia.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
					if (isset($multimedia_catalogos) && is_array($multimedia_catalogos) && !empty($multimedia_catalogos)){ ?>
					<dt>Catálogos relacionados</dt>
					<dd>
						<ul>
							<?php 
							foreach ($multimedia_catalogos as $c){
								echo '<li>'.$c->nombre_multimedia.'</li>';
							} ?>
						</ul>
					</dd>
					<?php } 
					if (isset($multimedia_microsites) && is_array($multimedia_microsites) && !empty($multimedia_microsites)){ ?>
					<dt>Microsites relacionados</dt>
					<dd>
						<ul>
							<?php 
							foreach ($multimedia_microsites as $m){
								echo '<li>'.$m->nombre.'</li>';
							} ?>
						</ul>
					</dd>
					<?php } 
					if (isset($multimedia_obras) && is_array($multimedia_obras) && !empty($multimedia_obras)){ ?>
					<dt>Obras relacionadas</dt>
					<dd>
						<ul>
							<?php 
							foreach ($multimedia_obras as $mo){
								echo '<li>'.$mo->titulo.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
                     if (isset($multimedia_artistas) && is_array($multimedia_artistas) && !empty($multimedia_artistas)){ ?>
					<dt>Artistas relacionados</dt>
					<dd>
						<ul>
							<?php
							foreach ($multimedia_artistas as $pa){
								echo '<li>'.$pa->apellidos.', '.$pa->nombre.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
                    if (isset($multimedia_enlaces) && is_array($multimedia_enlaces) && !empty($multimedia_enlaces)){ ?>
					<dt>Enlaces relacionados</dt>
					<dd>
						<ul>
							<?php
							foreach ($multimedia_enlaces as $me){
								echo '<li>'.$me->fichero.' - '.$me->nombre_multimedia.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
					/*
					 *
					$tags=json_decode(modules::run('services/relations/get_rel','detalle_multimedia','tag',$multimedia->id_detalle_multimedia,'true'),true);
					if (isset($tags) && !empty($tags)){
					?>
					<dt>Tags de la multimedia</dt>
					<dd>
						<ul>
							<?php 
						$t=array();
						foreach($tags as $tag){
							$t[]=$tag['tag'];
							echo '<li>'.$tag['tag'].'</li>';
						}
						?>
						</ul>
					</dd>
					<?php } 
					
					<dt>Destacado</dt>
					<dd><?php echo ($multimedia->destacado == 1 ? 'Si' : 'No')?></dd>*
					* * */?>
				</dl>
				<strong class="boton"><?php echo anchor('backend/editar_multimedia/'.$multimedia->id_multimedia,'Editar Multimedia',array('title'=>"Edita Multimedia"))?></strong>
				<!-- Ficha Multimedia cierre -->

				<!--<strong class="boton"><a href="nuevo_idioma_multimedia" title="Nuevo Idioma">Nuevo Idioma</a></strong>-->
			</div>
			<?php
			//echo '<pre>'.print_r($multimedia_idiomas,true).'</pre>';
			
			foreach($multimedia_idiomas as $multimedia_idioma){ ?>

			<!-- <?php echo $idioma[$multimedia_idioma->id_idioma]->nombre?> -->
			
			<div id="tabLang<?php echo $multimedia_idioma->id_idioma?>" class="tab">
				<h2><?php echo $idioma[$multimedia_idioma->id_idioma]->nombre?></h2>
				
				<dl class="ficha_obra">
				<?php if ($multimedia_idioma->nombre_multimedia!=''){ ?>
					<dt>Nombre</dt>
					<dd><?php echo $multimedia_idioma->nombre_multimedia?></dd>
					<?php }

					if ($multimedia_idioma->descripcion_multimedia!=''){ ?>
					<dt>Descripción</dt>
					<dd><?php echo $multimedia_idioma->descripcion_multimedia?></dd>
					<?php }
					if ($multimedia_idioma->url!=''){ ?>
					<dt>URL</dt>
					<dd><?php echo $multimedia_idioma->url?></dd>
					<?php }
					
					if ($multimedia_idioma->titulo_pagina!=''){ ?>
					<dt>Título Página</dt>
					<dd><?php echo $multimedia_idioma->titulo_pagina?></dd>
					<?php }
					if ($multimedia_idioma->descripcion_pagina!=''){ ?>
					<dt>Descripción Página</dt>
					<dd><?php echo $multimedia_idioma->descripcion_pagina?></dd>
					<?php }
					if ($multimedia_idioma->keywords!=''){ ?>
					<dt>Keywords</dt>
					<dd><?php echo $multimedia_idioma->keywords?></dd>
					<?php } ?>
					<?php 
					$tags=json_decode(modules::run('services/relations/get_rel','detalle_multimedia','tag',$multimedia_idioma->id_detalle_multimedia,'true'),true);
					if (!empty($tags)){ ?>
					<dt>Tags</dt>
					<?php
						$t=array();
						foreach($tags as $tag){
							echo '<dd>'.$tag['tag'].'</dd>';
						}
					}
                    ?>
					
				</dl>
	
				<strong class="boton"><?php echo anchor('multimedia/eliminar_idioma/'.$multimedia_idioma->id_detalle_multimedia,'Eliminar Idioma',array('title'=>"Eliminar Idioma", 'class'=>"delete"))?></strong>
				<strong class="boton"><?php echo anchor('multimedia/editar_idioma/'.$multimedia->id_multimedia.'/'.$multimedia_idioma->id_detalle_multimedia,'Editar Idioma',array('title'=>"Editar Idioma"))?></strong>
				<!-- Inglés cierre-->
			</div>
			<?php } ?>
			<div class="tab" id="tabNewLang">
				<h2>Crear nuevo idioma para la multimedia <?php echo (isset($multimedia->titulo) ? 'Ficha de '.$multimedia->titulo : 'Multimedia sin titulo')?></h2>
				
				<?php
				
				echo modules::run('template/crear_idioma_form',$multimedia->id_multimedia,'multimedia');?>
				
			</div>
			
			
		</div>
