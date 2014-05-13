<script type="text/javascript">
$(document).ready(function()
{
	$.template('datosEmpresa', <?php echo $datos_empresa ?>);
	
	//Cambio de modo facturación 
	$('#modo_factura').bind('change', function()
	{
		var _this = $(this);
		//_this.attr('disabled','disabled');
		$('#div-cargando-factura').fadeIn();

		$.post('<?php echo site_url('evento/json/get_nombre_factura') ?>', { modo : _this.val() },
		function(json)
		{
			var nf = $('#nombre_factura');
			nf.find('option').remove();

			for (var i in json)
			{
				nf.append('<option value="'+i+'">'+json[i]+'</option>');
			}

			//_this.removeAttr('disabled');
			$('#div-cargando-factura').fadeOut();

			nf.trigger('change');
		}, 'json');
	});

	//Cambio de nombre de facturación 
	$('#nombre_factura').bind('change', function()
	{
		var _this = $(this);
		var id_usuario = $('.datos_contacto input[name=id_usuario]').val();

		//_this.attr('disabled','disabled');
		$('#seleccionar_empresa').hide();

		if (id_usuario != null && _this.val() == 1)
		{
			$('#div-cargando-factura').fadeIn();
			
			$.post('<?php echo site_url('evento/json/get_empresas_from_usuario')?>', { "id_usuario" : id_usuario },
			function(json)
			{
				var e = $('#id_empresa');
				e.find('option').remove();

				for (var i in json)
				{
					e.append('<option value="'+json[i].id_empresa+'">'+json[i].razon_social+'</option>');
				}
				e.append('<option value="0">Otra Empresa</option>');
				e.trigger('change');
				
				$('#seleccionar_empresa').show();
				//_this.removeAttr('disabled');
				$('#div-cargando-factura').fadeOut();
			}, 'json');
		}
		else if (_this.val() == 1)
		{
			var e = $('#id_empresa');
			e.find('option').remove();
			e.append('<option value="0">Otra Empresa</option>');
			e.trigger('change');

			$('#seleccionar_empresa').show();
			//_this.removeAttr('disabled');
		}
		else
		{
			var e = $('#id_empresa');
			e.find('option').remove();
			e.trigger('change');

			//_this.removeAttr('disabled');
		}
	});

	//Cambio de empresa para factura 
	$('#id_empresa').bind('change', function()
	{
		var _this = $(this);
		$('.datos_empresa').remove();

		if (_this.val() == 0)
		{
			$('#opciones_factura').after($.tmpl('datosEmpresa'));
			$('.datos_empresa input:first').focus();
		}
	});

	//Disparar cambio de modo de facturación
	$('#modo_factura').trigger('change');
});
</script>