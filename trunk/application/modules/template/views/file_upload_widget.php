		<div class="twelve columns">
			<div class="four columns">
				<span class="button radius success" name="boton_subida">
					<span><i class="general foundicon-plus"></i> <?php echo lang('sumar_imagen'); ?></span>
						<input id="fileupload" type="file" name="files[]" data-url="server/" multiple>
				</span>
			</div>

			<div class="four columns">
				<button type="submit" class="button radius wtc" name="inicio">
					<i class="general foundicon-up-arrow"></i> <?php echo lang('iniciar_imagen'); ?>
				</button>
			</div>

			<div class="four columns">
				<button type="reset" class="button alert radius" name="limpiar">
					<i class="general foundicon-remove"></i> <?php echo lang('cancelar_imagen'); ?>
				</button>
			</div>

		</div>

		<div class="twelve columns">
			<table class="twelve" id="tabla_imagen">
				<thead>
					<th> <?php echo lang('preview_imagen'); ?> </th>
					<th> <?php echo lang('nombre_imagen'); ?> </th>
					<th> <?php echo lang('peso_imagen'); ?> </th>
					<th> <?php echo lang('progreso_imagen'); ?> </th>
					<th> <?php echo lang('inicio_imagen'); ?> </th>
					<th> <?php echo lang('limpiar_imagen'); ?> </th>
				</thead>
			</table>
		</div>

		<?php if(isset($tipo) && $tipo != '' && isset($id) && $id != ''): ?>
			<input type="hidden" id = "id_campo" name="<?php echo $tipo; ?>" value="<?php echo $id; ?>" />
		<?php endif; ?>

		<div id="zona_modal"></div>