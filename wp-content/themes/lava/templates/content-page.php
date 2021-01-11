<div class="main">
	<?php if ( 'hide' == Lava()->get_header() || 'placeholder' == Lava()->get_header() ): ?>
		<div class="post-header">
			<h1 class="post-title"><?php the_title(); ?></h1>
		</div>
	<?php endif; ?>
	<div class="post-content">
		<?php the_content(); ?>
		<?php lava_link_pages(); ?>
	</div>
	<?php if ( !is_front_page() && !Lava_Util::get_option( 'page_hide_comments', false ) ) : ?>
	<?php comments_template(); ?>
	<?php endif; ?>
</div>