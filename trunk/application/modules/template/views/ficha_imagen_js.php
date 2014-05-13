<?php if((isset($imagen_principal) && !empty($imagen_principal)) || (isset($imagenes_secundarias) && !empty($imagenes_secundarias)) ): ?>
	<?php //echo '<pre>'.print_r($imagenes_terciarias,true).'</pre>';die(); ?>
	<script>
		<?php if(isset($imagen_principal) && !empty($imagen_principal)): ?>
			<?php $timestamp = strtotime($imagen_principal[0]->actualizado); ?>
		<?php endif; ?>
		$(document).ready(function(){

				<?php if(isset($imagen_principal) && !empty($imagen_principal)): ?>
					$('#thumb_<?php echo $imagen_principal[0]->id_multimedia; ?>').click(function(e){
						e.preventDefault();
						$('img[name=img_actual]').attr('src', '<?php echo base_url().'assets/front/img/large/'.$imagen_principal[0]->fichero; ?>');
						$('span[name=nombre_imagen]').text("<?php echo substr($imagen_principal[0]->fichero, 0, strpos($imagen_principal[0]->fichero,'.') );  ?>");
						$('span[name=extension_imagen]').text(".<?php echo strtolower(substr(strrchr($imagen_principal[0]->fichero,'.'), 1));  ?>");
						$('span[name=dia_imagen]').text('<?php echo date("d/m/Y", $timestamp); ?>');
						$('span[name=hora_imagen]').text('<?php echo date("H:i:s", $timestamp); ?>');
						$('span[name=tipo_imagen]').text("<?php echo lang('imagen_t'.$imagen_principal[0]->destacado); ?>");
					});

					$('#eliminar_<?php echo $imagen_principal[0]->id_multimedia; ?>').click(function(){
						$('#add_principal').append('<a class="radius button success"'
						+ 'href="' + '<?php echo $url_add_p ?>'
						+ '"' + ' title="' + '<?php echo lang("add_imagen"); ?>' + '">'	+ '<?php echo lang("add_imagen_p") ?>' + '</a>');
						$.ajax({
							type: "POST",
							url: "<?php echo $url_delete; ?>",
							data: { id_multimedia: "<?php echo $imagen_principal[0]->id_multimedia; ?>", fichero: "<?php echo $imagen_principal[0]->fichero; ?>" }
							}).done(function( msg ) {
								$("#column_<?php echo $imagen_principal[0]->id_multimedia?>").remove();
								location.reload();
							});
					});
				<?php endif; ?>

				<?php if(isset($imagenes_secundarias) && !empty($imagenes_secundarias)): ?>
						<?php foreach($imagenes_secundarias as $imagen): ?>
							$('#thumb_<?php echo $imagen->id_multimedia; ?>').click(function(e){
								<?php $timestamp = strtotime($imagen->actualizado); ?>
								e.preventDefault();
								$('img[name=img_actual]').attr('src', '<?php echo base_url().'assets/front/img/large/'.$imagen->fichero; ?>');
								$('span[name=nombre_imagen]').text("<?php echo substr($imagen->fichero, 0, strpos($imagen->fichero,'.') );  ?>");
								$('span[name=extension_imagen]').text(".<?php echo strtolower(substr(strrchr($imagen->fichero,'.'),1));  ?>");
								$('span[name=dia_imagen]').text('<?php echo date("d/m/Y", $timestamp); ?>');
								$('span[name=hora_imagen]').text('<?php echo date("H:i:s", $timestamp); ?>');
								$('span[name=tipo_imagen]').text("<?php echo lang('imagen_t'.$imagen->destacado); ?>");
							});

							$('#eliminar_<?php echo $imagen->id_multimedia; ?>').click(function(){
								$.ajax({
									type: "POST",
									url: "<?php echo $url_delete; ?>",
									data: { id_multimedia: "<?php echo $imagen->id_multimedia; ?>", fichero: "<?php echo $imagen->fichero; ?>" }
									}).done(function( msg ) {
										$("#column_<?php echo $imagen->id_multimedia?>").remove()
										location.reload();
									});
							});

						<?php endforeach; ?>
				<?php endif; ?>

				<?php if(isset($imagenes_terciarias) && !empty($imagenes_terciarias)): ?>
					<?php foreach($imagenes_terciarias as $imagen): ?>
						$('#thumb_<?php echo $imagen->id_multimedia; ?>').click(function(e){
							<?php $timestamp = strtotime($imagen->actualizado); ?>
							e.preventDefault();
							$('img[name=img_actual]').attr('src', '<?php echo base_url().'assets/front/img/large/'.$imagen->fichero; ?>');
							$('span[name=nombre_imagen]').text("<?php echo substr($imagen->fichero, 0, strpos($imagen->fichero,'.') );  ?>");
							$('span[name=extension_imagen]').text(".<?php echo strtolower(substr(strrchr($imagen->fichero,'.'),1));  ?>");
							$('span[name=dia_imagen]').text('<?php echo date("d/m/Y", $timestamp); ?>');
							$('span[name=hora_imagen]').text('<?php echo date("H:i:s", $timestamp); ?>');
							$('span[name=tipo_imagen]').text("<?php echo lang('imagen_t'.$imagen->destacado); ?>");
						});

						$('#eliminar_<?php echo $imagen->id_multimedia; ?>').click(function(){
							$.ajax({
								type: "POST",
								url: "<?php echo $url_delete; ?>",
								data: { id_multimedia: "<?php echo $imagen->id_multimedia; ?>", fichero: "<?php echo $imagen_principal->fichero; ?>" }
								}).done(function( msg ) {
									$("#column_<?php echo $imagen->id_multimedia?>").remove()
									location.reload();
								});
						});

					<?php endforeach; ?>
				<?php endif; ?>
		});
	</script>
<?php endif; ?>