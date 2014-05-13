<?php //echo '<pre>'.print_r($imagen_principal,true).'</pre>';die(); ?>
<div class="row" id="zona_imagenes">

	<div class="row">
		<div class="six columns imagen_principal">
			<?php $this->load->helper('misc'); ?>
			<a class="th" href="#">
				<!--<img name="img_actual" src="<?php echo get_dir_imagen($imagen_principal, $imagenes_secundarias, $imagenes_terciarias); ?>" />-->
				<?php
					if(!isset($imagenes_secundarias) || empty($imagenes_secundarias))
						$imagenes_secundarias = '';
				?>
				<img name="img_actual" src="<?php echo get_dir_imagen($imagen_principal, $imagenes_secundarias,''); ?>" />
			</a>
		</div>
		<div class="six columns">
			<h3><?php echo lang('titulo_imagen'); ?></h3>
			<?php $info = get_info_imagen($imagen_principal, $imagenes_secundarias,'', 'es'); ?>

			<p> <strong><?php echo lang('nombre_imagen'); ?>:</strong> <span name="nombre_imagen"><?php echo $info->fichero ?></span> </p>
			<p> <strong><?php echo lang('extension_imagen'); ?>:</strong> <span name="extension_imagen">.<?php echo $info->extension; ?></span></p>
			<p> <strong><?php echo lang('dia_imagen'); ?>:</strong> <span name="dia_imagen"><?php echo $info->dia; ?></span></p>
			<p> <strong><?php echo lang('hora_imagen'); ?>:</strong> <span name="hora_imagen"><?php echo $info->hora; ?></span></p>
			<p> <strong><?php echo lang('tipo_imagen'); ?>:</strong> <span name="tipo_imagen"><?php echo $info->destacado; ?></span></p>

		</div>
	</div>

	<div class="row">
		<div class="twelve columns imagenes_secundarias">

			<?php if(isset($imagen_principal) && !empty($imagen_principal)): ?>
				<div id="colummn_<?php echo $imagen_principal[0]->id_multimedia; ?>" class="four columns mobile-two">
					<a class="th" id="<?php echo 'thumb_'.$imagen_principal[0]->id_multimedia; ?>" href="#">
						<img src="<?php echo base_url().'assets/front/img/thumb/'.$imagen_principal[0]->fichero; ?>"/>
					</a>

					<div class="row">
						<div class="four columns">
							<button id="eliminar_<?php echo $imagen_principal[0]->id_multimedia; ?>" class="radius button small alert"><?php echo lang('eliminar'); ?></button>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if(isset($imagenes_secundarias) && !empty($imagenes_secundarias)): ?>
					<?php foreach($imagenes_secundarias as $imagen): ?>
						<div id="colummn_<?php echo $imagen->id_multimedia; ?>" class="four columns mobile-four">
							<a class="th" id="<?php echo 'thumb_'.$imagen->id_multimedia; ?>" href="#">
								<img src="<?php echo base_url().'assets/front/img/thumb/'.$imagen->fichero; ?>"/>
							</a>

							<div class="row">
								<div class="four columns">
									<button id="eliminar_<?php echo $imagen->id_multimedia; ?>" class="radius button small alert"><?php echo lang('eliminar'); ?></button>
								</div>
							</div>
						</div>
					<?php endforeach;?>
			<?php endif; ?>
			
			<div style="margin-left: 15px">
				<span style="color: #424242; font-size: 11px"><b><?php echo lang('img_recomendaciones'); ?></b></span><br />
				<ul>
					<!-- Noticias y Eventos -->
					<?php if(strlen(lang('img_eventos_noticias_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_eventos_noticias_tit'); ?> </b><?php echo lang('img_eventos_noticias_desc'); ?></li>
					<?php endif; ?>
					
					<!-- Servicios -->
					<?php if(strlen(lang('img_servicios_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_servicios_tit'); ?> </b><?php echo lang('img_servicios_desc'); ?></li>
					<?php endif; ?>
					
					<!-- Banners -->
					<?php if(strlen(lang('img_banners_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_banners_tit'); ?> </b><?php echo lang('img_banners_desc'); ?></li>
					<?php endif; ?>
					
					<!-- Noticias -->
					<?php if(strlen(lang('img_noticias_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_noticias_tit'); ?> </b><?php echo lang('img_noticias_desc'); ?></li>
					<?php endif; ?>
					
					<!-- Productos -->
					<?php if(strlen(lang('img_productos_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_productos_tit'); ?> </b><?php echo lang('img_productos_desc'); ?></li>
					<?php endif; ?>
					
					<!-- Categorias -->
					<?php if(strlen(lang('img_categorias_tit')) > 0):?>
						<li style="color: #424242; font-size: 11px"><b><?php echo lang('img_categorias_tit'); ?> </b><?php echo lang('img_categorias_desc'); ?></li>
					<?php endif; ?>
					
				</ul>
			</div>
			
		</div>
	</div>

</div>

<div class="row">
	<div class="twelve columns">

		<div id="add_principal" class="six columns">
			<?php
				if(!isset($imagen_principal) || empty($imagen_principal)){
					echo anchor($url_add_p, lang('add_imagen_p'), array('title'=> lang('add_imagen'), 'class' => 'button radius success'));
				}

			?>
		</div>

		<div class="six columns">
			<?php
				if(isset($url_add_s) && !empty($url_add_s))
					echo anchor($url_add_s, lang('add_imagen_s'), array('title'=> lang('del_imagen'), 'class' => 'button radius wtc'));
			?>
		</div>
	</div>
</div>