<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo $detalle_noticia->nombre; ?></h1>
			<h2 class="show-for-small"><?php echo $detalle_noticia->nombre; ?></h2>
			<ul class="breadcrumbs hide-for-touch">
				<?php if(isset($breadcrumbs) && !empty($breadcrumbs)): ?>
					<?php
						$cont = 1;
						$limite = count($breadcrumbs);
						foreach($breadcrumbs as $key => $value):
					?>
						<?php if($cont == $limite): ?>
							<li class="current" ><a href="#"><?php echo $value; ?></a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url().$key; ?>"><?php echo $value; ?></a></li>
						<?php endif; ?>

					<?php
						$cont++;
						endforeach;
					?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>


<div class="row">
	<div class="eight columns">

		<a class="small button secondary listado show-for-touch" href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('noticias_volver'); ?></a>

		<div class="radius_content">

			<div class="noticia_principal_inner">
				<?php
					
					if (isset($imagen_principal[0]->fichero) && file_exists(FCPATH.'assets/front/img/large/'.$imagen_principal[0]->fichero))
					{
						$img_noticia = base_url().'assets/front/img/large/'.$imagen_principal[0]->fichero;
					}
					else
				    {
						$img_noticia = base_url().'assets/front/img/template/placeholder/placeholder_large.jpg';
					}
				?>
				<img src="<?php echo $img_noticia; ?>" />

				<h2><?php echo $detalle_noticia->nombre; ?></h2>

				<?php
					$base_fecha = strtotime($detalle_noticia->creado);
					$dia = date('d ', $base_fecha);
					$mes = lang('mes_'.date('n', $base_fecha));
					$anyo = date(' Y', $base_fecha);
				?>

				<small><?php echo $dia.$mes.$anyo; ?></small>

				<?php if(isset($detalle_noticia->descripcion_ampliada) && $detalle_noticia->descripcion_ampliada != ''): ?>
					<?php echo $detalle_noticia->descripcion_ampliada; ?>
				<?php endif; ?>


				<span class='st_facebook_hcount' displayText='Facebook'></span>
				<span class='st_twitter_hcount' displayText='Tweet'></span>


			</div>

			<div class="row">
			<div class="twelve columns hide-for-small miniaturas_detalle">

				<?php if(isset($imagenes_secundarias)): ?>
					<?php foreach($imagenes_secundarias as $imagen): ?>
						<div class="three columns">
							<?php
								if ($imagen->fichero != '' && file_exists(FCPATH.'assets/front/img/large/'.$imagen->fichero) && file_exists(FCPATH.'assets/front/img/thumb/'.$imagen->fichero))
								{
									$img_thumb = base_url().'assets/front/img/large/'.$imagen->fichero;
									$img_large = base_url().'assets/front/img/thumb/'.$imagen->fichero;
								}
								else
							    {
									$img_thumb = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
									$img_large = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
								}
							?>
							<a href="<?php echo $img_large; ?>" class="th fancybox">
								<img src="<?php echo $img_thumb; ?>" />
							</a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<div style="clear: both;"></div>

			</div>


			<div class="twelve columns show-for-small miniaturas_detalle_mobile">

				<?php if($imagenes_secundarias): ?>
					<?php foreach($imagenes_secundarias as $imagen): ?>
						<div class="mobile-two three columns">
							<a href="<?php echo base_url().'assets/front/img/large/'.$imagen->fichero; ?>" class="th fancybox">
								<img src="<?php echo base_url().'assets/front/img/thumb/'.$imagen->fichero; ?>" />
							</a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

			</div>

			<div style="clear: both;"></div>

		</div>



		</div>

	<a class="small button secondary listado show-for-touch" href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('noticias_volver'); ?></a>

	</div>

	<div class="four columns">

		<div class="radius_content" style="margin-left: -12px; min-width: 310px">
			<h1><?php echo lang('noticias.archivo_tit'); ?></h1>

			<ul>
				<?php if(isset($noticias_archivo) && !empty($noticias_archivo)): ?>
					<?php foreach($noticias_archivo as $noticia):
						if(strlen($noticia->nombre) < 38) :?>
							<li><a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo ucwords($noticia->nombre); ?></a></li>
						<?php else: ?><li><a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo ucwords(substr($noticia->nombre,0,38)); ?>...</a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>

		<!--<div class="radius_content">
			<h1><?php echo lang('noticias.tweet_tit'); ?></h1>
			<div class="tweets_inner"></div>
		</div>

		<div id="fb_box" style="width:100%;">
		  <div class="fb-like-box" data-href="https://www.facebook.com/adobegocreate" data-width="292" data-show-faces="true" data-stream="false" data-header="false"></div>
		</div>-->
		
<!------------------------------ REDES SOCIALES CONGRESSUS CENTER ------------------------------>
		<div style="position: auto; height: 490px">
			<a class="twitter-timeline" href="https://twitter.com/CongressusWTC" data-widget-id="337634804675792896">Tweets by @CongressusWTC</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div style="margin-left: -12px" class="fb-like-box" data-href="https://www.facebook.com/CongressusCenter" data-width="310" data-show-faces="true" data-stream="false" data-show-border="true" data-header="false"></div>
<!------------------------------ /REDES SOCIALES CONGRESSUS CENTER ------------------------------>



	</div>

</div>