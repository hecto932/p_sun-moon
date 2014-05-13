		<?php echo (isset($panel_botones) && !empty($panel_botones)) ? $panel_botones : '' ?>
				
		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>
				
				<table class="twelve" border="1">
					<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					<thead>
						<tr>
							<th id="codigo_reserva" class="col1 <?php echo ( (strpos(uri_string(), 'codigo_reserva') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(), 'codigo_reserva') != false) ? $url.'/'.$order_by_new : $url.'/'.'codigo_reserva/asc', lang('codigo')) ?>
							</th>
							
							<th id="cliente" class="col2 <?php echo ( (strpos(uri_string(), 'cliente') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(), 'cliente') != false) ? $url.'/'.$order_by_new : $url.'/'.'cliente/asc', lang('reservacion_cliente')) ?>
							</th>
							
							<th id="fecha_pago" class="col3 <?php echo ( (strpos(uri_string(),'fecha_pago') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(),'fecha_pago') != false) ? $url.'/'.$order_by_new : $url.'/'.'fecha_pago/asc', lang('reservacion_fecha_pago'))?>
							</th>
							
							<!--
							<th id="total_pagar" class="col4 <?php echo ( (strpos(uri_string(), 'total_pagar') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'total_pagar') != false) ? $url.'/'.$order_by_new : $url.'/'.'total_pagar/asc', lang('pagar'))?>
							</th>
							-->
							
							<th id="monto" class="col5 <?php echo ( (strpos(uri_string(), 'monto') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'monto') != false) ? $url.'/'.$order_by_new : $url.'/'.'monto/asc', lang('pagado'))?>
							</th>
							
							<th id="forma_pago" class="col6 <?php echo ( (strpos(uri_string(), 'forma_pago') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'forma_pago') != false) ? $url.'/'.$order_by_new : $url.'/'.'forma_pago/asc', lang('reservacion_forma_pago'))?>
							</th>
							
							<th id="referencia" class="col7 <?php echo ( (strpos(uri_string(), 'referencia') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'referencia') != false) ? $url.'/'.$order_by_new : $url.'/'.'referencia/asc', lang('reservacion_nro_referencia'))?>
							</th>
							
							<th id="confirmado" class="col8 <?php echo ( (strpos(uri_string(), 'confirmado') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'confirmado') != false) ? $url.'/'.$order_by_new : $url.'/'.'confirmado/asc', lang('reservacion_pago_confirmado'))?>
							</th>
							
							<th id="ver_reservacion" class="col10">
								<span>  <?php echo lang('listado_ver'); ?> </span>
							</th>
							
							<th id="asignar" class="col11">
								<span>  <?php echo lang('reservacion_pago_confirmar'); ?> </span>
							</th>
							
							<!--
							<th id="eliminar" class="col9 last">
								<span> <?php echo lang('listado_eliminar'); ?> </span>
							</th>
							-->
						</tr>
						<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					</thead>
						<?php /*-----------------------------------------Inicio Cuerpo----------------------------------------------*/?>
					
					<tbody>
						<?php $i=1; ?>
						
						<?php foreach ($pagos as $pago): ?>
							
							<tr>
								<td class="col1" headers="codigo">
									<p>
										<?php echo $pago->codigo_reserva; ?>
									</p>
								</td>
								
								<td class="col2" headers="cliente">
									<p>
										<?php echo $pago->cliente; ?>
									</p>
								</td>
								
								<?php list($fecha, $hora) = explode(' ', flip_timestamp($pago->fecha_pago)); ?>
								<td class="col3" headers="fecha">
									<p>
										<?php echo $fecha; ?>
									</p>
								</td>
								
								<!--
								<td class="col4" headers="pagar">
									<p>
										<?php echo $pago->total_pagar; ?>
									</p>
								</td>
								-->
								
								<td class="col5" headers="pagado">
									<p>
										<?php echo $pago->monto.' '.$pago->moneda; ?>
									</p>
								</td>
								
								<td class="col6" headers="forma_pago">
									<p>
										<?php echo $pago->forma_pago; ?>
									</p>
								</td>
								
								<td class="col7" headers="referencia">
									<p>
										<?php echo $pago->numero_referencia; ?>
									</p>
								</td>
								
								<?php
									if($pago->confirmado == 0)
									{
										$confirmado = lang('reservacion_pago_pendiente');
										$color = lang('reservacion_clr_pendiente');
										$boton_confirmar = lang('reservacion_pago_confirmar');
									}
									elseif($pago->confirmado == 1)
									{
										$color = lang('reservacion_clr_reservado');
										$confirmado = lang('reservacion_pago_confirmado');
										$boton_confirmar = lang('reservacion_pago_pendiente');
									}
								?>
								
								<td class="col8" headers="estado_reservacion">
									<p>
										<span class="round label" style=" background-color: <?php echo $color; ?>" ><?php echo $confirmado; ?></span>
									</p>
								</td>

								<td class="col10 last" headers="ver_reservacion">
									<?php
										echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$pago->id_reservacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver'), 'class' => 'small button radius wtc'));
									?>
								</td>
								
								<td class="col11 last" headers="asignar">
									<?php
									echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('confirmar_pago_url').'/'.$pago->id_pago, $boton_confirmar,array('class' => 'small button radius wtc'));
									?>
								</td>
								
							</tr>
						<?php endforeach; ?>
					</tbody>
						<?php /*-----------------------------------------Fin Cuerpo----------------------------------------------*/?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>
