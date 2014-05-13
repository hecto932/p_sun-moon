<?php
$estados=modules::run('services/relations/get_all','estado','true');
$banner = modules::run('services/relations/get_all','banner','true','banner.id_banner');
?>

<div class="row">
	<div class="twelve columns">

		<?php if(isset($breadcrumbs)): ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>

		<!-- Formulario Buscar FAQ -->
		<?php if (isset($mensaje) && $mensaje!='') echo '<p class="error">'.lang('listado_error').'</p>';

		echo form_open('backend/banners','id="gen_form" class="custom"');?>
			<fieldset>
				<div class="row">
					<div class="six columns centered">
						<div class="row">
							<div class="two columns">
								<label class="inline" for="id_banner">
									<span> <?php echo lang('banners_ficha_id'); ?> </span>
								</label>
							</div>
							<div class="ten columns">
								<input name="id_banner" type="text" />
							</div>
						</div>

	                    <div class="row">
		                    <div class="two columns">
								<label class="inline" for="estado">
									<span> <?php echo lang('estado'); ?> </span>
								</label>
							</div>					
							<div class="ten columns estado" >
								<select class="custom" id="estado" name="id_estado" >
									<option value=""> <?php echo lang('banners_ficha_estado'); ?> </option>
									<?php foreach(json_decode($estados) as $estado){
											echo '<option value="'.$estado->id_estado.'">'.$estado->estado.'</option>';
										}
									?>
								</select>
							</div>
						</div>
							

						<div class="row">
							<div class="twelve columns alinear-derecha">
								<button class="button radius wtc" type="submit"> <?php echo lang('buscar'); ?> </button>		
							</div>
						</div>						
					</div>
				</div>
		</fieldset>
			</form>		
		
			<!-- Formulario Buscar Obra cierre -->
	</div>
</div>

