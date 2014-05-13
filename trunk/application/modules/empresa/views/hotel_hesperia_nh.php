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
	<div class="six columns hotel_hesperia">
		<img class="img_principal" alt="prueba" src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia.jpg"/>
        
        
        <a href="http://www.hesperia.es/nh/es/hoteles/venezuela/valencia/hesperia-wtc-valencia.html" target="_blank">
        	<img class="img_secundaria" alt="prueba2" src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/logo_hesperia.png" style="width: 433px; height: 294px">
        </a>
	</div>
	
	<div class="six columns">
		 <h3><span style="color: #B2B2B2;">Hotel Hesperia WTC</span><br></h3>
        <p><br></p>
        <p>Hotel Hesperia WTC Valencia, de categoría superior, pertenece a la cadena Hesperia / NH Hoteles, con presencia en 24 países; es una de las más grandes en España y la quinta de Europa en la categoría de negocios.<u></u><u></u></p>
        <p><br>
          El hotel de 15 pisos cuenta con 323 lujosas habitaciones, todas con aislamiento acústico que las mantiene en un ambiente  de silencio y tranquilidad absoluto, idóneo para el descanso o una reunión privada de negocios en la sala ejecutiva (habitaciones Suites). El equipamiento estándar de las habitaciones incluye: lujosa ropa de cama, una amplia variedad de comodidades, como Wi-Fi, televisión LCD y minibar.<u></u><u></u></p>
        <p><br>
          El hotel ofrece un buffet estilo gourmet en el Restaurant Atmósfera, así como una gastronomía refinada y de ambiente íntimo en el Restaurant Orión o una noche de bebidas y diversión en el Rio´s Scotch Bar. Las instalaciones del Hotel Hesperia WTC Valencia están acordes a su categoría: piscina al aire libre, cancha de tenis, gimnasio, spa y saunas, peluquería, lounge, cafetería, lobby bar y salones privados. Entre sus servicios destacan: servicios de botones, servicio de habitaciones 24 horas, alquiler de autos, oficinas de líneas aéreas, servicio de traslados ejecutivos, entre otros.</p>
	</div>
</div>

<div class="row" style="margin-top: 25px">
	<div class="twelve columns centered">
		<h3 align="center">Hotel Hesperia NH</h3>
	</div>
</div>

<div class="row" style="margin-top: 25px">
	<div class="three columns"></div>
	<div class="nine columns">
		<div class="ten columns no-padding">
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia_02.jpg" rel="shadowbox[nh]" title="Hotel Hesperia Habitacion">
		        	<img src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/thumbnails/hotel_hesperia_02.jpg" width="100" height="75" alt="gal1">
		        </a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia_03.jpg" rel="shadowbox[nh]" title="Hotel Hesperia Habitacion">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/thumbnails/hotel_hesperia_03.jpg" width="100" height="75" alt="gal2">
	        	</a>
			</div>
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia_04.jpg" rel="shadowbox[nh]" title="Lobby del Hotel Hesperia">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/thumbnails/hotel_hesperia_04.jpg" width="100" height="75" alt="gal3">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia_05.jpg" rel="shadowbox[nh]" title="Bar del Hotel Hesperia">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/thumbnails/hotel_hesperia_05.jpg" width="100" height="75" alt="gal4">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/hotel_hesperia_01.jpg" rel="shadowbox[nh]" title="Fallada Hotel Hesperia">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/hotel_hesperia/thumbnails/hotel_hesperia_01.jpg" width="100" height="75" alt="gal5">
	        	</a>
			</div>
		</div>
	</div>
</div>