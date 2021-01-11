<?php if ( '2' == Lava()->get_layout() ): ?>
<div class="card">
	<div class="container-full">
		<div class="post-content"><?php the_content(); ?></div>
	</div>
</div>
<?php else: ?>
<div class="card">
	<div class="row no-padding">
		<div class="col x12 g6">
			<div class="lava-image-holder equal-height">
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php echo esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), 'lava_thumb_medium' ) ); ?>"><?php the_post_thumbnail( 'lava_thumb_medium' ); ?></a>
			<?php endif; ?>
			</div>
		</div>
		<div class="col x12 g6">
			<div class="container-half equal-height">
				<div class="post-content"><?php the_content(); ?></div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>