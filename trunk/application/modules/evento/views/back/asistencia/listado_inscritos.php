<?php if ( ! empty($inscritos)): ?>
	<form class="custom">
		<table class="twelve">
			<thead>
				<tr>
					<th width="25%"><?php echo anchor("$uri_base/nombres/$new_orden/$from",lang('inscritos.nombre_completo').query_arrow('nombres', $order_campo, $new_orden))?></th>
					<?php $width = $evento->dias > 1 ? 75/($evento->dias+1) : 75/$evento->dias; ?>
					<?php if ($evento->dias > 1): ?><th>Todos</th><?php endif ?>
					<?php for ($i = 1; $i <= $evento->dias; $i++): ?>
						<th width="<?php echo "$width%" ?>"><?php echo $evento->dias < 11 ? "Día $i" : $i ?></th>
					<?php endfor ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($inscritos as $usuario): ?>
				<tr>
					<td><?php echo anchor('', $usuario->nombres.' '.$usuario->apellidos) ?></td>
					<?php if ($evento->dias > 1): ?>
					<td>
						<div class="asistencia-dia todos"></div>
					</td>
					<?php endif ?>
					<?php $dias = strlen($usuario->dias_asistidos) ? explode(",", $usuario->dias_asistidos) : array() ?>
					<?php for ($i = 1; $i <= $evento->dias; $i++): ?>
						<td>
							<input type="hidden" name="id_inscripcion" value="<?php echo $usuario->id_inscripcion ?>">
							<input type="hidden" name="dia" value="<?php echo $i ?>">
							<div class="asistencia-dia<?php if (in_array($i, $dias)) echo ' checked' ?>"></div>
						</td>
					<?php endfor ?>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</form>
	
	<!-- Leyenda -->
	<table class="two">
		<tr>
			<td><div class="asistencia-dia"></div></td>
			<td>No Asistió</td>
		</tr>
		<tr>
			<td><div class="asistencia-dia checked"></div></td>
			<td>Asistió</td>
		</tr>
	</table>
	
	<?php echo $this->pagination->create_links() ?>
<?php else: ?>
	<div class="alert-box">
		<?php echo lang('inscritos.sin_datos')?>
	</div>
<?php endif ?>

<?php echo $asistencia_css ?>
<?php echo $asistencia_js ?>