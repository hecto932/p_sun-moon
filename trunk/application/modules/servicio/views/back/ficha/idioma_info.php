<?php
	$idiomas = json_decode(modules::run('services/relations/get_all','idioma','true'));
	foreach($servicio_idiomas as $servicio_idioma):
						$idioma[$servicio_idioma->id_idioma] = json_decode(modules::run('services/relations/get_from_id','idioma',$servicio_idioma->id_idioma,'true'));
	endforeach;
?>


<?php foreach($servicio_idiomas as $servicio_idioma): ?>
	<?php
		$img = json_decode(modules::run('services/relations/get_rel','servicio','imagen',$servicio->id_servicio,'true'));
		$ni = 0;
		foreach($img as $k => $i):
			if ($i->id_idioma == $servicio_idioma->id_idioma):
				$ni=$k;
			endif;
		endforeach;
	?>

	<?php
	/*
	 *  Por cada lenguaje creado el código se encarga de crear
	 *  una nueva pestaña mostrando la informaciñon correspondiente
	 *  al idioma, el id de la ficha tiene que terminar en Tab
	 *  para ser tomada por el framework Foundation.
	 *
	 * */
	?>

	<li id="Lang<?php echo $servicio_idioma->id_idioma; ?>Tab">

		<div class="idioma_info">
			<h3><?php echo lang('ficha_info'); ?></h3>

			<?php if ($servicio_idioma->nombre != ''): ?>
				<div>
					<i class="foundicon-page"></i>
					<span> <?php echo lang('servicios_ficha_titulo'); ?>: </span> </span> <?php echo $servicio_idioma->nombre?> </span>

				</div>
			<?php endif; ?>

			<?php if ($servicio_idioma->subtitulo != ''): ?>
				<div>
					<i class="foundicon-add-doc"></i>
					<span> <?php echo lang('servicios_ficha_subT'); ?>: <?php echo $servicio_idioma->subtitulo?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($servicio_idioma->descripcion_breve != ''): ?>
				<div>
					<i class="foundicon-quote"> </i>
					<span> <?php echo lang('servicios_ficha_dscB'); ?>: <?php echo $servicio_idioma->descripcion_breve?> </span>
				</div>
			<?php endif; ?>

			<?php if ($servicio_idioma->descripcion_ampliada != ''): ?>
				<div class="desc_larga">
					<i class="foundicon-quote"></i>
					<?php
						$temp = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', strip_tags($servicio_idioma->descripcion_ampliada));
					?>
					<span style="word-wrap: break-word;"> <?php echo lang('servicios_ficha_dscA'); ?>: <?php echo $temp; ?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($servicio_idioma->descripcion_pagina != ''): ?>
				<div>
					<i class="foundicon-quote"></i>
					<span><?php echo lang('servicios_ficha_paginaD'); ?>: <?php echo $servicio_idioma->descripcion_pagina; ?> </span>
				</div>
			<?php endif; ?>

			<?php if ($servicio_idioma->titulo_pagina != ''): ?>
				<div>
					<i class="foundicon-paper-clip"></i>
					<span> <?php echo lang('servicios_ficha_paginaT'); ?>: <?php echo $servicio_idioma->titulo_pagina?> </span>
				</div>
			<?php endif; ?>


			<?php if ($servicio_idioma->url != ''): ?>
				<div>
					<i class="foundicon-website"></i>
					<span>URL: <?php echo $servicio_idioma->url; ?></span>
				</div>
			<?php endif; ?>


			<?php if ($servicio_idioma->keywords != ''): ?>
				<div>
					<i class="foundicon-lock"></i>
					<span> <?php echo lang('servicios_ficha_pclave'); ?>: <?php echo $servicio_idioma->keywords; ?></span>
				</div>
			<?php endif;  ?>

		</div>

		<dl>
            <?php if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia != ''): ?>
				<dt> <?php echo lang('servicios_ficha_descI'); ?> </dt>
				<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
			<?php endif; ?>

		</dl>

		<div class="row">
			<div class="twelve columns">
				<?php
					echo anchor(lang('backend_url').'/'.lang('servicios_url').'/'.lang('eliminar_url').'_'.lang('idioma_url').'/'.$servicio->id_servicio.'/'.$servicio_idioma->id_detalle_servicio, lang('idioma_eliminar'), array('title'=> lang('idioma_eliminar'), 'class' => 'button radius alert'));
				?>

				<?php
					echo anchor(lang('backend_url').'/'.lang('servicios_url').'/'.lang('editar_url').'_'.lang('idioma_url').'/'.$servicio->id_servicio.'/'.$servicio_idioma->id_detalle_servicio, lang('idioma_editar'), array('title'=> lang('idioma_editar'), 'class' => 'button radius wtc'));
				?>
			</div>
		</div>


<?php endforeach; ?>