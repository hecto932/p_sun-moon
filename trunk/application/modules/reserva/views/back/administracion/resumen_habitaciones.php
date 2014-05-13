<link rel='stylesheet' id='g1-social-icons-css'  		href='<?php echo base_url(); ?>assets/front/css/main.css' type='text/css' media='all' />
<link rel='stylesheet' id='rs-settings-css'  			href='<?php echo base_url(); ?>assets/front/css/settings.css' type='text/css' media='all' />
<link rel='stylesheet' id='rs-captions-css'  			href='<?php echo base_url(); ?>assets/front/css/captions.css' type='text/css' media='all' />
<link rel='stylesheet' id='g1_woocommerce-css'  		href='<?php echo base_url(); ?>assets/front/css/g1-woocommerce.css' type='text/css' media='screen' />
<link rel='stylesheet' id='g1_screen-css'  				href='<?php echo base_url(); ?>assets/front/css/g1-screen.css' type='text/css' media='screen' />
<link rel='stylesheet' id='g1_dynamic_style-css'  		href='<?php echo base_url(); ?>assets/front/css/g1-dynamic-style.css' type='text/css' media='screen' />
<link rel='stylesheet' id='galleria_theme-css'  		href='<?php echo base_url(); ?>assets/front/css/galleria.classic.css' type='text/css' media='screen' />
<link rel='stylesheet' id='jquery.magnific-popup-css'  	href='<?php echo base_url(); ?>assets/front/css/magnific-popup.css' type='text/css' media='screen' />
<link rel='stylesheet' id='g1_style-css'  				href='<?php echo base_url(); ?>assets/front/css/style.css' type='text/css' media='screen' />
<link rel='stylesheet' id='google_font_490ee25e-css'  	href='<?php echo base_url(); ?>assets/front/fonts/Open-Sans.css' type='text/css' media='all' />
<link rel='stylesheet' id='google_font_7b2b4c23-css'  	href='<?php echo base_url(); ?>assets/front/fonts/Open-Sans-400.css' type='text/css' media='all' />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/solyluna.css">	
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/back.css">	
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/smoothness-jquery-ui.css"/>
<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
<script src="<?php echo base_url(); ?>assets/back/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/js/jquery/jquery-1.10.2.js"></script>

<script>
	$(document).ready(function()
	{
		//alert($(window).width());
		//Datepicker
		$('.fecha_habitaciones').datepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha_filtro');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abrv');?>", "<?php echo lang('datapicker_dia_lunes_abrv');?>", "<?php echo lang('datapicker_dia_martes_abrv');?>", "<?php echo lang('datapicker_dia_miercoles_abrv');?>",  "<?php echo lang('datapicker_dia_jueves_abrv');?>", "<?php echo lang('datapicker_dia_viernes_abrv');?>", "<?php echo lang('datapicker_dia_sabado_abrv');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
		
		//Hide - Show
		$('.cliente_back').click(function()
		{
			if($(this).find('.datos').is(':hidden'))
			{
				$(this).find('.datos').slideDown('slow');
				$(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');
			}
			else
			{
				$(this).find('.datos').slideUp('slow');
				$(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
			}
		});
		
		//anterior
		$('.anterior').click(function(e){
			e.preventDefault();
			$('input[name="habitacion_nav"]').val('anterior');
			$('form[name="filtrar_habitaciones"]').submit();
		});
		//siguiente
		$('.siguiente').click(function(e){
			e.preventDefault();
			$('input[name="habitacion_nav"]').val('siguiente');
			$('form[name="filtrar_habitaciones"]').submit();
		});
		//Consultar
		$('.consultar_habitaciones').click(function(e){
			e.preventDefault();
			$('input[name="habitacion_nav"]').val('');
			$('form[name="filtrar_habitaciones"]').submit();
		});
		
	});
</script>

<?php echo form_open('backend/reservaciones/resumen', array('id' => "gen_form", 'class' => 'custom', 'name' => 'filtrar_habitaciones')) ?>
	<input type="hidden" name="habitacion_nav" value="" ></input>
	<ul class="block-grid">
	  <li><button class="small button radius wtc anterior"> < </button></li>
	  <li><input type="text" name="fecha_habitaciones" class="fecha_habitaciones" value="<?php echo $fecha_habitaciones; ?>" readonly style="height: 28px;" ></input></li>
	  <li style="padding-right: 15px;"><button class="small button radius wtc siguiente"> > </button></li>
	  <li><button class="small button radius wtc consultar_habitaciones"> Consultar fecha </button></li>
	</ul>
</form>
<hr />

<div id="g1-content" style="z-index: inherit !important;">
    <div class="g1-layout-inner" style="padding-top: 0px !important; padding-bottom: 0px !important;">
		<ul class="g1-grid">
			
			<?php $i = 0; ?>
			
			<?php foreach($habitaciones_ocupadas as $habitacion): ?>
				
				<?php
					$i++;
					if($i == 5)
					{
						echo '</ul></div></div>';
						$i = 0;
						echo '<div id="g1-content"><div class="g1-layout-inner" style="padding-top: 0px !important; padding-bottom: 0px !important;"><ul class="g1-grid">';
					}
				?>
				
				<!-- Si esta ocupado -->
				<?php if(isset($habitacion['in']) || isset($habitacion['out']) || isset($habitacion['huesped']) ):?>
					<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on" style="float: left;">
						<div class="habitacion_estado">
							
							<!-- Estado -->
							<div id="g1-message-5" class="g1-message g1-message--info " style="background-color:#B9B9B9;font-size: 12px;border-radius: 7px 7px 0px 0px;">
								<div class="g1-inner">Reservado</div>
							</div>
							
							<!-- Imagen -->
							<figure class="entry-featured-media">
						        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center ">
						            <span class="g1-decorator"><img class="attachment-g1_one_fourth wp-post-image" width="96" src="<?php echo base_url(); ?>assets/back/img/template/habitacion_back.png"></img></span>
						        </a>
						    </figure>
						    
						     <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
						        <div class="g1-inner">
						            <header class="entry-header">
						                
						                <!-- Habitacion -->
						                <h3 style="padding-bottom: 10px;"><a><?php echo $habitacion['codigo']; ?></a></h3>
						              	
					              		<p class="entry-meta g1-meta" style="font-size: 12px;">
				               				<?php if(isset($habitacion['huesped'])): ?>
				               					<a class="cliente_back">
					               					<i class="icon-plus-sign"></i><b> Huesped:</b> <?php echo $habitacion['huesped']; ?><br />
						               				<span class="datos" style="display: none;">
						               					<b>Teléfono:</b> <?php echo $habitacion['huesped_telefono']; ?><br />
						               					<b>Email</b> <?php echo $habitacion['huesped_email']; ?>
						               				</span>
						               			</a>
					               			<?php endif; ?>
					               			
					               			<?php if(isset($habitacion['in'])): ?>
					               				<span style="display: block;">
					               				<a class="cliente_back">
						               				<i class="icon-plus-sign"></i><b> Checkin:</b> <?php echo $habitacion['in_nombre']; ?><br />
							               			<span class="datos" style="display: none;">
							               				<b>Teléfono:</b> <?php echo $habitacion['in_telefono']; ?><br />
							               				<b>Email</b> <?php echo $habitacion['in_email']; ?>
							               			</span>
							               		</a>
							               		</span>
					               			<?php endif; ?>
					               			
					               			<?php if(isset($habitacion['out'])): ?>
					               				<span style="display: block; padding-top: 10px;">
					               				<a class="cliente_back">
						               				<i class="icon-plus-sign"></i><b> Checkout:</b> <?php echo $habitacion['out_nombre']; ?><br />
							               			<span class="datos" style="display: none;">
							               				<b>Teléfono:</b> <?php echo $habitacion['out_telefono']; ?><br />
							               				<b>Email</b> <?php echo $habitacion['out_email']; ?>
							               			</span>
						               			</a>
						               			</span>
					               			<?php endif; ?>
						                </p>
						                
						            </header>
						    	</div>
							</div>
							
						</div>
					</li>
				<?php else: ?>
					
					<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on" style="float: left;">
						<div class="habitacion_estado">
							
							<!-- Estado -->
							<div id="g1-message-5" class="g1-message g1-message--success" style="font-size: 12px;border-radius: 7px 7px 0px 0px;">
								<div class="g1-inner">Disponible</div>
							</div>
							
							<!-- Imagen -->
							<figure class="entry-featured-media">
						        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center ">
						            <span class="g1-decorator"><img class="attachment-g1_one_fourth wp-post-image" width="96" src="<?php echo base_url(); ?>assets/back/img/template/habitacion_back.png"></img></span>
						        </a>
						    </figure>
						    
						    <!-- Habitacion y asignar -->
						    <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
						        <div class="g1-inner">
						            <header class="entry-header">
						                <h3 style="padding-bottom: 10px;"><a><?php echo $habitacion['codigo']; ?></a></h3>
						                <!--
						                <p class="entry-meta g1-meta" style="font-size: 12px;">
						                	<a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard" style="color: #FFFFFF;"><i class="icon-plus"></i> Asignar</a>
						                </p>
						                -->
						            </header>
						    	</div>
							</div>
							
						</div>
					</li>
					
				<?php endif;?>
				
			<?php endforeach; ?>
			
		</ul>
    </div>
</div>