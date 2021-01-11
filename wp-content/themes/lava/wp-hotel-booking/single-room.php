<?php
/**
 * The template for displaying single room page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/single-room.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

get_header();

do_action( 'lava_content_start' );

do_action( 'hotel_booking_before_main_content' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>>
	<?php

	do_action( 'lava_hb_page_header' );

	if ( 'custom' == Lava()->get_layout() ) :

		get_template_part( 'templates/hotel/single-room' );

	elseif ( 'blank' == Lava()->get_layout() ) :
		
		get_template_part( 'templates/hotel/single-room-blank' );
	
	else: ?>

	<div class="container-full"><?php

		do_action( 'lava_before_main_content' );

		hb_get_template_part( 'content', 'single-room' );

		do_action( 'lava_after_main_content' );

		do_action( 'lava_hb_sidebar_content' );

		do_action( 'lava_after_sidebar_content' );

	?></div>

	<?php endif; ?>

</article>

<?php

endif;

do_action( 'hotel_booking_after_main_content' );

do_action( 'lava_content_end' );

get_footer();