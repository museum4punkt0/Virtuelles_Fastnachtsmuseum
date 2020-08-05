//COnvert all svg in img tags to inline svg´s

/*
    $(function(){
        activate('img[src*=".svg"]');

        function activate(string){
            jQuery(string).each(function(){
                var $img = jQuery(this);
                var imgID = $img.attr('id');
                var imgClass = $img.attr('class');
                var imgURL = $img.attr('src');

                jQuery.get(imgURL, function(data) {
                    // Get the SVG tag, ignore the rest
                    var $svg = jQuery(data).find('svg');

                    // Add replaced image's ID to the new SVG
                    if(typeof imgID !== 'undefined') {
                        $svg = $svg.attr('id', imgID);
                    }
                    // Add replaced image's classes to the new SVG
                    if(typeof imgClass !== 'undefined') {
                        $svg = $svg.attr('class', imgClass+' replaced-svg');
                    }

                    // Remove any invalid XML tags as per http://validator.w3.org
                    $svg = $svg.removeAttr('xmlns:a');

                    // Replace image with new SVG
                    $img.replaceWith($svg);

                }, 'xml');
            });
        }


    });
*/

(function($) {
    var wh = window.innerHeight,
        $header = $('.headerWrapper');


    // Keep adding code here
    // init
    var ctrl = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 'onLeave'
        }
    });

    // Create scene
    $("section").each(function() {
      console.log(this.id);

      if($(this).attr('id') == 'Thementitel'){
        new ScrollMagic.Scene({
            triggerElement: this,

        })
        .setPin(this, {pushFollowers:false})
        .addTo(ctrl);
      }

      if(!$(this).hasClass('Priest') || !$(this).attr('id') == 'Thementitel'){
        var tween = TweenMax.fromTo(this, 0.1,
          {css:{'background-position': "0% 0%"}},
          {css:{'background-position': "0% 100%"}},);
        new ScrollMagic.Scene({
            triggerElement: this,
            triggerHook: 'onEnter',
                      //offset: 200,
            duration: '600%'
        })
        .setPin(this)
        .setTween(tween)
        .addIndicators({
          name: 'trigger of each',
          indent: 520,
          colorStart: 'white',
          colorEnd: 'black',
          colorTrigger: 'red',
        })
        .addTo(ctrl);
}



else if($(this).hasClass('Priest')){
  console.log("priest is scrolling");
  var light = TweenMax.fromTo('#lightbeamOverlay', 0.1,
    {css:{
      'opacity' : '0',
      'background-position': "0% 0%"}},
    {css:{
      'display' : 'block',
      'opacity' : '1',
      'background-position': "0% 100%"}},);
  new ScrollMagic.Scene({
      triggerElement: this,
      triggerHook: 'onEnter',

      //offset: 200,
      duration: '100%'
  })
  .setPin(this, {pushFollowers: true})
  .addTo(ctrl)
  .setTween(light)
}
else if($(this).attr('id') == 'Thementitel'){
  console.log("Thementitel is scrolling");
}


var height = window.height;

});

})(jQuery);
//init controller for Scrollmagic
var controller = new ScrollMagic.Controller();

//loop loop loop loop through all elements with a class fade-in
$('.fade-in').each(function(){

  //build a tween
  var tween = TweenMax.from($(this), 0.3, {autoAlpha: 0, scale: 0.5, y: '+=120', ease:Linear.easeNone});

  // build a scene
  var scene = new ScrollMagic.Scene({
    triggerElement:  this
  })
  .setTween(tween)
  .addTo(controller);
});
