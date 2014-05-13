<?php include("header.php"); ?>


<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title">Reservación</h1>
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
						<div class="form-row">
							<label for="contact_form_name_1">Nombre Completo <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_name_1" name="contact_form_name_1" value="" />
						</div>
						<div class="form-row">
							<label for="contact_form_email_1">Email  <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						<div class="form-row">
							<label for="contact_form_message_1">Telefono <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						<div class="form-row">
							<label for="contact_form_message_1">Nacionalidad <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
					</div>
					
				</div>
				<div id="g1-content">
					<div>
						<h2>Datos de estadía</h2>
						<div class="form-row">
							<label for="contact_form_name_1">Aereolinea <em class="meta"></em></label>
							<input type="text" id="contact_form_name_1" name="contact_form_name_1" value="" />
						</div>
						<div class="form-row">
							<label for="contact_form_email_1">Llegada  <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						
						<div class="form-row">
							<label for="contact_form_email_1">Hora de llegada  <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						
						<div class="form-row">
							<label for="contact_form_email_1">Salida  <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						
						<div class="form-row">
							<label for="contact_form_email_1">Hora de Salida  <em class="meta">(requerido)</em></label>
							<input type="text" id="contact_form_email_1" name="contact_form_email_1" value="" />
						</div>
						
						<div class="form-row">
							<label for="contact_form_message_1">Observaciones</label>
							<textarea id="contact_form_message_1" name="contact_form_message_1" rows="5" cols="5"></textarea>
						</div>
						<div class="form-row">
							<center>
							<a href="maquetacion/reservar.php" class="button" >Enviar</a>
							</center>
						</div>
					</div>
				</div>					
			</form>
		</div>
 	</div>
	<!-- END #g1-content -->
	
	<div class="row">
		<div class="large-12 columns">
			<p>
        		<b>Nota: </b>Los datos recogidos en este formularios seran enviados por correo electronico al personal de la Posala Sol y Luna, estos se encargaran de contactactarse con usted
        		para organizar su estadia.
        	</p>
		</div>
	</div>
	
<?php include("footer.php"); ?>