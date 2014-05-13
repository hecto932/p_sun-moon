<?php
	$habitaciones 			= $reservacion;
	$reservacion 			= $reservacion[0];
	$codigos_habitaciones 	= implode(', ', distintos($habitaciones, 'habitacion'))
?>

<h3><?php echo lang('ficha_datos'); ?></h3>

	<div class="ficha_servicio">

		<table style="border: 0px; padding: 3px 3px;" width="100%">
			
			<tr>
				<td width="20%"><i class="foundicon-website"></i> <?php echo lang('reservacion_codigo'); ?>:</td>
				<td><?php echo (!empty($reservacion->codigo_reserva)) ? ucfirst($reservacion->codigo_reserva) : lang('reservacion_no_data'); ?></td>
				
				<?php
					if($reservacion->id_estado_reservacion == 1) $color = lang('reservacion_clr_disponible');
					elseif($reservacion->id_estado_reservacion == 2) $color = lang('reservacion_clr_pendiente');
					elseif($reservacion->id_estado_reservacion == 3) $color = lang('reservacion_clr_reservado');
					elseif($reservacion->id_estado_reservacion == 4) $color = lang('reservacion_clr_checkin');
					elseif($reserva->id_estado_reservacion == 5) $color = lang('reservacion_clr_autocancel');
				?>

				<td width="20%"><i class="foundicon-website"></i> <?php echo lang('reservacion_estado_reservacion'); ?>:</td>
				<td>
					<span class="round label" style=" background-color: <?php echo $color; ?>" >
						<?php echo (!empty($reservacion->estado_reservacion)) ? ucfirst($reservacion->estado_reservacion) : lang('reservacion_no_data'); ?>
					</span>
				</td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_activo'); ?>:</td>
				<td><?php echo (!empty($reservacion->activo)) ? ucfirst($reservacion->activo) : lang('reservacion_no_data'); ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_forma_pago'); ?>:</td>
				<td><?php echo (!empty($reservacion->forma_pago)) ? ucfirst($reservacion->forma_pago) : lang('reservacion_no_data'); ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_creado'); ?>:</td>
				<td><?php echo (!empty($reservacion->creado)) ? flip_timestamp($reservacion->creado) : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_cliente'); ?>:</td>
				<td><?php echo (!empty($reservacion->nombre)) ? ucfirst($reservacion->nombre) : lang('reservacion_no_data') ; ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_personas'); ?>:</td>
				<td><?php echo (!empty($reservacion->personas)) ? ucfirst($reservacion->personas) : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_nacionalidad'); ?>:</td>
				<td><?php echo (!empty($reservacion->nacionalidad)) ? ucfirst($reservacion->nacionalidad) : lang('reservacion_no_data') ; ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_aerolinea'); ?>:</td>
				<td><?php echo (!empty($reservacion->aerolinea)) ? ucfirst($reservacion->aerolinea) : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_telefono'); ?>:</td>
				<td><?php echo (!empty($reservacion->telefono)) ? ucfirst($reservacion->telefono) : lang('reservacion_no_data') ; ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_checkin'); ?>:</td>
				<td><?php echo (!empty($reservacion->checkin)) ? flip_timestamp($reservacion->checkin) : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_email'); ?>:</td>
				<td><?php echo (!empty($reservacion->email)) ? strtolower($reservacion->email) : lang('reservacion_no_data') ; ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_checkout'); ?>:</td>
				<td><?php echo (!empty($reservacion->checkout)) ? flip_timestamp($reservacion->checkout) : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('reservacion_pais'); ?>:</td>
				<td><?php echo (!empty($reservacion->pais)) ? ucfirst($reservacion->pais) : lang('reservacion_no_data') ; ?></td>
			</tr>
			
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('habitaciones'); ?>:</td>
				<td><?php echo (!empty($reservacion->reservadas)) ? $reservacion->reservadas : lang('reservacion_no_data') ; ?></td>
				
				<td><i class="foundicon-website"></i> <?php echo lang('pagar'); ?>:</td>
				<td><?php echo (!empty($reservacion->precio)) ? $reservacion->precio.' '.$reservacion->moneda : lang('reservacion_no_data') ; ?></td>
			</tr>
			
		</table>
	
	</div>

<div class="row">
	<div class="twelve columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('editar_url').'_'.lang('reservacion_url').'/'.$reservacion->id_reservacion, lang('editar_tit_reserva'), array('title'=>'Editar', 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$reservacion->id_reservacion, lang('editar_tit_reserva'), array('title'=>'Editar', 'class' => 'button radius wtc'));
		?>
	</div>
</div>