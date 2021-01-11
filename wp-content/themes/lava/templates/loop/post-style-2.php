<?php
do_action( 'lava_content_loop_start' );
do_action( 'lava_content_loop_thumb' );

?>
<div class="post-info">
	<?php echo lava_get_post_title(); ?>
	<?php echo lava_get_post_meta( Lava()->get_post_meta() ); ?>
	<?php echo lava_get_post_excerpt( Lava()->get_excerpt_length() ); ?>
	<div class="post-action">
		<?php lava_button( esc_html__( 'Read More', 'lava' ), get_permalink(), array( 'btn-secondary' ) ); ?>
	</div>
</div>
<?php

do_action( 'lava_content_loop_end' );