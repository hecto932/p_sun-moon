<div class="row">
	<div class="twelve columns">
		<form class="custom">
			<fieldset>
				<legend><?php echo lang('empresa_evento.agregar')?></legend>
				<div class="row">
					<div class="six columns">
						<div class="row">
							<div class="four columns">
								<label for="rif" class="inline"><?php echo lang('empresa_evento.rif')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('rif', '', 'class="six" id="rif"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="razon_social" class="inline"><?php echo lang('empresa_evento.razon_social')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('razon_social', '', 'class="eleven" id="razon_social"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="email" class="inline"><?php echo lang('empresa_evento.email')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('email', '', 'class="eleven" id="email"')?>
							</div>
						</div>
					</div>
					<div class="six columns">
						
						<div class="row">
							<div class="four columns">
								<label for="telefono1" class="inline"><?php echo lang('empresa_evento.telefono1')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('telefono1', '', 'id="telefono1"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="telefono2" class="inline"><?php echo lang('empresa_evento.telefono2')?></label>
							</div>
							<div class="eight columns">
								<?php echo form_input('telefono2', '', 'id="telefono2"')?>
							</div>
						</div>
						
						<div class="row">
							<div class="four columns">
								<label for="direccion" class="inline"><?php echo lang('empresa_evento.direccion')?></label>
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

<?php echo $empresas_agregar_js ?>