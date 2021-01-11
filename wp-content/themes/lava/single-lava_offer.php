<?php

get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-offer-post' ); ?>>

	<?php do_action( 'lava_page_header' );

		do_action( 'lava_container_start' );

		get_template_part( 'templates/content', 'single-offer' );

		do_action( 'lava_container_end' );
	?>

</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();