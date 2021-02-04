$(document).ready(function() {
	
  $('.multi-item-carousel').on('slide.bs.carousel', function (e) {
    let $e = $(e.relatedTarget),
        itemsPerSlide = 3,
        totalItems = $('.carousel-item', this).length,
        $itemsContainer = $('.carousel-inner', this),
        it = itemsPerSlide - (totalItems - $e.index());
    if (it > 0) {
      for (var i = 0; i < it; i++) {
        $('.carousel-item', this).eq(e.direction == "left" ? i : 0).
          // append slides to the end/beginning
          appendTo($itemsContainer);
      }
    }
  }); 
  $('#icon_btn').click(function(){
    var x = $("#myTopnav");
    if (x.attr("class") === "navbar topnav") {
      x.addClass(" responsive");

    } else {
      x.removeClass(" responsive");
    }
  });

  if($( window ).width() >= 991){
      $('#d1').addClass("dropdown-menu");
      $('#d2').addClass("dropdown-menu");
      $('#d3').addClass("dropdown-menu");
      $('#d4').addClass("dropdown-menu");
      $('#navbarDropdownMenuLink1').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink2').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink3').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink4').addClass("dropdown-toggle");
      $('ul').removeClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').removeClass('nav-main');
    }
    else{
      $('#navbarDropdownMenuLink1').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink2').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink3').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink4').removeClass("dropdown-toggle");
      $('#d1').removeClass("dropdown-menu");
      $('#d2').removeClass("dropdown-menu");
      $('#d3').removeClass("dropdown-menu");
      $('#d4').removeClass("dropdown-menu");
      $('ul').addClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').addClass('nav-main');
    }
  $(window).resize(function(){
    if($( window ).width() >= 991){
      $('#d1').addClass("dropdown-menu");
      $('#d2').addClass("dropdown-menu");
      $('#d3').addClass("dropdown-menu");
      $('#d4').addClass("dropdown-menu");
      $('#navbarDropdownMenuLink1').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink2').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink3').addClass("dropdown-toggle");
      $('#navbarDropdownMenuLink4').addClass("dropdown-toggle");
      $('ul').removeClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').removeClass('nav-main');
    }
    else{
      $('.nav-link').addClass('nav-main');
      $('#navbarDropdownMenuLink1').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink2').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink3').removeClass("dropdown-toggle");
      $('#navbarDropdownMenuLink4').removeClass("dropdown-toggle");
      $('#d1').removeClass("dropdown-menu");
      $('#d2').removeClass("dropdown-menu");
      $('#d3').removeClass("dropdown-menu");
      $('#d4').removeClass("dropdown-menu");
      $('ul').addClass("navbar-nav mr-auto mt-lg-0");
    }
  });
  $('.topnav .nav-item a').each(function() {
      if ( (window.location.pathname.indexOf( $(this).attr('href') ) ) > -1) {
        $(this).addClass('active-link');
      }
      if (this.href == window.location.href) {
        $(this).addClass('active-link');
      }
  });
});