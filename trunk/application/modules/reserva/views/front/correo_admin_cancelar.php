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
						El usuario <b><?php echo $titular_reserva; ?></b> ha cancelado la reserva correspondiente a la siguiente informacion.
					</p>
				</td>
			</tr>
			<tr>
				<td><h3><?php echo lang('front.correo_usuario_titulo2'); ?></h3></td>
			</tr>
			<tr>
				<td>
					<p><b><?php echo lang('front.correo_usuario_codigo'); ?></b> <?php echo $codigo_reserva;?></p>
					<p><b><?php echo lang('front.correo_usuario_checkin'); ?></b> <?php echo $checkin;?></p>
					<p><b><?php echo lang('front.correo_usuario_checkout'); ?></b> <?php echo $checkout;?></p>
				</td>
			</tr>
		</table>
	</body>
</html>