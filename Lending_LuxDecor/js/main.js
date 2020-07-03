$(function() {
	$('.projects-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots: true,
    navText: ['<img src="img/Vector 1.jpg" alt="left" />','<img src="img/Vector 2.jpg" alt="left" />'],
    startPosition: 1,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
	});
}); 