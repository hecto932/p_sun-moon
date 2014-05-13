<?php
	$idiomas = json_decode(modules::run('services/relations/get_all','idioma','true'));
	foreach($banner_idiomas as $banner_idioma):
						$idioma[$banner_idioma->id_idioma] = json_decode(modules::run('services/relations/get_from_id','idioma',$banner_idioma->id_idioma,'true'));
	endforeach;
?>


<?php foreach($banner_idiomas as $banner_idioma): ?>
	<?php
		$img = json_decode(modules::run('services/relations/get_rel','banner','imagen',$banner->id_banner,'true'));
		$ni = 0;
		foreach($img as $k => $i):
			if ($i->id_idioma == $banner_idioma->id_idioma):
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

	<li id="Lang<?php echo $banner_idioma->id_idioma; ?>Tab">

		<div class="idioma_info">
			<h3><?php echo lang('ficha_info'); ?></h3>

			<?php if ($banner_idioma->nombre != ''): ?>
				<div>
					<i class="foundicon-page"></i>
					<span> <?php echo lang('banners_ficha_titulo'); ?>: </span> </span> <?php echo $banner_idioma->nombre?> </span>

				</div>
			<?php endif; ?>

			<?php if ($banner_idioma->subtitulo != ''): ?>
				<div>
					<i class="foundicon-add-doc"></i>
					<span> <?php echo lang('banners_ficha_subT'); ?>: <?php echo $banner_idioma->subtitulo?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($banner_idioma->descripcion_breve != ''): ?>
				<div>
					<i class="foundicon-quote"> </i>
					<span> <?php echo lang('banners_ficha_dscB'); ?>: <?php echo $banner_idioma->descripcion_breve?> </span>
				</div>
			<?php endif; ?>

			<?php if ($banner_idioma->descripcion_ampliada != ''): ?>
				<div class="desc_larga">
					<i class="foundicon-quote"></i>
					<?php

						//$temp =  str_replace('<p> </p>', ' ', str_replace('<br />', "\n", $banner_idioma->descripcion_ampliada));
						$temp = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', strip_tags($banner_idioma->descripcion_ampliada));
					?>
					<span style="word-wrap: break-word;"> <?php echo lang('banners_ficha_dscA'); ?>: <?php echo $temp; ?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($banner_idioma->descripcion_pagina != ''): ?>
				<div>
					<i class="foundicon-quote"></i>
					<span><?php echo lang('banners_ficha_paginaD'); ?>: <?php echo $banner_idioma->descripcion_pagina; ?> </span>
				</div>
			<?php endif; ?>

			<?php if ($banner_idioma->titulo_pagina != ''): ?>
				<div>
					<i class="foundicon-paper-clip"></i>
					<span> <?php echo lang('banners_ficha_paginaT'); ?>: <?php echo $banner_idioma->titulo_pagina?> </span>
				</div>
			<?php endif; ?>


			<?php if ($banner_idioma->url != ''): ?>
				<div>
					<i class="foundicon-website"></i>
					<span>URL: <?php echo $banner_idioma->url; ?></span>
				</div>
			<?php endif; ?>


			<?php if ($banner_idioma->keywords != ''): ?>
				<div>
					<i class="foundicon-lock"></i>
					<span> <?php echo lang('banners_ficha_pclave'); ?>: <?php echo $banner_idioma->keywords; ?></span>
				</div>
			<?php endif;  ?>

		</div>

		<dl>
            <?php if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia != ''): ?>
				<dt> <?php echo lang('banners_ficha_descI'); ?> </dt>
				<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
			<?php endif; ?>

		</dl>

		<div class="row">
			<div class="twelve columns">
				<?php
					echo anchor(lang('backend_url').'/'.lang('banners_url').'/'.lang('eliminar_url').'_'.lang('idioma_url').'/'.$banner->id_banner.'/'.$banner_idioma->id_detalle_banner, lang('idioma_eliminar'), array('title'=> lang('idioma_eliminar'), 'class' => 'button radius alert'));
				?>

				<?php
					echo anchor(lang('backend_url').'/'.lang('banners_url').'/'.lang('editar_url').'_'.lang('idioma_url').'/'.$banner->id_banner.'/'.$banner_idioma->id_detalle_banner, lang('idioma_editar'), array('title'=> lang('idioma_editar'), 'class' => 'button radius wtc'));
				?>
			</div>
		</div>


<?php endforeach; ?>