<?php 
//echo '<pre>'.print_r($multimedias,true).'</pre>';
//echo $num_multimedias ?>
		<!-- Tabla -->
		<table id="tabla" border="1" summary="Tabla de multimedias.">
			<caption>Tabla de multimedias</caption>
			<thead>
				<tr>
					<th id="id" class="col1 <?php echo ((strpos(uri_string(),'id_multimedia')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_multimedia')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_multimedia/asc',"ID")?></th>
					<th id="nombre" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc',"Título")?></th>

					<th id="tipo" class="col3 <?php echo ((strpos(uri_string(),'tipo')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'tipo')!=false) ? $url.'/'.$order_by_new : $url.'/'.'tipo/asc',"Tipo")?></th>
					<th id="estado" class="col4 dark <?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',"Estado")?></th>
					<th id="tagscol" class="col5"><span>Tags</span></th>
					<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->
					
					<th id="ver_multimedia" class="col6 dark"><span>Ver Multimedia</span></th>
					<th id="eliminar" class="col7 last"><span>Eliminar</span></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$i=1;
			foreach ($multimedias as $multimedia){ ?>
				<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="multimedia_<?php echo $multimedia->id_multimedia?>">
					<td class="col1" headers="id"><p><?php echo $multimedia->id_multimedia?></p></td>
					<td class="col2" headers="nombre"><p><?php echo $multimedia->nombre_multimedia?></p></td>

					<td class="col3" headers="tipo"><p><?php echo modules::run('services/relations/get_from_id','tipo_multimedia',$multimedia->id_tipo)->nombre?></p></td>

					<td class="col4" headers="estado"><p><?php 
					$estado=json_decode(modules::run('services/relations/get_from_id','estado',$multimedia->id_estado,'true'));
					echo $estado->estado;?></p></td>
					<td class="col5" headers="tagscol"><p><?php 
					$tags=json_decode(modules::run('services/relations/get_rel','detalle_multimedia','tag',$multimedia->id_detalle_multimedia,'true'),true);
					$t=array();
					foreach($tags as $tag){
						$t[]=$tag['tag'];
					}
					
					echo implode(', ',$t);?></p></td>
					<!--<td class="col8" headers="editar"><p class="centered"><?php echo anchor('backend/editar_multimedia/'.$multimedia->id_multimedia,'Editar',array('title'=>"editar multimedia", 'id'=>"icon_editar"))?></p></td>-->
					
					<td class="col6 last" headers="ver_multimedia"><strong class="boton"><?php echo anchor('backend/ficha_multimedia/'.$multimedia->id_multimedia,'Ver Multimedia',array('title'=>"ver la ficha de la multimedia"))?></strong></td>
					<td class="col7" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_multimedia/'.$multimedia->id_multimedia,'Eliminar',array('title'=>"eliminar multimedia", 'id'=>"icon_eliminar", 'class'=>"delete"))?></p></td>
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
