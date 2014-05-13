<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('complejo.tit_seccion'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('complejo.tit_seccion'); ?></h2>

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

	<div class="seven columns">

		<div class="resena_content">
		<h2><?php echo lang('complejo.hotel_tit'); ?></h2>

		<p><?php echo lang('complejo.hotel_descA'); ?></p>
		<p><?php echo lang('complejo.hotel_descB'); ?></p>
		<p><?php echo lang('complejo.hotel_descC'); ?></p>
		</div>

	</div>

	<div class="five columns">

		<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/areasinternas.jpg" class="hide-for-small fancybox" rel="shadowbox">
			<img style="margin-bottom: -3px;" src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/areasinternas.jpg" />
		</a>

		<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/areasinternas.jpg" class="show-for-small imagen_complejo fancybox">
			<img style="margin-bottom: -3px;" src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/areasinternas.jpg" />
		</a>

		<div class="twelve columns no-padding">

				<div class="mobile-two-gallery three columns no-padding">
					<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/convenciones.jpg" class="fancybox" rel="shadowbox">
						<img src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/convenciones.jpg" />
					</a>
				</div>

				<div class="mobile-two end three columns no-padding">
					<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/habitacioncompleta.jpg" class="fancybox" rel="shadowbox">
						<img src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/habitacioncompleta.jpg" />
					</a>
				</div>


				<div class="mobile-two-gallery three columns no-padding">
					<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/habitacionmuebles.jpg" class="fancybox" rel="shadowbox">
						<img src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/habitacionmuebles.jpg" />
					</a>
				</div>

				<div class="mobile-two end three columns no-padding">
					<a href="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/riosbar.jpg" class="fancybox" rel="shadowbox">
						<img src="<?php echo base_url(); ?>assets/front/img/template/complejo/fullscreen/riosbar.jpg" />
					</a>
				</div>

		</div>

	</div>

	<div class="twelve columns">

		<div class="radius_content_convenciones hide-for-small">

			<div class="tit_convenciones hide-for-small">
				<h4><?php echo lang('complejo.conv_tit'); ?></h4>
				<h5><?php echo lang('complejo.conv_subt'); ?></h5>
			</div>

			<div class="tit_convenciones_mobile show-for-small">
				<h4><?php echo lang('complejo.conv_tit'); ?></h4>
				<h5><?php echo lang('complejo.conv_subt'); ?></h5>
			</div>

			<div class="six columns">
				<p><?php echo lang('complejo.conv_descA'); ?></p>
				<p><?php echo lang('complejo.conv_descB'); ?></p>
			</div>

			<div class="six columns">

				<p><strong><?php echo lang('complejo.opciones_tit'); ?></strong></p>

				<ul>
					<li><?php echo lang('complejo.opcionA'); ?></li>
					<li><?php echo lang('complejo.opcionB'); ?></li>
					<li><?php echo lang('complejo.opcionC'); ?></li>
					<li><?php echo lang('complejo.opcionD'); ?></li>
				</ul>

			</div>

			<div style="clear: both;"></div>

		</div>
		
		<div class="radius_content_convenciones_2 show-for-small">

			<div class="tit_convenciones hide-for-small">
				<h4><?php echo lang('complejo.conv_tit'); ?></h4>
				<h5><?php echo lang('complejo.conv_subt'); ?></h5>
			</div>

			<div class="tit_convenciones_mobile show-for-small">
				<h4><?php echo lang('complejo.conv_tit'); ?></h4>
				<h5><?php echo lang('complejo.conv_subt'); ?></h5>
			</div>

			<div class="six columns">
				<p><?php echo lang('complejo.conv_descA'); ?></p>
				<p><?php echo lang('complejo.conv_descB'); ?></p>
			</div>

			<div class="six columns">

				<p><strong><?php echo lang('complejo.opciones_tit'); ?></strong></p>

				<ul>
					<li><?php echo lang('complejo.opcionA'); ?></li>
					<li><?php echo lang('complejo.opcionB'); ?></li>
					<li><?php echo lang('complejo.opcionC'); ?></li>
					<li><?php echo lang('complejo.opcionD'); ?></li>
				</ul>

			</div>

			<div style="clear: both;"></div>

		</div>
	</div>

	<div class="five columns">
		<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/edificiowtc.jpg">
			<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/edificiowtc.jpg" />
		</a>
	</div>

	<div class="seven columns">

		<div class="resena_content">
			<h1><?php echo lang('complejo.zanexa_tit'); ?></h1>
		</div>

		<div class="resena_content">
			<h2 style="margin-top: 20px;"><?php echo lang('complejo.zanexa_subtit'); ?></h2>
			<p><?php echo lang('complejo.zanexa_desc'); ?></p>
		</div>

	</div>

</div>