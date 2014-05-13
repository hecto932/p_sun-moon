<script type="text/javascript">
	
	$(document).ready(function()
	{
		$('.ver_comentario').click(function()
		{
			$(this).parents('tr').next('tr').toggle();
		});
	});
	
</script>

<div class="row">
	<div class="twelve columns">

		<?php if(isset($breadcrumbs)): ?> <?php echo $breadcrumbs; ?> <?php endif; ?>

		<table class="twelve" border="1" >
			
			<thead>
				<tr>
					<th id="nombre" 		class="col1 dark <?php echo ((strpos(uri_string(), 'nombre') != false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(), 'nombre') != false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc', 'Nombre')?></th>
					<th id="email" 			class="col2 <?php echo ((strpos(uri_string(), 'email') != false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(), 'email') != false) ? $url.'/'.$order_by_new : $url.'/'.'email/asc', "Email")?></th>
					<th id="rating" 		class="col3 dark <?php echo ((strpos(uri_string(), 'rating') != false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(), 'rating') != false) ? $url.'/'.$order_by_new : $url.'/'.'rating/asc', 'Rating')?></th>
					<th id="creado" 		class="col4 dark <?php echo ((strpos(uri_string(), 'creado') != false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'creado') != false) ? $url.'/'.$order_by_new : $url.'/'.'creado/asc', 'Creado')?></th>
					<th id="id_estado" 		class="col5 dark <?php echo ((strpos(uri_string(), 'id_estado') != false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado') != false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc', 'Estado')?></th>
					<th id="ver" 			class="col9 dark last"><span> <?php echo 'Acción'; ?> </span></th>
                    <th id="eliminar" 		class="col10"><span> <?php echo 'Eliminar'; ?> </span></th>
				</tr>
			</thead>
			
			<tbody>
			<?php $i=1; ?>
			<?php foreach ($testimonios as $testimonio): ?>
				
				<tr<?php echo ($i%2==0 ? ' bgcolor="#F9F9F9" ' : '') ?> id="testimonio_<?php echo $testimonio->id_testimonio; ?>">
					
					<td class="col1" headers="nombre">
						<span data-tooltip class="has-tip" title="<?php echo wordwrap($testimonio->comentario, 70, "<br />\n"); ?>">
							<p class="ver_comentario"><?php echo ucwords($testimonio->nombre); ?></p>
						</span>
					</td>
					
					<td class="col2" headers="email">
						<p><?php echo $testimonio->email; ?></p>
					</td>
					
					<td class="col3" headers="rating">
						<p><?php echo $testimonio->rating; ?></p>
					</td>
					
					<?php list($fecha, $hora) = explode(' ', flip_timestamp($testimonio->creado)); ?>
					<td class="col4" headers="creado">
						<p><?php echo $fecha; ?></p>
					</td>
					
					<?php 
						$class_label = 'class="round label"';
						if($testimonio->id_estado == 1) $class_label = 'class="success round label"';
						elseif($testimonio->id_estado == 3) $class_label = 'class="alert round label"';
					?>
					<td class="col5" headers="id_estado">
						<p><span <?php echo $class_label; ?> ><?php echo $testimonio->estado; ?></span></p>
					</td>
					
					<!-- Publicar/Guardar -->
					<?php
						if($testimonio->id_estado == 1)
						{
							$href = 'backend/guardar_testimonio/'.$testimonio->id_testimonio;
							$button_name = 'Guardar';
						}
						else
						{
							$href = 'backend/publicar_testimonio/'.$testimonio->id_testimonio;
							$button_name = 'Publicar';
						}
					?>
					<td class="col9 last" headers="ver_testimonio">
						<strong class="boton">
							<p class="centered"><?php echo anchor($href, $button_name, array('title'=> $button_name, 'class'=>"small button radius wtc"))?></p>
						</strong>
					</td>
					
					<!-- Eliminar -->
					<td class="col10" headers="eliminar">
						<strong class="boton">
							<p class="centered"><?php echo anchor('backend/borrar_testimonio/'.$testimonio->id_testimonio, lang('eliminar'), array('title'=> 'Eliminar', 'id'=>"icon_eliminar", 'class'=>"delete small secondary button radius wtc"))?></p>
						</strong>
					</td>
				</tr>
				
				<tr style="display: none;">
					<td colspan="12">
						<?php echo strtolower($testimonio->comentario); ?>
					</td>
				</tr>
				
				<?php
				$i++;
				endforeach; ?>
			</tbody>
		</table>


		<!-- Paginación -->
		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>
		<!-- Paginación cierre -->
	</div>
</div>