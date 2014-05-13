<script type="text/javascript">
$(document).ready(function()
{
	function getDatos()
	{
		var json = "{ \"id_evento\" : \"<?php echo $evento->id_evento?>\", ";
		$('.datos_hospedaje input, .datos_hospedaje select').each(function()
		{
			json += "\""+$(this).attr('name')+"\" : \""+$(this).val()+"\", ";
		});
		return $.parseJSON(json.replace(/\,\s?$/, '')+" }");
	}
	
	//Boton de limpiar
	$('#boton_limpiar').bind('click', function(e)
	{
		e.preventDefault();
		$('#precio, #cantidad').val('0');
		$('label.error').removeClass('error');
		$('input.error').removeClass('error');
		$('small.error').remove();
		$('input[name=id_tipo_hospedaje]').focus();
	});

	//Boton de aceptar
	$('#boton_aceptar').bind('click', function(e)
	{
		e.preventDefault();
		var _this = $(this);

		$('#div-cargando').show();

		//Deshabilitar inputs 
		$('.datos_hospedaje input, .datos_hospedaje select').attr('disabled', 'disabled');
		_this.toggleClass('disabled');
		$('#boton_limpiar').toggleClass('disabled');

		$('label.error').removeClass('error');
		$('input.error').removeClass('error');
		$('small.error').remove();
		
		$.post('<?php echo site_url('evento/hospedaje/agregar')?>', getDatos(),
		function(json)
		{
			if (json.sin_errores == null)
			{
				$.each(json, function(input, error)
				{
					$('input[name="'+input+'"]').addClass('error').after('<small class="error">'+error+'</small>')
						.parents('.field').find('label').addClass('error');
				});

				//Habilitar inputs
				$('.datos_hospedaje input, .datos_hospedaje select').removeAttr('disabled');
				_this.toggleClass('disabled');
				$('#boton_limpiar').toggleClass('disabled');

				$('input.error:first').focus();

				$('#div-cargando').fadeOut();
			}
			else
			{
				$(window).attr('location', '<?php echo site_url('backend/eventos/hospedaje/'.$evento->id_evento) ?>');
			}
		}, 'json');
	});
});
</script>