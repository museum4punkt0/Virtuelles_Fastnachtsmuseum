<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Scrollmagic_Imagegroup' ) ) {
	class WPBakeryShortCode_Scrollmagic_Imagegroup extends WPBakeryShortCodesContainer {
	}
} else {
	add_action( 'init', function(){
		global $composer_settings;
		if ( ! empty( $composer_settings ) ) {
			if ( array_key_exists( 'COMPOSER_LIB', $composer_settings ) ) {
				$lib_dir = $composer_settings['COMPOSER_LIB'];
				if ( file_exists( $lib_dir . 'shortcodes.php' ) ) {
					require_once( $lib_dir . 'shortcodes.php' );
				}
			}
		}
		if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Scrollmagic_Imagegroup' ) ) {
			class WPBakeryShortCode_Scrollmagic_Imagegroup extends WPBakeryShortCodesContainer {
			}
		}
	} );
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE {

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
			
			add_shortcode( 'bb_sm_image_group', array( $this, 'shortcode' ) );
			add_shortcode( BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE, array( $this, 'shortcode' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->vc_shortcode();
			}

        }
        
        public function vc_shortcode() {
			vc_map( array(
			    "name" => esc_html__( "Image group", 'bestbug' ),
			    "base" => BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE,
			    "as_parent" => array('except' => BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE),
			    "content_element" => true,
				"icon" => "bb_sm_imagesgroup",
			    "js_view" => 'VcColumnView',
				"description" => esc_html__( "Image Group specifies the horizontal alignment of Single Image", 'bestbug' ),
				'category' => esc_html( sprintf( esc_html__( 'by %s', 'bestbug' ), BESTBUG_SM_CATEGORY ) ),
			    "params" => array(
					array(
						'type'        => 'dropdown',
						'heading'     => 'Align',
						'param_name'  => 'align',
						'value' => array(
							'Left' => 'left',
							'Center' => 'center',
							'Right' => 'right',
						),
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
		public function settings($attr = BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE) {
			return BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE;
		}
		
		public function shortcode( $atts, $content = null ) {
			shortcode_atts( array(
				'bbsm_scene' => '',
				'scenes' => '',
				'align' => '',
				'css' => '',
				'el_class' => '',
			), $atts );
			$attr = $atts;
			
			if(!isset($attr['el_class'])) {
				$attr['el_class'] = '';
			}
			if(!isset($attr['css'])) {
				$attr['css'] = '';
			}
			if(!isset($attr['scenes'])) {
				$attr['scenes'] = '';
			}
			if(!isset($attr['align'])) {
				$attr['align'] = 'left';
			}
			
			$css_class = apply_filters( BESTBUG_HELPER::$VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, BESTBUG_HELPER::vc_shortcode_custom_css_class( $attr['css'], ' ' ), BESTBUG_SCROLLMAGIC_SEQUENCE_IMAGE_SHORTCODE, $atts );
			$css_class .= ' ' . $attr['el_class'] . ' bbsm-text-' . $attr['align']. ' ' . $attr['scenes'];

			return '<div class="'.esc_attr($css_class).'">'.do_shortcode($content).'</div>';
		}
        
    }
	
	new BESTBUG_SCROLLMAGIC_IMAGE_GROUP_SHORTCODE();
}

