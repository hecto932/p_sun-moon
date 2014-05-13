<h3><?php echo lang('ficha_datos'); ?></h3>

	<div class="ficha_banner">
		<?php $estado = json_decode(modules::run('services/relations/get_from_id','estado',$banner->id_estado,'true')); ?>
		<table style="border: 0px; padding: 3px 3px;">
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('estado'); ?>:</td>
				<td><?php echo ucfirst($estado->estado); ?></td>
			</tr>
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('banners_crear_fecha'); ?>:</td>
				<td><?php echo date('d/m/Y',mysql_to_unix($banner->creado)); ?></td>
			</tr>
		</table>
	</div>
	
<div class="row">
	<div class="twelve columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('banners_url').'/'.lang('editar_url').'_'.lang('banner_url').'/'.$banner->id_banner, lang('editar_tit_bnn'), array('title'=>lang('editar_tit_bnn'), 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('banners_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$banner->id_banner, lang('editar_tit_bnn'), array('title'=>lang('editar_tit_bnn'), 'class' => 'button radius wtc'));
		?>
	</div>
</div>