<span itemscope itemtype="http://schema.org/LocalBusiness">
	<meta itemprop="name" content="Posada Sol y Luna" />
	<meta itemprop="description" content="<?php echo lang('meta.nosotros.descripcion'); ?>" />
	
	<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<meta itemprop="streetAddress" 		content="<?php echo lang('meta.nosotros.street_address'); ?>">
		<meta itemprop="addressLocality" 	content="<?php echo lang('meta.nosotros.address_locality'); ?>">
		<meta itemprop="addressRegion" 		content="<?php echo lang('meta.nosotros.address_region'); ?>">
		<meta itemprop="addressCountry" 	content="<?php echo lang('meta.nosotros.address_country'); ?>">
	</span>
</span>


<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.titulo_servicios'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.titulo_servicios'); ?></h1>
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
  		 
  		<!-- VISTA DESKTOP -->        
  		<div id="g1-content-area">
    		<div>
				<div id="content" role="main">
					<center>
					<article id="post-583" class="post-583 page type-page status-publish g1-complete instock">
               			<!-- BEGIN: .g1-collection -->
    					<div itemscope itemtype="http://schema.org/LocalBusiness" class="g1-collection g1-collection--grid g1-collection--one-third g1-collection--filterable g1-effect-none">
	        				<ul><!-- -->
	        					<?php foreach($servicios as $servicio): ?>
	        					<li class="g1-collection__item filter-303 filter-306 filter-309 ">
	        						<div style="height: 486px;">
	            					<article itemprop="image" id="post-262" class="post-262 g1_work type-g1_work status-publish format-standard g1-brief instock">
	    								
	    								<figure class="entry-featured-media">
											<a href="<?php echo lang('front.servicio_url').'/'.lang('front.detalle_url').'/'.$servicio->id_servicio; ?>" id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center ">
												<span class="g1-decorator">
													
													<?php 
														//Imagen del producto
														$fuente_imagen = lang('img_url').'/'.lang('img_med_url').'/';
														$placeholder = lang('img_back_url').'/'.lang('img_template_url').'/'.lang('img_placeholder_url');
														//$placeholder = "assets/back/img/template/placeholder_med.jpg";
                               							$fichero = (isset($servicio->fichero) && !empty($servicio->fichero) && file_exists(FCPATH.$fuente_imagen.$servicio->fichero) ? $fuente_imagen.$servicio->fichero : $placeholder);
													
													 ?>
													<img width="320" height="180" src="<?php echo $fichero; ?>" class="attachment-g1_one_third wp-post-image" alt="<?php echo $servicio->nombre; ?>" />
												</span>
											</a>
										</figure>
										
	    								<div class="g1-nonmedia">
	        								<div class="g1-inner">
	            								
	            								<header class="entry-header">
	                								<b><h3><a href="<?php echo lang('front.servicio_url').'/'.lang('front.detalle_url').'/'.$servicio->id_servicio; ?>" title="Multiple Templates" ><?php echo $servicio->nombre; ?></a></h3></b>
	                								<p class="entry-meta g1-meta">                                          
		                    							<p><b><?php echo lang('front.servicios_tipo'); ?>:</b> <?php echo $servicio->nombre_tipo;?></p>
	                    							</p>
	                            				</header>
	                            				
	            								<div class="entry-summary">
	            									<p><?php echo $servicio->descripcion_breve; ?></p>
												</div>
												
	            								<footer class="entry-footer">
	               									<div>
	                        							<a id="g1-button-23" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="<?php echo base_url().lang('front.servicio_url').'/'.lang('front.detalle_url').'/'.$servicio->id_servicio; ?>" ><?php echo lang('front.servicios_ver'); ?></a>                    
	                        						</div>
	                            				</footer><!-- .entry-footer -->
	        								</div>
	        								<div class="g1-01"></div>
	    								</div>
									</article><!-- .post-XX --> 
									</div>       
								</li><!-- -->
								<?php endforeach; ?>
							</ul>
    					</div>
    				<!-- END: .g1-collection -->
              		</article><!-- #post-583 -->
              		</center>
            	</div><!-- #content -->
  			</div><!-- #primary -->
  			
        </div>
         <!-- VISTA DESKTOP --> 
         
       
         
      	<!-- END #g1-content-area -->
	</div>
	<div class="g1-background">
	</div>	
</div>
<!-- END #g1-content -->