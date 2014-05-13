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
			<div id="g1-content">
				<div>
					<h2>Datos personales</h2>
					
					<div class="form-row comment-form-author"
						<label for="contact_form_message_1">Email <em class="meta">(requerido)</em></label>
						<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
					</div>
					
					<!-- PASSWORD -->
					<div id="password_div" class="form-row">
						<label for="contact_form_message_1">Contraseña <em class="meta">(obligatorio)</em></label>
						<input type="password" name="password" value="" />
					</div>
					
					<!-- REPASSWORD -->
					<div id="repassword_div" class="form-row">
						<label for="contact_form_message_1">Repita la contraseña <em class="meta">(obligatorio)</em></label>
						<input type="password" name="repassword" value="" />
					</div>
					
					<div class="form-row">
						<center>
							<a href="usuarios/registro" class="button">Aceptar</a>
						</center>
					</div>
				</div>	
			</div>
		</form>
	</div>
</div>
<!-- END #g1-content -->

<?php include("footer.php"); ?>