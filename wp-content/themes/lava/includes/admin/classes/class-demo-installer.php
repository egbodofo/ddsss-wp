<?php
require_once 'class-demo-generator.php';

class Lava_Demo_Installer {

	function __construct() {
		add_action( 'wp_ajax_lava_check_plugins', array( $this, 'check' ) );
		add_action( 'wp_ajax_lava_demo_installer', array( $this, 'run' ) );
	}

	function check() {
		$plugin_ready = false;

		if ( defined( 'LAVA_EXTENSION_VERSION' ) &&
			class_exists( 'SiteOrigin_Panels' ) &&
			class_exists( 'SiteOrigin_Widgets_Bundle' ) &&
			class_exists( 'WP_Hotel_Booking' ) ) {
			$plugin_ready = true;
		}

		echo json_encode( array( 'plugin_ready' => $plugin_ready ) );
		
		exit;
	}

	function run() {
		set_time_limit( 300 );

		$demo_action = isset( $_POST['demo_action'] ) ? sanitize_text_field( $_POST['demo_action'] ) : '';

		if ( $demo_action === 'install' ) {

			$demo_id = isset( $_POST['demo_id'] ) ? sanitize_text_field( $_POST['demo_id'] ) : '';
			$demo_content = isset( $_POST['demo_content'] ) ? sanitize_text_field( $_POST['demo_content'] ) : '';

			// we save all demo info in option lava_demo
			$demo_option = get_option( 'lava_demo' );
			$content_installed = isset( $demo_option['content_installed'] ) ? (bool) $demo_option['content_installed'] : false;
			
			// if demo content exist, first remove it
			if ( $content_installed == true ) {
				Lava_Demo_Generator::delete_content();
			}

			// do not save the theme option for if there is an existing demo installation
			$save_option_for_restore = true;
			if ( !empty( $demo_option['id'] ) ) {
				$save_option_for_restore = false;
			}

			// load theme options
			Lava_Demo_Generator::load_theme_options( LAVA_THEME_DEMO_DIR .'/'. $demo_id .'/options.json', $save_option_for_restore );

			// install contents if include is checked
			if ( $demo_content == 'include' ) {
				get_template_part( 'includes/demos/' . $demo_id . '/content' );
				$content_installed = true;
			} else {
				$content_installed = false;
			}

			// update demo options
			$demo_option = get_option( 'lava_demo' );
			$demo_option['id'] = $demo_id;
			$demo_option['content_installed'] = $content_installed;
			update_option( 'lava_demo', $demo_option );
			
		} else if ( $demo_action === 'uninstall' ) {
			Lava_Demo_Generator::restore_theme_options();
			Lava_Demo_Generator::delete_content();
			$demo_option = get_option( 'lava_demo' );
			$demo_option['id'] = '';
			$demo_option['content_installed'] = false;
			update_option( 'lava_demo', $demo_option );
		}

		exit;
	}

}
new Lava_Demo_Installer();