		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

				<table class="twelve" border="1" summary="Tabla de tipos de habitación.">
					<?php /*-----------------------------------------Inicio encabezado----------------------------------------------*/?>
					<thead>
						<?php
						/*
						 *  Encabezado del listado.
						 * 	Nombre:
						 * 	Destacado:
						 *  Fecha:
						 * 	Estado:
						 * 	Ver_servicio:
						 * 	Eliminar:
						 * */
						?>

						<tr>
							<th id="nombre" class="col1 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc',lang('listado_nombre')) ?>
							</th>
							
							<th id="estado" class="col6<?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>">
								<?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',lang("listado_estado"))?>
							</th>

							<th id="ver_tipo_habitacion" class="col10">
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
						<?php $i=1; //die_pre($tipos_habitacion); ?>
						<?php foreach ($tipos_habitacion as $tipo): ?>
							<tr>

								<td class="col1" headers="nombre">
									<p>
										<?php echo ($tipo->nombre != '') ? ucwords($tipo->nombre) : lang('tipo_habitacion_sintitulo');  ?>
									</p>
								</td>
								
								<td class="col6" headers="estado">
									<p>
										<?php
											$estado = json_decode(modules::run('services/relations/get_from_id','estado', $tipo->id_estado,'true'));
											echo lang($estado->estado);
											
										?>
									</p>
								</td>


								<td class="col10 last" headers="ver_tipo_habitacion">
									<?php
										if($this->session->userdata('idioma') == 'es')
										{
											echo anchor(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('ficha_url').'_'.lang('tipo_habitacion_url').'/'.$tipo->id_tipo_habitacion, lang('tipo_habitacion_list_ver'),array('title'=> lang('tipos_habitacion_ficha_ver'), 'class' => 'button radius wtc'));

										}
										else
										{
											echo anchor(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/'.$tipo->id_tipo_habitacion, lang('tipo_habitacion_list_ver'),array('title'=> lang('tipos_habitacion_ficha_ver') , 'class' => 'button radius wtc'));
										}
									?>
								</td>

								<td class="col9" headers="eliminar">
									<p class="centered">
										<?php echo anchor(lang('backend_url').'/'.lang('tipos_habitacion_url').'/'.lang('eliminar_url').'_'.lang('tipo_habitacion_url').'/'.$tipo->id_tipo_habitacion,'Eliminar',array('title'=>"eliminar tipo de habitación", 'class'=>"delete", 'id'=>"icon_eliminar"))?>
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
