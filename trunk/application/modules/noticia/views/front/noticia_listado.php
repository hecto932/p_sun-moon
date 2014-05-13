<?php $this->load->helper('text'); $this->load->helper('misc'); ?>

<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('wtc.titulo_not'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('wtc.titulo_not'); ?></h2>
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

		<div class="radius_content">
			
			<div class="twelve columns hide-for-small">
				<dl class="sub-nav">
			  		<dt><?php echo lang('noticias_orden'); ?></dt>
			  		<?php if($order_active!=1 && $order_active!=2) : ?>
			  		<dd class="active"><a href="<?php echo base_url(); ?>noticias"><?php echo lang('noticias_todas'); ?></a></dd>
			  		<?php else: ?>
			  		<dd><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('noticias_todas'); ?></a></dd>
			  		<?php endif; ?>
			  		<?php if($order_active==2) : ?>
			  		<dd class="active"><a title="<?php echo lang('noticias_semana_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('noticias_semana'); ?></a></dd>
			  		<?php else: ?>
			  		<dd><a title="<?php echo lang('noticias_semana_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('noticias_semana'); ?></a></dd>
			  		<?php endif; ?>
			  		<?php if($order_active==1) : ?>
			  		<dd class="active"><a title="<?php echo lang('noticias_mes_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('noticias_mes'); ?></a></dd>
			  		<?php else: ?>
			  		<dd><a title="<?php echo lang('noticias_mes_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('noticias_mes'); ?></a></dd>
			  		<?php endif; ?>
				</dl>
			</div>
			
			<div class="twelve columns show-for-small">
				<ul class="side-nav">
			  		<li><span style="color: #848484"><?php echo lang('noticias_orden'); ?></span></li>
			  		<li class="divider"></li>
			  		<?php if($order_active!=1 && $order_active!=2) : ?>
			  		<li class="active"><a href="<?php echo base_url(); ?>noticias"><?php echo lang('noticias_todas'); ?></a></li>
			  		<?php else: ?>
			  		<li><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('noticias_todas'); ?></a></li>
			  		<?php endif; ?>
			  		<?php if($order_active==2) : ?>
			  		<li class="active"><a title="<?php echo lang('noticias_semana_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('noticias_semana'); ?></a></li>
			  		<?php else: ?>
			  		<li><a title="<?php echo lang('noticias_semana_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_semana_url'); ?>"><?php echo lang('noticias_semana'); ?></a></li>
			  		<?php endif; ?>
			  		<?php if($order_active==1) : ?>
			  		<li class="active"><a title="<?php echo lang('noticias_mes_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('noticias_mes'); ?></a></li>
			  		<?php else: ?>
			  		<li><a title="<?php echo lang('noticias_mes_title'); ?>" href="<?php echo base_url().lang('noticias_url').'/'.lang('act_mes_url'); ?>"><?php echo lang('noticias_mes'); ?></a></li>
			  		<?php endif; ?>
				</ul>
			</div>

			<div class="noticia_principal">
				<?php if(isset($noticia_principal) && !empty($noticia_principal) && ($noticia_principal->id_estado!=3)): ?>

					<a href="<?php echo base_url().lang('noticias_url').'/'.$noticia_principal->url; ?>">
						<?php
							if ($noticia_principal->fichero != '' && file_exists(FCPATH.'assets/front/img/large/'.$noticia_principal->fichero))
							{
								$img_noticia = base_url().'assets/front/img/large/'.$noticia_principal->fichero;
							}
							else
						    {
								$img_noticia = base_url().'assets/front/img/template/placeholder/placeholder_large.jpg';
							}
						?>
						<img src="<?php echo $img_noticia; ?>">
					</a>
					<a href="<?php echo base_url().lang('noticias_url').'/'.$noticia_principal->url; ?>"><h2><?php echo character_limiter($noticia_principal->nombre, 90); ?></h2></a>
					<?php
						$base_fecha = strtotime($noticia_principal->creado);
						$dia = date('d ', $base_fecha);
						$mes = lang('mes_'.date('n', $base_fecha));
						$anyo = date(' Y', $base_fecha);
					?>
					<small><?php echo $dia.$mes.$anyo; ?></small>
					<p><?php echo character_limiter($noticia_principal->descripcion_breve, 360) ;?></p>
					<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend"></div>
				<?php endif; ?>

			</div>

			<?php if(isset($noticias_secundarias) && !empty($noticias_secundarias)): ?>
				<?php $cont = 1; ?>
				<?php foreach($noticias_secundarias as $noticia): ?>
					<?php if($noticia->id_estado != 3) : ?>
					<div class="six columns mobile-two">
						<div class="noticia_secundaria">
							<a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>">
								<?php
									if ($noticia->fichero != '' && file_exists(FCPATH.'assets/front/img/med/'.$noticia->fichero))
									{
										$img_noticia = base_url().'assets/front/img/med/'.$noticia->fichero;
									}
									else
								    {
										$img_noticia = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
									}
								?>
								<img style="width:247px; height: 185px"; src="<?php echo $img_noticia; ?>">
							</a>
							<a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>" class="hide-for-small"><h2><?php echo character_limiter($noticia->nombre, 55); ?></h2></a>
							<a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>" class="show-for-small"><h6><?php echo character_limiter($noticia->nombre, 55); ?></h6></a>
							<?php
								$base_fecha = strtotime($noticia->creado);
								$dia = date('d ', $base_fecha);
								$mes = lang('mes_'.date('n', $base_fecha));
								$anyo = date(' Y', $base_fecha);
							?>
							<small><?php echo $dia.$mes.$anyo ?></small>
							<p><?php echo character_limiter($noticia->descripcion_breve, 150); ?></p>
							<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend"></div>
						</div>
					</div>
					<?php if($cont%2 == 0): ?>
						<hr>
					<?php endif; ?>
					<?php $cont++; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if(empty($noticias_secundarias) && empty($noticia_principal)): ?>
				<div style="margin: 30px 10px; padding: 30px 10px; background: #E6E6E6;">
					<center>
						<h3>
							<strong><?php echo lang('noticias_no_exist').''; ?></strong>
						</h3>
					</center>
				</div>
			<?php endif; ?>

			<div class="twelve columns">
				<?php if($pagination): ?>
					<?php echo $pagination; ?>
				<?php endif; ?>
			</div>

			<div style="clear:both;"></div>

		</div>
	</div>
	<div class="four columns">
		<div class="radius_content" style="margin-left: -12px; min-width: 310px">
			<h1><?php echo lang('noticias.archivo_tit'); ?></h1>
				<ul>
					<?php if(isset($noticias_archivo) && !empty($noticias_archivo)): ?>
						<?php foreach($noticias_archivo as $noticia): 
								if(strlen($noticia->nombre) < 35) :?>
							<li><a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo ucwords($noticia->nombre); ?></a></li>
						<?php else: ?><li><a href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo ucwords(substr($noticia->nombre,0,35)); ?>...</a></li>
						<?php endif; ?>
						 <?php endforeach; ?>
					<?php endif; ?>
				</ul>
		</div>

<!------------------------------ REDES SOCIALES CONGRESSUS CENTER ------------------------------>
		<div style="position: auto; height: 490px">
			<a class="twitter-timeline" href="https://twitter.com/CongressusWTC" data-widget-id="337634804675792896">Tweets by @CongressusWTC</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div style="margin-left: -12px" class="fb-like-box" data-href="https://www.facebook.com/CongressusCenter" data-width="310" data-show-faces="true" data-stream="false" data-show-border="true" data-header="false"></div>
<!------------------------------ /REDES SOCIALES CONGRESSUS CENTER ------------------------------>


		<!--<div class="radius_content">
			<h1><?php echo lang('noticias.tweet_tit'); ?></h1>
			<div class="tweets_inner"></div>
		</div>


		<div id="fb_box" style="width:100%;">
		  <div class="fb-like-box" data-href="https://www.facebook.com/adobegocreate" data-width="292" data-show-faces="true" data-stream="false" data-header="false"></div>
		</div>-->

	</div>

</div>