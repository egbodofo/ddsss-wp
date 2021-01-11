<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$search = hb_get_page_permalink( 'search' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>

<div id="room-<?php the_ID(); ?>" <?php post_class( 'hb_single_room' ); ?>>
	<div class="room-details">
		<div class="post-content"><?php the_content(); ?></div>
	</div>
	<div class="room-search container-full">
		<h3 class="section-heading center-align"><?php esc_html_e( 'Check Availability', 'lava' ); ?></h3>
		<?php echo do_shortcode('[hotel_booking search_page="' . esc_url( $search ) . '" show_title="" show_label="true" default_dates="true"]'); ?>
		<div class="row">
			<div class="col x12 l6">
				<div class="content-box price">
					<?php do_action( 'hotel_booking_loop_room_price' ); ?>
				</div>
			</div>
			<div class="col x12 l6">
				<div class="content-box support">
					<div class="contact-box"><?php echo Lava_Util::get_option( 'hb_contact_info', '' ); ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php get_template_part( 'templates/hotel/gallery' ); ?>
</div>