<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="http://<?php echo $_SERVER['SERVER_NAME']?>/">
		<meta charset="UTF-8" />
		<title>Correo - Reserva</title>
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
					<h2>Bienvenido</h2>
				</td>
			</tr
			<tr>
				<td>
					<p>
						Apreciado (a) Cliente,
						<br />
						<br	/>
						Es un placer darle la bienvenida a Sol y Luna, agradecemos que cuente con nuestro servicio. A traves de nuestra pagina web
						<a href="http://losroquessolyluna.com">http://losroquessolyluna.com</a> podra encontrar todos los servicios que ofrecemos 
						especialmente para usted.			
					</p>
				</td>
			</tr>
		</table>
	</body>
</html>