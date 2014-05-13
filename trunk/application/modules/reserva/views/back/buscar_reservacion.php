
<script type="text/javascript">
	$(function(){

		var checkin 	= $('.checkin');
		var checkout 	= $('.checkout');
		
		checkin.datepicker(
		{
			timeFormat: 'HH:mm',
			
			dateFormat: "<?php echo lang('datapicker_formato_reserva');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"],
			
		});
		checkout.datepicker(
		{
			timeFormat: 'HH:mm',
			
			dateFormat: "<?php echo lang('datapicker_formato_reserva');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"],

		});
		
		$('.limpiar').click(function()
		{
			checkin.val('');
			checkout.val('');
		});
		
	});
</script>


		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>

				<!-- Formulario Buscar FAQ -->
				<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';

				echo form_open('/backend/reservaciones/listado','id="gen_form" class="custom"');?>
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
							        	<?php echo form_dropdown('id_estado_activo', $opt_activo, set_value('id_activo')); ?>
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
							        	<?php echo form_dropdown('id_estado_reservacion', $opt_est_reservacion, set_value('id_estado_reservacion')); ?>
						        	</div>
								</div>
								
								<!-- Cliente -->
								<div class="row">
									<div class="three columns">
							        	<label class="inline" for="cliente">
							        		<span> <?php echo lang('reservacion_cliente'); ?> </span>
							        	</label>
							        </div>
						        	<div class="nine columns">
							        	<input type="text" name="cliente" value="<?php echo set_value('cliente'); ?>" />
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
							        	<input type="text" name="checkin" class="checkin" readonly="readonly" value="<?php echo set_value('checkin'); ?>" />
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
							        	<input type="text" name="checkout" class="checkout" readonly="readonly" value="<?php echo set_value('checkout'); ?>" />
						        	</div>
								</div>
								
								<div class="row">
									<div class="twelve columns alinear-derecha">
										<button class="button radius wtc" type="submit" style="margin-top:10px"> <?php echo lang('buscar'); ?> </button>
										<button class="button radius secondary limpiar" type="button" style="margin-top:10px"> <?php echo lang('reservacion_limpiar_fechas'); ?> </button>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
					<!-- Formulario Buscar Obra cierre -->
			</div>
		</div>