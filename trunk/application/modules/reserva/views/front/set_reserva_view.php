<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.set_reserva.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.set_reserva.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<h2 style="text-align: center;"><?php echo lang('front.pdf.correo_titulo1'); ?></h2>
		<form action="reserva/reserva_front/update_reserva" method="post">
			<div id="g1-table-1" class="g1-table g1-table--solid " style="font-size: 12px;">
			<table style="width: 100%;">
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.titular_reserva'); ?></b></td>
					<td style="width: 25%;"><?php echo $titular_reserva; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.codigo_reserva'); ?></b></td>
					<td style="width: 25%;"><?php echo $codigo_reserva; ?></td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.email'); ?></b></td>
					<td style="width: 25%;"><?php echo $email; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.checkin'); ?></b></td>
					<td style="width: 25%;">
						<input id="datepicker1" type="text" style="height: 3.313em;font-size: 12px;" name="checkin" readonly="readonly" value="<?php echo $checkin; ?>" />
					</td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.telefono'); ?></b></td>
					<td style="width: 25%;"><?php echo $telefono; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.checkout'); ?></b></td>
					<td style="width: 25%;">
						<input id="datepicker2" type="text" style="height: 3.313em;font-size: 12px;" name="checkin" readonly="readonly" value="<?php echo $checkout; ?>" />
					</td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.pais'); ?></b></td>
					<td style="width: 25%;"><?php echo $pais; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.noches'); ?></b></td>
					<td style="width: 25%;"><?php echo $noches; ?></td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.nacionalidad'); ?></b></td>
					<td style="width: 25%;"><?php echo $nacionalidad; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.habitaciones'); ?></b></td>
					<td style="width: 25%;"><?php echo $numero_habitaciones; ?></td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.direccion'); ?></b></td>
					<td style="width: 25%;"><?php echo $direccion; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.personas'); ?></b></td>
					<td style="width: 25%;"><?php echo $personas; ?></td>
				</tr>
				
				<tr>
					<td style="width: 25%;"><b>Precio:</b></td>
					<td style="width: 25%;"><?php echo $precio_total; ?></td>
					<td style="width: 25%;"><b><?php echo lang('front.pdf.forma_pago'); ?></b></td>
					<td style="width: 25%;"><?php echo $tipo_forma_pago; ?></td>
				</tr>
			</table>
		</div>
			<hr />
			
			<div id="tabla_datos" class="g1-table g1-table--solid " style="font-size: 15px;">
				<input type="hidden" name="codigo_reserva" value="<?php echo $codigo_reserva; ?>">
		    	<table>
		        	<thead>
		            	<tr>
		                	<th><?php echo lang('front.datos.reserva.p4'); ?></th>
		            	</tr>
		        	</thead>
		        	<tbody>
		        		<tr>
		        			<td>
		        				<center><h3>Datos de habitación</h3></center>
		        			</td>
		        			
		        		</tr>
	        				<?php foreach($habitaciones as $habitacion => $value1): ?>
		        				<tr>
				        			<td>
				        				<table>
											<td style="width: 94px;">
												<div>
		   											<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" width="94"/>
		   										</div>
											</td>
											<td>
												<span>
				   									<h5><?php echo lang('front.datos.reserva.habitacion'); ?> <?php echo $value1['tipo']; ?></h5>
				   									<p><b><?php echo lang('front.datos.reserva.p6'); ?> </b><?php echo lang('front.datos.reserva.p7'); ?></p>
				   									<div>
				   										<label for="nombre_cliente"><?php echo lang('front.datos.reserva.nombre_cliente'); ?></label>
														<input id="nombre_cliente" type="text" name="nombre_cliente[]" value="<?php echo $value1['nombre_titular']; ?>" />
				   									</div>
				   									
				   									<p>
				   										<?php echo $value1['tipo_descrip']; ?>
				   									</p>
				   									
				   									<p>
				   										<b><?php echo lang('front.datos.reserva.maximo_personas'); ?></b> <?php echo $value1['personas']; ?>
				   										<br />
				   										<br />
				   										<b><?php echo lang('front.datos.reserva.restricciones'); ?> </b><?php echo lang('front.datos.reserva.restriccion1'); ?>
				   									</p>
				   									<hr />
				   									<h5><?php echo lang('front.datos.reserva.p9'); ?></h5>
				   									<p>
				   										<?php echo lang('front.datos.reserva.p8'); ?>
				   									</p>
				   									
				   									<div>
				   										<label for="nombre_cliente"><b><?php echo lang('front.datos.reserva.peticiones_especiales'); ?></b></label>
														<textarea name="peticiones[]" class="noResize"><?php echo $value1['peticion']; ?></textarea>
				   									</div>
				   									<p>
				   										<em><?php echo lang('front.datos.reserva.nota_peticiones'); ?> </em>
				   									</p>
			   									</span>
											</td>
										</table>
				        			</td>
			        			</tr>
	        				<?php endforeach; ?>
		        	</tbody>
		    	</table>   
			</div>
		</form>	
	</div>
	<div class="form-row">
		<center>
			<a id="g1-button-23" class="g1-button g1-button--medium g1-button--solid g1-button--standard" href="usuarios/reservas-usuario"><i class="icon-reply"></i> Volver a reservaciones</a>
			<?php if($id_estado_reservacion!=3): ?>
				<a id="g1-button-21" class="g1-button g1-button--medium g1-button--solid g1-button--standard " href="reserva/reserva_front/cancel_reserva/<?php echo $codigo_reserva; ?>" style="color: #ffffff;"><i class="icon-remove"></i> Cancelar reservación</a> 
			<?php endif; ?>
			<a onclick="document.forms[0].submit();return false;" id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard" href="<?php echo lang("front.reserva_url").'/download_reserva/'.$codigo_reserva; ?>"><i class="icon-save"></i> Guardar cambios</a>
		</center>
	</div>
</div>