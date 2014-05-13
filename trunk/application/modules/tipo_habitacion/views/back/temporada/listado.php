<?php if (count($temporadas)): ?>
	<table class="twelve">
		<thead>
			<tr>
				<th width="20%"><?php echo anchor("$uri_base/nombre/$new_orden/$from", 		lang('temporada').				query_arrow('nombre', 	$order_campo, $new_orden))?></th>
				<th width="20%"><?php echo anchor("$uri_base/inicio/$new_orden/$from", 		lang('temporada_inicio').		query_arrow('inicio', 	$order_campo, $new_orden))?></th>
				<th width="20%"><?php echo anchor("$uri_base/fin/$new_orden/$from", 		lang('temporada_fin').			query_arrow('fin', 		$order_campo, $new_orden))?></th>
				
				<th width="20%"><?php echo lang('tipo_habitacion_list_editar'); ?></th>
				<th width="20%"><?php echo lang('tipo_habitacion_crear_pquitar'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($temporadas as $temporada): ?>
				<tr style="height:55px;">
					<td><?php echo $temporada->nombre; ?></td>
					
					<?php list($a, $m, $d) = explode('-', $temporada->inicio); $mes = mes_letras($m); ?>
					<td><?php echo $d.' '.$mes; ?></td>
					
					<?php list($a, $m, $d) = explode('-', $temporada->fin); $mes = mes_letras($m); ?>
					<td><?php echo $d.' '.$mes; ?></td>
					
					<td>
						<a href="<?php echo site_url('/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url').'/'.lang('editar_temporada_url').'/'.$temporada->id_temporada_fecha) ?>" class="button radius wtc"><?php echo lang('editar')?></a>
					</td>
					<td>
						<a href="<?php echo site_url('/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url').'/'.lang('eliminar_temporada_url').'/'.$temporada->id_temporada_fecha) ?>" style="margin-left:5px;" class="eliminar"><?php echo lang('eliminar')?></a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links()?>
<?php else: ?>
	<div class="alert-box"><?php echo 'Sin datos'; ?></div>
<?php endif ?>