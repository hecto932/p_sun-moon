	<p class="welcome"> <?php echo lang('bienvenido'); ?>  <span><?php echo $userdata['nombre']." ".$userdata['apellidos']?></span></p> 
		<strong class="oculto"> <?php echo lang('menu_opt_usr'); ?> </strong>		
		<ul id="menu_user">
			<?php
		/*	<li> 
				<strong>
	    			<?php echo ($this->session->userdata('idioma') == 'es') ? lang('spanish.idioma') : '<a href="'.base_url().'idioma/idioma/cambiar_idioma/es'.'">'.lang('spanish.idioma').'</a>'; ?> 
	    		</strong>
	    	</li>
	    			/
	    	<li>
	    		<strong>
	    			<?php echo ($this->session->userdata('idioma') == 'en') ? lang('ingles.idioma') : '<a href="'.base_url().'idioma/idioma/cambiar_idioma/en'.'">'.lang('ingles.idioma').'</a>'; ?>	
	    		</strong>  
			</li>*/
			?> 
			<li><?php echo anchor(lang('backend_url').'/'.lang('usuarios_url').'/logout', lang('salir_sistema'), array('title'=> lang('salir_sistema')))?></li>
			 
		</ul> 
