<form class="custom">
	<fieldset>
		<legend><?php echo lang('inscritos.facturacion')?></legend>
		<div class="twelve columns">
			<div id="div-cargando-factura" class="alert-box" style="display:none;"><?php echo lang('cargando')?></div>
		</div>
		
		<div class="twelve columns" id="opciones_factura">
			<div class="row">
				<div class="four columns">
					<label for="modo_factura"><?php echo lang('inscritos.modo_factura')?></label>
					<?php echo form_dropdown('modo_factura', $modo_factura_opt, 1, 'id="modo_factura"') ?>
				</div>
				
				<div class="four columns">
					<label for="nombre_factura"><?php echo lang('inscritos.nombre_factura')?></label>
					<?php echo form_dropdown('nombre_factura', $nombre_factura_opt, 1, 'id="nombre_factura"') ?>
				</div>
				
				<div class="four columns" id="seleccionar_empresa">
					<label for="id_empresa"><?php echo lang('inscritos.empresa')?></label>
					<select name="id_empresa" id="id_empresa"></select>
				</div>
			</div>
		</div>
	</fieldset>
</form>

<?php echo $datos_facturacion_js ?>