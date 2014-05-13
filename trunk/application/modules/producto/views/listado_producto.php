<?php 
//echo '<pre>'.print_r($productos,true).'</pre>';
//echo $num_productos ?>
<!-- Tabla -->
<table id="tabla" border="1" summary="Tabla de productos.">
	<caption>Tabla de <?php echo $this->lang->line('productos')?></caption>
	<thead>
		<tr>
			<th id="codigo_coloplas" class="col1 <?php echo ((strpos(uri_string(),'codigo_coloplas')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'codigo_coloplas')!=false) ? $url.'/'.$order_by_new : $url.'/'.'codigo_coloplas/asc', ($this->session->userdata('idioma' == 'es')) ? "Codigo ".$this->lang->line('producto') : $this->lang->line('producto').' code')?></th>
			<th id="nombre" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc', lang('producto_ficha_nombre'))?></th>
			<th id="detacado" class="col3 <?php echo ((strpos(uri_string(),'destacado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'destacado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'destacado/asc', lang('destacado'))?></th>
			<th id="categoria" class="col2 dark  <?php echo ((strpos(uri_string(),'nombre_categoria')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre_categoria')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre_categoria/asc', lang('categoria'))?></th>
			
			<th id="estado" class="col6 <?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc', lang('estado'))?></th>
			
			<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->
			
			<th id="ver_producto" class="col10 "><span> <?php echo ($this->session->userdata('idioma' == 'es')) ? "Ver ".$this->lang->line('producto') : "View ".$this->lang->line('producto') ?> </span></th>
			<th id="eliminar" class="col9 last"><span> <?php echo $this->lang->line('eliminar')?> </span></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach ($productos as $producto){ ?>
		<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="producto_<?php echo $producto->id_producto?>">
			<td class="col1" headers="codigo_coloplas"><p><?php echo $producto->codigo_coloplas?></p></td>
			<td class="col2" headers="nombre"><p><?php echo $producto->nombre?></p></td>
			<td class="col3" headers="detacado"><p><?php echo ($producto->destacado == 1 ? 'Si' : 'No')?></p></td>
			<td class="col4" headers="categoria"><p><?php echo $producto->nombre_categoria?></p></td>
			
			<td class="col6" headers="estado"><p><?php 
			$estado=json_decode(modules::run('services/relations/get_from_id','estado',$producto->id_estado,'true'));
			echo $estado->estado;?></p></td>
			
			<!--<td class="col8" headers="editar"><p class="centered"><?php echo anchor('backend/editar_'.$this->lang->line('producto_url').'/'.$producto->id_producto,'Editar',array('title'=>"editar ".$this->lang->line('productos_url'), 'id'=>"icon_editar"))?></p></td>-->
			
			<td class="col10 last" headers="ver_producto"><strong class="boton"><?php echo anchor('backend/ficha_'.$this->lang->line('producto_url').'/'.$producto->id_producto, lang('producto_listado_ver') , array('title'=> lang('producto_listado_titulo')))?></strong></td>
			<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor('backend/borrar_'.$this->lang->line('producto_url').'/'.$producto->id_producto, lang('eliminar'), array('title'=> lang('producto_listado_eliminar'), 'class'=>"delete", 'id'=>"icon_eliminar"))?></p></td>
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
