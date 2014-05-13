<div class="row">
	<div class="twelve columns">
		<?php if (count($hospedaje)): ?>
			<table class="twelve">
				<thead>
					<tr>
						<th width="35%"><?php echo anchor("$uri_base/$evento->id_evento/descripcion/$new_orden/$from", lang('hospedaje.tipo_hospedaje').query_arrow('descripcion', $order_campo, $new_orden))?></th>
						<th width="15%"><?php echo anchor("$uri_base/$evento->id_evento/cantidad/$new_orden/$from", lang('hospedaje.cantidad').query_arrow('cantidad', $order_campo, $new_orden))?></th>
						<th width="15%"><?php echo anchor("$uri_base/$evento->id_evento/disponible/$new_orden/$from", lang('hospedaje.disponible').query_arrow('disponible', $order_campo, $new_orden))?></th>
						<th width="15%"><?php echo anchor("$uri_base/$evento->id_evento/precio/$new_orden/$from", lang('hospedaje.precio').query_arrow('precio', $order_campo, $new_orden))?></th>
						<th width="25%"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($hospedaje as $habitacion): ?>
						<tr style="height:60px;">
							<td><?php echo $habitacion->descripcion ?></td>
							<td><?php echo $habitacion->cantidad ?></td>
							<td><?php echo $habitacion->disponible?></td>
							<td><?php echo number_format($habitacion->precio, 2, ',', '.') ?></td>
							<td>
								<?php echo form_hidden('id_hospedaje', $habitacion->id_hospedaje) ?>
								<div class="opciones-hospedaje" style="display:none;">
									<a href="#" class="button radius wtc editar" style="margin-right:6px;"><?php echo lang('editar')?></a>
									<?php if ($habitacion->asignados == 0): ?>
										<a href="#" class="eliminar"><?php echo lang('eliminar') ?></a>
									<?php endif ?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="alert-box"><?php echo lang('hospedaje.sin_hospedaje')?></div>
		<?php endif ?>
	</div>
</div>

<?php echo $hospedaje_listado_js ?>