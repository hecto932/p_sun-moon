<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<title>Correo - Reserva</title>
		
	</head>
	<body>
		<table>
			<tr>
				
				<td>
					<img src="http://posada/assets/front/img/template/logo/logo_new.png" width="128" />
				</td>
				<td>
					<h2>Correo de Reservación</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2" >
					<h2>Datos personaless</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<p><b>Nombre Completo: </b><?php echo $nombre; ?></p>
					<p><b>Email: </b><?php echo $email; ?></p>
					<p><b>Teléfono: </b><?php echo $telefono; ?></p>
					<p><b>Nacionalidad: </b><?php echo $nacionalidad; ?></p>
					
				</td>
			</tr>
			<tr>

				<td colspan="2">
					<h2>Datos de Estadía</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><b>Adultos: </b><?php echo $adultos; ?></p>
					<p><b>Aereolinea: </b><?php echo $aereolinea; ?></p>
					<p><b>Llegada: </b><?php echo $fecha_llegada; ?></p>
					<p><b>Hora de llegada: </b><?php echo $hora_llegada; ?></p>
					<p><b>Salida: </b><?php echo $fecha_salida; ?></p>
					<p><b>Hora de salida: </b><?php echo $hora_salida; ?></p>
					<p><b>Observaciones: </b><?php echo $observaciones; ?></p>				
				</td>
			</tr>
		</table>
	</body>
</html>