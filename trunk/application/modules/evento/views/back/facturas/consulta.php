<div class="row">
	<div class="twelve columns"><?php echo $breadcrumbs ?></div>
</div>

<div class="row">
	<div class="twelve columns">
		<dl class="tabs contained">
			<dd class="active"><a href="#Datos"><?php echo lang('facturas.datos_basicos')?></a></dd>
			<dd><a href="#Pagos"><?php echo lang('facturas.pagos')?></a></dd>
		</dl>
		
		<ul class="tabs-content contained">
			<li class="active" id="DatosTab"><?php echo $datos_basicos ?></li>
			<li id="PagosTab"><?php echo $registrar_pagos ?></li>
		</ul>
	</div>
</div>
