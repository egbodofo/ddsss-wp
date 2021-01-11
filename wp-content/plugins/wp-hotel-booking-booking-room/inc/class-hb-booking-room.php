<?php
/**
 * HB_Report_Room
 *
 * @author   ThimPress
 * @package  WP-Hotel-Booking/Booking-Room/Classes
 * @version  1.7.2
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Hotel_Booking_Room_Extension' ) ) {
	/**
	 * Class WP_Hotel_Booking_Room_Extension
	 */
	class WP_Hotel_Booking_Room_Extension {

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * WP_Hotel_Booking_Room_Extension constructor.
		 */
		public function __construct() {
			add_action( 'hb_admin_settings_tab_after', array( $this, 'admin_settings' ) );

			$this->init();
		}

		// add admin setting
		public function admin_settings( $tab ) {
			if ( $tab !== 'room' ) {
				return;
			}
			$settings = hb_settings(); ?>

			<table class="form-table">
				<tr>
					<th><?php _e( 'Enable book in single room', 'wp-hotel-booking-room' ); ?></th>
					<td>
						<input type="hidden"
						       name="<?php echo esc_attr( $settings->get_field_name( 'enable_single_book' ) ); ?>"
						       value="0" />
						<input type="checkbox"
						       name="<?php echo esc_attr( $settings->get_field_name( 'enable_single_book' ) ); ?>" <?php checked( $settings->get( 'enable_single_book' ) ? 1 : 0, 1 ); ?>
						       value="1" />
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Init.
		 */
		public function init() {
			if ( ! hb_settings()->get( 'enable_single_book', 0 ) ) {
				return;
			}

			add_action( 'hotel_booking_single_room_title', array( $this, 'single_add_button' ), 9 );

			add_action( 'wp_footer', array( $this, 'wp_footer' ) );
			// enqueue script
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

			add_action( 'wp_ajax_check_room_availabel', array( $this, 'check_room_availabel' ) );
			add_action( 'wp_ajax_nopriv_check_room_availabel', array( $this, 'check_room_availabel' ) );

			add_filter( 'hotel_booking_add_to_cart_results', array( $this, 'add_to_cart_redirect' ), 10, 2 );

			add_action( 'wp_ajax_hotel_booking_single_check_room_available', array(
				$this,
				'hotel_booking_single_check_room_available'
			) );
			add_action( 'wp_ajax_nopriv_hotel_booking_single_check_room_available', array(
				$this,
				'hotel_booking_single_check_room_available'
			) );
		}

		/**
		 * Single search button.
		 */
		public function single_add_button() {
			ob_start();
			$this->get_template( 'single-search-button.php' );
			$html = ob_get_clean();
			echo $html;
		}

		/**
		 * WP Footer.
		 */
		public function wp_footer() {
			$html = array();
			ob_start();
			// search form.
			$this->get_template( 'single-search-available.php' );
			// book form.
			$this->get_template( 'single-book-room.php' );
			$html[] = ob_get_clean();
			echo implode( '', $html );
		}

		/**
		 * Enqueue script.
		 */
		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'magnific-popup', WPHB_BOOKING_ROOM_URI . 'inc/libraries/magnific-popup/jquery.magnific-popup.min.js', array(), '1.0.0', true );

			wp_enqueue_style( 'magnific-popup', WPHB_BOOKING_ROOM_URI . 'inc/libraries/magnific-popup/magnific-popup.css', array(), '1.0.0' );

			wp_enqueue_style( 'wp-hotel-booking-room', WPHB_BOOKING_ROOM_URI . 'assets/css/site.min.css', array(), WPHB_BOOKING_ROOM_VER );
			wp_register_script( 'wp-hotel-booking-room', WPHB_BOOKING_ROOM_URI . 'assets/js/site.js', array(), false, true );
			//wp_enqueue_script( 'wp-hotel-booking-room', WPHB_BOOKING_ROOM_URI . 'assets/js/site.js', array(), WPHB_BOOKING_ROOM_VER );
			$l10n = apply_filters( 'hote_booking_blocked_days_l10n', array(
				'blocked_days'    => wp_hote_booking_blocked_days()
			) );
			wp_localize_script( 'wp-hotel-booking-room', 'Hotel_Booking_Blocked_Days', $l10n );
			wp_enqueue_script( 'wp-hotel-booking-room' );
		}

		/**
		 * Check room available.
		 */
		public function check_room_availabel() {
			// ajax referer
			if ( ! isset( $_POST['check-room-availabel-nonce'] ) || ! check_ajax_referer( 'check_room_availabel_nonce', 'check-room-availabel-nonce' ) ) {
				return;
			}

			$room_id = false;
			if ( isset( $_POST['hotel_booking_room_id'] ) && is_numeric( $_POST['hotel_booking_room_id'] ) ) {
				$room_id = absint( $_POST['hotel_booking_room_id'] );
			}

			$check_in_date = isset( $_POST['hotel_booking_room_check_in_timestamp'] ) ? sanitize_text_field( $_POST['hotel_booking_room_check_in_timestamp'] ) : '';
			$check_in_date = (int) $check_in_date + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

			$check_out_date = isset( $_POST['hotel_booking_room_check_out_timestamp'] ) ? sanitize_text_field( $_POST['hotel_booking_room_check_out_timestamp'] ) : '';
			$check_out_date = (int) $check_out_date + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

			$args = apply_filters( 'hotel_booking_query_room_available', array(
				'room_id'        => $room_id,
				'check_in_date'  => $check_in_date,
				'check_out_date' => $check_out_date
			) );
			// get available room qty
			$available = hotel_booking_get_qty( $args );

			if ( ! is_wp_error( $available ) ) {
				wp_send_json( array(
					'status'         => true,
					'qty'            => $available,
					'check_in_date'  => date( 'm/d/Y', $check_in_date ),
					'check_out_date' => date( 'm/d/Y', $check_out_date )
				) );
				die();
			} else {
				wp_send_json( array( 'status' => false, 'message' => $available->get_error_message() ) );
				die();
			}
		}

		/**
		 * @param $param
		 * @param $room
		 *
		 * @return mixed
		 */
		public function add_to_cart_redirect( $param, $room ) {
			if ( isset( $param['status'] ) && $param['status'] === 'success' && isset( $_POST['is_single'] ) && $_POST['is_single'] ) {
				$param['redirect'] = hb_get_cart_url();
			}

			return $param;
		}

		/*
		 * Template path.
		 */
		public function template_path() {
			return apply_filters( 'hb_room_addon_template_path', 'wp-hotel-booking-room' );
		}

		/**
		 * Get template part
		 *
		 * @param        $slug
		 * @param string $name
		 *
		 * @return mixed|string
		 */
		public function get_template_part( $slug, $name = '' ) {
			$template = '';

			// Look in yourtheme/slug-name.php and yourtheme/wp-hotel-booking-room/slug-name.php
			if ( $name ) {
				$template = locate_template( array(
					"{$slug}-{$name}.php",
					$this->template_path() . "/{$slug}-{$name}.php"
				) );
			}

			// Get default slug-name.php
			if ( ! $template && $name && file_exists( WPHB_BOOKING_ROOM_PATH . "/templates/{$slug}-{$name}.php" ) ) {
				$template = WPHB_BOOKING_ROOM_PATH . "/templates/{$slug}-{$name}.php";
			}

			// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wp-hotel-booking-room/slug.php
			if ( ! $template ) {
				$template = locate_template( array( "{$slug}.php", $this->template_path() . "{$slug}.php" ) );
			}

			// Allow 3rd party plugin filter template file from their plugin
			if ( $template ) {
				$template = apply_filters( 'hb_room_addon_get_template_part', $template, $slug, $name );
			}
			if ( $template && file_exists( $template ) ) {
				load_template( $template, false );
			}

			return $template;
		}

		/**
		 * Get other templates passing attributes and including the file.
		 *
		 * @param        $template_name
		 * @param array  $args
		 * @param string $template_path
		 * @param string $default_path
		 */
		public function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
			if ( $args && is_array( $args ) ) {
				extract( $args );
			}

			$located = $this->locate_template( $template_name, $template_path, $default_path );

			if ( ! file_exists( $located ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );

				return;
			}
			// Allow 3rd party plugin filter template file from their plugin
			$located = apply_filters( 'hb_room_addon_get_template', $located, $template_name, $args, $template_path, $default_path );

			do_action( 'hb_room_before_template_part', $template_name, $template_path, $located, $args );

			include( $located );

			do_action( 'hb_room_after_template_part', $template_name, $template_path, $located, $args );
		}

		/**
		 * Locate a template and return the path for inclusion.
		 *
		 * This is the load order:
		 *
		 *        yourtheme        /    $template_path    /    $template_name
		 *        yourtheme        /    $template_name
		 *        $default_path    /    $template_name
		 *
		 * @access public
		 *
		 * @param string $template_name
		 * @param string $template_path (default: '')
		 * @param string $default_path  (default: '')
		 *
		 * @return string
		 */
		public function locate_template( $template_name, $template_path = '', $default_path = '' ) {

			if ( ! $template_path ) {
				$template_path = $this->template_path();
			}

			if ( ! $default_path ) {
				$default_path = WPHB_BOOKING_ROOM_TEMPLATES;
			}

			$template = null;
			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name,
					$template_name
				)
			);
			// Get default template
			if ( ! $template ) {
				$template = $default_path . $template_name;
			}

			// Return what we found
			return apply_filters( 'hb_room_locate_template', $template, $template_name, $template_path );
		}

		/**
		 * Check room available.
		 */
		public function hotel_booking_single_check_room_available() {
			if ( ! isset( $_POST['hb-booking-single-room-check-nonce-action'] ) || ! wp_verify_nonce( $_POST['hb-booking-single-room-check-nonce-action'], 'hb_booking_single_room_check_nonce_action' ) ) {
				return;
			}

			$errors = array();

			if ( ! isset( $_POST['room-id'] ) || ! is_numeric( $_POST['check_in_date_timestamp'] ) ) {
				$errors[] = __( 'Check in id is required.', 'wp-hotel-booking-room' );
			} else {
				$room_id = absint( $_POST['room-id'] );
			}

			if ( ! isset( $_POST['room-name'] ) ) {
				$errors[] = __( 'Check in name is required.', 'wp-hotel-booking-room' );
			} else {
				$room_name = sanitize_text_field( $_POST['room-name'] );
			}

			if ( ! isset( $_POST['check_in_date'] ) || ! isset( $_POST['check_in_date_timestamp'] ) || ! is_numeric( $_POST['check_in_date_timestamp'] ) ) {
				$errors[] = __( 'Check in date is required.', 'wp-hotel-booking-room' );
			} else {
				$checkindate_text = sanitize_text_field( $_POST['check_in_date'] );
				$checkindate      = absint( $_POST['check_in_date_timestamp'] );
			}

			if ( ! isset( $_POST['check_out_date_timestamp'] ) || ! is_numeric( $_POST['check_out_date_timestamp'] ) ) {
				$errors[] = __( 'Check out date is required.', 'wp-hotel-booking-room' );
			} else {
				$checkoutdate_text = sanitize_text_field( $_POST['check_out_date'] );
				$checkoutdate      = absint( $_POST['check_out_date_timestamp'] );
			}

			// valid request and require field
			if ( empty( $errors ) ) {
				$qty = hotel_booking_get_room_available( $room_id, array(
					'check_in_date'  => $checkindate,
					'check_out_date' => $checkoutdate
				) );

				if ( absint( $qty ) > 0 ) {

					// room has been found
					wp_send_json( array(
						'status'              => true,
						'check_in_date_text'  => $checkindate_text,
						'check_out_date_text' => $checkoutdate_text,
						'check_in_date'       => date( 'm/d/Y', $checkindate ),
						'check_out_date'      => date( 'm/d/Y', $checkoutdate ),
						'room_id'             => $room_id,
						'room_name'           => $room_name,
						'qty'                 => $qty
					) );
				} else {
					$errors[] = sprintf( __( 'No room found in %s and %s', 'wp-hotel-booking-room' ), $checkindate_text, $checkoutdate_text );
				}
			}

			// input is not pass validate, sanitize
			wp_send_json( array( 'status' => false, 'messages' => $errors ) );
		}

		/**
		 * @return null|WP_Hotel_Booking_Room_Extension
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}