
<strong><?php echo $tipo_habitacion; ?></strong>

<?php if(!empty($habitaciones_disponibles)): ?>
	<?php echo form_dropdown('habitacion_'.$id_reservacion_tipo_habitacion, $habitaciones_disponibles, set_value('habitaciones', ( isset($habitaciones_selected) ? $habitaciones_selected : 0) ), 'style="width:174px;"' ); ?>
<?php else: ?>
	<span style="color: #C60F13;"><?php echo lang('no_habitacion'); ?></span>
<?php endif; ?>
	
<br /><br /><p><strong>Titular: </strong><?php echo $tratamiento.' '.$nombre; ?></p>

<strong>Peticiones:</strong><p style="font-style: italic;" ><?php echo (!empty($peticiones)) ? $peticiones : 'Sin peticiones'; ?></p>

<?php if(isset($habitacion_asignada) && !empty($habitacion_asignada)): ?>
	<p style="color: #5DA422;"><strong>Asignada: </strong><?php echo $habitacion_asignada; ?></p>
<?php endif; ?>

<hr />

