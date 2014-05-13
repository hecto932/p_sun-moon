<script type="text/javascript">
	$(document).ready(function(){
//Full Caption Sliding (Hidden to Visible)
		

	function cambio_select() {
		$.ajax({
			data:		{ tipo_cat : $("#tipo_cat").val() },
			url:		'<?= site_url('services/relations/arbol_categorias/')?>/' + $("#tipo_cat").val(),
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
	
	function eliminarMultimedia(id) {
		$.ajax({
			data:		{ id_multimedia : id },
			url:		' <?= site_url('services/services/ajax_eliminar_multimedia/categoria') ?>',
			type:		'POST',
			success:	function() {
				$('#imagen_' + id).fadeOut('slow');
			}
		});
	}
	function eliminarTempMultimedia(id, posicion) {
	$('input#imgActualBackend' + posicion).remove();
	$('li#img_' + id).fadeOut('slow');
	}
	$('.boxgrid.captionfull').hover(function(){
			$(".cover", this).stop().animate({top:'30px'},{queue:false,duration:100});
		}, 
		function() {
			$(".cover", this).stop().animate({top:'60px'},{queue:false,duration:100});
		});
		
});
</script>
<div id="ficha">
	<?php
	echo validation_errors();
	$id = (isset($categoria -> id_categoria) ? $categoria -> id_categoria : '');
	?>
	<h2><?php echo ($id != '' ? lang('categoria_edi_tit') : lang('categoria_cre_tit') )?> </h2>
	<!-- Formulario Editar Categoria -->
	<?php  echo form_open('categoria/create/' . $id, 'id="gen_form" class="editar_categoria"');?>
	<fieldset>
		<table class="proyectoTabla" width="100%">
			<tr>
				<td width="20%"><label for="estado"><span> <?php echo lang('estado');?> </span></label></td>
				<td width="80%">
				<select id="estado" name="id_estado">
					<?php
					foreach (json_decode($estados) as $estado) {
						echo '<option value="' . $estado -> id_estado . '" ' . ($estado -> id_estado == $categoria -> id_estado ? 'selected="selected"' : set_select('id_estado', $estado -> id_estado)) . '>' . ucwords($estado -> estado) . '</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td width="20%"><label for="tipo"><span> <?php echo lang('tipo'); ?> </span></label></td>
				<td width="80%"><?php  //die(print_r($tipos_cat));?>
				<select id="tipo_cat" name="id_tipo_cat" onchange="cambio_select()">
					<?php
					foreach (json_decode($tipos_cat) as $tipo) {
						echo '<option value="' . $tipo -> id . '" ' . ($tipo->id == $categoria -> id_tipo_cat ? 'selected="selected"' : set_select('id', $tipo -> id)) . '>' . ucwords($tipo -> nombre) . '</option>';
					}
					?>
				</select></td>
			</tr>
			<?php if($arbol_categorias!='false'){ ?>
			<tr>
				<td><label for="padre"><span> <?php echo lang('categoria_padre'); ?> </span></label></td>
				<td>
					<input id="selected-cat" type="hidden" value="<?php echo $id ?>"/>
					<div id="tree">
                        <? echo $arbol_categorias; ?>
                    </div>
				<!--<div id="tree">
					<?php  echo $arbol_categorias;?>
				</div>-->
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td></td>
				<td><label for="destacado">
					<input style="width:12px;" id="destacado" name="destacado" type="checkbox" value="1"  <?php  echo((isset($categoria -> destacado) && $categoria -> destacado == 1) ? 'checked="checked"' : set_checkbox('destacado', '1'));?> /> <span style="width:70px;"> <?php echo lang('destacado'); ?> </span> </label></td>
			</tr>
			<tr>
				<td><label for="imagen" rowspan="2"><span> <?php echo lang('imagen'); ?> (500x300)</span></label></td>
				<td>
				<div id="inputFile" class="imgContainer">
					<ul id="inputFileul">
						<?php
						$img = '';
						if (isset($categoria)) {
							//print_r($categoria);
							$img = json_decode(modules::run('services/relations/get_rel', 'categoria', 'imagen', $categoria -> id_categoria, 'true', 'multimedia.id_multimedia'));
							//echo '<pre>'.print_r($img,true).'</pre>';
							//die();
							echo generate_thumbs_2($img, $categoria, 'categoria', 'nombre', 'imagenActual[]', "imagen", true);
						}
						?>
					</ul>
				</div></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<input id="imagen" name="imagen" type="file" class="categoria" />
				<input id="imagenName" name="imagenName" type="hidden" />
				</td>
			</tr>
		</table>
		<?php echo (isset($categoria) ? '<input type="hidden" name="id_categoria" value="' . $categoria->id_categoria . '" />' : '')
		?>
		<strong class="boton">
		<button type="submit" class="guardar">
			<?php echo (isset($categoria) ? lang('guardar') : lang('crear'))?>
		</button></strong>
	</fieldset>
	<div id="dyn_input"></div>
</div>