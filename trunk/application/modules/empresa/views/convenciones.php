<div class="row">
	<div class="twelve columns">
		<div class="tit_bread">
			<h1 class="hide-for-small"><?php echo lang('wtc.titulo_secc'); ?></h1>
			<h2 class="show-for-small"><?php echo lang('wtc.titulo_secc'); ?></h2>
			<ul class="breadcrumbs hide-for-touch">
				<?php if(isset($breadcrumbs) && !empty($breadcrumbs)): ?>
					<?php
						$cont = 1;
						$limite = count($breadcrumbs);
						foreach($breadcrumbs as $key => $value):
					?>
						<?php if($cont == $limite): ?>
							<li class="current" ><a href="#"><?php echo $value; ?></a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url().$key; ?>"><?php echo $value; ?></a></li>
						<?php endif; ?>

					<?php
						$cont++;
						endforeach;
					?>
				<?php endif; ?>

			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="six columns convenciones" style="margin-top: 35px">
		<img class="img_principal" src="<?php echo base_url(); ?>assets/front/img/template/convenciones/convenciones_principal.jpg" alt="convencion_principal">
        <img class="img_secundaria" src="<?php echo base_url(); ?>assets/front/img/template/convenciones/convenciones_secundaria.jpg" alt="convencion_secundaria">
	</div>
	
	<div class="six columns">
		<h3><span style="color: #B2B2B2;"><?php echo lang('empresa.convenciones_tit'); ?></span><br></h3>
        <p><br></p>
        <p><?php echo lang('empresa.convenciones_p1'); ?></p>
        <p><?php echo lang('empresa.convenciones_p2'); ?></p>
        <p><?php echo lang('empresa.convenciones_p3'); ?></p>
	</div>
	
</div>


<div class="row">
	<div class="five columns centered" style="margin-top: 35px">
		<h3> Centro de convenciones </h3>
	</div>
</div>

<div class="row" style="margin-top: 25px;margin-right: 21%">
	<div class="three columns"></div>
	<div class="nine columns">
		<div class="ten columns no-padding">
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="assets/front/img/template/convenciones/convenciones_01.jpg" rel="shadowbox[convenciones]" title="Centro de Convenciones Gran Salon">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/convenciones/thumbnails/convenciones_01.jpg" width="100" height="75" alt="convencion1">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="assets/front/img/template/convenciones/convenciones_02.jpg" rel="shadowbox[convenciones]" title="Centro de Convenciones Montaje Salon VIP" >
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/convenciones/thumbnails/convenciones_02.jpg" width="100" height="75" alt="convencion2">
	        	</a>
			</div>
			<div class="mobile-two-gallery two columns no-padding">
				<a class="fancybox" href="assets/front/img/template/convenciones/convenciones_03.jpg" rel="shadowbox[convenciones]" title="Centro de Convenciones Exposicion comercial caroni y cabriales">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/convenciones/thumbnails/convenciones_03.jpg" width="100" height="75" alt="convencion3">
	        	</a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="assets/front/img/template/convenciones/convenciones_04.jpg" rel="shadowbox[convenciones]" title="Centro de Convenciones Salones VIP">
		        	<img src="<?php echo base_url(); ?>assets/front/img/template/convenciones/thumbnails/convenciones_04.jpg" width="100" height="75" alt="convencion4">
		        </a>
			</div>
			<div class="mobile-two end two columns no-padding">
				<a class="fancybox" href="assets/front/img/template/convenciones/convenciones_05.jpg" rel="shadowbox[convenciones]" title="Centro de Convenciones Exposicion comercial sotano 1">
	        		<img src="<?php echo base_url(); ?>assets/front/img/template/convenciones/thumbnails/convenciones_05.jpg" width="100" height="75" alt="convencion5">
	        	</a>
			</div>
		</div>
	</div>
</div>


 <!--
<div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
                              
                                <div class="art-postcontent art-postcontent-0 clearfix"><div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="barras" ></div>
    </div>
</div>
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell" style="width: 48%; float: left;" >
        
    </div><div class="art-layout-cell layout-item-0" style="width: 45%; float: left;" >
        
<p></p>
    </div>
    </div>
</div>
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell" style="width: 100%" >
          
        
   G A L E R I A  D E  F O T O S   --------------------------------
  
  
 <script type="text/javascript" charset="utf-8">

	$(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'facebook',
			animation_speed: 'slow', /* fast/slow/normal */
			slideshow: 5000, /* false OR interval time in ms */
			autoplay_slideshow: true, /* true/false */
			opacity: 0.80, /* Value between 0 and 1 */
			show_title: true, /* true/false */
			allow_resize: true, /* Resize the photos bigger than viewport. true/false */
			default_width: 600,
			default_height: 447,
			counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			horizontal_padding: 20, /* The padding on each side of the picture */
			hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
			wmode: 'opaque', /* Set the flash wmode attribute */
			autoplay: true, /* Automatically start videos: True/False */
			modal: false, /* If set to true, only the close button will close the window */
			deeplinking: true, /* Allow prettyPhoto to update the url to enable deeplinking. */
			overlay_gallery: true, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
			keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
			changepicturecallback: function(){}, /* Called everytime an item is shown/changed */
			callback: function(){}, /* Called when prettyPhoto is closed */
			ie6_fallback: true,
			
		});
	});
</script>
   
  <div class="galeria-fotos">  
  	<div class="barra-azul"></div>
    	
        

        
 <div class="barra-azul"></div>
 
   </div>  
<a href="images/fullscreen/convenciones-6.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>   
<a href="images/fullscreen/convenciones-7.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-8.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-9.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-10.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-11.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-12.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-13.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-14.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
<a href="images/fullscreen/convenciones-15.jpg" rel="prettyPhoto[pp_cong]" title="Centro de Convenciones Exposicion comercial sotano 1"></a>  
   
    
    -->
  
   <!--  G A L E R I A  D E  F O T O S   -------------------------------- 
   
    
    
    </div>
    </div>
</div>
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="barras" ></div>
    </div>
</div>
</div>
                
</article></div>-->
                   