<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="http://<?php echo $_SERVER['SERVER_NAME']?>/">
		<meta charset="UTF-8" />
	</head>
	<body>
		<table>
			<!-- 
			<tr>
				
				<td>
					<img src="assets/front/img/template/logo/logonew.png" width="128" />
				</td>
				<td>
					<h2>Reservación</h2>
				</td>
			</tr>
			-->
			<tr>
				<td><img src="assets/front/img/template/logo/logonew.png" style="width:200px;" /></td>
				<td>
					<p>
						<?php echo lang('front.correo_admin_header_p1'); ?>
					</p>
					<p>
						<?php echo lang('front.correo_admin_header_p2'); ?>
					</p>
					<p>
						<?php echo lang('front.correo_admin_header_p3'); ?>
					</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" >
					<h2><?php echo lang('front.correo_usuario_titulo1'); ?></h2>
				</td>
			</tr>
			<tr>
				<td>
					<p>
						<?php echo lang('front.correo_usuario_p1'); ?> <b><?php echo $tratamiento.' '.$titular_reserva; ?></b> <?php echo lang('front.correo_usuario_p2'); ?>
						<br />
						<?php echo lang('front.correo_usuario_p3'); ?>	
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
					<p style="text-decoration: none;"><b><?php echo lang('front.correo_usuario_checkout'); ?></b> <?php echo $checkout;?></p>
					<p><b><?php echo lang('front.correo_usuario_habitaciones'); ?></b> <?php echo $numero_habitaciones;?></p>
					<p><b><?php echo lang('front.correo_usuario_forma_pago'); ?></b> <?php echo $tipo_forma_pago; ?></p>
					<?php if(!empty($observaciones)): ?>
						<p><b><?php echo lang('front.correo_usuario_observaciones'); ?></b> <?php echo $observaciones; ?></p>	
					<?php endif; ?>
					<?php if(isset($password) && !empty($password)): ?>
						<p><b><?php echo lang('front.registro.input_password'); ?></b> <?php echo $password; ?></p>	
					<?php endif; ?>
					
				</td>
			</tr>
			<tr>
				<p>
					<?php echo lang('front.correo_usuario_p4'); ?>	
				</p>
			</tr>
		</table>
	</body>
</html>