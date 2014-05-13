		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

				<table class="twelve" border="1" summary="Tabla de habitaciones.">
					<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					<thead>
						<?php
						/*
						 *  Encabezado del listado.
						 * 	Nombre:
						 * 	Destacado:
						 *  Fecha:
						 * 	Estado:
						 * 	Ver_habitacion:
						 * 	Eliminar:
						 * */
						?>

						<tr>
							<th id="nombre" class="col1 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'detalle_habitacion.nombre/asc',lang('listado_nombre')) ?>
							</th>
							
							<th id="codigo" class="col2 dark <?php echo ((strpos(uri_string(),'codigo')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'codigo')!=false) ? $url.'/'.$order_by_new : $url.'/'.'habitacion.codigo/asc',lang('habitaciones_codigo')) ?>
							</th>
							
							<th id="nombre_tipo" class="col4 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'tipo_habitacion') != false) ? $url.'/'.$order_by_new : $url.'/'.'nombre_tipo/asc',lang('tipo_habitacion')) ?>
							</th>

							<th id="estado" class="col6<?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',lang("listado_estado"))?>
							</th>

							<th id="ver_habitacion" class="col10">
								<span>  <?php echo lang('listado_ver'); ?> </span>
							</th>

							<th id="eliminar" class="col9 last">
								<span> <?php echo lang('listado_eliminar'); ?> </span>
							</th>
						</tr>
						<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					</thead>
						<?php /*-----------------------------------------Inicio Cuerpo----------------------------------------------*/?>
					<tbody>
						<?php $i=1; ?>
						<?php foreach ($habitaciones as $habitacion): ?>
							<tr>

								<td class="col1" headers="nombre">
									<p>
										<?php echo ($habitacion->nombre != '') ? ucwords($habitacion->nombre) : lang('habitaciones_sintitulo');  ?>
									</p>
								</td>
								
								<td class="col2" headers="codigo">
									<p>
										<?php echo ($habitacion->codigo != '') ? ucwords($habitacion->codigo) : lang('habitaciones_sincodigo');  ?>
									</p>
								</td>
								
								<td class="col4" headers="nombre_tipo">
									<p><?php echo $habitacion->nombre_tipo; ?></p>
								</td>

								<td class="col6" headers="estado">
									<p>
										<?php
											$estado = json_decode(modules::run('services/relations/get_from_id','estado', $habitacion->id_estado,'true'));
											echo lang($estado->estado);
											
										?>
									</p>
								</td>


								<td class="col10 last" headers="ver_habitacion">
									<?php
										if($this->session->userdata('idioma') == 'es')
										{
											echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('ficha_url').'_'.lang('habitacion_url').'/'.$habitacion->id_habitacion, lang('habitaciones_list_ver'),array('title'=> lang('habitaciones_ficha_ver'), 'class' => 'button radius wtc'));

										}
										else
										{
											echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/'.$habitacion->id_habitacion, lang('habitaciones_list_ver'),array('title'=> lang('habitaciones_ficha_ver') , 'class' => 'button radius wtc'));
										}
									?>
								</td>

								<td class="col9" headers="eliminar">
									<p class="centered">
										<?php echo anchor(lang('backend_url').'/'.lang('habitaciones_url').'/'.lang('eliminar_url').'_'.lang('habitacion_url').'/'.$habitacion->id_habitacion,'Eliminar',array('title'=>"eliminar habitacion", 'class'=>"delete", 'id'=>"icon_eliminar"))?>
									</p>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
						<?php /*-----------------------------------------Fin Cuerpo----------------------------------------------*/?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>
