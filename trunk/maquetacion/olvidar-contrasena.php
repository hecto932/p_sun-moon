<?php include("header.php"); ?>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small">Restablecimiento de contraseña</h1>
    		<h1 class="entry-title show-for-small" style="font-size: 22px;">Restablecimiento de contraseña</h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
<div id="g1-content">
    <div class="g1-layout-inner">
		<form  method="post" id="contact-form-counter-1" class="contact-form">
			<h2>Datos personales</h2>
					
			<p>Introduzca su correo electronico y le enviaremos un link para reestablecer su contraseña.</p>

			<div id="g1-content" class="large-6 columns">
				<div>
					
					<div class="form-row comment-form-author"
						<label for="contact_form_message_1">Email <em class="meta">(requerido)</em></label>
						<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
					</div>
					
					<div class="form-row">
						<center>
							<a href="usuarios/registro" class="button">Solicitar contraseña</a>
						</center>
					</div>
				</div>	
			</div>
		</form>
	</div>
</div>
<!-- END #g1-content -->

<?php include("footer.php"); ?>