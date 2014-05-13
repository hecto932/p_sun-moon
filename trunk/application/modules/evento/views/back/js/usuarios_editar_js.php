<script type="text/javascript">
$(document).ready(function()
{
	$('#aceptar').bind('click', function(e)
	{
		e.preventDefault();

		var _this = $(this);

		if (_this.is('.disabled')) return;
		_this.addClass('disabled').next().addClass('disabled');

		$('input.error').removeClass('error');
		$('small.error').remove();
		$('input,textarea').attr('disabled', 'disabled');
		
		$.post('<?php echo site_url('evento/usuario/agregar')?>', getDatos(),
		function(json)
		{
			if (json.sin_errores == null)
			{
				$.each(json, function(k, v)
				{
					var input = $('input[name='+k+']');
					input.addClass('error').after('<small class="error'+(input.is('.six')?' six':'')+(input.is('.eleven')?' eleven':'')+'">'+v+'</small>');
				});

				$('input,textarea').removeAttr('disabled');
				$('input.error:first').focus();

				_this.removeClass('disabled').next().removeClass('disabled');
			}
			else
			{
				$(window).attr('location', '<?php echo site_url('backend/eventos/usuarios') ?>');
			}
		}, 'json');
	});

	$('#limpiar').bind('click', function(e)
	{
		e.preventDefault();
		if ($(this).is('.disabled')) return;

		$('input,textarea').val('');
		$('input.error').removeClass('error');
		$('small.error').remove();
		$('input:first').focus();
	});

	$(document).on('change', 'input.error', function()
	{
		$(this).removeClass('error').next('small').remove();
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
});
</script>