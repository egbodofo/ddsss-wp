<?php
/*
  Plugin Name: WP Hotel Booking Coupon
  Plugin URI: http://thimpress.com/
  Description: WP Hotel Booking Coupon
  Author: ThimPress
  Version: 1.7.3
  Author URI: http://thimpress.com
  Tags: wphb
 */

define( 'TP_HB_COUPON_DIR', plugin_dir_path( __FILE__ ) );
define( 'TP_HB_COUPON_URI', plugin_dir_url( __FILE__ ) );
define( 'TP_HB_COUPON_VER', '1.7.3' );

if ( ! class_exists( 'WP_Hotel_Booking_Coupon' ) ) {
	/**
	 * Class WP_Hotel_Booking_Coupon
	 */
	class WP_Hotel_Booking_Coupon {

		/**
		 * @var bool
		 */
		public $is_hotel_active = false;

		/**
		 * WP_Hotel_Booking_Coupon constructor.
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		}

		/**
		 * Load text domain.
		 */
		public function load_textdomain() {
			$default     = WP_LANG_DIR . '/plugins/wp-hotel-booking-coupon-' . get_locale() . '.mo';
			$plugin_file = TP_HB_COUPON_DIR . '/languages/wp-hotel-booking-coupon-' . get_locale() . '.mo';
			if ( file_exists( $default ) ) {
				$file = $default;
			} else {
				$file = $plugin_file;
			}
			if ( $file ) {
				load_textdomain( 'wp-hotel-booking-coupon', $file );
			}
		}

		/**
		 * Plugin loaded.
		 */
		public function plugins_loaded() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			if ( ( class_exists( 'TP_Hotel_Booking' ) && is_plugin_active( 'tp-hotel-booking/tp-hotel-booking.php' ) ) || ( is_plugin_active( 'wp-hotel-booking/wp-hotel-booking.php' ) && class_exists( 'WP_Hotel_Booking' ) ) ) {
				$this->is_hotel_active = true;
			}

			if ( ! $this->is_hotel_active ) {
				add_action( 'admin_notices', array( $this, 'add_notices' ) );
			} else {
				if ( $this->is_hotel_active ) {
					require_once TP_HB_COUPON_DIR . '/inc/class-hb-coupon.php';
					add_action( 'hb_admin_settings_tab_after', array( $this, 'admin_settings' ) );
					add_action( 'hotel_booking_before_cart_total', array( $this, 'hotel_booking_before_cart_total' ) );
					add_action( 'init', array( $this, 'register_post_types_coupon' ) );
				}
			}

			$this->load_textdomain();
		}

		/**
		 * Notice messages
		 */
		public function add_notices() { ?>
            <div class="error">
                <p><?php _e( 'The <strong>WP Hotel Booking</strong> is not installed and/or activated. Please install and/or activate before you can using <strong>WP Hotel Booking Coupon</strong> add-on.' ); ?></p>
            </div>
			<?php
		}

		/**
		 * @param $settings
		 */
		public function admin_settings( $settings ) {
			if ( $settings !== 'general' ) {
				return;
			}
			$settings = hb_settings(); ?>
            <table class="form-table">
                <tr>
                    <th><?php _e( 'Enable Coupon', 'wp-hotel-booking-coupon' ); ?></th>
                    <td>
                        <input type="hidden"
                               name="<?php echo esc_attr( $settings->get_field_name( 'enable_coupon' ) ); ?>"
                               value="0"/>
                        <input type="checkbox"
                               name="<?php echo esc_attr( $settings->get_field_name( 'enable_coupon' ) ); ?>" <?php checked( $settings->get( 'enable_coupon' ) ? 1 : 0, 1 ); ?>
                               value="1"/>
                    </td>
                </tr>
            </table>
			<?php
		}

		/**
		 * Before cart total
		 */
		public function hotel_booking_before_cart_total() {
			$settings = hb_settings();
			if ( defined( 'TP_HOTEL_COUPON' ) && TP_HOTEL_COUPON && $settings->get( 'enable_coupon' ) ) {
				// if( $coupon = get_transient( 'hb_user_coupon_' . session_id() ) ) {
				if ( $coupon = WP_Hotel_Booking::instance()->cart->coupon ) {
					$coupon = HB_Coupon::instance( $coupon );
					?>
                    <tr class="hb_coupon">
                        <td class="hb_coupon_remove" colspan="8">
                            <p class="hb-remove-coupon" align="right">
                                <a href="" id="hb-remove-coupon"><i class="fa fa-times"></i></a>
                            </p>
                            <span class="hb-remove-coupon_code"><?php printf( __( 'Coupon applied: %s', 'wp-hotel-booking-coupon' ), $coupon->coupon_code ); ?></span>
                            <span class="hb-align-right">
                            -<?php echo hb_format_price( $coupon->discount_value ); ?>
                        </span>
                        </td>
                    </tr>
				<?php } else { ?>
                    <tr class="hb_coupon">
                        <td colspan="8" class="hb-align-center">
                            <input type="text" name="hb-coupon-code" value=""
                                   placeholder="<?php _e( 'Coupon', 'wp-hotel-booking-coupon' ); ?>"
                                   style="width: 150px; vertical-align: top;"/>
                            <button type="button"
                                    id="hb-apply-coupon"><?php _e( 'Apply Coupon', 'wp-hotel-booking-coupon' ); ?></button>
                        </td>
                    </tr>
				<?php }
			}
		}

		/**
		 * Register post type.
		 */
		public function register_post_types_coupon() {
			$args = array(
				'labels'             => array(
					'name'               => _x( 'Coupons', 'Coupons', 'wp-hotel-booking-coupon' ),
					'singular_name'      => _x( 'Coupon', 'Coupon', 'wp-hotel-booking-coupon' ),
					'menu_name'          => __( 'Coupons', 'wp-hotel-booking-coupon' ),
					'parent_item_colon'  => __( 'Parent Item:', 'wp-hotel-booking-coupon' ),
					'all_items'          => __( 'Coupons', 'wp-hotel-booking-coupon' ),
					'view_item'          => __( 'View Coupon', 'wp-hotel-booking-coupon' ),
					'add_new_item'       => __( 'Add New Coupon', 'wp-hotel-booking-coupon' ),
					'add_new'            => __( 'Add New', 'wp-hotel-booking-coupon' ),
					'edit_item'          => __( 'Edit Coupon', 'wp-hotel-booking-coupon' ),
					'update_item'        => __( 'Update Coupon', 'wp-hotel-booking-coupon' ),
					'search_items'       => __( 'Search Coupon', 'wp-hotel-booking-coupon' ),
					'not_found'          => __( 'No coupon found', 'wp-hotel-booking-coupon' ),
					'not_found_in_trash' => __( 'No coupon found in Trash', 'wp-hotel-booking-coupon' ),
				),
				'public'             => false,
				'query_var'          => true,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'has_archive'        => false,
				'capability_type'    => 'hb_room',
				'map_meta_cap'       => true,
				'show_in_menu'       => 'tp_hotel_booking',
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'supports'           => array( 'title' ),
				// 'can_export'         => false,
				'hierarchical'       => false
			);
			$args = apply_filters( 'hotel_booking_register_post_type_coupon_arg', $args );
			register_post_type( 'hb_coupon', $args );
		}
	}
}

$Coupon = new WP_Hotel_Booking_Coupon();
