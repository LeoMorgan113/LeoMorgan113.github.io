$(document).ready(function() {
setTimeout(function(){$(".owl-carousel").owlCarousel()},2000);
})

$(function() {


	$(window).scroll(function() { 
       if ($(this).scrollTop() > 100) {  
			$('#head').addClass('head_w animate__animated animate__fadeInDown animate__delay-0.5s 2s');
			$('#header').addClass('container1');
			$('.white').hide();
			$('.blue').show();
		}else{
			$('#head').removeClass('head_w animate__animated animate__fadeInDown animate__delay-0.5s 2s');
			$('#header').removeClass('container1');
			$('.white').show();
			$('.blue').hide();
		}
    });
   $('.owl-carousel').owlCarousel({
	    loop:true,
	    margin:0,
	    nav:true,
	    dots: true,
	    mouseDrag: true,
	    touchDrag: true,
	    navText: ['<img src="img/left.png" alt="left" />','<img src="img/right.png" alt="right" />'],
	    startPosition: 0,
	    responsive:{
	        0:{
	            items:1
	        },
	        575:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
    });
});