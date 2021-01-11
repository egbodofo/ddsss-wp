<?php
/**
 * Plugin Name: WP Hotel Booking Room
 * Plugin URI: http://thimpress.com/
 * Description: Support book room without search room
 * Author: ThimPress
 * Author URI: http://thimpress.com
 * Version: 1.8.2
 * Text Domain: wp-hotel-booking-room
 * Domain Path: /languages/
 * Tags: wphb
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

define( 'WPHB_BOOKING_ROOM_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPHB_BOOKING_ROOM_URI', plugin_dir_url( __FILE__ ) );
define( 'WPHB_BOOKING_ROOM_INC', WPHB_BOOKING_ROOM_PATH . 'inc' );
define( 'WPHB_BOOKING_ROOM_TEMPLATES', WPHB_BOOKING_ROOM_PATH . 'templates/' );
define( 'WPHB_BOOKING_ROOM_VER', '1.8.2' );

if ( ! class_exists( 'WP_Hotel_Booking_Room' ) ) {
	/**
	 * Class WP_Hotel_Booking_Room
	 */
	class WP_Hotel_Booking_Room {

		/**
		 * @var null
		 */
		static $instance = null;

		/**
		 * @var bool
		 */
		public $available = false;

		/**
		 * @var null
		 */
		public $booking = null;

		/**
		 * WP_Hotel_Booking_Room constructor.
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'loaded' ) );
		}

		/**
		 * Plugin loaded.
		 */
		public function loaded() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			if ( ( class_exists( 'TP_Hotel_Booking' ) && is_plugin_active( 'tp-hotel-booking/tp-hotel-booking.php' ) ) || ( is_plugin_active( 'wp-hotel-booking/wp-hotel-booking.php' ) && class_exists( 'WP_Hotel_Booking' ) ) ) {
				$this->available = true;
			}

			if ( ! $this->available ) {
				add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			} else {
				// include files
				$this->_includes( 'functions.php' );
				$this->_includes( 'class-hb-booking-room.php' );

				// load text domain
				$this->load_textdomain();

				$this->booking = WP_Hotel_Booking_Room_Extension::instance();

				add_filter( 'hb_plugins_templates_path', array( $this, 'plugin_override_templates' ) );
			}
		}

		/**
		 * @return bool
		 */
		public function load_textdomain() {

			$prefix    = basename( WPHB_BOOKING_ROOM_PATH );
			$locale    = get_locale();
			$file_name = $prefix . '-' . $locale . '.mo';

			$file    = $plugin_file = WPHB_BOOKING_ROOM_PATH . '/languages/' . $file_name;
			$wp_file = WP_LANG_DIR . '/plugins/' . $file_name;

			if ( file_exists( $wp_file ) ) {
				$file = $wp_file;
			}

			return load_textdomain( 'wp-hotel-booking-room', $file );
		}

		/**
		 * @param string $file
		 */
		public function _includes( $file = '' ) {
			$file = WPHB_BOOKING_ROOM_INC . '/' . $file;
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}

		/**
		 * Admin notice.
		 */
		public function admin_notice() {
			?>
			<div class="error">
				<p><?php __( wp_kses( 'The <strong>WP Hotel Booking</strong> is not installed and/or activated. Please install and/or activate before you can using <strong>WP Hotel Booking Booking Room</strong> add-on.', array( 'strong' => array() ) ), 'wp-hotel-booking-room' ); ?></p>
			</div>
			<?php
		}

		public function plugin_override_templates( $plugins ) {
			if ( ! is_array( $plugins ) ) {
				return $plugins;
			}

			$plugins['wphb-booking-room'] = array(
				'folder' => 'wp-hotel-booking-room',
				'path'   => WPHB_BOOKING_ROOM_TEMPLATES
			);

			return $plugins;
		}

		/**
		 * @return null|WP_Hotel_Booking_Room
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				return self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

if ( ! function_exists( 'WP_Hotel_Booking_Room' ) ) {
	/**
	 * @return null|WP_Hotel_Booking_Room
	 */
	function WP_Hotel_Booking_Room() {
		return WP_Hotel_Booking_Room::instance();
	}
}

$GLOBALS['WP_Hotel_Booking_Room'] = WP_Hotel_Booking_Room();
