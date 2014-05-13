<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<dl class="tabs">
			<dd class="active"><a href="#Listado"><?php echo lang('hospedaje.hospedaje_disponible')?></a></dd>
			<dd><a href="#Agregar"><?php echo lang('hospedaje.agregar') ?></a></dd>
		</dl>
		
		<ul class="tabs-content">
			<li class="active" id="ListadoTab"><?php echo $listado_hospedaje ?></li>
			<li id="AgregarTab"><?php echo $agregar_hospedaje ?></li>
		</ul>
	</div>
</div>