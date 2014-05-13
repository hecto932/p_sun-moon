<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.restablecer.contrasena_titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 22px;"><?php echo lang('front.restablecer.contrasena_titulo'); ?></h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
<div id="g1-content">
    <div class="g1-layout-inner">
		<form action="<?php echo lang('front.usuarios_front_url').'/'.lang('front.restablecer-contrasena_url'); ?>" method="post" id="contact-form-counter-1" class="contact-form">
			<div id="g1-content">
				<div>
					<h2><?php echo lang('front.restablecer.contrasena.subtitulo'); ?></h2>
					
					<div class="form-row comment-form-author"
						<label for="contact_form_message_1"><?php echo lang('front.restablecer.contrasena.email'); ?> <em class="meta"><?php echo lang('front.restablecer.obligatorio'); ?></em></label>
						<input type="text" name="email" value="" />
						<?php	if(form_error('email'))
								echo form_error('email');
							else
								echo '<small class="error" style="display:none;">'.lang('front.olvidar.contrasena.form_requerido').'</small>';
				 	?>
					</div>
					
					<!-- PASSWORD -->
					<div id="password_div" class="form-row">
						<label for="contact_form_message_1"><?php echo lang('front.olvidar.contrasena.password'); ?> <em class="meta"><?php echo lang('front.olvidar.contrasena.obligatorio'); ?> <?php echo lang('front.restablecer.obligatorio'); ?></em></label>
						<input type="password" name="password" value="" />
						<?php	if(form_error('password'))
								echo form_error('password');
							else
								echo '<small class="error" style="display:none;">'.lang('front.olvidar.contrasena.form_requerido').'</small>';
				 	?>
					</div>
					
					<!-- REPASSWORD -->
					<div id="repassword_div" class="form-row">
						<label for="contact_form_message_1"><?php echo lang('front.olvidar.contrasena.repassword'); ?> <em class="meta"><?php echo lang('front.olvidar.contrasena.obligatorio'); ?> <?php echo lang('front.restablecer.obligatorio'); ?></em></label>
						<input type="password" name="repassword" value="" />
						<?php	if(form_error('repassword'))
								echo form_error('repassword');
							else
								echo '<small class="error" style="display:none;">'.lang('front.olvidar.contrasena.form_requerido').'</small>';
				 	?>
					</div>
					
					<div class="form-row">
						<center>
							<br	/>
							<button type="submit"class="button"><?php echo lang('front.restablecer.contrasena.btn1'); ?></button>
						</center>
					</div>
				</div>	
			</div>
		</form>
	</div>
</div>

<!-- END #g1-content -->