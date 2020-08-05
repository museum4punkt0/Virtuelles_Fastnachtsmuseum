// adapted from: http://www.sitepoint.com/scroll-based-animations-jquery-css3/

var ToggleSound = document.getElementById("soundBox");
var State = 1;
$('#soundBox').on('click', function() {

var On = document.getElementById("soundBox").children[0];
var Off = document.getElementById("soundBox").children[1];


if (On.style.display === "none") {
		On.style.display = "block";
		Off.style.display =	"none";
		State = 1;
		 muteAllSound();
	}

else {
		On.style.display = "none";
		Off.style.display =	"block";
		State = 0;
		 muteAllSound();
	}
	console.log(State);
	});

console.clear();

var $animation_elements = $('.audio');
var $window = $(window);

$window.on('scroll resize', check_if_in_view);

$window.trigger('scroll');

$(document).ready(function() {
	muteAllSound();
});




function check_if_in_view() {
	var window_height = $window.height();
	var window_top_position = $window.scrollTop();
	var window_bottom_position = (window_top_position + window_height);

	$animation_elements.each( function() {
		var $element = $(this);
		var element_height = $element.outerHeight();
		var element_top_position = $element.offset().top;
		var element_bottom_position = (element_top_position + element_height);

		//check to see if this current container is within viewport
		if ((element_bottom_position >= window_top_position) &&
			(element_top_position <= window_bottom_position)) {

			$element.addClass('in-view');

			$audio = $(this).find("audio");
			audio = $audio.get(0);
			if ( !$audio.is(":animated") && audio.paused ) {
				audio.volume = 0;
				$audio.animate({volume:1}, 2000);
				audio.play();
			}



		} else {
			$element.removeClass('in-view');
			$audio = $(this).find("audio");
			audio = $audio.get(0);
			if ( !$audio.is(":animated") && !audio.paused ) {
				$audio.animate({volume:0}, 2000, function() {
					this.pause();
					});
				}
			}
		});
}

var AllAudios= document.getElementsByClassName('audio');

function muteAllSound(){
if (State === 1){
	console.log("An");
	for (var i = 0; i < AllAudios.length; ++i) {
		var item = AllAudios[i].children[0];
		console.log(item);
		item.muted = false;
	}
	$window.on('scroll resize', check_if_in_view);
}else{
		console.log("Aus");
		for (var i = 0; i < AllAudios.length; ++i) {
			var item = AllAudios[i].children[0];
			item.muted = true;
		}
	}
}
