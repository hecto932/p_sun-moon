<div class="asistente" id="asistente_${Asistente}">
	<form class="custom">
		<fieldset>
			<legend><?php echo lang('inscritos.datos_asistente')?> ${Asistente}</legend>
			<div class="six columns">
				<div class="row">
					<div class="four columns">
						<label class="inline" for="cedula_${Asistente}"><?php echo lang('inscritos.cedula')?></label>
					</div>
					<div class="eight columns">
						<input class="six cedula" type="text" name="cedula_${Asistente}" id="cedula_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="four columns">
						<label class="inline" for="rif_${Asistente}"><?php echo lang('inscritos.rif')?></label>
					</div>
					<div class="eight columns">
						<input class="six rif" type="text" name="rif_${Asistente}" id="rif_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="four columns">
						<label class="inline" for="email_${Asistente}"><?php echo lang('inscritos.email')?></label>
					</div>
					<div class="eight columns">
						<input type="text" name="email_${Asistente}" class="email" id="email_${Asistente}" required >
					</div>
				</div>
				
				<div class="row">
					<div class="twelve columns">
						<label for="desea_hospedaje_${Asistente}">
							<input type="checkbox" name="desea_hospedaje_${Asistente}" id="desea_hospedaje_${Asistente}" class="desea_hospedaje" style="display: none;">
							<span class="custom checkbox" style="margin-right: 5px;"></span>
							<?php echo lang('inscritos.desea_hospedaje')?></label>
					</div>
				</div>
				
				<div class="row hospedaje" id="div-hospedaje-${Asistente}" style="display:none;">
					<div class="four columns">
						<label for="id_hospedaje_${Asistente}" class="inline"><?php echo lang('inscritos.tipo_hospedaje')?></label>
					</div>
					<div class="eight columns">
						<select class="custom" name="id_hospedaje_${Asistente}" id="id_hospedaje_{Asistente}"></select>
					</div>
				</div>
			</div>
			<div class="six columns">
				<div class="row">
					<div class="three columns">
						<label class="inline" for="nombres_${Asistente}"><?php echo lang('inscritos.nombres')?></label>
					</div>
					<div class="nine columns">
						<input type="text" name="nombres_${Asistente}" class="nombres" id="nombres_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="three columns">
						<label class="inline" for="apellidos_${Asistente}"><?php echo lang('inscritos.apellidos')?></label>
					</div>
					<div class="nine columns">
						<input type="text" name="apellidos_${Asistente}" class="apellidos" id="apellidos_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="three columns">
						<label class="inline" for="telefono1_${Asistente}"><?php echo lang('inscritos.telefono1')?></label>
					</div>
					<div class="nine columns">
						<input type="text" name="telefono1_${Asistente}" class="telefono1" id="telefono1_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="three columns">
						<label class="inline" for="telefono2_${Asistente}"><?php echo lang('inscritos.telefono2')?></label>
					</div>
					<div class="nine columns">
						<input type="text" name="telefono2_${Asistente}" class="telefono2" id="telefono2_${Asistente}">
					</div>
				</div>
				
				<div class="row">
					<div class="three columns">
						<label class="inline" for="direccion_${Asistente}"><?php echo lang('inscritos.direccion')?></label>
					</div>
					<div class="nine columns">
						<textarea name="direccion_${Asistente}" class="direccion" id="direccion_${Asistente}"></textarea>
					</div>
				</div>
			</div>
			<div class="six columns"></div>
			<div class="six columns">
				<a href="#" class="button alert round small eliminar_asistente" style="float: right;">Eliminar Asistente</a>
			</div>
		</fieldset>
	</form>
</div>
