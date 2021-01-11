<div <?php post_class( 'post-offer col x12 m6 g4' ); ?>>
	<?php echo lava_get_post_thumb( 'lava_thumb_offer' ); ?>
	<div class="post-info">
		<h3 class="post-title"><?php the_title(); ?></h3>
		<?php lava_offer_price(); ?>
		<?php lava_button( esc_html__( 'Details', 'lava' ), get_permalink(), array( 'btn-secondary' ) ); ?>
	</div>
</div>