<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_POSTTYPES' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_POSTTYPES Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_POSTTYPES {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			//$this->init();
			add_filter( 'bb_register_posttypes', array( $this, 'register_posttypes' ), 10, 1 );
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
        
		public function register_posttypes($posttypes) {

			if( empty($posttypes) ) {
				$posttypes = array();
			}

			$labels = array(
				'name'               => _x( 'Scenes', 'Scenes', 'bestbug' ),
				'singular_name'      => _x( 'Scene', 'Scene', 'bestbug' ),
				'menu_name'          => _x( 'Scenes', 'Scenes', 'bestbug' ),
				'name_admin_bar'     => _x( 'Scene', 'Scene', 'bestbug' ),
				'add_new'            => _x( 'Add New', 'Scene', 'bestbug' ),
				'add_new_item'       => __( 'Add New Scene', 'bestbug' ),
				'new_item'           => __( 'New Scene', 'bestbug' ),
				'edit_item'          => __( 'Edit Scene', 'bestbug' ),
				'view_item'          => __( 'View Scene', 'bestbug' ),
				'all_items'          => __( 'All Scenes', 'bestbug' ),
				'search_items'       => __( 'Search Scenes', 'bestbug' ),
				'parent_item_colon'  => __( 'Parent Scenes:', 'bestbug' ),
				'not_found'          => __( 'No Scenes found.', 'bestbug' ),
				'not_found_in_trash' => __( 'No Scenes found in Trash.', 'bestbug' )
			);

			$args = array(
				'labels'             => $labels,
	            'description'        => __( 'Scenes settings.', 'bestbug' ),
				'public'             => false,
				'publicly_queryable' => true,
				'show_ui'            => false,
				'show_in_menu'       => false,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
			);

			$posttypes[BESTBUG_SCROLLMAGIC_POSTTYPE] = $args;
			return $posttypes;
		}
        
    }
	
	new BESTBUG_SCROLLMAGIC_POSTTYPES();
}

