<script>

	var cont = 0;
	var datos = new Array();

	function procesar_imagen(){
		$.ajax({
				type: "POST",
				url: "<?php echo $url; ?>",
				data: { valores: datos },
				dataType: 'json'
				}).done(function( msg ) {
			});
		datos = [];
	}

	$(function () {
	   var jqXHR = null;
	   $('#fileupload').fileupload({
	    	add: function (e, data){
	    		var that = this;
	    		var file = data.files[0];
	    		var nombre_tr = id_nombre(file.name, false);

	    		$('<tr id = "' + nombre_tr + '"/>').appendTo("#tabla_imagen");
	            $('<td class="preview"/> <td class="nombre"/> <td class="size"/>  <td class="zona_bar"/> <td class="inicio"/> <td class="cancelar"/>').appendTo('#' + nombre_tr);


	            	 var loadingImage = window.loadImage(
					        file,
					        function (img) {
					        	$(img).appendTo('#' + nombre_tr + ' >  td[class=preview]');
					        },
					        {maxWidth: 80, maxHeight: 35, canvas: true}
					    );



				$('<p>').text(file.name).appendTo('#' + nombre_tr + '> td[class=nombre]');

	       		$('<p>').text(bytesToSize(file.size)).appendTo('#' + nombre_tr + '> td[class=size]');

	       		$('<div class="nice radius progress success" aria-valuenow="0" aria-valuemax="0" aria-valuemin="0" role="progressbar"> '
                + '<span class="meter" style="width: 0%;" '
                + 'id = "barra_' + nombre_tr + '"' + ' />  </div>').appendTo('#tabla_imagen tr:last > td[class=zona_bar]');

                $('<button class="small button radius wtc"> <i class="general foundicon-up-arrow"/> Iniciar </button>')
                .appendTo('#' + nombre_tr +  '> td[class=inicio]')
                .click(function(){
                	var progress = parseInt(data.loaded / data.total * 100, 10);
                	var temp = $(this).parents('tr').find('.zona_bar .meter');
                	$(this).remove();
                	$('#' + nombre_tr + '> td[class=inicio]').html('<p> listo </p>');
                	$('#' + nombre_tr + '> td[class=cancelar] > button').removeClass('alert').addClass('warning');
                	$('#' + nombre_tr + '> td[class=cancelar] > button').html('<i class="general foundicon-trash"/> Limpiar');
                	data.submit();
                });

                $('<button class="small button radius alert"> <i class="general foundicon-remove"/> Cancelar </button>')
	                .appendTo('#tabla_imagen tr:last > td[class=cancelar]')
	                .click(function() {
	                	file = null;
	                	$('#' + nombre_tr).remove();
	            });

	            $('button[name=inicio]').click(function(){
	            	if(file != null){
		            	data.submit();
		            	$('#tabla_imagen tr > td[class=inicio]').html('<p> listo </p>');
		            	$('.cancelar > button').removeClass('alert').addClass('warning');
                		$('.cancelar > button').html('<i class="general foundicon-trash"/> Limpiar');
		            	var progress = parseInt(data.loaded / data.total * 100, 10);
		        		$('.meter').css('width', progress + '%');
		        		file = null;
		        	}
	       		 });

	       		 $('button[name=limpiar]').click(function(){
	       		 	file = null;
	            	$("#tabla_imagen").find("tr:gt(0)").remove();
	            	$('#zona_modal').empty();

	       		 });

				var row =  $('#' +  nombre_tr);
	    		row.appendTo('#tabla_imagen');
	    		data.context = row;
	    	},
	        done: function (e, data) {
			     $("#myModal").reveal();
			     imagen = data.files[0];
			     var temp = new Object();

			     /*
			      *	Tipos de archivos
			      * 1: imagen
			      *
			      * */
			     temp.fichero = imagen.name;
			     temp.id = $('#id_campo').val();
			     temp.destacado = <?php echo $destacado; ?>;
			     temp.id_tipo = 1;

			     var dir = "<?php echo base_url().'assets/front/img/temp/'; ?>";
			     add_modal(imagen, dir);
			     add_thumb(data, imagen, dir);
			     datos.push(temp);
	        },
	        progress: function(e, data){
	        	var progress = parseInt(data.loaded / data.total * 100, 10);
	        	var barra = data.context.find('.meter').css('width', progress + '%');
	        }
	    });

	    $('#cerrar_subida').click(function(e){
	    	procesar_imagen();
	    });

	    $('#cerrar_upload').click(function(e){
	    	procesar_imagen();
	    	$('#myModal').trigger('reveal:close');
	    });
	});
</script>