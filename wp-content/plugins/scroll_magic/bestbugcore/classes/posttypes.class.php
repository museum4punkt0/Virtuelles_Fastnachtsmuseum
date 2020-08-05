<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_CORE_POSTTYPES' ) ) {
	/**
	 * BESTBUG_CORE_POSTTYPES Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_CORE_POSTTYPES {

        public $posttypes;
        
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'register_posttypes' ) );
		}

		public function init() {

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
		
		}

		public function enqueueScripts() {
		
        }
        
        public function register_posttypes() {
            $this->posttypes = apply_filters( 'bb_register_posttypes', array() );

    		if( empty($this->posttypes) ) {
    			return;
    		}

    		foreach ($this->posttypes as $slug => $posttype) {
    			if( !empty($slug) ) {
    				register_post_type( $slug, $posttype );
    			}
    		}
        }
        
    }
	
	new BESTBUG_CORE_POSTTYPES();
}

