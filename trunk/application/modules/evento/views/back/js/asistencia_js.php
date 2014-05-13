<script type="text/javascript">
$(document).ready(function()
{
	$('table.twelve .asistencia-dia').bind('click', function()
	{
		var _this = $(this);
		
		if (_this.is('.checked'))
			_this.removeClass('checked', 500);
			
		else
			_this.addClass('checked', 500);

		var id_inscripcion = _this.siblings(':hidden[name=id_inscripcion]').val();
		var dia = _this.siblings(':hidden[name=dia]').val();
		$.post('<?php echo site_url('evento/asistencia/marcar') ?>',
		{ "id_inscripcion" : id_inscripcion, "dia" : dia });
	});

	$('table.twelve .asistencia-dia.todos').bind('click', function()
	{
		if ($(this).is('.checked'))
			$(this).closest('tr').find('.asistencia-dia:not(.todos)').trigger('click');
		
		else
			$(this).closest('tr').find('.asistencia-dia:not(.checked,.todos)').trigger('click');
	});
});
</script>
