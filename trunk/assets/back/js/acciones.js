function id_nombre (cadena, modal){
	cadena = cadena.substr(0, cadena.lastIndexOf("."));
	if(modal == false)
	{
		return cadena.replace(/ /g, '_').replace(/\\.[^.\\s]{3,4}$/g, '').toLowerCase();	
	}
	else
	{
		return cadena.replace(/ /g, '_').replace(/\\.[^.\\s]{3,4}$/g, '').toLowerCase() + '_modal';	
	}
	
}

function limite_caracteres() {
  var cnt = $("#actual_breve");
  var txt = $('textarea[name=descripcion_breve]').val(); 
  var len = txt.length;
  var limit = 200; 
  
  if(len > limit){
    $('textarea[name=descripcion_breve]').val(txt.substr(0,limit));
    $('#actual_breve').html(len-1);
  } 
  else { 
    $(cnt).html(len);
    if($(cnt).hasClass("error_breve")){
    	$('#actual_breve').removeClass("error_breve");
    	$('#actual_breve').addClass("normal_breve");
    }
  }
     
  
  if(limit-len <= 20) {
  	if($('#actual_breve').hasClass('normal_breve')){
  		$('#actual_breve').removeClass('normal_breve');	
  	}
    $('#actual_breve').addClass("error_breve");
  }
}

function nombre2url(){
	var url_temp = $('input[name=nombre]').val();
	url_temp = url_temp.replace(/[^a-z 0-9~%.:_\-]/gi, "")
	url_temp = url_temp.replace(/ /gi, "-");
	url_temp = url_temp.replace(/\./gi, "");
	url_temp = url_temp.toLowerCase();
	$('input[name=url]').val(url_temp);
}

function add_modal(imagen, dir){
	var nombre = id_nombre(imagen.name, true);
	var html_modal = '<div id ="' + nombre + '" class ="reveal-modal [expand, xlarge, large, medium, small]" >'
	+ '<div class="row"> <div class="twelve columns"> <img src= "' + dir + imagen.name + '"/> </div> </div>'
	+ '<div class="row"> <div class="twelve columns"> <a href="' + dir + imagen.name + '" target="_blank" class="button radius success"> <i class="general foundicon-down-arrow"/>  Descargar </a> </div> </div>' 
	+ '</div>';
	$('#zona_modal').append(html_modal);
}

function add_thumb(data, imagen, dir){
	thumb = data.context.find('.preview canvas').remove();
	data.context.find('.preview')
	.html('<a href="#" data-reveal-id="' + id_nombre(imagen.name, true) 
	+  '">' + '<img src="' + dir + 'thumbnail/' + imagen.name +  '"/></a>');
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

/*--------------------------------------------------------------------------------------------------------*/
/*										SECCIÓN DE LLAMADAS 										      */
/*--------------------------------------------------------------------------------------------------------*/

$(document).ready(function(){
	$('input[name=nombre]').bind('change keyup', nombre2url);
	$('textarea[name=descripcion_breve]').keyup(limite_caracteres);
});
