<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.olvidar.contrasena.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 22px;"><?php echo lang('front.olvidar.contrasena.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
<div id="g1-content">
    <div class="g1-layout-inner">
		<form action="<?php echo lang('front.usuarios_front_url').'/'.lang('front.restablecer_url'); ?>" method="post" id="contact-form-counter-1" class="contact-form">
			<div class="large-12 columns">
				<p><?php echo lang('front.olvidar.contrasena.p1'); ?></p>
				<div id="email_div" class="form-row comment-form-author"
					<label for="contact_form_message_1"><?php echo lang('front.olvidar.contrasena.label1'); ?> <em class="meta"><?php echo lang('front.olvidar.contrasena.requerido'); ?></em></label>
					<input type="text" name="email" value="" />
					<?php	if(form_error('email'))
								echo form_error('email');
							else
								echo '<small class="error" style="display:none;">'.lang('front.olvidar.contrasena.form_requerido').'</small>';
				 	?>
				</div>
					
				<div class="form-row">
					<center>
						<button type="submit"class="button"><?php echo lang('front.olvidar.contrasena.button1'); ?></button>
					</center>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- END #g1-content -->