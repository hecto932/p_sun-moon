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
	<div class="six columns" style="margin-top: 35px">
		<div>
			<img alt="Prueba" class="wtcv_img_principal" src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_wtcvalencia_01.jpg">
		    <img alt="prueba2" src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_wtcvalencia_02.jpg">
    	</div>
	</div>
	
	<div class="six columns">
			<h3>&nbsp;</h3>
		        
			<h3>
					<span style="color: #B2B2B2;">WTC Valencia</span>
				<br>
			</h3>
		        
			<p><br></p>
		        
			<p>WTC Valencia esta anclado al norte de la ciudad de mayor proyección económica en la región central y centro occidental de Venezuela, ocupa un área de 4 hectáreas con su centro de convenciones, salas para reuniones, torre de oficinas, locales comerciales, hotel cinco estrellas y áreas de exposición para ferias. Como primera ciudad industrial de Venezuela, Valencia es pionera en el país en acoger el concepto de la marca WTC: pertenecer a una  red global que <strong>&ldquo;promueve prosperidad a través del intercambio comercial e inversiones&rdquo;.</strong></p>
			<p> 
				<br>
		    	El World Trade Center Valencia es una moderna torre corporativa, diseñada bajo los estándares de la marca WTC, cuenta con una infraestructura y organización de clase mundial para facilitar el servicio a  los clientes corporativos e individuales, organizadores de eventos, huéspedes, entre otros. WTC Valencia se constituye en el epicentro de reuniones de negocios, convenciones y congresos.
		    </p>
		    <p>
		    <br>
			Paralelamente, se proyecta el <strong>WTC Club </strong>como un espacio de encuentro idóneo para el desarrollo de negocios entre empresarios, ejecutivos, industriales y corporaciones y donde se prestan servicios de: estudios de mercado, asesorías legales, coordinación de misiones comerciales,  triangulación de negocios, programas de desarrollo gerencial, conferencias, seminarios y logística para la exposición de productos y servicios.</p>
		<p></p>
	</div>
</div>

<div class="row" style="margin-top: 25px">
	<div class="one column"></div>
	<div class="seven columns centered">
		<h3>WTC Valencia</h3>
	</div>
</div>

<div class="row" style="margin-top: 35px">
	<div class="three columns"></div>
	<div class="nine columns">
		<div class="ten columns no-padding">
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_valencia_03.jpg" rel="shadowbox[wtcvalencia]" title="World Trade Center Valencia - Venezuela">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/thumbnails/wtcv_valencia_03.jpg" alt="gal2">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_valencia_04.jpg" rel="shadowbox[wtcvalencia]" title="World Trade Center Valencia - Venezuela">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/thumbnails/wtcv_valencia_04.jpg" alt="gal3">
	        	</a>
			</div>
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_valencia_06.jpg" rel="shadowbox[wtcvalencia]" title="World Trade Center Valencia - Venezuela">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/thumbnails/wtcv_valencia_05.jpg" alt="gal4">
				</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_valencia_05.jpg" rel="shadowbox[wtcvalencia]" title="World Trade Center Valencia - Venezuela">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/thumbnails/wtcv_valencia_06.jpg" alt="gal5">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/wtcv_valencia_07.jpg" rel="shadowbox[wtcvalencia]" title="World Trade Center Valencia - Venezuela">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/wtc_valencia/thumbnails/wtcv_valencia_07.jpg" alt="gal6">
	        	</a>
			</div>
		</div>
	</div>
</div>