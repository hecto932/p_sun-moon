<div class="row datos_hospedaje">
	<div class="six columns">
		<form class="custom">
			<fieldset>
				<legend><?php echo lang('hospedaje.nuevo')?></legend>
			
				<div class="row field">
					<div class="four columns">
						<label class="inline" for="id_tipo_hospedaje"><?php echo lang('hospedaje.tipo_hospedaje')?></label>
					</div>
					<div class="eight columns">
						<?php echo form_dropdown('id_tipo_hospedaje', $tipo_hospedaje_opt, 1, 'id="id_tipo_hospedaje"') ?>
					</div>
				</div>
				
				<div class="row field">
					<div class="four columns">
						<label class="inline" for="cantidad"><?php echo lang('hospedaje.cantidad')?></label>
					</div>
					<div class="eight columns">
						<input type="text" name="cantidad" id="cantidad" class="three" value="0">
					</div>
				</div>
				
				<div class="row field">
					<div class="four columns">
						<label class="inline" for="precio"><?php echo lang('hospedaje.precio')?></label>
					</div>
					<div class="six columns">
						<div class="row collapse">
							<div class="eight columns">
								<input type="text" name="precio" id="precio" value="0">
							</div>
							<div class="four columns">
								<span class="postfix">Bs.F</span>
							</div>
						</div>
					</div>
					<div class="four columns"></div>
				</div>
				
				<div class="row" style="margin-top:20px;">
					<div class="twelve columns">
						<div class="alert-box" style="display:none;" id="div-cargando"><?php echo lang('cargando')?></div>
						<a href="#" id="boton_aceptar" class="button radius wtc"><?php echo lang('aceptar')?></a>
						<a href="#" id="boton_limpiar" class="button radius wtc"><?php echo lang('limpiar')?></a>
					</div>
				</div>
			
			</fieldset>
		</form>
	</div>
</div>

<?php echo $hospedaje_js ?>