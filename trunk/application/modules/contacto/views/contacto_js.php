<?php 
				/*	Nomeclatura de script de contacto
				 *	
				 * [campo]_valor: Variable temporal que contiene
				 * 	el valor del input [nombre]_contacto.
				 * 
				 * [nombre]_contacto: Variable post con el valor del input.
				 * 
				 *	Procedimiento: Ingrese las variables pertinentes del formulario
				 *  en la forma anteriormente indicada, envie a la vista la url de la
				 *  función que procesara los datos. 
				 * 
				 *  
				 * 
				 */			
			?>

<script>

	$(document).ready(function(){
		$('button[name=enviar_contacto]').click(function(event){
			$('#zona_mensajes').empty();
			var nombre_valor = $('input[name=nombre_contacto]').val();
			var direccion_valor = $('input[name=direccion_contacto]').val();
			var correo_valor = $('input[name=correo_contacto]').val();
			var ciudad_valor = $('input[name=ciudad_contacto]').val();
			var estado_valor = $('input[name=estado_contacto]').val();
			var postal_valor = $('input[name=postal_contacto]').val();
			var areatexto_valor = $('textarea[name=mensaje_contacto]').val();
			var request = $.ajax({
				url: "<?php echo lang('contacto_url').'/'.lang('procesar_url'); ?>",
				type: "POST",
				dataType: "json",
				data: {nombre_contacto: nombre_valor, direccion_contacto: direccion_valor, correo_contacto: correo_valor, ciudad_contacto: ciudad_valor, estado_contacto: estado_valor, postal_contacto: postal_valor, mensaje_contacto: areatexto_valor},
				success: function(result)
				{
					var titulo = result.titulo;
					var estado = result.estado;
					var mensajes = result.mensajes;
					console.log(mensajes);
					if(titulo == "<?php echo lang('contacto.diag_titF'); ?>"){
						$('#estado_imagen').attr('src', '../../assets/front/img/temp/noenviadoicon.png');
					}
					else{
						$('#estado_imagen').attr('src', '../../assets/front/img/temp/enviadoicon.png');
					}
					$('#titulo_mensaje').text(titulo);					
					$('#texto_mensaje').text(estado);
					if($('#titulo_mensaje').text() == '<?php echo lang("contacto.diag_titF"); ?>'){
						
						$.each(mensajes, function(key, value){
							if(value != ''){
								$('input[name=' + key + '_contacto]').addClass('error');
								$('#zona_mensajes').append('<p>'+ value + '</p>');	
							}
							else{
								if($('input[name=' + key + '_contacto]').hasClass('error'))
								{
									$('input[name=' + key + '_contacto]').removeClass('error');
								}
							}
							
							if(key == 'mensaje'){
								if(value != ''){
									$('textarea[name=mensaje_contacto]').addClass('error');
								}
								else
								{
									if( $('textarea[name=mensaje_contacto]').hasClass('error')){
										$('textarea[name=mensaje_contacto]').removeClass('error');	
									}
								}
							}
						});
					}
					else{
						$.each(mensajes, function(key, value){
							if(key != 'mensaje'){
								
								$('input[name=' + key + '_contacto]').val('');
								if($('input[name=' + key + '_contacto]').hasClass('error')){
									$('input[name=' + key + '_contacto]').removeClass('error');
								}
							}
							else{
								$('textarea[name=mensaje_contacto]').val('');
								if($('textarea[name=mensaje_contacto]').hasClass('error')){
									$('textarea[name=mensaje_contacto]').removeClass('error');
								}
							}
						})
					}
					$('#modal_fin').reveal();
				}
			});
		});
		
		$('#cerrar_fin').click(function(){
			$('#modal_fin').trigger('reveal:close');
		});
		
	});
</script>