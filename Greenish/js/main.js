$(function(){
	$('nav .menu a').on('click', function(){ 
        $('nav .menu a').css({
        	"color": "#8a8a8a",
			"padding": "15px 0",
			"border": "none"
        });
        $(this).css({
        	"color": "#7cbe5c",
			"padding": "15px 0 10px 0",
			"borderBottom": "5px solid #7cbe5c"
        });
        return false;           
    });
    $('button').hover(function(){
    	$( this ).addClass( "hover" );
  	}, function() {
    	$( this ).removeClass( "hover" );
  	});
});