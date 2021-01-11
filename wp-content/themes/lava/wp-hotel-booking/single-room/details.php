<?php
/**
 * The template for displaying single room details.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/single-room/details.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

$room = WPHB_Room::instance( get_the_ID() );
ob_start();
the_content();
$content = ob_get_clean();

$tabsInfo   = array();

if ( !Lava_Util::get_option( 'hb_single_hide_desc', false ) ) {
	$tabsInfo[] = array(
		'id'      => 'hb_room_description',
		'title'   => esc_html__( 'Description', 'lava' ),
		'content' => $content
	);
}

if ( !Lava_Util::get_option( 'hb_single_hide_info', false ) ) {
	$tabsInfo[] = array(
		'id'      => 'hb_room_additinal',
		'title'   => esc_html__( 'Additional Information', 'lava' ),
		'content' => $room->addition_information
	);
}

if ( Lava_Util::get_option( 'hb_single_hide_reviews', false ) ) {
    remove_filter( 'hotel_booking_single_room_infomation_tabs', array( 'HB_Comments', 'addTabReviews' ) );
}

$tabs = apply_filters( 'hotel_booking_single_room_infomation_tabs', $tabsInfo );
// prepend after li tabs single
do_action( 'hotel_booking_before_single_room_infomation' );
?>
<div class="hb_single_room_details">
    <ul class="hb_single_room_tabs expanded">
		<?php foreach ( $tabs as $key => $tab ): ?>
            <li>
                <a href="#<?php echo esc_attr( $tab['id'] ) ?>">
					<?php do_action( 'hotel_booking_single_room_before_tabs_' . $tab['id'] ); ?>
					<?php printf( '%s', $tab['title'] ) ?>
					<?php do_action( 'hotel_booking_single_room_after_tabs_' . $tab['id'] ); ?>
                </a>
            </li>
		<?php endforeach; ?>
    </ul>

    <div class="hb_single_room_tabs_content">
		<?php foreach ( $tabs as $key => $tab ): ?>
            <div id="<?php echo esc_attr( $tab['id'] ) ?>" class="hb_single_room_tab_details">
				<?php do_action( 'hotel_booking_single_room_before_tabs_content_' . $tab['id'] ); ?>
				<?php printf( '%s', $tab['content'] ); ?>
				<?php do_action( 'hotel_booking_single_room_after_tabs_content_' . $tab['id'] ); ?>
            </div>
		<?php endforeach; ?>
    </div>
</div>
<?php do_action( 'hotel_booking_after_single_room_infomation' ); ?>
