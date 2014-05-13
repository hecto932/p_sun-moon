<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
	<title><?php echo lang('emailing_bienvenido')?></title>
</head>

<body style="background-color:#ffffff; text-align:center;">

<!--Contenedor -->
<div style="width: 650px; margin-right: auto; margin-left: auto; text-align: left; overflow: hidden; border: 1px solid gray;">

<!--Header -->
	<div style="background: #808285; height: 3px; width: 100%;"> &nbsp; </div>
		<div style="height: 55px; padding: 20px; background: #be1e2d; float: left; width: 100%;">
			<img src="<?php echo base_url();?>assets/front/img/logo.png" alt="Overlay Logo" style="float: left; margin-right:20px">
		</div>
	
	
	<!--Contenido -->	
		<div style="clear: both; height: 100px; background-color: #fff; padding: 20px 0 50px 0;">
			<h1 style="color: #BC1E2D; normal; font-family:Arial, Helvetica, sans-serif; font-size: 20px; text-align: center;">
				<?php echo lang('emailing_mensaje');?>
			</h1>
			<p style="font-family:Arial, Helvetica, sans-serif; margin-left: 25px; font-size:12px; color:#000;">
				<strong><?php echo lang('contacto.emailing.nombre'); ?>:</strong> prueba campos
			</p>
			
			<p style="font-family:Arial, Helvetica, sans-serif; margin-left: 25px; font-size:12px; color:#000;">
				<strong><?php echo lang('contacto.emailing.emailing'); ?>:</strong> prueba campos
			</p>
			
			<?php if(isset($empresa)): ?> 
				<p style="font-family:Arial, Helvetica, sans-serif; margin-left: 25px; font-size:12px; color:#000;">
					<strong><?php echo lang('contacto.emailing.empresa'); ?>:</strong> prueba campos
				</p>
			<?php endif; ?>
			
			<p style="font-family:Arial, Helvetica, sans-serif; margin-left: 25px; font-size:12px; color:#000;"><strong><?php echo lang('contacto.emailing.mensaje'); ?>:</strong> prueba mensaje</p>
		
		<!--Responder Solicitud -->
		<!-- <a href="#" style="clear: both; padding: 10px; font-size:12px; font-family:Arial, Helvetica, sans-serif; text-decoration: none; background: #0e52a0; float: left; color:#fff;" >Responder la solicitud</a> -->
		
		
		
		<!--Datos  -->
		<br/><br/><br/>
		</div><!--Cierra Contenido -->
			<div style = "background: #BC1E2D; height: 20px; width: 100%; ">
				
				<small style="font-size: 11px; font-family:Arial, Helvetica, sans-serif; color: white;">telefono direccion prueba </small>
				<br/>
				
			</div>
			<div style = "background: #808285; height: 25px; width: 100%; border-top: 1px solid white; "> &nbsp; <br/> </div>
	</div><!--Cierra Contenedor -->
</body>
</html>