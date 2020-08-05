<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_HELPER' ) ) {
	/**
	 * BESTBUG_HELPER Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_HELPER {
		
		public static $VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG;

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			self::$VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG = (defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) ? VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG : 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG';
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
        
		public static function update_option( $option_name, $option_value ){
			$option_exists = (get_option( $option_name, null));
		
			if($option_exists !== null) {
				if($option_value == $option_exists) {
					return true;
				}
				return update_option($option_name, $option_value);
			} else {
				return add_option($option_name, $option_value);
			}
		}
		
		public static function update_meta( $post_id, $meta_name, $meta_value ){
			$meta_exists = get_post_meta($post_id, $meta_name);
			if( is_array($meta_exists) && count($meta_exists) > 0 ) {
				if($meta_value == $meta_exists[0]) {
					return true;
				}
				return update_post_meta( $post_id, $meta_name, $meta_value );
			} else {
				return add_post_meta( $post_id, $meta_name, $meta_value, true );
			}
		}
		
		public static function vc_shortcode_custom_css_class($css) {
			if( function_exists('vc_shortcode_custom_css_class') ) {
				return vc_shortcode_custom_css_class($css);
			}
			return '';
		}
		
		public static function get_background_image($id = '') {
			if(empty($id)) {
				return '';
			}
			$image = wp_get_attachment_image_src($id);
			if(isset($image[0])) {
				return 'style="background-image:url('.$image[0].')"';
			}
			return '';
		}
		
		public static function option($option_name) {
			return bb_option($option_name);
		}
		
		public static function begin_wrap_html($page_title){
			?>
			<div class="wrap bb-wrap bb-settings">
			    <h2 class="bb-headtitle"><?php echo esc_html($page_title) ?></h2>
			<?php
		}
        
		public static function end_wrap_html(){
			?>
			</div>
			<?php
		}
		
		public static function get_custom_class( $param_value, $prefix = '' ) {
			$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

			return $css_class;
		}
		
		public static function get_bbcustom_class( $param_value, $prefix = '' ) {
			preg_match( '/([\bb_custom_])\w+/', $param_value, $css_class ) ;
			return (isset($css_class[0]))?$css_class[0]:'';
		}
        
    }
	
	new BESTBUG_HELPER();
}

// Get option
if(!function_exists('bb_option')) {
    function bb_option($option_name) {
		$option_exists = (get_option( $option_name, null));
	
		if($option_exists !== null) {
			return $option_exists;
		} else {
			
			$options = apply_filters( 'bb_register_options', array() );
    		if( !isset($options) || count($options) <= 0 ) {
    			return false;
    		}
			
    		foreach ($options as $key => $option) {
				if($option['type'] != 'options_fields') {
					continue;
				}
				foreach ($option['fields'] as $key => $field) {
					if(isset($field['param_name']) && $field['param_name'] == $option_name) {
						if(is_array($field['value']) && isset($field['std'])) {
							return $field['std'];
						}
						return $field['value'];
					}
				}
			}
			
			return false;
		}
    }
}