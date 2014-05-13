<div class="row">
	<div class="six columns">
		<form class="custom">
			<fieldset>
				<legend><?php echo lang('pagos.titulo') ?></legend>
				<div class="row">
					<div class="four columns">
						<label class="inline" for="id_tipo_pago"><?php echo lang('pagos.tipo_pago')?></label>
					</div>
					<div class="eight columns">
						<?php echo form_dropdown('id_tipo_pago', $tipo_pago_opt, 1, 'id="id_tipo_pago"') ?>
					</div>
				</div>
				
				<div class="row">
					<div class="four columns">
						<label class="inline" for="referencia"><?php echo lang('pagos.referencia')?></label>
					</div>
					<div class="eight columns">
						<input type="text" name="referencia" id="referencia">
					</div>
				</div>
				
				<div class="row">
					<div class="four columns">
						<label class="inline" for="monto"><?php echo lang('pagos.monto')?></label>
					</div>
					<div class="eight columns">
						<div class="row collapse">
							<div class="eight columns">
								<input type="text" name="monto" id="monto">
							</div>
							<div class="four columns">
								<span class="postfix">Bs.F</span>
							</div>
						</div>
					</div>
				</div>
				
			</fieldset>
			
			<div class="row">
				<div class="twelve columns">
					<a href="#" class="button radius wtc" id="aceptar"><?php echo lang('aceptar') ?></a> 
					<a href="#" class="button radius wtc" id="limpiar"><?php echo lang('limpiar')?></a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php echo $pagos_js ?>