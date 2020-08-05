<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'BESTBUG_SCROLLMAGIC' ) ) {
	/**
	 * BESTBUG_SCROLLMAGIC Class
	 *
	 * @since	1.0
	 */
	class BESTBUG_SCROLLMAGIC {
		
		public $page_title;
		public $shortcodes;

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			$this->init();
		}

		public function init() {
			
			add_action( 'admin_menu', array( $this, 'all_scenes' ) );
			
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			if(is_admin() && isset($_GET['page']) && $_GET['page'] == BESTBUG_SCENE_ADD) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScriptsAddScene' ) );
			}
			
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			add_action( 'wp_ajax_rc_delete_shortcode', array($this, 'delete') );
			add_filter( 'script_loader_tag', array($this, 'modify_jsx_tag'), 10, 3 );
			
			add_action( 'wp_ajax_update_scene', array( $this, 'update_scene' ) );
			add_action( 'wp_ajax_bbsm_delete_scene', array( $this, 'delete' ) );
			add_action( 'wp_ajax_bbsm_duplicate_scene', array( $this, 'duplicate' ) );
        }
		
		public function modify_jsx_tag( $tag, $handle, $src ) {
			// Check that this is output of JSX file
			if ( 'bb-scene-editor' == $handle ) {
				$tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
				$tag = str_replace( "<script src=", "<script type='text/babel' src=", $tag );
			}

			return $tag;
		}
		
		public function adminEnqueueScripts()
		{
			wp_enqueue_script( 'sweetalert', BESTBUG_CORE_URL . '/assets/admin/js/sweetalert.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'bb-sm', BESTBUG_SM_URL . '/assets/admin/js/admin.js', array( 'jquery' ), '1.0', true );
		}

		public function adminEnqueueScriptsAddScene() {
			wp_enqueue_style( 'wp-color-picker');
			wp_enqueue_script( 'wp-color-picker');

			wp_enqueue_style( 'animate', BESTBUG_SM_URL . 'assets/libs/animate/animate.min.css' );

			wp_enqueue_script( 'TweenMax', BESTBUG_SM_URL . 'assets/libs/TweenMax/TweenMax.min.js', array( 'jquery' ), '1.15.1', true );
			wp_enqueue_script( 'scrollmagic', BESTBUG_SM_URL . 'assets/libs/scrollmagic/ScrollMagic.min.js', array( 'jquery' ), '2.0.5', true );
			wp_enqueue_script( 'animation-gsap', BESTBUG_SM_URL . 'assets/libs/scrollmagic/plugins/animation.gsap.min.js', array( 'jquery' ), '2.0.5', true );
			wp_enqueue_script( 'addIndicators', BESTBUG_SM_URL . 'assets/libs/scrollmagic/plugins/debug.addIndicators.min.js', array( 'jquery' ), '2.0.5', true );

			wp_enqueue_script( 'react', BESTBUG_SM_URL . 'assets/libs/reactjs/react.min.js', array( 'jquery' ), '15.4.2', true );
			wp_enqueue_script( 'react-dom', BESTBUG_SM_URL . 'assets/libs/reactjs/react-dom.min.js', array( 'react' ), '15.4.2', true );

			wp_enqueue_script( 'babel', BESTBUG_SM_URL . 'assets/libs/reactjs/babel.min.js', array( 'react' ), '6.15.0', true );

			wp_enqueue_script( 'bb-scene-editor', BESTBUG_SM_URL . '/assets/admin/js/bb-scene-editor.jsx', array( 'react' ), null, true );
			// Localize the script
			$translation = array(
				'livePreview' => esc_html__( 'Live Preview', 'bestbug' ),
				'sceneSettings' => esc_html__('General Settings', 'bestbug'),
				'properties' => esc_html__('After', 'bestbug'),
				'ease' => esc_html__('Ease', 'bestbug'),
				'bezier' => esc_html__('Bezier', 'bestbug'),
				'classes' => esc_html__('Class', 'bestbug'),
				'general' => esc_html__('General', 'bestbug'),
				'init' => esc_html__('Init', 'bestbug'),
			);
			wp_localize_script( 'bb-scene-editor', 'BB_TRANSLATION', $translation );

			$props = array(
				
				'width' => '',
				'height' => '',
				
				'zIndex' => '',
				
				'position' => '',
				'left' => '',
				'top' => '',
				'right' => '',
				'bottom' => '',

				'x' => '',
				'y' => '',
				'z' => '',

				'scaleX' => '',
				'scaleY' => '',
				'scaleZ' => '',

				'rotation' => '',
				'rotationX' => '',
				'rotationY' => '',
				'rotationZ' => '',

				'skewX' => '',
				'skewY' => '',

				'backgroundColor' => '',
				'color' => '',
				
				'backgroundAttachment' => '',
				
				'overflow' => '',
			);

			$settings = array(
				'init' => $props,
				'scroll' => $props,
				// General
				'general' => array(
					'title' => '',
					'name' => '',
					'duration' => '',
					'offset' => '',
					'pin' => 'off',
					'pushFollowers' => true,
					'triggerHook' => '0.5',
					'vertical' => 'on',
					'reverse' => true,
					'triggerElement' => '',
				),
				// Ease
				'ease' => array(
					'delay' => '',
					'duration' => '0.5',
					'ease' => '',
				),
				// Class
				'class' => array(
					'classToggleEnable' => 'off',
					'classCSS' => 'bounce',
				),

				// Misc
				'misc' => array(
					'drawSVG' => 'on',
					'selector' => '',
					'container' => '',
				),

				// bezier
				'bezier' => array(
					// array(
					// 	'x' => 510,
					// 	'y' => 60,
					// ),
					// array(
					// 	'x' => 620,
					// 	'y' => -60,
					// ),
					// array(
					// 	'x' => 500,
					// 	'y' => -100,
					// ),
					// array(
					// 	'x' => 380,
					// 	'y' => 20,
					// ),
					// array(
					// 	'x' => 500,
					// 	'y' => 60,
					// ),
					// array(
					// 	'x' => 580,
					// 	'y' => 20,
					// ),
					// array(
					// 	'x' => 620,
					// 	'y' => 15,
					// ),
				),

			);

			wp_localize_script( 'bb-scene-editor', 'BB_SCENE_SETTINGS', $settings );


			$settings_edit = '';
			if(isset($_GET['idScene']) && !empty($_GET['idScene']) && is_numeric($_GET['idScene'])) {
				$scene_settings = get_post($_GET['idScene']);
				$settings_edit = (array)json_decode(base64_decode($scene_settings->post_content));
				$settings_edit['scene_id'] = $scene_settings->ID;
			}
			wp_localize_script( 'bb-scene-editor', 'BB_SCENE_EDIT_SETTINGS', $settings_edit );

		}

		public function enqueueScripts() {
		
		}
		
		function update_scene(){

			if( isset( $_POST['data'] ) && !empty( $_POST['data'] ) ) {
				$settings = $_POST['data'];

				foreach ($settings['init'] as $key => $init) {
					if($init == '') {
						unset($settings['init'][$key]);
					}
				}
				foreach ($settings['scroll'] as $key => $scroll) {
					if($scroll == '') {
						unset($settings['scroll'][$key]);
					}
				}
				
				$name = sanitize_title( esc_html($settings['general']['name']) );
				if(empty($name)) {
					$name = sanitize_title( esc_html($settings['general']['title']) );
				}
				$settings['general']['name'] = $name;

				$scene = array(
					'post_title' => esc_html($settings['general']['title']),
					'post_content' => base64_encode(json_encode($settings)),
					'post_type' => 'bbsm_scene',
					'post_status' => 'publish',
					'post_name' => $name
				);

				if(isset($settings['scene_id']) && !empty($settings['scene_id'])) {
					$scene['ID'] = esc_html($settings['scene_id']);
				}
				
				$error = true;

				$scene_ID = wp_insert_post( $scene, $error );

				if( !$scene_ID ) {
					echo json_encode(array(
						'msg' => esc_html__('Failed'),
						'status' => 'error',
					));
				} else {
					$post = get_post($scene_ID);
					
					echo json_encode(array(
						'msg' => esc_html__('Saved'),
						'status' => 'ok',
						'name' => $post->post_name,
						'scene_id' => $scene_ID,
					));
					
				}
			}

			wp_die();

		}
	
		public function delete(){
			if(isset($_POST['id'])) {
				$del = wp_delete_post( $_POST['id'], true );
				if($del) {
					echo json_encode(array(
						'status' => 'notice',
						'title' => esc_html('Deleted', 'bestbug'),
						'message' => esc_html('Scene is deleted!', 'bestbug'),
					));
					exit;
				}
			}
			echo json_encode(array(
				'status' => 'error',
				'title' => esc_html('Error', 'bestbug'),
				'message' => esc_html('Can not delete!', 'bestbug'),
			));
			exit;
		}
		
		public function duplicate(){
			if(!isset($_POST['id']) || empty($_POST['id'])) {
				return;
			}
			$post = get_post($_POST['id']);

			if($post) {
				
				$scene = array(
					'post_title' => esc_html($post->post_title),
					'post_content' => $post->post_content,
					'post_type' => BESTBUG_SCROLLMAGIC_POSTTYPE,
					'post_status' => 'publish',
				);
				
				$scene_ID = wp_insert_post( $scene );
				
				if( !$scene_ID ) {
					$this->notice = esc_html__( 'Irks! An error has occurred.', 'bestbug' );
					add_action( 'admin_notices', array( $this, 'error_notice' ) );
				} else {
					
					$post = get_post($scene_ID);
					if($post) {
						$settings = (array)json_decode(base64_decode($post->post_content));
						$settings["general"]->name = $post->post_name;
						$scene = array(
							'ID'           => $scene_ID,
							'post_content' => base64_encode(json_encode($settings)),
						);
					  	wp_update_post( $scene );
					}
					
					echo json_encode(array(
						'status' => 'notice',
						'title' => esc_html('Copied', 'bestbug'),
						'message' => esc_html('Scene is copied!', 'bestbug'),
						'row' => array(
							'id' => $post->ID,
							'title' => $post->post_title,
							'name' => $post->post_name,
						),
					));
					exit;
				}
				
			} 
			echo json_encode(array(
				'status' => 'error',
				'title' => esc_html('Error', 'bestbug'),
				'message' => esc_html('Can not copy!', 'bestbug'),
			));
			exit;
			
		}
		
		public function all_scenes(){
			$menu = array(
				'page_title' => esc_html('All Scenes', 'bestbug'),
				'menu_title' => esc_html('Scroll Magic', 'bestbug'),
				'capability' => 'manage_options',
				'menu_slug' => BESTBUG_SM_SLUG,
				'icon' => BESTBUG_SM_URL . '/assets/admin/img/visual_composer.png',
				'position' =>  76,
			);
			$this->page_title = $menu['page_title'];
			add_menu_page($menu['page_title'],
						$menu['menu_title'],
						$menu['capability'],
						$menu['menu_slug'],
						array(&$this, 'view'),
						$menu['icon'],
						$menu['position']
					);
			add_submenu_page(
				BESTBUG_SM_SLUG,
				esc_html__('All Scenes' , 'bestbug'),
				esc_html__('All Scenes' , 'bestbug'),
				$menu['capability'],
				$menu['menu_slug'],
				array(&$this, 'view')
		    );
			add_submenu_page(
				BESTBUG_SM_SLUG,
				esc_html('Add Scene', 'bestbug'),
				esc_html('Add Scene', 'bestbug'),
				'manage_options',
				BESTBUG_SCENE_ADD,
				array(&$this, 'add_scenes' )
			);
		}
		
		public function view() {
			
			$this->scenes = get_posts(array(
				'numberposts' => -1,
				'post_type' => BESTBUG_SCROLLMAGIC_POSTTYPE,
			));
			
			BESTBUG_HELPER::begin_wrap_html($this->page_title);
			include 'templates/scenes.view.php';
			BESTBUG_HELPER::end_wrap_html();
		}
		
		public function subform(){
			?>
			<div class="bb-row">
			    <div class="bb-col">
			        <a href="<?php echo admin_url( 'admin.php?page=' . BESTBUG_SCENE_ADD ) ?>" class="button success"><span class="dashicons dashicons-plus-alt"></span><?php esc_html_e('Add Scene', 'bestbug') ?></a>
			    </div>
			</div>
			<?php
		}
        
        public function add_scenes() {
			include 'templates/add_scene.view.php';
        }
        
    }
	
	new BESTBUG_SCROLLMAGIC();
}

