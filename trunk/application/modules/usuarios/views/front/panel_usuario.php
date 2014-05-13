
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.panel.usuario.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 22px;"><?php echo lang('front.panel.usuario.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.panel.usuario.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.panel.usuario.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.panel.usuario.breadcrumb3'); ?></li>
   			</ol>
   		</nav> 
   		<div id="g1-content-area">
   			<?php if(isset($mensaje) && !empty($mensaje)):?>
	   			<div class="alert-box">
					<?php echo $mensaje; ?>
				</div>
			<?php endif; ?>
   			<div id="primary">
   				
   				<ul class="g1-grid">
				    <li class="g1-column g1-one-third  g1-valign-top g1-start-animation" data-g1-delay="on" style="min-width: 200px;">
				    	<center>
					    	<div class="listado_eventos" style="min-height: 340px; font-size: 13px;">
					    		<a href="<?php echo lang('front.usuarios_url').'/'.lang('front.mis.datos_url'); ?>">
					    			<h3><?php echo lang('front.panel.usuario.subtitulo1'); ?></h3>
					    			<img src="assets/front/img/med/158-01.png"/>
					    			<p><?php echo lang('front.panel.usuario.p1'); ?></p>
					    		</a>	    		
					    	</div>
					    </center>
				    </li>

				    <li class="g1-column g1-one-third g1-valign-top g1-start-animation" data-g1-delay="on" style="min-width: 200px;">
				    	<center>
					    	<div class="listado_eventos" style="min-height: 340px; font-size: 13px;">
					    		<a href="<?php echo lang('front.usuarios_url').'/'.lang('front.reservas_usuario_url'); ?>">
					    			<h3><?php echo lang('front.panel.usuario.subtitulo2'); ?></h3>
					    			<img src="assets/front/img/med/1589-01.png" style="height: 153px;"/>
					    			<p><?php echo lang('front.panel.usuario.p2'); ?></p>
					    		</a>	    		
					    	</div>
						</center>
				    </li>

				    <li class="g1-column g1-one-third  g1-valign-top g1-start-animation" data-g1-delay="on">
				    	
				    </li>
				</ul>
   			</div>
   			<div id="secondary">
   		
			</div>
		</div>
	</div>
</div>