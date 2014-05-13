<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<?php if (count($facturas)): ?>
			<table class="twelve">
				<thead>
					<th width="15%"><?php echo anchor("$uri_base/id_factura/$new_orden", lang('facturas.numero').query_arrow('id_factura', $order_campo, $new_orden)) ?></th>
					<th width="21%"><?php echo anchor("$uri_base/nombre/$new_orden", lang('facturas.nombre').query_arrow('nombre', $order_campo, $new_orden))?></th>
					<th width="10%"><?php echo anchor("$uri_base/monto/$new_orden",lang('facturas.monto').query_arrow('monto', $order_campo, $new_orden))?></th>
					<th width="12%"><?php echo anchor("$uri_base/cancelada/$new_orden",lang('facturas.cancelada').query_arrow('cancelada', $order_campo, $new_orden))?></th>
					<th width="12%"><?php echo anchor("$uri_base/anulada/$new_orden",lang('facturas.anulada').query_arrow('anulada', $order_campo, $new_orden))?></th>
					<th width="20%"><?php echo anchor("$uri_base/timestamp/$new_orden", lang('facturas.fecha').query_arrow('timestamp', $order_campo, $new_orden))?></th>
					<th width="10%"></th>
				</thead>
				<tbody>
					<?php foreach ($facturas as $factura): ?>
						<tr>
							<td><?php echo $factura->id_factura?></td>
							<td><?php echo $factura->nombre ?></td>
							<td><?php echo number_format($factura->monto, 2, ',', '.') ?></td>
							<td><?php echo $factura->cancelada ? 'Si' : 'No'?></td>
							<td><?php echo $factura->anulada ? 'Si' : 'No'?></td>
							<td><?php echo date('d/m/Y h:i A', strtotime($factura->timestamp))?></td>
							<td><?php echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('facturas_url').'/'.lang('consultar_url').'/'.$factura->id_factura,'Ver', 'class="button wtc radius"') ?></td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
			<?php echo $this->pagination->create_links() ?>
		<?php else: ?>
			<div class="alert-box"><?php echo lang('facturas.sin_datos')?></div>
		<?php endif ?>
	</div>
</div>