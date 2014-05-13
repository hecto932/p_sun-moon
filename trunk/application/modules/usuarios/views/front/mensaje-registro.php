<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo $titulo; ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 22px;"><?php echo $titulo; ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<center>
			<p><?php echo $mensaje; ?></p>
			<br />
			<img src="<?php echo lang('img_url').'/'.lang('img_med_url').'/'; ?>registro.png"  alt="mensaje-exitoso"  data-fullwidthcentering="on" /> 
			<br />
			<a class="button" href="<?php echo lang('front.inicio_url'); ?>" style="color: #ffffff;"><?php echo lang('front.mensaje-volver-inicio')?></a>
		</center>
	</div>
</div>
