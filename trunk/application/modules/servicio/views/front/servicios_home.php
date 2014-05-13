<div class="row">

	<div class="twelve columns">

		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('servicios.tit_seccion'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('servicios.tit_seccion'); ?></h2>

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

		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_1.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_1.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_2.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_2.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_5.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_5.jpg">
			</a>
		</div>
		
		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_4.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_4.jpg">
			</a>
		</div>
		
		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_3.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_3.jpg">
			</a>
		</div>

		<div class="mobile-two two columns no-padding">
			<a href="<?php echo base_url(); ?>assets/front/img/template/servicios/fullscreen/servicio_6.jpg" class="fancybox" rel="shadowbox">
				<img src="<?php echo base_url(); ?>assets/front/img/template/servicios/thumbnails/servicio_6.jpg">
			</a>
		</div>

	</div>

	<div class="four columns">
		
		<div class="lista_servicios">
			<a href="<?php echo base_url().lang('servicios_wtc_url'); ?>"><h1><?php echo lang('servicios.conc_tit'); ?></h1></a>
			<ul>
				<span onclick="show('#info_services');"><?php $activo = lang('servicios.carac_activo'); ?></span>
				<?php if(isset($tipo_servicios)): // echo '<pre>'.print_r($servicios,true).'</pre>';die(); ?>
					<?php foreach($tipo_servicios as $tipo): ?>
						<?php if($tipo->id_tipo_servicio == '2'): ?>
							<?php $servicios[$tipo->id_tipo_servicio] = array_reverse($servicios[$tipo->id_tipo_servicio]); ?>
						<?php endif; ?>
						<?php if($tipo->id_tipo_servicio != '7'): ?>
							<li>
								<a id="opcion_<?php echo $tipo->id_tipo_servicio; ?>" class="" href="<?php echo ($tipo->nombre_tipo == 'hospedaje') ? lang('hospedaje_url') : '#' ; ?>">
									<?php echo ucfirst(strtolower(lang('servicios.carac_opc'.$tipo->id_tipo_servicio))); ?>
								</a>
								<ul id="subopcion_<?php echo $tipo->id_tipo_servicio; ?>">
									<?php foreach($servicios[$tipo->id_tipo_servicio] as $key => $servicio): ?>
										<?php if($servicio->nombre != ''): //echo '<pre>'.print_r($servicios,true).'</pre>';die(); ?>
											<li>
												<?php if($tipo->id_tipo_servicio != '2'): ?>
													<a id="servicio_<?php echo $servicio->id_servicio; ?>" class="<?php echo ($tipo->id_tipo_servicio == $activo) ? 'active' : '' ; ?>" href="#"><?php echo ($servicio->nombre == '') ? lang('servicio_sinnombre') : ucwords($servicio->nombre); ?></a>
												<?php else : ?>
													<a id="servicio_<?php echo $servicio->id_servicio; ?>" class="<?php echo ($tipo->id_tipo_servicio == $activo) ? 'active' : '' ; ?>" href="#nombre_<?php echo $key; ?>"><?php echo ($servicio->nombre == '') ? lang('servicio_sinnombre') : ucwords($servicio->nombre); ?></a>
												<?php endif; ?>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>

	</div>

	<div class="eight columns" id="description_all">
		<div id="resena_desktop" class="resena_content">
			<h6 id="resena_titulo"><?php echo ucwords(lang('servicios.rese_tit')); ?></h6>
			<div id="resena_ddescripcion" style="margin-top: 12px">
				<p><?php echo lang('servicios.conc_desc'); ?></p>
			</div>
			<span id="resena_eventos"></span><br /><br />
			<img id="resena_imagen" src="<?php echo base_url().'assets/front/img/large/restaurnt_atmosfera_servicios.jpg'; ?>" />
		</div>
	</div>
	
	<div class="eight columns" id="description_2">
		<?php foreach($tipo_servicios as $tipo): ?>
			<?php if($tipo->id_tipo_servicio == '2'): ?>
				<?php foreach($servicios[$tipo->id_tipo_servicio] as $key => $servicio): ?>
					<?php if(!empty($servicio->fichero)  && file_exists(FCPATH.'assets/front/img/large/'.$servicio->fichero)) : ?>
						<?php $img = base_url().'assets/front/img/large/'.$servicio->fichero; ?>
					<?php else : ?>
						<?php $img = base_url().'assets/front/img/template/placeholder/placeholder_large_1.jpg'; ?>
					<?php endif; ?>
						<?php if(isset($servicio->descripcion_ampliada) && $servicio->descripcion_ampliada != ''): ?>
							<span style="position: relative;top: -90px;float: left;" id="nombre_<?php echo $key; ?>"></span>
							<div id="descripcion" style="margin-top: 12px">
								<span style="color: #000;font-size: 18px"><?php echo ucfirst($servicio->nombre); ?></span>
								<p><?php echo ucfirst($servicio->descripcion_ampliada); ?></p><br />
								<a href="<?php echo $img; ?>" class="fancybox" title="<?php echo ucfirst($servicio->nombre); ?>"><img src="<?php echo $img; ?>" style="width: 597px;" /></a>
							</div>
							<hr style="width: 95%; margin-left: auto;margin-right: auto;" />
						<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

</div>

<div class="row show-for-small">
	<div class="twelve columns">
		<div class="lista_servicios">
			<h1>Sobre los servicios</h1>
		</div>
		<ul class="accordion">
			<?php  $type = 1;  //echo '<pre>'.print_r($servicios,true).'</pre>';die();?>
			<?php if(isset($tipo_servicios)): ?>
				<?php foreach($tipo_servicios as $tipo): ?>
					<?php if($tipo->id_tipo_servicio != '7'): ?>
						<li>
							<?php if($tipo->id_tipo_servicio == 1):  ?>
								<div class="title"><a style="color: #222" href="<?php echo lang('hospedaje_url'); ?>"><h5><?php echo lang('servicios.carac_opc'.$tipo->id_tipo_servicio) ?></h5></a></div>
							<?php else : ?>
								<div class="title"><h5><?php echo lang('servicios.carac_opc'.$tipo->id_tipo_servicio) ?></h5></div>
								<div class="content">
									<?php if(isset($tipo->id_tipo_servicio)) : ?>
										<?php foreach($servicios[$tipo->id_tipo_servicio] as $servicio): ?>
											<?php if(!empty($servicio->nombre)):  ?>
												<?php if($type == 1 && $tipo->id_tipo_servicio == 1):  ?>
													<a href="<?php echo ($tipo->nombre_tipo == 'hospedaje') ? lang('hospedaje_url') : '#' ; ?>">
														<h3><?php echo lang('servicios.hospedaje_subt'); ?></h3>
													</a>
													<?php $type = 0; ?>
												<?php else: ?>
													<?php if($tipo->nombre_tipo!='hospedaje'): ?>
														<?php if(!empty($servicio->fichero)  && file_exists(FCPATH.'assets/front/img/large/'.$servicio->fichero)) : ?>
															<?php $img = base_url().'assets/front/img/large/'.$servicio->fichero; ?>
														<?php else : ?>
															<?php $img = base_url().'assets/front/img/template/placeholder/placeholder_large_1.jpg'; ?>
														<?php endif; ?>
														<img src="<?php echo $img; ?>">
														<h3><?php echo ($servicio->nombre == '') ? lang('servicio_sinnombre') : ucwords($servicio->nombre); ?></h3>
														<p><?php echo ($servicio->descripcion_ampliada == '') ? '' : ucfirst($servicio->descripcion_ampliada); ?></p>
													<?php endif; ?>
												<?php endif; ?>
											<?php endif; ?>
											<hr />
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>