<?php 
//echo '<pre>'.print_r($obras,true).'</pre>';
//echo $num_obras ?>
		<!-- Tabla -->
		<table id="tabla" border="1" summary="Tabla de obras.">
			<caption>Tabla de obras</caption>
			<thead>
				<tr>
					<th id="id" class="col1 <?php echo ((strpos(uri_string(),'id_obra')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_obra')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_obra/asc',"ID")?></th>
					<th id="titulo" class="col2 dark <?php echo ((strpos(uri_string(),'titulo')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'titulo')!=false) ? $url.'/'.$order_by_new : $url.'/'.'titulo/asc',"Título")?></th>
					<!--<th id="detacado" class="col3 <?php echo ((strpos(uri_string(),'destacado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'destacado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'destacado/asc',"Destacado")?></th>-->
					<th id="categoria" class="col4 dark <?php echo ((strpos(uri_string(),'nombre_categoria')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre_categoria')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre_categoria/asc',"Categoría")?></th>
					<th id="fecha" class="col5 <?php echo ((strpos(uri_string(),'ano')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'ano')!=false) ? $url.'/'.$order_by_new : $url.'/'.'ano/asc',"Fecha")?></th>
					<th id="estado" class="col6 dark <?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',"Estado")?></th>
					<th id="tagscol" class="col7"><span>Tags</span></th>
					<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->
					
					<th id="ver_obra" class="col10 dark"><span>Ver Obra</span></th>
					<th id="eliminar" class="col9 last"><span>Eliminar</span></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$i=1;
			foreach ($obras as $obra){ ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="obra_<?php echo $obra->id_obra?>">
					<td class="col1" headers="id"><p><?php echo $obra->id_obra?></p></td>
					<td class="col2" headers="titulo"><p><?php echo $obra->titulo?></p></td>
					<!--<td class="col3" headers="detacado"><p><?php echo ($obra->obra_destacada == 1 ? 'Si' : 'No')?></p></td>-->
					<td class="col4" headers="categoria"><p><?php echo $obra->nombre_categoria?></p></td>
					<td class="col5" headers="fecha"><p><?php echo modules::run('services/relations/format_fecha',$obra->dia,$obra->mes,$obra->ano,$obra->fecha_aprox,'true')?></p></td>
					<td class="col6" headers="estado"><p><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$obra->id_estado,'true'));
					echo $estado->estado;?></p></td>
					<td class="col7" headers="tagscol"><p><?php 
					$tags=json_decode(modules::run('services/relations/get_rel','detalle_obra','tag',$obra->id_detalle_obra,'true'),true);
					$t=array();
					foreach($tags as $tag){
						$t[]=$tag['tag'];
					}
					
					echo implode(', ',$t);?></p></td>
					<!--<td class="col8" headers="editar"><p class="centered"><?php echo anchor('backend/editar_obra/'.$obra->id_obra,'Editar',array('title'=>"editar obra", 'id'=>"icon_editar"))?></p></td>-->
					
					<td class="col10 last" headers="ver_obra"><strong class="boton"><?php echo anchor('backend/ficha_obra/'.$obra->id_obra,'Ver Obra',array('title'=>"ver la ficha de la obra"))?></strong></td>
					<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_obra/'.$obra->id_obra,'Eliminar',array('title'=>"eliminar obra", 'class'=>"delete", 'id'=>"icon_eliminar"))?></p></td>
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
