<div id="content" >
			<div class="dcontent_4">	
				<div class="dprefix_1 dgrid_2">
					<?php	
				if(validation_errors())
					echo "<section class='error_msg'><span>" . validation_errors() . "</span></section>";
				
				if(isset($error) && $error != '')
					echo "<section class='error_msg'><span>" . $error . "</span></section>";
					?>
					<section id="login_module" class="form_style1" >
						<h3>Pagina de Login</h3>
						
						<p class="message"> Ingrese sus datos</p>
						
						<?php echo form_open('login/validar') ?>
							<fieldset>
								<div class="field_container">
									<div class="field">
										<?php echo form_input('cedula', set_value('cedula')) ?>
										<div class="tag">Usuario o Cédula </div>
									</div>
								</div>
								<div class="field_container">
									<div class="field">
										<?php echo form_password('clave') ?>
										<div class="tag">Contraseña </div>
									</div>
								</div>
								<div class="wrapper">

									<div class="dcontent_2">
										<div class="dgrid_1">
											<a href="login/formulario_registro" title="Registrarse">Usuario por primera vez?</a>
											<br>
											<a href="login/formulario_recuperar_clave" title="Olvido su contraseña?">Olvido su contraseña?</a>
										</div>
										<div class="dgrid_1">
											<input id="bt_login" class="button" type="submit" value="Ingresar" name="commit"/>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</fieldset>
						</form>
						
					</section>
				</div>
				<div class="clear"></div>
			</div>
		</div>
