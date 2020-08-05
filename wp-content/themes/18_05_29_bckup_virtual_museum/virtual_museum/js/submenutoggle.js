var classes = new Array();

if(document.getElementsByClassName("current") && document.getElementsByClassName("BigBoxImage")){
(function($) {


  var BeginningClass = document.getElementsByClassName("current")[0];
  var currentClassName = $(BeginningClass).attr('class').split(' ');
  classes[1] = currentClassName[1];
  ContentSwitch(classes);


}(jQuery));
}else{
  stop();
}

//-------------------------Click Event for show/hide PopUp-----------------------------------------//

//Check which Element got clicked
$('body').click(function(e){

var target = $(e.target);
var getDiv = $(target.closest('div'));


//remove active if other objects are active but not clicked
$('.active').not($(getDiv)).removeClass('active');

//Check if clicked Element is one of the instrument Icons
if (getDiv.hasClass('icon_table')){
//Check status of the instrument Icon (already active, show/hide)

  if(!getDiv.hasClass('active')){
    //if the status of the clicked element is not active
    //set status of clicked object to active
    $(getDiv).addClass('active');
  }
} //endif for icon_table
else if (getDiv.hasClass('BigBoxImage')) {
  $('.BigBoxImage').not($(getDiv)).removeClass('current');
  console.log(getDiv);

  $(getDiv).addClass('current');
}
  console.log(getDiv);


  if(getDiv.hasClass('BigBoxImage')){
    classes = $(getDiv).attr('class').split(' ');
}

ContentSwitch(classes);
});



//if the status of the clicked element is not active

//set status of clicked object to active
//check if any other object has class active

function ContentSwitch(classes){
  switch (classes[1]){
    case 'content1':
      $('#variableContentWrapper').not('.content1').removeClass('active');
      $('#variableContentWrapper .content1').addClass('active');
      break;
    case 'content2':
      $('#variableContentWrapper').not('.content2').removeClass('active');
      $('#variableContentWrapper .content2').addClass('active');
      break;
    case 'content3':
      $('#variableContentWrapper').not('.content3').removeClass('active');
      $('#variableContentWrapper .content3').addClass('active');
      break;
    case 'content4':
      $('#variableContentWrapper').not('.content4').removeClass('active');
      $('#variableContentWrapper .content4').addClass('active');
      break;
    case 'content5':
      $('#variableContentWrapper').not('.content5').removeClass('active');
      $('#variableContentWrapper .content5').addClass('active');
      break;
    case 'content6':
      $('#variableContentWrapper').not('.content6').removeClass('active');
      $('#variableContentWrapper .content6').addClass('active');
      break;
  }
}
