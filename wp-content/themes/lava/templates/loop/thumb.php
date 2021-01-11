<?php if ( has_post_thumbnail() ): ?>
	<div class="post-thumb">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php the_post_thumbnail( Lava()->get_thumb_size() ); ?>
		</a>
	</div>
<?php endif; ?>