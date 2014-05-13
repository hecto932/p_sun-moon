<?php if ( ! empty($inscritos)): //die_pre($inscritos); ?>
	<table class="twelve">
		<thead>
			<tr>
				<th width="15%"><?php echo anchor("$uri_base/cedula/$new_orden/$from",lang('inscritos.cedula_o_rif').query_arrow('cedula', $order_campo, $new_orden))?></th>
				<th width="30%"><?php echo anchor("$uri_base/nombres/$new_orden/$from",lang('inscritos.nombre_completo').query_arrow('nombres', $order_campo, $new_orden))?></th>
				<th width="20%"><?php echo anchor("$uri_base/email/$new_orden/$from",lang('inscritos.email').query_arrow('email', $order_campo, $new_orden))?></th>
				<th width="10%"><?php echo anchor("$uri_base/telefono/$new_orden/$from",lang('inscritos.telefono').query_arrow('telefono', $order_campo, $new_orden))?></th>
				<!--<th width="10%"><?php echo anchor("$uri_base/desea_hospedaje/$new_orden/$from",lang('inscritos.desea_hospedaje').query_arrow('desea_hospedaje', $order_campo, $new_orden))?></th>
				<th width="25%"><?php echo anchor("$uri_base/contacto_nombres/$new_orden/$from",lang('inscritos.contacto').query_arrow('contacto_nombres', $order_campo, $new_orden))?></th>-->
				<th width="20%"><?php echo anchor("$uri_base/timestamp/$new_orden/$from",lang('inscritos.fecha').query_arrow('timestamp', $order_campo, $new_orden))?></th>
				<th width="5%"><?php echo lang('listado_ver'); ?></th>
				<th width="5%"><?php echo lang('eliminar'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($inscritos as $key => $usuario): ?>
			<tr>
				<td><?php echo empty($usuario->cedula) ? $usuario->rif : $usuario->cedula ?></td>
				<td><?php echo ucwords(strtolower($usuario->nombres.' '.$usuario->apellidos)) ?></td>
				<td><?php echo $usuario->email; ?></td>
				<td><?php echo $usuario->telefono1; ?></td>
				<!--<td><?php echo empty($usuario->desea_hospedaje) ? 'No' : 'Si'?></td>
				<td><?php echo $usuario->contacto_nombres.' '.$usuario->contacto_apellidos ?></td>-->
				<td><span style="font-size: 12px"><?php echo date('d/m/Y h:i A', strtotime($usuario->timestamp)) ?></span></td>
				<td>
					<a href="#" class="button wtc tiny radius" data-reveal-id="contact_modal<?php echo $key ?>">
						<?php echo lang('listado_ver'); ?>
					</a>
				</td>
				<td style="text-align: center"><?php echo anchor('backend/borrar_inscripcion/'.$usuario->id_inscripcion.'/'.$usuario->id_evento,'<i class="foundicon-remove"></i>',array('title'=>"Eliminar inscripcion", 'class'=>"delete", 'id'=>"icon_eliminar"))?></td>
			</tr>
			<div id="contact_modal<?php echo $key ?>" class="reveal-modal large">
				<h3><?php echo lang('inscritos.info') ?></h3>
				<ul>
					<!-- NOMBRE -->
					<li><strong><?php echo lang('inscritos.nombre_completo'); ?>:</strong> <?php echo ucwords(strtolower($usuario->nombres.' '.$usuario->apellidos)); ?></li>
					<!-- CÉDULA -->
					<li><strong><?php echo lang('inscritos.cedula'); ?>:</strong> <?php echo $usuario->cedula; ?></li>
					<!-- RIF -->
					<?php if(isset($usuario->rif) && !empty($usuario->rif)) : ?>
						<li><strong><?php echo lang('inscritos.rif'); ?>:</strong> <?php echo $usuario->rif; ?></li>
					<?php endif; ?>
					<!-- EMAIL -->
					<li><strong><?php echo lang('inscritos.email'); ?>:</strong> <?php echo $usuario->email; ?></li>
					<!-- TELÉFONO -->
					<li>
						<strong><?php echo lang('inscritos.telefono'); ?>:</strong>
						<?php echo (isset($usuario->telefono2) && !empty($usuario->telefono2)) ? $usuario->telefono1.' / '.$usuario->telefono2 : $usuario->telefono1; ?>
					</li>
					<!-- DIRECCION -->
					<li><strong><?php echo lang('inscritos.direccion'); ?>:</strong> <?php echo $usuario->direccion; ?></li>
					<!-- HOSPEDAJE -->
					<li><strong><?php echo lang('inscritos.desea_hospedaje'); ?>:</strong> <?php echo ($usuario->desea_hospedaje=='0') ? 'No' : 'Sí'; ?></li>
					<hr />
					<!-- INSCRITO POR -->
					<strong><?php echo lang('inscritos.datos_contacto') ?></strong><br />
					<li>
						<strong><?php echo lang('inscritos.contacto'); ?>:</strong>
						<?php echo ($usuario->cedula!=$usuario->contacto_cedula) ? ucwords(strtolower($usuario->contacto_nombres.' '.$usuario->contacto_apellidos)) : 'Auto-inscrito'; ?>
					</li>
					<!-- DATOS CONTACTO -->
					<?php if($usuario->cedula!=$usuario->contacto_cedula) : ?>
						<li><strong><?php echo lang('inscritos.email'); ?>:</strong> <?php echo $usuario->contacto_email; ?></li>
						<li><strong><?php echo lang('inscritos.cedula'); ?>:</strong> <?php echo $usuario->contacto_cedula; ?></li>
						<li>
							<strong><?php echo lang('inscritos.telefono'); ?>:</strong>
							<?php echo (isset($usuario->contacto_telefono2) && !empty($usuario->contacto_telefono2)) ? $usuario->contacto_telefono1.' / '.$usuario->contacto_telefono2 : $usuario->contacto_telefono1; ?>
						</li>
					<?php endif; ?>
				</ul>
				<a class="close-reveal-modal">&#215;</a>
			</div>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php echo $this->pagination->create_links() ?>
<?php else: ?>
	<div class="alert-box">
		<?php echo lang('inscritos.sin_datos')?>
	</div>
<?php endif ?>