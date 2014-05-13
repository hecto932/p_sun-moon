<script type="text/javascript">
$(document).ready(function()
{	
	//Buscar datos de usuario al introducir cédula, rif o email 
	$('#contacto_cedula').change(function()
	{
		$('.datos_contacto input[name=id_usuario]').remove();
		var _this = $(this);
		var _name = new String(_this.attr('name')).replace(/^contacto_/, '');
		$.post('<?php echo site_url('evento/json/get_usuario')?>',
		{ "cedula" : _this.val() },
		function(json)
		{
			$('.datos_contacto input.error').toggleClass('error').siblings('small.error').remove();
			$('#contacto_rif').val(json.rif);
			$('#contacto_email').val(json.email);
			$('#contacto_nombres').val(json.nombres);
			$('#contacto_apellidos').val(json.apellidos);
			$('#contacto_telefono1').val(json.telefono1);
			$('#contacto_telefono2').val(json.telefono2);
			$('#contacto_direccion').val(json.direccion);

			if (json.id_usuario != null)
			{
				$('.datos_contacto').append('<input type="hidden" name="id_usuario" value="'+json.id_usuario+'">');
				$('#nombre_factura').trigger('change');
			}
		}, 'json');
	});

	//Marcar si persona contacto asiste al evento 
	$('#contacto_asiste').bind('change', function()
	{
		if ($(this).is(':checked'))
			$('#div-desea-hospedaje').show();
		else
			$('#div-desea-hospedaje, #div-contacto-hospedaje').hide();
	});

	//Marcar si persona contacto quiere hospedaje 
	$('#contacto_desea_hospedaje').bind('change', function()
	{
		if ($(this).is(':checked'))
		{
			var div = $('#div-contacto-hospedaje').show();
			var select = div.find('select');

			select.find('option').remove();

			$.post('<?php echo site_url('evento/json/get_hospedaje_disponible') ?>', {"id_evento":"<?php echo $evento->id_evento ?>"},
			function(json)
			{
				select.append('<option value="0">No selecciona</option>');
				$.each(json, function(key, hospedaje)
				{
					select.append('<option value="'+hospedaje.id_hospedaje+'">'+hospedaje.descripcion+' - Bs.F '+hospedaje.precio+'</option>');
				});

				select.trigger('change');
			}, 'json');
		}
		else
			$('#div-contacto-hospedaje').hide();
	});
});
</script>