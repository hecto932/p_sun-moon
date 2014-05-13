<div class="datos_contacto">
	<?php echo $datos_contacto ?>
</div>

<div class="datos_facturacion">
	<?php echo $datos_facturacion ?>
</div>

<div id="asistentes"></div>

<div class="row">
	<div class="twelve columns">
		<a href="#" class="success round button small" id="agregar_asistente">Agregar Asistente</a>
	</div>
</div>

<div class="row">
	<div class="twelve" style="padding:20px;">
		<div class="alert-box" id="div-cargando" style="display:none;"><?php echo lang('cargando')?></div>
		<hr />
		<a href="#" class="button radius wtc" id="boton_aceptar">Aceptar</a> 
		<a href="#" class="button radius wtc">Limpiar</a>
	</div>
</div>

<?php echo $formulario_inscribir_js ?>