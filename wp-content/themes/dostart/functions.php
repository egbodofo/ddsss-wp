<?php
/**
 * dostart functions and definitions
 */

if ( ! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */

define('DOSTART_THEME_VERSION', wp_get_theme()->get('Version'));
define('DOSTART_THEME_DIR', trailingslashit(get_template_directory()));
define('DOSTART_THEME_URI', trailingslashit(esc_url(get_template_directory_uri())));

if ( ! function_exists('dostart_theme_setup') ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function dostart_theme_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on dostart, use a find and replace
         * to change 'dostart to the name of your theme in all the template files.
         */
        load_theme_textdomain('dostart', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        add_image_size('dostart-thumb', 740, 367, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'primary' => esc_html__('Primary Menu', 'dostart'),
            )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'dostart_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style('assets/css/editor-style.css');

        add_theme_support("custom-header");

        /**
         * Yost seo support added for theme
         */
        add_theme_support( 'yoast-seo-breadcrumbs' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 40,
                'width'       => 200,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        /**
         * Woocommerce Support.
         * Product Gallery | Product Lightbox | Product Slider
         */
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        /**
         * Post Excerpt Length
         **/

        function dostart_custom_excerpt_length( $length ) {
            if ( is_admin() ) {
                return $length;
            }

            return 50;
        }
        add_filter('excerpt_length', 'dostart_custom_excerpt_length', 999);
    }
endif;
add_action('after_setup_theme', 'dostart_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dostart_content_width() {
    $GLOBALS['content_width'] = apply_filters('dostart_content_width', 640);
}
add_action('after_setup_theme', 'dostart_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dostart_widgets_setup() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'dostart'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'dostart'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer Widgets', 'dostart'),
            'id'            => 'footer-widgets',
            'description'   => esc_html__('Add footer widgets here.', 'dostart'),
            'before_widget' => '<div class="col-md-3 col-sm-6"><div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'dostart_widgets_setup');

/**
 * Enqueue scripts and styles.
 */
function dostart_load_style_and_scripts() {

    // Define Direcotry URI
    $dir = DOSTART_THEME_URI;

    wp_enqueue_style('bootstrap', $dir . '/assets/css/bootstrap.css', array(), DOSTART_THEME_VERSION);
    wp_enqueue_style('font-awesome-all', $dir . '/assets/css/all.min.css', array(), DOSTART_THEME_VERSION);
    wp_enqueue_style('font-awesome-min', $dir . '/assets/css/fontawesome.min.css', array(), DOSTART_THEME_VERSION);
    wp_enqueue_style('hc-offcanvas', $dir . '/assets/css/hc-offcanvas-nav.min.css', array(), DOSTART_THEME_VERSION);
    wp_enqueue_style('dostart-default', $dir . '/assets/css/default.min.css', array(), DOSTART_THEME_VERSION);
    wp_enqueue_style('dostart-theme', $dir . '/assets/css/style.min.css', array(), DOSTART_THEME_VERSION);

    wp_enqueue_style('dostart-style', get_stylesheet_uri(), array(), DOSTART_THEME_VERSION);

    wp_enqueue_script('skip-link-focus-fix', $dir . '/assets/js/skip-link-focus-fix.js', array( 'jquery' ), DOSTART_THEME_VERSION, true);
    wp_enqueue_script('navigation', $dir . '/assets/js/navigation.js', array( 'jquery' ), DOSTART_THEME_VERSION, true);
    wp_enqueue_script('hc-offcanvas', $dir . '/assets/js/hc-offcanvas-nav.js', array( 'jquery' ), DOSTART_THEME_VERSION, true);
    wp_enqueue_script('dostart-active', $dir . '/assets/js/active.js', array( 'jquery' ), DOSTART_THEME_VERSION, true);

    if ( is_singular() && comments_open() && get_option('thread_comments') ) {

        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'dostart_load_style_and_scripts');

/**
 * Custom template tags for this theme.
 */
require DOSTART_THEME_DIR . '/inc/template-tags.php';

/**
 * Required plugin installer
 */
require DOSTART_THEME_DIR . '/inc/required-plugins.php';

/**
 * Custom Header
 */

require DOSTART_THEME_DIR . '/inc/custom-header.php';

/**
 * customizer
 */
require DOSTART_THEME_DIR . '/inc/customizer/customizer.php';

/**
 * WooCommerce
 */
if ( class_exists('WooCommerce') ) {
    require_once DOSTART_THEME_DIR . '/inc/class/woocommerce.php';
}

/**
 * Walker Menu
//  
*/
require DOSTART_THEME_DIR . '/inc/walker/init.php';
require DOSTART_THEME_DIR . '/inc/walker/menu-walker.php';
