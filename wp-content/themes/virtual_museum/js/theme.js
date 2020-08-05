
var targetId;
var SplittID;

var AllCanvas = document.getElementsByClassName("ImageBox");
var AllFrontLayer = document.querySelectorAll(".FrontLayer");
var imgs = [];

window.scroll({
  top: 2500,
  left: 0,
  behavior: 'smooth'
});

// Scroll certain amounts from current position
window.scrollBy({
  top: 100, // could be negative value
  left: 0,
  behavior: 'smooth'
});



//Get all ImageBoxes and Images that are in the ImageBoxes
for (i = 0; i < AllCanvas.length; i++){
  //var ImageArray = [AllCanvas[i].id][imgs[i]];

  imgs[i] = $('#' + AllCanvas[i].id + ' img').map(function(){
                       return this;
                 }).get();
}




for (i = 0; i < AllFrontLayer.length; i++){
  var LayerIds = AllFrontLayer[i].id;
  var Reset;
  var Front = AllFrontLayer[i];
  var tr;

  console.log(AllFrontLayer[i]);

  AllFrontLayer[i].addEventListener("tiltChange", function (event) {
       targetId = event.target.id;
       SplittID = targetId.replace('front_','');
      Reset = false;
      var el = AllFrontLayer[SplittID-1];

      var st = window.getComputedStyle(el, null);

     tr = st.getPropertyValue("-webkit-transform") ||
          st.getPropertyValue("-moz-transform") ||
          st.getPropertyValue("-ms-transform") ||
          st.getPropertyValue("-o-transform") ||
          st.getPropertyValue("transform") ||
          "Either no transform set, or browser doesn't do getComputedStyle";

          $(imgs[SplittID-1][0]).css({
             'transform':'' + tr + ''
           });

           console.log(SplittID);
  });



  AllFrontLayer[i].addEventListener("mouseleave", function (event){
    setTimeout(function(){
         //your code
   if (Reset == false){
    if ($(imgs[SplittID-1][0]).css("transform") != 'none'){

      $(imgs[SplittID-1][0]).css({
        'transform':'none'
      });
        Reset = true;
      }
    }
      console.log(Reset);
    },30);
  });
}


/*
  window.onload = function() {
    BackgroundColorChange();
  }


  //Function for Background- and Text-Color change through average Image-Color
  function BackgroundColorChange(){
    var Images = document.getElementsByClassName('GetColorImage');
    var Sections = document.getElementsByClassName('ContentContainer');
    var TextBoxes = document.getElementsByClassName('ContentTextBoxes');

    var colorThief = new ColorThief();

    for (var i = 0; i < Images.length; i++){
      var SectionColors = colorThief.getColor(Images[i]);
      var SectionsIds = Sections[i].id;
      var TextIds = TextBoxes[i].id;
      var HSLColors = rgb2hsv(SectionColors[0], SectionColors[1], SectionColors[2]);
      var rgb = [
        SectionColors[0],
        SectionColors[1],
        SectionColors[2]
      ];
      var TextColor;

      var GetContrastText = setContrast(rgb);
      var GoodContrast = GetContrastText.color;

      if (GoodContrast == 'white'){
        TextColor = "#f7f7f7";
      }else{
        TextColor = "#0f0f0f";
      };

      var hsl = [
        HSLColors.h,
        HSLColors.s / 100 * 60,
        HSLColors.v / 100 * 130,
      ];


      //console.log (" CurrentColors: "+ SectionColors);

      $('#' + SectionsIds).css(
        {"background-color":"hsl(" + hsl[0] + ", " + hsl[1] + "%, " + hsl[2] + "%)"}
      );


      $('#' + TextIds).css(
        {"color":TextColor}
      );
      //console.log(GoodContrast);
    }
}

//Gives Contrast Color for the Text
function setContrast(rgb) {

  var o = Math.round(((parseInt(rgb[0]) * 299) +
                      (parseInt(rgb[1]) * 587) +
                      (parseInt(rgb[2]) * 114)) / 1000);
  var fore = (o > 125) ? 'black' : 'white';
  var back = 'rgb(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ')';
  return{
  color : fore
  };
}


function rgb2hsv () {
    var rr, gg, bb,
        r = arguments[0] / 255,
        g = arguments[1] / 255,
        b = arguments[2] / 255,
        h, s,
        v = Math.max(r, g, b),
        diff = v - Math.min(r, g, b),
        diffc = function(c){
            return (v - c) / 6 / diff + 1 / 2;
        };

    if (diff == 0) {
        h = s = 0;
    } else {
        s = diff / v;
        rr = diffc(r);
        gg = diffc(g);
        bb = diffc(b);

        if (r === v) {
            h = bb - gg;
        }else if (g === v) {
            h = (1 / 3) + rr - bb;
        }else if (b === v) {
            h = (2 / 3) + gg - rr;
        }
        if (h < 0) {
            h += 1;
        }else if (h > 1) {
            h -= 1;
        }
    }
    return {
        h: Math.round(h * 360),
        s: Math.round(s * 100),
        v: Math.round(v * 100)
    };
}
*/

//End Background- and Text-Color change
(function($) {
    var wh = window.innerHeight,
        $header = $('#TopMenu');


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

/*var canvastwo = document.getElementById('canvastwo'),
    ctx = canvastwo.getContext('2d'),
    loaded = 0,
    canvasW = canvastwo.width,
    canvasH = canvastwo.height,
    canvasRect = canvastwo.getBoundingClientRect(),
    winCenter = window.innerHeight / 2,
    layerstwo = [
      {url: "../imgs/bild2_layer/saulerechts.png", offset: 0, x:0, y:0},
      {url: "../imgs/bild2_layer/saulelinks.png", offset: -0.04, x:0, y:0},
      {url: "../imgs/bild2_layer/tree.png", offset: 0.02, x:0, y:0},
      {url: "../imgs/bild2_layer/leafs.png", offset: -0.08, x:0, y:0},
      {url: "../imgs/bild2_layer/Narr.png", offset: -0.03, x:0, y:0},
      {url: "../imgs/bild2_layer/harp.png", offset: -0.03, x:0, y:0},
      {url: "../imgs/bild2_layer/kingDavid.png", offset: -0.03, x:0, y:0},
      {url: "../imgs/bild2_layer/bg_layer.png", offset: -0.03, x:0, y:0},
    ];


    for (var i = 0; i < layerstwo.length; i++) {
      var img = new Image();
      img.src = layerstwo[i].url;
      layerstwo[i].img = img;
      img.onload = handle_img_load;
    }

    window.addEventListener('scroll', handle_scroll);

    function handle_scroll() {
      canvasRect = canvastwo.getBoundingClientRect();
    }

    function handle_img_load() {
      loaded += 1;

      if (loaded == layerstwo.length){
        animate();
      }
}




/*function animate(){
  ctx.clearRect(0,0,canvasW, canvasH);

  var elCenter = canvasRect.top + (canvasH / 2);
  var distFromCenter = elCenter - winCenter;

  for (i = layerstwo.length - 1; i > -1; i -= 1){
    var _y = layerstwo[i].y + (distFromCenter * layerstwo[i].offset);
    ctx.drawImage(layerstwo[i].img, layerstwo[i].x, _y, img.width, img.height,  0, 0, canvastwo.width, canvastwo.height);
  }
  requestAnimationFrame(animate);
}*/


//function ParallaxCanvas(){

/*  ImageLayer = [
    img1 =
      [
        {url: "../imgs/layer0.png", offset: 0, x:0, y:0},
        {url: "../imgs/layer4.png", offset: -0.06, x:0, y:0},
        {url: "../imgs/layer3.png", offset: 0.05, x:0, y:0},
        {url: "../imgs/layer2.png", offset: -0.1, x:0, y:0},
        {url: "../imgs/layer1.png", offset: -0.05, x:0, y:0},
      ],

    img2 =
        [
          {url: "../imgs/bild2_layer/frame.png", offset: 0, x:0, y:0},
          {url: "../imgs/bild2_layer/saulerechts.png", offset: 0, x:0, y:0},
          {url: "../imgs/bild2_layer/saulelinks.png", offset: 0, x:0, y:0},
          {url: "../imgs/bild2_layer/Narr.png", offset: 0, x:0, y:0},
          {url: "../imgs/bild2_layer/kingDavid.png", offset: 0, x:0, y:0},
          {url: "../imgs/bild2_layer/leafs.png", offset: -0.06, x:0, y:0},
          {url: "../imgs/bild2_layer/tree.png", offset: 0.05, x:0, y:0},
          {url: "../imgs/bild2_layer/harp.png", offset: -0.1, x:0, y:0},
          {url: "../imgs/bild2_layer/bg_layer.png", offset: -0.05, x:0, y:0},
        ],

    img3 =
        [
          {url: "../imgs/fallbackMorisk.jpg", offset: 0, x:0, y:0},
        ],

    img4 =
        [
          {url: "../imgs/fallbackBriegl.png", offset: 0, x:0, y:0},
        ]
      ];


  var AllCanvas = document.getElementsByClassName("ImageCanvas");
  var CurrentCanvas;

  var k = 0;



  for (var i=0; i < AllCanvas.length; i++){

    var canvasIds = AllCanvas[i].id;
        CurrentCanvas = $('#' + canvasIds).get(0);
        ctx = CurrentCanvas.getContext('2d');
    var loaded = 0;
    var canvasW = CurrentCanvas.width;
    var canvasH = CurrentCanvas.height;
    var canvasRect = CurrentCanvas.getBoundingClientRect();
    var winCenter = window.innerHeight / 2;

    for (var j = 0; j < ImageLayer[i].length; j++) {
      var img = new Image();
      img.src = ImageLayer[i][j].url;
      ImageLayer[i][j].img = img;
      img.onload = handle_img_load(ImageLayer[i]);
    }

  window.addEventListener('scroll', handle_scroll);

      function handle_scroll() {
        canvasRect = CurrentCanvas.getBoundingClientRect();
      //  k = 0;
      }

      function handle_img_load() {
        loaded += 1;
        if (loaded == ImageLayer[i].length){
          animate();

        }
      }

      function animate(){
        if (k < ImageLayer.length){
          ctx.clearRect(0,0,canvasW, canvasH);
          var elCenter = canvasRect.top + (canvasH / 2);
          var distFromCenter = elCenter - winCenter;
          var Images = ImageLayer[k];

          for (l = Images.length - 1; l > -1; l -= 1) {
            var _y = Images[l].y + (distFromCenter * Images[l].offset);
            ctx.drawImage(Images[l].img, Images[l].x, _y, img.width, img.height,  0, 0, CurrentCanvas.width, CurrentCanvas.height);
            //console.log("where "+ canvasIds + " what: " + " IMG " + Images[l].img + " IMG-X " + Images[l].x + " Y " + _y + " img.width " + img.width + " imageheight " + img.height + '0' + '0' + " CurrCanvasWidth " + CurrentCanvas.width + " CurrCanvasheight " + CurrentCanvas.height);
            console.log ("newy: " + _y);
          }

        k++;
      }
        requestAnimationFrame(animate);
        console.log("AnimationCalled")
    }
  }*/
//}
/*

var canvas = document.getElementById('canvasone'),
    ctx = canvas.getContext('2d'),
    loaded = 0,
    canvasW = canvas.width,
    canvasH = canvas.height,
    canvasRect = canvas.getBoundingClientRect(),
    winCenter = window.innerHeight / 2,
    layersone =


    for (var i = 0; i < layersone.length; i++) {
      var img = new Image();
      img.src = layersone[i].url;
      layersone[i].img = img;
      img.onload = handle_img_load;
    }

    window.addEventListener('scroll', handle_scroll);

    function handle_scroll() {
      canvasRect = canvas.getBoundingClientRect();
    }

    function handle_img_load() {
      loaded += 1;

      if (loaded == layersone.length){
        animate();
      }
}

function animate(){
  ctx.clearRect(0,0,canvasW, canvasH);

  var elCenter = canvasRect.top + (canvasH / 2);
  var distFromCenter = elCenter - winCenter;

  for (i = layersone.length - 1; i > -1; i -= 1){
    var _y = layersone[i].y + (distFromCenter * layersone[i].offset);
    ctx.drawImage(layersone[i].img, layersone[i].x, _y, img.width, img.height,  0, 0, canvas.width, canvas.height);
  }
  requestAnimationFrame(animate);
}
*/
