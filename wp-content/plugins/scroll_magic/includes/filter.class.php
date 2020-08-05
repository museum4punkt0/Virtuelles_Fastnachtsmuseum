<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_FILTER' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_FILTER Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_FILTER {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_filter( 'vc_shortcodes_css_class', array($this, 'filter'), 10, 3 );
		}

		public function init() {

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		function filter( $class_string = '', $tag = '', $atts = null ) {

			$prefix = BESTBUG_SCROLMAGIC_PREFIX;
			$shortcodes = array();
			if(bb_option($prefix . 'add_option') == 'no') {
				$shortcodes = array();
			} else if(bb_option($prefix . 'all_shortcodes') == 'yes') {
				$shortcodes = explode(",", bb_option('bbsm_cache_all_vcshortcodes'));
			} else {
				$shortcodes = explode(",", bb_option($prefix . 'shortcodes'));
			}
			
			if(!in_array(BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE, $shortcodes)) {
				array_push( $shortcodes, BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE);
			}
			if(!in_array(BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE, $shortcodes)) {
				array_push( $shortcodes, BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE);
			}
			if(!in_array(BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE, $shortcodes)) {
				array_push( $shortcodes, BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE);
			}
			
			if(!in_array($tag, $shortcodes )) {
				return $class_string;
			}
			
			if(!isset($atts['bbsm_scene'])) {
				return $class_string;
			}
			
			$scene = str_replace(","," ", $atts['bbsm_scene']);
			$class_string .= ' ' . $scene;
			return $class_string;
		}

    }
	
	new BESTBUG_SCROLLMAGIC_FILTER();
}

