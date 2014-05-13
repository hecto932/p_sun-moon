<script type="text/javascript">
$(document).ready(function()
{
	$.template('ModalEliminar', '<div id="ModalEliminar" class="reveal-modal large"><input type="hidden" name="id_hospdeaje" value="${id_hospedaje}"><p><i class="foundicon-remove" style="margin-right:6px;"></i>Seguro que desea eliminar esta opción de hospedaje?</p><a href="#" class="button radius alert">Eliminar</a><a href="#" class="button radius wtc" style="margin-left:6px;">Cancelar</a></div>');

	$('table.twelve td a.eliminar').bind('click', function(e)
	{
		e.preventDefault();
		$('#ModalEliminar').remove();
		$(this).closest('.row').after($.tmpl('ModalEliminar', { "id_hospedaje" : $(this).closest('tr').find(':hidden').val() }));
		$('#ModalEliminar').reveal({closeOnBackgroundClick : false});
	});

	$('table.twelve td a.editar').bind('click', function(e)
	{
		e.preventDefault();
		$('a[href=#Agregar]').trigger('click');

		var tds = $(this).closest('tr').find('td');
		var tipoHospedaje = tds.eq(0).text();
		var cantidad = tds.eq(1).text();
		var precio = tds.eq(3).text().replace(/\./, '').replace(/\,00$/, '');

		$('#id_tipo_hospedaje option').each(function(i, v)
		{
			if ($(this).text() == tipoHospedaje)
			{
				$('#id_tipo_hospedaje')[0].selectedIndex = i;
				$('#id_tipo_hospedaje').trigger('change');
			}
		});

		$('#precio').val(precio);
		$('#cantidad').val(cantidad).focus();
	});
	
	$(document).on('click', '#ModalEliminar a:last', function(e)
	{
		e.preventDefault();
		if ($(this).hasClass('disabled')) return;
		$('#ModalEliminar').trigger('reveal:close');
	});

	$(document).on('click', '#ModalEliminar a:first', function(e)
	{
		e.preventDefault();
		
		var _this = $(this);

		if (_this.hasClass('disabled')) return;
		
		_this.toggleClass('alert, disabled');
		$(this).find('+ a').toggleClass('disabled');
		
		$.post('<?php echo site_url('evento/hospedaje/eliminar') ?>',
		{ "id_hospedaje" : _this.siblings(':hidden').val() },
		function() { $(window).attr('location', '<?php echo site_url('backend/eventos/hospedaje/'.$evento->id_evento) ?>') });
	});

	//$('a[href=#Agregar]').bind('click', function()
	//{
		//setTimeout(function()
		//{ $('#id_tipo_hospedaje')[0].selectedIndex = 0; $('#id_tipo_hospedaje').trigger('change'); $('#cantidad, #precio').val(''); }, 100);
	//});

	$('table.twelve tr').bind({
	"mouseenter" : function() { $(this).find('.opciones-hospedaje').show() },
	"mouseleave" : function() { $(this).find('.opciones-hospedaje').hide() } });
});
</script>
