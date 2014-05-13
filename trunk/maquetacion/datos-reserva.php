<?php include("header.php"); ?>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title">Envia tus datos</h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text">Tu estas aqui: </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="http://3clicks.bringthepixel.com/"><span itemprop="title">Inicio</span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item">Reservaciones</li>
   			</ol>
   		</nav> 
   		<div id="g1-content-area">
   			<div id="primary">
   				<div id="tabla_reserva" class="g1-table g1-table--solid ">
   					<table>
   						<thead>
   							<tr>
   								<th>Datos de la estadía</th>
   							</tr>
   						</thead>
   						<tbody>
							<td>
								<table>
									<td style="width: 94px;">
										<div>
											<img src="http://posada/assets/front/img/template/nosotros/3small.jpg" style="width: 94px;height: 66px;"/>
   											
   										</div>
									</td>
									<td>
										<span>
		   									<h5>Posada Sol y Luna</h5>
		   									<p>
		   										Isla Gran Roque, Los Roques - Venezuela.
		   										<br />
		   										<b>Entrada: </b>04-04-2013
		   										<br />
		   										<b>Salida : </b>04-04-2013
		   										<br />
		   									</p>
	   									</span>
									</td>
								</table>
							</td>
   						</tbody>
   					</table>
   				</div>
		   		<form action="" method="post"> 
					<div id="tabla_datos" class="g1-table g1-table--solid ">
				    	<table>
				        	<thead>
				            	<tr>
				                	<th>Tus datos</th>
				            	</tr>
				        	</thead>
				        	<tbody>
				        		<tr>
				        			<td>
										<table>
											<td>
												<label for="tratamiento">Tratamiento</label>
												<select id="tratamiento" name="tratamiento">
													<option>Sr.</option>
													<option>Srta.</option>
													<option>Sra.</option>
												</select>
											</td>
											
											<td>
												<label for="nombre">Nombre</label>
												<input id="nombre" type="text" name="nombre" value="" />
											</td>
											
											<td>
												<label for="email">Email</label>
												<input id="email" type="text" name="email" value="" />
											</td>
										</table>
									</td>
									
				        		</tr>
				        	
				        		<tr>
				        			<td>
				        				<center><h3>Condiciones de la reserva</h3></center>
				        			</td>
				        			
				        		</tr>
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
				   									<h5>Habitacion: Tipo de habitacion</h5>
				   									<p><b>Cancelación GRATUITA </b>antes del 29 de enero de 2014.</p>
				   									<div>
				   										<label for="nombre_cliente">Nombre del cliente</label>
														<input id="nombre_cliente" type="text" name="nombre_cliente" value="" />
				   									</div>
				   									
				   									<p>
				   										Descripcion detalla de los beneficios de la habitacion.
				   									</p>
				   									
				   									<p>
				   										<b>Maximo de personas:</b> 2
				   										<br />
				   										<br />
				   										<b>Restricciones: </b>Solo para NO fumadores
				   										<br />
				   										<br />
				   									</p>
				   									<hr />
				   									<h5>Servicios destacados de la habitacion</h5>
				   									<p>
				   										Aire acondicionado, Balcón, TV de pantalla plana, Vistas al mar, Conexión Wi-Fi gratuita 
				   									</p>
				   									
				   									<div>
				   										<label for="nombre_cliente"><b>Peticiones especiales</b></label>
														<textarea class="noResize"></textarea>
				   									</div>
				   									<p>
				   										<em>Las peticiones no se pueden garantizar, pero el alojamiento hará todo lo posible por satisfacer tu petición. </em>
				   									</p>
			   									</span>
											</td>
										</table>
				        			</td>
				        		</tr>
								
				        	</tbody>
				    	</table>
					</div>
					<div class="form-row">
						<center>
							<a href="maquetacion/direccion-reserva.php" class="button">Continuar</a>
						</center>
					</div>
				</form>
   			</div>
   			<div id="secondary">
   				<div id="g1-box-counter-1" class="g1-box g1-box--simple  g1-box--icon sinsombra">
   					
   					<div class="g1-box__inner">
						<div style="text-align:center;">
							<h2>Precio total</h2>
							<h3>$210</h3>
						</div>
						<div id="g1-divider-1" class="g1-divider g1-divider--none g1-divider--noicon "></div>
						<div style="text-align:center;">
							<ul id="g1-list-1" class="g1-list--empty g1-list--simple ">
								<li>Habitacion 1</li>
								<li>Por 7 noches</li>
								<li>Impuesto minimo incluido</li>
							</ul>
						</div>
   					</div>
   				</div> 		
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>