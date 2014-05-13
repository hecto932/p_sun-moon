<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ZURBemails</title>
	
<link rel="stylesheet" type="text/css" href="stylesheets/email.css" />

</head>
 
<body bgcolor="#FFFFFF" style="-webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; width: 100%!important; height: 100%; margin:0; padding:0; font-family: helvetica,	 /* Unix+X, MacOS */ sans-serif">


<table class="head-wrap" bgcolor="black" style="width: 100%; text-align: center;">
	<tr>
		<td></td>
		<td class="header container" style="width: 100%; display:block!important;max-width:600px!important;margin:0 auto!important; /* makes it centered */clear:both!important; padding: 5px 0;">
			
				<div class="content">
					<table bgcolor="black">
					<tr>
						<td><img style="max-width: 100%;" src="<?php echo base_url(); ?>assets/front/img/temp/wtclogo.png" /></td>
					</tr>
				</table>
				</div>
				
		</td>
		<td></td>
	</tr>
</table>



<table style="width: 100%;">
	<tr>
		<td></td>
		<td bgcolor="#FFFFFF" style="width: 100%; display:block!important;max-width:600px!important;margin:0 auto!important; /* makes it centered */clear:both!important;">

			<div>
			<table>
				<tr>
					<td>			
						<h3 style="margin-bottom: 20px;"><?php echo lang('contacto.enviar_titulo'); ?> <a style="text-decoration: none; font-weight:bold; color:#0063b0;" href="http://www.wtcvalencia.com"><?php echo lang('contacto.enviar_wtc'); ?></a></h3>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_nombre'); ?></strong><?php echo $nombre; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_direccion'); ?></strong><?php echo $direccion; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_correo'); ?></strong><?php echo $correo; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_ciudad'); ?></strong><?php echo $ciudad; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_estado'); ?></strong><?php echo $estado; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_codpostal'); ?></strong><?php echo $postal; ?></p>
						<p style="line-height:20px; font-size:13px;"><strong><?php echo lang('contacto.enviar_mensaje'); ?></strong><?php echo $mensaje; ?></p>
						<!-- A Real Hero (and a real human being) -->
						<!--<p><img style="max-width: 100%; " src="http://placehold.it/600x300" /></p> /hero -->
						
						<!-- Callout Panel -->
						<p style="padding:15px; background-color:#8bd2f4; margin-bottom: 15px; line-height: 20px;">
							<?php echo lang('contacto.enviar_slogan'); ?> <a style="text-decoration: none; font-weight:bold; color:#0063b0;" href="<?php echo base_url().lang('servicios_wtc_url'); ?>"><?php echo lang('contacto.enviar.conocer'); ?> &raquo;</a>
						</p><!-- /Callout Panel -->												
						<br/>										
						<!-- social & contact -->
						<table width="100%" style="background-color: #ebebeb; ">
							<tr>
								<td>
									
									<!--- column 1 -->
									<table align="left" class="column" style="float:left; padding:10px!important; margin:0 auto; max-width:600px!important; width: 280px;min-width: 279px; float:left;">
										<tr>
											<td>				
												
												<h5 style="font-weight:900; font-size: 16px; line-height: 1.1; margin-bottom:15px; color:#000;"><?php echo lang('contacto.enviar_conectate'); ?></h5>
												<p>
													<a href="#" style="padding: 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center; background-color: #3B5998!important;"><?php echo lang('contacto.enviar.facebook'); ?></a> 
													<a href="#"style="padding: 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center; background-color: #1daced!important;"><?php echo lang('contacto.enviar.twitter'); ?></a> 
													<a href="#" style="padding: 7px;font-size:12px;margin-bottom:10px;text-decoration:none;color: #FFF;font-weight:bold;display:block;text-align:center; background-color: #4875B4!important;"><?php echo lang('contacto.enviar.linkedin'); ?></a></p>
						
												
											</td>
										</tr>
									</table><!-- /column 1 -->	
									
									<!--- column 2 -->
									<table align="left" class="column" style="float:left; padding:10px!important; margin:0 auto; max-width:600px!important; width: 280px;min-width: 279px; float:left;">
										<tr>
											<td>				
																			
												<h5 style="font-weight:900; font-size: 16px; line-height: 1.1; margin-bottom:15px; color:#000;"><?php echo lang('contacto.enviar_info'); ?></h5>												
												<p style="font-size: 13px; line-height: 20px;">
													<?php echo lang('contacto.enviar_dir_wtc'); ?>
													<br/> Email: <strong><a style="font-weight: bold; color: #0063b0;" href="emailto:hseldon@trantor.com"><?php echo lang('contacto.enviar_correo_wtc'); ?></a></strong></p>
                								<p style="font-size: 13px; line-height: 20px;">
                									<?php echo lang('contacto.enviar_tlfA_wtc'); ?><br />
                									<?php echo lang('contacto.enviar_tlfB_wtc'); ?><br />
                								</p>
                
											</td>
										</tr>
									</table><!-- /column 2 -->
									
									<span class="clear"></span>	
									
								</td>
							</tr>
						</table><!-- /social & contact -->
					
					
					</td>
				</tr>
			</table>
			</div>
									
		</td>
		<td></td>
	</tr>
</table>


</body>
</html>