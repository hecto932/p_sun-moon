
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.reservacion.usuario.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size:22px;"><?php echo lang('front.reservacion.usuario.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.reservacion.usuario.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.reservacion.usuario.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.reservacion.usuario.breadcrumb3'); ?></li>
   			</ol>
   		</nav>
   		
   		<?php if(!empty($update)): ?>
   			<div id="mensaje_pago" class="g1-message g1-message--success ">
				<div id="mensaje" class="g1-inner">
					<?php echo $update; ?>
				</div>
			</div>
		<?php endif; ?>
   		
   		<?php if(empty($mensaje)): ?> 
				<div>
		    		<table class="footable table metro-blue">
			        	<thead>
			            	<tr>
			                	<th ><?php echo lang("front.reservacion.usuario.codigo_reserva"); ?></th>
				                <th data-hide="phone"><?php echo lang("front.reservacion.usuario.personas"); ?></th>
				                <th data-hide="phone"><?php echo lang("front.reservacion.usuario.aerolinea"); ?></th>
				                <th ><?php echo lang("front.reservacion.usuario.checkin"); ?></th>
				                <th data-hide="phone"><?php echo lang("front.reservacion.usuario.checkout"); ?></th>
				                <th data-hide="phone"><?php echo lang("front.reservacion.usuario.estado_reserva"); ?></th>
				                <th ><?php echo lang("front.reservacion.usuario.detalles"); ?></th>
			            	</tr>
			        	</thead>
			        	<tbody>

			        		
				        		<?php foreach($reservaciones as $r => $value): ?>
					        		<tr style="text-align: center;">
					        			
						        			<td><?php echo $value->codigo_reserva; ?></td>
						        			<td><?php echo $value->personas; ?></td>
						        			<td><?php echo $value->aerolinea; ?></td>
						        			<td><?php echo $value->checkin; ?></td>
						        			<td><?php echo $value->checkout; ?></td>
						        			<td><?php echo $value->id_estado_reservacion; ?></td>
						        			<td><a href="<?php echo lang('front.detalle-reserva_url').'/'.$value->codigo_reserva; ?>">Ver</a></td>
					        		</tr>
				        		<?php endforeach; ?>
			        	</tbody>
			    	</table>
				</div>
			<?php else: ?>
	    		<div id="mensaje_pago" class="g1-message g1-message--error ">
					<div id="mensaje" class="g1-inner">
						<?php echo $mensaje; ?>
					</div>
				</div>
		   	<?php endif;?>
		<div class="form-row">
			<center>
				<a class="button" href="<?php echo lang('front.inicio_url'); ?>" style="color: #ffffff;"><i class="icon-reply-all"></i> <?php echo lang('front.mensaje-volver-inicio')?></a>
			</center>
		</div>
	</div>
</div>
