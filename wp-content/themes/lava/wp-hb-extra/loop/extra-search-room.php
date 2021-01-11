<?php
/**
 * The template for displaying extra package in search room page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking-extra/loop/extra-search-room.php.
 *
 * @package WP-Hotel-Booking/Extra/Templates
 * @version 1.9.7.4
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

// HB_Room_Extra instead of HB_Room
$room_extra = HB_Room_Extra::instance( $post_id );
$room_extra = $room_extra->get_extra();

if ( $room_extra && ( !get_option( 'tp_hotel_booking_custom_process' ) || is_singular( 'hb_room' ) ) ) { ?>

    <div class="hb_addition_package_extra">
		<?php if ( ! get_option( 'tp_hotel_booking_custom_process' ) ) { ?>
            <div class="hb_addition_package_title">
                <h5 class="hb_addition_package_title_toggle">
                    <a href="javascript:void(0)" class="hb_package_toggle">
						<?php esc_html_e( 'Optional Extras', 'lava' ); ?>
                    </a>
                </h5>
            </div>
		<?php } ?>
        <div class="hb_addition_packages">
            <ul class="hb_addition_packages_ul">
				<?php foreach ( $room_extra as $key => $extra ): ?>
                    <li data-price="<?php echo esc_attr( $extra->amount_singular ); ?>">
                        <div class="hb_extra_optional_right">
                            <input type="<?php if ( $extra->required ) { echo 'hidden'; } else { echo 'checkbox'; } ?>"
                                   name="hb_optional_quantity_selected[<?php echo esc_attr( $extra->ID ); ?>]"
                                   class="hb_optional_quantity_selected lava-checkbox"
                                   id="<?php echo esc_attr( 'hb-ex-room-' . $post_id . '-' . $key ) ?>" <?php if ( $extra->required ) echo 'checked="checked" '; ?>
                            />
                        </div>
                        <div class="hb_extra_optional_left">
                            <div class="hb_extra_title">
                                <div class="hb_package_title">
                                    <label for="<?php echo esc_attr( 'hb-ex-room-' . $post_id . '-' . $key ) ?>"><?php printf( '%s', $extra->title ) ?></label>
                                </div>
                                <p><?php printf( '%s', $extra->description ) ?></p>
                            </div>
                            <div class="hb_extra_detail_price">
								<?php if ( $extra->respondent === 'number' ): ?>
                                    <input type="number" step="1" min="1"
                                           name="hb_optional_quantity[<?php echo esc_attr( $extra->ID ); ?>]"
                                           value="1"
                                           class="hb_optional_quantity"
                                    />
								<?php else: ?>
                                    <input type="hidden" step="1" min="1"
                                           name="hb_optional_quantity[<?php echo esc_attr( $extra->ID ); ?>]"
                                           value="1"/>
								<?php endif; ?>
                                <label>
                                    <strong><?php echo esc_html( $extra->price ); ?></strong>
                                    <small><?php printf( '/ %s', $extra->respondent_name ? $extra->respondent_name : esc_html__( 'Package', 'lava' ) ) ?></small>
                                </label>
                            </div>
                        </div>
                    </li>
				<?php endforeach ?>
            </ul>
        </div>
    </div>

<?php }