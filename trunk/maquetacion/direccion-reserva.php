<?php include("header.php"); ?>

<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title">Introduce tu direccion</h1>
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
   				<div class="bs2-is-complete">
					<p>¡Ya casi has acabado! Solo necesitamos unos datos más para confirmar tu reserva.</p>
				</div>
				
				<form action="" method="post">
					<!-- TABLA DE DATOS PERSONALES-->
					<div id="tabla_reserva" class="g1-table g1-table--solid ">
	   					<table>
	   						<thead>
	   							<th>Tu dirección</th>
	   							<th></th>
	   						</thead>
	   						<tbody>
	   							<tr>
									<td>
										<label for="direccion">Direccion</label>
										<input id="direccion" type="text" name="direccion" value="Venezuela" />
									</td>
									<td>
										<label for="nombre">Nombre</label>
										<input id="nombre" type="text" name="nombre" value="Hector Flores" disabled="disabled" />
									</td>
	   							</tr>
	   							<tr>
	   								<td>
	   									<label for="direccion">Ciudad</label>
										<input id="direccion" type="text" name="direccion" value="Valencia" />
	   								</td>
	   								
	   								<td>
	   									<label for="correo">Correo electronico</label>
	   									<input id="correo" type="text" name="correo" value="hf.nsce@gmail.com" disabled="disabled" />
	   								</td>
	   							</tr>
	   							
	   							<tr>
	   								<td>
	   									<label for="direccion">Codigo postal</label>
										<input id="direccion" type="text" name="postal" value="2001" />
	   								</td>
	   								<td>
	   									
	   								</td>				
	   							</tr>
	   							
	   							<tr>
	   								<td>
	   									<label for="direccion">Pais</label>
										<select class="ClickTaleSensitive fixed_width" id="cc1" name="cc1">
											<option value="">-- Selecciona el país --</option>
											<option value="xa">Abjasia</option>
											<option value="af">Afganistán</option>
											<option value="al">Albania</option>
											<option value="de">Alemania</option>
											<option value="ad">Andorra</option>
											<option value="ao">Angola</option>
											<option value="ai">Anguilla</option>
											<option value="ag">Antigua y Barbuda</option>
											<option value="aq">Antártida</option>
											<option value="sa">Arabia Saudí</option>
											<option value="dz">Argelia</option>
											<option value="ar">Argentina</option>
											<option value="am">Armenia</option>
											<option value="aw">Aruba</option>
											<option value="au">Australia</option>
											<option value="at">Austria</option>
											<option value="az">Azerbayán</option>
											<option value="bs">Bahamas</option>
											<option value="bh">Bahréin</option>
											<option value="bd">Bangladesh</option>
											<option value="bb">Barbados</option>
											<option value="bz">Belice</option>
											<option value="bj">Benin</option>
											<option value="bm">Bermudas</option>
											<option value="by">Bielorrusia</option>
											<option value="bo">Bolivia</option>
											<option value="bq">Bonaire, Saint Eustatius y Saba</option>
											<option value="ba">Bosnia Herzegovina</option>
											<option value="bw">Botsuana</option>
											<option value="br">Brasil</option>
											<option value="bn">Brunei Darussalam</option>
											<option value="bg">Bulgaria</option>
											<option value="bf">Burkina Faso</option>
											<option value="bi">Burundi</option>
											<option value="bt">Bután</option>
											<option value="be">Bélgica</option>
											<option value="cv">Cabo Verde</option>
											<option value="kh">Camboya</option>
											<option value="cm">Camerún</option>
											<option value="ca">Canadá</option>
											<option value="td">Chad</option>
											<option value="cl">Chile</option>
											<option value="cn">China</option>
											<option value="cy">Chipre</option>
											<option value="va">Ciudad del Vaticano</option>
											<option value="co">Colombia</option>
											<option value="km">Comores</option>
											<option value="cg">Congo</option>
											<option value="kp">Corea del Norte</option>
											<option value="kr">Corea del Sur</option>
											<option value="cr">Costa Rica</option>
											<option value="ci">Costa de Marfil</option>
											<option value="hr">Croacia</option>
											<option value="cw">Curaçao</option>
											<option value="dk">Dinamarca</option>
											<option value="dj">Djibouti</option>
											<option value="dm">Dominica</option>
											<option value="ec">Ecuador</option>
											<option value="eg">Egipto</option>
											<option value="sv">El Salvador</option>
											<option value="ae">Emiratos Árabes Unidos</option>
											<option value="er">Eritrea</option>
											<option value="sk">Eslovaquia</option>
											<option value="si">Eslovenia</option>
											<option value="es">España</option>
											<option value="us">Estados Unidos </option>
											<option value="ee">Estonia</option>
											<option value="et">Etiopía</option>
											<option value="ph">Filipinas</option>
											<option value="fi">Finlandia</option>
											<option value="fj">Fiyi</option>
											<option value="fr">Francia</option>
											<option value="ga">Gabón</option>
											<option value="gm">Gambia</option>
											<option value="ge">Georgia</option>
											<option value="gh">Ghana</option>
											<option value="gi">Gibraltar</option>
											<option value="gd">Granada</option>
											<option value="gr">Grecia</option>
											<option value="gl">Groenlandia</option>
											<option value="gp">Guadalupe</option>
											<option value="gu">Guam</option>
											<option value="gt">Guatemala</option>
											<option value="gf">Guayana Francesa</option>
											<option value="gg">Guernsey</option>
											<option value="gn">Guinea</option>
											<option value="gq">Guinea Ecuatorial</option>
											<option value="gw">Guinea-Bissau</option>
											<option value="gy">Guyana</option>
											<option value="ht">Haití</option>
											<option value="hn">Honduras</option>
											<option value="hk">Hong Kong</option>
											<option value="hu">Hungría</option>
											<option value="in">India</option>
											<option value="id">Indonesia</option>
											<option value="iq">Iraq</option>
											<option value="ie">Irlanda</option>
											<option value="ir">Irán</option>
											<option value="bv">Isla Bouvet </option>
											<option value="mu">Isla Mauricio</option>
											<option value="im">Isla de Man</option>
											<option value="cx">Isla de Navidad</option>
											<option value="is">Islandia</option>
											<option value="ky">Islas Caimán</option>
											<option value="cc">Islas Cocos</option>
											<option value="ck">Islas Cook</option>
											<option value="fo">Islas Faroe </option>
											<option value="gs">Islas Georgias del Sur y Sandwich …</option>
											<option value="hm">Islas Heard y McDonald</option>
											<option value="fk">Islas Malvinas</option>
											<option value="mp">Islas Marianas del Norte</option>
											<option value="mh">Islas Marshall</option>
											<option value="um">Islas Menores de los EEUU</option>
											<option value="nf">Islas Norfolk</option>
											<option value="sb">Islas Solomón</option>
											<option value="tc">Islas Turks y Caicos</option>
											<option value="vi">Islas Vírgenes (EEUU)</option>
											<option value="vg">Islas Vírgenes Británicas</option>
											<option value="il">Israel</option>
											<option value="it">Italia</option>
											<option value="jm">Jamaica</option>
											<option value="jp">Japón</option>
											<option value="je">Jersey</option>
											<option value="jo">Jordania</option>
											<option value="kz">Kazajstán</option>
											<option value="ke">Kenia</option>
											<option value="kg">Kirguizistán</option>
											<option value="ki">Kiribati</option>
											<option value="xk">Kosovo</option>
											<option value="kw">Kuwait</option>
											<option value="la">Laos</option>
											<option value="ls">Lesotho</option>
											<option value="lv">Letonia</option>
											<option value="lr">Liberia</option>
											<option value="ly">Libia</option>
											<option value="li">Liechtenstein</option>
											<option value="lt">Lituania</option>
											<option value="lu">Luxemburgo</option>
											<option value="lb">Líbano</option>
											<option value="mo">Macao</option>
											<option value="mk">Macedonia</option>
											<option value="mg">Madagascar</option>
											<option value="my">Malasia</option>
											<option value="mw">Malawi</option>
											<option value="mv">Maldivas</option>
											<option value="ml">Mali</option>
											<option value="mt">Malta</option>
											<option value="ma">Marruecos</option>
											<option value="mq">Martinica</option>
											<option value="mr">Mauritania</option>
											<option value="yt">Mayotte</option>
											<option value="fm">Micronesia</option>
											<option value="md">Moldavia</option>
											<option value="mn">Mongolia</option>
											<option value="me">Montenegro</option>
											<option value="ms">Montserrat</option>
											<option value="mz">Mozambique</option>
											<option value="mm">Myanmar (Birmania)</option>
											<option value="mx">México</option>
											<option value="mc">Mónaco</option>
											<option value="na">Namibia</option>
											<option value="nr">Nauru</option>
											<option value="np">Nepal</option>
											<option value="ni">Nicaragua</option>
											<option value="ng">Nigeria</option>
											<option value="nu">Niue</option>
											<option value="no">Noruega</option>
											<option value="nc">Nueva Caledonia</option>
											<option value="nz">Nueva Zelanda</option>
											<option value="ne">Níger</option>
											<option value="om">Omán</option>
											<option value="pk">Pakistán</option>
											<option value="pw">Palau</option>
											<option value="pa">Panamá</option>
											<option value="pg">Papúa Nueva Guinea</option>
											<option value="py">Paraguay</option>
											<option value="nl">Países Bajos</option>
											<option value="pe">Perú</option>
											<option value="pn">Pitcairn</option>
											<option value="pf">Polinesia Francesa</option>
											<option value="pl">Polonia</option>
											<option value="pt">Portugal</option>
											<option value="pr">Puerto Rico</option>
											<option value="qa">Qatar</option>
											<option value="gb">Reino Unido</option>
											<option value="cf">República Centroafricana</option>
											<option value="cz">República Checa</option>
											<option value="cd">República Democrática del Congo</option>
											<option value="do">República Dominicana</option>
											<option value="re">Reunión</option>
											<option value="rw">Ruanda</option>
											<option value="ro">Rumanía</option>
											<option value="ru">Rusia</option>
											<option value="bl">Saint Barthelemy</option>
											<option value="mf">Saint Martin</option>
											<option value="ws">Samoa</option>
											<option value="as">Samoa Americana</option>
											<option value="kn">San Cristóbal y Nieves</option>
											<option value="sm">San Marino</option>
											<option value="pm">San Pedro y Miquelón</option>
											<option value="vc">San Vicente y las Granadinas</option>
											<option value="sh">Santa Helena</option>
											<option value="lc">Santa Lucía</option>
											<option value="st">Santo Tomé y Príncipe</option>
											<option value="sn">Senegal</option>
											<option value="rs">Serbia</option>
											<option value="sc">Seychelles</option>
											<option value="sl">Sierra Leona</option>
											<option value="sg">Singapur</option>
											<option value="sx">Sint Maarten</option>
											<option value="sy">Siria</option>
											<option value="so">Somalia</option>
											<option value="lk">Sri Lanka</option>
											<option value="za">Sudáfrica</option>
											<option value="sd">Sudán</option>
											<option value="se">Suecia</option>
											<option value="ch">Suiza</option>
											<option value="sr">Surinam</option>
											<option value="sj">Svalbard  y Jan Mayen</option>
											<option value="sz">Swaziland</option>
											<option value="tj">Tadjikistán</option>
											<option value="th">Tailandia</option>
											<option value="tw">Taiwán</option>
											<option value="tz">Tanzania</option>
											<option value="io">Territorio Británico del Océano Ín…</option>
											<option value="ps">Territorio Palestino</option>
											<option value="tf">Territorios Franceses del Sur</option>
											<option value="tl">Timor Oriental</option>
											<option value="tg">Togo</option>
											<option value="tk">Tokelau</option>
											<option value="to">Tonga</option>
											<option value="tt">Trinidad y Tobago</option>
											<option value="tm">Turkmenistán</option>
											<option value="tr">Turquía</option>
											<option value="tv">Tuvalu</option>
											<option value="tn">Túnez</option>
											<option value="ua">Ucrania</option>
											<option value="ug">Uganda</option>
											<option value="uy">Uruguay</option>
											<option value="uz">Uzbekistán</option>
											<option value="vu">Vanuatu</option>
											<option selected="selected" value="ve">Venezuela</option>
											<option value="vn">Vietnam</option>
											<option value="wf">Wallis y Futuna</option>
											<option value="ye">Yemen</option>
											<option value="zm">Zambia</option>
											<option value="zw">Zimbabue</option>
										</select>
	   								</td>
	   								<td>
	   									
	   								</td>
	   							</tr>
	   							
	   							<tr>
	   								<td>
	   									<label for="direccion">Teléfono</label>
										<input id="telefono" type="text" name="postal" value="+58 412 776 2882" />
	   								</td>
	   								<td>
	   									
	   								</td>
	   							</tr>
	   							
	   						</tbody>
	   					</table>
	   				</div>
					<!-- /TABLA DE DATOS PERSONALES -->		
					
					<!-- TU GARANTIA DE LA RESERVA -->
					<div id="tabla_tarjeta" class="g1-table g1-table--solid ">
	   					<table>
	   						<thead>
	   							<th>Tu garantía de la reserva</th>
	   						</thead>
	   						<tbody>
	   							<tr>
	   								<td>
	   									<label for="tdc">TIPO DE TARJETA</label>
		   								<select name="tdc">
											<option value="">-- Selecciona --</option>
											<option>
												American Express
											</option>
											<option>
												Visa
											</option>
											<option>
												MasterCard
											</option>
											<option>
												Diners Club
											</option>
											<option>
												Discover
											</option>
										</select>
	   								</td>
	   							</tr>
	   							
	   							<tr>
	   								<td>
	   									<label for="titular">TITULAR DE LA TARJETA</label>
										<input id="telefono" type="text" name="postal" value="Hector Flores" />
	   								</td>
	   							</tr>
	   							
	   							<tr>
	   								
	   								<td>
	   									<label>FECHA DE EXPIRACION</label>
	   									<br />
   										<span>
   											<label>MES</label>
   											<select id="cc_month" class="select_tdc" name="cc_month">
												<option>01</option>
												<option>02</option>
												<option>03</option>
												<option>04</option>
												<option>05</option>
												<option>06</option>
												<option>07</option>
												<option>08</option>
												<option>09</option>
												<option>10</option>
												<option>11</option>
												<option>12</option>
											</select>
											<label>AÑO</label>
											<select class="select_tdc" name="cc_year" id="ccYear">
												<option>2013</option>
												<option>2014</option>
												<option>2015</option>
												<option>2016</option>
												<option>2017</option>
												<option>2018</option>
												<option>2019</option>
												<option>2020</option>
												<option>2021</option>
												<option>2022</option>
												<option>2023</option>
											</select>
   										</span>
	   								</td>
	   							</tr>
	   							
	   							
	   						</tbody>
	   					</table>
	   					
	   				</div>
	   				<div class="form-row">
							<center>
								<a href="maquetacion/direccion-reserva.php" class="button">Reservar por $210</a>
							</center>
					</div>
				</form>
				<!-- /TU GARANTIA DE LA RESERVA-->
   				
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