
<div id="g1-precontent">
	<div class="g1-background">
	</div>
	<header class="entry-header g1-layout-inner">
  		<div class="g1-hgroup">
    		<h1 class="entry-title hide-for-small"><?php echo lang('front.reserva.habitaciones.titulo'); ?></h1>
    		<h1 class="entry-title show-for-small" style="font-size: 26px;"><?php echo lang('front.reserva.habitaciones.titulo'); ?></h1>
      	</div>
  	</header>
</div>

<div id="g1-content">
	<div class="g1-layout-inner">
		<nav class="g1-nav-breadcrumbs g1-meta">
   			<p class="assistive-text"><?php echo lang('front.reserva.habitaciones.breadcrumb1'); ?> </p>
   			<ol>
   				<li class="g1-nav-breadcrumbs__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
   					<a itemprop="url" href="/"><span itemprop="title"><?php echo lang('front.reserva.habitaciones.breadcrumb2'); ?></span></a>
   				</li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.reserva.habitaciones.breadcrumb3'); ?></li>
   				<li class="g1-nav-breadcrumbs__item"><?php echo lang('front.reserva.habitaciones.breadcrumb4'); ?></li>
   			</ol>
   		</nav> 
   		<div>
   			<h2><?php echo lang('front.reserva.habitaciones.subtitulo1'); ?></h2>
   			<p>
				<?php echo lang('front.reserva.habitaciones.p1'); ?> <b style="font-size: 20px;"><?php echo $fecha_llegada; ?></b> hasta <b style="font-size: 20px;"><?php echo $fecha_salida; ?></b>, para <b style="font-size: 20px;"><?php echo $noches; ?></b> noches.
   			</p>
   			<?php	if(form_error('tip_hab'))
						echo form_error('tip_hab');
			?>
   		</div>
   		<!-- reserva/reserva_front/datos_reserva -->
   		
   		<form action="<?php echo lang('front.reserva_url').'/'.lang('front.datos_url'); ?>" method="post"> 
   			<input type="hidden" name="fecha_llegada" value="<?php echo $fecha_llegada; ?>" />
   			<input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida; ?>" />
   			<input type="hidden" name="noches" value="<?php echo $noches; ?>" />
   			<input type="hidden" name="temporada" value="<?php echo $temporada; ?>" />
			<div id="g1-table-1" class="g1-table g1-table--solid ">
		    	<table>
		        	<thead>
		            	<tr>
		                	<th style="width: 20%;"><?php echo lang('front.reserva.habitaciones.tipo_habitacion'); ?></th>
			                <th style="width: 20%;"><?php echo lang('front.reserva.habitaciones.condiciones'); ?></th>
			                <th style="width: 10%;"><?php echo lang('front.reserva.habitaciones.max'); ?></th>
			                <th style="width: 10%;"><?php echo lang('front.reserva.habitaciones.precio'); ?></th>
			                <th style="width: 30%;"><?php echo lang('front.reserva.habitaciones.habitaciones'); ?></th>
		            	</tr>
		        	</thead>
		        	<tbody>
		        		<!-- HABITACION 1-->
		        		<?php $existen = false;?>
		        		<?php foreach($hab_disponibles as $habitacion): ?>
		        			<?php if($habitacion->habitaciones>0): ?>
		        				<?php $existen=true; ?>
			        			<tr>
				            		<td style="width: 260px;">
				            			<div>
				            				<h5><?php echo $habitacion->tipo; ?></h5>
				            				<img src="assets/front/img/template/reservas/habitaciones/habitacion-classic.jpg" style="width: 260px;"/>
				            				<p><?php echo $habitacion->tipo_descrip; ?></p>
				            			</div>
				            		</td>
				                	<td style="width: 260px;"> 
				                		<ul style="font-size: 12px; text-decoration: bold;">
				                			<li><p><?php echo lang('front.reserva.habitaciones.p2'); ?></p></li>		                			
				                		</ul>
				                	</td>
				                	<td>
				                		<?php for($i=0;$i<$habitacion->personas;++$i): ?>
				                			<i class="icon-user"></i>
				                		<?php endfor;?>
				                		
				                	</td>
				                	<td>
				                		<center>
				                		<h5>
				                			<?php echo $habitacion->moneda_abreviado; ?>
				                			<br />
				                			<?php echo $habitacion->valor;?>
				                		</h5>
				                		</center>
				                	</td>
				                	<td>
				                		<select name="tip_hab[<?php echo $habitacion->id_tipo_habitacion; ?>]">
				                			<option value="0">0</option>
				                		<?php for($i=1;$i<=$habitacion->habitaciones;++$i): ?>
				                			<option value="<?php echo $i; ?>"><?php echo $i." (".$habitacion->moneda_abreviado." ".$i*$habitacion->valor*$noches.")"; ?></option>
				                		<?php endfor; ?>
				                		</select>
				                		<p>
				                			<?php echo lang('front.reserva.habitaciones.calculo'); ?>
				                		</p>
				                	</td>
				            	</tr>
				       		<?php endif;?>
		        		<?php endforeach; ?>
		        	</tbody>
		    	</table>
			</div>
			<?php if(!$existen): ?>
				<p><?php echo lang('front.reserva.habitaciones.p3'); ?> <b style="font-size: 20px;"><?php echo $fecha_llegada." hasta ".$fecha_salida; ?></b>, por favor intente con una nueva fecha </p>
				<div class="form-row">
					<center>
						<a class="button" href="<?php echo lang('front.inicio_url'); ?>" style="color: #ffffff;"><?php echo lang('front.mensaje-volver-inicio')?></a>
					</center>
				</div>
			
			<?php else: ?>
				<div class="form-row">
					<center>
						<a class="button" style="background-color: rgb(191, 18, 34);border-color: rgb(191, 18, 34);" href="<?php echo lang('front.inicio_url'); ?>"><i class="icon-remove"></i> <?php echo lang('front.reserva.habitaciones.btn2'); ?></a>
						<button type="submit" class="button"><?php echo lang('front.reserva.habitaciones.btn1'); ?></button>		
					</center>
				</div>
			<?php endif;?>
		</form>
	</div>
</div>
