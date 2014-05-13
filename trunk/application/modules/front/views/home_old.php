<?php $this->load->helper('text'); $this->load->helper('misc'); //die_pre($banners);?>



<div class="100width fondo_banner">

	<div class="container hide-for-small">
			<section id="jms-slideshow" class="jms-slideshow">
				<div class="step" data-color="color-1" data-x="2000" data-y="1000" data-z="3000" data-rotate="-20">

				</div>
				<div class="step" data-color="color-2" data-x="1000" data-z="2000" data-rotate="20">

				</div>
				<div class="step" data-color="color-3" data-x="2000" data-y="1500" data-z="1000" data-rotate="20">

				</div>

				<div class="step" data-color="color-4" data-x="2000" data-y="2000" data-z="1000" data-rotate="20">

				</div>

				<div class="step" data-color="color-5" data-x="2000" data-y="2000" data-z="1000" data-rotate="20">

				</div>

			</section>
        </div>
</div>

<div class="100width fondo_banner_mobile show-for-small">

</div>
<div class="row hide-for-small">
	<div class="twelve columns margin_cuadros">
		<ul class="cuadros_banner">
			<li class="blanco">
				<h1><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('home.noticias'); ?></a></h1>
				<h2><?php echo lang('home.noticias_tit'); ?></h2>
				<ul class="eventos_home">
					<?php if(!empty($noticias_home)): ?>
						<?php foreach ($noticias_home as $noticia): ?>
							<li>
								<span class="evento"><a style="color: #2E2E2E" href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo character_limiter($noticia->nombre, 20); ?></a></span>
								<span><strong><?php echo date("d-M", strtotime($noticia->fecha_creacion)); ?></strong></span>
							</li>
						<?php endforeach; ?>
					<?php else: ?>
						<li><span class="evento>"><?php echo lang('notcias_homeno'); ?></span></li>
						<p></p>
					<?php endif; ?>
				</ul>
				<a href="<?php echo base_url().lang('noticias_url'); ?>" class="button small float_right_button" style="margin-top: 20px"><?php echo lang('home.noticias_mas'); ?></a>
			</li>

			<li class="naranja">
				<h3><a style="color: #FFF" href="<?php echo lang('hospedaje_url'); ?>"><?php echo lang('home.hospedate'); ?></a></h3>
				<h2><?php echo lang('home.hospedate_slogan'); ?></h2>
				<p><?php echo lang('home.hospedate_desc'); ?></p>
				<a href="servicios_wtc/hospedaje" class="button small float_right_button" style="margin-top: 35px"><?php echo lang('home.asociacion_info'); ?></a>
			</li>

			<li class="azul">
				<h3 style="font-size: 21px"><a style="color: #FFF" href="<?php echo base_url().lang('membresias_wtc_url'); ?>"><?php echo lang('home.membresias'); ?></a></h3>
				<h2><?php echo lang('home.membresias_slogan'); ?></h2>
				<img style="float:left; padding-right: 10px;" src="<?php echo base_url(); ?>assets/front/img/temp/creditcard_1.png" />
				<p><?php echo lang('home.membresias_desc'); ?></p>
				<a href="membresias_wtc" class="button white small float_right_button " style="margin-top: 35px"><?php echo lang('home.membresias_info'); ?></a>
			</li>
		</ul>
	</div>
</div>

<div class="row hide-for-small">
	<div class="twelve columns texto-central">
		<h1><?php echo lang('home.tit_principal'); ?></h1>
	</div>
</div>

<div class="row show-for-small">
	<div class="twelve columns margin_cuadros">
		<ul class="cuadros_banner">
			<li class="blanco_movil">
				<h1><a href="<?php echo base_url().lang('noticias_url'); ?>"><?php echo lang('home.noticias'); ?></a></h1>
				<h2><?php echo lang('home.noticias_tit'); ?></h2>
				<ul class="eventos_home">
					<?php if(!empty($noticias_home)): ?>
						<?php foreach ($noticias_home as $noticia): ?>
							<li>
								<span class=""><?php echo character_limiter($noticia->nombre, 80); ?></span>
								<div style="float: right;"><span style="margin-right: 25px"><strong><?php echo date("d-M-Y", strtotime($noticia->fecha_creacion)); ?></strong></span></div>
							</li>
						<?php endforeach; ?>
					<?php else: ?>
						<li><span class="evento>"><?php echo lang('notcias_homeno'); ?></span></li>
						<p></p>
					<?php endif; ?>
				</ul>
				<a href="<?php echo base_url().lang('noticias_url'); ?>" class="button small float_right_button"><?php echo lang('home.noticias_mas'); ?></a>

			</li>

			<li class="naranja_movil">
				<h3><a style="color: #FFF" href="<?php echo lang('hospedaje_url'); ?>"><?php echo lang('home.hospedate'); ?></a></h3>
				<h2><?php echo lang('home.hospedate_slogan'); ?></h2>
				<p><?php echo lang('home.hospedate_desc'); ?></p>
				<div style="clear:both;"></div>
				<a href="hmr" class="button small float_right_button"><?php echo lang('home.asociacion_info'); ?></a>
			</li>

			<li class="azul_movil">
				<h3><a style="color: #FFF" href="<?php echo base_url().lang('membresias_wtc_url'); ?>"><?php echo lang('home.membresias'); ?></a></h3>
				<h2><?php echo lang('home.membresias_slogan'); ?></h2>
				<img style="float:left; padding-right: 10px;" src="../../assets/front/img/temp/creditcard_1.png" />
				<p><?php echo lang('home.membresias_desc'); ?></p>
				<div style="clear:both;"></div>
				<a href="membresias_wtc" class="button white small float_right_button"><?php echo lang('home.membresias_info'); ?></a>
			</li>
		</ul>
	</div>
</div>


<div class="row">

	<div class="eight columns">
<?php //die_pre($eventos_home); ?>
		<div class="radius_content noticias_home_height">
			<h1><?php echo lang('home.eventos'); ?></h1>
				
				<?php if(isset($eventos_home) && !empty($eventos_home)): ?>
					<?php foreach($eventos_home as $evento): ?>
						<?php if($evento->hora_evento == '00:00:00') : ?>
							<?php $evento->hora_evento = lang('eventos_centropsd');?>
						<?php else : ?>
							<?php
								$base_hora = strtotime($evento->hora_evento);
								$evento->hora_evento = date('g:i A', $base_hora).' / '.date('G:i', $base_hora);
							?>
						<?php endif; ?>
						<div class="div_noticia_home">
						<?php $timestamp = strtotime($evento->fecha_evento); ?>
						
						<div class="noticia_home show-for-small">
							<div class="row">

								<div class="six columns">
									<span class="radius label secondary_date"><?php echo date('d M Y', $timestamp); ?></span>
									<br/><br/>

									<h2>
										<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo character_limiter($evento->nombre, 80); ?></a>
									</h2><br />
									<p>
										<?php echo '<b>Lugar: </b>'.ucfirst(strtolower($evento->lugar_evento)); ?><br />
										<?php echo '<b>Hora: </b>'.$evento->hora_evento; ?>
									</p>

									<!--<p><?php echo character_limiter($evento->descripcion_breve, 275); ?></p>-->
								</div>
								<div class="six columns">
									<?php
										if(is_array($evento->ficheros1) && !empty($evento->ficheros1))
											$fichero = $evento->ficheros1[0];
										else
											$fichero ='';
									 ?>
									<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>">
										<?php
											if ($fichero != '' && file_exists(FCPATH.'assets/front/img/med/'.$fichero))
												$img_evento = base_url().'assets/front/img/med/'.$fichero;
											else
												$img_evento = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
										?>
										<?php // echo '<pre>Fichero: '.print_r($img_evento,true).'</pre>';die(); ?>
										<img src="<?php echo $img_evento; ?>">
									</a>
								</div>
							</div>
						</div>

							<div class="noticia_home_mobile hide-for-small">
								<div class="row">
									<div class="two columns">
										<div class="dia_mes">
											<h3><?php echo date('d', $timestamp); ?></h3>
											<h4><?php echo date('M', $timestamp); ?></h4>
											<h5><?php echo date('Y', $timestamp); ?></h5>
											<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>">
												<img src="../../assets/front/img/temp/speech.png" />
											</a>
										</div>
									</div>

									<div class="six columns" style="margin-top: 5px;">
										<h2>
											<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>">
												<?php echo character_limiter($evento->nombre, 70); ?>
											</a>
										</h2><br />
										<p>
											<?php echo '<b>Lugar: </b>'.ucfirst(strtolower($evento->lugar_evento)); ?><br />
											<?php echo '<b>Hora: </b>'.$evento->hora_evento; ?>
										</p>
									</div>

									<div class="four columns">
										<?php
											if(is_array($evento->ficheros1) && !empty($evento->ficheros1))
												$fichero = $evento->ficheros1[0];
											else
												$fichero ='';
										 ?>
										<a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>">
											<?php
												if ($fichero != '' && file_exists(FCPATH.'assets/front/img/thumb/'.$fichero))
												{
													$img_evento = base_url().'assets/front/img/med/'.$fichero;
												}
												else
											    {
													$img_evento = base_url().'assets/front/img/template/placeholder/placeholder_med.jpg';
												}
											?>
											<img src="<?php echo $img_evento; ?>">
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<div style="margin-top: 30px"><a href="<?php echo base_url().lang('eventos_url'); ?>" class="button small twelve"><?php echo lang('home.eventos_dir'); ?></a></div>
		</div>
	</div>

	<div class="four columns">
		<!--<div class="radius_content" style="min-width: 320px; margin-left: -15px">
			<h1><?php echo lang('home.tweets_tit'); ?></h1>
		</div>-->
		<div style="position: auto; height: 475px">
<a class="twitter-timeline" href="https://twitter.com/CongressusWTC" data-widget-id="337634804675792896">Tweets by @CongressusWTC</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
	</div>
</div>