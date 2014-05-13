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
				<td><img src="assets/front/img/template/logo/logonew.png" style="width:200px;" /></td>
				<td>
					<p>
						<?php echo lang('front.correo_usuario_header_p1'); ?>
					</p>
					<p>
						<?php echo lang('front.correo_usuario_header_p2'); ?>
					</p>
					<p>
						<?php echo lang('front.correo_usuario_header_p3'); ?>
					</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" >
					<h2><?php echo lang('front.correo_usuario_titulo1'); ?></h2>
				</td>
			</tr
			<tr>
				<td>
					<p>
						<b><?php echo $titular_reserva; ?></b> ha realizado un pago en la reserva <b><?php echo $codigo_reserva; ?></b> el dia <b><?php echo $fecha_pago; ?></b> por el monto de
						<?php echo $tipo_moneda.' '.$monto; ?>, metodo <b><?php echo $tipo_forma_pago; ?></b>, referencia <b><?php echo $numero_referencia; ?>.</b> 
					</p>
				</td>
			</tr>
		</table>
	</body>
</html>