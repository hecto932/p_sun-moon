		<ul id="tabs">
			<li><a href="#tabFicha" title=""> <?php echo $this->lang->line('proyecto_ficha_titulo')?></a></li>
			<?php
			$idiomas=json_decode(modules::run('services/relations/get_all','idioma','true'));
			foreach($producto_idiomas as $producto_idioma){ 
				$idioma[$producto_idioma->id_idioma]=json_decode(modules::run('services/relations/get_from_id','idioma',$producto_idioma->id_idioma,'true'));
				?>
			<li><a href="#tabLang<?php echo $producto_idioma->id_idioma ?>" title=""><?php echo $idioma[$producto_idioma->id_idioma]->nombre?></a></li>
			<?php } 
			if (count($idiomas) > count($producto_idiomas)) { ?>
			<li class="toNewLang"><a href="#tabNewLang" title=""> <?php echo lang('idioma_crear'); ?> </a></li>	
			<?php } ?>		
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">	
			<!-- Ficha Producto -->
				<h2>Ficha <?php echo $this->lang->line('buscar_tit_prod'); ?></h2>
	<?php 
	//echo '<pre>'.print_r($producto,true).'</pre>';
	?>
				<dl class="ficha_obra">
				
					<dt>Codigo <?php echo $this->lang->line('producto')?></dt>
					<dd><?php echo $producto->codigo_coloplas?></dd>
					<dt> <?php echo $this->lang->line('estado'); ?> </dt>
					<dd><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$producto->id_estado,'true'));
					echo $estado->estado?></dd>
					<dt> <?php echo $this->lang->line('categoria_padre'); ?> </dt>
					<?php 
					if (isset($cat_path) && !empty($cat_path)){ 
						foreach($cat_path as $k=>$cat){
							$c[]=anchor('backend/ficha_categoria/'.$k,$cat);
						}
						?>
					
					<dd><?php echo implode(' &raquo; ',$c)?></dd>
					<?php }else{ ?>
					
					<dd> <?php echo lang('raiz'); ?> </dd>
					<?php
					}
					?>
					<dt> <?php echo lang('destacado'); ?> </dt>
					<dd><?php echo ($producto->destacado==1 ?  lang('respuesta_si') : lang('respuesta_no'))?></dd>
					
					<?php if ($producto->enlace){ ?>
                    <dt> <?php echo lang('enlace_gmaps'); ?> </dt>
                    <dd> 	<a href="<?php echo $producto->enlace?>" alt="<?php echo (isset($producto->nombre) ? 'Mapa de '.$producto->nombre : 'Proyecto sin Mapa')?>">Mapa de <?php echo (isset($producto->nombre) ? $producto->nombre : 'Proyecto sin Mapa')?>
                            </a>
                    </dd>
                	<?php } ?>
                
 					<?php if ($producto->enlace_video){ ?>
                    <dt> <?php echo lang('enlace_video'); ?> </dt>
                    <dd> 	<a href="<?php echo $producto->enlace_video?>" alt="<?php echo (isset($producto->nombre) ? 'Video de '.$producto->nombre : 'Proyecto sin Video')?>">Video de <?php echo (isset($producto->nombre) ? $producto->nombre : 'Proyecto sin Video')?>
                            </a>
                    </dd>
                	<?php } ?>
                	
                	               
					<?php 
					$where = array('multimedia.destacado'=>'1');
					$img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where));
					if (is_array($img) && !empty($img)){ ?>
					<dt> <?php echo lang('imagen_logo'); ?> (140x100)</dt>
					<?php 
					//echo '<pre>'.print_r(json_decode($img),true).'</pre>'; 
					foreach($img as $k=>$im){
						
					?>
					
					<dd><p class="img"><img src="/assets/front/img/med/<?php echo $im->fichero?>" title="miniatura de <?php echo (isset($producto->titulo) ? $producto->titulo : 'Producto sin titulo')?>" /></p></dd>
					<?php }
					
					} ?>
					
					<?php 
					$where = array('multimedia.destacado'=>'2');
					$img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where));
					if (is_array($img) && !empty($img)){ ?>
					<dt> <?php echo lang("imagenes"); ?> (530x250)</dt>
					<?php 
					//echo '<pre>'.print_r(json_decode($img),true).'</pre>'; 
					foreach($img as $k=>$im){
						
					?>
					
					<dd><p class="img"><img src="/assets/front/img/med/<?php echo $im->fichero?>" title="miniatura de <?php echo (isset($producto->titulo) ? $producto->titulo : 'Producto sin titulo')?>" /></p></dd>
					<?php }
					
					} ?>
					
					<?php if (isset($producto_productos) && is_array($producto_productos) && !empty($producto_productos)){ ?>
					<dt> <?php echo lang("producto_relacionados"); ?> </dt>
					<dd>
						<ul>
							<?php 
							foreach ($producto_productos as $p){
								echo '<li>'.$p->id_producto_relacionado.' - '.$p->titulo.'</li>';
								
							} ?>
						</ul>
					</dd>
					<?php
					}
					?>
				</dl>
				<strong class="boton"><?php echo anchor('backend/editar_'.$this->lang->line('producto_url').'/'.$producto->id_producto,'Editar '.$this->lang->line('producto'),array('title'=>"Edita ".$this->lang->line('producto')))?></strong>
				<!-- Ficha Producto cierre -->

				<!--<strong class="boton"><a href="nuevo_idioma_producto" title="Nuevo Idioma">Nuevo Idioma</a></strong>-->
			</div>
			<?php
			//echo '<pre>'.print_r($producto_idiomas,true).'</pre>';
			
			foreach($producto_idiomas as $producto_idioma){ ?>
			<?php 
			$img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true'));
			$ni=0;
			foreach($img as $k=>$i){
				if ($i->id_idioma==$producto_idioma->id_idioma)
					$ni=$k;
			}
			
			//echo '<pre>'.print_r($img,true).'</pre>';
			?>
			<!-- <?php echo $idioma[$producto_idioma->id_idioma]->nombre?> -->
			
			<div id="tabLang<?php echo $producto_idioma->id_idioma?>" class="tab">
				<h2><?php echo $idioma[$producto_idioma->id_idioma]->nombre?></h2>
				
				<dl class="ficha_obra">
				<?php 
					if ($producto_idioma->nombre!=''){ ?>
					<dt> <?php lang('producto_ficha_nombre'); ?> </dt>
					<dd><?php echo $producto_idioma->nombre?></dd>
					<?php }
					if ($producto_idioma->descripcion_breve!=''){ ?>
					<dt> <?php lang('producto_ficha_descB'); ?> </dt>
					<dd><?php echo $producto_idioma->descripcion_breve?></dd>
					<?php }
					if ($producto_idioma->titulo!=''){ ?>
					<dt> <?php lang('producto_ficha_titulo'); ?> </dt>
					<dd><?php echo $producto_idioma->titulo?></dd>
					<?php }
					if ($producto_idioma->descripcion_ampliada!=''){ ?>
					<dt> <?php lang('producto_ficha_descA'); ?> </dt>
					<dd><?php echo $producto_idioma->descripcion_ampliada?></dd>
					<?php }
					
					if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia!=''){ ?>
					<dt> <?php lang('producto_ficha_descI'); ?> </dt>
					<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
					<?php }
			        if ($producto_idioma->pdf!=''){ ?>
					<dt> <?php lang('producto_ficha_pdf'); ?> </dt>
					<dd><?php echo anchor('assets/front/pdf/'.$producto_idioma->pdf,'ver brochure')?></dd>
					<?php }
					if ($producto_idioma->url!=''){ ?>
					<dt> <?php lang('producto_ficha_url'); ?> </dt>
					<dd><?php echo $producto_idioma->url?></dd>
					<?php }
					if ($producto_idioma->titulo_pagina!=''){ ?>
					<dt>  <?php lang('producto_ficha_paginaT'); ?> </dt>
					<dd><?php echo $producto_idioma->titulo_pagina?></dd>
					<?php }
					if ($producto_idioma->descripcion_pagina!=''){ ?>
					<dt> <?php lang('producto_ficha_paginaD'); ?> </dt>
					<dd><?php echo $producto_idioma->descripcion_pagina?></dd>
					<?php } ?>
					<?php if ($producto_idioma->email_empresa_contacto!=''){ ?>
					<dt> <?php lang('producto_ficha_emailC'); ?> </dt>
					<dd><?php echo $producto_idioma->email_empresa_contacto?></dd>
					<?php } ?>
					<?php if ($producto_idioma->url_facebook!=''){ ?>
					<dt> <?php lang('producto_ficha_facebook'); ?> </dt>
					<dd><?php echo $producto_idioma->url_facebook?></dd>
					<?php } ?>
					<?php if ($producto_idioma->url_twitter!=''){ ?>
					<dt> <?php lang('producto_ficha_twitter'); ?> </dt>
					<dd><?php echo $producto_idioma->url_twitter?></dd>
					<?php } ?>
					<?php if ($producto_idioma->url_gmap!=''){ ?>
					<dt> <?php lang('producto_ficha_gmaps'); ?> </dt>
					<dd><?php echo $producto_idioma->url_gmap?></dd>
					<?php } ?>
				</dl>
	
				<strong class="boton"><?php echo anchor($this->lang->line('producto_url').'/eliminar_idioma/'.$producto_idioma->id_detalle_producto,'Eliminar Idioma',array('title'=>lang('idioma_eliminar'), 'class'=>"delete"))?></strong>
				<strong class="boton"><?php echo anchor($this->lang->line('producto_url').'/editar_idioma/'.$producto->id_producto.'/'.$producto_idioma->id_detalle_producto,'Editar Idioma',array('title'=> lang('idioma_editar')))?></strong>
				<!-- Inglés cierre-->
			</div>
			<?php } ?>
			<div class="tab" id="tabNewLang">
				<h2>Crear nuevo idioma para <?php echo $this->lang->line('producto')?> <?php echo (isset($producto->titulo) ? lang("ficha_inicio").$producto->titulo : $this->lang->line('producto').' sin titulo')?></h2>
				<?php
				echo modules::run('template/crear_idioma_form',$producto->id_producto);?>
				
			</div>
			
			
		</div>
