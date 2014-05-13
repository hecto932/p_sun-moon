<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="http://<?php echo $_SERVER['SERVER_NAME']?>/">
		<meta charset="UTF-8" />
		<title>Correo - Reserva</title>
	</head>
	<body>
		<table>
			<tr>
				
				<td>
					<img src="assets/front/img/template/logo/logonew.png" width="128" />
				</td>
				<td>
					<h2>Reservación</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2" >
					<h2>Datos personales</h2>
				</td>
			</tr>
			<tr>
				<td>
					<p>
						Estimado <b><?php echo $titular_reserva; ?></b> su reserva ha sido registrada exitosamente, en las proximas horas el personal de Sol y Luna
						se pondra en contacto con usted para acordar concretar el pago de la reserva.	
					</p>
				</td>
			</tr>
			<tr>
				<h2>Resumen de reserva</h2>
				<!--
				<td colspan="2"> 
					<p><b>Nombre Completo: </b><?php echo $nombre_completo; ?></p>
					<p><b>Email: </b><?php echo $email; ?></p>
					<p><b>Teléfono: </b><?php echo $telefono; ?></p>
					<p><b>Nacionalidad: </b><?php echo $nacionalidad; ?></p>
					
				</td>
				-->
			</tr>
			<tr>
				<td colspan="2">
					<p><b>Checkin: </b><?php echo $fecha_llegada; ?></p>
					<p><b>Hora de llegada: </b><?php echo $hora_llegada; ?> horas</p>
					<p><b>Checkout: </b><?php echo $fecha_salida; ?></p>
					<p><b>Hora de salida: </b><?php echo $hora_salida; ?> horas</p>
					<p><b>Llegada: </b><?php echo $fecha_llegada; ?></p>
					<p><b>Habitaciones: </b><?php echo $numero_habitaciones; ?></p>
					<p><b>Personas: </b><?php echo $personas; ?></p>
					<p><b>Noches: </b><?php echo $noches; ?></p>
					
					<?php $i=1; ?>
					<?php foreach($habitaciones as $habitacion =>$value): ?>
						<h3>Habitacion <?php echo $i++; ?></h3>
						<p><b>Titular de habitacion:</b> <?php echo $value['nombre_titular']; ?></p>	
						<p><b>Tipo: </b><?php echo $value['tipo']; ?></p>
						<p><b>Descripcion: </b><?php echo $value['tipo_descrip']; ?></p>
						<p><b>Precio por noche: </b><?php echo $value['moneda_abreviado']." ".$value['valor']; ?></p>	
						<?php if($value['peticion']): ?>
							<p><b>Peticion: </b><?php echo $value['peticion']; ?></p>
						<?php endif;?>
					<?php endforeach; ?>
					
					<h3>Precio total: <?php echo $denominacion." ".$precio_total; ?></h3>
					<p><b>Observaciones adicionales: </b><?php if(!empty($observaciones) )echo $observaciones; else echo "Ninguna."; ?></p>				
				</td>
			</tr>
		</table>
	</body>
</html>