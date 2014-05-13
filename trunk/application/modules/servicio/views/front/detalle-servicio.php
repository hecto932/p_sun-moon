<span itemscope itemtype="http://schema.org/LocalBusiness">
	<meta itemprop="name" content="Posada Sol y Luna" />
	<meta itemprop="description" content="<?php echo lang('meta.nosotros.descripcion'); ?>" />
	
	<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<meta itemprop="streetAddress" 		content="<?php echo lang('meta.nosotros.street_address'); ?>">
		<meta itemprop="addressLocality" 	content="<?php echo lang('meta.nosotros.address_locality'); ?>">
		<meta itemprop="addressRegion" 		content="<?php echo lang('meta.nosotros.address_region'); ?>">
		<meta itemprop="addressCountry" 	content="<?php echo lang('meta.nosotros.address_country'); ?>">
	</span>
	
	<span itemscope itemtype="http://schema.org/TouristInformationCenter">
		<meta itemprop="name" 			content="<?php echo $detalle_servicio['nombre']; ?>">
		<meta itemprop="description" 	content="<?php echo $detalle_servicio['descripcion_breve']; ?>" />
	</span>
	
</span>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title"><?php echo lang('front.titulo_servicios'); ?></h1>
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
   		         
  		<div id="g1-content-area">    
        	<div>
    			<div id="primary" role="main">
            		<!-- BEGIN: .g1-collection -->
            		<h2 class="entry-title"><center><?php echo $detalle_servicio['nombre']; ?></center></h2>
					<div itemscope itemtype="http://schema.org/LocalBusiness" class="g1-collection g1-collection--grid g1-collection--max g1-collection--simple g1-effect-none">
	    				<ul>
	    					<li class="g1-collection__item">
	        					<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
	    							
	    							<figure class="entry-featured-media" style="height: 500px;">
	    								<ul class="g1-gallery-items">
	    									
	    									<?php foreach($imagenes as $imagen): ?>
	    										<?php 
													//Imagen del producto
                       								//$fuente_imagen = "assets/front/img/large/";
													$fuente_imagen = lang('img_url').'/'.lang('img_large_url').'/';
													$fichero = (isset($imagen['fichero']) && !empty($imagen['fichero']) && file_exists(FCPATH.$fuente_imagen.$imagen['fichero']) ? $fuente_imagen.$imagen['fichero'] : "" );
												
													//die_pre($fichero);
												?>
	    										<?php if(!empty($fichero)): ?>
	    											<li>
	    												<img src="<?php echo $fichero; ?>" alt="<?php echo $detalle_servicio['nombre']; ?>"/>
	    											</li>
	    										<?php else: ?>
	    											<li>
	    												<img src="assets/front/img/med/placeholder_med.jpg" alt="<?php echo $detalle_servicio['nombre']; ?>"/>
	    											</li>
	    										<?php endif; ?>
	    									<?php endforeach; ?>				
	    								</ul>
	    								<ul class="g1-gallery-data">
	    									<?php foreach($imagenes as $imagen): ?>
	    										<?php 
													//Imagen del producto
                       								$fuente_imagen = "assets/front/img/large/";
													$fichero = (isset($imagen['fichero']) && !empty($imagen['fichero']) && file_exists(FCPATH.$fuente_imagen.$imagen['fichero']) ? $fuente_imagen.$imagen['fichero'] : "");
													//die_pre($fichero);
												?>
	    										<?php if(!empty($fichero)): ?>
	    											<li>
	    												<a href="<?php echo $fichero; ?>"></a>
	    											</li>
	    										<?php else: ?>
	    											<li>
	    												<img src="assets/front/img/med/placeholder_med.jpg" alt="<?php echo $detalle_servicio['nombre']; ?>"/>
	    											</li>
	    										<?php endif; ?>
	    									<?php endforeach; ?>
	    								</ul>
	    							</figure>
	    							<div class="g1-nonmedia">
	        							<div class="g1-inner">
	            							<header class="entry-header">
	                							<h3><a ><?php echo $detalle_servicio['subtitulo']; ?></a></h3>                                
	                							<!--
	                							<p class="entry-meta g1-meta">
	                    							<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time> 
	                                               	<span class="entry-comments-link">
	    											<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
	    											</span>
	                    						</p>
	                            			</header><!-- .entry-header -->
											<div class="entry-summary">
												<p><?php echo $detalle_servicio['descripcion_ampliada']; ?></p>
											</div>
	            							
	        							</div>
	        							<div class="g1-01"></div>
	    							</div>
								</article>    
							</li>
						</ul>
					</div>
				</div>
				<div id="secondary" class="g1-sidebar widget-area " role="complementary">
  
        		</div>
			</div>           
		</div>           
	</div>
	<div class="g1-background">
	</div>	
</div>

