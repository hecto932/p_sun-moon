<h3><?php echo lang('ficha_datos'); ?></h3>

	<div class="ficha_habitacion">
		<?php $estado = json_decode(modules::run('services/relations/get_from_id','estado',$habitacion->id_estado,'true')); ?>		

		<table style="border: 0px; padding: 3px 3px;">
			<!--<tr>
				<td><i class="general foundicon-page"></i> <?php echo lang('nombre'); ?>:</td>
				<td><?php echo ($servicio->nombre == '') ? lang('servicios_sintitulo') : ucfirst($servicio->nombre); ?></td>
			</tr>-->
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('estado'); ?>:</td>
				<td><?php echo ucfirst($estado->estado); ?></td>
			</tr>
			<tr>
				<td><i class="general foundicon-star"></i> <?php echo lang('tipo_habitacion'); ?>:</td>
				<td><?php echo $habitacion->nombre_tipo; ?></td>
			</tr>
			<!--
			<tr>
				<td><i class="general foundicon-star"></i> <?php echo 'Estado habitación'; ?>:</td>
				<td><?php echo ucwords(strtolower($habitacion->estado_habitacion)); ?></td>
			</tr>
			-->
		</table>
	
	</div>

<div class="row">
	<div class="twelve columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('editar_url').'_'.lang('habitacion_url').'/'.$habitacion->id_habitacion, lang('editar_tit_hab'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$habitacion->id_habitacion, lang('editar_tit_hab'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
		?>
	</div>
</div>