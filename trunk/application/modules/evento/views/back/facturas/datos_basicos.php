<div class="row">
	<div class="five columns">
		<h3><?php echo lang('facturas.datos_basicos')?></h3>
		<form class="custom">
			<table class="twelve">
				<tr>
					<td width="33%"><strong><?php echo lang('facturas.numero')?></strong></td>
					<td width="66%"><?php echo $factura->id_factura ?></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('facturas.nombre')?></strong></td>
					<td><?php echo anchor('', $factura->nombre) ?></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('facturas.monto')?></strong></td>
					<td><?php echo number_format($factura->monto, 2, ',', '.') ?></td>
				</tr>
				<tr>
					<td colspan="2">
						<label for="factura_cancelada">
							<input type="checkbox" id="factura_cancelada" style="display:none;" <?php if ($factura->cancelada) echo 'checked="checked"'?>> 
							<span class="custom checkbox"></span> <?php echo lang('facturas.cancelada')?>
						</label>
						
						<label for="factura_anulada">
							<input type="checkbox" id="factura_anulada" style="display:none;" <?php if ($factura->anulada) echo 'checked="checked"'?>> 
							<span class="custom checkbox"></span> <?php echo lang('facturas.anulada')?>
						</label>
					</td>
				</tr>
				<tr>
					<td><strong><?php echo lang('facturas.fecha')?></strong></td>
					<td><?php echo date('d/m/Y h:i A', strtotime($factura->timestamp)) ?></td>
				</tr>
			</table>
		</form>
	</div>
	
	<div class="seven columns">
		<h3><?php echo lang('pagos.pagos_realizados') ?></h3>
		<?php if (count($pagos)): ?>
			<table class="twelve">
				<thead>
					<tr>
						<th><?php echo lang('pagos.tipo_pago')?></th>
						<th><?php echo lang('pagos.referencia')?></th>
						<th><?php echo lang('pagos.fecha')?></th>
						<th><?php echo lang('pagos.monto')?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pagos as $pago): ?>
						<tr>
							<td><?php echo $pago->tipo_pago?></td>
							<td><?php echo $pago->referencia?></td>
							<td><?php echo date('d/m/Y h:i A', strtotime($pago->timestamp)) ?></td>
							<td><?php echo number_format($pago->monto, 2, ',', '.')?></td>
						</tr>
					<?php endforeach ?>
						<tr>
							<td colspan="3" style="text-align:right;"><strong><?php echo lang('total')?></strong></td>
							<td><strong><?php echo number_format($total_pagos, 2, ',', '.')?></strong></td>
						</tr>
				</tbody>
			</table>
		<?php else: ?>
			<div class="alert-box"><?php echo lang('pagos.sin_pagos')?></div>
		<?php endif ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<h3><?php echo lang('facturas.inscripciones_asociadas') ?></h3>
		<?php if (count($inscripciones)): ?>
			<table class="twelve">
				<thead>
					<tr>
						<th width="30%"><?php echo lang('evento')?></th>
						<th width="20%"><?php echo lang('inscritos.nombre_completo')?></th>
						<th width="10%"><?php echo lang('eventos_crear_precio')?></th>
						<th width="20%"><?php echo lang('hospedaje.tipo_hospedaje')?></th>
						<th width="10%"><?php echo lang('hospedaje.precio')?></th>
						<th width="10%"><?php echo lang('total') ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($inscripciones as $inscrito): ?>
					<tr>
						<td><?php echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$inscrito->id_evento, $inscrito->evento_nombre) ?></td>
						<td><?php echo anchor('', $inscrito->nombres.' '.$inscrito->apellidos) ?></td>
						<td><?php echo number_format($inscrito->precio_evento, 2, ',', '.') ?></td>
						<td><?php echo $inscrito->tipo_hospedaje ?></td>
						<td><?php echo number_format(is_null($inscrito->precio_hospedaje) ? 0 : $inscrito->precio_hospedaje, 2, ',', '.') ?></td>
						<td><strong><?php echo number_format($inscrito->total, 2, ',', '.')?></strong></td>
					</tr>
				<?php endforeach ?>
					<tr>
						<td colspan="5" style="text-align:right;"><strong><?php echo lang('total')?></strong></td>
						<td><strong><?php echo number_format($monto, 2, ',', '.')?></strong></td>
					</tr>
				</tbody>
			</table>
		<?php else: ?>
			<div class="alert-box alert"><?php echo lang('facturas.sin_inscripciones')?></div>
		<?php endif ?>
	</div>
</div>

<?php echo $factura_js ?>