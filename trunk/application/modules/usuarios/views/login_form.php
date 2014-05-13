<div class="row">
	 <div id="twelve columns">
			<h2><?php echo lang('usuario_acceso'); ?></h2>
			<!-- Formulario Crear Obra -->
			<?php echo form_open('usuarios/login',array('id'=>'gen_form')) ?>
				<fieldset>
					<legend>Conexión</legend>
						<div class="row" style="margin-top: 17px; margin-left: 28%">
							<div class = "one column">
								<label class="left inline <?php echo (isset($error)) ? 'error' : ''; ?>" for="email">
									<span> <?php echo lang('usuario_login'); ?> </span>
								</label>
							</div>
							<div class="one column"></div>
							<div class="ten columns">
								<input autofocus class="six <?php echo ((form_error('email') != '')) ? 'error' : ''; ?>" id="email" name="email" type="text" class="login_input" placeholder="<?php echo (isset($error)) ? $error : lang('pl_email'); ?>"/>
							</div>

						</div>

						<div class="row" style=" margin-left: 28%">
							<div class="one column">
								<label class="left inline" for="password"><span> <?php echo lang('password_login'); ?> </span></label>
							</div>
							<div class="one column"></div>
							<div class="ten columns">
								<input class="six" id="password" name="password" type="password" class="login_input" placeholder="<?php echo lang('pl_password'); ?>"/>
							</div>

						</div>




					<div class = "row">
						<div class = "six columns offset-by-five area_botns">
							<button class="wtc radius button" type="submit"> <?php echo lang('entrar_login'); ?> </button>	
						</div>
					</div>
	
					<center><p class="mensajeLogin" style="color: #A4A4A4;margin-top: 2%"> <?php echo lang('info_login'); ?> </p></center>
				</fieldset>
			</form>
			<!-- Formulario Formulario Crear Obra cierre -->
		</div>
</div>