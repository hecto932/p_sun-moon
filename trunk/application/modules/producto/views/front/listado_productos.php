<div class="container_16 descripcion">
<h2 style="color:#757575; margin-left:35px;"><a href="<?php echo site_url(lang('productos_url')); ?>"><?php echo lang('productos_gama'); ?></a> <span style="color:#00a9dd; font-weight:normal;"> > 
	<a href="<?php echo site_url(lang('listado_subcategorias_url').$padre_url_1); ?>"><?php if(isset($padre_nombre_1)&&($padre_nombre_1!='')){ echo $padre_nombre_1; } ?></a></span>
	<span style="color:#00a9dd; font-weight:normal;"> > <?php if(isset($padre_nombre_2)&&($padre_nombre_2!='')){ echo $padre_nombre_2; } ?></h2>
<hr id="hrfooter" />

<?php  if($error==1){ ?>
	
	<br /><h3><?php echo lang('productos_error_listado'); ?></h3>
	
<?php }else{  ?>


<ul class="gamaproductosthumbs">
	<?php foreach ($arbol_productos as $producto) {
		
		if(isset($producto->url)&&($producto->url!='')) { $url=$producto->url; }else{ $url=$producto->id_producto; } 	 
		
		$nombre = ($producto->nombre!='' ? $producto->nombre : $this->lang->line('sin_titulo'));
		$where2 = array('multimedia.destacado'=>'2');
		if (isset($producto)) { $imagen=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where2));
			//echo '<pre>'.print_r($imagen,TRUE).'</pre>';die('');		
			
		$img_url=(isset($imagen) && isset($imagen[0]->fichero) && $imagen[0]->fichero!='' ? '/assets/front/img/med/'.$imagen[0]->fichero : $placeholder);
		if(!file_exists(FCPATH.$img_url)) $img_url = $placeholder;
				
		} ?>
								
<li><img src="<?=$img_url?>" width="268" height="113" /><div class="altura_productos"><h3><? if(strlen($nombre)>52){ echo substr($nombre,0,50).'...'; }else echo $nombre;  ?>
</h3>
<p><?php if(strlen($producto->descripcion_breve)>80){ echo substr($producto->descripcion_breve,0,80).'...'; }else echo $producto->descripcion_breve;  ?></p></div>
<a href="<?php echo site_url().lang('detalle_productos_url').$url; ?>"><button class="ver_articulo"><?php echo lang('productos_articulo'); ?></button></a>

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style rating">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f2061da4202e5cb"></script>
<!-- AddThis Button END -->

</li>
<?php }  ?>
</ul>

<?php } ?>

<div class="clear"></div>
<br />
<br />
<hr id="hrfooter" />
</div>