<script>

$(document).ready(function(){
	$('.inicio_hospedaje').click(function(){
		$('#tit_seccion').text('<?php echo lang("servicios.hospedaje_tit"); ?>');
		$('#cont_seccion').empty();
		$('#cont_seccion').append("<p><strong>"+"<?php echo lang('servicios.hospedaje_subt'); ?>"+"</strong></p>");
		$('#cont_seccion').append("<p>"+"<?php echo lang('servicios.hospedaje_p1'); ?>"+"</p>");
		$('#cont_seccion').append("<p>"+"<?php echo lang('servicios.hospedaje_p2'); ?>"+"</p>");
		$('#cont_seccion').append("<p>"+"<?php echo lang('servicios.hospedaje_p3'); ?>"+"</p>");
		$('#cont_seccion').append("<ul id='ul_seccion'>");
		<?php $cont = lang('servicios.hospedaje_ul'); ?>
		<?php for($i = 1; $i < $cont; $i++): ?>
			$("<li><?php echo lang('servicios.hospedaje_li'.$i); ?></li>").appendTo("#ul_seccion");
		<?php endfor; ?>

	});

	<?php if(isset($habitaciones)): ?>
		<?php foreach($habitaciones as $key => $value): ?>
			$('#habitacion_<?php echo $value->id_servicio; ?>').click(function(event){
				event.preventDefault();
				if($('#habitacion_<?php echo $value->id_servicio; ?>').not('.active')){
					var activo = $('#lista_habitaciones').find('.active');
					if(activo.hasClass('active')){
						activo.removeClass('active');
					}
					$('#habitacion_<?php echo $value->id_servicio; ?>').addClass('active');
				}
				$('#tit_seccion').text('<?php echo $value->nombre; ?>');
				
				<?php if(empty($value->fichero)) : ?>
						$('#resena_imagen').attr('src', '<?php echo base_url().'assets/front/img//template/placeholder/placeholder_large.jpg'; ?>');
				<?php elseif(isset($value->fichero) && !empty($value->fichero)): ?>
					$('#resena_imagen').attr('src', '<?php echo base_url().'assets/front/img/med/'.$value->fichero; ?>');
				<?php endif; ?>
				
				$('#cont_seccion').empty();
				<?php if(isset($value->descripcion_ampliada) && $value->descripcion_ampliada != ''): ?>
					var temp = <?php echo json_encode($value->descripcion_ampliada); ?>;
					$('#cont_seccion').html(temp);
				<?php endif; ?>
				
			});
		<?php endforeach; ?>
	<?php endif; ?>

});


</script>

