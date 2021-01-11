<?php

get_header();

do_action( 'lava_content_start' ); ?>

<div class="<?php echo esc_attr( Lava()->get_layout() ); ?>">

	<?php do_action( 'lava_page_header' );

		do_action( 'lava_container_start' );

	 	if ( have_posts() ) {

			do_action( 'lava_before_main_content' );

			get_template_part( 'templates/content', 'loop' );

			do_action( 'lava_after_main_content' );

			do_action( 'lava_sidebar_content' );

			do_action( 'lava_after_sidebar_content' );
	
		} else {

			get_template_part( 'templates/content', 'none' );
		}

		do_action( 'lava_container_end' );

	?>
</div><?php

do_action( 'lava_content_end' );

get_footer();