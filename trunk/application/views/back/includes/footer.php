				<div id="myModal" class="reveal-modal [expand, xlarge, large, medium, small]">
					<img src="<?php echo base_url(); ?>assets/back/img/template/logo.jpg" />
					<hr>

					<h2><?php echo lang('operacion_imagen'); ?></h2>
					<p><?php echo lang('dialogo_modal'); ?></p>
					<div class="progress radius wtc eigth">
						<span class="meter"></span>
					</div>
					<a id ="cerrar_subida" class="close-reveal-modal">&#215;</a>
					<div class="row">
						<div class="twelve columns">
							<button id="cerrar_upload" class="button alert radius">
								<i class="general foundicon-remove"></i> <?php echo lang('modal_imagen'); ?>
							</button>
						</div>
					</div>
				</div>


				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/foundation.min.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/modernizr.foundation.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.filedrop.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/app.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/responsive-tables.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery-ui.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.textareaCounter.plugin.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/prettify.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.fileupload.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.iframe-transport.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/load-image.min.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/canvas-to-blob.min.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.fileupload-fp.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/acciones.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery-ui-timepicker-addon.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/accounting.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.inputmask.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.inputmask.extensions.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.inputmask.numeric.extensions.js"></script>
				<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/jquery.tmpl.min.js"></script>
				<script type="text/javascript" src="http://cssdeck.com/assets/js/embed.js"></script>


					<?php if(isset($eventos_js)): ?>
						<?php echo $eventos_js; ?>
					<?php endif; ?>


					<?php if(isset($noticias_js)): ?>
						<?php echo $noticias_js; ?>
					<?php endif; ?>

					<script>
						$(document).ready(function()
						{
							CKEDITOR.editorConfig = function( config )
							{
								 config.language= '<?php echo $this->session->userdata('idioma'); ?>',
								 config.uiColor = '#4F8ABE';
							};
						});

					</script>

					<?php
						if(isset($ficha_js)){
							echo $ficha_js;
						}
					?>

					<?php
						if(isset($file_upload_js))
						{
							echo $file_upload_js;
						}
					?>

				<?php if(isset($imagen)): ?>
					<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/js/imagenes.js"></script>
				<?php endif; ?>
				
				<!-- Chosen JS -->
				<?php if(isset($cargar_chosen) && $cargar_chosen): ?>
					<script type="text/javascript" src="<?php echo base_url(); ?>assets/back/chosen/chosen.jquery.min.js"></script>
				<?php endif; ?>
	</body>
</html>