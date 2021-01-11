<div class="main">
	<?php get_template_part( 'templates/content', 'media' ); ?>
	<div class="post-content-wrapper">
		<div class="post-header">
			<?php if ( 'default' != Lava()->get_header() ): ?>
				<h1 class="post-title"><?php the_title(); ?></h1>
			<?php endif; ?>
			<div class="post-published">
				<i class="material-icons">date_range</i>
				<span class="month"><?php echo get_the_date( 'M' ); ?></span>
				<span class="day"><?php echo get_the_date( 'd' ); ?></span>
				<span class="year"><?php echo get_the_date( 'Y' ); ?></span>
			</div>
			<?php get_template_part( 'templates/single/meta' ); ?>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php lava_link_pages(); ?>
		</div>
		<?php get_template_part( 'templates/single/tags' ); ?>
	</div>
	<?php do_action( 'lava_post_share' ); ?>
	<?php get_template_part( 'templates/single/related' ); ?>
	<?php if ( !Lava_Util::get_option( 'single_hide_comments', false ) ) : ?>
	<?php comments_template(); ?>
	<?php endif; ?>
</div>