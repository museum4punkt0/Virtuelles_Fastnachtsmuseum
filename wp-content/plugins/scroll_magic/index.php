<?php
/*
Plugin Name: Scroll Magic
Description: Scroll Magic - Scrolling animation builder.
Author: BestBug
Version: 3.3
Author URI: http://lamblue.com/scroll-magic
Text Domain: bestbug
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'BESTBUG_SM_URL' ) or define('BESTBUG_SM_URL', plugins_url( '/', __FILE__ )) ;
defined( 'BESTBUG_SM_PATH' ) or define('BESTBUG_SM_PATH', basename( dirname( __FILE__ ))) ;
defined( 'BESTBUG_SM_TEXTDOMAIN' ) or define('BESTBUG_SM_TEXTDOMAIN', plugins_url( '/', __FILE__ )) ;

defined( 'BESTBUG_SCROLLMAGIC_SHORTCODE' ) or define('BESTBUG_SCROLLMAGIC_SHORTCODE', 'scrollmagic') ;
defined( 'BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE' ) or define('BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE', 'scrollmagic_sequence') ;
defined( 'BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE' ) or define('BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE', 'scrollmagic_imagegroup') ;
defined( 'BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE' ) or define('BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE', 'scrollmagic_image') ;
defined( 'BESTBUG_SCROLLMAGIC_EMPTY_SPACE_SHORTCODE' ) or define('BESTBUG_SCROLLMAGIC_EMPTY_SPACE_SHORTCODE', 'scrollmagic_spacing') ;

// Category
defined( 'BESTBUG_SM_CATEGORY' ) or define('BESTBUG_SM_CATEGORY', 'Scroll Magic') ;

// POSTTYPES
defined( 'BESTBUG_SCROLLMAGIC_POSTTYPE' ) or define('BESTBUG_SCROLLMAGIC_POSTTYPE', 'bbsm_scene');

// PREFIX
defined( 'BESTBUG_SCROLMAGIC_PREFIX' ) or define('BESTBUG_SCROLMAGIC_PREFIX', 'bbsm_');

//SLUGS
defined( 'BESTBUG_SM_SLUG' ) or define('BESTBUG_SM_SLUG', 'bbsm-all-scenes');
defined( 'BESTBUG_SCENE_ADD' ) or define('BESTBUG_SCENE_ADD', 'bbsm-add-scene');
defined( 'BESTBUG_SM_SLUG_SETTINGS' ) or define('BESTBUG_SM_SLUG_SETTINGS', 'bbsm-options');



if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_CLASS' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_CLASS Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_CLASS {
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Load core
			if(!class_exists('BESTBUG_CORE_CLASS')) {
				include_once 'bestbugcore/index.php';
			}
			BESTBUG_CORE_CLASS::support('vc-params');
			BESTBUG_CORE_CLASS::support('options');
			BESTBUG_CORE_CLASS::support('posttypes');
			
			if(is_admin()) {
				include_once 'includes/admin/index.php';
			}
			
			include_once 'includes/index.php';
			include_once 'includes/shortcodes/index.php';
			
            add_action( 'init', array( $this, 'init' ) );
			
			// Editor
			add_filter("mce_external_plugins", array( $this, "enqueue_plugin_scripts"));
			add_filter("mce_buttons", array( $this, "register_buttons_editor"));
			
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links') );
			
		}

		public function init() {
			
			// Load enqueueScripts
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			
			// Check on mobile
			if(bb_option(BESTBUG_SCROLMAGIC_PREFIX.'mobile_mode') == 'no' && wp_is_mobile()) {
				return;
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
			$scenestmp = get_posts(array(
				'numberposts' 	   => -1,
				'post_type' 	   => 'bbsm_scene',
				'orderby'          => 'title',
				'order'            => 'ASC',
			));

			$scenes = array();
			foreach ($scenestmp as $key => $scene) {
				$scenes[$key]['text'] = $scene->post_title;
				$scenes[$key]['value'] = $scene->ID;
			}
			wp_localize_script( 'jquery', 'BB_SCENES', $scenes );
			wp_localize_script( 'jquery', 'BB_SM', array(
				'BB_SM_ICON' => BESTBUG_SM_URL . '/assets/admin/img/bb_sm.png',
				'BB_SMIMSQ_ICON' => BESTBUG_SM_URL . '/assets/admin/img/imagesequence.png',
				'BB_SM_SINGLE_IMAGE' => BESTBUG_SM_URL . '/assets/admin/img/bb_sm_single_image_icon.png',
				'BB_SM_IMAGE_GROUP' => BESTBUG_SM_URL . '/assets/admin/img/bb_sm_imagesgroup.png',
		 	) );
			wp_enqueue_style( 'bb-scrollmagic-admin', BESTBUG_SM_URL . '/assets/admin/css/admin.css' );
		}

		public function enqueueScripts() {
			wp_enqueue_style( 'animate', BESTBUG_SM_URL . 'assets/libs/animate/animate.min.css' );
			wp_enqueue_script( 'TweenMax', BESTBUG_SM_URL . 'assets/libs/TweenMax/TweenMax.min.js', array( 'jquery' ), '1.15.1', true );
			wp_enqueue_script( 'scrollmagic', BESTBUG_SM_URL . 'assets/libs/scrollmagic/ScrollMagic.min.js', array( 'jquery' ), '2.0.5', true );
			wp_enqueue_script( 'animation-gsap', BESTBUG_SM_URL . 'assets/libs/scrollmagic/plugins/animation.gsap.min.js', array( 'jquery' ), '2.0.5', true );
			wp_enqueue_script( 'bb-scrollmagic', BESTBUG_SM_URL . '/assets/js/scrollmagic.wp.js', array( 'jquery' ), '1.0', true );
			
			wp_enqueue_style( 'bb-scrollmagic', BESTBUG_SM_URL . '/assets/css/bb-scrollmagic.css' );
			
			if(bb_option(BESTBUG_SCROLMAGIC_PREFIX.'smooth_scrolling') == 'yes') {
				wp_enqueue_script( 'smoothscroll', BESTBUG_SM_URL . '/assets/js/smoothscroll.js', array( 'jquery' ), '1.2.1', true );
			}
			
			wp_localize_script( 'bb-scrollmagic', 'BB_ALLOW_CLASS_NAME', 'true' );
			
			$bb_scenes = array();
			$scenes = get_posts(array(
				'numberposts' => -1,
				'post_type' => 'bbsm_scene',
			));
			foreach ($scenes as $id => $scene_detail) {
				$scene = (array)json_decode(base64_decode($scene_detail->post_content));

				$tween = ( isset($scene['scroll']) ) ? $scene['scroll'] : array();
				unset($scene['scroll']);
				$init = ( isset($scene['init']) ) ? $scene['init'] : array();
				unset($scene['init']);
				$misc = ( isset($scene['misc']) ) ? $scene['misc'] : array();
				unset($scene['misc']);
				$bezier = ( isset($scene['bezier']) ) ? $scene['bezier'] : array();
				unset($scene['bezier']);

				unset($scene['general']->title);
				
				$bb_scenes[$scene_detail->post_name] = array(
													'settings' => $scene,
													'init' => $init,
													'tween' => $tween,
													'misc' => $misc,
													'bezier' => $bezier,
												);
			}
			wp_localize_script( 'bb-scrollmagic', 'BB_SCENES', $bb_scenes );
			
		}
		
		public function add_action_links ( $links ) {
			$mylinks = array(
				'<a href="' . admin_url( 'admin.php?page=bb_sm_options' ) . '">Settings</a>',
			);
			return array_merge( $mylinks, $links );
		}
		
		// Button TinyMCE
		function enqueue_plugin_scripts($plugin_array)
		{
		    //enqueue TinyMCE plugin script with its ID.
			$plugin_array["scrollmagic"] =  BESTBUG_SM_URL . 'assets/admin/js/bb-sm-editor.js';
		    return $plugin_array;
		}
		function register_buttons_editor($buttons)
		{
			//register buttons with their id.
		    array_push($buttons, BESTBUG_SCROLLMAGIC_SHORTCODE);
			array_push($buttons, BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE);
			array_push($buttons, BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE);
			array_push($buttons, BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE);
		    return $buttons;
		}

	}
	new BESTBUG_SCROLLMAGIC_CLASS();
}
