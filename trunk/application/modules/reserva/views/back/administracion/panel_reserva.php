
<div class="row">
	<div class="twelve columns">
		<ul class="button-group even five-up">
			<li>
				<form method="POST" action="/backend/reservaciones/resumen">
					<button style="background-color: #00A2AD;" name="panel_diario" value="diario" class="button" ><?php echo lang('reservacion_resumen_diario'); ?><br /></button>
				</form>
			</li>
			<li>
				<form method="POST" action="/backend/reservaciones/resumen">
					<button style="background-color: #00A2AD;" name="panel_habitaciones" value="habitaciones" class="button" ><?php echo lang('reservacion_resumen_habitaciones'); ?></button>
				</form>
			</li>
			<!--
			<li>
				<form method="POST" action="/backend/reservaciones/listado">
					<button style="background-color: #00A2AD;" name="panel_reservaciones" value="reservaciones" class="button" ><?php echo lang('reservacion_listado_reservaciones'); ?></button>
				</form>
			</li>
			-->
			<li>
				<form method="POST" action="/backend/reservaciones/reservar">
					<button style="background-color: #00A2AD;" name="panel_reservar" value="reservar" class="button" ><?php echo lang('reservacion_efectuar_reservacion'); ?></button>
				</form>
			</li>
			<li>
				<form method="POST" action="/backend/reservaciones/pagos">
					<button style="background-color: #00A2AD;" name="panel_reservar" value="reservar" class="button" ><?php echo lang('reservacion_confirmar_pago'); ?></button>
				</form>
			</li>
			<li>
				<form method="POST" action="/backend/reservaciones/asignacion">
					<button style="background-color: #00A2AD;" name="panel_asignacion" value="asignacion" class="button" ><?php echo lang('reservacion_asignacion_habitacion'); ?></button>
				</form>
			</li>
		</ul>
	</div>
</div>