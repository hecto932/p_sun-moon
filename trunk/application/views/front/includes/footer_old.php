<div class="100width fondo_blanco">
<div class="row">

	<div class="four columns">

		<div class="content_lazos">
			<h4><?php echo lang('footer.asoc_tit'); ?> </h4>
		</div>

	</div>
	<div class="eight columns">

		<ul class="img_asociados hide-for-small">
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/hesperia_wtc_1.png" /></a></li>
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/congressus1.png" /></a></li>
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/hmr1.png" /></a></li>
		</ul>

		<ul class="img_asociados_mobile show-for-small">
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img style="width: 80px;" class="show-for-small" src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/hesperia_wtc_1.png" /></a></li>
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img style="width: 80px;" class="show-for-small" src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/congressus1.png" /></a></li>
			<li><a href="<?php echo base_url().lang('hmr_url'); ?>"><img style="width: 80px;" class="show-for-small" src="<?php echo base_url(); ?>assets/front/img/template/asociaciones/thumbnails/hmr1.png" /></a></li>
		</ul>

	</div>

</div>
</div>

<div class="100width fondo_footer">

	<div class="cuadro_footer_mobile blanco show-for-small">
			<div class="cuadro_footer_inner">
				<img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/front/img/temp/creditcardicon_1.png" />
				<h1><a href="<?php echo base_url().lang('membresias_wtc_url'); ?>"><?php echo lang('footer.memb_tit'); ?></a></h1>
				<h2><?php echo lang('footer.memb_desc'); ?></h2>
			</div>
		</div>

		<div class="cuadro_footer_mobile azul_claro show-for-small">
			<div class="cuadro_footer_inner">
				<img src="<?php echo base_url(); ?>assets/front/img/temp/hospedajeicon.png" />
				<h3><a style="color: #FFF" href="<?php echo lang('hospedaje_url'); ?>"><?php echo lang('footer.hosp_tit'); ?></a></h3>
				<h2><?php echo lang('footer.hosp_desc'); ?></h2>
			</div>
		</div>

		<div class="cuadro_footer_mobile azul show-for-small" style="margin-bottom: 20px;">
			<div class="cuadro_footer_inner">
				<img src="<?php echo base_url(); ?>assets/front/img/temp/mundoicon.png" />
				<h3><a style="color: #FFF" href="<?php echo base_url().lang('wtc_url'); ?>"><?php echo lang('footer.renm_tit'); ?></a></h3>
				<h2><?php echo lang('footer.renm_desc'); ?></h2>
			</div>
		</div>

			<div class="row">
	<div class="twelve columns">


		<div class="cuadro_footer blanco hide-for-small">
			<img src="<?php echo base_url(); ?>assets/front/img/temp/creditcardicon_1.png" />
			<h1 id="tit_membresia"><a href="<?php echo base_url().lang('membresias_wtc_url'); ?>"><?php echo lang('footer.memb_tit'); ?></a></h1>
			<h2 id="tit_servicios"><?php echo lang('footer.memb_desc'); ?></h2>
		</div>

		<div class="cuadro_footer azul_claro hide-for-small">
			<img src="<?php echo base_url(); ?>assets/front/img/temp/hospedajeicon.png" />
			<h3 id="tit_hospedaje"><a style="color: #FFF" href="<?php echo lang('hospedaje_url'); ?>"><?php echo lang('footer.hosp_tit'); ?></a></h3>
			<h2 id="tit_habitaciones"><?php echo lang('footer.hosp_desc'); ?></h2>
		</div>

		<div class="cuadro_footer azul hide-for-small">
			<img src="<?php echo base_url(); ?>assets/front/img/temp/mundoicon.png" />
			<h3 id="tit_renombre"><a style="color: #FFF" href="<?php echo base_url().lang('wtc_url'); ?>"><?php echo lang('footer.renm_tit'); ?></a></h3>
			<h2 id="tit_paises"><?php echo lang('footer.renm_desc'); ?></h2>
		</div>

	</div>

	<div class="eight columns">
		<h1 class="tit_footer"><strong><?php echo lang('footer.wtc'); ?></strong></h1>

		<ul class="botonera_footer_mobile show-for-small mobile-four">
			<h2 class="tit_footer"><?php echo lang('footer.wtc_tit'); ?></h2>
			<?php
				$cont = lang('footer.organizacion');
				for ($i = 0; $i <= $cont; $i++):
			?>
				<li><a style="color: #BDBDBD" href="<?php echo lang('footer.wtc_url'.$i); ?>"><?php echo lang('footer.wtc_opc'.$i); ?></a></li>
			<?php endfor; ?>
		</ul>

		<ul class="botonera_footer_mobile show-for-small mobile-four">
			<h2 class="tit_footer"><?php echo lang('footer.comp_tit'); ?></h2>
			<?php
				$cont = lang('footer.organizacion');
				for ($i = 0; $i <= $cont; $i++):
			?>
				<li><a style="color: #BDBDBD" href="<?php echo lang('footer.comp_url'.$i); ?>"><?php echo lang('footer.comp_opc'.$i); ?></a></li>
			<?php endfor; ?>
		</ul>

		<ul class="botonera_footer_mobile_eventos show-for-small mobile-four">
			<h2 class="tit_footer"><?php echo lang('footer.eventos'); ?></h2>
			<?php if(!empty($eventos_footer)): ?>
				<?php foreach($eventos_footer as $evento): ?>
					<li><a style="color: #BDBDBD" href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo character_limiter($evento->nombre, 90); ?></a></li>
				<?php endforeach; ?>
			<?php else: ?>
				<li><?php echo lang('eventos_footerno'); ?></li>
			<?php endif; ?>
		</ul>

		<ul class="botonera_footer_mobile_eventos show-for-small mobile-four">
			<h2 class="tit_footer"><?php echo lang('footer.noticias'); ?></h2>
			<?php if(isset($noticias_footer) && !empty($noticias_footer)): ?>
				<?php foreach($noticias_footer as $noticia): ?>
					<li><a style="color: #BDBDBD" href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo character_limiter($noticia->nombre); ?></a></li>
				<?php endforeach; ?>
			<?php else: ?>
				<li><?php echo lang('noticias_footerno'); ?></li>
			<?php endif; ?>
		</ul>

		<ul class="botonera_footer hide-for-small">
			<li><strong><?php echo lang('footer.wtc_tit'); ?></strong></li>
			<?php
				$cont = lang('footer.organizacion');
				for ($i = 0; $i <= $cont; $i++):
			?>
				<li><a style="color: #BDBDBD" href="<?php echo lang('footer.wtc_url'.$i); ?>"><?php echo lang('footer.wtc_opc'.$i); ?></a></li>
			<?php endfor; ?>
		</ul>

		<ul class="botonera_footer hide-for-small">
			<li><strong><?php echo lang('footer.comp_tit'); ?></strong></li>
			<?php
				$cont = lang('footer.organizacion');
				for ($i = 0; $i <= $cont; $i++):
			?>
				<li><a style="color: #BDBDBD" href="<?php echo lang('footer.comp_url'.$i); ?>"><?php echo lang('footer.comp_opc'.$i); ?></a></li>
			<?php endfor; ?>
		</ul>

		<ul class="botonera_footer hide-for-small">
			<li><strong><?php echo lang('footer.eventos'); ?></strong></li>
			<?php if(!empty($eventos_footer)): ?>
				<?php foreach($eventos_footer as $evento): ?>
					<li><a style="color: #BDBDBD" href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo character_limiter($evento->nombre, 90); ?></a></li>
				<?php endforeach; ?>
			<?php else: ?>
				<li><?php echo lang('eventos_footerno'); ?></li>
			<?php endif; ?>
		</ul>

		<ul class="botonera_footer hide-for-small">
			<li><strong><?php echo lang('footer.noticias'); ?></strong></li>
			<?php if(isset($noticias_footer) && !empty($noticias_footer)): ?>
				<?php foreach($noticias_footer as $noticia): ?>
					<li><a style="color: #BDBDBD" href="<?php echo base_url().lang('noticias_url').'/'.$noticia->url; ?>"><?php echo character_limiter($noticia->nombre, 90); ?></a></li>
				<?php endforeach; ?>
			<?php else: ?>
				<li><?php echo lang('noticias_footerno'); ?></li>
			<?php endif; ?>
		</ul>


	</div>

	<div class="four columns">
		<div class="contacto_home">
			<h1><strong><?php echo lang('footer.cont_tit'); ?></strong></h1>
			<div style="margin-top: 22px">
				<p><?php echo lang('footer.cont_dir'); ?></strong></p>
				<p><strong><i><?php echo lang('footer.cont_inft'); ?></i></strong><br />
				<?php echo lang('footer.cont_telfI'); ?> <br/> <?php echo lang('footer.cont_correoI'); ?></p>
	
				<p><strong><i><?php echo lang('footer.cont_aloj'); ?></i></strong><br />
				<?php echo lang('footer.cont_telfA'); ?><br/> <?php echo lang('footer.cont_correoA'); ?></p>
				<a href="<?php echo base_url().lang('contacto_url'); ?>" class="button small"><?php echo lang('footer.cont_minfo'); ?></a>
			</div>
		</div>
	</div>


	<div class="twelve columns">
		<hr style="border-color: #008cf7; margin-bottom:5px;" />

		<ul class="idiomas">
			<?php
				$cont = lang('footer.idiomas');
				$activo = lang('footer.idi_activo');
				for ($i = 1; $i <= $cont; $i++):
			?>
			<?php
			/*
			 * El activo hay que realizarlo cargando el código del idioma
			 * que posee la variable de sesion, hay que cargarlo cada vez
			 * que se cargue la vista.
			 *
			 * */
			?>
				<li><a class="<?php echo ($activo == $i) ? 'active' : ''; ?>" href="#"><?php echo lang('footer.idi_tit'.$i); ?></a></li>
			<?php endfor; ?>
		</ul>

		<p class="copyright"><?php echo lang('footer.derechos'); ?><a style="vertical-align:center;" href="<?php echo lang('footer.wintech'); ?>"><img src="<?php echo base_url(); ?>assets/front/img/temp/logowin.gif"/></a> </p>

	</div>


</div>
</div>

		<?php echo (isset($contacto_modal) && !empty($contacto_modal)) ? $contacto_modal : '' ; ?>

		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/foundation.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.accordion.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.alerts.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.buttons.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.clearing.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.forms.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.joyride.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.magellan.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.mediaQueryToggle.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.navigation.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.orbit.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.reveal.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.tabs.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.tooltips.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.foundation.topbar.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/modernizr.foundation.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/app.js"></script>
		<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.customforms.js"></script>-->
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.tweetable.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/banner/jmpress.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/banner/jquery.jmslideshow.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/banner/modernizr.custom.48780.js"></script>
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "ur-6493d269-5eaf-75d2-7599-61ea75647199", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

			<script>
			$(function(){
			 	$('.tweets').tweetable({username: 'philipbeel', time: true, limit: 9, replies: false, position: 'append'});
			 	$('.tweets_inner').tweetable({username: 'philipbeel', time: true, limit: 4, replies: false, position: 'append'});
			});
		</script>

		<script>
			$(document).ready(function() {
				$(".fancybox").fancybox({
					openEffect	: 'fade',
					closeEffect	: 'fade'
				});
			});
		</script>

		<script type="text/javascript">
			$(function() {

				var jmpressOpts	= {
					animation		: { transitionDuration : '0.8s' }
				};

				$( '#jms-slideshow' ).jmslideshow( $.extend( true, { jmpressOpts : jmpressOpts }, {
					autoplay	: true,
					bgColorSpeed: '0.8s',
					arrows		: true
				}));

			});
		</script>

		<script>
			function ajustar_footer()
			{
				 var ancho = $(window).width();
				 var tam_letra = $('.cuadro_footer > h3').css('font-size').replace('px', '');
				 console.log(ancho);
				 if(ancho > 910){
				 	$('#tit_membresia').css('font-size', '23px' );
				 	$('#tit_hospedaje').css('font-size', '23px' );
				 	$('#tit_renombre').css('font-size', '23px' );
					$('.cuadro_footer > h2').css('font-size', '12px' );
				 }
				 if(ancho == 910 || ancho == 881 || ancho == 869 || ancho == 844 || ancho == 837 || ancho == 829 || ancho == 806 || ancho == 853 || ancho == 875 || ancho == 754){
				 	var tam_letra = $('#tit_membresia').css('font-size').replace('px', '');
				 	$('#tit_membresia').css('font-size', (tam_letra - 1) + 'px' );
				 	$('#tit_hospedaje').css('font-size', (tam_letra - 1) + 'px' );
				 	$('#tit_renombre').css('font-size', (tam_letra - 1) + 'px' );
				 }
				 if(ancho == 830 || ancho == 787){
				 	var tam_letra = $('.cuadro_footer > h2').css('font-size').replace('px', '');
				 	$('.cuadro_footer > h2').css('font-size', (tam_letra - 1) + 'px' );
				 }


			}
		</script>

		<?php echo (isset($servicios_js) && !empty($servicios_js)) ? $servicios_js : '' ; ?>

		<?php echo (isset($hospedaje_js) && !empty($hospedaje_js)) ? $hospedaje_js : '' ; ?>

		<?php echo (isset($contacto_js) && !empty($contacto_js)) ? $contacto_js : '' ; ?>


		<noscript>
			<style>
			.step {
				width: 100%;
				position: relative;
			}
			.step:not(.active) {
				opacity: 1;
				filter: alpha(opacity=99);
				-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=99)";
			}
			.step:not(.active) a.jms-link{
				opacity: 1;
				margin-top: 40px;
			}
			</style>
		</noscript>



		<script>
			/*
			 * REMEMBER TO CHANGE TO YOUR APP ID AND CHANGE data-href TO SUIT YOU
			 */
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));


			$(window).bind("load resize", function(){
				ajustar_footer;
			  var container_width = $('#fb_box').width();
			    $('#fb_box').html('<div class="fb-like-box" ' +
			    'data-href="https://www.facebook.com/adobegocreate"' +
			    ' data-width="' + container_width + '" data-height="265" data-show-faces="true" ' +
			    'data-stream="false" data-header="false"></div>');
			    FB.XFBML.parse( );
			});
		</script>

		<!--<?php include_once("analisistrack-wtc.php") ?>-->
	</body>
</html>
