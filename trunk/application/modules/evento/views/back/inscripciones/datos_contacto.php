<fieldset>
	<legend><?php echo lang('inscritos.datos_contacto')?></legend>
	<div class="six columns">
		<form class="custom">
			<div class="row">
				<div class="four columns">
					<label class="inline" for="contacto_cedula"><?php echo lang('inscritos.cedula')?></label>
				</div>
				<div class="eight columns">
					<input class="six" type="text" name="contacto_cedula" id="contacto_cedula">
				</div>
			</div>
				
			<div class="row">
				<div class="four columns">
					<label class="inline" for="contacto_rif"><?php echo lang('inscritos.rif')?></label>
				</div>
				<div class="eight columns">
					<input class="six" type="text" name="contacto_rif" id="contacto_rif">
				</div>
			</div>
			
			<div class="row">
				<div class="four columns">
					<label class="inline" for="contacto_email"><?php echo lang('inscritos.email')?></label>
				</div>
				<div class="eight columns">
					<input type="text" name="contacto_email" id="contacto_email" required >
				</div>
			</div>
			
			<div class="row">
				<div class="twelve columns">
					<label for="contacto_asiste">
						<?php echo form_checkbox(array("name" => 'contacto_asiste', "value" => '1', "id" => 'contacto_asiste', 'checked' => FALSE, 'style' => 'display: none;')) ?>
						<span class="custom checkbox" style="margin-right: 5px;"></span>
						Esta persona asistirá al evento</label>
				</div>
			</div>
			
			<div class="row" id="div-desea-hospedaje" style="display:none;">
				<div class="twelve columns">
					<label for="contacto_desea_hospedaje">
						<?php echo form_checkbox(array("name" => 'contacto_desea_hospedaje', "value" => '1', "id" => 'contacto_desea_hospedaje', 'checked' => FALSE, 'style' => 'display: none;')) ?>
						<span class="custom checkbox" style="margin-right: 5px;"></span>
						Desea hospedaje</label>
				</div>
			</div>
			
			<div class="row" id="div-contacto-hospedaje" style="display: none; margin-top: 10px;">
				<div class="four columns">
					<label for="contacto_id_hospedaje" class="inline"><?php echo lang('inscritos.tipo_hospedaje')?></label>
				</div>
				<div class="eight columns">
					<select name="contacto_id_hospedaje" id="contacto_id_hospedaje"></select>
				</div>
			</div>
		</form>
	</div>
		
	<div class="six columns">
		<div class="row">
			<div class="three columns">
				<label class="inline" for="contacto_nombres"><?php echo lang('inscritos.nombres')?></label>
			</div>
			<div class="nine columns">
				<input type="text" name="contacto_nombres" id="contacto_nombres">
			</div>
		</div>
			
		<div class="row">
			<div class="three columns">
				<label class="inline" for="contacto_apellidos"><?php echo lang('inscritos.apellidos')?></label>
			</div>
			<div class="nine columns">
				<input type="text" name="contacto_apellidos" id="contacto_apellidos">
			</div>
		</div>
		
		<div class="row">
			<div class="three columns">
				<label class="inline" for="contacto_telefono1"><?php echo lang('inscritos.telefono1')?></label>
			</div>
			<div class="nine columns">
				<input type="text" name="contacto_telefono1" id="contacto_telefono1">
			</div>
		</div>
		
		<div class="row">
			<div class="three columns">
				<label class="inline" for="contacto_telefono2"><?php echo lang('inscritos.telefono2')?></label>
			</div>
			<div class="nine columns">
				<input type="text" name="contacto_telefono2" id="contacto_telefono2">
			</div>
		</div>
		
		<div class="row">
			<div class="three columns">
				<label class="inline" for="contacto_direccion"><?php echo lang('inscritos.direccion')?></label>
			</div>
			<div class="nine columns">
				<textarea name="contacto_direccion" id="contacto_direccion"></textarea>
			</div>
		</div>
	</div>
</fieldset>

<?php echo $datos_contacto_js ?>