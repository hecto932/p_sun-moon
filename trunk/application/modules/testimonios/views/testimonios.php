<script type="text/javascript" src="assets/front/raty/demo/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/front/raty/lib/jquery.raty.js"></script>

<script type="text/javascript">
	var j = jQuery.noConflict();
	var base_url = 'assets/front/raty/lib/img/';
	
	j( document ).ready(function()
	{
		j('.star').raty({
		  path:     null,
		  starOn:   base_url+'star-on.png',
		  starOff:  base_url+'star-off.png',
		  starHalf: base_url+'star-half.png',
		  score: 1
		});
		
	});
</script>

<script type="text/javascript">

	var jq = jQuery.noConflict();
	jq(document).ready(function()
	{
		jq('.star').css('width', '130px');
		jq('.star_rating').css('width', '130px');
		
		jq('.set_comentarios').find('div.star_rating').raty({
		  readOnly: true,
		  path:     null,
		  starOn:   base_url+'star-on.png',
		  starOff:  base_url+'star-off.png',
		  starHalf: base_url+'star-half.png',
		  score: function(){return $(this).attr('data-score');}
		});
		
	});
</script>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front_title.testimonios'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front_title.testimonios'); ?></h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
<div id="g1-content">
	<div class="g1-layout-inner">
		
   		<!-- Breadcrumbs -->
		<?php if(isset($breadcrumbs)): ?>
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.nosotros_direccion'); ?></p>
   			<ol>
   				<?php foreach($breadcrumbs as $titulo => $url):?>
   				<li class="g1-nav-breadcrumbs__item" >
   					<a itemprop="url" href="<?php echo $url; ?>">
   						<?php echo $titulo; ?>
   					</a>
   				</li>
   				<?php endforeach; ?>
   			</ol>
   		</nav>  
   		<?php endif; ?> 
   		
   		<!-- VISTA DESKTOP-->
   		<div id="g1-content-area" class="hide-for-small">
    		<div id="primary">
				<div id="content" role="main">
					<article id="post-1701" class="post-1701 page type-page status-publish g1-complete instock">      
                        
                        <!-- BEGIN .entry-content -->
                        <div class="entry-content set_comentarios">                         	
							<div id="g1-divider-top-1" class="g1-divider-top g1-meta "></div>
                  			
                  			<?php if(isset($mensaje_comentario_guardado) && !empty($mensaje_comentario_guardado)): ?>
                  				
                  				<div id="g1-message-1" class="g1-message g1-message--success ">
									<div class="g1-inner">
										<?php echo $mensaje_comentario_guardado; ?>
									</div>
								</div>
                  				
                  			<?php endif; ?>
                  			
                  			<?php if(isset($comentarios) && !empty($comentarios)): ?>
                  				
                  				<h2><?php echo lang('front.testimonios_comentarios_visitantes'); ?></h2>
                  			
                  				<?php foreach($comentarios as $comentario): ?>
                  					
                  					<span><b><?php echo lang('front.testimonios_puntuacion'); ?>: </b><div class="star_rating" data-score="<?php echo $comentario->rating; ?>"></div> </span>
                  					
									<figure id="g1-quote-4" class="g1-quote g1-quote--solid g1-quote--small " >
										
										<div class="g1-inner">
											<p><?php echo $comentario->comentario; ?></p>
										</div>
										
										<figcaption class="g1-meta">
											
											<span class="g1-quote__image"></span>
											
											<strong><?php echo $comentario->nombre; ?></strong>
											
											<?php
												list($anio, $mes, $dia_hora) =  explode('-', $comentario->creado);
												list($dia, $hora) = explode(' ', $dia_hora);
												$creado = implode('-', array($dia, $mes, $anio)).' '.$hora;
											?>
											
											<span><b><?php echo lang('front.testimonios_fecha_publicacion'); ?>: </b> <?php echo $creado; ?></span>
											
										</figcaption>
										
									</figure>

							<div id="g1-divider-3" class="g1-divider g1-divider--none g1-divider--noicon "></div>
							<?php endforeach; ?>
							<?php  endif; ?>
						</div>
						
						<nav class="g1-pagination">
							<p>
								<?php echo @$paginacion; ?>
							</p>
    					</nav>
    				
                        <!-- END .entry-content -->
                        <footer class="entry-meta">
                        	
                        	<h2><?php echo lang('front.testimonios_comentarios_experiencia'); ?></h2>
                        	
							<form accept-charset="UTF-8" action="<?php echo base_url()."testimonios/testimonios/comentar"; ?>" method="post">
								
								<div class="form-row" id="nombre_completo_div">
									<label><?php echo lang('front.testimonios_nombre'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<input type="text" name="nombre_completo" value="<?php echo @$nombre_completo; ?>" />
									<?php
											if(form_error('nombre_completo'))
												echo form_error('nombre_completo');
											else
												echo '<small class="error" style="display:none;">El campo es obligatorio, no puede estar vacio.</small>'
								 	?>
								</div>
								<div class="form-row" id="email_div">
									<label><?php echo lang('front.testimonios_email'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<input type="text" name="email" value="<?php echo @$email; ?>" />
									<?php	if(form_error('email'))
												echo form_error('email');
											else
												echo '<small class="error" style="display:none;">El campo es obligatorio, no puede estar vacio.</small>'
								 	?>	
								</div>
								
								<div class="form-row">
									<label><?php echo lang('front.testimonios_puntuacion'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<div class="star"></div>	
								</div>
								
								<div class="form-row" id="mensaje_div">
										<label><?php echo lang('front.contacto_label3'); ?></label>
										<textarea  name="mensaje" rows="5" cols="5"><?php if(isset($mensaje) && !empty($mensaje)) echo $mensaje; ?></textarea>
										<?php	if(form_error('mensaje'))
													echo form_error('mensaje');
												else
													echo '<small class="error" style="display:none;">'.lang('front.testimonios_required2').'.</small>'
								 		?>
									</div>
								<!-- 
								<div class="form-row" id="captcha_div">
									<label for="contact_form_captcha_1">7 + 3 ?  <em class="meta">(<?php echo lang('front.testimonios_humano'); ?>)</em></label>
									<input type="text" name="captcha" value="<?php echo @$captcha; ?>" />
									<?php	if(form_error('captcha'))
												echo form_error('captcha');
											else
												echo '<small class="error" style="display:none;">'.lang('front.testimonios_required2').'</small>'
								 	?>
								</div>
								-->
								<div class="form-row" id="captcha_div">
									<input type="hidden" name="resultado_captcha" value="<?php echo $resultado; ?>" />
									<label><?php echo $a.' + '.$b; ?> <em class="meta"><?php echo lang('front.contacto_humano'); ?></em></label>
									<input type="text" name="captcha" value="" />
									<?php	if(form_error('captcha'))
												echo form_error('captcha');
											else 
												echo '<small class="error" style="display:none;">'.lang('front.contacto_required2').'</small>'
							 		?>
								</div>
								<div class="form-row">
									<center>
										<button type="submit" class="button"><?php echo lang('front.enviar'); ?></button>
									</center>
								</div>
							</form>
                    	</footer>
					</article><!-- #post-1701 -->
				</div><!-- #content -->
				
			</div><!-- #primary -->            
			<div id="secondary" class="g1-sidebar widget-area" role="complementary">
            	<div class="g1-inner">
                	<nav class="g1-side-nav">
                		<ul class="g1-menu">
            				<li class="page_item page-item-156 current_page_ancestor">
            					<a href="testimonios/">
            						<span><?php echo lang('front.testimonios_pagina_tit'); ?></span>
            					</a>
            				</li>
                        	<li class="page_item page-item-583 current_page_ancestor current_page_parent">
                        		<a href="testimonios/facebook">
                        			<span><?php echo lang('front.testimonios_facebook_tit'); ?></span>
                        		</a>
                        	</li>
						</ul>
          			</nav>
            	</div>
            	<div class="g1-background">
                	<div></div>
            	</div>
        	</div>

   		</div>
   		<!-- VISTA DESKTOP-->
   		
   		<!-- VISTA MOVIL-->
   		<div id="g1-content-area" class="show-for-small">
    		<div id="primary" class="g1-sidebar widget-area" role="complementary">
            	<div class="g1-inner">
                	<nav class="g1-side-nav">
                		<ul class="g1-menu">
            				<li class="page_item page-item-156 current_page_ancestor">
            					<a href="testimonios/">
            						<span><?php echo lang('front.testimonios_pagina_tit'); ?></span>
            					</a>
            				</li>
                        	<li class="page_item page-item-583 current_page_ancestor current_page_parent">
                        		<a href="testimonios/facebook">
                        			<span><?php echo lang('front.testimonios_facebook_tit'); ?></span>
                        		</a>
                        	</li>
						</ul>
          			</nav>
            	</div>
            	<div class="g1-background">
                	<div></div>
            	</div>
        	</div>
    		
    		<div id="secondary">
				<div id="content" role="main">
					<article id="post-1701" class="post-1701 page type-page status-publish g1-complete instock">      
                        
                        <!-- BEGIN .entry-content -->
                        <div class="entry-content set_comentarios">                         	
							<div id="g1-divider-top-1" class="g1-divider-top g1-meta "></div>
                  			
                  			<?php if(isset($comentarios) && !empty($comentarios)): ?>
                  				
                  				<h2><?php echo lang('front.testimonios_comentarios_visitantes'); ?></h2>
                  			
                  				<?php foreach($comentarios as $comentario): ?>
                  					
                  					<span><b><?php echo lang('front.testimonios_puntuacion'); ?>: </b><div class="star_rating" data-score="<?php echo $comentario->rating; ?>"></div> </span>
                  					
									<figure id="g1-quote-4" class="g1-quote g1-quote--solid g1-quote--small " >
										
										<div class="g1-inner">
											<p><?php echo $comentario->comentario; ?></p>
										</div>
										
										<figcaption class="g1-meta">
											
											<span class="g1-quote__image"></span>
											
											<strong><?php echo $comentario->nombre; ?></strong>
											
											<?php
												list($anio, $mes, $dia_hora) =  explode('-', $comentario->creado);
												list($dia, $hora) = explode(' ', $dia_hora);
												$creado = implode('-', array($dia, $mes, $anio)).' '.$hora;
											?>
											
											<span><b><?php echo lang('front.testimonios_fecha_publicacion'); ?>: </b> <?php echo $creado; ?></span>
											
										</figcaption>
										
									</figure>

							<div id="g1-divider-3" class="g1-divider g1-divider--none g1-divider--noicon "></div>
							<?php endforeach; ?>
							<?php  endif; ?>
						</div>
						
						<nav class="g1-pagination">
							<p>
								<?php echo @$paginacion; ?>
							</p>
    					</nav>
    				
                        <!-- END .entry-content -->
                        <footer class="entry-meta">
                        	
                        	<h2><?php echo lang('front.testimonios_comentarios_experiencia'); ?></h2>
                        	
							<form accept-charset="UTF-8" action="<?php echo base_url()."testimonios/testimonios/comentar"; ?>" method="post">
								
								<div class="form-row" id="nombre_completo_div">
									<label><?php echo lang('front.testimonios_nombre'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<input type="text" name="nombre_completo" value="<?php echo @$nombre_completo; ?>" />
									<?php
											if(form_error('nombre_completo'))
												echo form_error('nombre_completo');
											else
												echo '<small class="error" style="display:none;">El campo es obligatorio, no puede estar vacio.</small>'
								 	?>
								</div>
								<div class="form-row" id="email_div">
									<label><?php echo lang('front.testimonios_email'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<input type="text" name="email" value="<?php echo @$email; ?>" />
									<?php	if(form_error('email'))
												echo form_error('email');
											else
												echo '<small class="error" style="display:none;">El campo es obligatorio, no puede estar vacio.</small>'
								 	?>	
								</div>
								
								<div class="form-row">
									<label><?php echo lang('front.testimonios_puntuacion'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
									<div class="star"></div>	
								</div>
								
								<div class="form-row" id="mensaje_div">
										<label><?php echo lang('front.contacto_label3'); ?></label>
										<textarea  name="mensaje" rows="5" cols="5"><?php if(isset($mensaje) && !empty($mensaje)) echo $mensaje; ?></textarea>
										<?php	if(form_error('mensaje'))
													echo form_error('mensaje');
												else
													echo '<small class="error" style="display:none;">'.lang('front.testimonios_required2').'.</small>'
								 		?>
									</div>
							
								<div class="form-row" id="captcha_div">
									<label for="contact_form_captcha_1">7 + 3 ?  <em class="meta">(<?php echo lang('front.testimonios_humano'); ?>)</em></label>
									<input type="text" name="captcha" value="<?php echo @$captcha; ?>" />
									<?php	if(form_error('captcha'))
												echo form_error('captcha');
											else
												echo '<small class="error" style="display:none;">'.lang('front.testimonios_required2').'</small>'
								 	?>
								</div>
								<div class="form-row">
									<center>
										<button type="submit" class="button"><?php echo lang('front.enviar'); ?></button>
									</center>
								</div>
							</form>
                    	</footer>
					</article><!-- #post-1701 -->
				</div><!-- #content -->
				
			</div><!-- #primary -->            
			

   		</div>
   		<!-- VISTA MOVIL -->
   		
        <!-- END #g1-content-area -->
	</div>
	<div class="g1-background">
	</div>	
</div>
<!-- END #g1-content -->	