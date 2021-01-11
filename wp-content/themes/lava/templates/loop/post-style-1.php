<?php
do_action( 'lava_content_loop_start' );
do_action( 'lava_content_loop_media' );

?>
<div class="post-info">
	<?php echo lava_get_post_title(); ?>
	<div class="post-published">
		<i class="material-icons">date_range</i>
		<span class="month"><?php echo get_the_date( 'M' ); ?></span>
		<span class="day"><?php echo get_the_date( 'd' ); ?></span>
	</div>
	<?php echo lava_get_post_meta( Lava()->get_post_meta() ); ?>
	<?php echo lava_get_post_excerpt( Lava()->get_excerpt_length() ); ?>
	<div class="post-action">
		<?php lava_button( esc_html__( 'Read More', 'lava' ), get_permalink(), array( 'btn-secondary' ) ); ?>
	</div>
</div>
<?php

do_action( 'lava_content_loop_end' );