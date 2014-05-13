function ajustarFileupload( e ) {
			var ancho = $(window).width();
	  		var span_w;
	  		
	  		if(ancho < 768)
	  		{
				$("#fileupload").css("width", $("#fileupload").parent().css("width"));	
	  		}
	  		if(ancho > 768 && $("fileupload").width() != 127){
	  			$("#fileupload").css("width", 127);
	  		}
				
	  		
	  		
}

$(document).ready(function(){
	$(window).bind("resize", ajustarFileupload);
	$(window).bind("load", ajustarFileupload);
});
