<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title"><?php echo lang('front.registro_titulo'); ?></h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
<div id="g1-content">
    <div class="g1-layout-inner">
    	
		<form  method="post" action="usuarios/usuarios_front/registrar_usuario" id="formulario_registro" class="contact-form">
			<?php if(isset($login_fb_google)): ?>
		    	<div id="mensaje_disponibilidad" class="g1-message g1-message--info ">
					<div id="mensaje" class="g1-inner">
						Complete los siguientes campos para poder culminar su registro y asi podra iniciar sesion automaticamente.
					</div>
				</div>
				<input type="hidden" name="login_fb_google" value="<?php echo $login_fb_google; ?>" />
			<?php else: ?>
				<input type="hidden" name="login_fb_google" value="0" />
			<?php endif;?>
			<div id="g1-content">
				<div>
					<h2><?php echo lang('front.registro_sub_titulo'); ?></h2>
					
					<!-- NOMBRE-->
					<div id="nombre_div" class="form-row">
						<label for="nombre"><?php echo lang('front.registro_label_1'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<input id="nombre" type="text" class="u-4" type="text" size="30" name="nombre" value="<?php echo @$nombre; ?>" />
						<?php	if(form_error('nombre'))
									echo form_error('nombre');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- EMAIL -->
					<div id="email_div" class="form-row">
						<label for="email"><?php echo lang('front.registro_label_5'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<input id="email" type="text" name="email" value="<?php echo @$email; ?>" />
						<?php	if(form_error('email'))
									echo form_error('email');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- PASSWORD -->
					<div id="password_div" class="form-row">
						<label for="password"><?php echo lang('front.registro_label_7'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<input id="password" type="password" name="password" value="" />
						<?php	if(form_error('password'))
									echo form_error('password');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- REPASSWORD -->
					<div id="repassword_div" class="form-row">
						<label for="repassword"><?php echo lang('front.registro_label_8'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<input id="repassword" type="password" name="repassword" value="" />
						<?php	if(form_error('repassword'))
									echo form_error('repassword');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- TELEFONO -->
					<div id="telefono_div" class="form-row">
						<label for="telefono"><?php echo lang('front.registro_label_2'); ?> <span style="font-size: 9px;">(<?php echo lang('front.solo_numeros'); ?>)</span><em class="meta"><?php echo lang('front.registro_requerido'); ?></em> </label>
						<input type="text" class="u-4" type="text" size="30" name="telefono" value="<?php echo @$telefono; ?>" />
						<?php if(form_error('telefono'))
									echo form_error('telefono');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- ID_PAIS -->
					<div id="id_pais_div" class="form-row">
						<label for="contact_form_message_1"><?php echo lang('front.registro_label_3'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<?php echo form_dropdown('id_pais', $opt_paises, set_value('id_pais')); ?>
						<?php	if(form_error('id_pais'))
									echo form_error('id_pais');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- NACIONALIDAD -->
					<div id="nacionalidad_div" class="form-row">
						<label for="contact_form_message_1"><?php echo lang('front.registro_label_4'); ?> <em class="meta"><?php echo lang('front.registro_requerido'); ?></em></label>
						<input type="text" name="nacionalidad" value="<?php echo @$nacionalidad; ?>" />
						<?php	if(form_error('nacionalidad'))
									echo form_error('nacionalidad');
								else
									echo '<small class="error" style="display:none;">'.lang('front.registro_form_requerido').'</small>';
				 		?>
					</div>
					
					<!-- DIRECCION -->
					<div id="direccion_div" class="form-row">
						<label for="contact_form_message_1"><?php echo lang('front.registro_label_6'); ?> <em class="meta"><?php //echo lang('front.registro_requerido'); ?></em></label>
						<textarea name="direccion" rows="5" cols="5"><?php echo @$direccion; ?></textarea>
					<!--	<?php	if(form_error('direccion'))
									echo form_error('direccion');
								else
									echo '<small class="error" style="display:none;">'.lang('front.contacto_required').'</small>';
				 		?>
				 	-->
					</div>
					
					<!-- BOTON SUBMIT -->
					<div class="form-row">
						<center>
							<br	/>
							<button type="submit"class="button"><?php echo lang('front.registro_button_submit'); ?></button>
						</center>
					</div>
				</div>	
			</div>
		</form>
	</div>
</div>
<!-- END #g1-content -->
