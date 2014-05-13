<h3><?php echo lang('ficha_datos'); ?></h3>

	<div class="ficha_servicio">
		<?php $estado = json_decode(modules::run('services/relations/get_from_id','estado',$servicio->id_estado,'true')); ?>		

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
				<td><i class="general foundicon-star"></i> <?php echo lang('tipo_servicio'); ?>:</td>
				<td><?php echo lang('servicio_'.$servicio->nombre_tipo); ?></td>
			</tr>
		</table>
	
	</div>

<div class="row">
	<div class="twelve columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('servicios_url').'/'.lang('editar_url').'_'.lang('servicio_url').'/'.$servicio->id_servicio, lang('editar_tit_serv'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('servicios_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$servicio->id_servicio, lang('editar_tit_serv'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
		?>
	</div>
</div>