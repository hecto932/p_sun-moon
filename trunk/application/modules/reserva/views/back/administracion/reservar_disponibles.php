	<br /><h5 style="color: #575757;">Habitaciones disponibles</h5><hr>
	
	<input type="hidden" name="denominacion" value="<?php echo $habitacion[0]->moneda_abreviado; ?>" />
	
	<?php foreach ($habitaciones as $habitacion): ?>
		
		<div class="row">
			<!-- Tipo habitacion -->
			<div class="two column">
	        	<label class="inline" for="checkin"><span style="color: #00A2AD;"> <?php echo lang('tipo_habitacion'); ?>: </span></label>
	        </div>
	    	<div class="two columns">
	    		<p style="margin-top: 5px;"><?php echo $habitacion->tipo; ?></p>
	    	</div>
	    	
	    	<!-- Personas -->
	    	<div class="one column">
	        	<label class="inline" for="checkout"><span style="color: #00A2AD;"> <?php echo lang('personas'); ?>: </span></label>
	        </div>
	    	<div class="one column">
	        	<p style="margin-top: 5px;"><?php echo $habitacion->personas; ?></p>
	        </div>
	    	
	    	<!-- Disponibilidad -->
	    	<div class="two column">
	        	<label class="inline" for="checkout"><span style="color: #00A2AD;"> <?php echo lang('disponibilidad'); ?>: </span></label>
	        </div>
	    	<div class="four columns">
		    	<?php
					//Numero de noches
					$datetime1 = new DateTime($checkin);
					$datetime2 = new DateTime($checkout);
					$noches = $datetime1->diff($datetime2);
					
					//Costo
					$costo = $noches * $habitacion->valor;
					
					//Opciones
					$count = $habitacion->habitaciones;
					$opciones = array();
					for($i = 0; $i <= $count; $i++) $opciones[$i.'_'.$costo] = $i.' ('.$costo*$i.' '.$habitacion->moneda_abreviado.')';
				?>
	        	<?php echo form_dropdown('habitacion['.$habitacion->id_tipo_habitacion.']', $opciones, set_value('habitacion[]'), 'class="habitacion" style="margin-top: 5px;"'); ?>
	    	</div>
		</div>
		
		<hr />
	<?php endforeach; ?>
	
	<br /><h5 style="color: #575757;"><?php echo lang('reservacion_datos_cliente'); ?></h5><hr>
	
	<div class="row huesped">
		<!-- Tratamiento -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_tratamiento'); ?> </span></label>
        	<?php echo form_dropdown('tratamiento', $opt_tratamiento, set_value('tratamiento'), 'class="tratamiento"'); ?>
    	</div>
    	
    	<!-- Nombre -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_cliente'); ?> </span></label>
        	<input type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" />
    	</div>
	</div>
	
	<div class="row">
		<!-- Email -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_email'); ?> </span></label>
        	<input type="text" name="email" value="<?php echo set_value('email'); ?>" />
    	</div>
    	
    	<!-- Contraseña -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_contraseña'); ?> </span></label>
        	<input type="password" name="password" value="<?php echo set_value('password'); ?>" />
    	</div>
	</div>
	
	<div class="row">
		<!-- Aerolinea -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_aerolinea'); ?> </span></label>
        	<input type="text" name="aerolinea" value="<?php echo set_value('aerolinea'); ?>" />
    	</div>
    	
    	<!-- Pais -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_pais'); ?> </span></label>
        	<?php echo form_dropdown('id_pais', $opt_paises, set_value('id_pais'), 'class="id_pais"'); ?>
    	</div>
	</div>
	
	<div class="row">
		<!-- Nacionalidad -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_nacionalidad'); ?> </span></label>
        	<input type="text" name="nacionalidad" value="<?php echo set_value('nacionalidad', $value_nacionalidad); ?>" />
    	</div>
    	
    	<!-- Forma de pago -->
    	<div class="six columns">
    		<label class="inline"><span> <?php echo lang('reservacion_forma_pago'); ?> </span></label>
        	<?php echo form_dropdown('id_tipo_forma_pago', $opt_forma_pago, set_value('id_tipo_forma_pago'), 'class="id_tipo_forma_pago"'); ?>
    	</div>
	</div>
	
	<div class="row">
		<!-- Telefono -->
    	<div class="twelve columns">
    		<label class="inline"><span> <?php echo lang('reservacion_telefono'); ?> </span></label>
        	<input type="text" name="telefono" value="<?php echo set_value('telefono'); ?>" />
    	</div>
	</div>
	
	<div class="row">
    	<!-- Direccion -->
    	<div class="twelve columns">
    		<label class="inline"><span> <?php echo lang('reservacion_direccion'); ?> </span></label>
        	<textarea id="direccion" name="direccion"><?php echo set_value('direccion'); ?></textarea>
    	</div>
	</div>
	
	<div class="row">
    	<div class="twelve columns" style="text-align: center;">
    		<button type="submit" class="button radius wtc efectuar_reservacion" name="efectuar_reserva" value="reservar"><?php echo 'Reservar' ?></button>
    	</div>
    </div>
