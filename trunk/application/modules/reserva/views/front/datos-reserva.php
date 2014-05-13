<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.datos.reserva.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.datos.reserva.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.datos.reserva.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.datos.reserva.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item">
   					<?php echo lang('front.datos.reserva.breadcrumb3'); ?>
   				</li>
   				<li class="g1-nav-breadcrumbs__item">
   					<?php echo lang('front.datos.reserva.breadcrumb4'); ?>
   				</li>
   			</ol>
   		</nav> 
   		
   		<?php echo validation_errors(); ?>
   		<div id="g1-content-area">
   			<div id="primary">
				
				<!-- VISTA RESPONSIVA DE INICIAR SESION FUNCIONANDO -->
				<?php if(!$this->session->userdata("id_usuario")): ?>
					<div id="iniciar_sesion_responsive">
						<div id="mensaje_disponibilidad" class="g1-message g1-message--warning habitacion_responsive_cabecera">
							<div id="mensaje" class="g1-inner" style="text-transform: uppercase;">
								Iniciar sesión
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<p><strong>¿Aun no has iniciado sesión?</strong> Inicia sesión aqui para reservar mas rapido.</p>
								<form id="inicio_sesion_responsive">
									<div class="correo">
										<label for="email_responsive">Email</label>
										<input id="email_responsive" name="email" type="email"  />
									</div>
									<div class="pass">
										<label for="password_responsive">Contraseña</label>
										<input id="password_responsive" name="password" type="password"  />
									</div>
									<center><a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard" style="text-align:center;">Iniciar sesión</a></center>
								</form>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- POOL DE HABITACIONES ESCOGIDAS -->
				<div id="pool_habitaciones_responsive">
					<div id="mensaje_disponibilidad" class="g1-message g1-message--info habitacion_responsive_cabecera">
						<div class="g1-inner" style="text-transform: uppercase;">
							Tus datos
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<form id="form_direccion_reserva" action="<?php echo lang("front.reserva_url").'/'.lang('front.direccion_reservacion_url'); ?>" method="post">
								<!-- DATOS A MANTENER DURANTE LA RESERVA -->
								<input id="id_session_direccion_responsive" type="hidden" name="sesion" value="<?php echo $this->session->userdata("id_usuario"); ?>" />
			        			<input type="hidden" name="fecha_llegada" value="<?php echo $fecha_llegada; ?>" />
					   			<input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida; ?>" />
					   			<input type="hidden" name="noches" value="<?php echo $noches; ?>" />
					   			<input type="hidden" name="temporada" value="<?php echo $temporada; ?>" />
					   			<input type="hidden" name="precio" value="<?php echo $precio; ?>" />
					   			<input type="hidden" name="cant_habitaciones" value="<?php echo $cant_habitaciones; ?>" />

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

								<!-- /DATOS A MANTENER DURANTE LA RESERVA -->
								
								<!-- DATOS DEL TITULAR DE LA RESERVA -->
								<label for="tratamiento"><?php echo lang('front.datos.reserva.tratamiento'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
								<select id="tratamiento" name="tratamiento">
									<option value="Sr."><?php echo lang('front.datos.reserva.tratamiento.op1'); ?></option>
									<option value="Srta."><?php echo lang('front.datos.reserva.tratamiento.op2'); ?></option>
									<option value="Sra."><?php echo lang('front.datos.reserva.tratamiento.op3'); ?></option>
								</select>
								<label><?php echo lang('front.datos.reserva.nombre'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
								<input id="nombre_titular" type="text" name="nombre" readonly="readonly" value="<?php echo @$this->session->userdata('nombre'); ?>" />
								<label for="email"><?php echo lang('front.datos.reserva.email'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
								<input id="email_titular" type="text" name="email" readonly="readonly" value="<?php echo @$this->session->userdata('email'); ?>" />
								<!-- /DATOS DEL TITULAR DE LA RESERVA -->
								
								<center><h3><?php echo lang("front.datos.reserva.condiciones"); ?></h3></center>

								<!-- HABITACIONES -->
								<?php $k=1;?>
								<?php foreach($habs as $habitacion => $value1): ?>
									<div class="row">
										<div class="large-12 columns">
											<div class="large-4 columns">
												<figure>
													<figcaption>
														<h5><?php echo lang('front.datos.reserva.habitacion'); ?> <?php echo $value1['tipo']; ?></h5>
													</figcaption>
													<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" alt="Imagen habitacion"/>
												</figure>	
											</div>
											<div class="large-8 columns">
												<label for="nombre_cliente"><?php echo lang('front.datos.reserva.nombre_cliente'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
												<input class="cliente" id="nombre_cliente" type="text" name="nombre_cliente[]" value="<?php echo @$this->session->userdata('nombre'); ?>" />
												<div class="datos_descripcion">
						               				<i class="icon-plus-sign"></i><strong> Descripción</strong>
							               			<div class="descripcion" style="display: none;">
							               				<p><?php echo $value1['tipo_descrip']; ?></p>
							               			</div>
							               		</div>
												<div class="datos_condiciones">
						               				<i class="icon-plus-sign"></i><strong> Condiciones</strong>
							               			<div class="condiciones" style="display: none;">
							               				<ul>
															<li><p><strong><?php echo lang('front.datos.reserva.p6'); ?> </strong><?php echo lang('front.datos.reserva.p7'); ?></p></li>
														</ul>
							               			</div>
							               		</div>
												<div class="datos_servicios">
						               				<i class="icon-plus-sign"></i><strong> Servicios de habitación</strong>
							               			<div class="servicios" style="display: none;">
							               				<p><?php echo lang('front.datos.reserva.p8'); ?></p>
							               			</div>
							               		</div>

												<p>
													<strong>Personas Max.</strong>
													<?php for($i=0;$i<$value1['personas'];++$i): ?>
														<i class="icon-user"></i>
													<?php endfor;?>
													<br />
												</p>
												<label for="peticiones"><strong><?php echo lang('front.datos.reserva.peticiones_especiales'); ?></strong></label>
												<textarea  name="peticiones[]" class="noResize"></textarea>
												<em><?php echo lang('front.datos.reserva.nota_peticiones'); ?></em>
											</div>
										</div>
									</div>
									<?php if(count($habs) != $k): ?>
										<div id="border_responsive"></div>
									<?php endif; ?>
									<?php ++$k; ?>
								<?php endforeach; ?>
								<!-- /HABITACIONES -->
								

								<button id="submit" type="submit" class="button" style="display: none;"><?php echo lang('front.datos.reserva.btn_continuar'); ?></button>
							</form>
						</div>
					</div>	
				</div>
   				<div id="resumen_reserva">
   					<div id="mensaje_disponibilidad" class="g1-message g1-message--success habitacion_responsive_cabecera">
						<div class="g1-inner" style="text-transform: uppercase;">
							<?php echo lang('front.datos.reserva.subtitulo3'); ?>
						</div>
					</div>
					<div style="text-align: center;padding:0em 1em;">
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
				<?php	if(form_error('sesion') && !$this->session->userdata("nombre"))
						echo form_error('sesion');
				?>
				
				<br />
				
				<?php	if(form_error('nombre_cliente'))
							echo form_error('nombre_cliente');
				?>
				<div id="botones" class="form-row">
					<center>
						<a id="g1-button-21" class="g1-button g1-button--medium g1-button--solid g1-button--standard " href="<?php echo lang('front.inicio_url'); ?>"><i class="icon-remove"></i> <?php echo lang('front.reserva.habitaciones.btn2'); ?></a>
						<a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard"> <?php echo lang('front.datos.reserva.btn_continuar'); ?></a>		
					</center>
				</div>
				<div id="cargador" style="top:60%;"></div>
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
			<script src="assets/front/js/jquery/jquery.min.js"></script>
            <script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){

                    //INICIO DE SESION RESPONSIVO POR AJAX
                    $('#g1-button-23').click(function(){
                        var url = "reserva/reserva_front/iniciar_sesion";
                        $.ajax({
                            url:    	url,
                            type:     	'POST',
                            dataType: 	'json',
                            data:     	$('#inicio_sesion_responsive').serialize(),
                            success: function(json)
                            {
                                //alert(json.titular_reserva);
                                if(json.mensaje=="Iniciado")
                                {
                                    $("#iniciar_sesion_responsive").slideUp("slow");
                                    $('.cliente').each(function(){
                                           $(this).val(json.titular_reserva);
                                    });
                                    $("#nombre_titular").val(json.titular_reserva);
                                    $("#email_titular").val(json.email);
                                    $("#titular_reserva").html(json.titular_reserva);
                                    $("#titular_reserva_responsive").html(json.titular_reserva);
                                    $('.titular_reserva').each(function(){
                                           $(this).html(json.titular_reserva);
                                    });
                                    $('.titular_li').each(function(){
                                           $(this).css( "display", "block" );
                                    });
                                    $('#panel_usuario').css( "display", "block" );
                                    $('#log_usuario').html('<b>Usuario: </b> '+json.titular_reserva);
                                    $('#logout').css( "display", "block" );
                                    $('#id_session_direccion_responsive').val(json.id_usuario);
                                }
                                else
                                {
                                    $('#inicio_sesion_responsive').find('#password_responsive').val('');
                                    alert("Usuario o contraseña incorrecto.");
                                }
                            }
                        });
                        return false;
                    });

					 $('#g1-button-24').click(function(){
                        var url = "reserva/reserva_front/ajax_direccion_reserva";

                        $.ajax({
                            url:    url,
                            type:     'POST',
                            dataType: 'json',
                            data:     $('#form_direccion_reserva').serialize(),
                            success: function(json)
                            {
                                if(json.mensaje == "correcto")
                                {
                                    $('#submit').click();
                                }
                                else
                                {
                                    if(json.error_sesion!="")
                                    {
                                      	$('#mensaje_sesion_responsive').find('#mensaje').html("<strong style='color: white;'> Debes iniciar sesion para poder continuar con la reserva. </strong>");
                                    	$('#mensaje_sesion_responsive').slideDown( "slow" );
                                    	$('#mensaje_disponibilidad').removeClass('g1-message--warning');
                                    	$('#mensaje_disponibilidad').addClass('g1-message--error');
                                    	var target_offset = $("#iniciar_sesion_responsive").offset();
                                        var target_top = target_offset.top;
                                        $('html,body').animate({scrollTop:target_top -100}, 800);
                                    }
                                    else
                                    {
                                        if(json.error_nombre_cliente!="")
                                        {
                                            var target_offset = $("#nombre_cliente").offset();
                                            target_top = target_offset.top;
                                            $('html,body').animate({scrollTop:target_top -120}, 800);
                                            alert("Campo titular de habitacion se encuentra vacio.");
                                        }
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

                    $('.datos_descripcion').click(function(){
                        if($(this).find('.descripcion').is(':hidden'))
                        {
                            $(this).find('.descripcion').slideDown('slow');
                            $(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');

                        }
                        else
                        {
                            $(this).find('.descripcion').slideUp('slow');
                            $(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                        }
                    });

                    $('.datos_condiciones').click(function(){
                        if($(this).find('.condiciones').is(':hidden'))
                        {
                            $(this).find('.condiciones').slideDown('slow');
                            $(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');

                        }
                        else
                        {
                            $(this).find('.condiciones').slideUp('slow');
                            $(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                        }
                    });

                    $('.datos_servicios').click(function(){
                        if($(this).find('.servicios').is(':hidden'))
                        {
                            $(this).find('.servicios').slideDown('slow');
                            $(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');

                        }
                        else
                        {
                            $(this).find('.servicios').slideUp('slow');
                            $(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
                        }
                    });

                });

            </script>
		</div>
	</div>
</div>

