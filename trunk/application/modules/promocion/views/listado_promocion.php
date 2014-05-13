<?php 
//echo '<pre>'.print_r($noticias,true).'</pre>';
//echo $num_promocions ?>
		<!-- Tabla -->
		<table id="tabla" border="1" summary="Tabla de promociones.">
			<caption>Tabla de promociones</caption>
			<thead>
				<tr>
					<th id="id" class="col1 <?php echo ((strpos(uri_string(),'id_promocion')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_promocion')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_promocion/asc',"ID")?></th>
					<th id="nombre" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc',"Nombre")?></th>
					<th id="destacado" class="col3 <?php echo ((strpos(uri_string(),'destacado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'destacado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'destacado/asc',"Destacado")?></th>
                    <th id="fecha" class="col4 dark <?php echo ((strpos(uri_string(),'creado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'creado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'creado/asc',"Fecha")?></th>

					
					<th id="estado" class="col6<?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',"Estado")?></th>
					
					<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->
					
					<th id="ver_promocion" class="col10 dark"><span>Ver Promocion</span></th>
					<th id="eliminar" class="col9 last"><span>Eliminar</span></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$i=1;
			foreach ($promociones as $promocion){ ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="promocion_<?php echo $promocion->id_promocion?>">
					<td class="col1" headers="id"><p><?php echo $promocion->id_promocion?></p></td>
					<td class="col2" headers="nombre"><p><?php echo $promocion->nombre?></p></td>
					<td class="col3" headers="destacado"><p><?php echo ($promocion->destacado ? 'Si' : 'No')?></p></td>

					<td class="col4" headers="fecha"><p><?php echo date('d/m/Y',mysql_to_unix($promocion->creado))?></p></td>
					<td class="col6" headers="estado"><p><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$promocion->id_estado,'true'));
					echo $estado->estado;?></p></td>
					
					<!--<td class="col8" headers="editar"><p class="centered"><?php echo anchor('backend/editar_promocion/'.$promocion->id_promocion,'Editar',array('title'=>"editar promocion", 'id'=>"icon_editar"))?></p></td>-->
					
					<td class="col10 last" headers="ver_promocion"><strong class="boton"><?php echo anchor('backend/ficha_promocion/'.$promocion->id_promocion,'Ver Promocion',array('title'=>"ver la ficha de la promocion"))?></strong></td>
					<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_promocion/'.$promocion->id_promocion,'Eliminar',array('title'=>"eliminar promocion", 'class'=>"delete", 'id'=>"icon_eliminar"))?></p></td>
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
