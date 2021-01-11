<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

$room = WPHB_Room::instance( get_the_ID() );

if ( Lava_Util::get_option( 'hb_single_hide_reviews', false ) ) {
    remove_filter( 'hotel_booking_single_room_infomation_tabs', array( 'HB_Comments', 'addTabReviews' ) );
}

$tabs = apply_filters( 'hotel_booking_single_room_infomation_tabs', array() );

do_action( 'hotel_booking_before_single_room_infomation' );
?>
<div class="single-room-details">

<?php if ( !Lava_Util::get_option( 'hb_single_hide_desc', false ) ) : ?>
	<div class="single-room-section">
		<div class="post-content"><?php the_content(); ?></div>
	</div>
<?php endif; ?>

<?php if ( !Lava_Util::get_option( 'hb_single_hide_info', false ) ) : ?>
	<div class="single-room-section">
		<h3 class="section-heading"><?php esc_html_e( 'Additional Information', 'lava' ); ?></h3>
		<div class="post-content"><?php echo wp_kses_post( $room->addition_information ); ?></div>
	</div>
<?php endif; ?>

<?php foreach ( $tabs as $key => $tab ) : ?>
	<?php if ( 'hb_room_pricing_plans' == $tab['id'] ) : ?>
	<div class="single-room-section">
		<h3 class="section-heading"><?php esc_html_e( 'Pricing Plans', 'lava' ); ?></h3>
		<?php do_action( 'hotel_booking_single_room_before_tabs_content_hb_room_pricing_plans' ); ?>
	</div>
	<?php endif; ?>
<?php endforeach ?>

<?php foreach ( $tabs as $key => $tab ) : ?>
	<?php if ( 'hb_room_reviews' == $tab['id'] ) : ?>
	<div class="single-room-section">
		<?php do_action( 'hotel_booking_single_room_before_tabs_content_hb_room_reviews' ); ?>
	</div>
	<?php endif; ?>
<?php endforeach; ?>

</div>
<?php do_action( 'hotel_booking_after_single_room_infomation' ); ?>


