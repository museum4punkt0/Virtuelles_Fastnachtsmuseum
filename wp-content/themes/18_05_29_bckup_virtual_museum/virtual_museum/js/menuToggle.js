
//-------------------------Click Event for show/hode TopDown menu -----------------------------------------//
    $('#burger').on('click', function(){
      console.log("click on burgerIcon");
      $(this).toggleClass('closeSub');
    //  $('#TopDownMenu').toggle(80);
      $( "#TopDownMenu" ).animate({
          opacity: 1,
          left: "0",
          height: "toggle"
        }, 800, function() {
  // Animation complete.
});
    });
    $("#TopDownMenu li").addClass('col-lg-3 col-md-6 grid-item');

    $(".menu .sub-menu li").removeClass('col-lg-3 col-md-6 grid-item');

    /*$('.menu').masonry({
      itemSelector : 'grid-item'
    });*/

    $('.closeText').on('click', function(){
      //console.log($(this).parent().find('.infoText'));
      //$(this).parent().find('.InfoText').toggleClass('closeBox');
    //  $('#TopDownMenu').toggle(80);
      $(this).parent().find('.InfoText').animate({
          opacity: 1,
          height: "toggle"
        }, 800, function() {
  // Animation complete.
  });
});
