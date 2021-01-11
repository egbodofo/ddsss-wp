<?php

do_action( 'lava_before_content_loop' );

while ( have_posts() ) : the_post();

	get_template_part( 'templates/loop/post-style', Lava()->get_post_style() );

endwhile;

do_action( 'lava_after_content_loop' );