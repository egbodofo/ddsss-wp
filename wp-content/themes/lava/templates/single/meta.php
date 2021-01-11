<?php

$output = '';
$post_meta = Lava_Util::get_option( 'single_post_meta', array( 'author', 'cats', 'comment' ) );

if ( !empty( $post_meta ) ) : ?>

	<ul class="post-meta">
	
	<?php if ( in_array( 'author', $post_meta ) ) : ?>
		<li class="meta-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"><i class="material-icons">person</i><?php the_author(); ?></a></li>
	<?php endif; ?>

	<?php if ( in_array( 'cats', $post_meta ) ) : ?>
		<li class="meta-cats"><i class="material-icons">local_offer</i><?php echo get_the_category_list() ?></li>
	<?php endif; ?>

	<?php if ( in_array( 'comment', $post_meta ) ): ?>
		<li class="meta-comments"><a href="<?php echo esc_url( get_permalink() ); ?>#comments"><i class="material-icons">mode_comment</i><?php echo get_comments_number(); ?></a></li>
	<?php endif; ?>

	</ul>

<?php endif; ?>