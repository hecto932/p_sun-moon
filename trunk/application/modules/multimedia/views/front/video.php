<?php //echo '<pre>'.print_r($multimedia,true).'</pre>';?>

			
			<h1><?php echo $multimedia->nombre_multimedia?></h1>

			<!-- INICIO Content -->	
			<div id="content">
				<p class="h2"><?php echo $multimedia->nombre_multimedia?></p>
				<div id="videoPlayer">
				<?php if (preg_match('/([0-9]+)/',$multimedia->fichero,$vi))
						$vimeo_id=$vi[1];
						?>
					<a href="http://vimeo.com/<?php echo $vimeo_id?>" title="Ver el video en el site de Vimeo" class="oembed">Vídeo "Los Segadores" en Vimeo.</a>					
				</div>
				<strong class="preLegend"><span><?php echo $multimedia->nombre_multimedia?></span></strong>
				<dl class="legend">
					<dt>Duración</dt>
						<dd><?php echo sec2hms($datos_video->duration)?></dd>
				</dl>
				
				<a href="#" title="esta colección en Mapa de la colección" id="goToMap"><span>Mapa de la colección</span></a>
				
				<div class="txt">
					<p><?php echo $multimedia->descripcion_multimedia?></p>
				</div>
			</div>
			<!-- FIN Content -->
						
			<!-- INICIO Opciones de navegación -->			
			<div id="nav_opt">
				<p>Opciones de navegación</p>
				<?php echo modules::run('template/compartir',$this->uri->uri_string(),$title)?>
				<?php if (isset($tags) && is_array($tags) && !empty($tags)){ ?>
				<strong>Tags</strong>
				<ul class="tags">
				<?php foreach ($tags as $tag){ 
					//echo '<pre>'.print_r($tag,true).'</pre>';?>
					<li><a href="/tag/<?php echo $tag->tag?>" title="Contenidos con el tag <?php echo $tag->tag?>"><?php echo $tag->tag?></a></li>
				<?php } ?>
				</ul>
				<?php }?>
				
			</div>
			<!-- FIN Opciones de navegación --> 
			

	
