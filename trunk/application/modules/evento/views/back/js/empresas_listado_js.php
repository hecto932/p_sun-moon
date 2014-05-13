<script type="text/javascript">
$(document).ready(function()
{
	$.template('ModalEliminar', '<div id="ModalEliminar" class="reveal-modal large"><input type="hidden" name="id_empresa" value="${id_empresa}"><h4>Seguro que desea eliminar esta empresa?</h4><a href="#" class="button radius alert">Eliminar</a><a href="#" class="button radius wtc" style="margin-left:6px;">Cancelar</a></div>');
	$.template('InfoEmpresa', 	'<table class="seven"><tbody><tr><td>Razón Social</td><td>${razon_social}</td></tr><tr><td>RIF</td><td>${rif}</td></tr><tr><td>E-Mail</td><td>${email}</td></tr></tbody></table>');
	
	$('table.twelve tr').bind({
		'mouseenter': function()
		{
			$(this).find('.opciones-empresa').show();
		},
		'mouseleave': function()
		{
			$(this).find('.opciones-empresa').hide();
		}
	});

	$('table.twelve td a.eliminar').bind('click', function(e)
	{
		e.preventDefault();
		$('#ModalEliminar').remove();
		var id_empresa = $(this).closest('tr').find(':hidden').val();
		$(this).closest('.row').after($.tmpl('ModalEliminar', {"id_empresa" : id_empresa }));
		$.post('<?php echo site_url('evento/json/get_empresa') ?>', { "id_empresa" : id_empresa },
		function(json)
		{
			$('#ModalEliminar h4').after($.tmpl('InfoEmpresa', json));
		}, 'json');
		$('#ModalEliminar').reveal({ closeOnBackgroundClick : false });
	});

	$(document).on('click', '#ModalEliminar a:first', function(e)
	{
		e.preventDefault();

		if ($(this).is('.disabled')) return;
		$(this).addClass('disabled').siblings('a').addClass('disabled');
		
		var id_empresa = $('#ModalEliminar :hidden').val();
		$.post('<?php echo site_url('evento/empresa/eliminar')?>', { "id_empresa" : id_empresa },
		function()
		{
			$(window).attr('location', '<?php echo site_url('backend/eventos/empresas') ?>');
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
