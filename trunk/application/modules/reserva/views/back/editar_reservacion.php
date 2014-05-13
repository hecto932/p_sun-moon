<?php echo (isset($panel_botones) && !empty($panel_botones)) ? $panel_botones : '' ?>

<script type="text/javascript">
	$(function(){

		var checkin 	= $('.checkin');
		var checkout 	= $('.checkout');
		
		checkin.datetimepicker(
		{
			timeFormat: 'HH:mm',
			
			dateFormat: "<?php echo lang('datapicker_formato_reserva');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"],
			
			/*
			onClose: function(dateText, inst)
			{
				if (checkout.val() != '')
				{
					var test_in 	= checkin.datetimepicker('getDate');
					var test_out 	= checkout.datetimepicker('getDate');
					if (test_in > test_out) checkout.datetimepicker('setDate', test_in);
				}
				else
				{
					checkout.val(dateText);
				}
			},
			onSelect: function (selectedDateTime)
			{
				checkout.datetimepicker('option', 'minDate', checkin.datetimepicker('getDate') );
			}
			*/
		});
		
		checkout.datetimepicker(
		{
			timeFormat: 'HH:mm',
			
			dateFormat: "<?php echo lang('datapicker_formato_reserva');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"],
			
			/*
			onClose: function(dateText, inst)
			{
				if (checkin.val() != '')
				{
					var test_in = checkin.datetimepicker('getDate');
					var test_out = checkout.datetimepicker('getDate');
					if (test_in > test_out) checkin.datetimepicker('setDate', test_out);
				}
				else
				{
					checkin.val(dateText);
				}
			},
			onSelect: function (selectedDateTime)
			{
				checkin.datetimepicker('option', 'maxDate', checkout.datetimepicker('getDate') );
			}
			*/
		});
		
		//Chosen
		$('#habitaciones_disponibles').chosen({placeholder_text_multiple: "Seleccionar", width: "100%"});
		
		//Height inicial del input
		$('#div_habitaciones_disponibles').find('.search-field').children('input').css('height', '25px');
		
		//Vaciar un select
		function vaciarCombo(combo)
		{
			while (combo.length > 0) combo.remove(combo.length-1);
		}
		
		$('.checkin').focusout(function()
		{
			get_hab_disponibles();
		});
		
		$('.checkout').focusout(function()
		{
			get_hab_disponibles();
		});
		
		function get_hab_disponibles()
		{
			var habitaciones 	= document.getElementById('habitaciones_disponibles');
			var cin 			= $('.checkin').val();
			var cout 			= $('.checkout').val();
			var id_reservacion 	= $('input[name="id_reservacion"]').val();
			
			vaciarCombo(habitaciones);
			$(habitaciones).trigger("chosen:updated");
			
			if(cin.length > 0 && cout.length > 0)
			{
				$.ajax({
				type: 		'POST',
				dataType: 	'json',
				url: 		'<?php echo site_url('reserva/reserva/ajax_get_habitaciones_disponibles'); ?>',
				data: 		{ 'in' : cin, 'out' : cout, 'id_reservacion' : id_reservacion},
				success: 	function(json)
							{
								if(json.length > 0)
								{
									//Llenar
									for (var i = 0; i < json.length; i++)
									{
										habitaciones.options[habitaciones.length] = new Option(json[i].codigo, json[i].id_habitacion);
									}
								}
								
								$(habitaciones).trigger('chosen:updated');
							}
				});
			}
		}
		
	});
</script>
	
	<div class="row">
		<div class="twelve columns">
				<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>

			    <!-- Formulario Crear tipo habitacion -->
			    <?php
			    	echo validation_errors();
			    	if (isset($error)) echo $error;
			    	$id = (isset($reservacion->id_reservacion) ? $reservacion->id_reservacion : '');
			    ?>

			    <?php echo form_open_multipart('/reserva/reserva/create/' . $id, array('id' => "gen_form", 'class' => 'custom')) ?>
			    
			    <?php echo (isset($reservacion) ? '<input type="hidden" name="id_reservacion" value="' . $reservacion->id_reservacion . '" />' : '') ?>
			    
			    <fieldset>
					<div class="row">
						<div class="nine columns centered">
							
							<!-- Activo -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="activo">
						        		<span> <?php echo lang('reservacion_activo'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($reservacion->id_activo)) ? $reservacion->id_activo : ''; ?>
						        	<?php echo form_dropdown('id_activo', $opt_activo, set_value('id_activo', $temp)); ?>
					        	</div>
							</div>
							
							<!-- Estado reservacion -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="estado_reservacion">
						        		<span> <?php echo lang('reservacion_estado_reservacion'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($reservacion->id_estado_reservacion)) ? $reservacion->id_estado_reservacion : ''; ?>
						        	<?php echo form_dropdown('id_estado_reservacion', $opt_est_reservacion, set_value('id_estado_reservacion', $temp)); ?>
					        	</div>
							</div>
							
							<!-- Aerolinea -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="aerolinea">
						        		<span> <?php echo lang('reservacion_aerolinea'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($reservacion->aerolinea) && !empty($reservacion->aerolinea)) ? $reservacion->aerolinea : ''; ?>
						        	<input type="text" name="aerolinea" value="<?php echo set_value('aerolinea', $temp); ?>" />
					        	</div>
							</div>
							
							<!-- Personas -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="reservacion_personas">
						        		<span> <?php echo lang('reservacion_personas'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($reservacion->personas) && !empty($reservacion->personas)) ? $reservacion->personas : ''; ?>
						        	<input type="text" name="personas" value="<?php echo set_value('personas', $temp); ?>" />
					        	</div>
							</div>
							
							<!-- Forma de pago -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="forma_pago">
						        		<span> <?php echo lang('reservacion_forma_pago'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php $temp = (isset($reservacion->id_tipo_forma_pago)) ? $reservacion->id_tipo_forma_pago : ''; ?>
						        	<?php echo form_dropdown('id_tipo_forma_pago', $opt_forma_pago, set_value('id_tipo_forma_pago', $temp)); ?>
					        	</div>
							</div>
							
							<!-- IN -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="checkin">
						        		<span> <?php echo lang('reservacion_checkin'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php 
					        			$temp1 = (isset($reservacion->checkin) && !empty($reservacion->checkin)) ? quitar_seg_timestamp(flip_timestamp($reservacion->checkin)) : '';
					        		?>
						        	<input type="text" name="checkin" class="checkin" readonly="readonly" value="<?php echo set_value('checkin', $temp1); ?>" />
					        	</div>
							</div>
							
							<!-- OUT -->
							<div class="row">
								<div class="three columns">
						        	<label class="inline" for="checkout">
						        		<span> <?php echo lang('reservacion_checkout'); ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
					        		<?php 
					        			$temp2 = (isset($reservacion->checkout) && !empty($reservacion->checkout)) ? quitar_seg_timestamp(flip_timestamp($reservacion->checkout)) : '';
					        		?>
						        	<input type="text" name="checkout" class="checkout" readonly="readonly" value="<?php echo set_value('checkout', $temp2); ?>" />
					        	</div>
							</div>
							
							<!-- Habitaciones -->
							<!--
							<div class="row" id="div_habitaciones_disponibles" >
								<div class="three columns">
						        	<label class="inline" for="habitaciones">
						        		<span> <?php echo 'Habitaciones'; ?> </span>
						        	</label>
						        </div>
					        	<div class="nine columns">
						        	<?php echo form_dropdown('habitaciones[]', $habitaciones_disponibles, set_value('habitaciones[]', ( isset($habitaciones_selected) ? $habitaciones_selected : 0) ), 'data-customforms="disabled" multiple="multiple" id="habitaciones_disponibles" style="width:300px; height:100px;" '); ?>
					        	</div>
							</div>
							-->
							
					        <div class="row">
					        	<div class="twelve columns alinear-derecha">
					        		<button type="submit" class="button radius wtc"><?php echo (isset($reservacion) ? lang('guardar') : lang('crear')) ?></button>
					        	</div>
					        </div>
						</div>
					</div>
			   	</fieldset>
			</form>
			<!-- Formulario Formulario Crear Tipo habitacion cierre -->
		</div>
	</div>
