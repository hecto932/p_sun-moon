<script type="text/javascript">

	$(function(){
		
		//Reload
		get_hab_disponibles();
		
		//datepicker format
		$('.checkin').datepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
		
		//datepicker format
		$('.checkout').datepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
		
		$('.checkin').change(function()
		{
			get_hab_disponibles();
		});
		
		$('.checkout').change(function()
		{
			get_hab_disponibles();
		});
		
		function get_hab_disponibles()
		{
			var cin = $('.checkin').val();
			var cout = $('.checkout').val();
			
			if(cin.length > 0 && cout.length > 0)
			{
				$.ajax({
				type: 		'POST',
				dataType: 	'html',
				url: 		'<?php echo site_url('reserva/reserva/ajax_get_disponibles_tipo_habitacion'); ?>',
				data: 		{ 'in' : cin, 'out' : cout},
				success: 	function(html)
							{
								$('#tabla_disponibles').html('');
								$('#tabla_disponibles').html(html);
								
								//Validar email
								$('input[name="email"]').focusout(function()
								{
									//var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
						    		//var emailblockReg = /^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/;
						    		var validemail = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
						    		var emailaddressVal = $(this).val();
						    		
						    		if( (emailaddressVal == '') || (!validemail.test(emailaddressVal)) )
						    		{
						    			$(this).siblings('label').children('span').after('<span class="error" style="color: red"> (Inválido)</span>');
						    		}
								}).focusin(function()
								{
									$('input[name="email"]').siblings('label').children('.error').remove();
								});
								
								//Validar Telefono
								$('input[name="telefono"]').keydown(function(event){
							        //backspace, delete, tab, escape, enter and .
							        if ($.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
							            											/*Ctrl+A*/ (event.keyCode == 65 && event.ctrlKey === true) || 
							            							/*home, end, left, right*/ (event.keyCode >= 35 && event.keyCode <= 39)){
										//let it happen, don't do anything
										return;
							        }
							        else{
							            // Ensure that it is a number and stop the keypress
							            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )){
							                event.preventDefault(); 
							            }
							        }
							    });
								
								//Required
								var requerido = '<?php echo lang('reservacion_requerido'); ?>';
								
								$('input[name="nombre"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('input[name="nombre"]').siblings('label').children('.error').remove();
								});
								$('input[name="password"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('input[name="password"]').siblings('label').children('.error').remove();
								});
								$('input[name="aerolinea"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('input[name="aerolinea"]').siblings('label').children('.error').remove();
								});
								$('input[name="telefono"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('input[name="telefono"]').siblings('label').children('.error').remove();
								});/*
								$('input[name="email"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> (Requerido)</span>');
								}).focusin(function(){
									$('input[name="email"]').siblings('label').children('.error').remove();
								});*/
								$('#direccion').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('#direccion').siblings('label').children('.error').remove();
								});
								$('input[name="nacionalidad"]').focusout(function(){
									if($(this).val() == '') $(this).siblings('label').children('span').after('<span class="error" style="color: red"> '+requerido+'</span>');
								}).focusin(function(){
									$('input[name="nacionalidad"]').siblings('label').children('.error').remove();
								});
								
								//Huespedes
								$('.habitacion').change(function()
								{
									//Id tipo habitacion
									var name = $(this).attr('name');
									var clean1 = name.split('[');
									var clean2 = clean1[1].split(']');
									var id_tipo_habitacion = clean2[0];
									
									//Cantidad
									var cantidad = $(this).val();
									var cantidad = cantidad.split('_');
									var cantidad = cantidad[0];
									
									//Borrar huespedes anteriores
									$(this).parent().parent().siblings('.add_huesped_'+id_tipo_habitacion).remove();
									
									//Add huesped
									for(var i = 1; i <= cantidad; i++)
									{
										$(this).parent().parent().after(
														'<div class="row add_huesped_'+id_tipo_habitacion+'">'+
															'<div class="two columns">' +
																'<select name="tratamiento_huesped['+id_tipo_habitacion+'_'+i+']">' +
																	'<option value="Sr.">' + '<?php echo lang('tratamiento_sr'); ?>' + '</option>' +
																	'<option value="Srta.">' + '<?php echo lang('tratamiento_srta'); ?>' + '</option>' +
																	'<option value="Sra.">' + '<?php echo lang('tratamiento_sra'); ?>' + '</option>' +
																'</select>' +
															'</div>' +
															'<div class="ten columns">' +
																'<input type="text" name="huesped['+id_tipo_habitacion+'_'+i+']" value="" />' +
															'</div>' +
														'</div>');
									}
								});
								
								//Set Values
								$('.tratamiento').val('<?php echo $value_tratamiento?>');
								$('input[name="nombre"]').val('<?php echo $value_nombre?>');
								$('input[name="email"]').val('<?php echo $value_email?>');
								$('input[name="password"]').val('<?php echo $value_password?>');
								$('input[name="aerolinea"]').val('<?php echo $value_aerolinea?>');
								$('input[name="nacionalidad"]').val('<?php echo $value_nacionalidad?>');
								$('.id_pais').val('<?php echo (!empty($value_pais)) ? $value_pais : 239 ?>');
								$('.id_tipo_forma_pago').val('<?php echo $value_pago?>');
								$('input[name="telefono"]').val('<?php echo $value_telefono?>');
								$('#direccion').html('<?php echo $value_direccion?>');
							}
				});
			}
		}
		
	});

</script>

<div class="row">
	<div class="twelve columns">
		
		<?php echo (isset($panel_botones) && !empty($panel_botones)) ? $panel_botones : '' ?>
		
		<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>
		
		<h5 style="color: #575757;">Fecha de estadía</h5><hr>
		
		<form method="POST" class="custom" id="ajax_form">
			<div class="row">
				<!-- IN -->
				<div class="one column">
		        	<label class="inline" for="checkin"><span> <?php echo lang('reservacion_checkin'); ?> </span></label>
		        </div>
	        	<div class="five columns">
	        		<?php $temp1 = (isset($checkin) && !empty($checkin)) ? $checkin : ''; ?>
		        	<input type="text" name="checkin" class="checkin" readonly="readonly" value="<?php echo set_value('checkin', $temp1); ?>" />
	        	</div>
	        	
	        	<!-- OUT -->
	        	<div class="one column">
		        	<label class="inline" for="checkout"><span> <?php echo lang('reservacion_checkout'); ?> </span></label>
		        </div>
	        	<div class="five columns">
	        		<?php $temp2 = (isset($checkout) && !empty($checkout)) ? $checkout : ''; ?>
		        	<input type="text" name="checkout" class="checkout" readonly="readonly" value="<?php echo set_value('checkout', $temp2); ?>" />
	        	</div>
			</div>
			
			<?php if(validation_errors()) echo validation_errors(); ?>
			
			<span id="tabla_disponibles"></span>
			
		</form>
	</div>
</div>
