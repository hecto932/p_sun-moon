<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#add_users').hide();
		$('#factura').hide();

		$('#go_to_add_users').click(function()
		{
			var contacto_asiste = $('input[name=contacto_asiste]:checked').val();
			var cedula = $('input[name=cedula]').val();
			
			if(cedula!='' && ($('input[name=cedula_user0]').val()!=cedula))
			{
				var tlfn = $('input[name=tlfn]').val();
				var nombre1 = $('input[name=nombre1]').val();
				var nombre2 = $('input[name=nombre2]').val();
				var apellido1 = $('input[name=apellido1]').val();
				var apellido2 = $('input[name=apellido2]').val();
				var email = $('input[name=email]').val();
				$('#user0').html('');
				
				$('#user_data').prepend
				(
					'<div id="user0" style="margin-top: 20px" class="custom">'+
		    		'<fieldset>'+
		    			'<legend><?php echo lang('evnt.contacto'); ?></legend>'+
			    		'<div class="six mobile-four columns">'+
							'<input name="cedula_user0" type="text" value="'+cedula+'" />'+
						'</div>'+
						'<div class="six mobile-four columns">'+
							'<input name="tlfn_user0" type="text" value="'+tlfn+'" />'+
					  	'</div>'+
						'<div class="six mobile-four columns">'+
							'<input name="nombre1_user0" type="text" value="'+nombre1+'" />'+
						'</div>'+
						'<div class="six mobile-four columns">'+
							'<input name="nombre2_user0" type="text" value="'+nombre2+'" />'+
						'</div>'+
						'<div class="six mobile-four columns">'+
							'<input name="apellido1_user0" type="text" value="'+apellido1+'" />'+
						'</div>'+
						'<div class="six mobile-four columns">'+
							'<input name="apellido2_user0" type="text" value="'+apellido2+'" />'+
						'</div>'+
						'<div class="twelve mobile-four columns">'+
							'<input name="email_user0" type="email" value="'+email+'" />'+
						'</div>'+
						'<div class="twelve mobile-four columns" style="margin-top: 10px;">'+
							'<label><?php echo lang('evnt.insc_hospedaje'); ?> </label>'+
							'<label for="radio6" class="left" style="margin-right: 15px;" ><input CHECKED value="<?php echo lang('evnt.asistencia_yes'); ?>" name="contacto_asiste" type="radio" id="radio4"><?php echo lang('evnt.asistencia_yes'); ?></label>'+
							'<label for="radio7" class="left"  ><input value="<?php echo lang('evnt.asistencia_no'); ?>" name="contacto_asiste" type="radio" id="radio5"><?php echo lang('evnt.asistencia_no'); ?></label>'+
						'</div>'+
					'</fieldset>'+
			  	'</div>'
				);
			}
			if(cedula!='')
			{
				$('#contact').hide();
		    	$('#factura').hide();
		    	$('#add_users').show();
			}
			//if(contacto_asiste=='No')
			//{
				
				$('#contact').hide();
		    	$('#factura').hide();
		    	$('#add_users').show();
			//}
		});
		
		$('#plus').click(function()
		{
		    var i = $('input[name=add_invitado]').val();
		    i = parseInt(i);
		    i = i+1;
		    if(i<11)
		    {
		    	$('input[name=add_invitado]').val(i);
			    $('#user_data').append
			    (
			    	'<div id="user'+i+'" style="margin-top: 20px">'+
			    		'<fieldset>'+
			    			'<legend><?php echo lang('evnt.invitado'); ?> '+i+'</legend>'+
				    		'<div class="six mobile-four columns">'+
								'<input name="cedula_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_cedula').' *'; ?>" />'+
							'</div>'+
							'<div class="six mobile-four columns">'+
								'<input name="tlfn_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_telefono').' *'; ?>" />'+
						  	'</div>'+
							'<div class="six mobile-four columns">'+
								'<input name="nombre1_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_nombre').' *'; ?>" />'+
							'</div>'+
							'<div class="six mobile-four columns">'+
								'<input name="nombre2_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_nombre').' *'; ?>" />'+
							'</div>'+
							'<div class="six mobile-four columns">'+
								'<input name="apellido1_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_apellido').' *'; ?>" />'+
							'</div>'+
							'<div class="six mobile-four columns">'+
								'<input name="apellido2_user'+i+'" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_apellido').' *'; ?>" />'+
							'</div>'+
							'<div class="twelve mobile-four columns">'+
								'<input name="email_user'+i+'" type="email" placeholder="<?php echo lang('evnt.insc_email').' *'; ?>" />'+
							'</div>'+
							'<div class="twelve mobile-four columns" style="margin-top: 10px;">'+
								'<label><?php echo lang('evnt.insc_hospedaje'); ?> </label>'+
								'<label for="radio6" class="left" style="margin-right: 15px;" ><input CHECKED value="Sí" name="radbutton_hospedaje'+i+'" type="radio" id="radio4">Sí</label>'+
								'<label for="radio7" class="left"  ><input value="No" name="radbutton_hospedaje'+i+'" type="radio" id="radio5">No</label>'+
							'</div>'+
						'</fieldset>'+
				  	'</div>'
			    );
		    }
		    else
		    	$('input[name=add_invitado]').val('10');
		    
		});
		
		$('#minus').click(function()
		{
		    var i = $('input[name=add_invitado]').val();
		    i = parseInt(i);
		    $('#user'+i).remove();
		    i = i-1;
		    if(i<0)
		    	$('input[name=add_invitado]').val('0');
		    else
		    	$('input[name=add_invitado]').val(i);
		});
		
		$('#go_to_factura').click(function()
		{
			$('input[name=rif]').attr('autofocus',true);
		    $('#contact').hide();
	    	$('#add_users').hide();
	    	$('#factura').show();
		});
		
		$('#back_to_contact').click(function()
		{
		    $('#add_users').hide();
		    $('#factura').hide();
		    $('#contact').show();
		});
		
		$('#back_to_users').click(function()
		{
		    $('#factura').hide();
		    $('#contact').hide();
		    $('#add_users').show();
		});
		
		//$("#submit_button").click(function() { submit; });
	});
</script>
<style>
	.steps ul
	{
		list-style:none;
		text-align:center;
	}
	
	.steps ul li
	{
		list-style:none;
		padding:7px 10px;
		border: 3px solid silver;
		display:inline;
		border-radius:7px;
		font-size:12px;
		font-weight:bold;
		margin:0;
		color:silver;
	}
	
	.steps ul li.active
	{
		list-style:none;
		background:silver;
		color:white;
	}
</style>

<!--------------------------------	VISTA EVENTO FORM	-------------------------------->

<div class="100width fondo_registro">
<div class="row">
	
	<div class="two mobile-four columns"></div>
	
	<div class="eight mobile-four columns">
		
		<div class="login_box radius_content margin_registro">
			
			<h2><?php echo lang('evnt.insc_form'); ?></h2>
			<h3><?php echo lang('evnt.certificado'); ?></h3>
			<br /><br />
			<center><h3><strong><?php echo ucwords($detalle_evento->nombre); ?></strong></h3></center>
			
				
			<?php if(isset($form_status) && $form_status=='ERROR') : ?>
				<div style="color: #8A0829; background: #F8E0E0; margin: 15px 0px; padding: 8px 10px">
					<center><h6 style="color: #8A0829;"><?php echo validation_errors(); ?></h6></center>
				</div>
			<?php endif; ?>
			
			
	<form method="post" action="<?php echo base_url().lang('eventos_url').'/'.lang('guardar_url').'_'.lang('inscripcion_url').'/'.$detalle_evento->url; ?>" class="custom">
	
<!--------------------------------	MODAL DE VERIFICACION DE DATOS	-------------------------------->
	<div id="myModal" class="reveal-modal" style="position: absolute; top:110px">
		<center><h2><?php echo lang('evnt.revisar_datos_tit');?></h2></center>
		<p style="margin-top: 20px"><?php echo lang('evnt.revisar_datos_p');?></p>
		<span><?php echo lang('evnt.gracias');?></span>
		
		
		<ul class="button-group round even-2" style="list-style: none; margin: 30px 5px; padding: 5px 5px; margin-left: 25%;">	
			<li>
				<input type="button" style="width: 80px" class="mobile-four button success small close-reveal-modal" value="<?php echo lang('evnt.atras');?>" />
			</li>
			<li><span style="padding-left: 30px;padding-right: 30px;"></span></li>
			<li>
				<input class="mobile-four button success small" style="width: 80px" id="submit_button" type="submit" value="<?php echo lang('evnt.enviar'); ?>">
			</li>
		</ul>
		<a class="close-reveal-modal">&#215;</a>
	</div>

<!----------------------------------------------- DATOS DE CONTACTO Y FACTURACION ------------------------------------------------------>				
		<div id="contact">
			<fieldset>
				<legend><h4 id="datos_personales"><?php echo lang('evnt.datos_contact_fact'); ?></h4></legend>
				<div class="row" style="margin-top: 10px">
					<div class="six mobile-six columns">
						<label><?php echo lang('mem_reg.nacionalidad'); ?></label>
						<label for="radio4" class="left" style="margin-right: 10px;" ><input CHECKED value="<?php echo lang('mem_reg.nacional'); ?>" name="nacionalidad" type="radio" id="radio4"> <?php echo lang('mem_reg.nacional'); ?></label>
						<label for="radio5" class="left"><input value="<?php echo lang('mem_reg.extranjero'); ?>" name="nacionalidad" type="radio" id="radio5"> <?php echo lang('mem_reg.extranjero'); ?></label>
					</div>
					<div class="six mobile-four columns">
						<input name="cedula" type="text" placeholder="<?php echo lang('evnt.insc_cedula').' *'; ?>" value="<?php echo (isset($cedula) && !empty($cedula)) ? $cedula : '';  ?>" autofocus required />
					</div>
					<div class="six mobile-four columns">
						<input name="nombre1" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_nombre').' *'; ?>" value="<?php echo (isset($nombre1) && !empty($nombre1)) ? $nombre1 : ''; ?>" required />
					</div>
					<div class="six mobile-four columns">
						<input name="nombre2" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_nombre').' *'; ?>" value="<?php echo (isset($nombre2) && !empty($nombre2)) ? $nombre2 : ''; ?>" />
					</div>
					<div class="six mobile-four columns">
						<input name="apellido1" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_apellido').' *'; ?>" value="<?php echo (isset($apellido1) && !empty($apellido1)) ? $apellido1 : ''; ?>" required />
					</div>
					<div class="six mobile-four columns">
						<input name="apellido2" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_apellido').' *'; ?>" value="<?php echo (isset($apellido2) && !empty($apellido2)) ? $apellido2 : ''; ?>" />
					</div>
					<div class="six mobile-four columns">
						<input name="email" type="email" placeholder="<?php echo lang('evnt.insc_email').' *'; ?>" value="<?php echo (isset($email) && !empty($email)) ? $email : ''; ?>" required />
					</div>
					<div class="six mobile-four columns">
						<input name="tlfn" type="text" placeholder="<?php echo lang('evnt.insc_telefono').' *'; ?>" value="<?php echo (isset($tlfn) && !empty($tlfn)) ?  $tlfn : ''; ?>" required />
					</div>
					<!--<div class="twelve mobile-four columns" style="margin-top: 10px;margin-left: 5px">
						<label><?php echo lang('evnt.asistencia_contact'); ?></label>
						<label for="radio6" class="left" style="margin-right: 15px;" ><input CHECKED value="<?php echo lang('evnt.asistencia_yes'); ?>" name="contacto_asiste" type="radio" id="radio4"> <?php echo lang('evnt.asistencia_yes'); ?></label>
						<label for="radio7" class="left"  ><input value="<?php echo lang('evnt.asistencia_no'); ?>" name="contacto_asiste" type="radio" id="radio5"> <?php echo lang('evnt.asistencia_no'); ?></label>
					</div>-->
				</div>
			</fieldset>
			<small><p><?php echo lang('evnt.nota').' '.lang('evnt.datos_prop'); ?></p></small>
			<input type="button" class="button small right" id="go_to_add_users" style="margin-bottom: 0px;margin: 10px 10px;" value="<?php echo lang('continuar'); ?>" />
			<div class="steps" style="margin-top: 70px">
				<ul>
					<li class="active">1</li>
					<li>2</li>
					<li>3</li>
				</ul>
			</div>
		</div>
		
<!----------------------------------------------- DATOS DE USUARIOS ASISTENTES AL EVENTO ------------------------------------------------------> 
		<div id="add_users">
			<fieldset>
				<legend><h4 id="datos_profesionales"><?php echo lang('evnt.add_user'); ?></h4></legend>
				
				<div class="row">
					<div class="five mobile-four columns"></div>
					<input type="button" style="width: 30px; height: 30px;" class="one mobile-four column small button" id="minus" value=" - " />
					<input style="text-align: center;" class="one mobile-four column" type="text" name="add_invitado" value="<?php echo (isset($add_invitado) && !empty($add_invitado)) ? $add_invitado : '0'; ?>" readonly />
					<input type="button" style="width: 30px; height: 30px;" class="one mobile-four column small button" id="plus" value=" + " />
					<div class="five mobile-four columns"></div>
				</div>
				
				<div class="row" style="margin-top: 10px">
					<!--DIV user_data SE LLENA CON JQUERY-->
					<div style="margin-top: 60px" id="user_data">
						
						<!--SI HUBO UN ERROR SE LLENA AQUI CON LOS DATOS ANTES INGRESADOS-->
						<?php if(isset($add_invitado) && $add_invitado>0 && $add_invitado<11) : ?>
							<?php for($i=0;$i<count($users);$i++) : ?>
								<div id="user<?php echo $i+1; ?>" style="margin-top: 20px">
						    		<fieldset>
						    			<legend><?php $X = $i+1; echo lang('evnt.invitado').' '.$X; ?></legend>
							    		<div class="six mobile-four columns">
											<input name="cedula_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_cedula').' *'; ?>" 
												value="<?php echo (!empty($users[$i]['cedula'])) ? $users[$i]['cedula'] : ''; ?>" />
										</div>
										<div class="six mobile-four columns">
											<input name="tlfn_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_telefono').' *'; ?>"
												value="<?php echo (!empty($users[$i]['tlfn'])) ? $users[$i]['cedula'] : ''; ?>" />
									  	</div>
										<div class="six mobile-four columns">
											<input name="nombre1_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_nombre').' *'; ?>"
												value="<?php echo (!empty($users[$i]['nombre1'])) ? $users[$i]['nombre1'] : ''; ?>" />
										</div>
										<div class="six mobile-four columns">
											<input name="nombre2_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_nombre').' *'; ?>"
												value="<?php echo (!empty($users[$i]['nombre2'])) ? $users[$i]['nombre2'] : ''; ?>" />
										</div>
										<div class="six mobile-four columns">
											<input name="apellido1_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_primer').' '.lang('evnt.insc_apellido').' *'; ?>"
												value="<?php echo (!empty($users[$i]['apellido1'])) ? $users[$i]['apellido1'] : ''; ?>" />
										</div>
										<div class="six mobile-four columns">
											<input name="apellido2_user<?php echo $i+1; ?>" type="text" placeholder="<?php echo lang('evnt.insc_segundo').' '.lang('evnt.insc_apellido').' *'; ?>"
												value="<?php echo (!empty($users[$i]['apellido2'])) ? $users[$i]['apellido2'] : ''; ?>" />
										</div>
										<div class="twelve mobile-four columns">
											<input name="email_user<?php echo $i+1; ?>" type="email" placeholder="<?php echo lang('evnt.insc_email').' *'; ?>"
												value="<?php echo (!empty($users[$i]['email'])) ? $users[$i]['email'] : ''; ?>" />
										</div>
										<div class="twelve mobile-four columns" style="margin-top: 10px;">
											<label><?php echo lang('evnt.insc_hospedaje'); ?> </label>
											<label for="radio6" class="left" style="margin-right: 15px;" ><input CHECKED value="Sí" name="radbutton_hospedaje<?php echo $i+1; ?>" type="radio" id="radio4">Sí</label>
											<label for="radio7" class="left"  ><input value="No" name="radbutton_hospedaje<?php echo $i+1; ?>" type="radio" id="radio5">No</label>
										</div>
									</fieldset>
							  	</div>
							<?php endfor; ?>
						<?php endif;  ?>
					</div>
					<div style="margin: 0px 15px; text-align: center;">
						<small>
							<h6><a href="<?php echo base_url(); ?>contacto/contacto_front/index"><?php echo lang('evnt.contact_cc'); ?></a></h6>
						</small>
					</div>
				</div>
			</fieldset>
			<input type="button" class="button small" id="back_to_contact" style="margin-bottom: 10px;margin: 10px 10px;" value="<?php echo lang('regresar'); ?>" />
			<input type="button" class="button small right" id="go_to_factura" style="margin-bottom: 10px;margin: 10px 10px;" value="<?php echo lang('continuar'); ?>" />
			<div class="steps" style="margin-top: 70px">
				<ul>
					<li>1</li>
					<li class="active">2</li>
					<li>3</li>
				</ul>
			</div>
		</div>
				  
<!----------------------------------------------- DATOS FISCALES DE FACTURACION ------------------------------------------------------>				  
				  
		<div id="factura">
			<fieldset>
				<legend><h4 id="datos_interes"><?php echo lang('evnt.insc_datos_fact'); ?></h4></legend>
				<div class="row" style="margin-top: 10px">
					<div class="six mobile-four columns">
						<input name="rif" type="text" placeholder="<?php echo lang('evnt.insc_rif_pers').' *'; ?>" value="<?php echo (isset($rif) && !empty($rif)) ?  $rif : ''; ?>" required />
					</div>
					<div class="twelve mobile-four columns">
						<textarea required style="resize: none; height: 65px;" name="dir_fiscal" placeholder="<?php echo lang('evnt.insc_dir_fiscal').' *'; ?>" value="<?php echo (isset($dir_fiscal) && !empty($dir_fiscal)) ? $dir_fiscal : ''; ?>"></textarea>
					</div>
					<div class="twelve mobile-four columns">
						<textarea style="resize: none; height: 65px;" name="add_comments" placeholder="<?php echo lang('evnt.add_comments'); ?>" value="<?php echo (isset($add_comments) && !empty($add_comments)) ? $add_comments : ''; ?>"></textarea>
					</div>
					<div class="twelve mobile-four columns">
						<input name="medio_difusion" type="text" placeholder="<?php echo lang('evnt.medio_difusion'); ?>" value="<?php echo (isset($medio_difusion) && !empty($medio_difusion)) ? $medio_difusion : ''; ?>" />
					</div>
				</div>
			</fieldset>
			<div class="twelve mobile-four columns">
				<fieldset>
					<legend><?php echo lang('evnt.insc_condicion_tit'); ?></legend>
					<ul>
						<li><?php echo lang('evnt.insc_condicion_1'); ?></li>
						<li><?php echo lang('evnt.insc_condicion_2'); ?></li>
						<li><?php echo lang('evnt.insc_condicion_3'); ?></li>
					</ul>
				</fieldset>
				<label><input type="checkbox" name="temrs_conds" required /><span class="custom checkbox"></span><?php echo '&nbsp;&nbsp;'.lang('evnt.terminos_cond'); ?></label>
			</div>
			<input type="button" class="button small" id="back_to_users" style="margin-bottom: 10px;margin: 10px 10px;" value="<?php echo lang('regresar'); ?>" />
			<a href="#" class="button small right" style="margin-bottom: 10px;margin: 10px 10px;" data-reveal-id="myModal"><b><?php echo lang('mem_reg.submit_info'); ?></b></a>
			<!--<input style="margin: 10px 0px"class="right hide-for-small" data-reveal-id="myModal" id="submit_button" type="submit" class="button small right" value="<?php echo lang('mem_reg.submit_info'); ?>" style="margin-bottom: 20px;">-->
			<div class="steps" style="margin-top: 70px">
				<ul>
					<li>1</li>
					<li>2</li>
					<li class="active">3</li>
				</ul>
			</div>
		</div>

		<div style="clear:both;"></div>
	</form>
	</div>
	
	<div>
		
	</div>
	
</div>
<div class="two mobile-four columns"></div>
</div>
</div>