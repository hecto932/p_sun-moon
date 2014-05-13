<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="http://<?php echo $_SERVER['SERVER_NAME']?>/">
		<meta charset="UTF-8" />
		<title><?php echo lang('front.restablecer.correo.title'); ?></title>
	</head>
	<body>
		<table>
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
					<h2><?php echo lang('front.restablecer.correo.titulo'); ?></h2>
				</td>
			</tr>
			<tr>
				<td colspan="2"> 
					<p><?php echo lang('front.restablecer.correo.p1'); ?> <?php echo $nombre_completo;?> <?php echo lang('front.restablecer.correo.p2'); ?></p>
					
					<p><?php echo lang('front.restablecer.correo.p3'); ?> <a href="<?php echo $enlace; ?>"><?php echo lang('front.restablecer.correo.p5'); ?></a> <?php echo lang('front.restablecer.correo.p4'); ?></p>
				</td>
			</tr>
			
		</table>
	</body>
</html>