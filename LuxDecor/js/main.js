$(function() {
	$('.projects-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    mouseDrag: true,
    touchDrag: true,
    autoplay: true,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    navText: ['<img src="img/Vector 1.png" alt="left" />','<img src="img/Vector 2.png" alt="right" />'],
    startPosition: 0,
    responsive:{
        0:{
            items:1
        },
        575:{
            items:2
        },
        1000:{
            items:3
        }
    }
    });
    $('.modal_carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    mouseDrag: true,
    touchDrag: true,
    navText: ['<img src="img/Vector 1.png" alt="left" />','<img src="img/Vector 2.png" alt="right" />'],
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
    $('#navbarToggle').blur(function(event){
        var screenWidth = window.innerWidth;
        if (screenWidth < 992){
            $('#collapsibleNavbar').collapse('hide');
        }
    });
    $('#navbarToggle').hover(function(){
        this.focus();
    });

    $(window).scroll(function() { 
        var scrollBottom =
    $(document).height() - $(window).height() - $(window).scrollTop();
        if ($(this).scrollTop() > 350 && scrollBottom > 50) {  
            $('#arrow').show();
        }else{
            $('#arrow').hide();
        }

    });

    $(window).scroll(function(){
        $('.curtain_orange').each(function(){
            var imagePos = $(this).offset().top;

            var topOfWindow = $(window).scrollTop();
            var k = 950;
            if (imagePos < topOfWindow+k){
                $(this).addClass("animate__swing animate__delay-1s 2s");
                k = k+k;
            }
        });
    });
});