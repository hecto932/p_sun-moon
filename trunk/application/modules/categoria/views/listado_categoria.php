<?php 
//echo '<pre>'.print_r($categorias,true).'</pre>';
//echo $num_categorias


 ?>

		<!-- Tabla -->
		<table id="tabla" border="1" summary="Tabla de Categorias.">
			<caption> <?php echo lang('categoria_list_tab'); ?> </caption>
			<thead>
				<tr>
					<th id="id" class="col1 <?php echo ((strpos(uri_string(),'id_categoria')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_categoria')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_categoria/asc',"ID")?></th>
					<th id="nombre" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc', lang("categoria_fic_nom"))?></th>
					<th id="descripcion" class="col3 <?php echo ((strpos(uri_string(),'descripcion')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'descripcion')!=false) ? $url.'/'.$order_by_new : $url.'/'.'descripcion/asc',lang("categoria_fic_dsc"))?></th>
					<th id="id_estado" class="col4 <?php echo ((strpos(uri_string(),'estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc', lang("estado"))?></th>
					
					<?php /*<th id="tagscol" class="col7"><span>Tags</span></th> */?>
					<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->
					<th id="ver_categoria" class="col10"><span> <?php echo lang('categoria_list_ver'); ?> </span></th>                    
					<th id="eliminar" class="col9  last"><span> <?php echo lang('eliminar'); ?> </span></th>

				</tr>
			</thead>
			<tbody>
			<?php 
			$i=1;
			foreach ($categorias as $categoria){ ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="categoria_<?php echo $categoria->id_categoria?>">
					<td class="col1" headers="id_categoria"><p><?php echo $categoria->id_categoria?></p></td>
					<td class="col2" headers="nombre"><p><?php echo $categoria->nombre?></p></td>
					<td class="col3" headers="descripcion"><p><?php echo $categoria->descripcion_breve?></p></td>
					<td class="col4" headers="id_estado"><p><?php switch($categoria->id_estado){
					case '1':
						echo lang('publicado');
					break;	
					case '2':
						echo lang('guardado');
					break;
					case '3':
						echo lang('borrado');
					break;
					}?></p></td>
					

					<!--<td class="col8" headers="editar"><p class="centered"><?php echo anchor('backend/editar_categoria/'.$categoria->id_categoria,'Editar',array('title'=>"editar categoria", 'id'=>"icon_editar"))?></p></td>-->
					<td class="col10 last" headers="ver_categoria"><strong class="boton"><?php echo anchor('backend/ficha_categoria/'.$categoria->id_categoria, lang('categoria_list_ver'),array('title'=> lang('categoria_list_titF')))?></strong></td>
					<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_categoria/'.$categoria->id_categoria,lang('eliminar'), array('title'=>lang('categoria_list_titE'), 'id'=>"icon_eliminar" ,'class'=>"delete"))?></p></td>

				</tr>
				<?php 
				$i++;
			} ?>
			</tbody>
		</table>
		<!-- Tabla cierre -->
		
		<!-- Paginación -->
		<?php echo $pagination?>
		<!-- Paginación cierre -->
