<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#mas_servicios').hide();
		$('#mas').click(function()
		{
			$('#mas_servicios').show();
			$('#mas').hide();
		});
		$('#menos').click(function()
		{
			$('#mas_servicios').hide();
			$('#mas').show();
		});
	});
</script>

<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('servicios.hospedaje'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('servicios.hospedaje'); ?></h2>

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


<div class="row hide-for-small">
	<div class="twelve columns miniaturas_wtc">
		<?php for($i=1; $i<=6; $i++) : ?>
			<div class="mobile-two two columns no-padding">
				<a href="../../assets/front/img/temp/galeria_wtc/hospedaje/hospedaje_<?php echo $i; ?>.jpg" class="fancybox" rel="shadowbox">
					<img src="../../assets/front/img/temp/galeria_wtc/hospedaje/hospedaje_<?php echo $i; ?>.jpg">
				</a>
			</div>
		<?php endfor; ?>
	</div>

	<div class="twelve columns" style="margin-bottom: 25px">
		<h4 style="color: #000"><?php echo lang('servicios.hospedaje_tit'); ?></h4><br />
		<p><?php echo lang('servicios.hospedaje_p1'); ?></p>
		<p><?php echo lang('servicios.hospedaje_p2'); ?></p>
		<div class="radius_content" style="padding: 25px 25px">
			<span style="font-size: 12px;font-weight: bold;"><?php echo lang('servicios.hospedaje_p3'); ?></span><br /><br />
			<?php $servicios = lang('servicios.hospedaje_ul'); ?>
			<ul id='lista_servicios'>
				<?php for($i = 1; $i <= 6; $i++): ?>
					<li><?php echo lang('servicios.hospedaje_li'.$i); ?></li>
				<?php endfor; ?>
				<li id='mas'><a><?php echo lang('servicios.mas_servicios'); ?></a></li>
				<div id='mas_servicios'>
					<?php for($i = 7; $i <= 14; $i++): ?>
						<li><?php echo lang('servicios.hospedaje_li'.$i); ?></li>
					<?php endfor; ?>
					<li><a id='menos'><?php echo lang('servicios.menos_servicios'); ?></a></li>
				</div>
			</ul>
		</div>
	</div>
	
	<?php if(isset($habitaciones)) : ?>
		<?php $habitaciones = array_reverse($habitaciones); ?>
		<h4 style="color: #000; margin-left: 29px;"><?php echo lang('servicios.hospedaje_subt'); ?></h4><br /><br />
		<?php foreach($habitaciones as $key => $habitacion) : ?>
			<?php
				if(!empty($habitacion->fichero)  && file_exists(FCPATH.'assets/front/img/large/'.$habitacion->fichero)) :
					$img = base_url().'assets/front/img/large/'.$habitacion->fichero;
				else :
					$img =  base_url().'assets/front/img/template/placeholder/placeholder_large.jpg';
				endif;
			?>
			<div class="twelve columns" style="margin-bottom: 11px;">
				<div class="four columns">
					<a href="<?php echo $img; ?>" class="fancybox" rel="shadowbox[hospedaje]" title="<?php echo $habitacion->nombre; ?>"><img src="<?php echo $img; ?>" alt="gal_<?php echo $key; ?>" /></a>
				</div>
				<div class="one column"></div>
				<div class="seven columns">
					<h3 style="color: #000;font-size: 18px"><?php echo $habitacion->nombre; ?></h3>
					<p>
						<?php echo $habitacion->descripcion_ampliada; ?>
					</p>
					<a class="small button" target="_blank" style="margin-top: 35px" href="http://www.hesperia.com/nh/en/hotels/venezuela/valencia/hesperia-wtc-valencia.html"><?php echo lang('hosedaje.reservar'); ?></a>
				</div>
			</div>
			<center><hr style="width: 94%;" /></center>
		<?php endforeach; ?>
	<?php endif; ?>
</div>


<div class="row show-for-small">

	<div class="twelve columns">

		<div class="lista_servicios">
			<h1><?php echo lang('servicios.hospedaje_inicio'); ?></h1>
			<p><?php echo lang('servicios.hospedaje_p1'); ?></p>
			<p><?php echo lang('servicios.hospedaje_p2'); ?></p>
		</div>
		<div class="radius_content">
			<ul>
				<?php for($i=1;$i<=14;$i++) : ?>
					<li><?php echo lang('servicios.hospedaje_li'.$i); ?></li>
				<?php endfor; ?>
			</ul>
		</div>
		

		<ul class="accordion">
			<?php if(isset($habitaciones)): ?>
				<?php foreach($habitaciones as $habitacion): ?>
					<li>
						<div class="title"><h5><?php echo ucwords($habitacion->nombre); ?></h5></div>
						<div class="content">
							<?php
								if(!empty($habitacion->fichero)  && file_exists(FCPATH.'assets/front/img/large/'.$habitacion->fichero)) :
									$img = base_url().'assets/front/img/large/'.$habitacion->fichero;
								else :
									$img =  base_url().'assets/front/img/template/placeholder/placeholder_large.jpg';
								endif;
							?>
							<img src="<?php echo $img; ?>" />
							<h3><?php echo lang('servicios.hospedaje_tit'); ?></h3>
							<p><?php echo $habitacion->descripcion_ampliada; ?></p>
							<a href="http://www.hesperia.com/nh/en/hotels/venezuela/valencia/hesperia-wtc-valencia.html" target="_blank" class="button small reservar_button"><?php echo strtoupper(lang('hosedaje.reservar')); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>

</div>
