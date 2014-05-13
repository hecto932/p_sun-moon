<script type="text/javascript">
$(document).ready(function()
{
	function getDatos()
	{
		var json = "{ \"id_factura\":\"<?php echo $factura->id_factura ?>\", ";
		$('input,select').each(function()
		{
			json += "\""+$(this).attr('name')+"\":\""+$(this).val()+"\", ";
		});

		return $.parseJSON(json.replace(/\,\s$/, '')+"}");
	}
	
	$('#aceptar').bind('click', function(e)
	{
		e.preventDefault();

		var _this = $(this);

		$('input.error').removeClass('error');
		$('small.error').remove();

		$.post('<?php echo site_url('evento/factura/agregar_pago') ?>', getDatos(),
		function(json)
		{		
			if (json.sin_errores == null)
			{
				$.each(json, function(i, v)
				{
					$('input[name='+i+']').addClass('error').after('<small class="error">'+v+'</small>');
				});

				$('input.error:first').focus();
			}
			else
			{
				$(window).attr('location', '<?php echo site_url('backend/eventos/facturas/consultar/'.$factura->id_factura) ?>');
			}
		}, 'json');		
	});
});
</script>