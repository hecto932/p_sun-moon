<!-- Tabla -->
<table id="tabla" border="1" summary="Tabla de operadoras.">
	<caption>Tabla de <?php echo lang('operadoras')?></caption>
	<thead>
		<tr>
			<th id="correo" class="col2 dark <?php echo ((strpos(uri_string(),'nombre')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'correo') != false) ? $url.'/'.$order_by_new : $url.'/'.'correo/asc', lang('contacto_ficha_correo'))?></th>
			<th id="creacion" class="col6 <?php echo ((strpos(uri_string(),'creacion')!=false) ? strtolower($order_dir) : 'desc')?>"><?php echo anchor((strpos(uri_string(),'creacion')!=false) ? $url.'/'.$order_by_new : $url.'/'.'creacion/asc', lang('contacto_ficha_creacion'))?></th>
			<th id="ver_correo" class="col10 "><span> <?php echo ($this->session->userdata('idioma' == 'es')) ? "Ver ".lang('contacto') : "View ".lang('contact') ?> </span></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach ($contactos as $contacto){ ?>
		<tr<?php echo ($i%2==0 ? ' class="dark"' : '') ?> id="contacto_<?php echo $contacto->id_contacto?>">
			<td class="col2" headers="correo"><p><?php echo $contacto->correo; ?></p></td>
			<td class="col3" headers="creacion"><p><?php echo $contacto->creacion; ?></p></td>
			<td class="col10 last" headers="ver_proyecto">
			<strong class="boton">
				<?php
					if($this->session->userdata('idioma') == 'es')
					{ 
						echo anchor(lang('backend_url').'/'.lang('contactos_url').'/'.lang('ficha_url').lang('operadora_url').'/'.$contacto->id_contacto, lang('contacto_listado_ver') , array('title'=> lang('operadora_listado_titulo')));
					}
					else
					{
						echo anchor(lang('backend_url').'/'.lang('contactos_url').'/'.lang('contacto_url').'_'.lang('ficha_url').'/'.$contacto->id_contacto, lang('contacto_listado_ver') , array('title'=> lang('operadora_listado_titulo')));
					}
				?>
					</strong></td>
		</tr>
		<?php 
		$i++;
	} ?>
	</tbody>
</table>
<!-- Tabla cierre -->

<!-- Paginación -->
<?php echo $pagination; ?>
<!-- Paginación cierre -->
