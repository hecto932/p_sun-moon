<?php
	$roles = modules::run('services/relations/get_all','rol');
	$usuarios = modules::run('services/relations/get_all','usuario');
?>

<script>
	$(function(){

		$('#fecha_desde, #fecha_hasta').datetimepicker({
			dateFormat: "<?php echo lang('datapicker_formato_fecha');?>",
			dayNamesMin: ["<?php echo lang('datapicker_dia_domingo_abr');?>", "<?php echo lang('datapicker_dia_lunes_abr');?>", "<?php echo lang('datapicker_dia_martes_abr');?>", "<?php echo lang('datapicker_dia_miercoles_abr');?>",  "<?php echo lang('datapicker_dia_jueves_abr');?>", "<?php echo lang('datapicker_dia_viernes_abr');?>", "<?php echo lang('datapicker_dia_sabado_abr');?>"],
			monthNames: ["<?php echo lang('datapicker_mes_enero');?>","<?php echo lang('datapicker_mes_febrero');?>","<?php echo lang('datapicker_mes_marzo');?>","<?php echo lang('datapicker_mes_abril');?>","<?php echo lang('datapicker_mes_mayo');?>","<?php echo lang('datapicker_mes_junio');?>","<?php echo lang('datapicker_mes_julio');?>","<?php echo lang('datapicker_mes_agosto');?>","<?php echo lang('datapicker_mes_septiembre');?>","<?php echo lang('datapicker_mes_octubre');?>","<?php echo lang('datapicker_mes_noviembre');?>","<?php echo lang('datapicker_mes_diciembre');?>"],
			currentText: "<?php echo lang('timepicker_hora_actual');?>",
			closeText: "<?php echo lang('timepicker_boton_cerrar');?>",
			timeOnlyTitle: "<?php echo lang('timepicker_titulo');?>",
			timeText: "<?php echo lang('timepicker_seleccion');?>",
			hourText: "<?php echo lang('timepicker_hora');?>",
			minuteText: "<?php echo lang('timepicker_minuto');?>"
		});
	});

</script>

<div class="row">
	<div class="twelve columns">
		
			<?php if(isset($breadcrumbs)): ?>
				<?php echo $breadcrumbs; ?>
			<?php endif; ?>

			<!-- Formulario Buscar Monitor -->

			<?php 
			if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';
			echo form_open('backend/monitor','id="gen_form" class="custom"');?>
				<fieldset>
					<div class="row">
						<div class="six columns centered">
							
							<!--
							<div class="row">
								<div class="three columns">
									<label class="inline" for="tipo_contenido">
										<span> <?php echo lang('monitor_tipoC'); ?> </span>
									</label>
								</div>
								<div class="nine columns">
									<select class="custom" id="tipo_contenido" name="tipo_contenido">
										<option value="">Todos</option>
										<option value="obra">Obras</option>
										<option value="artista">Artista</option>
										<option value="coleccion">Colecciones</option>
										<option value="categoria">Categorias</option>
										<option value="tecnica">Tecnicas</option>
										<option value="usuario">Usuarios</option>
										<option value="exposicion">Exposiciones</option>
										<option value="multimedia">Multimedia</option>
									</select>
								</div>
							</div>
							-->
								
							<div class="row">
								<div class="three columns">
									<label class="inline" for="fecha_desde">
										<span> <?php echo lang('monitor_desde'); ?> </span>
									</label>
								</div>
								<div class="nine columns">
									<input id="fecha_desde" name="fecha_desde" type="text" />
								</div>
								
							</div>
							
							<div class="row">
								<div class="three columns">
									<label class="inline" for="fecha_hasta">
										<span> <?php echo lang('monitor_hasta'); ?> </span>
									</label>
								</div>
								<div class="nine columns">
									<input id="fecha_hasta" name="fecha_hasta" type="text" />
								</div>
							</div>
							
							<div class="row">
								<div class="three columns">
									<label class="inline" for="roles">
										<span> <?php echo lang('usuarios_rol'); ?> </span>
									</label>
								</div>						
								<div class="nine columns">
									<select id="roles" name="id_rol">
										<option value="">Todos</option>
										<?php foreach($roles as $rol){
											echo '
										<option value="'.$rol->id_rol.'</option>">'.$rol->nombre.'</option>';
											
										}
											?>
									</select>
								</div>
							</div>
							
							<div class="row">
								<div class="three columns">
									<label class="inline" for="tipo_accion">
										<span> <?php echo lang('monitor_tipoA'); ?> </span>
									</label>	
								</div>
								<div class="nine columns">
									<select id="tipo_accion" name="tipo_accion">
										<option value="">Todas</option>
										<option value="listado">Listado</option>
										<option value="crear">Crear</option>
										<option value="editar">Editar</option>
										<option value="borrar">Borrar</option>
										<option value="editar_idioma">Editar idioma</option>
										<option value="eliminar_idioma">Eliminar idioma</option>
									</select>
								</div>						
							</div>
							
							<div class="row">
								<div class="three columns">
									<label class="inline" for="id_usuario">
										<span> <?php echo lang("usuario"); ?> </span>
									</label>
								</div>
								<div class="nine columns">
									<select id="id_usuario" name="id_usuario">
										<option value="">Todas</option>
									<?php foreach($usuarios as $usuario){
										echo '
										<option value="'.$usuario->id_usuario.'">'.$usuario->apellidos.', '.$usuario->nombre.'</option>';
										
									}
										?>
									</select>
								</div>
							</div>
							
							<div class="row">
								<div class="twelve columns alinear-derecha">
									<button class="button radius wtc" type="submit"> <?php echo lang("buscar") ?> </button>	
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
			<!-- Formulario Buscar Obra cierre -->
			
		
		</div>
</div>