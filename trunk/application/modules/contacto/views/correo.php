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
					<h2>Contacto</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2" >
					<h2>Datos personales</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<p><b>Nombre Completo: </b><?php echo $nombre_completo; ?></p>
					<p><b>Email: </b><?php echo $email; ?></p>
					<p><b>Teléfono: </b><?php echo $telefono; ?></p>
					<p><b>Mensaje: </b><?php echo $mensaje; ?></p>				
				</td>
			</tr>
			
		</table>
	</body>
</html>