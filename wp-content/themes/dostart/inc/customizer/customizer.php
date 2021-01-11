<?php

/**
 * dostart Theme Customizer
 *
 * @package dostart
 */

if ( ! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * Customizer Loader
 */

if ( class_exists('Kirki') ) {

    Kirki::add_config( 'theme_config_id', array(
        'capability'  => 'edit_theme_options',
        'option_type' => 'theme_mod',
    ) );


    /*=======================================================================*/
    /* [ General Settings ]
    /*=======================================================================*/

    Kirki::add_panel( 'dostart_general_settings', array(
        'priority' => 19,
        'title'    => esc_html__( 'General Settings', 'dostart' ),
    ) );

    /*---------------------------------
      [ Basic Settings ]  
     --------------------------------*/
    Kirki::add_section( 'dostart_basic_settings', array(
        'priority' => 30,
        'title'    => __('Basic Settings', 'dostart'),
        'priority' => 30,
        'panel'    => 'dostart_general_settings',
    ) );
    Kirki::add_field( 'theme_config_id', [
        'type'      => 'typography',
        'settings'  => 'dostart_typography_setting',
        'label'     => esc_html__( 'Control Label', 'dostart' ),
        'section'   => 'dostart_basic_settings',
        'default'   => [
            'font-family'    => 'Roboto',
            'variant'        => 'regular',
            'font-size'      => '14px',
            'line-height'    => '1.5',
            'letter-spacing' => '0',
            'color'          => '#666666',
            'text-transform' => 'none',
            'text-align'     => 'left',
        ],
        'priority'  => 10,
        'transport' => 'auto',
        'output'    => [
            [
                'element' => 'body',
            ],
        ],
    ] );
     //------Theme Layouts -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'switch',
        'settings' => 'dostart_theme_layout',
        'label'    => esc_html__( 'Box Layouts', 'dostart' ),
        'section'  => 'dostart_basic_settings',
        'default'  => 'off',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'dostart' ),
            'off' => esc_html__( 'Disable', 'dostart' ),
        ],
    ] );

    /*---------------------------------
      [ Social Media Icons ]  
     --------------------------------*/
    Kirki::add_section( 'dostart_social_icons', array(
        'priority'    => 30,
        'title'       => __('Social Media Icons', 'dostart'),
        'description' => __('Social Media links', 'dostart'),
        'priority'    => 30,
        'panel'       => 'dostart_general_settings',
    ) );

    //------Facebook Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'checkbox',
        'settings' => 'social_open_new_tab',
        'label'    => esc_html__('Open New Tab', 'dostart'),
        'section'  => 'dostart_social_icons',
        'priority' => 10,
    ] ); 

    //------Facebook Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_facebook',
        'label'           => esc_html__('Facebook', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_facebook' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );

    //------Twitter Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_twitter',
        'label'           => esc_html__('Twitter', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_twitter' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );

    //------Youtube Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_youtube',
        'label'           => esc_html__('Youtube', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_youtube' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );

    //------Pinterest Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_pinterest',
        'label'           => esc_html__('Pinterest', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_pinterest' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );

    //------Behance Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_behance',
        'label'           => esc_html__('Behance', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_behance' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );


   //------Linkedin Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_linkedin',
        'label'           => esc_html__('Linkedin', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_linkedin' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] ); 

    //------Instagramm Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'link',
        'settings'        => 'dostart_social_instagram',
        'label'           => esc_html__('Instagramm', 'dostart'),
        'section'         => 'dostart_social_icons',
        'priority'        => 10,
        // 'transport' => 'postMessage',    
        'partial_refresh' => array(
            'dostart_social_instagram' => array(
                'selector'        => '.footer-social-icon',
                'render_callback' => '__return_false',
            ),
        ),
    ] );


    /*---------------------------------
         [ Theme Global Color ]
     -------------------------------*/
     Kirki::add_section( 'colors', array(
		 'priority' => 30,
		 'title'    => __('Colors', 'dostart'),
		 'panel'    => 'dostart_general_settings',
	 ) );

     //----Theme Primary Color --------*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'color',
        'settings' => 'dostart_theme_primary_color',
        'label'    => __('Theme Primary Color', 'dostart'),
        'section'  => 'colors',
        'default'  => '#065FD4',
        // 'transport'   => 'postMessage',
    ] );

    //------Theme Title Color -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'color',
        'settings' => 'dostart_theme_title_color',
        'label'    => __('Theme Title Color', 'dostart'),
        'section'  => 'colors',
        'default'  => '#212121',
        // 'transport'   => 'postMessage',
    ] );


   //------Back To Top Background -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'color',
        'settings' => 'dostart_backtotop_bg',
        'label'    => __('Back To Top Background', 'dostart'),
        'section'  => 'colors',
        'default'  => '#065FD4',
        // 'transport'   => 'postMessage',
    ] );



    /*=======================================================================*/
    /* [ Header ]
    /*=======================================================================*/

    Kirki::add_panel( 'dostart_header', array(
        'priority' => 19,
        'title'    => esc_html__( 'Header', 'dostart' ),
    ) );

     /*---------------------------------
      [ Primary Menu ]  
     --------------------------------*/
    Kirki::add_section( 'dostart_primary_menu', array(
        'priority' => 30,
        'title'    => __('Primary Menu', 'dostart'),
        'priority' => 30,
        'panel'    => 'dostart_header',
    ) );

    //------Primary Menu Color -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'color',
        'settings' => 'dostart_primary_menu_color',
        'label'    => __('Menu Text Color', 'dostart'),
        'section'  => 'dostart_primary_menu',
        'default'  => '#333',
        // 'transport'   => 'postMessage',
    ] );

    //------Primary Menu Icon -----*/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'switch',
        'settings' => 'dostart_menu_arrow_down',
        'label'    => esc_html__( 'Menu Icon', 'dostart' ),
        'section'  => 'dostart_primary_menu',
        'default'  => '1',
        'priority' => 10,
        'choices'  => [
            'on'  => esc_html__( 'Enable', 'dostart' ),
            'off' => esc_html__( 'Disable', 'dostart' ),
        ],
    ] );




    /*=======================================================================-*/
         /* [ Footer Customizer ]
    /*========================================================================*/

    Kirki::add_section( 'dostart_footer', array(
        'priority' => 30,
        'title'    => __('Footer', 'dostart'),
    ) );

     //----- Footer Widget Background ------/
    Kirki::add_field( 'theme_config_id', [
        'type'     => 'color',
        'settings' => 'dostart_footer_widget_bg',
        'label'    => __('Footer Widget Background', 'dostart'),
        'section'  => 'dostart_footer',
        'default'  => '#2f2e2e',
    ] );

    //------- Footer Background ---------/
     Kirki::add_field( 'theme_config_id', [
		 'type'      => 'color',
		 'settings'  => 'dostart_footer_bg',
		 'label'     => __('Footer Background', 'dostart'),
		 'section'   => 'dostart_footer',
		 'default'   => '#222222',
		 'transport' => 'postMessage',
	 ] );

    //------- Footer text color ---------/
     Kirki::add_field( 'theme_config_id', [
		 'type'     => 'color',
		 'settings' => 'dostart_copyright_text_color',
		 'label'    => __('Copyright Text Color', 'dostart'),
		 'section'  => 'dostart_footer',
		 'default'  => '#666666',
	 ] );

     //-----  Copyright Text ---------/
    Kirki::add_field( 'theme_config_id', [
        'type'            => 'editor',
        'settings'        => 'dostart_copyright_text',
        'label'           => esc_html__('Copyright Text', 'dostart'),
        'section'         => 'dostart_footer',
        'default'         => esc_html__( '© Powered by WordPress 2020', 'dostart' ),
        'priority'        => 10,
        'transport'       => 'postMessage',
		'partial_refresh' => array(
			'dostart_footer' => array(
				'selector'        => '.copyright-text',
				'render_callback' => '__return_false',
			),
		),
    ] );

    
}



if ( ! class_exists('Dostart_Customizer') ) {

    /**
     * Declear Class
     */
    class Dostart_Customizer
    {

        /**
         * Instance
         *
         * @access private
         * @var object
         */
        private static $instance;

        /**
         * making instatance of the class
         */
        public static function get_instance() {
            if ( ! isset(self::$instance) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         */
        public function __construct() {
            add_action('customize_preview_init', array( $this, 'dostart_customize_preview_js' ));
            add_action('customize_register', array( $this, 'dostart_customize_register' ));
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */

        public function dostart_customize_register( $wp_customize ) {

            /**
             * Move Default Section
             */
            $wp_customize->get_section('header_image')->panel     = 'dostart_header';
            $wp_customize->get_section('colors')->panel           = 'dostart_general_settings';
            $wp_customize->get_section('title_tagline')->panel    = 'dostart_header';
            $wp_customize->get_section('background_image')->panel = 'dostart_general_settings';

        }


        /**
         * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
         */
        public function dostart_customize_preview_js() { 
        wp_enqueue_script('dostart-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), DOSTART_THEME_VERSION, true);
        }

    }
}

/**
 *  calling class by get_instance()
 */

Dostart_Customizer::get_instance();








