<?php echo (isset($panel_botones) && !empty($panel_botones)) ? $panel_botones : '' ?>

<div class="row">
	<div class="twelve columns">
		<?php if(isset($breadcrumbs)): ?><?php echo $breadcrumbs; ?><?php endif; ?>
		
		<?php if(isset($mensaje_flash) && !empty($mensaje_flash)):?>
			
			<div class="alert-box alert"><?php echo $mensaje_flash; ?><a class="close" href="">×</a></div>
			
		<?php endif; ?>
		
		<dl class="tabs contained ten-up">
			
			<?php if(isset($huespedes_actuales) && !empty($huespedes_actuales)): ?>
				<dd <?php echo ($sub_activo == 'Huespedes') ? 'class="active"' : '' ; ?> >
					<a href="#Huespedes">
						<i class="foundicon-idea"></i>
						<span><?php echo 'Resumen'; ?></span>
					</a>
				</dd>
			<?php endif; ?>
			
			<?php if(isset($habitaciones_actuales) && !empty($habitaciones_actuales)): ?>
				<dd <?php echo ($sub_activo == 'Habitaciones') ? 'class="active"' : '' ; ?> >
					<a href="#habitaciones">
						<i class="foundicon-idea"></i>
						<span><?php echo 'Habitaciones'; ?></span>
					</a>
				</dd>
			<?php endif; ?>
			
		</dl>

		<ul class="tabs-content contained">
			
			<?php if(isset($huespedes_actuales) && !empty($huespedes_actuales)): ?>
				<li id="HuespedesTab"  <?php echo ($sub_activo == 'Huespedes') ? 'class="active"' : '' ; ?> >
					<?php echo $huespedes_actuales; ?>
				</li>
			<?php endif; ?>
			
			<?php if(isset($habitaciones_actuales) && !empty($habitaciones_actuales)): ?>
				<li id="habitacionesTab"  <?php echo ($sub_activo == 'Habitaciones') ? 'class="active"' : '' ; ?> >
					<?php echo $habitaciones_actuales; ?>
				</li>
			<?php endif; ?>
			
		</ul>
		
	</div>
</div>
