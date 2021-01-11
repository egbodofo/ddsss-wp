<?php

get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php Lava()->get_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>>

	<?php do_action( 'lava_page_header' );

		do_action( 'lava_container_start' );

		do_action( 'lava_before_main_content' );

		get_template_part( 'templates/content', 'page' );

		do_action( 'lava_after_main_content' );

		do_action( 'lava_sidebar_content' );

		do_action( 'lava_after_sidebar_content' );

		do_action( 'lava_container_end' ); ?>

</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();