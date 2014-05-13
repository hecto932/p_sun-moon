<script>
$(document).ready(function(){
	$('#description_2').hide();
	<?php if(isset($tipo_servicios)): ?>
		<?php foreach($tipo_servicios as $tipo): ?>
			<?php if($tipo->nombre_tipo != 'hospedaje'): ?>
				$('#opcion_<?php echo $tipo->id_tipo_servicio; ?>').click(function(event){
					$('#description_all').show();
					$('#description_2').hide();
						if($('#opcion_<?php echo $tipo->id_tipo_servicio?>').hasClass('active')){
							event.preventDefault();
							$('#opcion_<?php echo $tipo->id_tipo_servicio?>').removeClass('active');
							$('#subopcion_<?php echo $tipo->id_tipo_servicio?>').removeClass('subopcion_active');
							$('#subopcion_<?php echo $tipo->id_tipo_servicio?>').hide();
						}
						else{
							event.preventDefault();
							var activo = $('.lista_servicios').find('.active');
							var subopcion_activo = $('.lista_servicios').find('.subopcion_active');
							var subopcion = $('#subopcion_<?php echo $tipo->id_tipo_servicio; ?>');
	
							if(activo.hasClass('active')){
								subopcion_activo.removeClass('subopcion_active');
								subopcion_activo.hide();
								activo.removeClass('active');
							}
	
							if(subopcion.css('display') == 'none'){
								$('#subopcion_<?php echo $tipo->id_tipo_servicio; ?>').show();
								$('#subopcion_<?php echo $tipo->id_tipo_servicio; ?>').addClass('subopcion_active');
							}else
							{
								$('#subopcion_<?php echo $tipo->id_tipo_servicio; ?>').hide();
								$('#subopcion_<?php echo $tipo->id_tipo_servicio; ?>').removeClass('subopcion_active');
							}
							$('#opcion_<?php echo $tipo->id_tipo_servicio; ?>').addClass('active');
						}
					<?php if($tipo->id_tipo_servicio == '2'): ?>
						$('#description_all').hide();
						$('#description_2').show();
					<?php endif; ?>
				});
			<?php endif; ?>

			$("#subopcion_<?php echo $tipo->id_tipo_servicio; ?>").hide();

		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(isset($servicios)): ?>
		<?php foreach($servicios as $categorias => $categoria): ?>
			<?php foreach($categoria as $servicio): ?>
				<?php if($servicio->id_tipo_servicio != '2'): ?>
					
					$("#servicio_<?php echo $servicio->id_servicio; ?>").click(function(event){
						event.preventDefault();
						<?php $this->load->helper('typography'); ?>
						$('#resena_ddescripcion').empty();
						$('#resena_titulo').text($('#servicio_<?php echo $servicio->id_servicio; ?>').text());
						
						<?php if($servicio->id_tipo_servicio=='4' && $servicio->url=='foros-charlas-y-talleres'): ?>
							$('#resena_eventos').html('<a href="<?php echo base_url().lang('eventos_url'); ?>"><?php echo lang('servicios.ir_eventos');?></a>');
						<?php else : ?>
							$('#resena_eventos').html('');
						<?php endif; ?>
						
						<?php if(empty($servicio->fichero)) : ?>
								$('#resena_imagen').attr('src', '<?php echo base_url().'assets/front/img/template/placeholder/placeholder_large_1.jpg'; ?>');
						<?php elseif(isset($servicio->fichero) && !empty($servicio->fichero)): ?>
							$('#resena_imagen').attr('src', '<?php echo base_url().'assets/front/img/large/'.$servicio->fichero; ?>');
							$('#resena_imagen').attr('style', 'width: 597px;');
						<?php endif; ?>
						
	
						<?php if(isset($servicio->descripcion_ampliada) && $servicio->descripcion_ampliada != ''): ?>
							var temp = <?php echo str_replace('<br><br>', '', json_encode($servicio->descripcion_ampliada)); ?>;
							$('#resena_ddescripcion').html(temp);
							$('#resena_ddescripcion br').remove();
							//$('#resena_ddescripcion').html($('#resena_ddescripcion').html().replace(/(<br><br>\s*){2,2}/gi,'<br>'));
						<?php endif; ?>
					});
				<?php else : ?>
					
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
	<?php endif; ?>
});





</script>

