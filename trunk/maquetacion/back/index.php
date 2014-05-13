<?php include('../header.php'); ?>
<!-- BEGIN #g1-content -->

<div id="g1-content">
    <div class="g1-layout-inner">
		<div class="row">
			<div class="large-12 columns" style="display:inline-block;">
				<center>
					<span>
						<a id="anterior" style="display:inline;"><i style="font-size: 22px;" class="icon-circle-arrow-left"></i></a>
					</span>
					
					<span>
						<input id="datepicker1" type="text" readonly="readonly" name="fecha" style="display:inline; width: 120px;"/>
					</span>
					
					<span>
						<a id="siguiente" style="display:inline;"><i style="font-size: 22px;" class="icon-circle-arrow-right"></i></a>
					</span>
				</center>
			</div>
		</div>
		<div id="mensaje_disponibilidad" class="g1-message g1-message--info " style="display: none;">
			<div id="mensaje" class="g1-inner" style="font-size: 16px;">
			</div>
		</div>
		<div>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
			<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
			<script src="assets/front/js/jquery/jquery.min.js"></script> 
			<script src="assets/front/js/jquery/jquery-1.10.2.js"></script>
			<script>
				
				$(document).ready(function(){
					var date = new Date();
					var date_format = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
					$('#datepicker1').val(date_format);
					$('#mensaje_disponibilidad').find('#mensaje').html("Disponibilidad del dia " + date_format);
					$('#mensaje_disponibilidad').slideDown('slow');
					$('.cliente_back').click(function(){
						if($(this).find('.datos').is(':hidden'))
						{
							$(this).find('.datos').slideDown('slow');
							$(this).find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');
							
						}
						else
						{
							$(this).find('.datos').slideUp('slow');
							$(this).find('i').removeClass('icon-minus-sign').addClass('icon-plus-sign');
						}
					});
					
					$('#anterior').click(function(){
						var fecha = $('#datepicker1').datepicker( "getDate" );					
						var date = new Date(fecha - 1);
						var dia = date.getDate();
						var mes = date.getMonth()+1;
						var ano = date.getFullYear();
						var date_format = dia + "-" + mes + "-" + ano;
						$('#datepicker1').datepicker( "setDate", date_format );
						$('#mensaje_disponibilidad').find('#mensaje').html("Disponibilidad del dia " + $('#datepicker1').val());
						
					});
					
					$('#siguiente').click(function(){
						var fecha = $('#datepicker1').datepicker( "getDate" );
						fecha.setDate(fecha.getDate()+1);
						var dia = fecha.getDate();
						var mes = fecha.getMonth()+1;
						var ano = fecha.getFullYear();
						var date_format = dia + "-" + mes + "-" + ano;
						$('#datepicker1').datepicker( "setDate", date_format );
						$('#mensaje_disponibilidad').find('#mensaje').html("Disponibilidad del dia " + $('#datepicker1').val());
					});
				});
			</script>
			<ul class="g1-grid">
				<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on">
					<div style="height: 300px;margin-bottom: 40px;background: none repeat scroll 0% 0% white;border: 1px solid rgb(204, 204, 204);border-radius: 8px 8px 0px 0px;transition: width 2s;">
						<div id="g1-message-5" class="g1-message g1-message--success" style="font-size: 12px;border-radius: 7px 7px 0px 0px;">
							<div class="g1-inner">Disponible</div>
						</div>
						<figure class="entry-featured-media">
					        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center " href="http://3clicks.bringthepixel.com/overview-on-right-post/">
					            <span class="g1-decorator">
					                <img class="attachment-g1_one_fourth wp-post-image" width="96" alt="post_photo_23_v01" src="assets/back/img/template/habitacion_back.png"></img>
					            </span>
					        </a>
					    </figure>
					    <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
					        <div class="g1-inner">
					            <header class="entry-header">
					                <h3>
					                    <a title="Overview on Right">
					                        HAB01	
					                    </a>
					                </h3>
					                <p class="entry-meta g1-meta" style="font-size: 12px;">
					                	<center>
					                   	 	No hay actividad para esta habitación el dia de hoy.
					                   	 	<br />
					                   	 	<br />
					                    	<a id="g1-button-24" class="g1-button g1-button--medium g1-button--solid g1-button--standard" style="color: #FFFFFF;"><i class="icon-plus"></i> Asignar</a>
					                    </center>
					                </p>
					            </header>

					            <footer class="entry-footer"></footer>

					        <div class="g1-01"></div>
					    </div>
					</div>
				</li>
    			<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on">
					<div style="height: 300px;margin-bottom: 40px;background: none repeat scroll 0% 0% white;border: 1px solid rgb(204, 204, 204);border-radius: 8px 8px 0px 0px;">
						<div id="g1-message-5" class="g1-message g1-message--warning " style="font-size: 12px;border-radius: 7px 7px 0px 0px;">
							<div class="g1-inner">Pendiente por pago</div>
						</div>
						<figure class="entry-featured-media">
					        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center " href="http://3clicks.bringthepixel.com/overview-on-right-post/">
					            <span class="g1-decorator">
					                <img class="attachment-g1_one_fourth wp-post-image" width="96" alt="post_photo_23_v01" src="assets/back/img/template/habitacion_back.png"></img>
					            </span>
					        </a>
					    </figure>
					    <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
					        <div class="g1-inner">
					            <header class="entry-header">
					                <h3>
					                    <a title="Overview on Right">
					                        HAB02	
					                    </a>
					                </h3>
					                <p class="entry-meta g1-meta" style="font-size: 12px;">
				               			<a class="cliente_back">
				               				<i class="icon-plus-sign"></i><b> Checkin:</b> Fernando Pinto
				               				<br />
					               			<span class="datos" style="display: none;">
					               				<b>Telefono:</b> +584127762882
					               				<br />
					               				<b>Email</b> fp.nsce@gmail.com
					               			</span>
					               		</a>
					               		<br />
					               		<a class="cliente_back">
				               				<i class="icon-plus-sign"></i><b> Checkout:</b> Loboxy Lobo
				               				<br />
					               			<span class="datos" style="display: none;">
					               				<b>Telefono:</b> +584127762882
					               				<br />
					               				<b>Email</b> fp.nsce@gmail.com
					               			</span>
					               		</a>          
					                </p>
					            </header>
					            <!--
					
					             .entry-header 
					
					            -->
					            <footer class="entry-footer"></footer>
					            <!--
					
					             .entry-footer 
					
					            -->
					        </div>
					        <div class="g1-01"></div>
					    </div>
					</div>
				</li>
    			<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on">
					<div style="height: 300px;margin-bottom: 40px;background: none repeat scroll 0% 0% white;border: 1px solid rgb(204, 204, 204);border-radius: 8px 8px 0px 0px;">
						<div id="g1-message-5" class="g1-message g1-message--info " style="background-color:#B9B9B9;font-size: 12px;border-radius: 7px 7px 0px 0px;">
							<div class="g1-inner">Reservado</div>
						</div>
						<figure class="entry-featured-media">
					        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--info " href="http://3clicks.bringthepixel.com/overview-on-right-post/">
					            <span class="g1-decorator">
					                <img class="attachment-g1_one_fourth wp-post-image" width="96" alt="post_photo_23_v01" src="assets/back/img/template/habitacion_back.png"></img>
					            </span>
					        </a>
					    </figure>
					    <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
					        <div class="g1-inner">
					            <header class="entry-header">
					                <h3>
					                    <a title="Overview on Right">
					                        HAB03	
					                    </a>
					                </h3>
					                <p class="entry-meta g1-meta" style="font-size: 12px;">
				               			<a class="cliente_back">
				               				<i class="icon-plus-sign"></i><b> Huesped:</b> Fernando Pinto
				               				<br />
					               			<span class="datos" style="display: none;">
					               				<b>Telefono:</b> +584127762882
					               				<br />
					               				<b>Email</b> fp.nsce@gmail.com
					               			</span>
					               		</a>        
					                </p>
					            </header>
					            <!--
					
					             .entry-header 
					
					            -->
					            <footer class="entry-footer"></footer>
					            <!--
					
					             .entry-footer 
					
					            -->
					        </div>
					        <div class="g1-01"></div>
					    </div>
					</div>
				</li>
    			<li class="g1-column g1-one-fourth g1-valign-top g1-start-animation" data-g1-delay="on">
					<div style="height: 300px;margin-bottom: 40px;background: none repeat scroll 0% 0% white;border: 1px solid rgb(204, 204, 204);border-radius: 8px 8px 0px 0px;">
						<div id="g1-message-5" class="g1-message g1-message--error " style="font-size: 12px;border-radius: 7px 7px 0px 0px;">
							<div class="g1-inner">Cancelado</div>
						</div>
						<figure class="entry-featured-media">
					        <a id="g1-frame-1" class="g1-frame g1-frame--none g1-frame--inherit g1-frame--center " href="http://3clicks.bringthepixel.com/overview-on-right-post/">
					            <span class="g1-decorator">
					                <img class="attachment-g1_one_fourth wp-post-image" width="96" alt="post_photo_23_v01" src="assets/back/img/template/habitacion_back.png"></img>
					            </span>
					        </a>
					    </figure>
					    <div class="g1-nonmedia" style="margin-top: -40px;padding:10px;">
					        <div class="g1-inner">
					            <header class="entry-header">
					                <h3>
					                    <a title="Overview on Right">
					                        HAB04	
					                    </a>
					                </h3>
					                <p class="entry-meta g1-meta" style="font-size: 12px;">
				               			<a class="cliente_back">
				               				<i class="icon-plus-sign"></i><b> Cancelada por</b> Fernando Pinto
				               				<br />
					               			<span class="datos" style="display: none;">
					               				<b>Telefono:</b> +584127762882
					               				<br />
					               				<b>Email</b> fp.nsce@gmail.com
					               			</span>
					               		</a>        
					                </p>
					            </header>
					            <footer class="entry-footer"></footer>
					        </div>
					        <div class="g1-01"></div>
					    </div>
					</div>
				</li>
			</ul>
		</div>
    </div>
</div>	
<?php include('../footer.php'); ?>
