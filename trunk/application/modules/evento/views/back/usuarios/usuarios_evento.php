<div class="row">
	<div class="twelve columns">
		<?php echo $breadcrumbs ?>
	</div>
</div>

<div class="row">
	<div class="twelve columns">
		<dl class="tabs">
			<dd class="active"><a href="#Listado">Listado de Usuarios</a></dd>
			<dd><a href="#Nuevo">Agregar Usuario</a></dd>
		</dl>
		<ul class="tabs-content">
			<li class="active" id="ListadoTab"><?php echo $listado_usuarios ?></li>
			<li id="NuevoTab"><?php echo $agregar_usuario ?></li>
		</ul>
	</div>
</div>

<?php echo $usuarios_listado_js ?>
