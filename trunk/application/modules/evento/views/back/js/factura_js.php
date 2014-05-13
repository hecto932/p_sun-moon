<script type="text/javascript">
$(document).ready(function()
{
	$('#factura_anulada').bind('change', function()
	{
		var anular = $(this).is(':checked') ? 1 : 0;
		$.post('<?php echo site_url('evento/factura/anular') ?>', 
		{"id_factura" : "<?php echo $factura->id_factura ?>", "anular" : anular},
		function()
		{
			$('#DatosTab').toggleClass('factura_anulada');
		});
	});

	$('#factura_cancelada').bind('change', function()
	{
		var cancelar = $(this).is(':checked') ? 1 : 0;
		$.post('<?php echo site_url('evento/factura/cancelar') ?>', 
		{"id_factura" : "<?php echo $factura->id_factura ?>", "cancelar" : cancelar});
	});

	<?php if ($factura->anulada): ?>
		$('#DatosTab').toggleClass('factura_anulada');
	<?php endif ?>
});
</script>
