$(function() {
	$('.owl-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    mouseDrag: true,
    touchDrag: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    navText: ['<img src="img/Vector 1.png" alt="left" />','<img src="img/Vector 2.png" alt="right" />'],
    startPosition: 0,
    responsive:{
        0:{
            items:1
        },
        768:{
            items:2
        },
        1000:{
            items:3
        }
    }
    });
});