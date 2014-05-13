		<ul id="tabs">
			<li><a href="#tabFicha" title=""> <?php echo lang('contacto')."'s ".lang('ficha'); ?></a></li>
		</ul>
		<div id="ficha">
			<div class="tab" id="tabFicha">	
				<h2> <?php echo $contacto->correo; ?></h2>
				<dl class="ficha_obra">	
					<?php if(isset($contacto->correo)): ?>
						<dt> <?php echo lang('contacto_nombre'); ?> </dt>
						<dd> <?php echo $contacto->correo; ?> </dd>
					<?php endif; ?>
					
					<?php if(isset($contacto->creacion)): ?>
						<dt> <?php echo lang('contacto_creacion'); ?> </dt>
						<dd> <?php echo $contacto->creacion; ?> </dd>
					<?php endif; ?>
				</dl>
				<strong class="boton">
					<?php echo anchor(lang('backend_url').'/'.lang('contactos_url').'/'.lang('listado_url'), lang('contacto_listado'), array('title'=> lang('operadora_listado_titulo'))); ?>
				</strong>
				
			</div>
			
			
		</div>
