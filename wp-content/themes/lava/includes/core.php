<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* -----------------------------------------------------------------------------
 * Theme Core
 * ----------------------------------------------------------------------------- */

class Lava_Core {

	static $debug_mode = false;

	function __construct() {
		$this->constants();
		$this->includes();
		$this->hooks();
	}

	/**
	 * Setup theme constants
	 * 
	 */
	function constants() {
		if ( ! defined( 'LAVA_THEME_NAME' ) ) {
			define( 'LAVA_THEME_NAME', 'Lava' );
		}

		if ( ! defined( 'LAVA_THEME_VERSION' ) ) {
			define( 'LAVA_THEME_VERSION', '1.4.9' );
		}

		if ( ! defined( 'LAVA_THEME_DIR' ) ) {
			define( 'LAVA_THEME_DIR', get_template_directory() );
		}

		if ( ! defined( 'LAVA_THEME_URI' ) ) {
			define( 'LAVA_THEME_URI', get_template_directory_uri() );
		}

        if ( !defined( 'LAVA_ADMIN_DIR' ) ) {
            define( 'LAVA_ADMIN_DIR', get_template_directory() .'/includes/admin' );
        }

        if ( !defined( 'LAVA_ADMIN_URI' ) ) {
            define( 'LAVA_ADMIN_URI', get_template_directory_uri() .'/includes/admin' );
        }

		if ( !defined( 'LAVA_LIB_DIR' ) ) {
			define( 'LAVA_LIB_DIR', get_template_directory() .'/includes/libs' );
		}

		if ( !defined( 'LAVA_LIB_URI' ) ) {
			define( 'LAVA_LIB_URI', get_template_directory_uri() .'/includes/libs' );
		}

        if ( !defined( 'LAVA_MIN_SUFFIX' ) ) {
            if ( self::$debug_mode ) {
                define( 'LAVA_MIN_SUFFIX', '');
            } else {
                define( 'LAVA_MIN_SUFFIX', '.min');
            }
        }

		// set content width
		global $content_width;

		if ( !isset( $content_width ) ) {
			$content_width = 1200;
		}
	}

	/**
	 * Include required files
	 * 
	 */
	function includes() {
		require_once( LAVA_THEME_DIR . '/includes/helper-functions.php' );
		require_once( LAVA_THEME_DIR . '/includes/admin/customizer.php' );
		require_once( LAVA_THEME_DIR . '/includes/admin/metabox.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-util.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-megamenu.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-walker-menu.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-page.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-post-views.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-woocommerce.php' );
		require_once( LAVA_THEME_DIR . '/includes/classes/class-event-calendar.php' );
		require_once( LAVA_THEME_DIR . '/includes/actions.php' );
		require_once( LAVA_THEME_DIR . '/includes/filters.php' );
		require_once( LAVA_THEME_DIR . '/includes/template-functions.php' );
		require_once( LAVA_THEME_DIR . '/includes/template-hooks.php' );
		require_once( LAVA_THEME_DIR . '/includes/widgets/so-widgets.php' );
		require_once( LAVA_THEME_DIR . '/includes/prebuilt/prebuilt.php' );

		if ( is_admin() || is_customize_preview() ) {
			require_once( LAVA_THEME_DIR . '/includes/admin/admin.php' );
		}
	}

	/**
	 * Theme hooks
	 * 
	 */
	function hooks() {
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_scripts' ) );
		add_action( 'init', array( $this, 'register_nav_menus' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
	}

	function theme_setup() {
		// Localization.
		load_theme_textdomain( 'lava', LAVA_THEME_DIR . '/languages' );

		// Automatic feed links.
		add_theme_support( 'automatic-feed-links' );
		
		// Post formats.
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

		// Html 5 supports
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		// Woocommerce.
		add_theme_support( 'woocommerce' );

		// Menus
 		add_theme_support( 'title-tag' );

		// Post thumbnail
		add_theme_support( 'post-thumbnails' );

		// Add image sizes
		add_image_size( 'lava_thumb_x_small', 100, 100, true );
		add_image_size( 'lava_thumb_small', 540, 360, true );
		add_image_size( 'lava_thumb_gallery', 480, 400, true );
		add_image_size( 'lava_thumb_medium_s', 640, 640, true );
		add_image_size( 'lava_thumb_medium', 960, 600, true );
		add_image_size( 'lava_thumb_large', 1200, 675, true );
	}

	/**
	 * Enqueue Style & Scripts
	 *
	 */
	function theme_scripts() {
		wp_enqueue_script( 'imagesloaded' );
		
		wp_enqueue_style(
			'material-icons',
			LAVA_THEME_URI . '/assets/css/material-icons.min.css',
			false,
			LAVA_THEME_VERSION
		);

		wp_register_style(
			'slick',
			LAVA_THEME_URI . '/assets/css/slick.min.css',
			false,
			LAVA_THEME_VERSION
		);

		wp_register_style(
			'fancybox',
			LAVA_THEME_URI . '/assets/css/fancybox.min.css'
		);

		wp_register_style(
			'lava',
			LAVA_THEME_URI . '/assets/css/style' . LAVA_MIN_SUFFIX . '.css',
			false,
			LAVA_THEME_VERSION
		);

		wp_enqueue_style(
			'lava-so-widgets',
			LAVA_THEME_URI . '/assets/css/widgets'. LAVA_MIN_SUFFIX .'.css',
			false,
			LAVA_THEME_VERSION
		);

		wp_register_script(
			'jquery-placeholder',
			LAVA_THEME_URI . '/assets/lib/js/jquery.placeholder.min.js',
			array( 'jquery' ),
			'2.3.1',
			true
		);

		wp_register_script(
			'jquery-matchheight',
			LAVA_THEME_URI . '/assets/lib/js/jquery.matchHeight.min.js',
			array( 'jquery' ),
			'0.7.0',
			true
		);

		wp_register_script(
			'jquery-requestanimationframe',
			LAVA_THEME_URI . '/assets/lib/js/jquery.requestanimationframe.min.js',
			array( 'jquery' ),
			'0.2.3',
			true
		);

		wp_register_script(
			'dropkick',
			LAVA_THEME_URI . '/assets/lib/js/dropkick.min.js',
			array( 'jquery' ),
			'2.2.5',
			true
		);

    	wp_register_script(
    		'fancybox',
    		LAVA_THEME_URI . '/assets/lib/js/jquery.fancybox.min.js',
    		array( 'jquery' ),
    		LAVA_THEME_VERSION,
    		true
		);

		wp_register_script(
			'jquery-throttle-debounce',
			LAVA_THEME_URI . '/assets/lib/js/jquery.throttle-debounce.min.js',
			array( 'jquery' ),
			'1.1',
			true
		);

		wp_register_script(
			'jquery-hoverdir',
			LAVA_THEME_URI . '/assets/lib/js/jquery.hoverdir.min.js',
			array( 'jquery' ),
			'1.1.2',
			true
		);

		wp_register_script(
			'jquery-inview',
			LAVA_THEME_URI . '/assets/lib/js/jquery.inview.min.js',
			array( 'jquery' ),
			'1.0',
			true
		);

		wp_register_script(
			'jquery-superfish',
			LAVA_THEME_URI . '/assets/lib/js/jquery.superfish.min.js',
			array( 'jquery' ),
			'1.7.10',
			true
		);

		wp_register_script(
			'jquery-fitvids',
			LAVA_THEME_URI . '/assets/lib/js/jquery.fitvids.min.js',
			array( 'jquery' ),
			'1.1',
			true
		);

		wp_register_script(
			'resize-sensor',
			LAVA_THEME_URI . '/assets/lib/js/ResizeSensor.min.js',
			array(),
			null,
			true
		);

		wp_register_script(
			'theia-sticky-sidebar',
			LAVA_THEME_URI . '/assets/lib/js/theia-sticky-sidebar.min.js',
			array( 'jquery', 'resize-sensor' ),
			'1.7.0',
			true
		);

		wp_register_script(
			'lava-modernizr',
			LAVA_THEME_URI . '/assets/lib/js/modernizr.js',
			array(),
			'3.6.0',
			true
		);

		wp_register_script(
			'slick',
			LAVA_THEME_URI . '/assets/lib/js/slick.min.js',
			array( 'jquery' ),
			'1.6.0',
			true
		);

		wp_register_script(
			'lava-sliders',
			LAVA_THEME_URI . '/assets/js/sliders' . LAVA_MIN_SUFFIX . '.js',
			array( 'jquery', 'slick' ),
			LAVA_THEME_VERSION,
			true
		);

		wp_register_script(
			'lava',
			LAVA_THEME_URI . '/assets/js/lava' . LAVA_MIN_SUFFIX . '.js',
			array(
				'jquery',
				'jquery-throttle-debounce',
				'jquery-matchheight',
				'jquery-placeholder',
				'jquery-fitvids',
				'jquery-requestanimationframe',
				'jquery-hoverdir',
				'jquery-inview',
				'jquery-superfish',
				'imagesloaded',
				'dropkick',
				'theia-sticky-sidebar',
				'resize-sensor',
				'lava-modernizr',
			),
			LAVA_THEME_VERSION,
			true
		);

		wp_enqueue_style( 'lava' );
		wp_style_add_data( 'lava', 'rtl', 'replace' );

		wp_enqueue_script( 'lava' );
		wp_localize_script( 'lava', 'lava_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		if ( is_single() ) {
			if ( !Lava_Util::get_option( 'single_hide_comments', false ) && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		} elseif ( is_page() && !is_front_page() ) {
			if ( !Lava_Util::get_option( 'page_hide_comments', false ) && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		if ( is_singular( 'hb_room' ) ) {
			wp_enqueue_style( 'slick' );
			wp_enqueue_script( 'lava-sliders' );
			wp_enqueue_style( 'fancybox' );
			wp_enqueue_script( 'fancybox' );
		}

		if ( !is_admin() || !is_customize_preview() ) {
			wp_dequeue_style( 'wp-hotel-booking' );
			wp_dequeue_style( 'wp-hotel-booking-libaries-style' );
			wp_dequeue_style( 'wp-hotel-booking-room' );
			wp_dequeue_style( 'wphb-extra-css' );
			wp_dequeue_style( 'magnific-popup' );
			wp_dequeue_script( 'wp-hotel-booking-gallery' );
			wp_dequeue_script( 'wp-hotel-booking-owl-carousel' );
		}
	}

	/**
	 * Register Menu locations
	 * 
	 */
	function register_nav_menus() {
		register_nav_menus( array(
			'main' => esc_html__( 'Main Menu', 'lava' ),
			'fullscreen' => esc_html__( 'Fullscreen Menu', 'lava' ),
			'left' => esc_html__( 'Left Menu', 'lava' ),
			'right' => esc_html__( 'Right Menu', 'lava' )
		));
	}

	/**
	 * Register Sidebars
	 * 
	 */
	function register_sidebars() {
		// register default sidebar
		register_sidebar( array(
			'name'          => esc_html__( 'Default Sidebar', 'lava' ),
			'id'            => 'default-sidebar',
			'description'   => esc_html__( 'The default sidebar for all templates.', 'lava' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="section-heading">',
			'after_title'   => '</h3>',
		));

		// register footer widget areas
		$columns = 4; $i = 0;

		while ( $i < $columns ) { $i++;
			register_sidebar( array(
				'name'          => esc_html__( 'Footer Area', 'lava' ) . ' ' . $i,
				'id'            => 'footer-' . $i,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="section-heading">',
				'after_title'   => '</h3>'
				)
			);
		}

		if ( class_exists( 'WP_Hotel_Booking' ) ) {
			// register hotel booking sidebar
			register_sidebar( array(
				'name'          => esc_html__( 'Hotel Booking Sidebar', 'lava' ),
				'id'            => 'hb-sidebar',
				'before_widget' => '<div id="%1$s" class="%2$s widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="section-heading">',
				'after_title'   => '</h3>',
			));
		}

		if ( class_exists( 'WooCommerce' ) ) {
			// register woocommerce sidebar
			register_sidebar( array(
				'name'          => esc_html__( 'WooCommerce Sidebar', 'lava' ),
				'id'            => 'wc-sidebar',
				'before_widget' => '<div id="%1$s" class="%2$s widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="section-heading">',
				'after_title'   => '</h3>',
			));
		}

		if ( defined( 'TRIBE_EVENTS_FILE' ) ) {
			// register woocommerce sidebar
			register_sidebar( array(
				'name'          => esc_html__( 'Event Sidebar', 'lava' ),
				'id'            => 'ec-sidebar',
				'before_widget' => '<div id="%1$s" class="%2$s widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="section-heading">',
				'after_title'   => '</h3>',
			));
		}

		$custom_widget_areas = get_option( 'lava_widget_areas' );
		
		if ( $custom_widget_areas ) {
			foreach ( $custom_widget_areas as $id => $data ) {
				register_sidebar( array( 
					'name'          => esc_html( $data['name'] ),
					'id'            => esc_attr( $id ),
					'description'	=> esc_html( $data['desc'] ),
					'before_widget' => '<div id="%1$s" class="%2$s widget '. esc_attr( $id ) .'">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				 ) );
			}
		}
	}
}

new Lava_Core();