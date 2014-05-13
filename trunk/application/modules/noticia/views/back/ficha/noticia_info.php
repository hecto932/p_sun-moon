<h3><?php echo lang('ficha_datos'); ?></h3>

	<div class="ficha_noticia">
		<?php $estado = json_decode(modules::run('services/relations/get_from_id','estado',$noticia->id_estado,'true')); ?>
		<table style="border: 0px; padding: 3px 3px;">
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('estado'); ?>:</td>
				<td><?php echo ucfirst($estado->estado); ?></td>
			</tr>
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('noticias_crear_fecha'); ?>:</td>
				<td><?php echo date('d/m/Y',mysql_to_unix($noticia->creado)); ?></td>
			</tr>
		</table>
	</div>
	
<div class="row">
	<div class="twelve columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('noticias_url').'/'.lang('editar_url').'_'.lang('noticia_url').'/'.$noticia->id_noticia, lang('editar_tit_not'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('noticias_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$noticia->id_noticia, lang('editar_tit_not'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
		?>
	</div>
</div>