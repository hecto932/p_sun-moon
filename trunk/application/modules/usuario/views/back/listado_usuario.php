<div class="row">
	<div class="twelve columns">

		<?php if(isset($breadcrumbs)): ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>


		<table class="twelve" border="1" summary="Tabla de Usuarios.">
			<thead>
				<tr>
					<th id="id" class="col1 <?php echo ((strpos(uri_string(),'id_usuario')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_usuario')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_usuario/asc', lang('usuarios_list_ID'))?></th>
					<th id="nombre" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc',lang('usuarios_list_usr'))?></th>
					<th id="email" class="col3 <?php echo ((strpos(uri_string(),'email')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'email')!=false) ? $url.'/'.$order_by_new : $url.'/'.'email/asc',"Email")?></th>
					<th id="id_rol" class="col4 dark <?php echo ((strpos(uri_string(),'id_rol')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_rol')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_rol/asc', lang('usuarios_list_rol'))?></th>
					<th id="id_estado_usuario" class="col5 dark <?php echo ((strpos(uri_string(),'id_estado_usuario')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado_usuario')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado_usuario/asc', 'Estado')?></th>
					<th id="ver_usuario" class="col10 dark last"><span> <?php echo lang('usuarios_list_tver'); ?> </span></th>
                    <th id="eliminar" class="col9"><span> <?php echo lang('usuarios_list_teli'); ?> </span></th>

				</tr>
			</thead>
			<tbody>
			<?php $i=1; ?>
			<?php foreach ($usuarios as $usuario): ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="usuario_<?php echo $usuario->id_usuario; ?>">
					<td class="col1" headers="id_usuario">
						<p><?php echo $usuario->id_usuario?></p>
					</td>
					<td class="col2" headers="nombre">
						<p><?php echo ucwords($usuario->apellidos.', '.$usuario->nombre); ?></p>
					</td>
					<td class="col3" headers="email">
						<p><?php echo $usuario->email; ?></p>
					</td>
					<td class="col4" headers="id_rol">
						<p><?php echo ($usuario->id_rol == '1') ? lang('administrador') : lang('editor'); ?></p>
					</td>
					<td class="col5" headers="id_estado_usuario">
						<p><?php echo (isset($usuario->estado_usuario)) ? $usuario->estado_usuario : ''; ?></p>
					</td>
					<td class="col10 last" headers="ver_usuario">
						<strong class="boton">
							<?php
								echo anchor('backend/ficha_usuario/'.$usuario->id_usuario, lang('usuarios_list_tver'), array('title'=> lang('usuarios_list_rusr'), 'class' => 'button radius wtc'))
							?>
						</strong>
					</td>
					<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_usuario/'.$usuario->id_usuario, lang('eliminar'),array('title'=> lang('usuarios_list_dusr'), 'id'=>"icon_eliminar", 'class'=>"delete"))?></p></td>
				</tr>
				<?php
				$i++;
				endforeach; ?>
			</tbody>
		</table>


		<!-- Paginación -->
		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>
		<!-- Paginación cierre -->
	</div>
</div>