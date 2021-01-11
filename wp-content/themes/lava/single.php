<?php

get_header();

do_action( 'lava_content_start' );

if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( Lava()->get_layout() ); ?>>

	<?php do_action( 'lava_page_header' ); ?>

	<div class="container-full"><?php

		do_action( 'lava_before_main_content' );

		get_template_part( 'templates/content', 'single' );

		do_action( 'lava_after_main_content' );

		do_action( 'lava_sidebar_content' );

		do_action( 'lava_after_sidebar_content' );

	?></div>

</article>

<?php

endif;

do_action( 'lava_content_end' );

get_footer();