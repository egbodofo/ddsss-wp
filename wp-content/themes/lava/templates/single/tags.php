<?php $tags = get_the_tags(); ?>
<?php if ( $tags ) : ?>
	<div class="post-tags">
	<?php foreach ( $tags as $tag ) : ?>
		<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" rel="tag"><?php echo esc_html( $tag->name ); ?></a>
	<?php endforeach; ?>
	</div>
<?php endif; ?>