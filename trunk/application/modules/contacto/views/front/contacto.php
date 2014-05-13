<!-- BEGIN #g1-precontent -->
<!--
<div id="g1-precontent" class="hide-for-small">
	<div id="g1-gmap-counter-1" class="g1-gmap" data-g1-gmap-config="{ map_type: 'roadmap',invert_lightness: '0',latitude: '11.946469',longitude: '-66.67631',zoom: '20',marker: 'standard',marker_icon: 'assets/front/images/gmap_marker_blue.png',type: 'rich',color: '#808080',color_hue: '#808080',color_saturation: '-100',color_lightness: '0.3921568627451' }" style="width: 100%; height: 680px;">
			<div class="g1-content" style="display: none;">
				<?php echo lang('footer.map_direccion'); ?>
			</div>
		</div>    
	<div class="g1-background">
	</div>
</div>
-->

<div id="g1-precontent">
	<div class="g1-background">
	</div>
</div>

<!-- END #g1-precontent -->
<div class="g1-background"></div>

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
     		         
     		<div id="g1-content-area">
    			<div id="primary">
					<div id="content" role="main">
						<article id="post-614" class="post-614 page type-page status-publish g1-complete instock">
                    		
                    		<header class="entry-header">
                       			<div class="g1-hgroup">
                            		<h1 class="entry-title hide-for-small"><?php echo lang('front.contacto_titulo'); ?></h1>
                            		<h3 class="entry-title show-for-small" style="color:#FFFFFF;"><?php echo lang('front.contacto_titulo'); ?></h3>
                          		</div>
                        	</header>
                        
                        	<!-- BEGIN .entry-content -->
                        	<div class="entry-content">
                  				
                  				<h2><?php echo lang('front.contacto_subtitulo1'); ?></h2>
								
								<hr />
								
								<div id="g1-lead-1" class="g1-lead " >
									<p>
										<?php echo lang('front.contacto_p1');?>
									</p>
								</div>
								
								<h2><?php echo lang('front.contacto_subtitulo3');?></h2>
								<?php echo lang('enviar_mensaje_url'); ?>
								<form accept-charset="UTF-8" action="<?php echo lang('action_enviar_mensaje'); ?>" method="post">
									
									<div class="form-row" id="nombre_completo_div">
										<label><?php echo lang('front.contacto_label1'); ?><em class="meta"><?php echo lang('front.contacto_requerido'); ?></em></label>
										<input type="text" name="nombre_completo" value="<?php if(isset($nombre_completo) && !empty($nombre_completo)) echo $nombre_completo; ?>"/>
										<?php	if(form_error('nombre_completo'))
													echo form_error('nombre_completo');
												else
													echo '<small class="error" style="display:none;">'.lang('front.contacto_required').'</small>'
								 		?>
									</div>
									
									<div class="form-row" id="email_div">
										<label><?php echo lang('front.contacto_label2'); ?> <em class="meta"><?php echo lang('front.contacto_requerido'); ?></em></label>
										<input type="text"  name="email" value="<?php if(isset($email) && !empty($email)) echo $email; ?>" />
										<?php	if(form_error('email'))
													echo form_error('email');
												else
													echo '<small class="error" style="display:none;">'.lang('front.contacto_required').'</small>'
								 		?>
									</div>
									<div class="form-row" id="telefono_div">
										<label for="contact_form_message_1">Telefono <em class="meta"><span style="font-size: 9px;">(<?php echo lang('front.solo_numeros'); ?>)</span>&nbsp;(requerido)</em></label>
										<input class="phone" type="text" name="telefono" value="<?php if(isset($telefono) && !empty($telefono)) echo $telefono; ?>"  />
										<?php	if(form_error('telefono'))
													echo form_error('telefono');
												else
													echo '<small class="error" style="display:none;">'.lang('front.contacto_required').'</small>'
							 			?>
									</div>
									<div class="form-row" id="mensaje_div">
										<label"><?php echo lang('front.contacto_label3'); ?></label>
										<textarea  name="mensaje" rows="5" cols="5"><?php if(isset($mensaje) && !empty($mensaje)) echo $mensaje; ?></textarea>
										<?php	if(form_error('mensaje'))
													echo form_error('mensaje');
												else
													echo '<small class="error" style="display:none;">'.lang('front.contacto_required').'</small>'
								 		?>
									</div>
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
											<button type="submit" class="button"><?php echo lang('front.contacto_button1'); ?></button>
										</center>
									</div>
								</form>
                       		</div>
                        <!-- END .entry-content -->
                        <footer class="entry-meta">
                       	</footer>
				</article><!-- #post-614 -->
			</div><!-- #content -->
		</div><!-- #primary -->    <!-- BEGIN: #secondary -->
		<div id="secondary" class="g1-sidebar widget-area" role="complementary">
			<div class="g1-inner">
				<section id="text-16" class="widget widget_text g1-widget--cssclass">
					<center>
					<header><h3 class="widgettitle"><?php echo lang('front.contacto_subtitulo4'); ?></h3></header>			
					<div class="textwidget">
						<p>
							<?php echo lang('front.contacto_direccion'); ?>
							<br /><a href="mailto:<?php echo lang('front.contacto_emailto'); ?>"><?php echo lang('front.contacto_email'); ?></a>
						</p>
						<p>
							<i id="icon-2" class="icon-phone g1-icon g1-icon--solid g1-icon--small g1-icon--inherit "></i> 
							<?php echo lang('front.contacto_telefonos'); ?>
						</p>
						<p>
							<i id="icon-3" class="icon-map-marker g1-icon g1-icon--solid g1-icon--small g1-icon--inherit "></i>
							<br /> 
							<?php echo lang('front.contacto_nombre'); ?>
						</p>
					</div>
					</center>
				</section>
				
				<section id="text-17" class="widget widget_text g1-widget--cssclass">
					<header><h3 class="widgettitle"><?php echo lang('front.contacto_subtitulo2'); ?></h3></header>
					<div class="textwidget">
						<div id="g1-social-icons-1" class="g1-social-icons g1-social-icons--list-vertical g1-social-icons--24 g1-social-icons--icon">
							<ul>
								<li>
									<a class="g1-new-window " href="<?php echo lang('facebook_url'); ?>">
										<span class="g1-social-icon g1-social-icon--facebook">
											<img src="<?php echo lang('images_url').'/'.lang('images_facebook_url').'/'; ?>facebook-icon.png" alt="facebook" width="24" height="24" />
										</span>
										<strong><?php echo lang('front.contacto_facebook'); ?></strong>
									</a>
									<i class="g1-meta"><?php echo lang('front.contacto_facebook_small'); ?></i>
								</li>
								<li>
									<a class="g1-new-window " href="<?php echo lang('twitter_url'); ?>">
										<span class="g1-social-icon g1-social-icon--twitter">
											<img src="<?php echo lang('images_url').'/'.lang('images_twitter_url').'/'; ?>twitter-icon.png" alt="twitter" width="24" height="24" />
										</span>
										<strong><?php echo lang('front.contacto_twitter'); ?></strong>
									</a>
									<i class="g1-meta"><?php echo lang('front.contacto_twitter_small'); ?></i>
								</li>
							</ul>
						</div>
					</div>
				</section>	
			</div>
			<div class="g1-background">
        		<div></div>
			</div>	
		</div>
		<!-- END: #secondary -->
	</div>
  	<!-- END #g1-content-area -->
	</div>
	<div class="g1-background">
	</div>	
</div>
	<!-- END #g1-content -->	
