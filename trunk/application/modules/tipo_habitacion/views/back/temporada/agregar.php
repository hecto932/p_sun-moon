<script type="text/javascript">
	$(function(){
		
		//Formato fecha
		$('.fecha').datepicker({
			changeYear: false,
			dateFormat: "<?php echo lang('datapicker_formato_fecha_temporada');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
		
		//Limpiar fechas
		$('.limpiar').click(function()
		{
			$('input[name="inicio"]').val('');
			$('input[name="fin"]').val('');
		});
	});
</script>

<div class="row">
	<div class="twelve columns">
		<form class="custom" method="POST" action="<?php echo '/'.lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('temporadas_url').'/'.lang('guardar_temporada_url') ?>">
			
			<?php if(isset($datos_temporada)): ?>
				
				<input type="hidden" name="id_temporada_fecha" value="<?php echo $datos_temporada[0]->id_temporada_fecha; ?>" />
				
			<?php endif; ?>
			
			<fieldset>
				<legend><?php echo lang('temporada_agregar')?></legend>
				
				<div class="row six columns">
					
					<div class="row">
						<div class="four columns">
							<label for="temporada" class="inline"><?php echo lang('temporada') ?></label>
						</div>
						<div class="eight columns">
							<?php $temp = (isset($datos_temporada) && !empty($datos_temporada[0]->id_temporada)) ? $datos_temporada[0]->id_temporada : ''; ?>
							<?php echo form_dropdown('id_temporada', $opt_temporada, set_value('id_temporada', $temp), 'class="twelve"')?>
						</div>
					</div>
					
					<div class="row">
						<div class="four columns">
							<label for="inicio" class="inline"><?php echo lang('temporada_inicio'); ?> <span style="font-style: italic;">(dd-mm)</span></label>
						</div>
						<div class="eight columns">
							<?php 
								$temp = (isset($datos_temporada) && !empty($datos_temporada[0]->inicio)) ? $datos_temporada[0]->inicio : '';
								if(!empty($temp)) { list($a, $m, $d) = explode('-', $temp); $temp = $d.'-'.$m; }
							?>
							<?php echo form_input('inicio', set_value('inicio', $temp), 'class="twelve fecha" readonly')?>
						</div>
					</div>
					
					<div class="row">
						<div class="four columns">
							<label for="inicio" class="inline"><?php echo lang('temporada_fin'); ?> <span style="font-style: italic;">(dd-mm)</span></label>
						</div>
						<div class="eight columns">
							<?php
								$temp = (isset($datos_temporada) && !empty($datos_temporada[0]->fin)) ? $datos_temporada[0]->fin : '';
								if(!empty($temp)) { list($a, $m, $d) = explode('-', $temp); $temp = $d.'-'.$m; }
							?>
							<?php echo form_input('fin', set_value('fin', $temp), 'class="twelve fecha" readonly')?>
						</div>
					</div>

				</div>
				
			</fieldset>
			<div class="twelve columns">
				<button type="submit" value="agregar_temporada" class="button radius wtc" id="aceptar"><?php echo lang('aceptar')?></button>
				<button type="button" class="button radius wtc limpiar" ><?php echo lang('limpiar')?></button>
			</div>
		</form>
	</div>
</div>