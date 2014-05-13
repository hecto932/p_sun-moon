<div class="container_16 descripcion">
<h2 style="color:#757575; margin-left:35px;"><a href="<?php echo site_url(lang('productos_url')); ?>"><?php echo lang('productos_gama'); ?></a><span style="color:#00a9dd; font-weight:normal;"> > 
<?php if(isset($padre_nombre)&&($padre_nombre!='')){ echo $padre_nombre; } ?></span></h2>
<hr id="hrfooter" />

<ul class="gamaproductos">
	
	<?php  if($error==1){ ?>
	
<br /><h3><?php echo lang('productos_subcategoria_error'); ?></h3>
	
<?php }else{  ?>

	<?php foreach ($subcategorias as $categoria) {
		$nombre = ($categoria->nombre!='' ? $categoria->nombre : $this->lang->line('sin_titulo')); 
		if(isset($categoria->url)&&($categoria->url!='')) { $url=$categoria->url; }else{ $url=$categoria->id_categoria; }

		if (isset($categoria)) { $imagen=modules::run('services/relations/get_rel','categoria','imagen',$categoria->id_categoria,false,'multimedia.id_multimedia');
			//echo '<pre>'.print_r($imagen,TRUE).'</pre>';//die('');		
			
		$img_url=(isset($imagen) && isset($imagen[0]->fichero) && $imagen[0]->fichero!='' ? '/assets/front/img/med/'.$imagen[0]->fichero : $placeholder);
		if(!file_exists(FCPATH.$img_url)) $img_url = $placeholder;
				
		} ?>
<li><span><h2><?php if(strlen($nombre)>26){ echo substr($nombre,0,20).'...'; }else{ echo $nombre; } ?></h2></span>
<img width="200" src="<?php echo $img_url; ?>" /><p><?php echo $categoria->descripcion_breve.'<br>'; ?></p><a href="<?php echo site_url().lang('listado_productos_url').$url; ?>"><?php echo lang('productos_leer'); ?></a></li>
   <?php } ?>
</ul>
<?php } ?>
<div class="clear"></div>
<br />
<br />
<hr id="hrfooter" />
</div>
