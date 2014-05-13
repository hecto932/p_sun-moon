		<ul id="tabs">
			<li><a href="#tabFicha" title="">Ficha de la promocion</a></li>
			<?php
			$idiomas=json_decode(modules::run('services/relations/get_all','idioma','true'));
			foreach($promocion_idiomas as $promocion_idioma){
				$idioma[$promocion_idioma->id_idioma]=json_decode(modules::run('services/relations/get_from_id','idioma',$promocion_idioma->id_idioma,'true'));
				?>
			<li><a href="#tabLang<?php echo $promocion_idioma->id_idioma ?>" title=""><?php echo $idioma[$promocion_idioma->id_idioma]->nombre?></a></li>
			<?php } 
			if (count($idiomas) > count($promocion_idiomas)) { ?>
			<li class="toNewLang"><a href="#tabNewLang" title="">Crear nuevo idioma</a></li>	
			<?php } ?>		
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">	
			<!-- Ficha promocion -->
				<h2>Ficha promocion</h2>
	<?php 
	//echo '<pre>'.print_r($promocion,true).'</pre>';
	?>
				<dl class="ficha_obra">
					<dt>Estado</dt>
					<dd><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$promocion->id_estado,'true'));
					echo $estado->estado?></dd>
					<dt>Fecha</dt>
					<dd><?php 

					echo date('d/m/Y',mysql_to_unix($promocion->creado))?></dd>
                    <dt>Destacada</dt>
                    <dd><?php echo ($promocion->destacado==1 ? 'Sí' : 'No')?></dd>
                    <?php if ($promocion->enlace){ ?>
                    <dt>Enlace</dt>
                    <dd><?php echo $promocion->enlace?></dd>
                <?php } ?>

                    <?php
					$img=json_decode(modules::run('services/relations/get_rel','promocion','imagen',$promocion->id_promocion,'true','multimedia.id_multimedia'));
					if (is_array($img) && !empty($img)){ ?>
					<dt>Imagen</dt>
					<?php
					//echo '<pre>'.print_r(json_decode($img),true).'</pre>';


					?>

					<dd><p class="img"><img src="/assets/front/img/med/<?php echo $img[0]->fichero?>" title="miniatura de <?php echo (isset($promocion->nombre) ? $promocion->nombre : 'Noticia sin titulo')?>" /></p></dd>
					<?php 

					} ?>
				</dl>
				<strong class="boton"><?php echo anchor('backend/editar_promocion/'.$promocion->id_promocion,'Editar promocion',array('title'=>"Edita promocion"))?></strong>
				<!-- Ficha promocion cierre -->

				<!--<strong class="boton"><a href="nuevo_idioma_promocion" title="Nuevo Idioma">Nuevo Idioma</a></strong>-->
			</div>
			<?php
			//echo '<pre>'.print_r($promocion_idiomas,true).'</pre>';
			
			foreach($promocion_idiomas as $promocion_idioma){ ?>
                    <?php
			$img=json_decode(modules::run('services/relations/get_rel','promocion','imagen',$promocion->id_promocion,'true'));
			$ni=0;
			foreach($img as $k=>$i){
				if ($i->id_idioma==$promocion_idioma->id_idioma)
					$ni=$k;
			}

			//echo '<pre>'.print_r($img,true).'</pre>';
			?>
			<!-- <?php echo $idioma[$promocion_idioma->id_idioma]->nombre?> -->
			
			<div id="tabLang<?php echo $promocion_idioma->id_idioma?>" class="tab">
				<h2><?php echo $idioma[$promocion_idioma->id_idioma]->nombre?></h2>
				
				<dl class="ficha_obra">
				<?php if ($promocion_idioma->nombre!=''){ ?>
					<dt>Titulo</dt>
					<dd><?php echo $promocion_idioma->nombre?></dd>
					<?php }
                    if ($promocion_idioma->subtitulo!=''){ ?>
					<dt>Subtitulo</dt>
					<dd><?php echo $promocion_idioma->subtitulo?></dd>
					<?php }
                    if ($promocion_idioma->descripcion_breve!=''){ ?>
					<dt>Descripción Breve</dt>
					<dd><?php echo $promocion_idioma->descripcion_breve?></dd>
					<?php }
					if ($promocion_idioma->descripcion_ampliada!=''){ ?>
					<dt>Descripción Ampliada</dt>
					<dd><?php echo $promocion_idioma->descripcion_ampliada?></dd>
					<?php }
                    if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia!=''){ ?>
					<dt>Descripción Imagen</dt>
					<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
					<?php }
                    if ($promocion_idioma->url!=''){ ?>
					<dt>URL</dt>
					<dd><?php echo $promocion_idioma->url?></dd>
					<?php }
                    if ($promocion_idioma->titulo_pagina!=''){ ?>
					<dt>Título Página</dt>
					<dd><?php echo $promocion_idioma->titulo_pagina?></dd>
					<?php }
					if ($promocion_idioma->descripcion_pagina!=''){ ?>
					<dt>Descripción Página</dt>
					<dd><?php echo $promocion_idioma->descripcion_pagina?></dd>
					<?php }if ($promocion_idioma->keywords!=''){ ?>
					<dt>Palabras clave</dt>
					<dd><?php echo $promocion_idioma->keywords?></dd>
					<?php }  ?>
					
					
					
				</dl>
	
				<strong class="boton"><?php echo anchor('promocion/eliminar_idioma/'.$promocion_idioma->id_detalle_promocion,'Eliminar Idioma',array('title'=>"Eliminar Idioma", 'class'=>"delete"))?></strong>
				<strong class="boton"><?php echo anchor('promocion/editar_idioma/'.$promocion->id_promocion.'/'.$promocion_idioma->id_detalle_promocion,'Editar Idioma',array('title'=>"Editar Idioma"))?></strong>
				<!-- Inglés cierre-->
			</div>
			<?php } ?>
			<div class="tab" id="tabNewLang">
				<h2>Crear nuevo idioma para la promocion <?php echo (isset($promocion->nombre) ? 'Ficha de '.$promocion->nombre : 'promocion sin titulo')?></h2>
				
				<?php
				
				echo modules::run('template/crear_idioma_form',$promocion->id_promocion,'promocion');?>
				
			</div>
			
			
		</div>
