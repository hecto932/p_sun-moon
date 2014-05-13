<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<!--Scripts Galeria Fotos de la casa -->

		<script type="text/javascript" src="../assets/js/jquery.pikachoose.js"></script>
		<script language="javascript">
			$(document).ready(
				function (){
					$("#pikame").PikaChoose({carousel:true});
				});
		</script>

<link href="../assets/css/bottom.css" rel="stylesheet" type="text/css" />



<div class="container_16">
	
	<?php  if($error==1){ ?>
	<br /><h3><?php echo lang('productos_error_detalle'); ?></h3>
	<?php }else{  ?>
 
<div class="grid_8 alpha">

<div class="pikachoose">
			<ul id="pikame" class="jcarousel-skin-pika">
				
			<?php
			if($imagen==NULL) : ?> <li><a><img src="<?php echo $placeholder; ?>" width="430" height="250"/></a></li> <?php endif;
			foreach ($imagen as $img) {
			$img_url=(!empty($img) && isset($img) && isset($img->fichero) && $img->fichero!='' ? '/assets/front/img/med/'.$img->fichero : $placeholder);
			if(!file_exists(FCPATH.$img_url)) $img_url = $placeholder;
			?>
	
							<li><a><img src="<?php echo $img_url; ?>" width="430" height="250"/></a></li>
			<?php } ?>
	
		
			</ul>
		</div>

</div>

<div class="grid_8 omega descripcion altura_descripcion">
	<? $nombre = ($producto->nombre!='' ? $producto->nombre : $this->lang->line('sin_titulo')); ?>
<h2 style="color:#757575;"><?php echo $nombre; ?></h2>
<p><?php echo $producto->descripcion_ampliada; ?></p>
<?php if(isset($producto->codigo_coloplas)&&($producto->codigo_coloplas!='')) {  ?>
<h2 style="color:#757575;"><?php echo lang('productos_codigo').$producto->codigo_coloplas; ?></h2>
<?php }  ?>


<div class="clear"></div>
	

</div>
<div class="grid_8 productos_relacionados">
		<hr id="hrfooter" />
		<ul class="listaproductosdetalle">
			<?php for ($i=0; $i < 2; $i++) {
				$where2 = array('multimedia.destacado'=>'2');
				if (isset($relacion[$i])) { $imagen=json_decode(modules::run('services/relations/get_rel','producto','imagen',$relacion[$i]->id_producto,'true','multimedia.id_multimedia',$where2));	
				$img_url=(isset($imagen) && isset($imagen[0]->fichero) && $imagen[0]->fichero!='' ? '/assets/front/img/thumb/'.$imagen[0]->fichero : $placeholder);
				if(!file_exists(FCPATH.$img_url)) $img_url = $placeholder; } 
				
			if(isset($relacion[$i]->nombre)&&($relacion[$i]->nombre!='')) { ?>
		<li><a href="<?php echo site_url().lang('detalle_productos_url').$relacion[$i]->url; ?>"><img widht="81" height="47" src="<?php echo $img_url; ?>" /></a><a href="<?php echo site_url().lang('detalle_productos_url').$relacion[$i]->url; ?>"><h3><?php echo $relacion[$i]->nombre; ?></h3></a> <br /><p><? echo substr($relacion[$i]->descripcion_breve, 0, 20); ?>...<br /><?php echo lang('productos_leer'); ?></p></li>
			<?php } } ?>
		
		</ul>

</div>
<?php } ?>

<hr id="hrfooter" />
</div>