<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.login.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.login.titulo'); ?></h1>
      	</div>
  	</header>
</div>



<div id="g1-content">
	<div class="g1-layout-inner">
		
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.login.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.login.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item">
   					<a href="<?php echo lang('front.iniciar.sesion_url'); ?>">
   						<?php echo lang('front.login.breadcrumb3'); ?>
   					</a>
   				</li>
   			</ol>
   		</nav>
   		<script src="assets/front/js/jquery/jquery.min.js"></script> 
		<script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#g1-button-23').click(function(){
					$('#error_email').hide();
					$('#error_password').hide();
					var url = "usuarios/usuarios_front/ajax_verificar_sesion";
					$.ajax({
						url:	url,
						type: 	'POST',
						dataType: 'json',
						data: 	$('#form_inicio_sesion').serialize(),
						success: function(json)
						{
							if(json.mensaje == "correcto")
							{
								$('#submit').click();
							}
							else
							{
								if(json.error_email!="")
								{
									$('#error_email').html(json.error_email);
									$('#error_email').show();
								}
								
								if(json.error_password!="")
								{
									$('#error_pass').html(json.error_password);
									$('#error_pass').show();
								}
								
							}
						}
					});
			
				});
				
				
				$('input[name="email"]').focusout(function(){
					if($(this).val()=="")
						$('#error_email').show();
				});
				
				$('input[name="password"]').focusout(function(){
					if($(this).val()=="")
						$('#error_pass').show();
				});
				
				$('input[name="email"]').focusin(function(){
					$('#error_email').hide();
				});
				
				$('input[name="password"]').focusin(function(){
					$('#error_pass').hide();
				});
				
				$( document ).ajaxStart(function() {
					$( "#cargador" ).show();
					$("#pagar").attr("disabled", "disabled");
					$('#pagar').css( "background", "none repeat scroll 0% 0% rgb(153, 153, 153)" );
					$("#g1-button-23").attr("disabled", "disabled");
					$('#g1-button-23').css( "border-color", "rgb(153, 153, 153)" );
					$('#g1-button-23').css( "background-color", "rgb(153, 153, 153)" );
					
				});
				
				$( document ).ajaxStop(function() {
					$( "#cargador" ).hide();
					$("#pagar").removeAttr("disabled");
					$('#pagar').css( "background", "none repeat scroll 0% 0% rgb(31, 180, 218)" );
					$("#g1-button-23").removeAttr("disabled");
					$('#g1-button-23').css( "border-color", "rgb(52, 152, 219)" );
					$('#g1-button-23').css( "background-color", "rgb(52, 152, 219)" );
				});
				
			});
   		</script>
   		
   		
   		
			<div id="content" role="main">
	   			<div class="hide-for-small">
	   				<form id="form_inicio_sesion" action="usuarios/usuarios_front/ajax_iniciar_sesion" method="post">
		   				<div id="inicio-sesion" class="login">
		   					<div class="row">
			   					<div class="large-6 columns">
			   						<legend><?php echo lang('front.login.sub_titulo'); ?></legend>
			   					</div>
			   				</div>
			   				<div class="row">
			   					<div class="large-6 columns">
			   						<label><?php echo lang('front.login.label1'); ?></label>
			   						<input type="email" name="email" value="" />
			   						<?php	if(form_error('email'))
												echo form_error('email');
											else
												echo '<small id="error_email" class="error" style="display:none;height: 23px;">'.lang('front.registro_form_requerido').'</small>';
									?>
			   					</div>
			   					<div class="large-6 columns">
			   						<center>
			   							<p><?php echo lang('front.login_parrafo2'); ?></p>
			   						</center>
			   					</div>
			   				</div>
			   				<div class="row">
			   					<div class="large-6 columns">
			   						<label><?php echo lang('front.login.label2')?></label>
			   						<input type="password" name="password" />
			   						<?php	if(form_error('password'))
												echo form_error('password');
											else
												echo '<small id="error_pass" class="error" style="display:none;height: 23px;">'.lang('front.registro_form_requerido').'</small>';
									?>
			   					</div>
			   					<div class="large-6 columns">
			   						<center>
										<a href="usuarios/facebook_control/login"><img src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_home_url').'/'; ?>webicon-facebook.png" /></a>
										<!-- <a><img src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_home_url').'/'; ?>webicon-twitter.png" /></a> -->
										
									</center>
			   					</div>
			   				</div>
			   				<div class="row">
			   					<div class="large-6 columns">
			   						<button id="submit" type="submit" class="button" style="display: none;"></button>
			   						<a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard"><?php echo lang('front.login.boton1'); ?></a>
			   						<p><a href="<?php echo lang('front.usuarios_front_url').'/'.lang('front.olvidar-contrasena_url');?>"><?php echo lang('front.login_parrafo1'); ?></a></p>
			   					</div>
			   					<div class="large-6 columns">
			   						<center>
			   							<a href="<?php echo lang('front.registro_url'); ?>"><?php echo lang('front.login.p2'); ?></a>
			   						</center>
			   					</div>
			   				</div>   				
			   			</div>
					</form>
					<div id="cargador"></div>
	   			</div>
   		
   		
   			<div class="show-for-small">
   				<form id="form_inicio_sesion" action="usuarios/usuarios_front/ajax_iniciar_sesion" method="post">
	   				<div id="inicio-sesion" class="login">
		   				<div class="row">
		   					<div class="large-6 columns">
		   						<label><?php echo lang('front.login.label1'); ?></label>
		   						<input type="email" name="email" value="" />
		   						<?php	if(form_error('email'))
											echo form_error('email');
										else
											echo '<small id="error_email" class="error" style="display:none;height: 23px;">'.lang('front.registro_form_requerido').'</small>';
								?>
		   					</div>
		   				</div>
		   				<div class="row">
		   					<div class="large-6 columns">
		   						<label><?php echo lang('front.login.label2')?></label>
		   						<input type="password" name="password" />
		   						<?php	if(form_error('password'))
											echo form_error('password');
										else
											echo '<small id="error_pass" class="error" style="display:none;height: 23px;">'.lang('front.registro_form_requerido').'</small>';
								?>
		   					</div>
		   				</div>
		   				<div class="row">
		   					<div class="large-6 columns">
		   						<center>
		   							<button id="submit" type="submit" class="button" style="display: none;"></button>
		   							<a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard"><?php echo lang('front.login.boton1'); ?></a>
		   							<p><a href="<?php echo lang('front.usuarios_front_url').'/'.lang('front.olvidar-contrasena_url');?>"><?php echo lang('front.login_parrafo1'); ?></a></p>
		   						</center>
		   					</div>
		   				</div>
		   				<div class="row">
		   					<div class="large-6 columns">
		   						<center>
		   							<p><?php echo lang('front.login_parrafo2'); ?></p>
		   							<a href="usuarios/facebook_control/login"><img src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_home_url').'/'; ?>webicon-facebook.png" /></a>
									<!-- <a><img src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_home_url').'/'; ?>webicon-twitter.png" /></a> -->
									<!-- <a href="usuarios/google_control/login"><img src="<?php echo lang('img_url').'/'.lang('img_template_url').'/'.lang('img_home_url').'/'; ?>webicon-googleplus.png" /></a> -->
		   						</center>
		   					</div>
		   				</div>  
		   				<div class="row">
		   					<div class="large-6 columns">
		   						<center>
		   							<a href="<?php echo lang('front.registro_url'); ?>"><?php echo lang('front.login.p2'); ?></a>
		   						</center>
		   					</div>
		   				</div> 				
		   			</div>
				</form>
				<div id="cargador"></div>
   			</div>
		
			
		</div>
	</div>
</div>