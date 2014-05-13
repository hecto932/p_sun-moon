<?php if (count($empresas)): ?>
	<table class="twelve">
		<thead>
			<tr>
				<th width="10%"><?php echo anchor("$uri_base/rif/$new_orden/$from", lang('empresa_evento.rif').query_arrow('rif', $order_campo, $new_orden))?></th>
				<th width="35%"><?php echo anchor("$uri_base/razon_social/$new_orden/$from", lang('empresa_evento.razon_social').query_arrow('razon_social', $order_campo, $new_orden))?></th>
				<th width="20%"><?php echo anchor("$uri_base/email/$new_orden/$from", lang('empresa_evento.email').query_arrow('email', $order_campo, $new_orden))?></th>
				<th width="15%"><?php echo anchor("$uri_base/telefono1/$new_orden/$from", lang('empresa_evento.telefono1').query_arrow('telefono1', $order_campo, $new_orden))?></th>
				<th width="20%"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($empresas as $empresa): ?>
				<tr style="height:55px;">
					<td><?php echo $empresa->rif?></td>
					<td><?php echo $empresa->razon_social?></td>
					<td><?php echo $empresa->email?></td>
					<td><?php echo $empresa->telefono1 ?></td>
					<td>
						<?php echo form_hidden('id_empresa', $empresa->id_empresa)?>
						<div class="opciones-empresa" style="display:none;">
							<a href="<?php echo site_url('backend/eventos/empresas/editar/'.$empresa->id_empresa) ?>" class="button radius wtc"><?php echo lang('editar')?></a>
							<a href="#" style="margin-left:5px;" class="eliminar"><?php echo lang('eliminar')?></a>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links()?>
<?php else: ?>
	<div class="alert-box"><?php echo lang('empresa_evento.sin_empresas')?></div>
<?php endif ?>