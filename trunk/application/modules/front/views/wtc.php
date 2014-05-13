<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('wtc.titulo_secc'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('wtc.titulo_secc'); ?></h2>
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

	<div class="six columns">
		<div class="resena_content">
			<img style="height: 330px; width: 440px;" src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/queesunwtc.jpg" />
		</div>
	</div>

	<div class="six columns">

		<div class="resena_content">
			<h2><?php echo lang('wtc.concepto_tit'); ?></h2>
			<p><?php echo lang('wtc.concepto_descA'); ?></p>
			<p><?php echo lang('wtc.concepto_descB'); ?></p>
			<p><?php echo lang('wtc.concepto_descC'); ?></p>
		</div>
	</div>


	<div class="twelve columns">

		<div class="radius_content_wtc">

			<div class="tit_wtcglobal hide-for-small">
				<h4><?php echo lang('wtc.asociacion_bnnA'); ?></h4>
				<h5><?php echo lang('wtc.asociacion_bnnB'); ?></h5>
			</div>

			<div class="tit_wtcglobal_mobile show-for-small">
				<h4><?php echo lang('wtc.asociacion_bnnA'); ?></h4>
				<h5><?php echo lang('wtc.asociacion_bnnB'); ?></h5>
			</div>

			<h2><?php echo lang('wtc.asociacion_tit'); ?></h2>
			<p><?php echo lang('wtc.asociacion_descA'); ?></p>
			<p><?php echo lang('wtc.asociacion_descB'); ?></p>
		</div>

	</div>

	<div class="twelve columns miniaturas_wtc">
			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/escalerawtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/escalerawtc.jpg">
				</a>
			</div>

			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/salonwtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/salonwtc.jpg">
				</a>
			</div>

			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/techowtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/techowtc.jpg">
				</a>
			</div>

			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/pasillowtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/pasillowtc.jpg">
				</a>
			</div>

			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/areacomunwtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/areacomunwtc.jpg">
				</a>
			</div>

			<div class="mobile-two two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/pasilloswtc.jpg" rel="shadowbox">
					<img src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/pasilloswtc.jpg">
				</a>
			</div>
	</div>

	<div class="six columns">

		<div class="resena_content">
		<h2><?php echo lang('wtc.historia_tit'); ?></h2>
		<p><?php echo lang('wtc.historia_descA'); ?></p>
		<p><?php echo lang('wtc.historia_descB'); ?></p>
		<p><?php echo lang('wtc.historia_descC'); ?></p>
		</div>

	</div>

	<div class="six columns" style="margin-top: 65px">
		<div class="resena_content">
			<img style="height: 330px; width: 440px;" src="<?php echo base_url(); ?>assets/front/img/template/wtc/fullscreen/fachadapol_1.jpg" />
		</div>
	</div>

</div>