<?php if($this->session->flashdata('mensaje') == lang('archivo_sub') || $this->session->flashdata('mensaje') == lang('archivo_elim')): ?>
	<div class="alert-box success">
		<?php echo $this->session->flashdata('mensaje'); ?>
		<a class="close" href="">×</a>
	</div>
<?php elseif($this->session->flashdata('mensaje') != ''): ?>
	<div class="alert-box alert">
		<?php echo $this->session->flashdata('mensaje'); ?>
		<a class="close" href="">×</a>
	</div>
<?php endif; ?>




<?php //if(!isset($documento) || empty($documento))
	echo form_open_multipart(lang('backend_url').'/'.lang('eventos_url').'/'.lang('subir_url').'/'.lang('pdf_url'), array('id' => 'subir_pdf'));
//else
	//echo form_open(lang('backend_url').'/'.lang('eventos_url').'/'.lang('eliminar_url').'/'.lang('pdf_url'));
?>

<div class="row">
	<div class="six columns ficha_evento">
		<h3><?php echo lang('ficha_datos'); ?></h3>
		
		<?php $estado = json_decode(modules::run('services/relations/get_from_id','estado',$evento->id_estado,'true')); ?>

		<table style="border: 0px; padding: 3px 3px;">
			<tr>
				<td><i class="foundicon-website"></i> <?php echo lang('estado'); ?>:</td>
				<td><?php echo ucfirst($estado->estado); ?></td>
			</tr>
			<tr>
				<td><i class="general foundicon-address-book"></i> <?php echo lang('eventos_crear_tipo_evento')  ?>:</td>
				<td><?php echo lang('eventos_tipo_'.$evento->id_tipo_evento); ?></td>
			</tr>
			<tr>
				<td><i class="foundicon-calendar"></i> <?php echo lang('eventos_crear_fecha'); ?>:</td>
				<td><?php echo date('d/m/Y' , strtotime($evento->fecha_evento));  ?></td>
			</tr>
			<tr>
				<td><i class="general foundicon-clock"></i> <?php echo lang('eventos_crear_hora_evento')  ?>:</td>
				<td><?php echo date('G:i' , strtotime($evento->hora_evento)); ?></td>
			</tr>
		</table>
	</div>
	
	<div class="six columns">
			<h3>Archivos Asociados</h3>
			<table class="twelve archivos_evento">
				<tbody>
				<?php if (count($archivos)): ?>
					<?php foreach ($archivos as $archivo): ?>
						<tr>
							<td>
								<i class="foundicon-page" style="margin-right:5px;"></i>
								<?php echo anchor('assets/front/uploads/eventos/pdf/'.$archivo->fichero, $archivo->fichero, 'target="_blank"') ?>
							</td>
							<td>
								<form>
									<a href="<?php echo base_url().'backend/eventos/eliminar/pdf/'.$evento->id_evento.'/'.$archivo->fichero; ?>"><i class="foundicon-remove" style="margin-right:5px;"></i></a>
								</form>
							</td>
						</tr>
					<?php endforeach ?>
				<?php endif ?>
				</tbody>
			</table>
			
			<?php if (count($archivos) == 0): ?>
				<div class="alert-box sin_archivos">No se han subido archivos para este evento.</div>
			<?php endif ?>
			
			<span class="twelve radius" name="pdf_upload">
				Arroje aquí un archivo para asociar al evento <span style="color: #6E6E6E; font-size: 11px">(máximo 3.5 mb)</span>.
				<input name="pdf_file" id="pdf_file" type="file" accept="" >
				<input type="hidden" name="id_evento" value="<?php echo $evento->id_evento; ?>" />
			</span>
	</div>
</div>

<div class="row">
	<div class="six columns">
		<?php
			if($this->session->userdata('idioma') == 'es')
				echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('editar_url').'_'.lang('evento_url').'/'.$evento->id_evento, lang('editar_tit_even'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
			else
				echo anchor(lang('backend_url').'/'.lang('eventos_url').'/'.lang('editar_url').'_'.lang('articulo_url').'/'.$evento->id_evento, lang('editar_tit_even'), array('title'=>lang('editar_tit_not'), 'class' => 'button radius wtc'));
		?>
		
		<ul class="button-group even three-up radius" style="margin-top:30px;">
			<?php echo '<li>'.anchor(lang('backend_url').'/'.lang('eventos_url').'/hospedaje/'.$evento->id_evento, 'Hospedaje' ,array('class' => 'button')).'</li>'?>
			<?php if ($evento->inscripcion) echo '<li>'.anchor(lang('backend_url').'/'.lang('eventos_url').'/inscripciones/'.$evento->id_evento, 'Inscripciones', array('class' => 'button')).'</li>' ?>
			<?php if ($evento->inscripcion) echo '<li>'.anchor(lang('backend_url').'/'.lang('eventos_url').'/asistencia/'.$evento->id_evento, 'Asistencia', 'class="button"').'</li>'?>
		</ul>
	</div>
	<div class="six columns alinear-derecha">
		<button type="submit" id="boton_subir" class="button radius wtc">Subir Archivo</button>
	</div>
</div>
</form>

<div id="tipoArchivoInvalidoModal" class="reveal-modal large">
	<img src="http://wtcval/assets/back/img/template/logo.png"/>
	<hr>

	<h2><?php echo lang('evento_modal_tipo_inv_titulo'); ?></h2>
	<p><?php echo lang('evento_modal_tipo_inv_contenido'); ?></p>
	<a id ="cerrar_subida" class="close-reveal-modal">&#215;</a>
	<div class="row">
		<div class="twelve columns">
			<button id="cerrarTipoArchivoInvalidoModal" class="button alert radius">
				<i class="general foundicon-remove"></i> <?php echo lang('modal_imagen'); ?>
			</button>
		</div>
	</div>
</div>

<div id="archivoVacioModal" class="reveal-modal large">
	<img src="http://wtcval/assets/back/img/template/logo.png"/>
	<hr>

	<h2><?php echo lang('evento_modal_archivo_vacio_titulo'); ?></h2>
	<p><?php echo lang('evento_modal_archivo_vacio_contenido'); ?></p>
	<a id ="cerrar_subida" class="close-reveal-modal">&#215;</a>
	<div class="row">
		<div class="twelve columns">
			<button id="cerrarArchivoVacioModal" class="button alert radius">
				<i class="general foundicon-remove"></i> <?php echo lang('modal_imagen'); ?>
			</button>
		</div>
	</div>
</div>
