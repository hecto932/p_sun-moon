		<ul id="tabs">
			<li><a href="#tabFicha" title="">Ficha de la home</a></li>
			<?php
			$idiomas=json_decode(modules::run('services/relations/get_all','idioma','true'));
			foreach($home_idiomas as $home_idioma){
				$idioma[$home_idioma->id_idioma]=json_decode(modules::run('services/relations/get_from_id','idioma',$home_idioma->id_idioma,'true'));
				?>
			<li><a href="#tabLang<?php echo $home_idioma->id_idioma ?>" title=""><?php echo $idioma[$home_idioma->id_idioma]->nombre?></a></li>
			<?php }
			if (count($idiomas) > count($home_idiomas)) { ?>
			<li class="toNewLang"><a href="#tabNewLang" title="">Crear nuevo idioma</a></li>
			<?php } ?>
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">
			<!-- Ficha Caja -->
				<h2>Ficha Caja</h2>
	<?php
	//echo '<pre>'.print_r($home,true).'</pre>';
	?>
				<dl class="ficha_home">
					
					<?php
					$img=json_decode(modules::run('services/relations/get_rel','home','imagen',$home->id_home,'true','multimedia.id_multimedia'));
					if (is_array($img) && !empty($img)){ ?>
					<dt>Imagen</dt>
					<?php
					//echo '<pre>'.print_r(json_decode($img),true).'</pre>';
					foreach($img as $k=>$im){

					?>

					<dd><p class="img"><img src="/assets/img/med/<?php echo $im->fichero?>" title="miniatura de <?php echo (isset($home->titulo) ? $home->titulo : 'Caja sin titulo')?>" /></p></dd>
					<?php }

					}
					
					if (isset($home_canales) && is_array($home_canales) && !empty($home_canales)){ ?>
					<dt>Canales</dt>
					<dd>
						<ul>
							<?php
							foreach ($home_canales as $cv){
								echo '<li>'.$cv->nombre.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
					if (isset($home_categorias) && is_array($home_categorias) && !empty($home_categorias)){ ?>
					<dt>Canales</dt>
					<dd>
						<ul>
							<?php
							foreach ($home_categorias as $hc){
								echo '<li>'.$hc->nombre.'</li>';
							} ?>
						</ul>
					</dd>
					<?php }
					?>
				</dl>
				<strong class="boton"><?php echo anchor('backend/editar_home/'.$home->id_home,'Editar Caja',array('title'=>"Edita Caja"))?></strong>
				<!-- Ficha Caja cierre -->

				<!--<strong class="boton"><a href="nuevo_idioma_home" title="Nuevo Idioma">Nuevo Idioma</a></strong>-->
			</div>
			<?php
			//echo '<pre>'.print_r($home_idiomas,true).'</pre>';

			foreach($home_idiomas as $home_idioma){ ?>
			<?php
			$img=json_decode(modules::run('services/relations/get_rel','home','imagen',$home->id_home,'true'));
			$ni=0;
			foreach($img as $k=>$i){
				if ($i->id_idioma==$home_idioma->id_idioma)
					$ni=$k;
			}

			//echo '<pre>'.print_r($img,true).'</pre>';
			?>
			<!-- <?php echo $idioma[$home_idioma->id_idioma]->nombre?> -->

			<div id="tabLang<?php echo $home_idioma->id_idioma?>" class="tab">
				<h2><?php echo $idioma[$home_idioma->id_idioma]->nombre?></h2>

				<dl class="ficha_home">
				<?php if ($home_idioma->titulo!=''){ ?>
					<dt>Título</dt>
					<dd><?php echo $home_idioma->titulo?></dd>
					<?php }
					if ($home_idioma->descripcion_breve!=''){ ?>
					<dt>Descripción Breve</dt>
					<dd><?php echo $home_idioma->descripcion_breve?></dd>
					<?php }
					if ($home_idioma->descripcion_ampliada!=''){ ?>
					<dt>Descripción Ampliada</dt>
					<dd><?php echo $home_idioma->descripcion_ampliada?></dd>
					<?php }
					if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia!=''){ ?>
					<dt>Descripción Imagen</dt>
					<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
					<?php }
					/*
					$fecha_visible=modules::run('services/relations/format_fecha',$home->dia,$home->mes,$home->ano,$home->fecha_aprox,'true');
					if ($fecha_visible!=''){ ?>
					<dt>Fecha Visible</dt>
					<dd><?php echo $fecha_visible?></dd>
					<?php }
					* */
					if ($home_idioma->titulo_y_pie!=''){ ?>
					<dt>Título y Pie</dt>
					<dd><?php echo $home_idioma->titulo_y_pie?></dd>
					<?php }
					if ($home_idioma->publicado_en!=''){ ?>
					<dt>Publicado en</dt>
					<dd><?php echo $home_idioma->publicado_en?></dd>
					<?php }
					if ($home_idioma->soporte!=''){ ?>
					<dt>Soporte</dt>
					<dd><?php echo $home_idioma->soporte?></dd>
					<?php }
					if ($home_idioma->url!=''){ ?>
					<dt>URL</dt>
					<dd><?php echo $home_idioma->url?></dd>
					<?php }
					if ($home_idioma->titulo_pagina!=''){ ?>
					<dt>Título Página</dt>
					<dd><?php echo $home_idioma->titulo_pagina?></dd>
					<?php }
					if ($home_idioma->descripcion_pagina!=''){ ?>
					<dt>Descripción Página</dt>
					<dd><?php echo $home_idioma->descripcion_pagina?></dd>
					<?php } ?>
					<?php
					$tags=json_decode(modules::run('services/relations/get_rel','detalle_home','tag',$home_idioma->id_detalle_home,'true'),true);
					if (!empty($tags)){ ?>
					<dt>Tags</dt>
					<?php
						$t=array();
						foreach($tags as $tag){
							echo '<dd>'.$tag['tag'].'</dd>';
						}
					} ?>

				</dl>

				<strong class="boton"><?php echo anchor('home/eliminar_idioma/'.$home_idioma->id_detalle_home,'Eliminar Idioma',array('title'=>"Eliminar Idioma", 'class'=>"delete"))?></strong>
				<strong class="boton"><?php echo anchor('home/editar_idioma/'.$home->id_home.'/'.$home_idioma->id_detalle_home,'Editar Idioma',array('title'=>"Editar Idioma"))?></strong>
				<!-- Inglés cierre-->
			</div>
			<?php } ?>
			<div class="tab" id="tabNewLang">
				<h2>Crear nuevo idioma para la home <?php echo (isset($home->titulo) ? 'Ficha de '.$home->titulo : 'Caja sin titulo')?></h2>

				<?php

				echo modules::run('template/crear_idioma_form',$home->id_home);?>

			</div>


		</div>
