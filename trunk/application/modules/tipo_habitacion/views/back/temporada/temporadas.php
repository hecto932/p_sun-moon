<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<dl class="tabs">
			<dd class="active"><a href="#Listado"><?php echo lang('temporada_listado'); ?></a></dd>
			<dd><a href="#Nuevo"><?php echo lang('temporada_agregar'); ?></a></dd>
		</dl>
		<ul class="tabs-content">
			<li class="active" id="ListadoTab"><?php echo $listado_temporadas; ?></li>
			<li id="NuevoTab"><?php echo $agregar_temporada; ?></li>
		</ul>
	</div>
</div>