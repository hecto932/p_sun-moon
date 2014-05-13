<?php //die_pre($this->session->userdata('id_usuario')); ?>
<div class="row">
	<div class="twelve columns">

		<?php if(isset($breadcrumbs)): ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>

		<table class="twelve responsive" border="1" summary="Tabla de monitor.">
			<thead>
				<tr>
					<th id="tipo" class="col1 <?php echo ((strpos(uri_string(),'tipo_contenido')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'tipo_contenido')!=false) ? $url.'/'.$order_by_new : $url.'/'.'tipo_contenido/asc', lang('monitor_tipoC'))?></th>
					<th id="id_contenido" class="col2 dark <?php echo ((strpos(uri_string(),'id_contenido')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_contenido')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_contenido/asc', lang('monitor_IDcnt'))?></th>
					
					<th id="tipo_accion" class="col3 dark <?php echo ((strpos(uri_string(),'tipo_accion')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'tipo_accion')!=false) ? $url.'/'.$order_by_new : $url.'/'.'tipo_accion/asc',lang("monitor_tipoA"))?></th>
					<th id="fecha" class="col4 <?php echo ((strpos(uri_string(),'fecha')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'fecha')!=false) ? $url.'/'.$order_by_new : $url.'/'.'fecha/asc',lang('monitor_fecha'))?></th>
					<th id="id_usuario" class="col5 dark last <?php echo ((strpos(uri_string(),'id_usuario')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_usuario')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_usuario/asc',lang('usuario'))?></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; ?>
			<?php foreach ($monitor as $monitor): ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="monitor_<?php echo $monitor->id_monitor?>">
					<td class="col1" headers="tipo"><p><?php echo $monitor->tipo_contenido; ?></p></td>
					<td class="col2" headers="id_contenido"><p><?php echo $monitor->id_contenido ?></p></td>
					<!--<td class="col3" headers="detacado"><p><?php echo ($monitor->monitor_destacada == 1 ? 'Si' : 'No')?></p></td>-->
					<td class="col3" headers="tipo_accion"><p><?php echo lang($monitor->tipo_accion) ?></p></td>
					<td class="col4" headers="fecha"><p><?php echo $monitor->fecha?></p></td>
					<td class="col5 last" headers="id_usuario"><p><?php 
					$usuario=json_decode(modules::run('usuarios/user_data',$monitor->id_usuario,'true'));
					//die_pre($monitor);
					echo (!empty($usuario)) ? ucwords($usuario->nombre.' '.$usuario->apellidos) : lang('not_defined_user');?></p></td>
					
				</tr>
				<?php $i++; ?>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>
		
	</div>
</div>