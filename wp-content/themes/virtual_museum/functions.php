<?php
/**
 * virtual_Museum functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package virtual_Museum
 */
 if( function_exists('acf_add_options_page') ) {

 	acf_add_options_page();
  acf_add_options_sub_page('Header');
 }



if ( ! function_exists( 'virtual_museum_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function virtual_museum_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on virtual_Museum, use a find and replace
		 * to change 'virtual_museum' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'virtual_museum', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'virtual_museum' ),
			'header-main-menu' => __('Header main Menu')
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'virtual_museum_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 66,
			'width'       => 270,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'virtual_museum_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function virtual_museum_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'virtual_museum_content_width', 640 );
}
add_action( 'after_setup_theme', 'virtual_museum_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function virtual_museum_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'virtual_museum' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'virtual_museum' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
  register_sidebar(array(
  'name'          => 'footer1',
  'id'            => 'footer1',
  'description'   => 'footer widget 2 of 4 columns',
  'before_widget' => '<div class=footer_widget>',
  'after_widget' => '</div>',
  ) );
  register_sidebar(array(
  'name'          => 'footer2',
  'id'            => 'footer2',
  'description'   => 'footer widget 1of4',
  'before_widget' => '<div class=footer_widget>',
  'after_widget' => '</div>',
  ) );
  register_sidebar(array(
  'name'          => 'footer3',
  'id'            => 'footer3',
  'description'   => 'footer widget 1of4',
  'before_widget' => '<div class=footer_widget>',
  'after_widget' => '</div>',
  ) );
}
add_action( 'widgets_init', 'virtual_museum_widgets_init' );
remove_filter ('the_content', 'wpautop');
/**
 * Enqueue scripts and styles.
 */
function virtual_museum_scripts() {

  wp_register_script('tweenmax_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/TweenMax.min.js', array(),'1.1', true);
  wp_enqueue_script('tweenmax_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/TweenMax.min.js', array(),'1.1', true);

  wp_register_script('scrollmagic_script', get_template_directory_uri() . 'js/scrollmagic/minified/ScrollMagic.min.js', array(),'1.1', true);
  wp_enqueue_script('scrollmagic_script', get_template_directory_uri() . 'js/scrollmagic/minified/ScrollMagic.min.js', array(),'1.1', true);

  wp_register_script('scrollmagic_indicators_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/debug.addIndicators.min.js', array(),'1.1', true);
  wp_enqueue_script('scrollmagic_indicators_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/debug.addIndicators.min.js', array(),'1.1', true);

  wp_register_script('animation_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/animation.gsap.min.js', array(),'1.1', true);
  wp_enqueue_script('animation_script', get_template_directory_uri() . 'js/scrollmagic/minified/plugins/animation.gsap.min.js', array(),'1.1', true);

	wp_enqueue_script( 'virtual_museum-menuToggle', get_template_directory_uri() . '/js/menuToggle.js', array(), '20151215', true );
	if(is_page_template('Fastnachtsband.php')){
		wp_enqueue_script( 'virtual_museum-submenuToggle', get_template_directory_uri() . '/js/submenutoggle.js', array(), '20151215', true );
	}
	wp_enqueue_script( 'virtual_museum-audio-fade', get_template_directory_uri() . '/js/audio_fade.js', array(), '20151215', true );
	//wp_enqueue_script( 'virtual_museum-theme', get_template_directory_uri() . '/js/theme.js', array(), '20151215', true );

    if (!is_admin()) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js');
        wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-ui-1.12.1/jquery-ui.min.js');
        wp_enqueue_script( 'jquery' );
				wp_enqueue_script('masonry');
}

	wp_enqueue_script( 'virtual_museum-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'virtual_museum-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
  wp_enqueue_script( 'virtual_museum-jssor-slider', get_template_directory_uri() . '/js/jssor.slider-27.1.0.min.js', array(), '20151215', true );
  wp_enqueue_script( 'virtual_museum-main-script', get_template_directory_uri() . '/js/main.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.1', true );
	wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '3.0.1', 'all' );
	wp_enqueue_script( 'bootstrap-js' );
	wp_enqueue_style( 'bootstrap-css' );
	wp_enqueue_style( 'virtual_museum-style', get_stylesheet_uri());
}
add_action( 'wp_enqueue_scripts', 'virtual_museum_scripts' );




/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
*	allow to upload svg-format on media library
*/
function kb_svg ( $svg_mime ){
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}

add_filter( 'upload_mimes', 'kb_svg' );
