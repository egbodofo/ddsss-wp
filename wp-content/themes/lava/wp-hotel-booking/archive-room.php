<?php
/**
 * The template for displaying archive room.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/archive-room.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

do_action( 'lava_content_start' ); ?>

<div class="<?php echo esc_attr( Lava()->get_layout() ); ?>"><?php

		do_action( 'lava_page_header', 'hb_archive' );

		do_action( 'hotel_booking_archive_description' );

		do_action( 'lava_container_start' );

		if ( have_posts() ) :

			do_action( 'hotel_booking_before_room_loop' );

			hotel_booking_room_loop_start();

			hotel_booking_room_subcategories();

			while ( have_posts() ) : the_post();

				hb_get_template_part( 'content', 'room' );

			endwhile; // end of the loop.

			hotel_booking_room_loop_end();

			do_action( 'hotel_booking_after_room_loop' );

		endif; 

		do_action( 'lava_container_end' );

?></div>

<?php do_action( 'lava_content_end' ); ?>

<?php get_footer(); ?>