<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Video gallery and Player
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Html5vp_Admin {

	function __construct() {		
		
		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'html5vp_register_menu'), 12 );

		
	}

	
	/**
	 * Function to add menu
	 * 
	 * @package Video gallery and Player
	 * @since 1.0.0
	 */
	function html5vp_register_menu() {

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.WP_HTML5VP_POST_TYPE, __('Upgrade to PRO - Video gallery and Player', 'html5-videogallery-plus-player'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'html5-videogallery-plus-player').'</span>', 'manage_options', 'html5vp-premium', array($this, 'html5vp_premium_page') );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Video gallery and Player
	 * @since 1.0.0
	 */
	function html5vp_premium_page() {
		include_once( WP_HTML5VP_DIR . '/includes/admin/settings/premium.php' );
	}
	
	
}

$html5vp_admin = new Html5vp_Admin();