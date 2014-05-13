<script type="text/javascript">
$(document).ready(function(){
        //Full Caption Sliding (Hidden to Visible)
        $('.boxgrid.captionfull').hover(function(){
            $(".cover", this).stop().animate({top:'30px'},{queue:false,duration:100});
        }, function() {
            $(".cover", this).stop().animate({top:'60px'},{queue:false,duration:100});
        });
    });
function eliminarMultimedia(id) {

	$.ajax({

		data:		{ id_multimedia : id },
		url:		'<?= site_url('services/services/ajax_eliminar_multimedia') ?>',
		type:		'POST',
		success:	function() {
						$('#imagen_' + id).fadeOut('slow');
					}
		
		});
	
}

function cambio_select() {
		$.ajax({
			data:		{ tipo_cat : $("#tipo_cat").val() },
			url:		'<?= site_url('services/relations/arbol_categorias/')?>/' + $("#tipo_cat").val()+'/0/0/producto',
			type:		'POST',
			success:	function(data) {
				//alert(data);
				$('#tree').fadeOut('slow', function() {
   					$("#tree").html(data);
   					crearTree('#tree');
   					$("#tree").fadeIn();
  				});
				
				
			}
		});
	}

function eliminarTempMultimedia(id, posicion) {

	$('input#imgActualBackend' + posicion).remove();
	$('li#img_' + id).fadeOut('slow');
	
}
</script>
		<div id="ficha">

			<h2><?php echo (isset($producto) ? 'Editar' : 'Crear').' '.$this->lang->line('proyecto')?></h2>

			<!-- Formulario Crear Producto -->
<?php echo validation_errors();
if (isset($producto_productos)) $productos_rel=json_decode($producto_productos);
//echo $producto_productos;

//echo '<pre>'.print_r($producto,true).'</pre>';
$id=(isset($producto->id_producto) ? $producto->id_producto : '');

	echo form_open('producto/create/'.$id,'id="gen_form" class="editar_producto"')?>
		<fieldset>
			<table width="100%" class="proyectoTabla">
			<tr>
				<td width="20%"><label for="codigo_coloplas"><span> <?php echo $this->lang->line('producto_crear_cre')?> </span></label></td>
				<td width="80%"><input id="codigo_coloplas" name="codigo_coloplas" type="text" value="<?php echo ((set_value('codigo_coloplas')!='' || !isset($producto->codigo_coloplas)) ? set_value('codigo_coloplas') : $producto->codigo_coloplas);?>" /></td>
			</tr>
			<tr>
				<td><label for="estado"><span> <?php echo lang('estado'); ?> </span></label></td>
				<td>
					<select id="estado" name="id_estado">
					<? foreach(json_decode($estados) as $estado)
							echo '<option value="'.$estado->id_estado.'" '.($estado->id_estado==$producto->id_estado ? 'selected="selected"'  : set_select('id_estado', $estado->id_estado)).'>'.ucwords($estado->estado).'</option>';
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="20%"><label for="tipo"><span> <?php echo lang('tipo'); ?> </span></label></td>
				<td width="80%">
				<select id="tipo_cat" name="id_tipo_cat" onchange="cambio_select()">
					<?php
					foreach (json_decode($tipos_cat) as $tipo) {
						echo '<option value="' . $tipo -> id . '" ' . ($tipo->id == $producto -> id_tipo_cat ? 'selected="selected"' : set_select('id_tipo_cat', $tipo -> id)) . '>' . ucwords($tipo -> nombre) . '</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td><label for="padre"><span> <?php echo lang('categoria_padre'); ?> </span></label>
                </td>
                <td>
                	<input id="selected-cat" type="hidden" value="<?php echo $id ?>"/>
                    <?php if($arbol_categorias != 'false')
					{?>
						<div id="tree">
                        <? echo $arbol_categorias;?>
                    	</div>
					<?}
					else
					{
						echo '<a id="error_link" href="' . site_url() . 'backend/crear_categoria' .  '">'.lang('categoria_error').'</a>';
					}
                    ?>
                    <!--<div id="tree">
                        <?php echo $arbol_categorias; ?>
                    </div>-->
                </td>
			</tr>
			<tr>
				<td></td>
				<td>
					<label for="destacado">
					<input style="width:12px;" id="destacado" name="destacado" type="checkbox" value="1" <?php echo ((isset($producto->destacado) && $producto->destacado==1)? 'checked="checked"' : set_checkbox('destacado', '1')); ?> /><span style="width:70px;"> <?php echo lang('destacado'); ?> </span>
					</label>
				</td>
			</tr>
			<!--<tr>
				<td><label for="enlace"><span>Enlace GoogleMaps</span></label></td>
				<td>
					<?php if (set_value('enlace'))
                            $enlace=set_value('enlace');
                       	  else
                            $enlace=(isset($producto->enlace) && $producto->enlace!='' ? $producto->enlace : ''); ?>
					<input id="enlace" name="enlace" type="text" value="<?php echo $enlace?>" />
				</td>
			</tr>
			<tr>
				<td><label for="enlacevideo"><span>Enlace Video</span></label></td>
				<td>
					<?php
                        if (set_value('enlace_video'))
                            $enlace=set_value('enlace_video');
                        else
                            $enlace=(isset($producto->enlace_video) && $producto->enlace_video!='' ? $producto->enlace_video : ''); ?>
                     <input id="enlacevideo" name="enlace_video" type="text" value="<?php echo $enlace?>" />
				</td>
			</tr>-->
			<!--<tr>
				<td rowspan="2"><label for="imagen"><span>Imagen Logo <br/>(140x100)</span></label></td>
				<td>
					<div id="inputFile" class="imgContainer">
						<ul id="inputFileul">
						<?php 
						$img = '';
						$where2 = array('multimedia.destacado'=>'1');
						if (isset($producto)) { $img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where2));
						echo generate_thumbs_2($img, $producto, 'producto', 'titulo', 'imagenActual[]', "imagen",true);
						}
						?>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td><input id="imagen" name="imagen" type="file" class="producto_logo"/><input id="imagenName" name="imagenName" type="hidden" /></td>
			</tr>-->
			<tr>
				<td rowspan="2"><label for="imagen2"><span> <?php echo lang('imagen'); ?>  <br/>(430x250)</span></label></td>
				<td>
					<div id="inputFile2" class="imgContainer">
						<ul id="inputFile2ul">
						<?php 
						$img = '';
						$where2 = array('multimedia.destacado'=>'2');
						if (isset($producto)) { $img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where2));
						echo generate_thumbs($img, $producto, 'producto', 'titulo', 'imagenActual2[]',true);
						}
						?>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td><input id="imagen2" name="imagen" type="file" class="producto_principal"/><input id="imagenName2" name="imagenName2" type="hidden" /></td>
			</tr>
			<!--<tr>
				<td rowspan="2"><label for="imagen3"><span>Imagenes Secundarias <br/>(400x500)</span></label></td>
				<td>
					<div id="inputFile3" class="imgContainer">
						<ul id="inputFile3ul">
						<?php 
						$img = '';
						$where2 = array('multimedia.destacado'=>'2');
						if (isset($producto)) { $img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where2));
						echo generate_thumbs($img, $producto, 'producto', 'titulo', 'imagenActual3[]');
						}
						?>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<td><input id="imagen3" name="imagen" type="file" class="proyecto_planos"/><input id="imagenName3" name="imagenName3" type="hidden" /><span id="uploadImage3">Subir imagen</span></td>
			</tr>
			<tr>
				<td rowspan="2"><label for="imagen4"><span>Imagenes Inmueble <br/>(500x250)</span></label></td>
				<td>
					<div id="inputFile4" class="imgContainer">
						<ul id="inputFile4ul">
						<?php 
						$img = '';
						$where2 = array('multimedia.destacado'=>'3');
						if (isset($producto)) { $img=json_decode(modules::run('services/relations/get_rel','producto','imagen',$producto->id_producto,'true','multimedia.id_multimedia',$where2));
						echo generate_thumbs($img, $producto, 'producto', 'titulo', 'imagenActual4[]');
						}
						?>
						</ul>
					</div>
				</td>
		</tr>
			<tr>
				<td><input id="imagen4" name="imagen" type="file" class="proyecto_inmuebles"/><input id="imagenName4" name="imagenName4" type="hidden" /><span id="uploadImage4">Subir imagen</span></td> 
			</tr>-->
			</table>
			
			<div class="relationsDiv">
						<div>
							<label for="relProductos">
								<span> <?php echo lang('producto_relacionados'); ?>:</span>
								<select id="relProductos" class="multiple" name="productos[]" multiple>
									<?php 
									
									$set_o=$this->input->post('productos');
									if (!empty($set_o)){
										foreach($set_o as $so){
											$so_data=modules::run('services/relations/get_from_id','producto',$so);
											echo '<option value="'.$so.'" selected="selected">'.$so_data->id_producto.' - '.$so_data->nombre.'</option>';
										}
										
									}elseif (isset($productos_rel) && !empty($productos_rel)){
										foreach($productos_rel as $producto_rel){
											$or=json_decode(modules::run('producto/read',$producto_rel->id_producto,'true'));
											echo '<option value="'.$producto_rel->id_producto_relacionado.'" selected="selected">'.$producto_rel->id_producto_relacionado.' - '.$producto_rel->nombre.'</option>';
										}
									}
									?>
								</select>
							</label>
							<strong class="boton"><button id="removeProductos"> <?php echo lang('producto_crear_pquitar'); ?>  &rArr;</button></strong>
						</div>
                      
						<div>
							<label for="categoriaRel">
								<?php
                                 $id = 'id="categoriaRel"';
								 if(is_array($categorias)&&(isset($categorias))&&($categorias!=NULL)&&(count($categorias)!=0))
								 {
								 $categorias[0]= lang('producto_crear_def');
                                 echo form_dropdown('', $categorias, 0,$id);
                                 }else{
                                 	echo lang('producto_crear_npro');
                                 } ?>
							</label>
							<label for="relProductosView">
								<select id="relProductosView" class="multiple charge" multiple>
								</select>
							</label>
							<strong class="boton"><button id="addProductos">&lArr; <?php echo lang('producto_crear_pmas'); ?> </button></strong>
						</div>
					</div>
			<div id='dyn_input'>
			
			</div>
			<!-- FIN Dyn -->
			<?php echo (isset($producto) ? '<input type="hidden" id="id_producto_hidden" name="id_producto" value="'.$producto->id_producto.'" />' : '')?>
			<strong class="boton"><button type="submit" class="guardar"><?php echo (isset($producto) ? lang('producto_crear_gua') : lang('producto_crear_cre'))?> </button></strong>
		</fieldset>
	</form>
			<!-- Formulario Formulario Crear Producto cierre -->
</div>
