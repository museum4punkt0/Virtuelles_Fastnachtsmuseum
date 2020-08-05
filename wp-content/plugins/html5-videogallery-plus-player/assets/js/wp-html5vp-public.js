jQuery(document).ready(function($) {

	$( '.wp-html5vp-video-row' ).each(function( index ) {
		
		var popup_id   = $(this).attr('id');
		var popup_conf = $.parseJSON( $(this).find('.wp-html5vp-popup-conf').text());

		if( typeof(popup_id) != 'undefined' ) {
			jQuery('#'+popup_id+ ' .popup-youtube').magnificPopup({					 
				type: 'iframe',
				mainClass: 'mfp-fade wp-html5vp-mfp-zoom-in wp-html5vp-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,				
			});
			
			jQuery('#'+popup_id+ ' .popup-modal').magnificPopup({					 					 
				mainClass: 'mfp-fade wp-html5vp-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,
				callbacks: {
				  close: function(){
					wp_hvgp_refresh_html5_video();
				  }
			  },
			});
		}
	});
	
});

/* Function to pause HTML5 video */
function wp_hvgp_refresh_html5_video() {
	jQuery('.video-wrap .wp-hvgp-video-frame').each(function( index ) {
		if (!jQuery(this).get(0).paused) {
			jQuery(this).get(0).pause();
		}
	});
}