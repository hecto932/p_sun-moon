<?php if (count($usuarios)): ?>
	<table class="twelve">
		<thead>
			<tr>
				<th width="10%"><?php echo anchor("$uri_base/cedula/$new_orden/$from", lang('usuarios_eventos.cedula').query_arrow('cedula', $order_campo, $new_orden))?></th>
				<th width="35%"><?php echo anchor("$uri_base/nombres/$new_orden/$from", lang('usuarios_eventos.nombre_completo').query_arrow('nombres', $order_campo, $new_orden))?></th>
				<th width="20%"><?php echo anchor("$uri_base/email/$new_orden/$from", lang('usuarios_eventos.email').query_arrow('email', $order_campo, $new_orden))?></th>
				<th width="15%"><?php echo anchor("$uri_base/telefono1/$new_orden/$from", lang('usuarios_eventos.telefono1').query_arrow('telefono1', $order_campo, $new_orden))?></th>
				<th width="20%"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as $usuario): ?>
				<tr style="height:55px;">
					<td><?php echo $usuario->cedula?></td>
					<td><?php echo $usuario->nombres.' '.$usuario->apellidos?></td>
					<td><?php echo $usuario->email?></td>
					<td><?php echo $usuario->telefono1 ?></td>
					<td>
						<?php echo form_hidden('id_usuario', $usuario->id_usuario)?>
						<div class="opciones-usuario" style="display:none;">
							<a href="<?php echo site_url('backend/eventos/usuarios/editar/'.$usuario->id_usuario) ?>" class="button radius wtc"><?php echo lang('editar')?></a>
							<a href="#" style="margin-left:5px;" class="eliminar"><?php echo lang('eliminar')?></a>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links()?>
<?php else: ?>
	<div class="alert-box"><?php echo lang('usuarios_eventos.sin_usuarios')?></div>
<?php endif ?>