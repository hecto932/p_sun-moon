<div class="row">
	<div class="twelve columns">
		<form class="custom">
			<fieldset>
				<legend><?php echo lang('usuarios_eventos.agregar')?></legend>
				<div class="row">
					<div class="six columns">
						<div class="row">
							<div class="four columns">
								<label for="cedula" class="inline"><?php echo lang('usuarios_eventos.cedula')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('cedula', '', 'class="six" id="cedula"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="rif" class="inline"><?php echo lang('usuarios_eventos.rif')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('rif', '', 'class="six" id="rif"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="email" class="inline"><?php echo lang('usuarios_eventos.email')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('email', '', 'class="eleven" id="email"')?>
							</div>
						</div>
					</div>
					<div class="six columns">
					
						<div class="row">
							<div class="four columns">
								<label for="nombres" class="inline"><?php echo lang('usuarios_eventos.nombres')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('nombres', '', 'id="nombres"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="apellidos" class="inline"><?php echo lang('usuarios_eventos.apellidos')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('apellidos', '', 'id="apellidos"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="telefono1" class="inline"><?php echo lang('usuarios_eventos.telefono1')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('telefono1', '', 'id="telefono1"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="telefono2" class="inline"><?php echo lang('usuarios_eventos.telefono2')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('telefono2', '', 'id="telefono2"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="direccion" class="inline"><?php echo lang('usuarios_eventos.direccion')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_textarea('direccion', '', 'id="direccion" style="height:80px;"')?>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
		
		<div class="twelve columns">
			<a href="#" class="button radius wtc" id="aceptar"><?php echo lang('aceptar')?></a>
			<a href="#" class="button radius wtc" id="limpiar"><?php echo lang('limpiar')?></a>
		</div>
	</div>
</div>

<?php echo $usuarios_agregar_js ?>