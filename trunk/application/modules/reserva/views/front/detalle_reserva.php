<?php $reservacion_temp = $this->session->userdata("reservacion_temp"); ?>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title"><?php echo lang('front.detalle.reserva.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.detalle.reserva.breadcrumb1'); ?></p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.detalle.reserva.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.detalle.reserva.breadcrumb3'); ?></li>
   			</ol>
   		</nav> 
   		
   		
   		
		<div class="form-row">
			<center>
				<a class="button" href="<?php echo lang('front.inicio_url'); ?>" style="color: #ffffff;"><?php echo lang('front.mensaje-volver-inicio')?></a>
			</center>
		</div>
	</div>
</div>