		<div class="row">
			<div class="twelve columns">

				<?php if(isset($breadcrumbs)): ?>
					<?php echo $breadcrumbs; ?>
				<?php endif; ?>

				<table class="twelve" border="1" summary="Tabla de eventos.">
					<thead>
						<tr>
							<th id="nombre" class="col1 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'nombre')!=false) ? $url.'/'.$order_by_new : $url.'/'.'nombre/asc',lang('categoria_fic_nom'))?></th>
							<th id="destacado" class="col3 <?php echo ((strpos(uri_string(),'destacado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'destacado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'destacado/asc',lang('destacado'))?></th>
		                    <th id="fecha" class="col4 dark <?php echo ((strpos(uri_string(),'creado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'creado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'creado/asc', lang("eventos_fecha"))?></th>


							<th id="estado" class="col6<?php echo ((strpos(uri_string(),'id_estado')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_estado')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_estado/asc',lang("estado"))?></th>
							
							<th id="id_tipo_evento" class="col8<?php echo ((strpos(uri_string(),'id_tipo_evento')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'id_tipo_evento')!=false) ? $url.'/'.$order_by_new : $url.'/'.'id_tipo_evento/asc',lang("tipo_evento"))?></th>
							

							<!--<th id="editar" class="col8 dark"><span>Editar</span></th>-->

							<th id="ver_evento" class="col10"><span>  <?php echo lang('eventos_list_ver'); ?> </span></th>
							<th id="eliminar" class="col9 last"><span> <? echo lang('eliminar'); ?> </span></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$i=1;
					foreach ($eventos as $evento){ ?>
						<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="evento_<?php echo $evento->id_evento?>">
							<td class="col1" headers="nombre"><p><?php echo ($evento->nombre != '') ? ucwords($evento->nombre) : lang('eventos_sintitulo');  ?></p></td>
							<td class="col3" headers="destacado"><p><?php echo $evento->destacado; ?></p></td>

							<td class="col4" headers="fecha"><p><?php echo date('d/m/Y',mysql_to_unix($evento->creado))?></p></td>
							<td class="col6" headers="estado">
								
								
								<p>
								<?php
									$estado = json_decode(modules::run('services/relations/get_from_id','estado',$evento->id_estado,'true'));
									echo lang($estado->estado);
								?>
								</p>
							</td>

							<td class="col8" headers="tipo_evento">
								<p><?php echo lang('eventos_tipo_'.$evento->id_tipo_evento); ?></p>
							</td>

							<td class="col10 last" headers="ver_evento">
							<?php
								if($this->session->userdata('idioma') == 'es')
								{
									echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('ficha_url').'_'.lang('evento_url').'/'.$evento->id_evento, lang('eventos_list_ver'),array('title'=> lang('eventos_ficha_ver'), 'class' => 'button radius wtc'));

								}
								else
								{
									echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('articulo_url').'_'.lang('ficha_url').'/'.$evento->id_evento, lang('eventos_list_ver'),array('title'=> lang('eventos_ficha_ver') , 'class' => 'button radius wtc'));

								}
							?>
							</td>
							<td class="col9" headers="eliminar"><p class="centered"><?php echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('eliminar_url').'_'.lang('evento_url').'/'.$evento->id_evento,'Eliminar',array('title'=>"eliminar evento", 'class'=>"delete", 'id'=>"icon_eliminar"))?></p></td>
						</tr>
						<?php
						$i++;
					} ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="twelve columns pagination-centered">
				<?php echo $pagination?>
			</div>
		</div>



