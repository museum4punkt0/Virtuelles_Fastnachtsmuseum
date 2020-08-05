<?php
/* BESTBUG CORE */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'BESTBUG_CORE_VERSION' ) or define('BESTBUG_CORE_VERSION', '1.1') ;

defined( 'BESTBUG_CORE_URL' ) or define('BESTBUG_CORE_URL', plugins_url( '/', __FILE__ )) ;
defined( 'BESTBUG_CORE_PATH' ) or define('BESTBUG_CORE_PATH', basename( dirname( __FILE__ ))) ;
defined( 'BESTBUG_CORE_TEXTDOMAIN' ) or define('BESTBUG_CORE_TEXTDOMAIN', 'bestbug') ;

if ( ! class_exists( 'BESTBUG_CORE_CLASS' ) ) {
	/**
	 * BESTBUG_CORE_CLASS Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_CORE_CLASS {


		/**
		 * Constructor, core of BESTBUG
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
            add_action( 'init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
			add_action( 'admin_footer', array( $this, 'ajax_loading') );
			
			include_once 'classes/helper.class.php';
			// just for dev
			include 'dev.php';
		}

		public function init() {

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
			wp_enqueue_style( 'bb-core', BESTBUG_CORE_URL . '/assets/admin/css/style.css' );
			wp_enqueue_script( 'bb-core', BESTBUG_CORE_URL . '/assets/admin/js/script.js', array( 'jquery', 'wp-color-picker' ), '1.0', true );
		}

		public function enqueueScripts() {
			wp_enqueue_style( 'css', BESTBUG_CORE_URL . '/assets/css/style.css' );
			// wp_enqueue_script( 'js', BESTBUG_CORE_URL . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
		}
		
		public static function support($lib = ''){
			switch ($lib) {
				case 'vc-params':
					include_once 'extend/index.php';
					include_once 'extend/vc-params/index.php';
					break;
				case 'options':
					include_once 'classes/options.class.php';
					break;
				case 'posttypes':
					include_once 'classes/posttypes.class.php';
					break;
				case 'htmldom':
					include_once 'libs/simple_html_dom.php';
					break;
				default:
					# code...
					break;
			}
		}

		public function loadTextDomain() {
			load_plugin_textdomain( BESTBUG_CORE_TEXTDOMAIN, false, BESTBUG_CORE_PATH . '/languages/' );
		}
		
		public function ajax_loading(){
			echo '<div class="bb-ajax-loading">
					<div class="bb-ajax-box">
						<div class="bb-spinner">
						  <div class="cube1"></div>
						  <div class="cube2"></div>
						</div>
					</div>
				</div>';
		}

	}
	new BESTBUG_CORE_CLASS();
}
