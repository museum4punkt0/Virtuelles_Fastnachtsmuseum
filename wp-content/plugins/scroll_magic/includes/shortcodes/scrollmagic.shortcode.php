<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Scrollmagic' ) ) {
	class WPBakeryShortCode_Scrollmagic extends WPBakeryShortCodesContainer {
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
		if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Scrollmagic' ) ) {
			class WPBakeryShortCode_Scrollmagic extends WPBakeryShortCodesContainer {
			}
		}
	} );
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC_SHORTCODE' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC_SHORTCODE Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC_SHORTCODE {

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
			
			add_shortcode( 'bb_sm', array( $this, 'shortcode' ) );
			add_shortcode( BESTBUG_SCROLLMAGIC_SHORTCODE, array( $this, 'shortcode' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->vc_shortcode();
			}

        }
        
        public function vc_shortcode() {
			vc_map( array(
			    "name" => esc_html__( "Scroll Magic", 'bestbug' ),
			    "base" => BESTBUG_SCROLLMAGIC_SHORTCODE,
			    "as_parent" => array('except' => BESTBUG_SCROLLMAGIC_SHORTCODE),
			    "content_element" => true,
				"icon" => "bb_sm_icon",
			    "js_view" => 'VcColumnView',
				"description" => esc_html__( "A full-fledged scrolling animation", 'bestbug' ),
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
		public function settings($attr = BESTBUG_SCROLLMAGIC_SHORTCODE) {
			return BESTBUG_SCROLLMAGIC_SHORTCODE;
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
			if(!isset($attr['bbsm_scene'])) {
				$attr['bbsm_scene'] = '';
			}
			if(!isset($attr['scenes'])) {
				$attr['scenes'] = '';
			}
			if(!isset($attr['css'])) {
				$attr['css'] = '';
			}
			if(!isset($attr['align'])) {
				$attr['align'] = 'left';
			}

			$scene = str_replace(","," ", $attr['bbsm_scene']);

			$el_id = uniqid('bbsm-');
			
			$css_class = BESTBUG_HELPER::vc_shortcode_custom_css_class( $attr['css']);
			$css_class .= ' ' . $attr['el_class'];
			$css_class .= ' ' . $scene;
			$css_class .= ' ' . $attr['scenes'];
			$css_class .= ' ' . $attr['bbsm_scene'];
			$css_class .= ' bbsm-text-' . $attr['align'];

			return "<div id='".esc_attr($el_id)."' class='".$css_class."'>" . do_shortcode( $content ) . '</div>';
		}
        
    }
	
	new BESTBUG_SCROLLMAGIC_SHORTCODE();
}

