		<?php echo (isset($panel_botones) && !empty($panel_botones)) ? $panel_botones : '' ?>
				
		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>
				
				<table class="twelve" border="1">
					<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					<thead>
						<tr>
							<!--
							<th id="codigo" class="col1 <?php echo ( (strpos(uri_string(), 'codigo') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(), 'codigo') != false) ? $url.'/'.$order_by_new : $url.'/'.'codigo/asc', 'Reservación') ?>
							</th>
							-->
							
							<th id="id_reservacion" class="col1 <?php echo ( (strpos(uri_string(), 'id_reservacion') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(), 'id_reservacion') != false) ? $url.'/'.$order_by_new : $url.'/'.'id_reservacion/asc', lang('reservacion')) ?>
							</th>
							
							<th id="cliente" class="col2 <?php echo ( (strpos(uri_string(), 'cliente') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(), 'cliente') != false) ? $url.'/'.$order_by_new : $url.'/'.'cliente/asc', lang('reservacion_cliente')) ?>
							</th>
							
							<th id="creado" class="col3 <?php echo ( (strpos(uri_string(),'creado') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(),'creado') != false) ? $url.'/'.$order_by_new : $url.'/'.'creado/asc', lang('reservacion_creado2'))?>
							</th>
							
							<th id="checkin" class="col4 <?php echo ( (strpos(uri_string(), 'checkin') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'checkin') != false) ? $url.'/'.$order_by_new : $url.'/'.'checkin/asc', lang('reservacion_checkin'))?>
							</th>
							
							<th id="checkout" class="col5 <?php echo ( (strpos(uri_string(), 'checkout') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'checkout') != false) ? $url.'/'.$order_by_new : $url.'/'.'checkout/asc', lang('reservacion_checkout'))?>
							</th>
							
							<th id="estado_reservacion" class="col6 <?php echo ( (strpos(uri_string(), 'estado_reservacion') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'estado_reservacion') != false) ? $url.'/'.$order_by_new : $url.'/'.'estado_reservacion/asc', lang('reservacion_estado'))?>
							</th>
							
							<th id="activo" class="col7 <?php echo ( (strpos(uri_string(), 'activo') != false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor( (strpos(uri_string(), 'activo') != false) ? $url.'/'.$order_by_new : $url.'/'.'activo/asc', lang('reservacion_activo'))?>
							</th>
							
							<th id="ver_reservacion" class="col10">
								<span>  <?php echo lang('listado_ver'); ?> </span>
							</th>
							
							<th id="asignar" class="col11">
								<span>  <?php echo lang('asignacion'); ?> </span>
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
						
						<?php foreach ($reservaciones as $reserva): ?>
							
							<tr>
								<td class="col1" headers="codigo">
									<p>
										<?php echo $reserva->codigo_reserva; ?>
									</p>
								</td>
								
								<td class="col2" headers="ciente">
									<p>
										<?php echo $reserva->cliente; ?>
									</p>
								</td>
								
								<?php list($fecha, $hora) = explode(' ', flip_timestamp($reserva->creado)); ?>
								<td class="col3" headers="creado">
									<p>
										<?php echo $fecha; ?>
									</p>
								</td>
								
								<?php list($fecha, $hora) = explode(' ', flip_timestamp($reserva->checkin)); ?>
								<td class="col4" headers="checkin">
									<p>
										<?php echo $fecha; ?>
									</p>
								</td>
								
								<?php list($fecha, $hora) = explode(' ', flip_timestamp($reserva->checkout)); ?>
								<td class="col5" headers="checkout">
									<p>
										<?php echo $fecha ?>
									</p>
								</td>
								
								<?php
									if($reserva->id_estado_reservacion == 1) $color = lang('reservacion_clr_disponible');
									elseif($reserva->id_estado_reservacion == 2) $color = lang('reservacion_clr_pendiente');
									elseif($reserva->id_estado_reservacion == 3) $color = lang('reservacion_clr_reservado');
									elseif($reserva->id_estado_reservacion == 4) $color = lang('reservacion_clr_checkin');
									elseif($reserva->id_estado_reservacion == 5) $color = lang('reservacion_clr_autocancel');
								?>
								
								<td class="col6" headers="estado_reservacion">
									<p>
										<span class="round label" style=" background-color: <?php echo $color; ?>" ><?php echo $reserva->estado_reservacion; ?></span>
									</p>
								</td>
								
								<td class="col7" headers="activo">
									<p>
										<?php echo $reserva->activo; ?>
									</p>
								</td>

								<td class="col10 last" headers="ver_reservacion">
									<?php
										if($this->session->userdata('idioma') == 'es')
										{
											echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('ficha_url').'_'.lang('reservacion_url').'/'.$reserva->id_reservacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver'), 'class' => 'small button radius wtc'));
										}
										else
										{
											echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/'.$tipo->id_tipo_habitacion, lang('reservacion_list_ver'),array('title'=> lang('reservacion_ficha_ver') , 'class' => 'small button radius wtc'));
										}
									?>
								</td>
								
								<td class="col11 last" headers="asignar">
									<?php
										if($this->session->userdata('idioma') == 'es')
										{
											echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('asignacion_url').'_'.lang('reservacion_url').'/'.$reserva->id_reservacion, lang('asignar'),array('title'=> lang('asignar'), 'class' => 'small button radius wtc'));
										}
										else
										{
											echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/'.$tipo->id_tipo_habitacion, lang('asignar'),array('title'=> lang('asignar') , 'class' => 'small button radius wtc'));
										}
									?>
								</td>
								
								<!--
								<td class="col9" headers="eliminar">
									<p class="centered">
										<?php echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('eliminar_url').'_'.lang('reservacion_url').'/'.$reserva->id_reservacion,'Eliminar',array('title'=>"eliminar reservación", 'class'=>"delete", 'id'=>"icon_eliminar"))?>
									</p>
								</td>
								-->
								
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
