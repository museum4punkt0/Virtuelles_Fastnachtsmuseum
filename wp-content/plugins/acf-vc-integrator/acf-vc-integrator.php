<?php
    /*
    Plugin Name: ACF-VC Integrator
    Plugin URI: https://nordiccustommade.dk/
    Description: ACF VC Integrator plugin is the easiest way to output your Advanced Custom Posttype fields in a WPBakery Page Builder (Visual Composer) Grid.
    Author: Nordic Custom Made
    Version: 1.2.4
    Author URI: https://nordiccustommade.dk/
    */
?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// Create a helper function for easy SDK access.
function avi_fs() {
		global $avi_fs;

		if ( ! isset( $avi_fs ) ) {
				// Include Freemius SDK.
				require_once dirname(__FILE__) . '/freemius/start.php';

				$avi_fs = fs_dynamic_init( array(
				            'id'                  => '737',
				            'slug'                => 'acf-vc-integrator',
				            'type'                => 'plugin',
				            'public_key'          => 'pk_d030216f06a393bfbf059ee916d94',
				            'is_premium'          => false,
				            'has_addons'          => false,
				            'has_paid_plans'      => false,
				            'menu'                => array(
				                'slug'           => 'acf-vc-integrator',
				                'account'        => false,
				                'contact'        => false,
				                'support'        => false,
				                'parent'         => array(
				                    'slug' => 'options-general.php',
				                ),
						),
				) );
		}

		return $avi_fs;
}

// Init Freemius.
avi_fs();
// Signal that SDK was initiated.
do_action( 'avi_fs_loaded' );
avi_fs()->add_action('after_uninstall', 'avi_fs_uninstall_cleanup');

	function acf_vc_integrator_check_for_dependancy() {
		function acf_vc_integrator_showMessage($message, $msgn = 'success', $isDismissible = false)
		{
			if ($msgn == "error") {
				echo '<div class="notice notice-error '.$isDismissible.'">';
			} elseif ($msgn == "info") {
				echo '<div class="notice notice-info '.$isDismissible.'">';
			}	else {
				echo '<div class="notice notice-success '.$isDismissible.'">';
			}
			echo "<p><strong>$message</strong></p></div>";
		}

		function acf_vc_integrator_showAdminMessages()
		{
			if ( !class_exists('Vc_Manager') and  !is_plugin_active( 'advanced-custom-fields/acf.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' )) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require both WPBakery Page Builder and Advanced Custom Fields plugins installed and activated.", "error");
			} elseif ( !class_exists('Vc_Manager') ) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require WPBakery Page Builder plugin installed and activated.", "error");
			} elseif ( !is_plugin_active( 'advanced-custom-fields/acf.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
				acf_vc_integrator_showMessage("ACF-VC Integrator require Advanced Custom Fields or Advanced Custom Fields Pro plugin installed and activated.", "error");
			}
      if(is_plugin_active( 'advanced-custom-fields-pro/acf.php' )) {
        $screen = get_current_screen();
        if( $screen->parent_base === "acf-vc-integrator" ) {
          acf_vc_integrator_showMessage("ACF-VC Integrator version 1.2 supports the Repeater field in ACF-Pro, as well as fields also found in ACF.", "info");
        } elseif($screen->parent_base === "plugins") {
          // acf_vc_integrator_showMessage("ACF-VC Integrator version 1.2 supports the Repeater field in ACF-Pro, as well as fields also found in ACF.", "info", "is-dismissible");
        }
      }
		}
		add_action('admin_notices', 'acf_vc_integrator_showAdminMessages');
	}

	//Check for ACF and VC plugins
	add_action('admin_init', 'acf_vc_integrator_check_for_dependancy');

  //Get acf OR acf pro version number
  function get_acf_version_number() {
  	if ( ! function_exists( 'get_plugins' ) )
  		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
    	$plugin_folder = get_plugins( '/' . 'advanced-custom-fields' );
    } else {
      $plugin_folder = get_plugins( '/' . 'advanced-custom-fields-pro' );
    }
    $plugin_file = 'acf.php';

  	if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
  		return $plugin_folder[$plugin_file]['Version'];
  	} else {
  		return NULL;
  	}
  }

	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'acfvc_add_action_links' );
	function acfvc_add_action_links ( $links ) {
		$settings_link = '<a href="options-general.php?page=acf-vc-integrator">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

  function is_acf_repeater_active() {
    if( is_plugin_active( 'acf-repeater/acf-repeater.php' ) AND !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
      return true;
    } else {
      return false;
    }
  }

	//Adding dashboard page.
	function acf_vc_integrator_admin() {
		include('acf_vc_integrator_admin.php');
	}
	function acf_vc_integrator_admin_actions() {
		add_options_page("ACF-VC Integrator", "ACF-VC Integrator", "manage_options", "acf-vc-integrator", "acf_vc_integrator_admin");
	}
	add_action('admin_menu', 'acf_vc_integrator_admin_actions');

	add_action( 'vc_before_init', 'acf_vc_integrator_elem' );
	// add_action( 'init', 'acf_vc_integrator_elem' );
	function acf_vc_integrator_elem() {
		if ( class_exists('Vc_Manager') ) {
			$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
			$groups_param_values = $fields_params = array();
			foreach ( $groups as $group ) {
				$flg = 1;

				$id = isset( $group['id'] ) ? 'id' : ( isset( $group['ID'] ) ? 'ID' : 'id' );
				$groups_param_values[ $group['title'] ] = $group[ $id ];
				$fields = function_exists( 'acf_get_fields' ) ? acf_get_fields( $group[ $id ] ) : apply_filters( 'acf/field_group/get_fields', array(), $group[ $id ] );
	      $fields_param_value = array();
	      if ($fields != false) :
	  			foreach ( $fields as $field ) {
	  				$fields_param_value[ $field['label'] ] = (string) $field['key'];
	  			}
	      endif;
				$fields_params[] = array(
					'type' => 'dropdown',
					'heading' => __( 'Field name', 'js_composer' ),
					'param_name' => 'field_from_' . $group[ $id ],
					'value' => $fields_param_value,
					'save_always' => true,
					'description' => __( 'Select field from group.', 'js_composer' ),
					'dependency' => array(
						'element' => 'field_group',
						'value' => array( (string) $group[ $id ] ),
					)
				);

			}

			wp_enqueue_style( 'acf-vc-integrator-style', plugin_dir_url( __FILE__ ).'css/acf-vc-integrator-style.css');
	    include_once('inc/acf_vc_helper.php');

			vc_map( array(
				'name' => __( 'ACF-VC Integrator', 'js_composer' ),
				'base' => 'acf_vc_integrator',
				'icon' => plugin_dir_url( __FILE__ )."images/acf_icon1.png",
				'category' => __( 'Content', 'js_composer' ),
				'description' => __( 'Advanced Custom Field - Visual Composer Integrator', 'js_composer' ),
				'php_class_name' => 'Acf_vc_integrator_Shortcode',
				'admin_enqueue_css' => plugin_dir_url( __FILE__ ).'css/acf-vc-integrator-style.css',
				'params' => array_merge(
					array(
						array(
							'type' => 'dropdown',
							'heading' => __( 'Field group', 'js_composer' ),
							'param_name' => 'field_group',
							'admin_label' => true,
							'value' => $groups_param_values,
							'save_always' => true,
							'description' => __( 'Select field group.', 'js_composer' ),
						),
					),
					$fields_params,
					array(
						array(
				            'type' => 'css_editor',
				            'heading' => __( 'Css', 'my-text-domain' ),
				            'param_name' => 'css',
				            'group' => __( 'Design options', 'my-text-domain' ),
				        ),
						array(
							'type' => 'dropdown',
							'heading' => __( 'Show label', 'js_composer' ),
							'param_name' => 'show_label',
							'value' => array( __( 'No', 'js_composer' ) => '', __( 'Yes', 'js_composer' ) => 'yes', __( 'Yes and hide if no result', 'js_composer' ) => 'yes_no' ),
							'save_always' => true,
							'description' => __( 'Enter label to display before key value.', 'js_composer' ),
						),
						array(
							'type' => 'dropdown',
							'heading' => __( 'Align', 'js_composer' ),
							'param_name' => 'align',
							'value' => array(
								__( 'left', 'js_composer' ) => 'left',
								__( 'right', 'js_composer' ) => 'right',
								__( 'center', 'js_composer' ) => 'center',
								__( 'justify', 'js_composer' ) => 'justify',
							),
							'description' => __( 'Select alignment.', 'js_composer' ),
						),
						array(
							'type' => 'textfield',
							'heading' => __( 'Extra class name', 'js_composer' ),
							'param_name' => 'el_class',
							'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),
						array(
							'type' => 'textfield',
							'heading' => __( 'Custom Link Text', 'js_composer' ),
							'param_name' => 'link_text',
							'description' => __( 'Applicable only for File Objects and Page Links', 'js_composer' ),
						)
					)
				),
			));
			class Acf_vc_integrator_Shortcode extends WPBakeryShortCode {
				/**
				 * @param $atts
				 * @param null $content
				 *
				 * @return mixed|void
				 */
				protected function content( $atts, $content = null ) {
					$field_key = $label = '';
					/**
					 * @var string $el_class
					 * @var string $show_label
					 * @var string $align
					 * @var string $field_group
					 */
					extract( shortcode_atts( array(
						'el_class' => '',
						'field_group' => '',
						'show_label' => '',
						'align' => '',
						'link_text' => ''
					), $atts ) );

	        $acf_version = get_acf_version_number();

	        if ( 0 === strlen( $field_group ) ) {
						$groups = function_exists( 'acf_get_field_groups' ) ? acf_get_field_groups() : apply_filters( 'acf/get_field_groups', array() );
						if ( is_array( $groups ) && isset( $groups[0] ) ) {
							$key = isset( $groups[0]['id'] ) ? 'id' : ( isset( $groups[0]['ID'] ) ? 'ID' : 'id' );
							$field_group = $groups[0][ $key ];
						}
					}
					if ( ! empty( $field_group ) ) {
						$field_key = ! empty( $atts[ 'field_from_' . $field_group ] ) ? $atts[ 'field_from_' . $field_group ] : 'field_from_group_' . $field_group;
					}

	        /*Get the page/post id when using Templatera*/
	        if(get_queried_object_id() != get_the_ID()) {
	          $post_id = get_queried_object_id();
	        } else {
	          $post_id = get_the_ID();
	        }
	        $output = "";
					$custom_field = get_field_object($field_key,$post_id);
					$css_class = 'vc_sw-acf' . ( strlen( $el_class ) ? ' ' . $el_class : '' ) . ( strlen( $align ) ? ' vc_sw-align-' . $align : '' ) . ( strlen( $field_key ) ? ' ' . $field_key : '' );
					$link_text = ( strlen( $link_text ) ? $link_text : 'Link' );
	        $acf_vc_helper = new acf_vc_helper();
					$output_empty = false;
					if (empty($custom_field["value"])) {
						$output_empty = true;
					} elseif('text' === $custom_field["type"]) {
	          $output = $acf_vc_helper->text($custom_field, $acf_version);
					} elseif('textarea' === $custom_field["type"]) {
	          $output = $acf_vc_helper->textarea($custom_field, $acf_version);
					} elseif('wysiwyg' === $custom_field["type"]) {
	          $output = $acf_vc_helper->wysiwyg($custom_field, $acf_version);
					} elseif('number' === $custom_field["type"]) {
	          $output = $acf_vc_helper->number($custom_field, $acf_version);
					} elseif('email' === $custom_field["type"]) {
	          $output = $acf_vc_helper->email($custom_field, $acf_version);
					} elseif('password' === $custom_field["type"]) {
	          $output = $acf_vc_helper->password($custom_field, $acf_version);
					} elseif('image' === $custom_field["type"]) {
	          $output = $acf_vc_helper->image($custom_field, $acf_version);
					} elseif('file' === $custom_field["type"]) {
	          $output = $acf_vc_helper->file($custom_field, $acf_version, $link_text);
					} elseif('checkbox' === $custom_field["type"]) {
	          $output = $acf_vc_helper->checkbox($custom_field, $acf_version);
					} elseif('radio' === $custom_field["type"]) {
	          $output = $acf_vc_helper->radio($custom_field, $acf_version);
					} elseif('user' === $custom_field["type"]) {
	          $output = $acf_vc_helper->user($custom_field, $acf_version);
					} elseif('page_link' === $custom_field["type"]) {
	          $output = $acf_vc_helper->page_link($custom_field, $acf_version, $link_text);
					} elseif('google_map' === $custom_field["type"]) {
	          $output = $acf_vc_helper->google_map($custom_field, $acf_version);
					} elseif('date_picker' === $custom_field["type"]) {
	          $output = $acf_vc_helper->date_picker($custom_field, $acf_version);
					} elseif('color_picker' === $custom_field["type"]) {
	          $output = $acf_vc_helper->color_picker($custom_field, $acf_version);
					} elseif('true_false' === $custom_field["type"]) {
	          $output = $acf_vc_helper->true_false($custom_field, $acf_version);
					} elseif('taxonomy' === $custom_field["type"]) {
	          $output = $acf_vc_helper->taxonomy($custom_field, $acf_version);
					} elseif('post_object' === $custom_field["type"]) {
	          $output = $acf_vc_helper->post_object($custom_field, $acf_version);
					} elseif('relationship' === $custom_field["type"]) {
	          $output = $acf_vc_helper->relationship($custom_field, $acf_version);
					} elseif('url' === $custom_field["type"]) {
	          $output = $acf_vc_helper->url($custom_field, $acf_version);
	  			} elseif('select' === $custom_field["type"]) {
	          $output = $acf_vc_helper->select($custom_field, $acf_version);
	  			} elseif('oembed' === $custom_field["type"]) {
	          $output = $acf_vc_helper->oembed($custom_field, $acf_version);
	  			} elseif('repeater' === $custom_field["type"]) {
	          $fieldNames = array_keys($custom_field['value'][0]);
	          $is_acf_repeater_active = is_acf_repeater_active();
	          if (!empty($custom_field['value'][0])) :
	            $output = '<div class="repeater-wrapper">';
				if ($acf_version >= 5) :
		            while ( have_rows($custom_field['name'],$post_id) ) : the_row();
		              $output .= '<div class="reapeater-row row-'.get_row_index().'">';
		              foreach ($fieldNames as $key => $value) {
		              $subSeild = get_sub_field_object($value);
		                if( $is_acf_repeater_active === true ) {
		                  $subSeildValue = get_sub_field($value);
		                  $subSeild["value"] = $subSeildValue;
		                }
		                $output .= $acf_vc_helper->repeater($subSeild, $acf_version, $link_text, $post_id);
		              }
		              $output .= '</div>';
		            endwhile;
				else :
					while ( has_sub_field($custom_field['name'],$post_id) ) {
		              $output .= '<div class="reapeater-row">';
		              foreach ($fieldNames as $key => $value) {
		              $subSeild = get_sub_field_object($value);
		                if( $is_acf_repeater_active === true ) {
		                  $subSeildValue = get_sub_field($value);
		                  $subSeild["value"] = $subSeildValue;
		                }
		                $output .= $acf_vc_helper->repeater($subSeild, $acf_version, $link_text, $post_id);
		              }
		              $output .= '</div>';
					}
				endif;
	            $output .= '</div>';
	          endif;
	        }

					if($output == "data-mismatch") {
						// set the mismatch error message here.
						$output = 'Data mismatch error. Custom field value doesn\'t match the field type. Please set the field value again.';
					}
					if ( 'yes' === $show_label OR 'yes_no' === $show_label AND $output_empty === false) {
						if(!isset($output)) {
							$output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].':</span> '.$custom_field["value"];
						} else {
							$output = '<span class="sw-acf-field-label label-'.$field_key.'">'.$custom_field["label"].':</span> '.$output;
						}
					} elseif ( 'yes_no' === $show_label AND  $output_empty === true) {
						$output = "";
					} else {
						if(!isset($output) OR empty($output)) $output = $custom_field["value"];
					}
					$css = '';
					extract(shortcode_atts(array(
					    'css' => ''
					), $atts));
					$css_class_vc = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
					return '<div id="' . $field_key . '" class="' . esc_attr( $css_class_vc ) . ' ' . esc_attr( $css_class ) . '">'.$output. '</div>';
					/*return '<< Working on retrieving the data from ACF. >>';*/

				}
			}

		}
	}
?>
