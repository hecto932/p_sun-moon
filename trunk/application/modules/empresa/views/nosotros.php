
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.nosotros_titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.nosotros_titulo'); ?></h1>
      	</div>
  	</header>
</div>

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
   		
   		<!-- Metadatos de posicionamiento -->
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
   		
		<div id="parrafos">
			<h1 class="hide-for-small"><?php echo lang('front.nosotros_subtitulo'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('front.nosotros_subtitulo'); ?></h2>
			<hr>
			<p>
				<?php echo lang('front.nosotros_p1'); ?>
			</p>
			
			<p>
				<?php echo lang('front.nosotros_p2'); ?>
			</p>
				
			<p>
				<?php echo lang('front.nosotros_p3'); ?>
			</p>
			
			<p>	
				<?php echo lang('front.nosotros_p4'); ?>
			</p>
		</div>
		
	</div>
</div>

<!-- Imagenes -->
<!-- BEGIN #g1-content -->
<div id="g1-content">
	<center>
	<div class="g1-layout-inner">           
   		<div id="g1-content-area">
            <div>
    			<div id="content" role="main">
					<!-- BEGIN: .g1-isotope-wrapper -->
					<div class="g1-isotope-wrapper">
                		
                		<!-- BEGIN: .g1-collection -->
    					<div itemscope itemtype="http://schema.org/LocalBusiness" class="g1-collection g1-collection--grid g1-collection--one-third g1-collection--gallery g1-effect-none">
        					<ul><!-- -->
        						<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>1small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.comida'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>1large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									
            									<header class="entry-header">
                									
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc1'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
    									
									</article>
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
									
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
            							
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>2small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.actividades'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>2large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									
            									<header class="entry-header">
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc2'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer> -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article>
									     
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    								
										<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>3small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.posada'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>3large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
    	        								
            									<header class="entry-header">
            										
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc3'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article>
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>4small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.habitaciones'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>4large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									<header class="entry-header">
            										
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc4'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article><!-- .post-XX -->        
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>5small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.playa'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>5large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									
            									<header class="entry-header">
                									
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc5'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article>
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>6small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.relax'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>6large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									
            									<header class="entry-header">
                									
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>

            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc6'); ?></p>
												</div>
												
            									<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>
        									<div class="g1-01"></div>
    									</div>
									</article>
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>7small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.paisaje'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>7large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									<header class="entry-header">
            										
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc7'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article>
								</li>
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>8small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.playa'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>8large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
            									
            									<header class="entry-header">
                									
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc8'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article>
								</li>
								
								
								<li class="g1-collection__item filter-303 filter-304 filter-307">
            						<article itemprop="image" id="post-261" class="post-261 g1_work type-g1_work status-publish format-gallery g1-brief instock">
    									
    									<figure class="entry-featured-media">
    										<ul class="g1-gallery-items">
    											<li>
    												<img width="320" height="180" src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>9small.jpg" class="attachment-g1_one_third wp-post-image" alt="<?php lang('front.nosotros_subtitulo').' - '.lang('image.nosotros.animales'); ?>" />
    											</li>
    										</ul>
    										<ul class="g1-gallery-data">
    											<li>
    												<a href="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_nosotros_url').'/'; ?>9large.jpg" data-g1-width="1136" data-g1-height="639"></a>
    											</li>
    										</ul>
    									</figure>
    									
    									<div class="g1-nonmedia">
    	        							<div class="g1-inner">
    	        								
            									<header class="entry-header">
            										
                									<h3><a ><?php echo lang('front.nosotros_img_tit1'); ?></a></h3>
                									
                									<!--
                									<p class="entry-meta g1-meta">
                    									<time itemprop="datePublished" datetime="2013-03-07T19:28:06" class="entry-date">March 7, 2013</time>                                            
                    									<span class="entry-comments-link">
    														<a href="http://3clicks.bringthepixel.com/work/microdata-support-work/#respond" title="Comment on Microdata Support">0 <span>Comments</span></a>    
    													</span>
                    								</p>
                    								-->
                    								
                            					</header>
                            					
            									<div class="entry-summary">
            										<p><?php echo lang('front.nosotros_img_desc9'); ?></p>
												</div>
												
												<!--
            									<footer class="entry-footer">
            										<div>
                        								<a id="g1-button-2" class="g1-button g1-button--small g1-button--solid g1-button--standard " href="#" >Comentar</a>                    
                        							</div>
                            					</footer><!-- .entry-footer -->
                            					
        									</div>	
        									<div class="g1-01"></div>
    									</div>
									</article><!-- .post-XX -->        
								</li><!-- -->
							</ul>
    					</div>
    					<!-- END: .g1-collection -->
					</div>
					<!-- END: .g1-isotope-wrapper -->
				</div><!-- #content -->
			</div><!-- #primary -->            
		</div>
            <!-- END #g1-content-area -->
	</div>
	<div class="g1-background">
	</div>	
	</center>
</div>
<!-- END #g1-content -->	
