<script type="text/javascript">
$(document).ready(function()
{
	$.template('ModalEliminar', '<div id="ModalEliminar" class="reveal-modal large"><input type="hidden" name="id_usuario" value="${id_usuario}"><h4>Seguro que desea eliminar este usuario?</h4><a href="#" class="button radius alert">Eliminar</a><a href="#" class="button radius wtc" style="margin-left:6px;">Cancelar</a></div>');
	$.template('InfoUsuario', 	'<table class="seven"><tbody><tr><td>Cédula</td><td>${cedula}</td></tr><tr><td>RIF</td><td>${rif}</td></tr><tr><td>E-Mail</td><td>${email}</td></tr><tr><td>Nombres</td><td>${nombres}</td></tr><tr><td>Apellidos</td><td>${apellidos}</td></tr></tbody></table>');
	
	$('table.twelve tr').bind({
		'mouseenter': function()
		{
			$(this).find('.opciones-usuario').show();
		},
		'mouseleave': function()
		{
			$(this).find('.opciones-usuario').hide();
		}
	});

	$('table.twelve td a.eliminar').bind('click', function(e)
	{
		e.preventDefault();
		$('#ModalEliminar').remove();
		var id_usuario = $(this).closest('tr').find(':hidden').val();
		$(this).closest('.row').after($.tmpl('ModalEliminar', {"id_usuario" : id_usuario }));
		$.post('<?php echo site_url('evento/json/get_usuario') ?>', { "id_usuario" : id_usuario },
		function(json)
		{
			$('#ModalEliminar h4').after($.tmpl('InfoUsuario', json));
		}, 'json');
		$('#ModalEliminar').reveal({ closeOnBackgroundClick : false });
	});

	$(document).on('click', '#ModalEliminar a:first', function(e)
	{
		e.preventDefault();

		if ($(this).is('.disabled')) return;
		$(this).addClass('disabled').siblings('a').addClass('disabled');
		
		var id_usuario = $('#ModalEliminar :hidden').val();
		$.post('<?php echo site_url('evento/usuario/eliminar')?>', { "id_usuario" : id_usuario },
		function()
		{
			$(window).attr('location', '<?php echo site_url('backend/eventos/usuarios') ?>');
		});
	});

	$(document).on('click', '#ModalEliminar a:last', function(e)
	{
		e.preventDefault();
		if ($(this).is('.disabled')) return;
		$('#ModalEliminar').trigger('reveal:close');
	});
});

function getDatos()
{
	var json = "{";
	$('input,textarea').each(function(k, v)
	{
		json += "\""+$(v).attr('name')+"\" : \""+$(v).val()+"\", ";
	});

	return $.parseJSON(json.replace(/\,\s?$/, '')+'}');
}
</script>
