<div style="margin-top:40px;" class="row tit_section">
		<h2>Your Profile</h2>
		<p>Donec ullamcorper nulla non metus auctor fringilla. Maecenas faucibus mollis interdum.</p>
		</div>
		
		<div class="row">
		<hr />
		</div>

<div class="row">
	<div class="five columns"></div>
	<div class="six columns form_resume">
		<?php echo form_open_multipart('carreras/enviar_cv', array("class" => "custom")); ?>
			<input name = "nombre" id = "nombre" type="text" value = "<?php echo set_value('nombre'); ?>" placeholder="<?php echo lang('carreras_placeholder_nombre'); ?>" />
			<input name = "apellido" id = "apellido" type="text" value = "<?php echo set_value('apellido'); ?>" placeholder="<?php echo lang('carreras_placeholder_apellido'); ?>" />
			
			<h2>Phone Numbers</h2>
			<input name = "numero" id = "numero" type="text" value = "<?php echo set_value('numero'); ?>" placeholder="<?php echo lang('carreras_placeholder_numero'); ?>" />
			<input name = "extension" id = "extension" type="text" value = "<?php echo set_value('extension'); ?>" placeholder="<?php echo lang('carreras_placeholder_extension'); ?>" />
			<input name = "tipo" id = "tipo" type="text" value = "<?php echo set_value('tipo'); ?>" placeholder="<?php echo lang('carreras_placeholder_tipo'); ?>" />
			<input name = "email" "email" type="text" value = "<?php echo set_value('email'); ?>" placeholder="<?php echo lang('carreras_placeholder_email'); ?>" />
			
			<h2>Addresses (1):</h2>
			
			<select class="customDropdown">
	  			<option SELECTED>* Type</option>
	  			<option>This is another option</option>
	  			<option>Look, a third option</option>
			</select>
			
			<input name = "calle" id = "calle" type="text" value = "<?php echo set_value('calle'); ?>" placeholder="<?php echo lang('carreras_placeholder_calle'); ?>" />
			<input name = "ciudad" id = "ciudad" type="text" value = "<?php echo set_value('ciudad'); ?>" placeholder="<?php echo lang('carreras_placeholder_ciudad'); ?>" />
			<input name = "zip" id = "zip" type="text" value = "<?php echo set_value('zip'); ?>" placeholder="<?php echo lang('carreras_placeholder_zip'); ?>" />
			<input name = "pais" id = "pais" type="text" value = "<?php echo set_value('pais'); ?>" placeholder="<?php echo lang('carreras_placeholder_pais'); ?>" />
		
			<select class="customDropdown">
				  <option SELECTED>* State</option>
				  <option>This is another option</option>
				  <option>Look, a third option</option>
			</select>

			<input type="text" placeholder="Exp. (Years)" />
			<select class="customDropdown">
				  <option SELECTED>How did you hear about us?</option>
				  <option>This is another option</option>
				  <option>Look, a third option</option>
			</select>

			<textarea name = "comentario" id = "comentario" placeholder="Please copy and paste your cover letter or enter any comments"></textarea>

			<h3>* Please upload your resume (max size: 512 KB)</h3> <input type="file" class="small button"> CHOOSE FILE </input> 

			<textarea name = "resumen" id = "resumen" placeholder="Or, copy and paste the text version of your resume"></textarea>

			<h4>By clicking the button below you agree to iCIMS' privacy policy.</h4>

			<input type="submit" class="button" value="SUBMIT FORM">


		<?php echo form_close(); ?>
		</form>
	</div>
	
	<div class="one column"></div>
</div>