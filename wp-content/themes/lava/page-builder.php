<?php

/* -----------------------------------------------------------------------------
 * Template Name: Page Builder
 * ----------------------------------------------------------------------------- */
get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>><?php

	do_action( 'lava_page_header' );

	do_action( 'lava_container_start' );
		
	the_content();

	do_action( 'lava_container_end' );

?>
</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();