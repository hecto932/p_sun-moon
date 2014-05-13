
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title"><?php echo lang('front.title_reservacion'); ?></h1>
      	</div>
  	</header>
</div>

<!-- BEGIN #g1-content -->
	<div id="g1-content">
        <div class="g1-layout-inner">
			<form accept-charset="UTF-8" action="<?php echo lang('action_enviar_reservacion'); ?>" method="post">
				<div id="g1-content">
					<div id="inputs1">
						<h2><?php echo lang('front.reserva_datos_personales'); ?></h2>
						<div class="form-row" id="nombre_completo_div">
							<label><?php echo lang('front.reserva_nombre'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input type="text" name="nombre_completo" value="<?php if(isset($nombre_completo) && !empty($nombre_completo)) echo $nombre_completo; ?>"/>
							<?php	if(form_error('nombre_completo'))
										echo form_error('nombre_completo');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
							
						</div>
						<div class="form-row" id="email_div">
							<label id="email_label" ><?php echo lang('front.reserva_email'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input id="email_input" type="text" name="email" value="<?php if(isset($email) && !empty($email)) echo $email; ?>" />
							<?php	if(form_error('email'))
										echo form_error('email');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						<div class="form-row" id="telefono_div">
							<label for="contact_form_message_1"><?php echo lang('front.reserva_telefono'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input class="phone" type="text" name="telefono" value="<?php if(isset($telefono) && !empty($telefono)) echo $telefono; ?>"  />
							<?php	if(form_error('telefono'))
										echo form_error('telefono');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						<div class="form-row" id="nacionalidad_div">
							<label for="contact_form_message_1"><?php echo lang('front.reserva_nacionalidad'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input type="text" name="nacionalidad" value="<?php if(isset($nacionalidad) && !empty($nacionalidad)) echo $nacionalidad; ?>" />
							<?php	if(form_error('nacionalidad'))
										echo form_error('nacionalidad');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
					</div>
					
				</div>
				<div id="g1-content">
					<div>
						<h2><?php echo lang('front.reserva_datos_estadia'); ?></h2>
						
					<label for="numero"><?php echo lang('front.inicio_label3'); ?></label>
					<select id="numero" name="adultos"  unselectable="unselectable">
						<?php for($i=1;$i<=16;$i++)
						{
							if($i==$adultos)
								echo '<option selected>'.$adultos.'</option>';
							else 
								echo '<option>'.$i.'</option>';
							
						}
						?>
					</select>
						
						<div class="form-row" id="aereolinea_div">
							<label for="contact_form_name_1"><?php echo lang('front.reserva_aerolinea'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input type="text" name="aereolinea" value="<?php if(isset($aereolinea) && !empty($aereolinea)) echo $aereolinea; ?>" />
							<?php	if(form_error('aereolinea'))
										echo form_error('aereolinea');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						<div class="form-row">
							<label for="contact_form_email_1"><?php echo lang('front.reserva_llegada'); ?> <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input type="text"  name="fecha_llegada" value="<?php echo $fecha_llegada; ?>" readonly="readonly" />
							<?php	if(form_error('fecha_llegada'))
										echo form_error('fecha_llegada');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						
						<div class="form-row" id="hora_llegada_div">
							<label for="contact_form_email_1"><?php echo lang('front.reserva_hora_llegada'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input class="time" type="text" name="hora_llegada" value="<?php echo set_value('hora_llegada', '00:00'); ?>"/>
							<?php	if(form_error('hora_llegada'))
										echo form_error('hora_llegada');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						
						<div class="form-row">
							<label for="contact_form_email_1"><?php echo lang('front.reserva_salida'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input type="text" name="fecha_salida" value="<?php echo $fecha_salida; ?>"  readonly="readonly" />
							<?php	if(form_error('fecha_salida'))
										echo form_error('fecha_salida');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						
						<div class="form-row" id="hora_salida_div">
							<label for="contact_form_email_1"><?php echo lang('front.reserva_hora_salida'); ?>  <em class="meta">(<?php echo lang('front.requerido'); ?>)</em></label>
							<input class="time" type="text" name="hora_salida" value="<?php echo set_value('hora_salida', '00:00'); ?>"/>
							<?php	if(form_error('hora_salida'))
										echo form_error('hora_salida');
									else
										echo '<small class="error" style="display:none;">'.lang('front.reserva_required').'</small>';
							 ?>
						</div>
						
						<div class="form-row">
							<label for="contact_form_message_1"><?php echo lang('front.reserva_observaciones'); ?></label>
							<textarea name="observaciones" rows="5" cols="5"><?php if(isset($observaciones) && !empty($observaciones)) echo $observaciones; ?></textarea>
						</div>
						<div class="form-row">
							<center>
							<button type="submit" class="button"><?php echo lang('front.enviar'); ?></button>
							</center>
						</div>
					</div>
				</div>					
			</form>
		</div>
 	</div>
	<!-- END #g1-content -->
	
	<div class="row">
		<div class="large-12 columns">
			<p>
        		<b><?php echo lang('front.reserva_nota1'); ?>: </b><?php echo lang('front.reserva_nota'); ?>
        	</p>
		</div>
	</div>