<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_USE_OPTIONS' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_USE_OPTIONS Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_USE_OPTIONS {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		
		public function init(){
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			$group = esc_html('Scroll Magic', 'bestbug');

			$prefix = BESTBUG_SCROLMAGIC_PREFIX;
			$shortcodes = array();
			if(bb_option($prefix . 'add_option') == 'no') {
				$shortcodes = array();
			} else if(bb_option($prefix . 'all_shortcodes') == 'yes') {
				$shortcodes = explode(",", bb_option('bbsm_cache_all_vcshortcodes'));
			} else {
				$shortcodes = explode(",", bb_option($prefix . 'shortcodes'));
			}
			
			if(!in_array(BESTBUG_SCROLLMAGIC_SHORTCODE, $shortcodes)) {
				array_push( $shortcodes, BESTBUG_SCROLLMAGIC_SHORTCODE);
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
			
			$scenestmp = get_posts(array(
				'numberposts' => -1,
				'post_type'   => BESTBUG_SCROLLMAGIC_POSTTYPE,
				'orderby'     => 'title',
				'order'       => 'ASC',
			));

			$scenes = array();
			foreach ($scenestmp as $key => $scene) {
				$scenes[$scene->post_title . ' '] = $scene->post_name;
			}
			foreach ($shortcodes as $key => $shortcode) {
				$shortcode = trim($shortcode);
				vc_add_param( $shortcode, array(
					'type' => 'bb_toggle',
					'heading' => esc_html__('ScrollMagic mode', 'bestbug'),
					'param_name' => 'bb_sm_mode',
					'group' => $group,
				));
				
				vc_add_param( $shortcode, 	array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Scenes', 'tm-bestbug' ),
					'value'       => $scenes,
					'param_name'  => 'bbsm_scene',
					"dependency" => array('element' => "bb_sm_mode", 'value' => array('yes')),
					'group' => $group,
					'description' => esc_html__( 'You can add, edit Scene in Scene panel', 'bestbug' ),
				)); // end add param

			}
		}
    }
	
	new BESTBUG_SCROLLMAGIC_USE_OPTIONS();
}

