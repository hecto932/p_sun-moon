<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<dl class="tabs">
			<dd class="active"><a href="#Listado">Listado de Empresas</a></dd>
			<dd><a href="#Nuevo">Agregar Empresa</a></dd>
		</dl>
		<ul class="tabs-content">
			<li class="active" id="ListadoTab"><?php echo $listado_empresas ?></li>
			<li id="NuevoTab"><?php echo $agregar_empresa ?></li>
		</ul>
	</div>
</div>

<?php echo $empresas_listado_js ?>
