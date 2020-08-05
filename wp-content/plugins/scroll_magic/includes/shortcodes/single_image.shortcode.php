<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE {

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		public function init() {
			
			add_shortcode( 'bb_sm_single_image', array( $this, 'shortcode' ) );
			add_shortcode( BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE, array( $this, 'shortcode' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->vc_shortcode();
			}

        }
        
        public function vc_shortcode() {
			vc_map( array(
			    "name" => esc_html__( "Single Image", 'bestbug' ),
			    "base" => BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE,
			    "as_parent" => array('except' => BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE),
			    "content_element" => true,
				"icon" => "bb_sm_single_image_icon",
				"description" => esc_html__( "Simple image and SVG file", 'bestbug' ),
				'category' => esc_html( sprintf( esc_html__( 'by %s', 'bestbug' ), BESTBUG_SM_CATEGORY ) ),
			    "params" => array(
					array(
						'type'        => 'attach_image',
						'heading'     => 'Image',
						'param_name'  => 'image',
						'save_always' => true,
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'bestbug' ),
						'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'bestbug'),
						'param_name' => 'el_class',
					),
					array(
						'type' => 'css_editor',
						'heading' => 'CSS box',
						'param_name' => 'css',
						'group' => 'Design Options',
					),
			    ),
			) );
        }
		public function settings($attr = BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE) {
			return BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE;
		}
		
		public function shortcode( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'image' => '',
				'scenes' => '',
				'css' => '',
				'el_class' => '',
			), $atts ) );
			
			if(!isset($atts['scenes'])) {
				$atts['scenes'] = '';
			}
			$css_class = apply_filters( BESTBUG_HELPER::$VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, BESTBUG_HELPER::vc_shortcode_custom_css_class( $css, ' ' ), BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE, $atts );
			$css_class .= ' ' . $el_class. ' ' . $atts['scenes'];
			
			if ( $image > 0 ) {
				$image = wp_get_attachment_image_src( $image, 'full' );
				if(isset($image[0]) && !empty($image[0])) {
					if (substr( $image[0] , -3) == 'svg' ) {
						$img = file_get_contents($image[0]);
					} else {
						$img = '<img src="'.$image[0].'" />';
					}
					return '<div class="bbsm-single-image '.esc_attr($css_class).'" >'.$img.'</div>';
				}
			}
			
			return '';
		}
        
    }
	
	new BESTBUG_SCROLLMAGIC_SINGLE_IMAGE_SHORTCODE();
}

