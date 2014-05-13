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
	<div class="twelve columns hmr_tit">
		<h1><?php echo lang('footer.asoc_tit'); ?></h1>
		<!--<h2>It is a long established fact that a reader will be distracted by the readable content of a page when looking.</h2>-->
	</div>

	<div class="twelve columns miniaturas_wtc">

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/escalerawtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/escalerawtc.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/salonwtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/salonwtc.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/techowtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/techowtc.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/pasillowtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/pasillowtc.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/areacomunwtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/areacomunwtc.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="../../assets/front/img/template/wtc/fullscreen/pasilloswtc.jpg" class="fancybox" rel="shadowbox">
				<img src="../../assets/front/img/template/wtc/fullscreen/pasilloswtc.jpg">
			</a>
		</div>

	</div>

</div>

<div class="row">

	<div class="four columns hmr_content">
		<a href="#"><img src="../../assets/front/img/template/asociaciones/fullscreen/hesperia.jpg"></a>
		<p><?php echo lang('hmr.hesperia_desc1'); ?></p>
		<p><?php echo lang('hmr.hesperia_desc2'); ?></p>
	</div>

	<div class="four columns hmr_content">
		<a href="#"><img src="../../assets/front/img/template/asociaciones/fullscreen/congressus.jpg"></a>
		<p><?php echo lang('hmr.congressus_desc1'); ?></p>
		<p><?php echo lang('hmr.congressus_desc2'); ?></p>
		<div class="lista_servicios">
			<ul>
				<li><?php echo lang('hmr.congressus_opc1'); ?></li>
				<li><?php echo lang('hmr.congressus_opc2'); ?></li>
				<li><?php echo lang('hmr.congressus_opc3'); ?></li>
			</ul>
		</div>
	</div>


	<div class="four columns hmr_content">
		<a href="#"><img src="../../assets/front/img/template/asociaciones/fullscreen/hmr.jpg"></a>
		<p><?php echo lang('hmr.hmr_desc1'); ?></p>
		<p><?php echo lang('hmr.hmr_desc2'); ?></p>
	</div>

</div>