<?php
	$idiomas = json_decode(modules::run('services/relations/get_all','idioma','true'));
	foreach($noticia_idiomas as $noticia_idioma):
						$idioma[$noticia_idioma->id_idioma] = json_decode(modules::run('services/relations/get_from_id','idioma',$noticia_idioma->id_idioma,'true'));
	endforeach;
?>


<?php foreach($noticia_idiomas as $noticia_idioma): ?>
	<?php
		$img = json_decode(modules::run('services/relations/get_rel','noticia','imagen',$noticia->id_noticia,'true'));
		$ni = 0;
		foreach($img as $k => $i):
			if ($i->id_idioma == $noticia_idioma->id_idioma):
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

	<li id="Lang<?php echo $noticia_idioma->id_idioma; ?>Tab">

		<div class="idioma_info">
			<h3><?php echo lang('ficha_info'); ?></h3>

			<?php if ($noticia_idioma->nombre != ''): ?>
				<div>
					<i class="foundicon-page"></i>
					<span> <?php echo lang('noticias_ficha_titulo'); ?>: </span> </span> <?php echo $noticia_idioma->nombre?> </span>

				</div>
			<?php endif; ?>

			<?php if ($noticia_idioma->subtitulo != ''): ?>
				<div>
					<i class="foundicon-add-doc"></i>
					<span> <?php echo lang('noticias_ficha_subT'); ?>: <?php echo $noticia_idioma->subtitulo?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($noticia_idioma->descripcion_breve != ''): ?>
				<div>
					<i class="foundicon-quote"> </i>
					<span> <?php echo lang('noticias_ficha_dscB'); ?>: <?php echo $noticia_idioma->descripcion_breve?> </span>
				</div>
			<?php endif; ?>

			<?php if ($noticia_idioma->descripcion_ampliada != ''): ?>
				<div class="desc_larga">
					<i class="foundicon-quote"></i>
					<?php

						//$temp =  str_replace('<p> </p>', ' ', str_replace('<br />', "\n", $noticia_idioma->descripcion_ampliada));
						$temp = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', strip_tags($noticia_idioma->descripcion_ampliada));
					?>
					<span style="word-wrap: break-word;"> <?php echo lang('noticias_ficha_dscA'); ?>: <?php echo $temp; ?> </span>
				</div>
			<?php endif; ?>

			<hr>

			<?php if ($noticia_idioma->descripcion_pagina != ''): ?>
				<div>
					<i class="foundicon-quote"></i>
					<span><?php echo lang('noticias_ficha_paginaD'); ?>: <?php echo $noticia_idioma->descripcion_pagina; ?> </span>
				</div>
			<?php endif; ?>

			<?php if ($noticia_idioma->titulo_pagina != ''): ?>
				<div>
					<i class="foundicon-paper-clip"></i>
					<span> <?php echo lang('noticias_ficha_paginaT'); ?>: <?php echo $noticia_idioma->titulo_pagina?> </span>
				</div>
			<?php endif; ?>


			<?php if ($noticia_idioma->url != ''): ?>
				<div>
					<i class="foundicon-website"></i>
					<span>URL: <?php echo $noticia_idioma->url; ?></span>
				</div>
			<?php endif; ?>


			<?php if ($noticia_idioma->keywords != ''): ?>
				<div>
					<i class="foundicon-lock"></i>
					<span> <?php echo lang('noticias_ficha_pclave'); ?>: <?php echo $noticia_idioma->keywords; ?></span>
				</div>
			<?php endif;  ?>

		</div>

		<dl>
            <?php if (isset($img[$ni]) && $img[$ni]->descripcion_multimedia != ''): ?>
				<dt> <?php echo lang('noticias_ficha_descI'); ?> </dt>
				<dd><?php echo $img[$ni]->descripcion_multimedia?></dd>
			<?php endif; ?>

		</dl>

		<div class="row">
			<div class="twelve columns">
				<?php
					echo anchor(lang('backend_url').'/'.lang('noticias_url').'/'.lang('eliminar_url').'_'.lang('idioma_url').'/'.$noticia->id_noticia.'/'.$noticia_idioma->id_detalle_noticia, lang('idioma_eliminar'), array('title'=> lang('idioma_eliminar'), 'class' => 'button radius alert'));
				?>

				<?php
					echo anchor(lang('backend_url').'/'.lang('noticias_url').'/'.lang('editar_url').'_'.lang('idioma_url').'/'.$noticia->id_noticia.'/'.$noticia_idioma->id_detalle_noticia, lang('idioma_editar'), array('title'=> lang('idioma_editar'), 'class' => 'button radius wtc'));
				?>
			</div>
		</div>


<?php endforeach; ?>