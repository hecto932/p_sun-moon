
<!-- BEGIN #g1-preheader -->
	<aside id="g1-preheader">
   		<div class="g1-layout-inner">
	       	<!-- BEGIN #g1-preheader-bar -->
	      	<div id="g1-preheader-bar" class="g1-meta">
	        </div>
            <!-- END #g1-preheader-bar -->
            
            <!--
			<nav style="margin-top: 0px;margin-right: 43px;" class="hide-for-small">
				<ul id="g1-primary-nav-menu" class="" style="float: right;">
					<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
						<a href="idioma/idioma/cambiar/es"><img src="assets/front/img/template/idiomas/banderas-01.png" style="width:20px;" /></a>
					</li>
					<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
						<a href="idioma/idioma/cambiar/en"><img src="assets/front/img/template/idiomas/banderas-02.png" style="width:20px;"/></a>
					</li>
					<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
						<a href="idioma/idioma/cambiar/fr"><img src="assets/front/img/template/idiomas/banderas-03.png" style="width:20px;"/></a>
					</li>
					<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
						<a href="idioma/idioma/cambiar/de"><img src="assets/front/img/template/idiomas/banderas-04.png" style="width:20px;"/></a>
					</li>
					<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
                		<a href="idioma/idioma/cambiar/it"><img src="assets/front/img/template/idiomas/banderas-05.png" style="width:20px;"/></a>
                	</li>
                	<li id="menu-item-535" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
                		<a href="idioma/idioma/cambiar/pt"><img src="assets/front/img/template/idiomas/banderas-06.png" style="width:20px;"/></a>
                	</li>
				</ul>
         	</nav>
         	
         	<nav style="margin-top: 10px;margin-right: 43px; a{ padding: 2px;}" class="show-for-small">
				<center>
				<a href="idioma/idioma/cambiar/es"><img src="assets/front/img/template/idiomas/banderas-01.png" style="width:20px;" /></a>
		
				<a href="idioma/idioma/cambiar/en"><img src="assets/front/img/template/idiomas/banderas-02.png" style="width:20px;"/></a>
			
				<a href="idioma/idioma/cambiar/fr"><img src="assets/front/img/template/idiomas/banderas-03.png" style="width:20px;"/></a>
			
				<a href="idioma/idioma/cambiar/de"><img src="assets/front/img/template/idiomas/banderas-04.png" style="width:20px;"/></a>
			
        		<a href="idioma/idioma/cambiar/it"><img src="assets/front/img/template/idiomas/banderas-05.png" style="width:20px;"/></a>
        	
        		<a href="idioma/idioma/cambiar/pt"><img src="assets/front/img/template/idiomas/banderas-06.png" style="width:20px;"/></a>
         		</center>
         	</nav>
         	
         	-->
           
       	<!-- END #g1-preheader-widget-area -->
		</div><!-- .g1-inner -->
        <div class="g1-background">
		</div>
</aside>
	<!-- END #g1-preheader -->

<!-- Twitter helper -->
<?php $tweets = get_tweets(lang('account_twitter')); ?>

<!-- BEGIN #g1-prefooter -->
<aside id="g1-prefooter">
	<div class="g1-twitter-toolbar">
		<div class="g1-twitter g1-twitter--carousel g1-auth-oauth ">
			<ul class="g1-twitter__items">
				<?php if(isset($tweets) && !empty($tweets)): ?>
					
					<?php foreach($tweets as $tweet): ?>
						
						<?php
							//Datos a mostrar 
							$usuario 	= $tweet->user;
							$date 		= new DateTime($tweet->created_at);
							$creado 	= $date->format('d-m-Y');
						?>
						
						<li>
							<div class="g1-twitter__item">
								<p class="g1-tweet-text"><?php echo $tweet->text; ?></p>
								<p class="g1-meta"><a href="<?php echo lang('front.cuenta_twitter'); ?>" rel="bookmark"><?php echo $usuario->name.' '.$creado; ?></a></p>
							</div>
						</li>
						
					<?php endforeach; ?>
				<?php else: ?>
					
					<li>
						<div class="g1-twitter__item">
							<p class="g1-tweet-text"><?php echo "texto"; ?></p>
							<p class="g1-meta"><a href="<?php echo lang('front.cuenta_twitter'); ?>" rel="bookmark"><?php echo "Admin creado:ya"; ?></a></p>
						</div>
					</li>
					
				<?php endif; ?>
				
			</ul>
			<p class="g1-twitter__follow"><a href="<?php echo lang('front.cuenta_twitter'); ?>">Siguenos en @<?php echo @$usuario->name; ?></a></p>
		</div>
	</div>
	<!--11.946469,-66.67631 
	<?php if (isset($title) && ! empty($title) && $title!="Contacto"): ?>
	
	<div class="g1-gmap-wrapper">
		<div id="g1-gmap-counter-1" class="g1-gmap" data-g1-gmap-config="{ map_type: 'roadmap',invert_lightness: '0',latitude: '11.946469',longitude: '-66.67631',zoom: '20',marker: 'standard',marker_icon: 'assets/front/images/gmap_marker_blue.png',type: 'rich',color: '#808080',color_hue: '#808080',color_saturation: '-100',color_lightness: '0.3921568627451' }" style="width: 100%; height: 680px;">
			<div class="g1-content" style="display: none;">
				<?php echo lang('footer.map_direccion'); ?>
			</div>
		</div>
	</div>
  	<?php endif ?>    
  	-->  
        
   	<!-- BEGIN #g1-prefooter-widget-area -->
   	<div  id="g1-prefooter-widget-area" class="g1-layout-inner hide-for-small">
   		<div class="g1-grid">
   			<center><h3><?php echo lang('footer.mapsite_title'); ?></h3></center>
      		<div class="g1-column g1-one-fourth hide-for-small">
       			<section id="nav_menu-2" class="widget widget_nav_menu g1-widget-list">
       				<header>
       					<h3 class="widgettitle"><?php echo lang('footer.mapsite_subtitle1'); ?></h3>
       				</header>
       				<div class="menu-custom-menu-1-container">
       					<ul id="menu-custom-menu-2" class="menu">
       						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
       							<a href="/"><?php echo lang('footer.mapsite_item1'); ?></a>
       						</li>
       						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
       							<a href="iniciar-sesion"><?php echo lang('footer.mapsite_item2'); ?></a>
       						</li>
						</ul>
					</div>
					
					<header>
       					<h3 class="widgettitle"><?php echo lang('footer.mapsite_subtitle2'); ?></h3>
       				</header>
       				<div class="menu-custom-menu-1-container">
       					<ul id="menu-custom-menu-2" class="menu">
       						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
       							<a href="nosotros"><?php echo lang('footer.mapsite_item3'); ?></a>
       						</li>
       						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-535">
       							<a href="nosotros/"><?php echo lang('footer.mapsite_item4'); ?></a>
       						</li>
						</ul>
					</div>
					
					<header>
       					<h3 class="widgettitle"><?php echo lang('footer.mapsite_subtitle3'); ?></h3>
       				</header>
       				<div class="menu-custom-menu-1-container">
       					<ul>
							<li>
								<a href="servicios/" title="Todos"><?php echo lang('footer.mapsite_item5'); ?></a>
							</li>
						</ul>
					</div>
				</section>
			</div>
         	<div class="g1-column g1-one-fourth hide-for-small">
         		<section id="recent-posts-3" class="widget widget_recent_entries g1-widget-list">	
         			<header>
         				<h3 class="widgettitle"></h3>
         			</header>	
         			
         			<ul>
						<li>
							<a href="servicios/2" title="Actividad"><?php echo lang('footer.mapsite_item6'); ?></a>
							<ul>
								<li>
									<a href="servicio/servicio_front/detalle/7" title="Excursión a una isla cercana por día"><?php echo lang('footer.mapsite_item6.1'); ?></a>
								</li>
								<li>
									<a href="servicio/servicio_front/detalle/8" title="Actividades Deportivas"><?php echo lang('footer.mapsite_item6.2'); ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="servicios/4" title="Promocional"><?php echo lang('footer.mapsite_item7'); ?></a>
							<ul>
								<li>
									<a href="servicio/servicio_front/detalle/1" title="Pensión Completa"><?php echo lang('footer.mapsite_item7.1'); ?></a>
								</li>
								<li>
									<a href="servicio/servicio_front/detalle/5" title="Media Pension"><?php echo lang('footer.mapsite_item7.2'); ?></a>
								</li>
								<li>
									<a href="servicio/servicio_front/detalle/6" title="Todo Incluido"><?php echo lang('footer.mapsite_item7.3'); ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="servicios/5" title="Transporte"><?php echo lang('footer.mapsite_item8'); ?></a>
							<ul>
								<li>
									<a href="servicio/servicio_front/detalle/9" title="Pasaje Aéreo"><?php echo lang('footer.mapsite_item8.1'); ?></a>
								</li>
							</ul>
						</li>
					</ul>
				</section>                
			</div>
        	<div class="g1-column g1-one-fourth hide-for-small">
         		<section id="recent-posts-3" class="widget widget_recent_entries g1-widget-list">
         			<header>
         				<h3 class="widgettitle">Reservaciones</h3>
         			</header>
         			<ul>
						<li>
							<a href="reservar" title="Todos">Reservar</a>
						</li>
					</ul>
         			<header>
         				<h3 class="widgettitle"><?php echo lang('footer.mapsite_subtitle4'); ?></h3>
         			</header>		
         			<ul>
						<li>
							<a href="testimonios/" title="Todos"><?php echo lang('footer.mapsite_item9'); ?></a>
						</li>
						<li>
							<a href="testimonios/facebook/" title="Actividad"><?php echo lang('footer.mapsite_item10'); ?></a>
						</li>
					</ul>
					<header><h3 class="widgettitle"><?php echo lang('footer.mapsite_subtitle5'); ?></h3></header>
					<ul>
						<li>
							<a href="contacto/" title="Todos"><?php echo lang('front.contacto_direccion'); ?></a>
						</li>
						<li>
							<a href="mailto:<?php echo lang('front.contacto_emailto'); ?>"><?php echo lang('front.contacto_email'); ?></a>
						</li>
					</ul>	
				</section>                
			</div>
			<div class="g1-column g1-one-fourth">
         		<section id="recent-posts-3" class="widget widget_recent_entries g1-widget-list">
         			<header>
         				<h3 class="widgettitle"></h3>
         			</header>
         			<ul>
         				<li>
							<a href="contacto/"><?php echo lang('front.contacto_telefonos_footer'); ?></a>
						</li>
						<li>
							<a hreft="contacto"><?php echo lang('front.contacto_nombre'); ?></a>
						</li>
					</ul>			
				</section>                
			</div>
    	</div>
   	</div>
   	<div class="large-12  columns show-for-small footer">
			<div class="large-9 columns">
				<h4>Contactanos</h4>
				<span><i class="foundicon_general-location"></i><b> Direccion: </b><?php echo lang('front.contacto_direccion'); ?></span>
				<br />
				<br />
				<span><i class="foundicon_general-phone"></i><b> Telefono: </b><?php echo lang('front.contacto_telefonos_footer'); ?></span>
				<br />
				<br />
				<span><i class="foundicon_general-mail"></i><b> Email: </b><a href="mailto:<?php echo lang('front.contacto_emailto'); ?>"><?php echo lang('front.contacto_email'); ?></a></span>
				<br />
				<br />
			</div>
		</div>
	<!-- END #g1-prefooter-widget-area -->

	<div class="g1-background">
	
	</div>
</aside>
<!-- END #g1-prefooter -->

	
<!-- BEGIN #g1-footer -->
<footer id="g1-footer" role="contentinfo" class="">
	<!-- BEGIN #g1-footer-area -->
 	<div id="g1-footer-area" class="g1-layout-inner">
 		<nav id="g1-footer-nav">
 			<div class="hide-for-small">
	      		<ul id="g1-footer-nav-menu" class="">
	      			<li id="menu-item-339" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-339">
	      				<a href="/"><?php echo lang('front_title.inicio'); ?></a>
	      			</li>
					<li id="menu-item-2122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2122">
						<a href="<?php echo lang('front.nosotros_url'); ?>"><?php echo lang('front_title.nosotros'); ?></a>
					</li>
					<li id="menu-item-2122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2122">
						<a href="<?php echo lang('front.servicios_url'); ?>"><?php echo lang('front_title.servicios'); ?></a>
					</li>
					<li id="menu-item-2122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2122">
						<a href="<?php echo lang('front.testimonios_url'); ?>"><?php echo lang('front_title.testimonios'); ?></a>
					</li>
					<li id="menu-item-1928" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1928">
						<a href="<?php echo lang('front.contacto_url'); ?>"><?php echo lang('front_title.contacto'); ?></a>
					</li>
				</ul>  
			</div> 
		</nav>
   		<p id="g1-footer-text" class="derechos"><a href="<?php echo lang('footer.wintech'); ?>"><img src="assets/front/images/wintech.png" width="64"/></a>&copy; <?php echo lang('footer.derechos'); ?></p>
	</div>
 	<!-- END #g1-footer-area -->
  	<div class="g1-background">
	
	</div>	

</footer>
<!-- END #g1-footer -->

<a href="#page" id="g1-back-to-top">Volver arriba</a>
    	
</div>
<!-- END #page -->

	<!-- DATEPICKER -->
	

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="assets/front/js/jquery-1.9.1.js"></script>
	<script src="assets/front/js/jquery-ui.js"></script>
	<script type="text/javascript" src="assets/front/js/jquery.mask.min.js"></script>
	<script type="text/javascript" src="assets/front/js/jquery.ui.datepicker-es.js"></script>
	
	
	<script>
	jQuery(document).ready(function ($) {


		var myDate = new Date();
		var prettyDate = myDate.getDate() + '-' + (myDate.getMonth()+1) + '-' +myDate.getFullYear();
		
		$( "#datepicker1").datepicker({
			dateFormat:"dd-mm-yy",
			minDate:"+1D",
			onClose: function (selectedDate) {
				$("#datepicker2").datepicker("option", "minDate", selectedDate);
			}
		});
		
		$( "#datepicker2").datepicker({
			dateFormat:"dd-mm-yy",
			maxDate:"+366D",
			onClose: function (selectedDate) {
				$("#datepicker1").datepicker("option", "maxDate", selectedDate);
			}
		});
		
		var currentDate = new Date();  
		$( "#datepicker3").datepicker({
			dateFormat:"dd-mm-yy",
			maxDate: currentDate
		});
		
		
		
		//$('.phone').mask('0000 - 000 0000');
		$('.phone').mask('000000000000');
		//VALIDANDO LA HORA 00:00 a 23:59
		var timeMask1 	= 	function(time, e, currentField, options){
  								return time.match(/^0[0-9]|1[0-9]|2[0-3]:[0-5][0-9]$/) ? '00:00': $("input[name='hora_llegada']").val('00:00');	
							};
		var timeMask2 	= 	function(time, e, currentField, options){
  								return time.match(/^0[0-9]|1[0-9]|2[0-3]:[0-5][0-9]$/) ? '00:00': $("input[name='hora_salida']").val('00:00');	
							};
		
		//VALIDACIONES REGISTRO DE RESERVA	--- INICIO
		$( "#nombre_completo_div").focusout(function() {
			var valor = $("input[name='nombre_completo']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#nombre_completo_div").focusin(function() {
			var valor = $("input[name='nombre_completo']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#email_div").focusout(function() {
			var valor = $("input[name='email']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#email_div").focusin(function() {
			var valor = $("input[name='email']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#telefono_div").focusout(function() {
			var valor = $("input[name='telefono']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#telefono_div").focusin(function() {
			var valor = $("input[name='telefono']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#nacionalidad_div").focusout(function() {
			var valor = $("input[name='nacionalidad']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#nacionalidad_div").focusin(function() {
			var valor = $("input[name='nacionalidad']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#aereolinea_div").focusout(function() {
			var valor = $("input[name='aereolinea']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#aereolinea_div").focusin(function() {
			var valor = $("input[name='aereolinea']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#mensaje_div").focusout(function() {
			var valor = $("input[name='mensaje']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#mensaje_div").focusin(function() {
			var valor = $("input[name='mensaje']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		/* ------------------------------------------------------- */
		$( "#captcha_div").focusout(function() {
			var valor = $("input[name='captcha']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#captcha_div").focusin(function() {
			var valor = $("input[name='captcha']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		
		/* ------------------------------------------------------- */
		$( "#comentario_div").focusout(function() {
			var valor = $("input[name='comentario']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#comentario_div").focusin(function() {
			var valor = $("input[name='comentario']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		
		//VALIDACIONES REGISTRO DE RESERVA	--- FIN
		
		//VALIDACIONES REGISTRO USUARIO	-- INCIO
		
		$('input[name="telefono"]').keydown(function(event){
	        //backspace, delete, tab, escape, enter and .
	        if ($.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
	            											/*Ctrl+A*/ (event.keyCode == 65 && event.ctrlKey === true) || 
	            							/*home, end, left, right*/ (event.keyCode >= 35 && event.keyCode <= 39)){
				//let it happen, don't do anything
				return;
	        }
	        else{
	            // Ensure that it is a number and stop the keypress
	            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )){
	                event.preventDefault(); 
	            }
	        }
	    });
		
		$( "#direccion_div").focusout(function() {
			
			var valor = $(this).val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#direccion_div").focusin(function() {
			var valor = $(this).val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		
		$( "#nombre_div").focusout(function() {
			var valor = $("input[name='nombre']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#nombre_div").focusin(function() {
			var valor = $("input[name='nombre']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		
		$( "#password_div").focusout(function() {
			var valor = $("input[name='password']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#password_div").focusin(function() {
			var valor = $("input[name='password']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		
		$( "#repassword_div").focusout(function() {
			var valor = $("input[name='repassword']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#telefono_div").focusout(function() {
			var valor = $("input[name='telefono']").val();
			if(valor=="")
				$(this).find( "small" ).css( "display", "inherit" );
		});
		
		$( "#repassword_div").focusin(function() {
			var valor = $("input[name='repassword']").val();
			if(valor=="" )
				$(this).find( "small" ).css( "display", "none" );
		});
		//VALIDACIONES REGISTRO USUARIO -- FIN	
		
		$('#hora_llegada').timepicker();
		$('#hora_salida').timepicker();
		
		$('#referencia').mask('####################');
		
	});
	
	var j = jQuery.noConflict();
	j(function () {
		j('.footable').footable();
	});
	
	
	</script>

	
	<!-- /DATEPICKER -->

<!-- JAVASCRIPT-->

<script type='text/javascript' src='assets/front/js/main.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.touchSwipe.min.js'></script>
<script type='text/javascript' src='assets/front/js/galleria-1.2.9.min.js'></script>
<script type='text/javascript' src='assets/front/js/galleria.classic.js'></script>
<script type='text/javascript' src='assets/front/js/g1-simple-sliders.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.metadata.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.easing.1.3.js'></script>
<script type='text/javascript' src='assets/front/js/breakpoints.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.carouFredSel-6.2.0-packed.js'></script>
<script type='text/javascript' src='assets/front/js/waypoints.min.js'></script>
<script type='text/javascript' src='assets/front/js/skrollr.min.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.magnific-popup.min.js'></script>
<script type='text/javascript' src='assets/front/js/modifications.js'></script>
<script type='text/javascript' src='assets/front/js/add-to-cart.min.js'></script>
<script type='text/javascript' src='assets/front/js/jquery.blockUI.min.js'></script>
<script type="text/javascript" src="assets/front/js/jquery-ui-timepicker-addon.js"=></script>


<!-- JAVASCRIPT-->
<script type='text/javascript' src='assets/front/js/jquery.placeholder.min.js'></script>

<!-- <script type='text/javascript' src='assets/front/js/maps.js'></script> -->
<!-- <script type='text/javascript' src='assets/front/js/infobox_packed.js'></script> -->
<script type='text/javascript' src='assets/front/js/g1-gmap.js'></script>
<script src="assets/front/footable/js/footable.js" type="text/javascript"></script>	
<!-- /JAVASCRIPT-->
<!-- /JAVASCRIPT-->

<!-- <script type='text/javascript' src='assets/front/js/g1-mailchimp.js'></script> -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQpNC7B4MSSPHpEgBzVwuRcQdNhsaWMEg&sensor=true"></script>-->

<script>
	function muestra_oculta(id)
	{
		if (document.getElementById)
		{ //se obtiene el id
			var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
			el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
		}
	}
	
	function cambiar(id,frase)
	{
		document.getElementById(id).innerHTML = frase;
	}
	
	//window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
		//muestra_oculta('g1-demo-container');/* "contenido_a_mostrar" es el nombre de la etiqueta DIV que deseamos mostrar */
		//muestra_oculta('lang_sel');
		//cambiar('g1-preheader__switch','<h3>Languages</h3>')
	//}
	
</script>

</body>
</html>