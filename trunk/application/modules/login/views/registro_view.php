<div id="content" >
	<div class="dcontent_4">	
		<div class="dprefix_1 dgrid_2">
			<?php	
				if(validation_errors())
					echo "<section class='error_msg'><span>" . validation_errors() . "</span></section>";
				
				if(isset($error) && $error != '')
					echo "<section class='error_msg'><span>" . $error . "</span></section>";
			?>
			<section id="new_user_module" class="form_style1">
				<h3>Nuevo Usuario</h3>

				<p class="message">Complete los siguientes datos obligatorios</p>
				<?php echo form_open('login/registro'); ?>
					<fieldset>
						<div class="field_container">
							<div class="field">
								<?php
									$options = array ('V' => 'V','E' => 'E');
									echo form_input('cedula',set_value('cedula'));
									echo form_dropdown('nacionalidad', $options, 'V');
								?>
								<div class="tag">Cédula </div>
							</div>							
						</div>

						<div class="field_container">
							<div class="field">
								<?php echo form_input('usuario',set_value('usuario')); ?>
								<div class="tag">Nombre de Usuario </div>																			
							</div>								
						</div>
						<div class="field_container">
							<div class="field">
								<?php echo form_password('clave') ?>
								<div class="tag">Contraseña </div>
							</div>								
						</div>
						<div class="field_container">
							<div class="field">
								<?php echo form_password('clave2'); ?>
								<div class="tag">Confirme la Contraseña </div>
							</div>
						</div>
						<div class="field_container">
							<div class="field">
								<?php echo form_input('correo',set_value('correo')); ?>
								<div class="tag">Correo Electrónico </div>
								</span>
							</div>
						</div>
						<div class="field_container">
							<div class="field">
								<?php
									$this->load->model('login_model');
									$result = $this->login_model->obtener_preguntas();
									$options = '';
									$options[-1] = "Seleccione una pregunta";
									
									foreach($result as $pregunta) {
										$options[$pregunta->pregunta_secreta_cod] = $pregunta->descripcion;
									}
									
									echo form_dropdown('pregunta', $options);
								?>
								<div class="tag">Pregunta Secreta </div>
							</div>							
						</div>
						<div class="field_container">
							<div class="field">
								<?php echo form_password('respuesta'); ?>
								<div class="tag">Respuesta </div>
							</div>
						</div>
						<div class="field_container">
							<div class="field">
								<?php echo form_input('codigo'); ?>
								<div class="tag">Código de Verificación </div>
							</div>
						</div>
						<div class="wrapper">
							<div class="dcontent_2">
								<div class="dgrid_1">
									<input id="bt_login" class="button" type="submit" value="Ingresar" name="commit"/>
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</fieldset>				
			</section>
		</div>
		<div class="clear"></div>
	</div>

</div>