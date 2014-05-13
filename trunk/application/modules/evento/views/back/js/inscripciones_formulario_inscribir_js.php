<script type="text/javascript">
$(document).ready(function()
{
	//HTML formulario asistentes 
	$.template("datosAsistente", <?php echo $datos_asistente ?>);
	var totalAsistentes = 0;
	var asistentesAgregados = Array();

	//Botón agregar asistentes 
	$('#agregar_asistente').bind('click', function(e)
	{
		e.preventDefault();
		totalAsistentes++;
		var nuevoAsistente = pickAsistente(asistentesAgregados);
		$.tmpl('datosAsistente',{ 'Asistente' : nuevoAsistente }).appendTo('#asistentes');
		$(window).attr('location', '#asistente_'+nuevoAsistente);
		$('#asistentes div.asistente:last select').foundationCustomForms();
		$('#asistentes div.asistente:last input:first').focus();
		asistentesAgregados[asistentesAgregados.length] = nuevoAsistente;
	});

	//Botón eliminar asistente 
	$('#asistentes').on('click', 'a.eliminar_asistente', function(e)
	{
		e.preventDefault();
		totalAsistentes--;
		var numeroAsistente = parseInt(new String($(this).parents('.asistente').find('input.cedula').attr('name')).replace(/^cedula_/, ''));
		asistentesAgregados.splice(asistentesAgregados.indexOf(numeroAsistente), 1);

		$(this).parents('.asistente').remove();
		$(window).attr('location', '#agregar_asistente');
		$('#agregar_asistente').focus();
	});

	//Tab inscribir asistentes 
	$('a[href=#inscribir]').bind('click', function(e)
	{
		setTimeout(function(){ $('#contacto_cedula').focus(); }, 150);
	});

	//Agregar nueva cédula, rif o email 
	$('#asistentes').on('change', 'input.cedula', function()
	{
		var _this = $(this);
		var _name = new String(_this.attr('name'));
		var _parent = $(this).parents('div.asistente');
		$.post('<?php echo site_url('evento/json/get_usuario')?>',
		{ "cedula" 	: _this.val() },
		function(json)
		{
			_parent.find('input.error').toggleClass('error').siblings('small.error').remove();
			_parent.find('input.rif').val(json.rif);
			_parent.find('input.email').val(json.email);
			_parent.find('input.nombres').val(json.nombres);
			_parent.find('input.apellidos').val(json.apellidos);
			_parent.find('input.telefono1').val(json.telefono1);
			_parent.find('input.telefono2').val(json.telefono2);
			_parent.find('textarea.direccion').val(json.direccion);
		}, 'json');
	});

	//Agregar nuevo rif de empresa 
	$('.datos_facturacion').on('change', '.datos_empresa input[name=empresa_rif]', function()
	{
		_this = $(this);
		_parent = $(this).parents('.datos_empresa');

		$.post('<?php echo site_url('evento/json/get_empresa') ?>', { "rif" : _this.val() },
		function(json)
		{
			_parent.find('input.error').toggleClass('error').siblings('small.error').remove();
			_parent.find('input[name=empresa_razon_social]').val(json.razon_social);
			_parent.find('input[name=empresa_email]').val(json.email);
			_parent.find('input[name=empresa_telefono1]').val(json.telefono1);
			_parent.find('input[name=empresa_telefono2]').val(json.telefono2);
			_parent.find('textarea[name=empresa_direccion]').val(json.direccion);
		}, 'json');
	});

	//Marcar que desea hospedaje 
	$('#asistentes').on('change', 'input.desea_hospedaje', function()
	{
		if ($(this).is(':checked'))
		{
			var div = $(this).parent().parent().parent().siblings('.hospedaje').show();
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
		{
			$(this).parent().parent().parent().siblings('.hospedaje').hide();
		}
	});

	//Arma datos de los formularios para enviar por POST 
	function getDatos()
	{
		var json = "{ \"total_asistentes\" : \""+totalAsistentes+"\", \"modo_factura\" : \""+$('#modo_factura').val()+"\", \"nombre_factura\" : \""+$('#nombre_factura').val()+"\", \"id_empresa\" : \""+$('#id_empresa').val()+"\", ";
		json += "\"id_evento\" : \"<?php echo $evento->id_evento ?>\", ";

		//Datos de contacto y asistentes 
		$('div.datos_contacto input, div.datos_contacto textarea, div.datos_contacto select, div#asistentes input, div#asistentes textarea, div#asistentes select')
		.each(function()
		{ json += "\""+$(this).attr('name')+"\" : \""+($(this).attr('type')!=null && $(this).attr('type')=='checkbox' ? $(this).attr('checked')=='checked' : $(this).val())+"\", " });

		//Datos de empresa 
		if ($('#nombre_factura').val() == 1 && $('#id_empresa').val() == 0)
		{
			$('div.datos_empresa input, div.datos_empresa textarea')
			.each(function()
			{ json += "\""+$(this).attr('name')+"\" : \""+($(this).attr('type')!=null && $(this).attr('type')=='checkbox' ? $(this).attr('checked')=='checked' : $(this).val())+"\", " });
		}
		
		return $.parseJSON(json.replace(/\,\s$/,"")+" }");
	}

	//Boton aceptar 
	$('#boton_aceptar').bind('click', function(e)
	{
		e.preventDefault();

		//Obtener datos del formulario 
		var formData = getDatos();

		if (formData.total_asistentes > 0 || (formData.total_asistentes == 0 && formData.contacto_asiste == 'true'))
		{
			//Borrar estilos de error 
			$('input.error').removeClass('error');
			$('small.error').remove();

			//Deshabilitar inputs 
			$('input, textarea, select').attr('disabled','disabled');
			$(this).toggleClass('disabled').siblings('a.button').toggleClass('disabled');

			//Mostrar mensaje cargando 
			$('#div-cargando').fadeIn();
			
			//Enviar datos 
			$.post('<?php echo site_url('evento/inscripcion/inscribir') ?>',
			formData,
			function(json)
			{
				// alert(json);
				if (json.sin_errores == null)
				{
					//Quitar mensaje cargando 
					$('#div-cargando').fadeOut();
	
					//Mostrar errores 
					$.each(json, function(campo, error)
					{
						$('input[name="'+campo+'"]').addClass('error').after('<small class="error">'+error+'</small>');
					});
	
					//Habilitar inputs nuevamente 
					$('input, textarea, select').removeAttr('disabled');
					$('#boton_aceptar').toggleClass('disabled').siblings('a.button').toggleClass('disabled');
	
					//Focus en primer error 
					$('input.error:first').focus();
				}
				else
				{
					$(window).attr('location', '<?php echo site_url('backend/eventos/inscripciones/'.$evento->id_evento) ?>');
				}
			}, 'json');
		}
		else
		{
			alert('No ha agregado ningún asistente al evento.');
			setTimeout(function(){ $('#agregar_asistente').focus(); }, 100);
		}
	});
});

function pickAsistente(array)
{
	for (i = 1; ;i++)
	{
		if (array.indexOf(i) == -1)
			return i;
	}
}
</script>