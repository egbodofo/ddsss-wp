<?php if ( is_search() ): ?>
	
	<div class="post-content">
		<ol class="search-tips">
			<li><?php esc_html_e( 'Make sure all words are spelled correctly', 'lava' ); ?></li>
			<li><?php esc_html_e( 'Try other keywords', 'lava'); ?></li>
			<li><?php esc_html_e( 'Try more general keywords', 'lava'); ?></li>
		</ol>
	</div>

<?php else: ?>

	<article class="no-posts">
		<h4 class="post-title"><?php esc_html_e( 'No posts to display.', 'lava' ); ?></h4>
		<?php if ( current_user_can( 'publish_posts' ) ): ?>
			<a class="add-post" href="<?php echo network_admin_url( 'post-new.php' ); ?>"><i class="fa fa-angle-right"></i><?php esc_html_e( 'Go and add some new posts.', 'lava' ) ;?></a>
		<?php endif; ?>
	</article>

<?php endif; ?>