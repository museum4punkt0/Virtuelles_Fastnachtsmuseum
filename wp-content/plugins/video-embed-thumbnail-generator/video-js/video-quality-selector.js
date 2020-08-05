/**
 * Video.js Resolution Selector
 *
 * This plugin for Video.js adds a resolution selector option
 * to the toolbar. Usage:
 *
 * <video>
 * 	<source data-res="480" src="..." />
 * 	<source data-res="240" src="..." />
 * </video>
 *
 * FIXME with hacks by User:TheDJ to make this video-js 5.0 compatible
 */

function kgvid_load_video_quality_selector() {

if ( videojs.VERSION.split('.')[0] < 5 ) {

	return;

}


/***********************************************************************************
 * Define some helper functions
 ***********************************************************************************/
var methods = {

	/**
	 * In a future version, this can be made more intelligent,
	 * but for now, we'll just add a "p" at the end if we are passed
	 * numbers.
	 *
	 * @param	(string)	res	The resolution to make a label for
	 *
	 * @returns	(string)	The label text string
	 */
	res_label : function( res ) {

		return ( /^\d+$/.test( res ) ) ? res + 'p' : res;
	}
};

/***********************************************************************************
 * Setup our resolution menu items
 ***********************************************************************************/
videojs.ResolutionMenuItem = videojs.extend( videojs.getComponent( 'MenuItem' ), {

	// Call variable to prevent the resolution change from being called twice
	call_count : 0,

	/** @constructor */
	constructor : function( player, options ){

		var touchstart = false;

		// Modify options for parent MenuItem class's init.
		options.label = methods.res_label( options.res );
		options.selected = ( options.res.toString() === player.getCurrentRes().toString() );

		// Call the parent constructor
		videojs.getComponent( 'MenuItem' ).call( this, player, options );

		// Store the resolution as a property
		this.resolution = options.res;

		// Register our click and tap handlers
		this.on( ['click', 'tap'], this.onClick );

		// Toggle the selected class whenever the resolution changes
		player.on( 'changeRes', videojs.bind( this, function() {

			if ( this.resolution == player.getCurrentRes() ) {

				this.selected( true );

			} else {

				this.selected( false );
			}

			// Reset the call count
			this.call_count = 0;
		}));
	}
});

// Handle clicks on the menu items
videojs.ResolutionMenuItem.prototype.onClick = function() {

	// Check if this has already been called
	if ( this.call_count > 0 ) { return; }

	// Call the player.changeRes method
	this.player().changeRes( this.resolution );

	// Increment the call counter
	this.call_count++;
};

/***********************************************************************************
 * Setup our resolution menu title item
 ***********************************************************************************/
videojs.ResolutionTitleMenuItem = videojs.extend( videojs.getComponent( 'MenuItem' ), {

	constructor : function( player, options ) {

		// Call the parent constructor
		videojs.getComponent( 'MenuItem' ).call( this, player, options );

		// No click handler for the menu title
		this.off( 'click' );
	}
});

/***********************************************************************************
 * Define our resolution selector button
 ***********************************************************************************/
videojs.ResolutionSelector = videojs.extend( videojs.getComponent( 'MenuButton' ), {

	/** @constructor */
	constructor : function( player, options ) {

		// Add our list of available resolutions to the player object
		player.availableRes = options.available_res;

		// Call the parent constructor
		videojs.getComponent( 'MenuButton' ).call( this, player, options );

	}
});

// Set class for resolution selector button
videojs.ResolutionSelector.prototype.buildCSSClass = function buildCSSClass() {
	return 'vjs-res-button ' + videojs.getComponent( 'MenuButton' ).prototype.buildCSSClass.call( this );
};

// Create a menu item for each available resolution
videojs.ResolutionSelector.prototype.createItems = function() {

	var player = this.player(),
		items = [],
		current_res;

	// Add the menu title item
	items.push( new videojs.ResolutionTitleMenuItem( player, {

		el : videojs.getComponent( 'Component' ).prototype.createEl( 'li', {

			className	: 'vjs-menu-title vjs-res-menu-title',
			innerHTML	: kgvidL10n_frontend.quality
		})
	}));

	// Add an item for each available resolution
	for ( current_res in player.availableRes ) {

		// Don't add an item for the length attribute
		if ( 'length' == current_res ) { continue; }

		items.push( new videojs.ResolutionMenuItem( player, {
			res : current_res,
			'selectable' : true
		}));
	}

	// Sort the available resolutions in descending order
	items.sort(function( a, b ) {

		if ( typeof a.resolution == 'undefined' ) {

			return -1;

		} else {

			return parseInt( b.resolution ) - parseInt( a.resolution );
		}
	});

	return items;
};

/***********************************************************************************
 * Register the plugin with videojs, main plugin function
 ***********************************************************************************/
videojs.plugin( 'resolutionSelector', function( options ) {

	// Only enable the plugin on HTML5 videos
	if ( ! this.el().firstChild.canPlayType  ) { return; }

	/*******************************************************************
	 * Setup variables, parse settings
	 *******************************************************************/
	var player = this,
		sources	= this.options_.sources,
		i = sources.length,
		j,
		found_type,

		// Override default options with those provided
		settings = videojs.mergeOptions({

			default_res	: '',		// (string)	The resolution that should be selected by default ( '480' or  '480,1080,240' )
			force_types	: false		// (array)	List of media types. If passed, we need to have source for each type in each resolution or that resolution will not be an option

		}, options || {} ),

		available_res = { length : 0 },
		current_res,
		resolutionSelector,

		// Split default resolutions if set and valid, otherwise default to an empty array
		default_resolutions = ( settings.default_res && typeof settings.default_res == 'string' ) ? settings.default_res.split( ',' ) : [];

	// Get all of the available resoloutions
	while ( i > 0 ) {

		i--;

		// Skip sources that don't have data-res attributes
		if ( ! sources[i]['data-res'] ) { continue; }

		current_res = sources[i]['data-res'];

		if ( typeof available_res[current_res] !== 'object' ) {

			available_res[current_res] = [];
			available_res.length++;
		}

		available_res[current_res].push( sources[i] );
	}

	// Check for forced types
	if ( settings.force_types ) {

		// Loop through all available resoultions
		for ( current_res in available_res ) {

			// Don't count the length property as a resolution
			if ( 'length' == current_res ) { continue; }

			i = settings.force_types.length;
			found_types = 0;

			// Loop through all required types
			while ( i > 0 ) {

				i--;

				j = available_res[current_res].length;

				// Loop through all available sources in current resolution
				while ( j > 0 ) {

					j--;

					// Check if the current source matches the current type we're checking
					if ( settings.force_types[i] === available_res[current_res][j].type ) {

						found_types++;
						break;
					}
				}
			}

			// If we didn't find sources for all of the required types in the current res, remove it
			if ( found_types < settings.force_types.length ) {

				delete available_res[current_res];
				available_res.length--;
			}
		}
	}

	// Make sure we have at least 2 available resolutions before we add the button
	if ( available_res.length < 2 ) { return; }

	/*******************************************************************
	 * Add methods to player object
	 *******************************************************************/

	// Make sure we have player.localize() if it's not defined by Video.js
	if ( typeof player.localize !== 'function' ) {

		player.localize = function( string ) {

			return string;
		};
	}

	// Helper function to get the current resolution
	player.getCurrentRes = function() {

		if ( typeof player.currentRes !== 'undefined' ) {

			return player.currentRes;

		} else {

			try {

				return res = sources[0]['data-res'];

			} catch(e) {

				return '';
			}
		}
	};

	// Define the change res method
	player.changeRes = function( target_resolution ) {

		var video_el = player.el().firstChild,
			is_paused = player.paused(),
			is_autoplay = player.autoplay(),
			current_time = player.currentTime(),
			button_nodes,
			button_node_count;

		// Do nothing if we aren't changing resolutions or if the resolution isn't defined
		if ( player.getCurrentRes() == target_resolution
			|| ! player.availableRes
			|| ! player.availableRes[target_resolution] ) { return; }

		// Make sure the loadedmetadata event will fire
		if ( 'none' == video_el.preload ) { video_el.preload = 'metadata'; }

		if ( is_autoplay ) { player.autoplay(false); }

		if ( current_time != 0 ) {

			player.pause();
			var real_aspect_ratio = Math.round(video_el.videoHeight/video_el.videoWidth*1000)/1000;
			var thumbnail_width = player.height() / real_aspect_ratio;
			var x_axis = (player.width() - thumbnail_width) / 2;
			var canvas = document.createElement("canvas");
			canvas.className = 'kgvid_temp_thumb';
			canvas.width = player.width();
			canvas.height = player.height();
			var context = canvas.getContext('2d');
			context.fillRect(0, 0, player.width(), player.height());
			context.drawImage(video_el, x_axis, 0, thumbnail_width, player.height());
			jQuery(video_el).parent().append(canvas);

			player.bigPlayButton.hide();

		}

		// Change the source and make sure we don't start the video over
		player.src( player.availableRes[target_resolution] )
			.one( 'loadedmetadata', function() {

				if ( current_time != 0 ) {

					player.currentTime( current_time );
					player.pause();

					// If the video was paused, don't show the poster image again
					player.addClass( 'vjs-has-started' );

					if ( ! is_paused ) { player.play(); }

					if ( is_autoplay ) { player.autoplay(true); }

				}

			})
			.one( 'seeked', function() {
				if ( current_time != 0 ) {

					jQuery(canvas).remove();

				}
			});

		// Save the newly selected resolution in our player options property
		player.currentRes = target_resolution;

		// Make sure the button has been added to the control bar
		if ( player.getChild( 'controlBar' ).getChild( 'resolutionSelector' )  ) {

			button_nodes = player.getChild( 'controlBar' ).getChild( 'resolutionSelector' ).el().firstChild.children;
			button_node_count = button_nodes.length;

			// Update the button text
			while ( button_node_count > 0 ) {

				button_node_count--;

				if ( 'vjs-control-text' == button_nodes[button_node_count].className ) {

					button_nodes[button_node_count].innerHTML = methods.res_label( target_resolution );
					break;
				}
			}
		}

		// Update the classes to reflect the currently selected resolution
		player.trigger( 'changeRes' );
	};

	/*******************************************************************
	 * Add the resolution selector button
	 *******************************************************************/

	// Get the starting resolution
	current_res = player.getCurrentRes();

	if ( current_res ) { current_res = methods.res_label( current_res ); }

	// Add the resolution selector button
	resolutionSelector = new videojs.ResolutionSelector( player, {
		available_res	: available_res
	});

	// Add the button to the control bar object and the DOM
	this.on( 'ready' , function() {
		player.controlBar.addChild( resolutionSelector );
		player.controlBar.el().insertBefore(jQuery(player.controlBar.el()).find('.vjs-res-button')[0], player.controlBar.customControlSpacer.el());

		// Loop through the choosen default resolutions if there were any
		for ( i = 0; i < default_resolutions.length; i++ ) {

			// Set the video to start out with the first available default res
			if ( available_res[default_resolutions[i]] ) {
				player.changeRes(default_resolutions[i]);
				break;
			}
		}

	} );
});

}

kgvid_load_video_quality_selector();
