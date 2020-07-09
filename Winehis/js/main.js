$(function(){
	$('.center').slick({
	  centerMode: true,
	  centerPadding: '150px',
	  autoplay: true,
      autoplaySpeed: 7000,
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: true,
	  focusOnSelect: true,
	  speed: 1500,
      infinite: true,
      cssEase: 'ease-in-out',
      touchThreshold: 100,
	  responsive: [
		    {
		      breakpoint: 768,
		      settings: {
		        arrows: true,
		        centerMode: true,
		        centerPadding: '40px',
		        slidesToShow: 1
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        arrows: true,
		        centerMode: true,
		        centerPadding: '40px',
		        slidesToShow: 1
		      }
		    }
		]
	});
	

	$(".center").on('afterChange', function(event, slick, currentSlide){
	     $("#cp").text(currentSlide + 1);
	});

	$(window).scroll(function(){
		$('#bot_gr').each(function(){
			var imagePos = $(this).offset().top;

			var topOfWindow = $(window).scrollTop();
			if (topOfWindow < imagePos-650){
				$('.grape').addClass("slideInUp");
				$('.bottle').addClass("slideInUp");
			}
		});
			
	});
	
	$(window).scroll(function() { 
		if ($(this).scrollTop() > 60) {  
			$('.full').hide();
			$('.short').show();
		}else{
			$('.full').show();
			$('.short').hide();
		}

	});
	
})

$(function() {
    var $elie = $(".ellipse"), degree = 0, timer;
    rotate();
    function rotate() {
        
        $elie.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});  
        $elie.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});                      
        timer = setTimeout(function() {
            ++degree; rotate();
        },100);
    }
    
    $(".input").toggle(function() {
        clearTimeout(timer);
    }, function() {
        rotate();
    });
});
var delay_popup = 0;
setTimeout("document.getElementById('openModal').style.display='block'", delay_popup);