<script>
	$('#boton_descarga').click(function(e){
		e.preventDefault;
		var request = $.ajax({
			url:"<?php lang('backend_url').'/'.lang('contactos_url').'/'.lang('descarga_archivo_url'); ?>",
			datatype: 'text',
			type: POST,
		});
		return false;
	});
</script>
<div id="ficha">

		<h2><?php echo (isset($operadora) ? lang('editar') : lang('crear')).' '.lang('operadora')?></h2>


		<!-- Formulario Crear operadora -->
		<fieldset>
			<table width="100%" class="contactoTabla">
			
			<tr>
				<td>
					<p name = "info_descarga"> <?php echo lang('contacto_descarga_info'); ?> <p>
					<strong class="boton_descarga">
						<?php echo anchor(lang('backend_url').'/'.lang('contactos_url').'/'.lang('descarga_url').'/'.lang('descarga_archivo_url'), lang('contacto_descarga_tit'), array('title'=> lang('operadora_listado_titulo'), 'id' => 'boton_descarga')); ?>
					</strong>
				</td>
			</tr>
			
			</table>
			
			<strong class="boton">
					<?php echo anchor(lang('backend_url').'/'.lang('contactos_url').'/'.lang('listado_url'), lang('contacto_listado'), array('title'=> lang('operadora_listado_titulo'))); ?>
			</strong>
		</fieldset>
	</form>
			<!-- Formulario Formulario Crear operadora cierre -->
</div>
