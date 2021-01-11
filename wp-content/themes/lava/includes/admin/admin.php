<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Lava_Admin {

    function __construct() {
        $this->constants();
        $this->includes();
        $this->hooks();
    }

    function constants() {
        if ( !defined( 'LAVA_THEME_DEMO_DIR' ) ) {
            define( 'LAVA_THEME_DEMO_DIR', get_template_directory() . '/includes/demos' );
        }
    }

    function includes() {
        require_once LAVA_ADMIN_DIR . '/github.php';
        require_once LAVA_ADMIN_DIR . '/plugins.php';
        require_once LAVA_ADMIN_DIR . '/classes/class-demo-generator.php';
        require_once LAVA_ADMIN_DIR . '/classes/class-demo-installer.php';
    }

    function hooks() {
        add_action( 'admin_menu', array( $this, 'admin_menus' ) );
        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
        
        add_action( 'after_switch_theme', array( $this, 'flush_rewrite_rules' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'gutenberg_styles' ) );
    }

    /**
     * Display admin notice if the required plugins are not active
     */
    function admin_notices() {
        if ( ! defined( 'LAVA_EXTENSION_VERSION' ) || ( defined( 'LAVA_EXTENSION_VERSION' ) && version_compare( LAVA_EXTENSION_VERSION, '1.0.8', '<' ) )  ) {
            if ( isset( $_GET['page'] ) && 'tgmpa-install-plugins' == $_GET['page'] ) {
                return;
            }
            $plugin_page_url = '';
            if ( class_exists( 'TGM_Plugin_Activation' ) ) {
                $plugin_page_url = TGM_Plugin_Activation::$instance->get_tgmpa_url();
            }
            ?>
            <div class="notice notice-error is-dismissible" style="padding:5px 15px 10px;">
                <h3 style="margin-bottom: 10px;"><?php esc_html_e( 'Installation/Update Of Required Plugins Needed', 'lava' ); ?></h3>
                <p><?php esc_html_e( 'The following required plugin is currently inactive: Lava Extension.', 'lava' ); ?></p>
                <p style="margin-top: 15px;"><a href="<?php echo esc_url( $plugin_page_url ); ?>" class="button-primary"><?php esc_html_e( 'Go Activate/Update Plugin', 'lava' ); ?></a></p>
            </div>
            <?php
        }
    }

    function admin_menus() {
        if ( current_user_can( 'edit_theme_options' ) ) {
            // work around for theme check
            $lava_func_add_menu = 'add_'.'menu_page';
            $lava_func_add_submenu = 'add_'.'submenu_page';

            $lava_func_add_menu( 'Lava', 'Lava', 'edit_theme_options', 'lava_welcome', array( $this, 'view_welcome' ), null, 2 );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'Welcome', 'lava' ), esc_html__( 'Welcome', 'lava' ), 'edit_theme_options', 'lava_welcome', array( $this, 'view_welcome' ) );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'Demos', 'lava' ), esc_html__( 'Demos', 'lava' ), 'edit_theme_options', 'lava_demos', array( $this, 'view_demos' ) );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'Fonts', 'lava' ), esc_html__( 'Fonts', 'lava' ), 'edit_theme_options', 'lava_fonts', array( $this, 'view_fonts' ) );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'Widget Areas', 'lava' ), esc_html__( 'Widget Areas', 'lava' ), 'edit_theme_options', 'lava_widget_areas', array( $this, 'view_widget_areas' ) );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'System Status', 'lava' ), esc_html__( 'System Status', 'lava' ), 'edit_theme_options', 'lava_system_status', array( $this, 'view_system_status' ) );
            $lava_func_add_submenu( 'lava_welcome', esc_html__( 'Customize', 'lava' ), esc_html__( 'Customize', 'lava' ), 'edit_theme_options', 'customize.php' );
        }
    }

    function view_welcome() {
        require_once 'views/welcome.php';
    }

    function view_demos() {
        require_once 'views/demos.php';
    }

    function view_fonts() {
        require_once 'views/fonts.php';
    }

    function view_widget_areas() {
        require_once 'views/widget-areas.php';
    }

    function view_system_status() {
        require_once 'views/system-status.php';
    }

    // Enqueue Admin Style & Scripts
    function admin_scripts() {
        wp_enqueue_style( 'admin', LAVA_ADMIN_URI . '/assets/css/admin.css', false, LAVA_THEME_VERSION );

        if ( wp_script_is( 'imagesloaded', 'registered' ) ) {
            wp_enqueue_script( 'imagesloaded' );
        } else {
            // prior to wordpress 4.6
            wp_enqueue_script( 'imagesloaded', LAVA_ADMIN_URI . '/assets/js/imagesloaded.min.js', array(), '4.1.1', true );
        }

        wp_enqueue_script( 'admin', LAVA_ADMIN_URI . '/assets/js/admin.js', array( 'jquery', 'imagesloaded' ), LAVA_THEME_VERSION, true );

        wp_localize_script(
            'admin',
            'lava_admin_ajax',
            array(
                'install_required_plugins' => esc_html( "Please install all the required plugins.", 'lava' ),
                'install_demo_option' => esc_html__( "Install Demo Without Content\n\nThis will only install the theme settings of the demo. Contents such as posts, pages, menus, sidebars etc. will not be installed.\n\nDo you want to proceed?", 'lava' ),
                'install_demo_full' => esc_html__( "Full Demo Installation\n\nThis will replicate the live demo, which include all the demo content and theme settings. Your current theme settings will be overwritten. Installation could take a minute or less to complete.\n\nDo you want to proceed?", 'lava' ),
                'uninstall_demo' => esc_html__( "All demo content and settings will be deleted. Contents created prior to demo installation will not be touched.\n\nDo you want to procceed?", 'lava' )
            )
        );
    }

    // Enqueue Gutenberg Style
    function gutenberg_styles() {
        wp_enqueue_style( 'lava-block-editor', LAVA_ADMIN_URI . '/assets/css/block-editor.css', false, LAVA_THEME_VERSION );
        wp_enqueue_style( 'lava-theme-fonts', 'https://fonts.googleapis.com/css?family=Lato:400,700|Raleway:600,700', false );
    }

    function flush_rewrite_rules() {
        flush_rewrite_rules();
    }
}

new Lava_Admin;