<?php
/* -----------------------------------------------------------------------------
 * Template Name: HB Checkout Page
 * ----------------------------------------------------------------------------- */
get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>>

	<?php do_action( 'lava_page_header' ); ?>

	<div class="hb-booking-steps cf">
		<div class="hb-booking-step hb-booking-completed">
			<span class="step-number">1</span>
			<span class="step-text"><?php esc_html_e( 'Check Availability', 'lava' ); ?></span>
		</div>
		<div class="hb-booking-step hb-booking-completed">
			<span class="step-number">2</span>
			<span class="step-text"><?php esc_html_e( 'Review', 'lava' ); ?></span>
		</div>
		<div class="hb-booking-step hb-booking-active">
			<span class="step-number">3</span>
			<span class="step-text"><?php esc_html_e( 'Check Out', 'lava' ); ?></span>
		</div>
	</div>

	<div class="container-full"><?php

		do_action( 'lava_before_main_content' );

		get_template_part( 'templates/content', 'page' );

		do_action( 'lava_after_main_content' );

		do_action( 'lava_hb_sidebar_content' );

		do_action( 'lava_after_sidebar_content' );

	?></div>

</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();