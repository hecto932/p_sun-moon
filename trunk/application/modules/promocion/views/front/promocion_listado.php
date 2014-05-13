<div class="container_16 noticias">

<h1><?php echo $this->lang->line('promociones') ?></h1>
<hr />
<?php 
		$detalle = false;
		
		if (isset($promocion_detalle) && !empty($promocion_detalle)){
			$promocion = $promocion_detalle;
			$detalle = true;
			$nombre = ($promocion->nombre!='' ? $promocion->nombre : $this->lang->line('sin_titulo'));
			$subtitulo = ($promocion->subtitulo!='' ? $promocion->subtitulo : '');
			$descripcion_breve = ($promocion->descripcion_breve!='' ? $promocion->descripcion_breve : $this->lang->line('sin_titulo'));
			$descripcion_ampliada = ($promocion->descripcion_ampliada!='' ? $promocion->descripcion_ampliada : $descripcion_breve);
			$url = $this->lang->line('sala_prensa.promociones_url').'/';
			$url .=($promocion->url!='' ? $promocion->url : $promocion->id_promocion);
			
			$url_fb = $url;
			$img=(modules::run('services/relations/get_rel','promocion','imagen',$promocion->id_promocion,false));
			$direc = "http://dummyimage.com/280x180/f5ede6/000.jpg";
			$img_url=(isset($img) && isset($img[0]->fichero) && $img[0]->fichero!='' ? '/assets/front/img/med/'.$img[0]->fichero : $direc);
			
			//echo '<pre> Imagen'.print_r($img,true).'</pre>';
			
			//$img_url=(isset($img) && is_array($img) ? '/assets/front/img/thumb/'.$img[0]->fichero : $direc);
			
			$img_descrip = $descripcion_breve;
			$fecha = date('d-m-Y',strtotime($promocion->creado));
			$fecha2 = date('d/m/Y',strtotime($promocion->creado));
			?>
				<div class=" grid_10">
					<!--  <img src="assets/front/images/promociones.jpg" alt="promociones" width="280" height="180" class="grid_5" /> -->
					<img src="<?php echo $img_url?>" alt="<?php echo $img_descrip?>" title="<?php echo $img_descrip?>" width="280" height="180" class="grid_5" />
					<h2><?php echo $nombre?></h2>
					<p><?php echo $fecha?></p>
					<?php echo modules::run('template/facebook',$url)?>
					<p><?php echo $subtitulo?></p>
					
					<div class="clear"></div>
					<div class="clear"></div>
					<br/>
					<h2><?php echo $nombre?></h2>
					<p><?php echo $descripcion_ampliada?> </p>
					<br/>
					<?php echo modules::run('template/addthis',$url)?>
					
					<hr class="hrtransparente" />
				</div>
			<?php 
			}
?>
	<?php 
	if (is_array($promociones) && !empty($promociones)){
		$li = 0;
		$promociones = array_reverse($promociones);
  		ksort($promociones); 
  		if(count($promociones)>6) $promociones = array_slice($promociones, 0, 6);
  		
  		$promocion_count = 0;
  		$listado = false;
		foreach($promociones as $promocion)
		{
			
			$nombre = ($promocion->nombre!='' ? $promocion->nombre : $this->lang->line('sin_titulo'));
			$descripcion_breve = ($promocion->descripcion_breve!='' ? $promocion->descripcion_breve : $this->lang->line('sin_titulo'));
			$descripcion_ampliada = ($promocion->descripcion_ampliada!='' ? $promocion->descripcion_ampliada : $descripcion_breve);
			$url = $this->lang->line('sala_prensa.promociones_url').'/';
			$url .=($promocion->url!='' ? $promocion->url : $promocion->id_promocion);
			
			$img=(modules::run('services/relations/get_rel','promocion','imagen',$promocion->id_promocion,false));
			$direc = "http://dummyimage.com/280x180/f5ede6/000.jpg";
			$img_url=(isset($img) && isset($img[0]->fichero) && $img[0]->fichero!='' ? '/assets/front/img/med/'.$img[0]->fichero : $direc);
			
			//echo '<pre> Imagen'.print_r($img,true).'</pre>';
			
			//$img_url=(isset($img) && is_array($img) ? '/assets/front/img/thumb/'.$img[0]->fichero : $direc);
			
			$img_descrip = $descripcion_breve;
			$fecha = date('d-m-Y',strtotime($promocion->creado));
			$fecha2 = date('d/m/Y',strtotime($promocion->creado));
			if($promocion_count<1 && $listado!= true && $detalle!=true) {
			?>
			<div class=" grid_10">
				<!--  <img src="assets/front/images/promociones.jpg" alt="promociones" width="280" height="180" class="grid_5" /> -->
				<img src="<?php echo $img_url?>" alt="<?php echo $img_descrip?>" width="280" height="180" class="grid_5" />
				<h2><?php echo $nombre?></h2>
				<p><?php echo $fecha?></p>
				<?php echo modules::run('template/facebook',$url)?>
				<p><?php echo $descripcion_breve?></p>
				
				<div class="clear"></div>
				<div class="clear"></div>
				<br/>
				<h2><?php echo $nombre?></h2>
					<p></p>
					<p><?php echo $descripcion_ampliada?> </p>
					<?php echo modules::run('template/addthis',$url)?>
				<hr class="hrtransparente" />
			</div>
			
			<?php 
			$url_fb = $url;
			}
			else {
				if($listado!=true)
				{ 
					$listado = true;
					?>
					<div class="grid_6">
						<h2>indice de promociones</h2>
						<ul class="stones">
					<?php 
				}
				?>
					<li><a href="<?php echo $url?>" title="<?php echo $nombre?>"><?php echo $nombre?> - [<?php echo $fecha2?>]</a></li>
					
			<?php
			}
			$promocion_count++;
		}
		if($listado!=false) echo '</ul>';
	}
	?>
					
<?php 
if($listado!=true){
?>
		<div class="grid_6">
			<h2>indice de promociones</h2>
				<ul class="stones">
				</ul>
<?php 
}
?>

<h3>Redes Sociales</h3>
<ul id="redessociales">
<!-- <li><a href="#"><img src="assets/front/images/fblogo.png" width="29" height="30" />Siguenos en Facebook</a> </li>  -->

<li>
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/'.$url_fb;?>" num_posts="6" width="350"></fb:comments> 
</li>

<li><a href="<?php echo $this->lang->line('twitter_url') ?>"><img src="assets/front/images/twitterlogo.png" width="30" height="30" />Siguenos en Twitter</a></li>
<li><a href="/<?php echo $this->lang->line('sala_prensa.noticias_url') ?>"><img src="assets/front/images/sobre.png" alt="botoncontacto" width="30" height="30" />Contacto</a></li>
</ul>
</div>

</div> <!-- Cierre Container 16 -->