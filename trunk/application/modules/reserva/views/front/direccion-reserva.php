
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.direccion.reserva.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.direccion.reserva.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.direccion.reserva.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.direccion.reserva.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.direccion.reserva.breadcrumb3'); ?></li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.direccion.reserva.breadcrumb4'); ?></li>
   			</ol>
   		</nav> 
   		
   		<?php //echo validation_errors(); ?>
   		<div id="g1-content-area">
   			<div id="primary">
   				<div id="g1-message-1" class="g1-message g1-message--success ">
					<div class="g1-inner">
				       <?php echo lang('front.direccion.reserva.p1'); ?>
				    </div>
				</div>

				<!-- NUEVA TABLA DATOS USUARIOS -->
				<div id="direccion_reserva_responsive">
					<div id="mensaje_disponibilidad" class="g1-message g1-message--info habitacion_responsive_cabecera">
						<div class="g1-inner" style="text-transform: uppercase;">
							<?php echo lang('front.direccion.reserva.p2'); ?>
						</div>
					</div>
					<div class="row">
						<!-- reserva/reserva_front/guardar_reserva -->
						<form id="form_guardar_reserva" action="<?php echo lang('front.reserva_url').'/'.lang('front.reservando.url'); ?>" method="post">
							<input type="hidden" name="sesion" value="<?php echo $this->session->userdata("id_usuario"); ?>" />
		        			<input type="hidden" name="fecha_llegada" value="<?php echo $fecha_llegada; ?>" />
				   			<input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida; ?>" />
				   			<input type="hidden" name="noches" value="<?php echo $noches; ?>" />
				   			<input type="hidden" name="temporada" value="<?php echo $temporada; ?>" />
				   			<input type="hidden" name="titular_reserva" value="<?php echo $titular_reserva; ?>">
				   			<input type="hidden" name="personas" value="<?php echo $personas; ?>">
				   			<input type="hidden" name="tratamiento" value="<?php echo $tratamiento; ?>" />
				   			
				   			<?php $i=0; ?>
				   			<?php foreach($habs as $h => $value1) : ?>
				   				<?php foreach($value1 as $a => $value2): ?>
				   					<input type="hidden" name="habs[<?php echo $i; ?>][<?php echo $a; ?>]" value="<?php echo $value2; ?>" />
				   				<?php endforeach; ?>	
				   				<?php ++$i; ?>	   				
				   			<?php endforeach; ?>
				   			
				   			<?php foreach($tip_habs as $h => $value1) : ?>
				   				<input type="hidden" name="tip_habs[<?php echo $h; ?>]" value="<?php echo $value1; ?>"/> 				
				   			<?php endforeach; ?>
				   			
				   			<?php $i=0; ?>
				   			<?php foreach($hab_disponibles as $h => $value1) : ?>
				   				<?php foreach($value1 as $a => $value2): ?>
				   					<input type="hidden" name="hab_disponibles[<?php echo $i; ?>][<?php echo $a; ?>]" value="<?php echo $value2; ?>" />
				   				<?php endforeach; ?>	
				   				<?php ++$i; ?>	   				
				   			<?php endforeach; ?>
				   			
		        			
		        			<input type="hidden" name="denominacion" value="<?php echo $denominacion; ?>"/>
		        			<input type="hidden" name="precio" value="<?php echo $precio; ?>"/>
			        		<input type="hidden" name="cant_habitaciones" value="<?php echo $cant_habitaciones; ?>" />
							
							<div class="large-12 columns">
								<div class="large-6 columns">
									<label for="direccion"><?php echo lang("front.direccion.reserva.direccion"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
                                 	<input id="direccion" type="text" name="direccion" readonly="readonly" value="<?php echo $this->session->userdata("direccion"); ?>" />
									<label for="aerolinea"><?php echo lang("front.direccion.reserva.aerolinea"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
                                    <input id="aerolinea" type="text" name="aerolinea" value="<?php echo @$aerolinea; ?>" />
                                    <small id="error_aerolinea" class="error" style="display:none;height: 24px;font-size: 12px;"></small>
									<label for="direccion"><?php echo lang("front.direccion.reserva.pais"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em> </label>
									<?php echo form_dropdown('id_pais', $opt_paises, $this->session->userdata("id_pais")); ?>
									<?php	if(form_error('id_pais'))
												echo form_error('id_pais');
											else
												echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
							 		?>
							 		<label for="direccion"><?php echo lang("front.direccion.reserva.forma_pago"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em> </label>
									<?php echo form_dropdown('id_tipo_forma_pago', $formas_pago,set_value('id_tipo_forma_pago')); ?>
									<?php	if(form_error('id_tipo_forma_pago'))
												echo form_error('id_tipo_forma_pago');
											else
												echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
							 		?>
								</div>
								<div class="large-6 columns">
									<label for="nombre"><?php echo lang("front.direccion.reserva.nombre"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
                                   	<input id="nombre" type="text" name="nombre" readonly="readonly" value="<?php echo @$this->session->userdata("nombre"); ?>" disabled="disabled" />
									<label for="correo"><?php echo lang("front.direccion.reserva.email"); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
                                    <input id="correo" type="text" name="correo" readonly="readonly" value="<?php echo @$this->session->userdata("email"); ?>" disabled="disabled" />
									<label for="telefono"><?php echo lang("front.direccion.reserva.telefono"); ?> <span style="font-size: 9px;">(<?php echo lang('front.solo_numeros'); ?>)</span> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em> </label>
									<input  type="text" name="telefono" value="<?php echo $this->session->userdata('telefono'); ?>" />
									<small id="error_telefono" class="error"  style="display:none;height: 24px;font-size: 12px;"></small>
									<label for="observaciones"><?php echo lang('front.reserva_observaciones'); ?></label>
									<textarea id="observaciones" name="observaciones" class="noResize" rows="5" cols="5"><?php echo @$observaciones; ?></textarea>
								</div>
							</div>
							<button id="submit" type="submit"class="button" style="display: none;">Reservar por <?php echo $denominacion." ".$precio; ?></button>
						</form>
					</div>
				</div>
				<div id="resumen_reserva">
   					<div id="mensaje_disponibilidad" class="g1-message g1-message--success habitacion_responsive_cabecera">
						<div class="g1-inner" style="text-transform: uppercase;">
							<?php echo lang('front.datos.reserva.subtitulo3'); ?>
						</div>
					</div>
					<div style="text-align: center; padding:0em 1em;">
						<ul id="g1-list-1" class="g1-list--empty g1-list--simple ">
							<?php //if($this->session->userdata("nombre")): ?>
								<li id="titular_li" class="titular_li" style="<?php echo ($this->session->userdata("nombre") ? "display:block;" : "display:none;"); ?>">
									<?php echo lang('front.datos.reserva.subtitulo4'); ?> <br /
									><b style="font-size: 20px;" class="titular_reserva">
										<?php echo $this->session->userdata("nombre"); ?>
									</b>
								</li>
							<?php //endif;?>
							<li><?php echo lang('front.datos.reserva.checkin'); ?> <b style="font-size: 20px;"><?php echo $fecha_llegada; ?></b></li>
							<li><?php echo lang('front.datos.reserva.checkout'); ?> <b style="font-size: 20px;"><?php echo $fecha_salida; ?></b></li>
							<li><?php echo lang('front.datos.reserva.habitaciones'); ?> <b style="font-size: 20px;"><?php echo $cant_habitaciones; ?></b></li>
							<?php $i=0; ?>
							<?php foreach($tip_habs as $th => $value): ?>
								<?php if($value!=0): ?>
									<li><b style="font-size: 20px;"><?php echo $hab_disponibles[$i]['tipo']; ?></b> : <b style="font-size: 20px;"><?php echo $value; ?></b></li>
								<?php endif; ?>
								<?php $i++; ?>
							<?php endforeach; ?>
							<li><?php echo lang('front.datos.reserva.noches'); ?> <b style="font-size: 20px;"><?php echo $noches; ?></b></li>
							<!-- <li>IVA <b>(12%)</b> aplicado.</li> -->
						</ul>
					</div>
					<div style="text-align:center;">
						<h1 style="text-decoration: underline;"><?php echo lang('front.datos.reserva.total'); ?></h1>
						<h2><b style="font-size: 20px;"><?php echo $denominacion." ".$precio; ?></b></h2>
					</div>
				</div>
				<div class="row">
					<center>
						<div class="large-12 columns">
							<a id="g1-button-21" class="g1-button g1-button--medium g1-button--solid g1-button--standard " href="<?php echo lang('front.inicio_url'); ?>"><i class="icon-remove"></i> <?php echo lang('front.reserva.habitaciones.btn2'); ?></a>
							<a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard"> Reservar por <?php echo $denominacion." ".$precio; ?></a>
						</div>
					</center>
				</div>


				<script src="assets/front/js/jquery/jquery.min.js"></script> 
				<script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#g1-button-24').click(function(){
							$('#error_aerolinea').slideUp('slow');
							$('#error_telefono').slideUp('slow');
							var url = 'reserva/reserva_front/ajax_guardar_reserva';
							
							$.ajax({
								url:		url,
								type:		'POST',
								dataType:	'json',
								data:		$('#form_guardar_reserva').serialize(),
								success: function(json)
								{
									if(json.mensaje == "Correcto")
									{
										$('#submit').click();
									}
									else
									{
										if(json.error_aerolinea !="")
										{
											$('#error_aerolinea').html(json.error_aerolinea);
											$('#error_aerolinea').slideDown('slow');
										}
										if(json.error_telefono !="")
										{
											$('#error_telefono').html(json.error_telefono);
											$('#error_telefono').slideDown('slow');
										}
										
									}
								}
							});
						});
						
						$( document ).ajaxStart(function() {
							$( "#cargador" ).show();
							$("#g1-button-24").attr("disabled", "disabled");
							$('#g1-button-24').css( "border-color", "rgb(153, 153, 153)" );
							$('#g1-button-24').css( "background-color", "rgb(153, 153, 153)" );
							
						});
						
						$( document ).ajaxStop(function() {
							$( "#cargador" ).hide();
							$("#g1-button-24").removeAttr("disabled");
							$('#g1-button-24').css( "border-color", "rgb(46, 204, 113)" );
							$('#g1-button-24').css( "background-color", "rgb(46, 204, 113)" );
						});
					});
				</script>
				<div id="cargador"></div>
				<!-- /TU GARANTIA DE LA RESERVA-->
   				
   			</div>
   			<div id="secondary">
   				<div id="resumen_reserva_lateral">
   					<div id="mensaje_disponibilidad" class="g1-message g1-message--success habitacion_responsive_cabecera">
						<div class="g1-inner" style="text-transform: uppercase;">
							<?php echo lang('front.datos.reserva.subtitulo3'); ?>
						</div>
					</div>
					<div style="text-align: center;padding:0em 1em;">
						<ul id="g1-list-1" class="g1-list--empty g1-list--simple ">
							<?php //if($this->session->userdata("nombre")): ?>
								<li id="titular_li" class="titular_li" style="<?php echo ($this->session->userdata("nombre") ? "display:block;" : "display:none;"); ?>">
									<?php echo lang('front.datos.reserva.subtitulo4'); ?> <br />
									<b style="font-size: 20px;" class="titular_reserva">
										<?php echo $this->session->userdata("nombre"); ?>
									</b>
								</li>
							<?php //endif;?>
							<li><?php echo lang('front.datos.reserva.checkin'); ?> <b style="font-size: 20px;"><?php echo $fecha_llegada; ?></b></li>
							<li><?php echo lang('front.datos.reserva.checkout'); ?> <b style="font-size: 20px;"><?php echo $fecha_salida; ?></b></li>
							<li><?php echo lang('front.datos.reserva.habitaciones'); ?> <b style="font-size: 20px;"><?php echo $cant_habitaciones; ?></b></li>
							<?php $i=0; ?>
							<?php foreach($tip_habs as $th => $value): ?>
								<?php if($value!=0): ?>
									<li><b style="font-size: 20px;"><?php echo $hab_disponibles[$i]['tipo']; ?></b> : <b style="font-size: 20px;"><?php echo $value; ?></b></li>
								<?php endif; ?>
								<?php $i++; ?>
							<?php endforeach; ?>
							<li><?php echo lang('front.datos.reserva.noches'); ?> <b style="font-size: 20px;"><?php echo $noches; ?></b></li>
							<!-- <li>IVA <b>(12%)</b> aplicado.</li> -->
						</ul>
					</div>
					<div style="text-align:center;">
						<h1 style="text-decoration: underline;"><?php echo lang('front.datos.reserva.total'); ?></h1>
						<h2><b style="font-size: 20px;"><?php echo $denominacion." ".$precio; ?></b></h2>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>
