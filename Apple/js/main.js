$(document).ready(function() {
  //nav
	$('.navbar-toggler').click(function(){
    let x = $('#navbarSupportedContent');
    if(x.attr("class") === 'collapse navbar-collapse'){
      $('.collapse').addClass(' show');
    }else{
      $('.collapse').removeClass(' show');
    }
  });

  //search in nav
   $(".search_img").click(function(){
        $(".wrap, .input").toggleClass("active");
        $(".search_img").toggleClass("act");
        $("input[type='text']").focus();
      });

  $('#search_btn').click(function(){
    let x = $('#search_input');
    if(x.attr("class") === 'search'){
      $('.search').addClass('search_ok');
      $('.search').css({"opacity":"100%"});
    }else{
      $('.search').removeClass('search_ok');
      $('.search').css({"opacity":"0%"});
    }
  });

  
  //nav bar 
  $('#icon_btn').click(function(){
    var x = $("#myTopnav");
    if (x.attr("class") === "navbar topnav") {
      x.addClass(" responsive");

    } else {
      x.removeClass(" responsive");
    }
  });

  var item_comp = $('.item_to_compare');
  //for resizing fields of compariosoned items
  if(item_comp.length > 2 && $( window ).width() < 500){
      item_comp.css({"flex": "0 1 50%"});
  }else if(item_comp.length > 2 && $( window ).width() < 650){
      item_comp.css({"flex": "0 1 33.33%"});
  }else{
    if(item_comp.length >= 4 ){
          item_comp.css({"flex": "0 1 25%"});
      }else if(item_comp.length == 3){
          item_comp.css({"flex": "0 1 33.333%"});
      }else if(item_comp.length <= 2){
          item_comp.css({"flex": "0 1 50%"});
      }
  }
        
  //resizing functions for nav and etc
  if($( window ).width() >= 991){
    $("#filter").removeClass("collapse");
  }else{
    $("#filter").addClass("collapse");
  }
  if($( window ).width() >= 767){
      $('#dropdown_else').addClass("dropdown-menu");
      
      $('#else').addClass("dropdown-toggle");
      $('#menu').removeClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').removeClass('nav-main');
    }
    else{
      $('#else').removeClass("dropdown-toggle");
      $('#dropdown_else').removeClass("dropdown-menu");
      $('#menu').addClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').addClass('nav-main');
    }
  $(window).resize(function(){
    if(item_comp.length > 2 && $( window ).width() < 500){
      item_comp.css({"flex": "0 1 50%"});
    }else if(item_comp.length > 2 && $( window ).width() < 650){
        item_comp.css({"flex": "0 1 33.33%"});
    }else{
      if(item_comp.length >= 4 ){
            item_comp.css({"flex": "0 1 25%"});
        }else if(item_comp.length == 3){
            item_comp.css({"flex": "0 1 33.333%"});
        }else if(item_comp.length <= 2){
            item_comp.css({"flex": "0 1 50%"});
        }
    }
    if($( window ).width() >= 991){
      $("#filter").removeClass("collapse");
    }else{
      $("#filter").addClass("collapse");
    }
    if($( window ).width() >= 767){
      $('#dropdown_else').addClass("dropdown-menu");
      $('#else').addClass("dropdown-toggle");
      $('#menu').removeClass("navbar-nav mr-auto mt-lg-0");
      $('.nav-link').removeClass('nav-main');
    }
    else{
      if($('#dropdown_else').attr('class') === 'dropdown-menu'){
        $('#dropdown_else').removeClass('me-auto mb-lg-0 mr-auto mt-lg-0');
      }
      $('.nav-link').addClass('nav-main');
      $('#else').removeClass("dropdown-toggle");
      $('#dropdown_else').removeClass("dropdown-menu");
      $('#menu').addClass("navbar-nav mr-auto mt-lg-0");
    }
    if(item_comp.length > 2 && $( window ).width() < 500){
      item_comp.css({"flex": "0 1 50%"});
    }
  });

  //for adding class "active" to links in nav
  $('.topnav .nav-item a').each(function() {
      if ( (window.location.pathname.indexOf( $(this).attr('href') ) ) > -1) {
        $(this).addClass('active-link');
      }
      if (this.href == window.location.href) {
        $(this).addClass('active-link');
      }
  });


  //carousel for popular product and history of products
  $("#owl-demo").owlCarousel({ 
    navigation: true,
    navigationText: ["<img src='imgs/icons/arrow_left_b.svg' alt='arrow_left'>","<img src='imgs/icons/arrow_right_b.svg' alt'arrow_right'>"], //../imgs/icons/arrow_left.svg
    slideSpeed: 300,
    pagination: true,
    autoPlay : false,
    goToFirst : true,
    goToFirstSpeed : 1000,
    paginationSpeed: 800,
    items: 4,
    itemsDesktop: [1199, 4],
    itemsDesktopSmall:[991, 3],
    itemsTablet: [767, 2],
    itemsMobile: [478, 1]
  });


  //
  var thumbs = document.querySelectorAll('#thumbs > a');
  var big = document.getElementById('big');
  for (var i = 0; i < thumbs.length; i++) {
      thumbs[i].addEventListener('click', function(e) {
          e.preventDefault();
          big.src = this.href;
      });
  }

  //characteristics hide/show
  $("#characteristics table tr:gt(4)").hide();
  $("#hide_characteristics").click(function(){
    $("#characteristics table tr:gt(4)").slideToggle(0);
    this.textContent = this.textContent === 'Скрыть' ? 'Подробнее' : 'Скрыть';
  });

  //star rating
  $("input[type='radio']").click(function(){ 
    var sim = $("input[type='radio']:checked").val();
    if (sim<3) { 
      $('.myratings').css('color','red'); 
      $(".myratings").text(sim); 
    }else{ 
      $('.myratings').css('color','green'); 
      $(".myratings").text(sim); } 
  });

 //password view
  $('body').on('click', '.password-control', function(){
    if ($('#password-input').attr('type') == 'password'){
      $(this).addClass('view');
      $('#password-input').attr('type', 'text');
    } else {
      $(this).removeClass('view');
      $('#password-input').attr('type', 'password');
    }
    return false;
  });


    // var k = $("#bag_page input[type='text']").length;
    // $("#bag_page input[type='button']").keydown(function(event) {
    //   $(".plus").click(function(){
    //       var newValuePlus = parseInt($("#textnumber").val()) + 1;
    //       if ( newValuePlus > 100 ) return;
    //       console.log(i)
    //       $("#textnumber").val(newValuePlus);
    //     });
    //   });
    // console.log(k);
    // for(var i=0; i<k; i++){
      
      
      
    //   $("#minus"+i).click(function(){
    //       var newValueMinus = parseInt($("#textnumber"+i).val()) - 1;
    //       if ( newValueMinus < 0 ) return;
    //       console.log(i);
    //       $("#textnumber"+i).val(newValueMinus);          
    //   }); 
    // }
      $('.minus').click(function () {
          var $input = $(this).parent().find("input[type='text']");
          var count = parseInt($input.val()) - 1;
          count = count < 1 ? 1 : count;
          $input.val(count);
          $input.change();
          return false;
      });
      $('.plus').click(function () {
          var $input = $(this).parent().find("input[type='text']");
          $input.val(parseInt($input.val()) + 1);
          $input.change();
          return false;
      });

});