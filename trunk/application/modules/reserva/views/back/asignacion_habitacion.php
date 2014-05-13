<script type="text/javascript">
	
	$(document).ready(function()
	{
		//Forzar change
		//$('select[name="tipo_habitacion"]').change();
		
		//Change select
		$('select[name="tipo_habitacion"]').change(function()
		{
			get_reserva_tipo();
		});
		
		//Mostrar tipos habitacion
		function get_reserva_tipo()
		{
			//Tipo habitacion seleccionada
			var id_tipo_habitacion 	= $('select[name="tipo_habitacion"]').val();
			var id_reservacion		= <?php echo $id_reservacion; ?>;
			
			//En caso de realizar la asignacion desde el top-menu "Asignación de habitación"
			var redirect_asignacion = '<?php echo (isset($redirect_asignacion) && !empty($redirect_asignacion)) ? $redirect_asignacion : '0'; ?>';
			
			if(id_tipo_habitacion != -1)
			{
				$.ajax({
				type: 		'POST',
				dataType: 	'html',
				url: 		'<?php echo site_url('reserva/reserva/ajax_get_reserva_tipo_habitacion'); ?>',
				data: 		{ 'id_tipo_habitacion' : id_tipo_habitacion, 'id_reservacion' : id_reservacion, 'redirect_asignacion' : redirect_asignacion},
				success: 	function(html)
							{
								var altura = <?php echo (count($data_asignacion) * 370); ?>;
								$('#AsignacionTab').css('height', altura+'px');
								$('.ajax_html').html(html);
							}
				});
			}

		}
	});
	
</script>

<h3><?php echo lang('asigmacion_habitacion'); ?></h3>

	<div class="ficha_servicio">
		
		<div class="twelve columns">
			
			<!-- Si el estado es cancelada o pendiente pago -->
			<?php if($reservacion[0]->id_estado_reservacion == 1 || $reservacion[0]->id_estado_reservacion == 2): ?>
				
				<div class="twelve columns">
					<div class="alert-box">
						<span><?php echo lang('reservacion_asignacion_mensaje1'); ?></span>
						<a class="close" href="">×</a>
					</div>
				</div>
				
			<?php else: ?>
			
				<div class="twelve columns">
					<div class="four columns">
						<?php //$temp = (isset($selected_tipo_habitacion) && !empty($selected_tipo_habitacion) ? $selected_tipo_habitacion : ''); ?>
						<strong><?php echo 'Tipo habitación'; ?></strong><?php echo form_dropdown('tipo_habitacion', $opt_tipo_habitacion, set_value('tipo_habitacion')); ?>
					</div>
					<div class="eight columns"></div><br /><br /><hr />
				</div>
				
				<?php if(isset($asignacion_error) && $asignacion_error): ?>
				<div class="twelve columns">
					<div class="alert-box alert">
						<span><?php echo lang('reservacion_asignacion_error'); ?></span>
						<a class="close" href="">×</a>
					</div>
				</div>
				<?php endif; ?>
				
				<!-- AJAX AJAX AJAX -->
				<div class="twelve columns ajax_html"></div>
			
			<?php endif; ?>
			
		</div>
		
	</div>

<div class="row">
	<div class="twelve columns">
		<?php
			//if($this->session->userdata('idioma') == 'es')
				//echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('editar_url').'_'.lang('reservacion_url').'/'.$reservacion->id_reservacion, lang('editar_tit_reserva'), array('title'=>'Editar', 'class' => 'button radius wtc'));
			//else
				//echo anchor(lang('backend_url').'/'.lang('reservaciones_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$reservacion->id_reservacion, lang('editar_tit_reserva'), array('title'=>'Editar', 'class' => 'button radius wtc'));
		?>
	</div>
</div>