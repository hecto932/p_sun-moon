<?php
//$cat_path=modules::run('services/relations/get_categoria_path/',$categoria->id_categoria)

?>
	<ul id="tabs">
			<li><a href="#tabFicha" title=""> <?php echo lang('categoria_fic_tit'); ?> </a></li>
	<?php
			$idiomas=json_decode(modules::run('services/relations/get_all','idioma','true'));
			foreach($categoria_idiomas as $categoria_idioma){ 
				$idioma[$categoria_idioma->id_idioma]=json_decode(modules::run('services/relations/get_from_id','idioma',$categoria_idioma->id_idioma,'true'));
				?>
			<li><a href="#tabLang<?php echo $categoria_idioma->id_idioma; ?>" title=""><?php echo $idioma[$categoria_idioma->id_idioma]->nombre?></a></li>
			<?php } 
			if (count($idiomas) > count($categoria_idiomas)) { ?>
			<li class="toNewLang"><a href="#tabNewLang" title=""><?php echo lang('idioma_crear')?> </a></li>	
			<?php } ?>		
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">	
			<!-- Ficha Obra -->
				<h2> <?php echo lang('categoria_fic_tit');?> </h2>
	<?php 
	//echo '<pre>'.print_r($categoria,true).'</pre>';
	?>
				<dl class="ficha_obra">
					<dt> <?php echo lang('estado');?> </dt>
					<dd><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$categoria->id_estado,'true'));
					echo $estado->estado?></dd>
					
					<?php 
					//echo '<pre>'.print_r($cat_path,true).'</pre>';
					if (isset($cat_path) && !empty($cat_path)){ 
						foreach($cat_path as $k=>$cat){
							$c[]=anchor('backend/ficha_categoria/'.$k,$cat);
						}
						?>
					<dt> <?php echo lang('categoria_padre'); ?> </dt>
					<dd><?php echo implode(' &raquo; ',$c)?></dd>
					<?php }else{ ?>
					<dt> <?php echo lang('categoria_padre'); ?> </dt>
					<dd> <?php echo lang('raiz'); ?> </dd>
					<?php
					}
					?>
					<dt> <?php echo lang('destacado'); ?> </dt>
					<dd><?php echo ($categoria->destacado==1 ? lang('respuesta_si') : lang('respuesta_no'))?></dd>
					<?php 
					
					$img=json_decode(modules::run('services/relations/get_rel','categoria','imagen',$categoria->id_categoria,'true','multimedia.id_multimedia'));
					if (is_array($img) && !empty($img)){ ?>
					
					<dt> <?php echo lang('imagen'); ?> </dt>
					<?php 
					//echo '<pre>'.print_r(json_decode($img),true).'</pre>'; 
					foreach($img as $k=>$im){
						
					?>
					
					<dd><p class="img"><img src="/assets/front/img/med/<?php echo $im->fichero?>" title="miniatura de <?php echo lang('imagen_miniatura').' '.(isset($categoria->nombre) ? $categoria->nombre : lang('categoria_sinnombre'))?>" /></p></dd>
					<?php }
					
					} ?>
                    </dl>
                    
                   <strong class="boton"><?php echo anchor('backend/editar_categoria/'.$categoria->id_categoria, lang('categoria_edi_tit') ,array('title'=> lang('categoria_edi_tit')))?></strong>   
                    
	

				<!-- Inglés cierre-->
			</div>
            <?php
			//echo '<pre>'.print_r($categoria_idiomas,true).'</pre>';
			foreach($categoria_idiomas as $categoria_idioma){ ?>
			<?php 
			//
			$img=json_decode(modules::run('services/relations/get_rel','categoria','imagen',$categoria->id_categoria,'true'));
			$ni=0;
			foreach($img as $k=>$i){
				if ($i->id_idioma==$categoria_idioma->id_idioma)
					$ni=$k;
			}
			
			?>
			<!-- <?php echo $idioma[$categoria_idioma->id_idioma]->nombre?> -->
			
			<div id="tabLang<?php echo $categoria_idioma->id_idioma?>" class="tab">
				<h2><?php echo $idioma[$categoria_idioma->id_idioma]->nombre?></h2>
				
				<dl class="ficha_obra">
				<?php if ($categoria_idioma->nombre!=''){ ?>
					<dt> <?php echo lang('categoria_fic_nom'); ?> Nombre</dt>
					<dd><?php echo $categoria_idioma->nombre?></dd>
					
					<?php }
					if ($categoria_idioma->descripcion_breve!=''){ ?>
					<dt> <?php echo lang('categoria_fic_dscB'); ?> </dt>
					<dd><?php echo $categoria_idioma->descripcion_breve?></dd>
					<?php }
					if ($categoria_idioma->descripcion_ampliada!=''){ ?>
					<dt> <?php echo lang('categoria_fic_dscA'); ?> </dt>
					<dd><?php echo $categoria_idioma->descripcion_ampliada?></dd>
					<?php }
					if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia!=''){ ?>
					<dt> <?php echo lang('categoria_fic_dscI'); ?> </dt>
					<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
					<?php }
					if ($categoria_idioma->url!=''){ ?>
					<dt> <?php echo lang('categoria_fic_url'); ?> </dt>
					<dd><?php echo $categoria_idioma->url?></dd>
					<?php }
					if ($categoria_idioma->titulo_pagina!=''){ ?>
					<dt> <?php echo lang('categoria_fic_pagT'); ?> </dt>
					<dd><?php echo $categoria_idioma->titulo_pagina?></dd>
					<?php }
					if ($categoria_idioma->descripcion_pagina!=''){ ?>
					<dt> <?php echo lang('categoria_fic_pagD'); ?> </dt>
					<dd><?php echo $categoria_idioma->descripcion_pagina?></dd>
					<?php } ?>
					
					
				</dl>
	
				<strong class="boton"><?php echo anchor('categoria/eliminar_idioma/'.$categoria_idioma->id_detalle_categoria, lang('idioma_eliminar'), array('title'=> lang('idioma_eliminar'),'class'=>'delete'))?></strong>
				<strong class="boton"><?php echo anchor('categoria/editar_idioma/'.$categoria->id_categoria.'/'.$categoria_idioma->id_detalle_categoria, lang('idioma_editar'), array('title'=>lang('idioma_editar')))?></strong>
				<!-- Inglés cierre-->
			</div>
			<?php } ?>
			<div class="tab" id="tabNewLang">
				
				<h2> <?php echo lang('idioma_crear_tit').' '.lang('categoria').' '; ?>  <?php echo (isset($categoria->nombre) ? $categoria->nombre : lang('sinnombre'))?></h2>
				
				<?php echo modules::run('template/crear_idioma_form2',$categoria->id_categoria,'categoria');?>
				
			</div>
			
			
		</div>

