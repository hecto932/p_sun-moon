<?php
	$idiomas = json_decode(modules::run('services/relations/get_all','idioma','true'));
	foreach($habitacion_idiomas as $habitacion_idioma):
						$idioma[$habitacion_idioma->id_idioma] = json_decode(modules::run('services/relations/get_from_id','idioma',$habitacion_idioma->id_idioma,'true'));
	endforeach;
?>


<?php foreach($habitacion_idiomas as $habitacion_idioma): ?>
	<?php
		$img = json_decode(modules::run('services/relations/get_rel','habitacion','imagen',$habitacion->id_habitacion,'true'));
		$ni = 0;
		foreach($img as $k => $i):
			if ($i->id_idioma == $habitacion_idioma->id_idioma):
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

	<li id="Lang<?php echo $habitacion_idioma->id_idioma; ?>Tab">

		<div class="idioma_info">
			<h3><?php echo lang('ficha_info'); ?></h3>

			<?php if ($habitacion_idioma->nombre != ''): ?>
				<div>
					<i class="foundicon-page"></i>
					<span> <?php echo lang('habitaciones_ficha_titulo'); ?>: </span> </span> <?php echo $habitacion_idioma->nombre?> </span>

				</div>
			<?php endif; ?>

			<?php if ($habitacion_idioma->subtitulo != ''): ?>
				<div>
					<i class="foundicon-add-doc"></i>
					<span> <?php echo lang('habitaciones_ficha_subT'); ?>: <?php echo $habitacion_idioma->subtitulo?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($habitacion_idioma->descripcion_breve != ''): ?>
				<div>
					<i class="foundicon-quote"> </i>
					<span> <?php echo lang('habitaciones_ficha_dscB'); ?>: <?php echo $habitacion_idioma->descripcion_breve?> </span>
				</div>
			<?php endif; ?>

			<?php if ($habitacion_idioma->descripcion_ampliada != ''): ?>
				<div class="desc_larga">
					<i class="foundicon-quote"></i>
					<?php
						$temp = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', strip_tags($habitacion_idioma->descripcion_ampliada));
					?>
					<span style="word-wrap: break-word;"> <?php echo lang('habitaciones_ficha_dscA'); ?>: <?php echo $temp; ?> </span>
				</div>
			<?php endif; ?>

			<hr>
			
			<?php if ($habitacion_idioma->descripcion_pagina != ''): ?>
				<div>
					<i class="foundicon-quote"></i>
					<span><?php echo lang('habitaciones_ficha_paginaD'); ?>: <?php echo $habitacion_idioma->descripcion_pagina; ?> </span>
				</div>
			<?php endif; ?>

			<?php if ($habitacion_idioma->titulo_pagina != ''): ?>
				<div>
					<i class="foundicon-paper-clip"></i>
					<span> <?php echo lang('habitaciones_ficha_paginaT'); ?>: <?php echo $habitacion_idioma->titulo_pagina?> </span>
				</div>
			<?php endif; ?>


			<?php if ($habitacion_idioma->url != ''): ?>
				<div>
					<i class="foundicon-website"></i>
					<span>URL: <?php echo $habitacion_idioma->url; ?></span>
				</div>
			<?php endif; ?>


			<?php if ($habitacion_idioma->keywords != ''): ?>
				<div>
					<i class="foundicon-lock"></i>
					<span> <?php echo lang('habitaciones_ficha_pclave'); ?>: <?php echo $habitacion_idioma->keywords; ?></span>
				</div>
			<?php endif;  ?>

		</div>

		<dl>
            <?php if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia != ''): ?>
				<dt> <?php echo lang('habitaciones_ficha_descI'); ?> </dt>
				<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
			<?php endif; ?>

		</dl>

		<div class="row">
			<div class="twelve columns">
				<?php
					echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('eliminar_url').'_'.lang('idioma_url').'/'.$habitacion->id_habitacion.'/'.$habitacion_idioma->id_detalle_habitacion, lang('idioma_eliminar'), array('title'=> lang('idioma_eliminar'), 'class' => 'button radius alert'));
				?>

				<?php
					echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('editar_url').'_'.lang('idioma_url').'/'.$habitacion->id_habitacion.'/'.$habitacion_idioma->id_detalle_habitacion, lang('idioma_editar'), array('title'=> lang('idioma_editar'), 'class' => 'button radius wtc'));
				?>
			</div>
		</div>


<?php endforeach; ?>