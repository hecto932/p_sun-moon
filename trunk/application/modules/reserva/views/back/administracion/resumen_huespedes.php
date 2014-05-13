<script>
	$(function(){
		//Datepicker
		$('.filtro_fecha').datepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha_filtro');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abrv');?>", "<?php echo lang('datapicker_dia_lunes_abrv');?>", "<?php echo lang('datapicker_dia_martes_abrv');?>", "<?php echo lang('datapicker_dia_miercoles_abrv');?>",  "<?php echo lang('datapicker_dia_jueves_abrv');?>", "<?php echo lang('datapicker_dia_viernes_abrv');?>", "<?php echo lang('datapicker_dia_sabado_abrv');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"]
		});
		//Antes
		$('.antes').click(function(e)
		{
			e.preventDefault();
			$('input[name="filtro_nav"]').val('antes');
			$('form[name="filtrar"]').submit();
		});
		//Despues
		$('.despues').click(function(e)
		{
			e.preventDefault();
			$('input[name="filtro_nav"]').val('despues');
			$('form[name="filtrar"]').submit();
		});
		//Consultar
		$('.consultar_fecha').click(function(e)
		{
			e.preventDefault();
			$('input[name="filtro_nav"]').val('');
			$('form[name="filtrar"]').submit();
		});
	});
</script>

<div class="row">
	<div class="twelve columns">

		<?php //if(isset($breadcrumbs)): ?><?php //echo $breadcrumbs; ?><?php //endif; ?>
		
		<?php echo form_open('backend/reservaciones/resumen', array('id' => "gen_form", 'class' => 'custom', 'name' => 'filtrar')) ?>
			<input type="hidden" name="filtro_nav" value="" ></input>
			<ul class="block-grid">
			  <li><button class="small button radius wtc antes"> < </button></li>
			  <li><input type="text" name="filtro_fecha"  class="filtro_fecha" value="<?php echo $filtro_fecha; ?>" readonly style="height: 28px;" ></input></li>
			  <li style="padding-right: 15px;"><button class="small button radius wtc despues"> > </button></li>
			  <li><button class="small button radius wtc consultar_fecha"> Consultar fecha </button></li>
			</ul>
		</form>
		<!--
		<?php echo form_open('backend/reservaciones/resumen', array('id' => "gen_form", 'class' => 'custom', 'name' => 'filtrar')) ?>
			<input type="hidden" name="filtro_nav" value="" ></input>
			<span class="one columns"><button class="small button radius wtc antes"> < </button></span>
			<span class="three columns"><input type="text" name="filtro_fecha"  class="filtro_fecha" value="<?php echo $filtro_fecha; ?>" readonly ></input></span>
			<span class="one columns"><button class="small button radius wtc despues"> > </button></span>
			<span class="seven columns"><button class="small button radius wtc consultar_fecha"> Consultar fecha </button></span>
		</form> -->
		
		<hr />
		<h5 style="color: #575757;"><?php echo lang('reservacion_resumen_huespedes'); ?></h5>
		<hr />
		
		<table class="twelve" border="1">
			<thead>
				<tr>
					<th id="codigo_reserva" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion') ?></th>
					<th id="nombre" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_cliente') ?></th>
					<th id="checkin" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_checkin') ?></th>
					<th id="checkout" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_checkout') ?></th>
					<th id="personas" class="col1" style="color: #00B2BF;"><?php echo lang('personas') ?></th>
					<th id="nacionalidad" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_nacionalidad') ?></th>
					<th id="habitaciones" class="col1" style="color: #00B2BF;"><?php echo lang('habitaciones') ?></th>
					<th id="ver_reservacion" class="col10"><span>  <?php echo lang('listado_ver'); ?> </span></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php if(!empty($listado)): ?>
				
					<?php $i=1; ?>
					<?php foreach ($listado as $huesped): ?>
						<tr>
							<td class="col1" headers="codigo_reserva"><p><?php echo $huesped->codigo_reserva; ?></p></td>
							<td class="col2" headers="nombre"><p><?php echo $huesped->nombre; ?></p></td>
							<?php list($fecha, $hora) = explode(' ', flip_timestamp($huesped->checkin)); ?>
							<td class="col4" headers="checkin"><p><?php echo $fecha; ?></p></td>
							<?php list($fecha, $hora) = explode(' ', flip_timestamp($huesped->checkout)); ?>
							<td class="col5" headers="checkout"><p><?php echo $fecha ?></p></td>
							<td class="col6" headers="personas"><p><?php echo $huesped->personas; ?></p></td>
							<td class="col7" headers="nacionalidad"><p><?php echo $huesped->nacionalidad; ?></p></td>
							<td class="col8" headers="habitaciones"><p><?php echo $huesped->habitaciones; ?></p></td>
							<td class="col10 last" headers="ver_reservacion">
								<?php echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$huesped->id_reservacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver'), 'class' => 'small button radius wtc')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				
				<?php else: ?>
					<tr>
						<td colspan="10"><div class="alert-box secondary"><?php echo lang('reservacion_resumen_no_huesped'); ?></div></td>
					</tr>
				<?php endif; ?>
			</tbody>
				
		</table>
		
		<h5 style="color: #3E77A8;"><?php echo lang('reservacion_resumen_reservadas'); ?></h5>
		<hr />
		
		<table class="twelve" border="1">
			<thead>
				<tr>
					<th id="codigo_reserva" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion') ?></th>
					<th id="nombre" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_cliente') ?></th>
					<th id="checkin" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_checkin') ?></th>
					<th id="nacionalidad" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_nacionalidad') ?></th>
					<th id="habitaciones" class="col1" style="color: #00B2BF;"><?php echo lang('habitaciones') ?></th>
					<th id="telefono" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_telefono') ?></th>
					<th id="ver_reservacion" class="col10"><span>  <?php echo lang('listado_ver'); ?> </span></th>
				</tr>
			</thead>
			
			<tbody>
				<?php if(!empty($reservadas)): ?>
					<?php $i=1; ?>
					<?php foreach ($reservadas as $cliente): ?>
						<tr>
							<td class="col1" headers="codigo_reserva"><p><?php echo $cliente->codigo_reserva; ?></p></td>
							<td class="col2" headers="nombre"><p><?php echo $cliente->nombre; ?></p></td>
							<?php list($fecha, $hora) = explode(' ', flip_timestamp($cliente->checkin)); ?>
							<td class="col3" headers="checkin"><p><?php echo $fecha ?></p></td>
							<td class="col4" headers="nacionalidad"><p><?php echo $cliente->nacionalidad; ?></p></td>
							<td class="col5" headers="habitaciones"><p><?php echo $cliente->habitaciones; ?></p></td>
							<td class="col6" headers="habitaciones"><p><?php echo $cliente->telefono; ?></p></td>
							<td class="col10 last" headers="ver_reservacion">
								<?php echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$cliente->id_reservacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver'), 'class' => 'small button radius wtc')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				
				<?php else: ?>
					<tr>
						<td colspan="10"><div class="alert-box secondary"><?php echo lang('reservacion_resumen_no_reservas'); ?></div></td>
					</tr>
				<?php endif; ?>
				
			</tbody>
				
		</table>

		<h5 style="color: #B3273A;"><?php echo lang('reservacion_resumen_pendiente'); ?></h5>
		<hr />
		
		<table class="twelve" border="1">
			<thead>
				<tr>
					<th id="codigo_reserva" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion') ?></th>
					<th id="nombre" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_cliente') ?></th>
					<th id="checkin" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_checkin') ?></th>
					<th id="nacionalidad" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_nacionalidad') ?></th>
					<th id="habitaciones" class="col1" style="color: #00B2BF;"><?php echo lang('habitaciones') ?></th>
					<th id="telefono" class="col1" style="color: #00B2BF;"><?php echo lang('reservacion_telefono') ?></th>
					<th id="ver_reservacion" class="col10"><span>  <?php echo lang('listado_ver'); ?> </span></th>
				</tr>
			</thead>
			
			<tbody>
				<?php if(!empty($pendientes)):?>
					
					<?php $i=1; ?>
					<?php foreach ($pendientes as $pendiente): ?>
						<tr>
							<td class="col1" headers="codigo_reserva"><p><?php echo $pendiente->codigo_reserva; ?></p></td>
							<td class="col2" headers="nombre"><p><?php echo $pendiente->nombre; ?></p></td>
							<?php list($fecha, $hora) = explode(' ', flip_timestamp($pendiente->checkin)); ?>
							<td class="col3" headers="checkin"><p><?php echo $fecha ?></p></td>
							<td class="col4" headers="nacionalidad"><p><?php echo $pendiente->nacionalidad; ?></p></td>
							<td class="col5" headers="habitaciones"><p><?php echo $pendiente->habitaciones; ?></p></td>
							<td class="col6" headers="habitaciones"><p><?php echo $pendiente->telefono; ?></p></td>
							<td class="col10 last" headers="ver_reservacion">
								<?php echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$pendiente->id_reservacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver'), 'class' => 'small button radius wtc')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				
				<?php else: ?>
					<tr>
						<td colspan="10"><div class="alert-box secondary"><?php echo lang('reservacion_resumen_no_pendiente'); ?></div></td>
					</tr>
				<?php endif; ?>
				
			</tbody>
		</table>
		
		
	</div>
</div>

<!--
<div class="row">
	<div class="twelve columns pagination-centered">
		<?php echo $pagination?>
	</div>
</div>
-->