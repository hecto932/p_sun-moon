<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title"><?php echo $titulo; ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<center>
			<p><?php echo $mensaje; ?></p>
			<br />
			<?php if($estado == "enviado"): ?>
				<img src="<?php echo lang('img_url').'/'.lang('img_med_url').'/'; ?>SI-02.png"  alt="mensaje-exitoso"  data-fullwidthcentering="on">
			<?php else: ?>
				<img src="<?php echo lang('img_url').'/'.lang('img_med_url').'/'; ?>NO-02.png"  alt="mensaje-exitoso"  data-fullwidthcentering="on">
			<?php endif; ?>
			<br />
			<a class="button" href="<?php echo lang('front.inicio_url'); ?>" style="color: #ffffff;"><?php echo lang('front.mensaje-volver-inicio')?></a>
		</center>
	</div>
</div>
