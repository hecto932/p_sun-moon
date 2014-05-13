<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#exito').fadeOut(5500);
	});
</script>

<!--------------------------------	MODAL DE DECISION: PERSONA NATURAL O JURÍDICA	-------------------------------->

<div id="myModal" class="reveal-modal" style="position: absolute; top:110px">
	<center>
		<h2>
			<img style="vertical-align: middle; margin-right: 5px; margin-bottom: 20px" src="../../assets/front/img/temp/usericon.png" />
			<?php echo lang('evnt.inscripcion');?>
		</h2>
		<b><?php echo $detalle_evento->nombre;?></b>
		<ul class="button-group round even-2" style="list-style: none; margin: 30px 10px; padding: 5px 5px; margin-left: 15%;">	
			<li>
				<a class="mobile-four button success" href="<?php echo base_url().lang('eventos_url').'/'.lang('inscripciones_url').'/'.$detalle_evento->url; ?>" target="_blank">
					<?php echo lang('evnt.persona_nat');?>
				</a>
			</li>
			<li><span style="padding-left: 30px;padding-right: 30px;"></span></li>
			<li>
				<a class="mobile-four button success" href="<?php echo base_url().lang('eventos_url').'/'.lang('insc_juridicas_url').'/'.$detalle_evento->url; ?>" target="_blank">
					<?php echo lang('evnt.persona_jur');?>
				</a>
			</li>
		</ul>
	</center>
	<a class="close-reveal-modal">&#215;</a>
</div>

<!--------------------------------	VISTA DETALLE	-------------------------------->

<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
				<h1 class="hide-for-small"><?php echo lang('eventos.titulo_secc'); ?></h1>
				<h2 class="show-for-small"><?php echo lang('eventos.titulo_secc'); ?></h2>
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
	<?php if(isset($form_status) && $form_status=='SUCCESS') : ?>
		<div id="exito" style="color: #0B610B; background: #CEF6CE; margin: 15px 0px; padding: 8px 0px">
			<center><h5 style="color: #0B610B;"><?php echo lang('membresias.diag_exito'); ?></h5></center>
		</div>
	<?php endif; ?>
	
<?php //echo '<pre>'.print_r($detalle_evento,true).'</pre>';die(); ?>
<div class="row">
	<div class="eight columns hide-for-small">

		<a class="small button secondary listado show-for-touch" href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_volver'); ?></a>
	
		<div class="radius_content <?php echo ($detalle_evento->id_tipo_evento == 6) ? 'evento_header_musical' : 'evento_header' ; ?>">
			<?php
				foreach ($detalle_evento->ficheros as $fichero)
				{
					if(strstr($fichero, '.pdf'))
					{
						if(strstr($fichero, 'pdfevento_'))
							$pdf_url = $fichero;
					}
				}
			?>
			<div class="header_conferencias">
				<h2><?php echo strtoupper(lang('eventos.plural_'.$detalle_evento->id_tipo_evento)); ?></h2>
				<h3><?php echo ucfirst($detalle_evento->nombre); ?>.</h3>
			</div>

			<div class="noticia_principal_inner">

				<h3><?php echo ucfirst($detalle_evento->nombre); ?></h3>
				<small><?php echo lang('eventos.fcambio'); ?>: <?php echo $detalle_evento->fecha_modificado; ?></small>

				<?php if(isset($pdf_url) && file_exists(FCPATH.'assets/front/uploads/eventos/pdf/'.$pdf_url)) : ?>
				<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$pdf_url; ?>" class="right hide-for-small" target="_blank">
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>

				<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$pdf_url; ?>" style="margin-top: 10px;" class="show-for-small" target="_blank">
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>
				<?php endif; ?>

				<p class="datos_fecha">
					<?php
						//die(gettype($modos_pago));
					
					?>
					<strong><?php echo lang('fecha'); ?>: </strong><?php echo $detalle_evento->fecha_eventof; ?><br />
					<strong><?php echo lang('hora'); ?>:</strong> <?php echo $detalle_evento->hora_evento; ?> <br />

					<strong><?php echo lang('eventos.levento'); ?>:</strong> <?php echo ($detalle_evento->lugar_evento != '') ? $detalle_evento->lugar_evento : lang('eventos_lugarsd') ; ?><br /><br />

					
					<?php if($detalle_evento->precio_evento != 'Gratis / Libre') : ?>
					<strong><?php echo lang('eventos.inversion'); ?>:</strong> <?php echo $detalle_evento->precio_evento; ?> <br />
					<strong><?php echo lang('eventos.fpago'); ?>:</strong> <?php echo (gettype($modos_pago) == 'string') ? $modos_pago : lang('eventos_centropsd'); ?><br />
					<strong><?php echo lang('eventos.cpago'); ?>:</strong> <?php echo ($detalle_evento->centros_pago != '') ? ucfirst($detalle_evento->centros_pago) : lang('eventos_centropsd') ; ?>
					<?php endif; ?>
				</p>
				
				<hr />

				<span style="word-wrap: break-word"><?php echo ucfirst($detalle_evento->descripcion_ampliada); ?></span>

				<!--<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$detalle_evento->fichero; ?>" class="right hide-for-small" target="_blank" >
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>-->
				<?php if($detalle_evento->inscripcion == 1) : ?>
					<div style="margin: 20px 0px; padding-bottom: 10px">
						<a href="#" class="right hide-for-small" data-reveal-id="myModal">
							<img height="25px" width="25px" style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/usericon.png" />
							<?php echo lang('evnt.inscripcion'); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<span class='st_facebook_hcount' displayText='Facebook'></span>
			<span class='st_twitter_hcount' displayText='Tweet'></span>

		</div>

		<a class="small button secondary listado show-for-touch" href="#"><?php echo lang('eventos_volver'); ?></a>
	</div>

	<div class="eight columns show-for-small">

		<a class="small button secondary listado show-for-touch" href="#"><?php echo lang('eventos_volver'); ?></a>

		<div class="radius_content evento_header_small">


			<div class="<?php echo ($detalle_evento->id_tipo_evento == 6) ? 'header_conferencias_small_white' : 'header_conferencias_small'; ?>">
				<h2><?php echo strtoupper(lang('eventos.plural_'.$detalle_evento->id_tipo_evento)); ?></h2>
				<h3><?php echo ucfirst($detalle_evento->nombre); ?>.</h3>

			</div>

			<div class="noticia_principal_inner">

				<h3><?php echo ucfirst($detalle_evento->nombre); ?></h3>
				<small><?php echo lang('eventos.fcambio'); ?>: <?php echo $detalle_evento->fecha_modificado; ?></small>
				
				<?php if(isset($pdf_url) && file_exists(FCPATH.'assets/front/uploads/eventos/pdf/'.$pdf_url)) : ?>
				<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$pdf_url; ?>" class="right hide-for-small" target="_blank">
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>

				<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$pdf_url; ?>" style="margin-top: 10px;" class="show-for-small" target="_blank">
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>
				<?php endif; ?>
				
				<p class="datos_fecha">
					<strong><?php echo lang('fecha'); ?>: </strong><?php echo $detalle_evento->fecha_eventof; ?><br />
					<strong><?php echo lang('hora'); ?>:</strong> <?php echo $detalle_evento->hora_evento; ?> <br />
					<strong><?php echo lang('eventos.levento'); ?>:</strong> <?php echo ($detalle_evento->lugar_evento != '') ? $detalle_evento->lugar_evento : lang('eventos_lugarsd') ; ?><br /><br />

					<?php if($detalle_evento->precio_evento != 'Gratis / Libre') : ?>
					<strong><?php echo lang('eventos.inversion'); ?>: </strong> <?php echo $detalle_evento->precio_evento; ?> <br />
					<strong><?php echo lang('eventos.fpago'); ?>:</strong> <?php echo (strlen($modos_pago[0])>2) ? $modos_pago[0] : lang('eventos_centropsd'); ?><br />
					<strong><?php echo lang('eventos.cpago'); ?>:</strong> <?php echo ($detalle_evento->centros_pago != '') ? ucfirst($detalle_evento->centros_pago) : lang('eventos_centropsd') ; ?>
					<?php endif; ?>
				</p>
				
				<hr />

				<span style="word-wrap: break-word"><?php echo ucfirst($detalle_evento->descripcion_ampliada); ?></span>
<!--
				<a href="<?php echo base_url().'assets/front/uploads/eventos/pdf/'.$pdf_url; ?>" target="_blank">
					<img style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/pdficon.png" />
					<?php echo lang('eventos.descarga'); ?>
				</a>-->
				<?php if($detalle_evento->inscripcion == 1) : ?>
					<a href="#" class="right show-for-small" data-reveal-id="myModal">
						<img height="25px" width="25px" style="vertical-align: middle; margin-right: 5px;" src="../../assets/front/img/temp/usericon.png" />
						<?php echo lang('evnt.inscripcion'); ?>
					</a>
				<?php endif; ?>

			</div>

			<span class='st_facebook_hcount' displayText='Facebook'></span>
			<span class='st_twitter_hcount' displayText='Tweet'></span>

		</div>

		<a class="small button secondary listado show-for-touch" href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('eventos_volver'); ?></a>
	</div>

	<div class="four columns">

		<div class="radius_content" style="min-width: 310px;margin-left: -15px">
			<h1><?php echo lang('eventos.archivo_tit'); ?></h1>

			<ul>
				<?php if(isset($archivo_eventos)): ?>
					<?php foreach($archivo_eventos as $evento): 
						if(strlen($evento->nombre) < 38) :?>
							<li><a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo ucfirst($evento->nombre); ?></a></li>
						<?php else: ?><li><a href="<?php echo base_url().lang('eventos_url').'/'.$evento->url; ?>"><?php echo ucfirst(substr($evento->nombre,0,38)); ?>...</a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>

		<!--<div class="radius_content">
			<h1>Tweets</h1>
			<div class="tweets_inner"></div>
		</div>-->
<!------------------------------ REDES SOCIALES CONGRESSUS CENTER ------------------------------>
		<div style="position: auto; height: 490px">
			<a class="twitter-timeline" href="https://twitter.com/CongressusWTC" data-widget-id="337634804675792896">Tweets by @CongressusWTC</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div style="margin-left: -12px" class="fb-like-box" data-href="https://www.facebook.com/CongressusCenter" data-width="310" data-show-faces="true" data-stream="false" data-show-border="true" data-header="false"></div>

<!------------------------------ /REDES SOCIALES CONGRESSUS CENTER ------------------------------>
		

		<!--<div id="fb_box" style="width:100%;">
		  <!<div class="fb-like-box" data-href="https://www.facebook.com/adobegocreate" data-width="292" data-show-faces="true" data-stream="false" data-header="false"></div>
		</div>-->

	</div>

</div>