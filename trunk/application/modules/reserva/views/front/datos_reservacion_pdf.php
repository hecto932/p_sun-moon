<!DOCTYPE html>
<html>
	<head>
		<link rel='stylesheet' id='g1_screen-css'  href='assets/front/css/g1-screen.css' type='text/css' media='screen' />
		<link rel='stylesheet' id='g1_dynamic_style-css'  href='assets/front/css/g1-dynamic-style.css' type='text/css' media='screen' />
	</head>
	<body>
		<div id="g1-content">
			<div class="g1-layout-inner">
				<TABLE BORDER="0" width="100%">
				<TR>
					<td><img src="assets/front/img/template/logo/logonew.png" style="width:200px;" /></td>
					<td style="font-size: 12px; text-align: justify;">
						<b>
							<p>
								<?php echo lang('front.pdf.correo_header_p1'); ?>
							</p>
							<p>
								<?php echo lang('front.pdf.correo_header_p2'); ?>
							</p>
							<p>
								<?php echo lang('front.pdf.correo_header_p3'); ?>
							</p>
						</b>
					</td>
				</TR>
				</TABLE> 
				
				<hr />
				<h2 style="text-align: center;"><?php echo lang('front.pdf.correo_titulo1'); ?></h2>
				<div id="g1-table-1" class="g1-table g1-table--solid " style="font-size: 12px;">
					<table style="width: 100%;">
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.titular_reserva'); ?></td>
							<td style="width: 25%;"><?php echo $titular_reserva; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.codigo_reserva'); ?></td>
							<td style="width: 25%;"><?php echo $codigo_reserva; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.email'); ?></td>
							<td style="width: 25%;"><?php echo $email; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.checkin'); ?></td>
							<td style="width: 25%;"><?php echo $checkin; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.telefono'); ?></td>
							<td style="width: 25%;"><?php echo $telefono; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.checkout'); ?></td>
							<td style="width: 25%;"><?php echo $checkout; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.pais'); ?></td>
							<td style="width: 25%;"><?php echo $pais; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.noches'); ?></td>
							<td style="width: 25%;"><?php echo $noches; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.nacionalidad'); ?></td>
							<td style="width: 25%;"><?php echo $nacionalidad; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.habitaciones'); ?></td>
							<td style="width: 25%;"><?php echo $numero_habitaciones; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"><?php echo lang('front.pdf.direccion'); ?></td>
							<td style="width: 25%;"><?php echo $direccion; ?></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.personas'); ?></td>
							<td style="width: 25%;"><?php echo $personas; ?></td>
						</tr>
						
						<tr>
							<td style="width: 25%;"></td>
							<td style="width: 25%;"></td>
							<td style="width: 25%;"><?php echo lang('front.pdf.forma_pago'); ?></td>
							<td style="width: 25%;"><?php echo $tipo_forma_pago; ?></td>
						</tr>
					</table>
				</div>
				
				<hr />
				
				<div id="g1-table-1" class="g1-table g1-table--solid " style="font-size: 12px;">
					<table style="width: 100%;" style="text-align: center;">
						<thead>
				        	<tr>
				            	<th style="width: 5%;"><b><?php echo lang('front.pdf.item'); ?></b></th>
				                <th style="width: 15%;"><b><?php echo lang('front.pdf.titular'); ?></b></th>
				                <th style="width: 20%;"><b><?php echo lang('front.pdf.habitacion'); ?></b></th>
				                <th style="width: 20%;"><b><?php echo lang('front.pdf.descripcion'); ?></b></th>
				                <th style="width: 20%;"><b><?php echo lang('front.pdf.precio'); ?></b></th>
				                <th style="width: 20%;"><b><?php echo lang('front.pdf.peticion'); ?></b></th>
				        	</tr>
				    	</thead>
				    	<tbody>
				    		<?php for($i=0;$i<count($habitaciones);++$i): ?>
				    			<tr>
					    			<td><?php echo $i+1; ?></td>
									<td><?php echo $habitaciones[$i]['nombre_titular']; ?></td>	
									<td><?php echo $habitaciones[$i]['tipo']; ?></td>
									<td><?php echo $habitaciones[$i]['tipo_descrip']; ?></td>
									<td><?php echo $habitaciones[$i]['moneda_abreviado']." ".$habitaciones[$i]['valor']; ?></td>	
									<?php if($habitaciones[$i]['peticion']): ?>
										<td><?php echo $habitaciones[$i]['peticion']; ?></td>
									<?php else: ?>
										<td>Ninguna.</td>
									<?php endif;?>
					    		</tr>
					    	<?php endfor; ?>
					    	<tr>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td><h3><?php echo lang('front.pdf.total'); ?></h3></td>
					    	</tr>
					    	<tr>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td></td>
					    		<td><h3><?php echo $denominacion." ".$precio_total; ?></h3></td>
					    	</tr>
				    	</tbody>
					</table>
				</div>
				
			</div>
		</div>	

	</body>
</html>
		